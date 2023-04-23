<?php

namespace App\Services;

use App\Exceptions\Expense\CannotCreateExpenseException;
use App\Exceptions\Expense\CannotDeleteExpenseException;
use App\Exceptions\Expense\CannotFoundExpenseException;
use App\Exceptions\Expense\CannotUpdateExpenseException;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Expense;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\User;

class ExpenseService
{
  public function index(Authenticatable $user, User $model)
  {
    $userFound = $model::find($user->getAuthIdentifier());
    $expenses = $userFound->expenses;

    if ($expenses->isEmpty())
      throw new CannotFoundExpenseException($user);

    return $expenses;
  }
  public function store(Array $request, Expense $expense)
  {
    $data = $expense::create($request);

    if (!$data)
      throw new CannotCreateExpenseException();

    return $data;
  }

  public function update(Array $request, Expense $expense)
  {
    $data = $expense->update($request);

    if (!$data)
      throw new CannotUpdateExpenseException($expense);

    return $expense;
  }

  public function delete(Expense $expense)
  {
    $delete = $expense->delete();

    if (!$delete)
      throw new CannotDeleteExpenseException($expense);
  }
}
