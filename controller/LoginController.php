<?php

namespace login\controller;

include_once('view/LoginView.php');

class LoginController {
    private $view;

    public function __construct(\login\view\LoginView $view) {
        $this->view = $view;
    }
}

?>