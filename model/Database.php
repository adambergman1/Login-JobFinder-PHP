<?php

namespace login\model;

class Database extends \login\DatabaseConfig {
    private $connection;

    public function connect () {
        $this->connection = mysqli_connect($this->DB_HOST, $this->DB_USERNAME, 
        $this->DB_PASSWORD, $this->DB_NAME);

        if (!$this->connection) {
            echo "Connection failed " . mysqli_connect_error();
        }

        return $this->connection;
    }
}

