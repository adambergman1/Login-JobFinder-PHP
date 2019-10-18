<?php

namespace login\view;

class RegisterView implements View {
	private static $messageId = 'RegisterView::Message';
	private static $name = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $doRegistration = 'RegisterView::Register';
	private static $rememberedName;
	
	private $message;

	public function response($isLoggedIn) : string {
		$ret = '';
		if (!$isLoggedIn) {
			$ret = "<h2>Register new user</h2>";
			$ret .= $this->generateRegistrationForm();
		}
		return $ret;
	}

  private function generateRegistrationForm() : string {
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

	public function getUsername () : string {
		return $_POST[self::$name];
	}

	public function getPassword () : string {
		return $_POST[self::$password];
	}

	public function getPasswordRepeat () : string {
		return $_POST[self::$passwordRepeat];
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

	public function getNewUserCredentials () : \login\model\NewUser {
			return new \login\model\NewUser($this->getUsername(), $this->getPassword(), $this->getPasswordRepeat());
	}

	public function setMessage ($message) : void {
		$this->message = $message;
	}

	public function userhasClickedRegister () : bool {

		if ($this->inputFieldHasValue(self::$name)) {
			self::$rememberedName = strip_tags($_POST[self::$name]);
		}
		return isset($_POST[self::$doRegistration]);
	}

	public function userWantsToRegister () : bool {
		if (isset($_GET["register"])) {
		  return true;
		} else {
		  return false;
		}
	  }
}