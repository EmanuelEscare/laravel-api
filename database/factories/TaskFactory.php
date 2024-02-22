<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Task::class;

    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $company = Company::inRandomOrder()->first();

        return [
            'user_id' => $user->id,
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'company_id' => $company->id,
        ];
    }

    /**
     * Indica que no se deben crear más de 5 registros por usuario.
     */
    public function configure()
    {
        return $this->afterCreating(function (Task $task) {
            $user = $task->user;
            $tasksCount = $user->tasks()->count();

            // Limitar la creación de instancias a 5 por usuario
            if ($tasksCount >= 3) {
                $task->delete();
            }
        });
    }
}
