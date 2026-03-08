<?php

declare(strict_types=1);

namespace Modules\Activity\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Activity\Models\Activity;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition(): array
    {
        return [
            'log_name' => // @var mixed faker->randomElement(['default', 'auth', 'system']
            'description' => // @var mixed faker->sentence(
            'subject_type' => // @var mixed faker->randomElement(['Modules\User\Models\User', 'App\Models\Appointment']
            // User model uses UUID; subject_id/causer_id are string(36) in activity_log
            'subject_id' => // @var mixed faker->uuid(
            'causer_type' => 'Modules\User\Models\User',
            'causer_id' => // @var mixed faker->uuid(
            'properties' => ['key' => 'value'],
            'batch_uuid' => // @var mixed faker->uuid(
            'event' => // @var mixed faker->randomElement(['created', 'updated', 'deleted']
            'created_at' => // @var mixed faker->dateTimeBetween('-1 year'
            'updated_at' => // @var mixed faker->dateTimeBetween('-1 year'
        ];
    }
}
