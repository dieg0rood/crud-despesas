<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Expense;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\User;
use App\Notifications\ExpenseNotify;
use Illuminate\Support\Facades\Notification;
use App\Services\ExpenseService;
use Illuminate\Http\JsonResponse;

class ExpenseController extends Controller
{
    public function __construct(
        protected ExpenseService $service, 
        protected User $user, 
        protected Expense $expense){}
    /**
     * Display a listing of the resource.
     */
    public function index(Authenticatable $user): JsonResponse
    {
        $expenses = $this->service->index($user, $this->user);
        return response()->json($expenses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request): JsonResponse
    {
        $expense = $this->service->store($request->validated(), $this->expense);
        Notification::send($expense->user, new ExpenseNotify($expense));
        return response()->json($expense->makeHidden('user'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense): JsonResponse
    {
        $this->authorize('view', $expense);
        return response()->json($expense, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseRequest $request, Expense $expense): JsonResponse
    {
        $this->authorize('update', $expense);
        $expense = $this->service->update($request->validated(), $expense);
        return response()->json($expense, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense): JsonResponse
    {
        $this->authorize('delete', $expense);
        $this->service->delete($expense);
        return response()->json('Successfully removed expense.', 204);
    }
}
