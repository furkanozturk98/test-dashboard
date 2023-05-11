<?php

namespace Database\Factories;

use App\Models\TestRun;
use App\Models\TestRunDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestRunDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TestRunDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'test_run_id' => fn() => TestRun::factory()->create()->id,
            'status'      => rand(0, 2),
            'file'        => $this->faker->words(5, true) . '.php',
            'method'      => $this->faker->words(5, true),
            'time'        => rand(1, 1000),
        ];
    }
}
