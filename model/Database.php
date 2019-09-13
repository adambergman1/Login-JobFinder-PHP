<?php

namespace login\model;

class Database {
    private $connection;

    public function connect () {
        $this->connection = mysqli_connect(\login\DatabaseConfig::$DB_HOST, \login\DatabaseConfig::$DB_USERNAME, 
        \login\DatabaseConfig::$DB_PASSWORD, \login\DatabaseConfig::$DB_NAME);

        if (!$this->connection) {
            echo "Connection failed" . mysqli_connect_error();
        }

        return $this->connection;
    }
}

?>