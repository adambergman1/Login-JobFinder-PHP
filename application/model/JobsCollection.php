<?php

namespace application\model;

// TODO: Consider using traversable interface 
// with visitor pattern 
class JobsCollection {
    private $jobs = array();

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