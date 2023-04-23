<?php

namespace Tests\Unit\API;

use App\Http\Controllers\ExpenseController;
use App\Models\Expense;
use App\Models\User;
use Mockery;
use Tests\TestCase;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Support\Facades\Auth;

class ExpenseControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    /*public function testDestroy()
    {
        $expenseId = 1;
        $userId = 1;

        $userMock = Mockery::mock('App\Models\User');
        $userMock->shouldReceive('find')->with($userId)->andReturn(new User(['user_id' => $userId]));

        $expenseMock = Mockery::mock('App\Models\Expense');
        $expenseMock->shouldReceive('find')->with($expenseId)->andReturn(new Expense(['id' => $expenseId, 'user_id' => $userId]));

       // $gate = Mockery::mock('Illuminate\Contracts\Auth\Access\Gate');
       // $gate->shouldReceive('authorize')->with('delete', $expenseMock)->once()->andReturnTrue();

        $controller = new ExpenseController();
        $response = $controller->destroy($expenseMock->find($expenseId));

       // $this->assertTrue($gate->authorize('delete'));
        $expenseMock->expects($this->once())->method('destroy')->with($expenseId);
        
        $this->assertEquals(response()->json([], 204)->getContent(), $response->getContent());
    }*/

    public function testExpenseCanBeDeleted()
    {
        // Cria um objeto de mock para o modelo User
        $user = Mockery::mock(User::class);
        $user->shouldReceive('setAttribute')
             ->withArgs(['id', 1])
             ->once();

        $user->id = 1;

        // Define a expectativa de que o método `getAuthIdentifier` será chamado no objeto de mock de autenticação
        Auth::shouldReceive('user')->andReturn($user);

        // Define a expectativa de que o método `setAttribute` será chamado no objeto de mock User
        
        // Cria um objeto de mock para o modelo Expense
        $expense = Mockery::mock(Expense::class);

        // Define a expectativa de que o método `delete` será chamado no objeto de mock Expense e retornará true
        $expense->shouldReceive('delete')->andReturn(true);

        // Cria uma instância do controlador ExpenseController
        $controller = new ExpenseController();

        // Chama o método destroy no controlador, passando o objeto de mock Expense como parâmetro
        $response = $controller->destroy($expense);

        // Verifica que a resposta foi um código 204 (no content)
        $this->assertEquals(204, $response->getStatusCode());

        // Limpa os objetos de mock
        Mockery::close();
    }
    

}
