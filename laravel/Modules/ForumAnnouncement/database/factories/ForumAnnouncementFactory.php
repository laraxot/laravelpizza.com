<?php

namespace Modules\ForumAnnouncement\Database\Factories;

use Modules\ForumAnnouncement\App\Models\ForumAnnouncement;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\App\Models\User;

class ForumAnnouncementFactory extends Factory
{
    protected $model = ForumAnnouncement::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraphs(3, true),
            'author_id' => User::factory(),
            'forum_id' => \Modules\Cms\App\Models\Forum::factory(),
            'is_active' => $this->faker->boolean,
            'starts_at' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'ends_at' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
        ];
    }
}