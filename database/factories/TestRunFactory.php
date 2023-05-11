<?php

namespace Database\Factories;

use App\Models\TestRun;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestRunFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TestRun::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'      => $this->faker->text,
            'file'       => 'junit.xml',
            'tests'      => rand(1, 15) * 15,
            'assertions' => rand(3, 25) * 15,
            'time'       => rand(1, 1352) * rand(1, 10) * 10,
            'created_by' => 1,
        ];
    }
}
