<?php

declare(strict_types=1);

namespace Modules\Notify\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Notify\Enums\NotificationLogStatusEnum;
use Modules\Notify\Models\NotificationLog;
use Modules\User\Models\User;

/**
 * @extends Factory<NotificationLog>
 */
class NotificationLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = NotificationLog::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'notifiable_type' => User::class,
            'notifiable_id' => 1,
            'channel' => 'mail',
            'data' => ['message' => $this->faker->sentence()],
            'sent_at' => now(),
            'status' => NotificationLogStatusEnum::SENT->value,
            'status_message' => null];
    }
}
