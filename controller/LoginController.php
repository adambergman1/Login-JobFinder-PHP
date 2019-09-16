<?php

namespace login\controller;

include_once('view/LoginView.php');

class LoginController {
    private $loginView;

    public function __construct(\login\view\LoginView $view) {
        $this->loginView = $view;
        $this->login();
    }

    private function login () {
        if ($this->loginView->shouldLogin()) {
            $userCredentials = $this->loginView->getUserCredentials();
    
        }
    }
}

?>