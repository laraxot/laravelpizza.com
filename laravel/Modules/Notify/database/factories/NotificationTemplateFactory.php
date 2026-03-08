<?php

namespace Modules\Notify\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Notify\Models\NotificationTemplate;

/**
 * @extends Factory<NotificationTemplate>
 */
class NotificationTemplateFactory extends Factory
{
    protected $model = NotificationTemplate::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => // @var mixed faker->word(
            'type' => 'email',
            'subject' => // @var mixed faker->sentence(
            'body' => // @var mixed faker->paragraph(
            'variables' => json_encode(['user_name' => 'User Name']),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the template is active.
     */
    public function active(): static
    {
        return // @var mixed state(fn (array $attributes
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the template is inactive.
     */
    public function inactive(): static
    {
        return // @var mixed state(fn (array $attributes
            'is_active' => false,
        ]);
    }

    /**
     * Configure the factory for email templates.
     */
    public function email(): static
    {
        return // @var mixed state(fn (array $attributes
            'type' => 'email',
        ]);
    }

    /**
     * Configure the factory for SMS templates.
     */
    public function sms(): static
    {
        return // @var mixed state(fn (array $attributes
            'type' => 'sms',
        ]);
    }
}