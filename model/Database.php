<?php

namespace login\model;

class Database {
    private $connection;
    private $settings;

    public function __construct () {
        $serverName = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        if ($serverName == 'localhost') {
            $this->settings = new \login\LocalSettings();
        } else {
            $this->settings = new \login\ProductionSettings();
        }
    }
    
    public function connect () {
        $this->connection = mysqli_connect($this->settings->DB_HOST, $this->settings->DB_USERNAME, 
        $this->settings->DB_PASSWORD, $this->settings->DB_NAME);

        if (!$this->connection) {
            echo "Connection failed " . mysqli_connect_error();
        }

        return $this->connection;
    }

    public function isUserValid (string $username, string $password) {
        $row = $this->findUserInDb($username);

        if ($row['username'] === $username && password_verify($password, $row['password'])) {
            return true;
        } else {
            return false;
        }
    }

    public function doesUserExist(string $name) {
        $row = $this->findUserInDb($name);

        if ($row['username'] === $name) {
            return true;
        } else {
            return false;
        }
    }

    private function findUserInDb (string $name) {
        $query = "SELECT * FROM users WHERE username = ?";

        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('s', $name);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row;
    }

    public function registerUser (string $username, string $password) {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        mysqli_query($this->connection, $query);
    }

    public function getHashedPassword (string $name) {
        $row = $this->findUserInDb($name);
        return $row['password'];
    }
}

