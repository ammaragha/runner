<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RunnersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 50; $i++) {
            $user = User::create([
                "name" => fake()->name(),
                "email" => fake()->unique()->safeEmail(),
                "phone" => fake()->unique()->phoneNumber(),
                "email_verified_at" => now(),
                "phone_verified_at" => now(),
                "password" => Hash::make("123"),
                "gender" => "other",
                "birthday" => fake()->date(),
                "rate" => fake()->numberBetween(0, 5),
                "role" => "runner"
            ]);

            $user->runner()->create([
                "service_id" => fake()->numberBetween(1, 4),
                "cost_per_hour" => fake()->numberBetween(1, 20),
                "is_active" => fake()->numberBetween(0, 1),
            ]);
        }
    }
}
