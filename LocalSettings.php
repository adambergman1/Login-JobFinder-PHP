<?php

namespace login;

// class Settings {
//     private $DB_HOST;
//     private $DB_NAME;
//     private $DB_USERNAME;
//     private $DB_PASSWORD;

//     public function __construct () {
//         $serverName = gethostbyaddr($_SERVER['REMOTE_ADDR']);

//         if ($serverName == 'localhost') {
//             // Set local DB values
//             $this->DB_HOST = "localhost";
//             $this->DB_NAME = "1dv610";
//             $this->DB_USERNAME = "root";
//             $this->DB_PASSWORD = "root";
//         } else {
//             // Set Jaws DB values
//             $url = getenv('JAWSDB_URL');
//             $dbparts = parse_url($url);
    
//             $this->DB_HOST = $dbparts['host'];
//             $this->DB_USERNAME = $dbparts['user'];
//             $this->DB_PASSWORD = $dbparts['pass'];
//             $this->DB_NAME = ltrim($dbparts['path'],'/');
//         }
//     }
// }

class LocalSettings {
    public $DB_HOST = "localhost";
    public $DB_NAME = "1dv610";
    public $DB_USERNAME = "root";
    public $DB_PASSWORD = "root";
}