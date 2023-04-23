<?php

namespace App\Exceptions\Expense;

use App\Models\Expense;
use Exception;

class CannotCreateExpenseException extends Exception
{
  public function __construct()
  {
    parent::__construct("Não foi possível criar a despesa, tente novamente mais tarde!",500);
    
  }
}