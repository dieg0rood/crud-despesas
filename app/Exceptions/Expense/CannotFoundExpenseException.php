<?php

namespace App\Exceptions\Expense;

use Exception;
use Illuminate\Contracts\Auth\Authenticatable;

class CannotFoundExpenseException extends Exception
{
  public function __construct(Authenticatable $user)
  {
    parent::__construct("Nenhuma despesa encontrada para o usuário nº " . $user->getAuthIdentifier(),404);
    
  }
}