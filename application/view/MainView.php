<?php

namespace application\view;

class MainView {

    private static $keyword = 'Keyword';
    private static $city = 'City';
    private static $submit = 'Submit';
    private static $messageId = 'Message';
    private $message;
    private $jobs = "";

    public function renderHTML () : string {
        $this->validateKeyword();
        return $this->showOutput();
    }

    private function showOutput () : string {
        $output = '<div class="job-finder">';
        $output .= $this->renderHeader();
        $output .= $this->renderSearchForm($this->message);
        $output .= $this->jobs;
        $output .= '</div>';
        return $output;
    }

    public function renderHeader () : string {
        return '<h3 class="job-finder-title">Find jobs in Sweden - The easy way</h3>';
    }

    public function renderSearchForm ($message) : string {
        return '
        <form method="get" class="job-finder-form"> 
            <div class="input-form">
                <label for="' . self::$keyword . '">Keyword:</label>
                <input type="text" id="' . self::$keyword . '" name="' . self::$keyword . '" placeholder="E.g. Web developer" />
            </div>

            <div class="input-form">
                <label for="' . self::$city . '">City (leave empty for all cities):</label>
                <input type="city" id="' . self::$city . '" name="' . self::$city . '" placeholder="E.g. Stockholm" />
            </div>
            <div class="button-form"> 
                <input type="submit" name="' . self::$submit . '" value="Search" />
            </div>
        </form>
        <p class="error-message" id="' . self::$messageId . '">' . $message . '</p>
    ';
    }

    public function renderJobs (\application\model\JobsCollection $jobs) : void {
        // TODO: Fix law of demeter by not calling methods from the argument
        $jobsArray = $jobs->getJobs();
        $ret = $this->renderJobsCount($jobs->getAmountOfJobs());

        $ret .= '<div class="jobs">';
        foreach ($jobsArray as $job) {
            $ret .= '<div class="job">';
            $ret .= '<div class="headline"><p>' . $job->title . '</p></div>';
            $ret .= '<div class="content">';
            $ret .= '<div class="description"><p>' . $job->description . '</p></div>';
            $ret .= $this->getJobSpecifications($job);
            $ret .= '</div></div>';
        }
        $ret .= '</div>';

        $this->jobs = $ret;
    }

    public function renderJobsCount (int $jobsCount) : string {
        $count = $jobsCount > 0 ? $jobsCount : 0;
        return '<p class="jobs-count">Found ' . $count . ' job listings' . '</p>';
    }

    private function getJobSpecifications (\application\model\Job $job) : string {
        $ret = "<div class='specifications'>";
        $ret .= "<div class='company-logo'><img src=' " . $job->logoUrl . " '/></div>";
        $ret .= "<p>Number of vacancies: " . $job->numOfVacancies . "</p>";
        $ret .= "<p>Published: " . $this->formatDate($job->publicationDate) . "</p>";
        $ret .= "<p>Deadline: " . $this->formatDate($job->deadline) . "</p>";
        $ret .= "<p>City: " . $job->city . "</p>";
        $ret .= "<p>Employment: " . $job->employmentType . "</p>";

        if ($job->websiteUrl) {
            $ret .= "<p>Employer: <a target='_blank' href=' " . $job->websiteUrl . " '> " . $job->employerName . " </a></p>";
        } else {
            $ret .= "<p>Employer: " . $job->employerName . "</p>";
        }

        if ($job->applyJobUrl) {
            $ret .= "<div class='apply-job'><a class='apply-job' target='_blank' href=' ". $job->applyJobUrl ." '>Apply this job</a></div>";
        } else if ($job->applyJobEmail) {
            $ret .= "<div class='apply-job'><a target='_blank' href='mailto:". $job->applyJobEmail ."?subject=" . $job->title . "'>Apply this job</a></div>";
        }

        $ret .= "</div>";

        return $ret;

    }

    private function hasKeyword () : bool {
        return isset($_GET[self::$keyword]) && !empty($_GET[self::$keyword]);
    }

    private function hasEmptyKeyword () : bool {
        return isset($_GET[self::$keyword]) && empty($_GET[self::$keyword]);
    }

    private function validateKeyword () : void {
        if ($this->hasEmptyKeyword()) {
            $this->setMessage(\application\view\Messages::MISSING_KEYWORD);
        }
    }

    private function formatDate (string $date) : string {
        $s = strtotime($date);
        return date('d/m/Y', $s);
    }

    public function userWantsToSearch () : bool {
        if ($this->hasKeyword())  {
            return true;
        } else {
            return false;
        }
    }

    public function setMessage ($message) : void {
        $this->message = $message;
    }

    public function getKeyword () : string {
        return $_GET[self::$keyword];
    }

    public function getCity () : string {
        return $_GET[self::$city];
    }
}