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
	private static $rememberedName = '';

	private $message;
	private $storage;

	public function __construct (\login\model\UserStorage $storage) {
		$this->storage = $storage;
	}

	/**
	 * Create HTTP response
	 * Should be called after a login attempt has been determined
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

	public function setMessage ($message) {
		$this->message = $message;
	}

	public function userWantsToLogin () : bool {
		$this->checkForEmptyFields();
		
		if ($this->hasUsername())  {
			self::$rememberedName = $_POST[self::$name];
		}
		
		if ($this->userHasClickedLogin() && $this->hasUsername() && $this->hasPassword()) {
			return true;
		} else {
			return false;
		}
	}

	private function checkForEmptyFields () {
		if ($this->userHasClickedLogin()) {
			if (!$this->hasPassword()) {
				$this->setMessage("Password is missing");
			}
			if (!$this->hasUsername()) {
				$this->setMessage("Username is missing");
			}
		}
	}

	private function hasUsername () : bool {
		return isset($_POST[self::$name]) && !empty($_POST[self::$name]);
	}

	private function hasPassword () : bool {
		return isset($_POST[self::$password]) && !empty($_POST[self::$password]);
	}

	private function userHasClickedLogin () : bool {
		return isset($_POST[self::$login]) && !$this->storage->hasStoredUser();
	}

	public function getUsername () : \login\model\Username {
		return new \login\model\Username($_POST[self::$name]);
	}

	private function getPassword () : \login\model\Password {
		return new \login\model\Password($_POST[self::$password]);
	}

	public function getKeepLoggedIn () : bool {
		return isset($_POST[self::$keep]);
	}

	public function getUserCredentials () : \login\model\UserCredentials {
		if ($this->hasUsername() && $this->hasPassword()) {
			$name = $this->getUsername();
			$pass = $this->getPassword();
			$keepLoggedIn = $this->getKeepLoggedIn();

			return new \login\model\UserCredentials($name, $pass, $keepLoggedIn);
		}
	}

	public function userHasClickedLogout () : bool {
		return isset($_POST[self::$logout]) && $this->storage->hasStoredUser();
	}

	public function setValueToUsernameField(string $name) {
		self::$rememberedName = $name;
	}

	public function setCookie () {
		$name = $this->getUsername()->getUsername();
		$pass = bin2hex(random_bytes(20));
		
		setcookie(self::$cookieName, $name, time() + 1800);
		setcookie(self::$cookiePassword, $pass, time() + 1800);

		$_COOKIE[self::$cookieName] = $name;
		$_COOKIE[self::$cookiePassword] = $pass;
	}
	
	public function removeCookie () {
		setcookie(self::$cookieName, "", time() - 1800);
		setcookie(self::$cookiePassword, "", time() - 1800);

		unset($_COOKIE[self::$cookieName]);
		unset($_COOKIE[self::$cookiePassword]);
	}
	
	public function hasCookie () : bool {
		return isset($_COOKIE[self::$cookieName]) && isset($_COOKIE[self::$cookiePassword]);
	}

	public function setSuccessfulMessage () {
		if ($this->getKeepLoggedIn()) {
			$this->setCookie();
			$this->setMessage(\login\view\Messages::WELCOME_YOU_WILL_BE_REMEMBERED);
		} else {
			$this->setMessage(\login\view\Messages::WELCOME);
		}
	}

	public function setWelcomeBackMessage () {
		// $this->setCookieWithTemporaryPwd();
		$this->setMessage(\login\view\Messages::WELCOME_BACK_WITH_COOKIE);
	}

	public function getCredentialsByCookie () {
		$username = new \login\model\Username($_COOKIE[self::$cookieName]);
		$password = new \login\model\Password($_COOKIE[self::$cookiePassword]);
		$stayLoggedIn = true;
		return new \login\model\UserCredentials($username, $password, $stayLoggedIn);
	}
}