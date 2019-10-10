<?php

namespace application\view;

class MainView {

    private static $keyword = 'Keyword';
    private static $city = 'City';
    private static $submit = 'Submit';
    private static $messageId = 'Message';
    private $message;

    private $jobs = "";
    
    const MIN_KEYWORD_LENGTH = 3;

    public function renderHTML () {
        $this->validateKeyword();
        $output = $this->renderHeader();
        $output .= $this->renderSearchForm($this->message);
        $output .= $this->jobs;

        return $output;
    }

    public function renderHeader () {
        return '<h3>Find jobs in Sweden - The easy way</h3>';
    }

    public function renderSearchForm ($message) {
        return '
        <form method="get" class="job-finder"> 
        <fieldset>
            <label for="' . self::$keyword . '">Keyword:</label>
            <input type="text" id="' . self::$keyword . '" name="' . self::$keyword . '" placeholder="E.g. Web developer" />

            <label for="' . self::$city . '">City (leave empty for all cities):</label>
            <input type="city" id="' . self::$city . '" name="' . self::$city . '" placeholder="E.g. Stockholm" />
            <input type="submit" name="' . self::$submit . '" value="Search" />
        </fieldset>
        </form>
        <p id="' . self::$messageId . '">' . $message . '</p>
    ';
    }

    public function renderJobs ($jobs = null) {
            $ret = '<div class="jobs">';
            foreach ($jobs as $item) {
                foreach ($item as $key) {
                    $ret .= '<div class="job">';
                    $ret .= "<p class='headline'>" . $key['headline'] . "</p>";
                    $ret .= "<div class='description'><p>" . nl2br($key['description']['text']) . "</p></div>";
                    $ret .= "</div>";
                }
            }
            $ret .= '</div>';
            $this->jobs = $ret;
    }

    private function hasKeyword () {
        return isset($_GET[self::$keyword]) && !empty($_GET[self::$keyword]);
    }

    private function hasCity () {
        return isset($_GET[self::$city]) && !empty($_GET[self::$city]);
    }

    private function hasEmptyKeyword () {
        return isset($_GET[self::$keyword]) && empty($_GET[self::$keyword]);
    }

    private function validateKeyword () {
        if ($this->hasKeyword() && strlen($_GET[self::$keyword]) < self::MIN_KEYWORD_LENGTH) {
            $this->setMessage("Keyword is too short. Minimum 3 characters.");
        } else if ($this->hasEmptyKeyword()) {
            $this->setMessage("Keyword is missing");
        }
    }

    public function userWantsToSearch () {
        if ($this->hasKeyword() && strlen($_GET[self::$keyword]) > self::MIN_KEYWORD_LENGTH)  {
            return true;
        } else {
            return false;
        }
    }

    public function setMessage ($message) {
        $this->message = $message;
    }

    public function getKeyword () {
        return $_GET[self::$keyword];
    }

    public function getCity () {
        return $_GET[self::$city];
    }
}