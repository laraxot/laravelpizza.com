<?php

declare(strict_types=1);

namespace Modules\Notify\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Notify\Models\NotificationTemplateVersion;

class NotificationTemplateVersionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = NotificationTemplateVersion::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
