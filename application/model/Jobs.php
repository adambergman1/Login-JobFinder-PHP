<?php

namespace application\model;

class Jobs {
    private $jobs = array();

    public function __construct (\application\model\Job $job) {
        $this->jobs[] = $job;
    }
}