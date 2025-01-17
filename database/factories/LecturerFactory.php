<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

class LecturerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lecturer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        static $number = 1;
        return [
                'research_group_id' => ($number++%12)+1, 
                'name' => $this->faker->name(),
                'email' => $this->faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => bcrypt('test'), // password
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'remember_token' => Str::random(10),
                'profile_photo_path' => null,
                'current_team_id' => null,
            ];
    }

    public function configure(){
        return $this->afterCreating(function (Lecturer $lecturer) {
            $lecturer->assignRole('supervisor', 'evaluator');
        });

    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the user should have a personal team.
     */
    public function withPersonalTeam(callable $callback = null): static
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(fn (array $attributes, Lecturer $user) => [
                    'name' => $user->name.'\'s Team',
                    'user_id' => $user->id,
                    'personal_team' => true,
                ])
                ->when(is_callable($callback), $callback),
            'ownedTeams'
        );
    }
}
