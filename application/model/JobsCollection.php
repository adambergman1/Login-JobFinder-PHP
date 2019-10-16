<?php

namespace application\model;

class JobsCollection {
    private $jobs = array();

    public function __construct () {
        // Traversable
        // Visitor pattern?
    }

    public function add (\application\model\Job $job) : void {
        $this->jobs[] = $job;
    }

    public function getJobs () : array {
        return $this->jobs;
    }

    public function getAmountOfJobs () : int {
        return count($this->jobs);
    }
}