<?php

namespace App\Exceptions\Expense;

use App\Models\Expense;
use Exception;

class CannotDeleteExpenseException extends Exception
{
  public function __construct(Expense $expense)
  {
    parent::__construct("A Despesa nº ".$expense->id." não pode ser excluída",500);
    
  }
}