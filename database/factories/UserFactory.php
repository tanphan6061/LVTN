<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $sex = ['female', 'male'];
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            // 'email_verified_at' => now(),
            'password' => bcrypt('Demopass69'), // password
            'birthday' => '1999-01-01', // password
            'sex' => $sex[rand(0, count($sex) - 1)], // password
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
