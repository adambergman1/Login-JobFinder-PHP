<?php

namespace application\controller;

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
        $keyword = $this->mv->getKeyword();
        $city = $this->mv->getCity();
        $result = $this->model->fetchJobs($keyword, $city);
        $this->mv->renderJobs($result);
    }
}