<?php

namespace application\model;

class SearchPhrase {
    private static $MIN_KEYWORD_LENGTH = 3;
    private static $MIN_CITY_LENGTH = 3;
    
    private $keyword;
    private $city;
    private $phrase;

    public function __construct (string $keyword, string $city) {
        $this->validateSearchPhrase($keyword, $city);

        $this->keyword = $keyword;
        $this->city = $city;
        $this->phrase = "{$keyword} {$city}";

        $this->replaceCharacters();
    }

    private function replaceCharacters () : void {
        $this->phrase = urlencode($this->phrase);
    }

    private function isKeywordValid (string $keyword) : bool {
        if (!empty($keyword) && strlen($keyword) >= self::$MIN_KEYWORD_LENGTH) {
            return true;
        } else {
            return false;
        }
    }

    private function isCityValid (string $city) : bool {
        if (empty($city) || strlen($city) >= self::$MIN_CITY_LENGTH) {
            return true;
        } else {
            return false;
        }
    }

    private function validateSearchPhrase (string $keyword, string $city) : void {
        if (!$this->isKeywordValid($keyword) && !$this->isCityValid($city)) {
            throw new KeywordAndCityTooShort;
        } else if (!$this->isKeywordValid($keyword)) {
            throw new InvalidKeywordLength;
        } else if (!$this->isCityValid($city)) {
            throw new InvalidCityLength;
        }
    }

    public function getPhrase () : string {
        return strtolower($this->phrase);
    }
}