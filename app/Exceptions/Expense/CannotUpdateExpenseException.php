<?php

namespace App\Exceptions\Expense;

use App\Models\Expense;
use Exception;

class CannotUpdateExpenseException extends Exception
{
  public function __construct(Expense $expense)
  {
    parent::__construct("A Despesa nº ". $expense->get('id'). " não pode ser atualizada",500);
    
  }
}