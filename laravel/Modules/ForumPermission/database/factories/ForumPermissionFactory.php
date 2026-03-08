<?php

namespace Modules\ForumPermission\Database\Factories;

use Modules\ForumPermission\App\Models\ForumPermission;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\App\Models\Role;

class ForumPermissionFactory extends Factory
{
    protected $model = ForumPermission::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word . ' Permissions',
            'description' => $this->faker->sentence,
            'forum_id' => \Modules\Cms\App\Models\Forum::factory(),
            'role_id' => Role::factory(),
            'can_create_post' => $this->faker->boolean,
            'can_edit_post' => $this->faker->boolean,
            'can_delete_post' => $this->faker->boolean,
            'can_create_thread' => $this->faker->boolean,
            'can_edit_thread' => $this->faker->boolean,
            'can_delete_thread' => $this->faker->boolean,
            'can_reply' => $this->faker->boolean,
            'can_edit_reply' => $this->faker->boolean,
            'can_delete_reply' => $this->faker->boolean,
            'can_moderate' => $this->faker->boolean,
        ];
    }
}