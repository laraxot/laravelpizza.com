<?php

namespace Modules\ForumTemplate\Database\Factories;

use Modules\ForumTemplate\App\Models\ForumTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\App\Models\User;

class ForumTemplateFactory extends Factory
{
    protected $model = ForumTemplate::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'content' => $this->faker->paragraphs(3, true),
            'author_id' => User::factory(),
            'forum_id' => \Modules\Cms\App\Models\Forum::factory(),
            'is_active' => $this->faker->boolean,
        ];
    }
}