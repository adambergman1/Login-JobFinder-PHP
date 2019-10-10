<?php

namespace application\model;

class Job {
    private $title;
    private $description;
    private $city;
    private $deadline;
    private $numOfVacancies;
    private $logoURL;
    
    public function __construct (string $title, string $description, string $city, string $deadline, string $numOfVacancies, string $logoURL) {
        $this->title = $title;
        $this->description = $description;
        $this->city = $city;
        $this->deadline = $deadline;
        $this->numOfVacancies = $numOfVacancies;
        $this->logoURL = $logoURL;
    }
}