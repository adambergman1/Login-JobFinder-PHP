<?php

namespace login\model;

class UserStorage {
	private static $SESSION_KEY =  __CLASS__ .  "::UserName";
	private static $NEW_USER_TO_REMEMBER = __CLASS__ . "::NewUser";
  
	public function loadUser() {
		if ($this->hasStoredUser()) {
			return $_SESSION[self::$SESSION_KEY];
		} else {
			throw new Exception("No user exits");
		}
  }

  public function hasStoredUser () : bool {
    if (isset($_SESSION[self::$SESSION_KEY])) {
			return true;
		} else {
      return false;
    }
  }
  
	public function saveUser(string $toBeSaved) {
		$_SESSION[self::$SESSION_KEY] = $toBeSaved;
	}
	
	public function destroySession () {
		$_SESSION = array();
		session_destroy();
	}

	public function saveNameFromRegistration (string $name) {
		$_SESSION[self::$NEW_USER_TO_REMEMBER] = $name;
	}

	public function getNameFromRegistration () : string {
		return $_SESSION[self::$NEW_USER_TO_REMEMBER];
	}

	public function hasNewRegistreredUser () {
		return isset($_SESSION[self::$NEW_USER_TO_REMEMBER]);
	}
}