<?php

namespace login;

class DatabaseConfig {
    protected $DB_HOST;
    protected $DB_NAME;
    protected $DB_USERNAME;
    protected $DB_PASSWORD;

    public function __construct () {
        $serverName = gethostbyaddr($_SERVER['REMOTE_ADDR']);

        if ($serverName == 'localhost') {
            // Set local DB values
            $this->DB_HOST = "localhost";
            $this->DB_NAME = "1dv610";
            $this->DB_USERNAME = "root";
            $this->DB_PASSWORD = "root";
        } else {
            // Set Jaws DB values
            $url = getenv('JAWSDB_URL');
            $dbparts = parse_url($url);
    
            $this->DB_HOST = $dbparts['host'];
            $this->DB_USERNAME = $dbparts['user'];
            $this->DB_PASSWORD = $dbparts['pass'];
            $this->DB_NAME = ltrim($dbparts['path'],'/');
        }
    }
}

?>