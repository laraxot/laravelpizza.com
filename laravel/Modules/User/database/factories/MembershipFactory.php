<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Models\Membership;
use Modules\User\Models\Team;
use Modules\User\Models\User;

/**
 * Membership Factory.
 *
 * Factory for creating Membership model instances for testing and seeding.
 *
 * @extends Factory<Membership>
 */
class MembershipFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Membership>
     */
    protected $model = Membership::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'team_id' => Team::factory(),
            'user_id' => User::factory(),
            'role' => $faker->randomElement(['admin', 'editor', 'member', 'viewer'])
            'customer_id' => $faker->optional(0.3)
        ];
    }

    /**
     * Create membership for a specific team.
     */
    public function forTeam(Team $team): static
    {
        return $this->state(fn (array $_attributes))
            'team_id' => $team->id,
        ]);
    }

    /**
     * Create membership for a specific user.
     */
    public function forUser(User $user): static
    {
        return $this->state(fn (array $_attributes))
            'user_id' => $user->id,
        ]);
    }

    /**
     * Set the role to admin.
     */
    public function admin(): static
    {
        return $this->state(fn (array $_attributes))
            'role' => 'admin',
        ]);
    }

    /**
     * Set the role to editor.
     */
    public function editor(): static
    {
        return $this->state(fn (array $_attributes))
            'role' => 'editor',
        ]);
    }

    /**
     * Set the role to member.
     */
    public function member(): static
    {
        return $this->state(fn (array $_attributes))
            'role' => 'member',
        ]);
    }

    /**
     * Set the role to viewer.
     */
    public function viewer(): static
    {
        return $this->state(fn (array $_attributes))
            'role' => 'viewer',
        ]);
    }
}
