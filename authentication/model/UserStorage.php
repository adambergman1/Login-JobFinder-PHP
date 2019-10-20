<?php

namespace login\model;

class UserStorage {
	private static $SESSION_KEY =  __CLASS__ .  "::UserName";
	private static $NEW_USER_TO_REMEMBER = __CLASS__ . "::NewUser";

  	public function hasStoredUser () : bool {
		if (isset($_SESSION[self::$SESSION_KEY])) {
			return true;
		} else {
			return false;
		}
  	}
  
	public function saveUser(string $name) : void {
		$_SESSION[self::$SESSION_KEY] = md5($name);
	}
	
	public function destroySession () : void {
		unset($_SESSION[self::$SESSION_KEY]);
		unset($_SESSION[self::$NEW_USER_TO_REMEMBER]);
	}

	public function saveNameFromRegistration (string $name) : void {
		$_SESSION[self::$NEW_USER_TO_REMEMBER] = $name;
	}

	public function getNameFromRegistration () : string {
		return $_SESSION[self::$NEW_USER_TO_REMEMBER];
	}

	public function hasNewRegistreredUser () : bool {
		return isset($_SESSION[self::$NEW_USER_TO_REMEMBER]);
	}
}