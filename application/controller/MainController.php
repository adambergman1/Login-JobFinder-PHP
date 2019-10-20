<?php

namespace application\controller;

use application\model\APIConnectionError;
use application\model\InvalidCityLength;
use application\model\InvalidKeywordLength;
use application\model\KeywordAndCityTooShort;

class MainController {
    private $mv;
    private $model;

    public function __construct (\application\view\JobFinderView $mv) {
        $this->mv = $mv;
        $this->model = new \application\model\API();
    }

    public function start () : void {
        if ($this->mv->userWantsToSearch()) {
            $this->search();
        }
    }

    public function search () : void {
        try {
            $keyword = $this->mv->getKeyword();
            $city = $this->mv->getCity();

            $this->searchModel = new \application\model\SearchPhrase($keyword, $city);
            $phrase = $this->searchModel->getPhrase();

            $result = $this->model->fetchJobs($phrase);
            $this->mv->renderJobs($result);
        } catch (APIConnectionError $e) {
            $this->mv->setMessage(\application\view\Messages::API_CONNECTION_ERROR);
        } catch (KeywordAndCityTooShort $e) {
            $this->mv->setMessage(\application\view\Messages::KEYWORD_AND_CITY_IS_INVALID);
        } catch (InvalidCityLength $e) {
            $this->mv->setMessage(\application\view\Messages::INVALID_CITY_LENGTH);
        } catch (InvalidKeywordLength $e) {
            $this->mv->setMessage(\application\view\Messages::INVALID_KEYWORD_LENGTH);
        }
    }
}