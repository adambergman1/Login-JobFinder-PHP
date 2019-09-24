<?php

namespace login\view;

class RegisterView {
	private static $messageId = 'RegisterView::Message"';
	private static $name = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $doRegistration = 'RegisterView::DoRegistration';
	
	private $message;

	public function response($isLoggedIn) {
		$ret = '';
		if (!$isLoggedIn) {
			$ret = "<h2>Register new user</h2>";
			$ret .= $this->generateRegistrationForm();
		}
		return $ret;
	}

  private function generateRegistrationForm() {
		return '
      <form action="?register" method="post" enctype="multipart/form-data">
        <fieldset>
          <legend>Register a new user - Write username and password</legend>
          <p id=' . self::$messageId . '">' . $this->message . '</p>
          
          <label for="' . self::$name . '">Username :</label>
          <input type="text" size="20" name="' . self::$name . '" id="' . self::$name . '" value="" />
          <br>
          <label for="' . self::$password . '">Password :</label>
          <input type="password" size="20" name="' . self::$password . '" id="' . self::$password . '" value="" />
					<br>
          <label for="' . self::$passwordRepeat . '" >Repeat password  :</label>
          <input type="password" size="20" name="' . self::$passwordRepeat . '" id="' . self::$passwordRepeat . '" value="" />
					<br>
          <input type="submit" name="' . self::$doRegistration . '"  value="Register" />
      </fieldset>
    </form>
		';
	}

	// public function getUsername () {
	// 	if ($this->hasUsername()) {
	// 		return self::$name;
	// 	}
	// }

	// public function getPassword () {
	// 	if ($this->hasPassword()) {
	// 		return self::$password;
	// 	}
	// }

	// public function getPasswordRepeat () {
	// 	if ($this->hasPasswordRepeat()) {
	// 		return self::$passwordRepeat;
	// 	}
	// }

	// public function hasUsername () : bool {
	// 	if (isset($_POST[self::$name]) && !empty($_POST[self::$name])) {
	// 		return true;
	// 	} else {
	// 		return false;
	// 	}
	// }

	// public function hasPassword () : bool {
	// 	if (isset($_POST[self::$password]) && !empty($_POST[self::$password])) {
	// 		return true;
	// 	} else {
	// 		return false;
	// 	}
	// }

	// public function hasPasswordRepeat () : bool {
	// 	if (isset($_POST[self::$passwordRepeat]) && !empty($_POST[self::$passwordRepeat])) {
	// 		return true;
	// 	} else {
	// 		return false;
	// 	}
	// }
}