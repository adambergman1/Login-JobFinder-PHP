<?php

namespace login\model;

class InvalidCharactersException extends \Exception { }

class InvalidCredentialsException extends \Exception { }

class TooShortNameException extends \Exception { }

class TooShortPasswordException extends \Exception { }

class WrongNameOrPassword extends \Exception { }

class PasswordsDoNotMatch extends \Exception { }

class NameAndPasswordMissing extends \Exception { }
