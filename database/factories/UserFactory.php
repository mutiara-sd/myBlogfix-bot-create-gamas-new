<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->unique()->username(),
            'telegram_username' => fake()->unique()->username(),
            'password' => static::$password ??= Hash::make('password'),
            'role_id' => Role::inRandomOrder()->first()->id,
            'profile_picture' => $this->faker->randomElement([
                'https://randomuser.me/api/portraits/men/'.rand(1, 99).'.jpg',
                'https://randomuser.me/api/portraits/women/'.rand(1, 99).'.jpg',
            ]),
            'remember_token' => Str::random(10),
        ];
    }
}
