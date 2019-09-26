<?php

namespace login\view;

class RegisterView {
	private static $messageId = 'RegisterView::Message';
	private static $name = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $doRegistration = 'RegisterView::DoRegistration';

	private static $rememberedName;
	
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
          <p id=' . self::$messageId . '>' . $this->message . '</p>
          
          <label for="' . self::$name . '">Username :</label>
          <input type="text" size="20" name="' . self::$name . '" id="' . self::$name . '" value="' . self::$rememberedName .'" />
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

	public function getUsername () : \login\model\Username {
		return new \login\model\Username($_POST[self::$name]);
	}

	public function getPassword () : \login\model\Password {
		return new \login\model\Password($_POST[self::$password]);
	}

	public function getPasswordRepeat () : \login\model\Password {
		return new \login\model\Password($_POST[self::$passwordRepeat]);
	}

	public function inputFieldHasValue ($field) : bool {
		if (isset($_POST[$field]) && !empty($_POST[$field])) {
			return true;
		} else {
			return false;
		}
	}

	public function passwordsAreSame () : bool {
		return $this->getPassword() == $this->getPasswordRepeat();
	}

	public function getNewUserCredentials () : \login\model\UserCredentials {
		if ($this->inputFieldHasValue(self::$name) && $this->inputFieldHasValue(self::$password) 
		&& $this->passwordsAreSame()) {
			return new \login\model\UserCredentials($this->getUsername(), $this->getPassword(), false);
		}
	}

	public function setMessage ($message) {
		$this->message = $message;
	}

	public function userhasClickedRegister () : bool {

		if ($this->inputFieldHasValue(self::$name)) {
			self::$rememberedName = $_POST[self::$name];
		}
		return isset($_POST[self::$doRegistration]);
	}
}