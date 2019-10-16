<?php

namespace application\model;

class Job {
    public $title;
    public $description;
    public $publicationDate;
    public $deadline;
    public $city;
    public $numOfVacancies;
    public $logoUrl;
    public $employmentType;
    public $websiteUrl;
    public $employerName;
    public $applyJobUrl;
    public $applyJobEmail;

    public function __construct (string $title, string $description, $logo, $amountOfVacancies, 
    $publicationDate, $deadline, $city, $employmentType, $websiteUrl, $employerName,
    $applyJobUrl, $applyJobEmail) {
        $this->title = $title;
        $this->description = $description;
        $this->logoUrl = $logo;
        $this->numOfVacancies = $amountOfVacancies;
        $this->publicationDate = $publicationDate;
        $this->deadline = $deadline;
        $this->city = $city;
        $this->employmentType = $employmentType;
        $this->websiteUrl = $websiteUrl;
        $this->employerName = $employerName;
        $this->applyJobUrl = $applyJobUrl;
        $this->applyJobEmail = $applyJobEmail;
    }
}