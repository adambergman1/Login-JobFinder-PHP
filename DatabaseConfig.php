<?php

namespace login;

class DatabaseConfig {
    public static $DB_HOST;
    public static $DB_NAME;
    public static $DB_USERNAME;
    public static $DB_PASSWORD;

    public function configure () {
        $serverName = gethostbyaddr($_SERVER['REMOTE_ADDR']);

        if ($serverName == 'localhost') {
            $this->DB_HOST = "localhost";
            $this->DB_NAME = "1dv610";
            $this->DB_USERNAME = "root";
            $this->DB_PASSWORD = "root";
            echo "You are on localhost";
        } else {
            $url = getenv('JAWSDB_URL');
            $dbparts = parse_url($url);
    
            $this->DB_HOST = $dbparts['host'];
            $this->DB_USERNAME = $dbparts['user'];
            $this->DB_PASSWORD = $dbparts['pass'];
            $this->DB_NAME = ltrim($dbparts['path'],'/');
            echo "You are live"; 
        }
    }
}

?>