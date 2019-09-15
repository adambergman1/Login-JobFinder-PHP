<?php

namespace login\controller;

include_once('view/LoginView.php');

class LoginController {
    private $loginView;

    public function __construct(\login\view\LoginView $view) {
        $this->loginView = $view;

        if ($this->loginView->hasRequiredInput()) {
            $this->login();

        }
        var_dump($this->loginView->hasRequiredInput());
    }

    private function login () {
        $loginCredentials = new \login\model\LoginModel($this->loginView->getUsername(), $this->loginView->getPassword(), $this->loginView->getKeepLoggedIn());
    }
}

?>