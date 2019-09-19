<?php

namespace login\view;

include_once('model/Exceptions.php');

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private static $rememberedName = "";

	private $message;

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response($isLoggedIn) {
		if (!$isLoggedIn) {
			$response = $this->generateLoginFormHTML($this->message);
		} else {
			$response = $this->generateLogoutButtonHTML($this->message);
		}
		return $response;
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . self::$rememberedName . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}
	
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES

	public function userWantsToLogin () : bool {
		if ($this->userHasClickedLogin() && $this->hasUsername()) {
			self::$rememberedName = $_POST[self::$name];
			return false;
		} else if ($this->userHasClickedLogin() && $this->hasUsername() && $this->hasPassword()) {
			return true;
		} else {
			$this->message = $this->getMessage();
			return false;
		}
	}

	public function getUsername () : \login\model\Username {
		return new \login\model\Username($_POST[self::$name]);
	}

	private function getPassword () : \login\model\Password {
			return new \login\model\Password($_POST[self::$password]);
	}

	private function getKeepLoggedIn () : bool {
		return isset($_POST[self::$keep]);
	}

	private function hasUsername () : bool {
		return isset($_POST[self::$name]) && !empty($_POST[self::$name]);
	}

	private function hasPassword () : bool {
		return isset($_POST[self::$password]) && !empty($_POST[self::$password]);
	}

	private function userHasClickedLogin () : bool {
		return isset($_POST[self::$login]);
	}

	public function getUserCredentials () : \login\model\UserCredentials {
		if ($this->hasUsername() && $this->hasPassword()) {
			$name = $this->getUsername();
			$pass = $this->getPassword();
			$keepLoggedIn = $this->getKeepLoggedIn();
			return new \login\model\UserCredentials($name, $pass, $keepLoggedIn);
		}
	}

	private function getMessage () {
		if ($this->userHasClickedLogin()) {
			if (!$this->hasUsername()) {
				return "Username is missing";
			}
	
			if (!$this->hasPassword()) {
				return "Password is missing";
			}
		}
	}

	public function setMessage ($message) {
		$this->message = $message;
	}

	// CREATE COOKIES

	// public function setCookie () {
	// 	$user = array(
	// 		'name' => self::$name,
	// 		'password' => self::$password,
	// 		'stayLoggedIn' => self::$keep
	// 	);

	// 	setcookie("userCredentials", $user, time() * 1800);

	// }

	// public function removeCookie () {
	// 	setcookie("userCredentials", "", time() - 1800);
	// }


}