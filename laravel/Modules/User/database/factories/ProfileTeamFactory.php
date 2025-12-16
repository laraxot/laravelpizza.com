<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Models\Profile;
use Modules\User\Models\ProfileTeam;
use Modules\User\Models\Team;

/**
 * ProfileTeam Factory.
 *
 * @extends Factory<ProfileTeam>
 */
class ProfileTeamFactory extends Factory
{
    protected $model = ProfileTeam::class;

    public function definition(): array
    {
        return [
            'profile_id' => Profile::factory(),
            'team_id' => Team::factory(),
            'role' => $this->faker->randomElement(['owner', 'admin', 'member']),
        ];
    }

    public function forProfile(Profile $profile): static
    {
        return $this->state(['profile_id' => $profile->id]);
    }

    public function forTeam(Team $team): static
    {
        return $this->state(['team_id' => $team->id]);
    }

    public function owner(): static
    {
        return $this->state(['role' => 'owner']);
    }

    public function admin(): static
    {
        return $this->state(['role' => 'admin']);
    }

    public function member(): static
    {
        return $this->state(['role' => 'member']);
    }
}
