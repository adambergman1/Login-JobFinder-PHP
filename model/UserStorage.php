<?php

namespace login\model;

class UserStorage {
  private static $SESSION_KEY =  __CLASS__ .  "::UserName";
  
	public function loadUser() {
		if ($this->hasStoredUser()) {
			return $_SESSION[self::$SESSION_KEY];
		} else {
			throw new \Exception("No user exits");
		}
  }

  public function hasStoredUser () : bool {
    if (isset($_SESSION[self::$SESSION_KEY])) {
			return true;
		} else {
      return false;
    }
  }
  
	public function saveUser(Username $toBeSaved) {
		$_SESSION[self::$SESSION_KEY] = $toBeSaved->getUsername();
  }
  
}