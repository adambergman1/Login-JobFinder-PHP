<?php

namespace application\model;

class API {

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
            $filterResult
            ));

        $data = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($data, true);
        return $json;
    }

    public function convertJobs (Array $jobs) {
        
    }
}