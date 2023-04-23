<?php

namespace App\Exceptions;

use Exception;

class CannotCreateUserException extends Exception
{
  public function __construct()
  {
    parent::__construct("Não foi possível cadastrar o usuário, tente novamente mais tarde!",500);
    
  }
}