<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Expense;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\User;
use App\Notifications\ExpenseNotify;
use Illuminate\Support\Facades\Notification;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Authenticatable $user)
    {
        $user = User::find($user->id);
        $expenses = $user->expenses;
        
        if ($expenses->isEmpty())
            abort(404, 'No expenses found.');
            
        return response()->json($expenses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request)
    {
        $expense = Expense::create($request->validated());

        if (!$expense)
            abort(500, 'Error to create a new expense.');

        Notification::send($expense->user, new ExpenseNotify($expense));

        return response()->json($expense, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        $this->authorize('view', $expense);  
        return response()->json($expense,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        if (!$expense->update($request->validated()))
            abort(500, 'Unable to update expense.');

        return response()->json($expense,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $this->authorize('delete', $expense);

        if (!$expense->delete())
            abort(500, 'Unable to remove expense.');

        return response()->json('Successfully removed expense.',204);
    }
}
