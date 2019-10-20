<?php

namespace application\view;

class LayoutView {
  
  public function render(bool $isLoggedIn, \login\view\View $v, DateTimeView $dtv, $loggedInView = null) : void {
    echo '
    <!DOCTYPE html>
      <html>
        <head>
          <link rel="stylesheet" type="text/css" href="public/css/style.css">
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <div class="header container">
            <div class="site-title">
              <h1>Assignment 2</h1>
            </div>
            <div class="logged-in-details">
              ' . $this->renderRegisterLink($isLoggedIn) . '
              ' . $this->renderIsLoggedIn($isLoggedIn) . '
            </div>
          </div>
          <div class="main container">
            ' . $v->response($isLoggedIn) . '
            ' . $this->renderLoggedInApplication($loggedInView) . '
          </div>
          <div class="container footer">
          ' . $dtv->show() . '
          </div>
         </body>
      </html>
    ';
  }

  private function renderLoggedInApplication ($loggedInView) : string {
    if ($loggedInView != null) {
      return $loggedInView->renderHTML();
    } else {
      return "";
    }
  }

  
  private function renderIsLoggedIn($isLoggedIn) : string {
    if ($isLoggedIn) {
      return '<h2 class="logged-in">Logged in</h2>';
    }
    else {
      return '<h2 class="not-logged-in">Not logged in</h2>';
    }
  }

  private function renderRegisterLink ($isLoggedIn) : string {
    $ret = '';

    if (!$isLoggedIn && !$this->userWantsToRegister()) {
      $ret = '<a href="?register" class="register-btn">Register a new user</a>';
    }
    if (!$isLoggedIn && $this->userWantsToRegister()) {
      $ret = '<a href="?" class="go-back-btn">Back to login</a>';
    }
    return $ret;
  }

  private function userWantsToRegister () : bool {
    if (isset($_GET["register"])) {
      return true;
    } else {
      return false;
    }
  }
}
