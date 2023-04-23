<?php

namespace Tests\Unit\Services;

use App\Services\ExpenseService;
use Tests\TestCase;

class ExpenseServiceTest extends TestCase
{


    public function test_all_expenses_can_be_found()
    {
        $expenseMock = $this->mock('App\Models\Expense');
        $expenseMock->shouldReceive('isEmpty')->andReturn(false);

        $userMock = $this->mock('Illuminate\Contracts\Auth\Authenticatable');
        $userMock->shouldReceive('getAuthIdentifier')->once()->andReturn(1);

        $userModelMock = $this->mock('App\Models\User');
        $userModelMock->shouldReceive('find')->andReturn($userModelMock);
        $userModelMock->shouldReceive('getAttribute')->with('expenses')->andReturn($expenseMock);

        $expenseService = new ExpenseService();
        $expenses = $expenseService->index($userMock, $userModelMock);

        $this->assertEquals($expenseMock, $expenses);
    }

    public function test_no_expenses_can_be_found()
    {
        $expenseMock = $this->mock('App\Models\Expense');
        $expenseMock->shouldReceive('isEmpty')->andReturn(true);

        $userMock = $this->mock('Illuminate\Contracts\Auth\Authenticatable');
        $userMock->shouldReceive('getAuthIdentifier')->twice()->andReturn(1);

        $userModelMock = $this->mock('App\Models\User');
        $userModelMock->shouldReceive('find')->andReturn($userModelMock);
        $userModelMock->shouldReceive('getAttribute')->with('expenses')->andReturn($expenseMock);

        $expenseService = new ExpenseService();
        $this->expectException('App\Exceptions\Expense\CannotFoundExpenseException');
        $expenses = $expenseService->index($userMock, $userModelMock);

        $this->assertNotNull($expenses);
    }

    public function test_expense_can_be_save()
    {
        $requestValidatedMock = [];

        $expenseModelMock = $this->mock('App\Models\Expense');
        $expenseModelMock->shouldReceive('create')->andReturn($expenseModelMock);

        $expenseService = new ExpenseService();
        $expenses = $expenseService->store($requestValidatedMock, $expenseModelMock);

        $expenseModelMock->shouldHaveReceived('create')->once();
        $this->assertEquals($expenses, $expenseModelMock);
    }

    public function test_expense_cannot_be_save()
    {
        $requestMock = [];

        $expenseModelMock = $this->mock('App\Models\Expense');
        $expenseModelMock->shouldReceive('create')->andReturn(false);
        

        $expenseService = new ExpenseService();
        $this->expectException('App\Exceptions\Expense\CannotCreateExpenseException');
        $expenses = $expenseService->store($requestMock, $expenseModelMock);

        $expenseModelMock->shouldHaveReceived('create')->once();
        $this->assertNotNull($expenses);
    }

    public function test_expense_can_be_update()
    {
        $requestMock = [];

        $expenseModelMock = $this->mock('App\Models\Expense');
        $expenseModelMock->shouldReceive('update')->andReturn($expenseModelMock);

        $expenseService = new ExpenseService();
        $expenses = $expenseService->update($requestMock,$expenseModelMock);

        $expenseModelMock->shouldHaveReceived('update')->once();
        $this->assertEquals($expenses, $expenseModelMock);
    }

    public function test_expense_cannot_be_update()
    {
        $requestMock = [];

        $expenseModelMock = $this->mock('App\Models\Expense');
        $expenseModelMock->shouldReceive('update')->andReturn(false);
        $expenseModelMock->shouldReceive('get')->with('id')->andReturn(1);

        $expenseService = new ExpenseService();
        $this->expectException('App\Exceptions\Expense\CannotUpdateExpenseException');
        $expenses = $expenseService->update($requestMock, $expenseModelMock);

        $requestMock->shouldHaveReceived('update')->once();
        $this->assertNotNull($expenses);
    }

    public function test_expense_can_be_deleted()
    {
        $expenseMock = $this->mock('App\Models\Expense');
        $expenseMock->shouldReceive('delete')->andReturn(true);

        $expenseService = new ExpenseService();
        $result = $expenseService->delete($expenseMock);

        $expenseMock->shouldHaveReceived('delete')->once();

        $this->assertNull($result);
    }

    public function test_expense_cannot_be_deleted()
    {
        $expenseMock = $this->mock('App\Models\Expense');
        $expenseMock->shouldReceive('delete')->andReturn(false);
        $expenseMock->shouldReceive('getAttribute')->with('id')->andReturn(1);

        $expenseService = new ExpenseService();
        $this->expectException('App\Exceptions\Expense\CannotDeleteExpenseException');
        $result = $expenseService->delete($expenseMock);

        $expenseMock->shouldHaveReceived('delete')->once();

        $this->assertNotNull($result);
    }
}
