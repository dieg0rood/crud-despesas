<?php

namespace App\Exceptions\User;

use Exception;

class CannotCreateUserException extends Exception
{
  public function __construct()
  {
    parent::__construct("Não foi possível cadastrar o usuário, tente novamente mais tarde!",500);
    
  }
}
