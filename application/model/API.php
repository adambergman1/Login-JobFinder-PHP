<?php

namespace application\model;

require_once('Exceptions.php');

class API {
    private $api;

    public function __construct () {
        $serverName = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $this->api = $this->getAPIKey($serverName);
    }

    private function getAPIKey ($serverName) {
        if ($serverName == 'localhost') {
            require_once('application/LocalAPIKey.php');
            $api = new \application\LocalAPIKey();
            return $api->API_KEY;
        } else {
            return getenv("AF_KEY");
        }
    }

    public function fetchJobs (string $phrase) : \application\model\JobsCollection {
        $url = 'https://jobsearch.api.jobtechdev.se/search?q=' . $phrase . '&offset=0&limit=10';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        $filterResult = 'X-Fields: hits{headline, logo_url, webpage_url, description{text}, number_of_vacancies, application_deadline,
            application_details{url, email}, workplace_address{municipality}, employment_type{label}, employer{name, url}, publication_date }';

        curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json; charset=utf-8',
            'api-key: ' . $this->api,
            $filterResult
            ));

        $data = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($data, true);
        // $json = json_encode($data, JSON_PRETTY_PRINT);

        if (array_key_exists('message', $json)) {
            throw new APIConnectionError;
        } else {
            return $this->createJobsFromJSON($json);
        }
    }

    private function createJobsFromJSON ($jsonArray) : \application\model\JobsCollection {
        $jobsCollection = new \application\model\JobsCollection();

        foreach ($jsonArray as $job) {
            foreach ($job as $item) {
                $title = $item['headline'];
                $description = nl2br($item['description']['text']);
                $logoUrl = $item['logo_url'];
                $amountOfVacancies = $item['number_of_vacancies'];
                $publicationDate = $item['publication_date'];
                $deadline = $item['application_deadline'];
                $city = $item['workplace_address']['municipality'];
                $employmentType = $item['employment_type']['label'];
                $websiteUrl = $this->validateUrl($item['employer']['url']);
                $employerName = $item['employer']['name'];
                $applyJobUrl = $this->validateUrl($item['application_details']['url']);
                $applyJobEmail = $item['application_details']['email'];

                $jobsCollection->add(new \application\model\Job($title, $description, $logoUrl, $amountOfVacancies, 
                $publicationDate, $deadline, $city, $employmentType, $websiteUrl, $employerName, $applyJobUrl, $applyJobEmail));
            }
        }
        return $jobsCollection;
    }

    private function validateUrl ($url) {
        if ($url) {
            if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                $url = "http://" . $url;
            }
            return $url;
        }
    }
}