<?php

namespace Modules\ForumSubscriber\Database\Factories;

use Modules\ForumSubscriber\App\Models\ForumSubscriber;
use Illuminate\Database\Eloquent\Factories\Factory;

class ForumSubscriberFactory extends Factory
{
    protected $model = ForumSubscriber::class;

    public function definition(): array
    {
        return [
            'user_id' => \Modules\User\App\Models\User::factory(),
            'forum_id' => \Modules\Cms\App\Models\Forum::factory(),
            'subscription_type' => $this->faker->randomElement(['email', 'digest', 'none']),
            'created_at' => now(),
        ];
    }
}