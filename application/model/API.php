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

    public function fetchJobs (string $keyword, string $city) {
        $phrase = $keyword;
        $phrase .= '%20';
        $phrase .= $city;

        $url = 'https://jobsearch.api.jobtechdev.se/search?q=' . $phrase . '&offset=0&limit=2';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        $filterResult = 'X-Fields: hits{headline, description, number_of_vacancies, application_deadline, 
            logo_url, application_details{url}, workplace_address{municipality}, employment_type{label}, employer{name, url}}';

        curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'api-key: ' . $this->api,
            $filterResult
            ));

        $data = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($data, true);

        if (array_key_exists('message', $json)) {
            throw new APIConnectionError;
        } else {
            return $json;
        }

    }

    // public function convertJobs (Array $jobs) {
        
    // }
}