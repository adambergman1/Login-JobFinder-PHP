<?php

namespace application\controller;

use application\model\APIConnectionError;

class MainController {
    private $mv;
    private $model;

    public function __construct (\application\view\MainView $mv) {
        $this->mv = $mv;
        $this->model = new \application\model\API();
    }

    public function start () {
        if ($this->mv->userWantsToSearch()) {
            $this->search();
        }
    }

    public function search () {
        try {
            $keyword = $this->mv->getKeyword();
            $city = $this->mv->getCity();

            $this->searchModel = new \application\model\SearchPhrase($keyword, $city);
            $phrase = $this->searchModel->getPhrase();
            $result = $this->model->fetchJobs($phrase);
            $this->mv->renderJobs($result);
        } catch (APIConnectionError $e) {
            $this->mv->setMessage(\application\view\Messages::API_CONNECTION_ERROR);
        }
    }
}