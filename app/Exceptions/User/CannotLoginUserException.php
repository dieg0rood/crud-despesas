<?php

namespace App\Exceptions\User;

use Exception;

class CannotLoginUserException extends Exception
{
  public function __construct()
  {
    parent::__construct("Credenciais inválidas!",401);
    
  }
}