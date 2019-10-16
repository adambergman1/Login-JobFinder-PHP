<?php

namespace application\view;

class LayoutView {
  
  public function render($isLoggedIn, $v, DateTimeView $dtv, $loggedInView = null) {
    echo '
    <!DOCTYPE html>
      <html>
        <head>
          <link rel="stylesheet" type="text/css" href="public/css/style.css">
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <div class="container">
          <div class="site-title">
            <h1><a href="./">Assignment 2</a></h1>
            </div>
          <div class="logged-in-details">
            ' . $this->renderRegisterLink($isLoggedIn) . '
            ' . $this->renderIsLoggedIn($isLoggedIn) . '
          </div>
          </div>
          <div class="container">
              ' . $v->response($isLoggedIn) . '
              ' . $this->renderLoggedInApplication($loggedInView) . '
          </div>
          <div class="container">
          ' . $dtv->show() . '
          </div>
         </body>
      </html>
    ';
  }

  public function renderLoggedInApplication ($loggedInView) {
    if ($loggedInView != null) {
      return $loggedInView->renderHTML();
    }
  }

  
  private function renderIsLoggedIn($isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2 class="logged-in">Logged in</h2>';
    }
    else {
      return '<h2 class="not-logged-in">Not logged in</h2>';
    }
  }

  private function renderRegisterLink ($isLoggedIn) {
    $ret = '';

    if (!$isLoggedIn && !$this->userWantsToRegister()) {
      $ret = '<a href="?register" class="register-btn">Register a new user</a>';
    }
    if (!$isLoggedIn && $this->userWantsToRegister()) {
      $ret = '<a href="?" "go-back-btn">Back to login</a>';
    }
    return $ret;
  }

  public function userWantsToRegister () {
    if (isset($_GET["register"])) {
      return true;
    } else {
      return false;
    }
  }
}
