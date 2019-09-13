<?php

namespace login\model;

class Database {
    private $connection;

    public function connect (\login\DatabaseConfig $dbSettings) {
        // $this->connection = mysqli_connect(\login\DatabaseConfig::$DB_HOST, \login\DatabaseConfig::$DB_USERNAME, 
        // \login\DatabaseConfig::$DB_PASSWORD, \login\DatabaseConfig::$DB_NAME);

        $this->connection = mysqli_connect($dbSettings->DB_HOST, $dbSettings->DB_USERNAME, 
        $dbSettings->DB_PASSWORD, $dbSettings->DB_NAME);

        if (!$this->connection) {
            echo "Connection failed " . mysqli_connect_error();
        }

        return $this->connection;
    }
}

?>