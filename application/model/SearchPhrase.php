<?php

namespace application\model;

class SearchPhrase {
    private static $MIN_KEYWORD_LENGTH = 3;
    private static $MIN_CITY_LENGTH = 3;
    
    private $keyword;
    private $city;
    private $phrase;

    public function __construct (string $keyword, string $city) {
        $this->validateKeyword($keyword);
        $this->validateCity($city);

        $this->keyword = $keyword;
        $this->city = $city;
        $this->phrase = "{$keyword} {$city}";

        $this->replaceCharacters();
    }

    public function replaceCharacters () : void {
        $this->phrase = urlencode($this->phrase);
    }

    public function getPhrase () : string {
        return strtolower($this->phrase);
    }
    
    private function validateKeyword (string $keyword) : void {
        if (empty($keyword) || strlen($keyword) < self::$MIN_KEYWORD_LENGTH) {
            throw new InvalidKeywordLength;
        }
    }

    private function validateCity (string $city) : void {
        if (empty($city) || strlen($city) < self::$MIN_CITY_LENGTH) {
            throw new InvalidCityLength;
        }
    }
}