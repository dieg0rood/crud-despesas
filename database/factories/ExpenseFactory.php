<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Expense;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    protected $model = Expense::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween('-1 years', 'now');
        $formattedDate = Carbon::parse($date)->format('Y-m-d');

        return [
            'description' => $this->faker->text(191),
            'expense_date' => $formattedDate,
            'user_id' => User::factory()->create()->id,
            'amount' => $this->faker->randomFloat(2, 10, 100000),
        ];
    }
}
