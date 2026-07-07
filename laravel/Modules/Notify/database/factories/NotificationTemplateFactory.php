<?php

declare(strict_types=1);

namespace Modules\Notify\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Notify\Models\NotificationTemplate;
use function Safe\json_encode;

/**
 * @extends Factory<NotificationTemplate>
 */
class NotificationTemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = NotificationTemplate::class;

    /**
     * Define the model's default state.
     */
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'name' => $this->faker->words(3, true),
            'code' => $this->faker->unique()->slug(2),
            'description' => $this->faker->sentence(),
            'subject' => json_encode(['en' => $this->faker->sentence(), 'it' => $this->faker->sentence()]),
            'body_html' => json_encode(['en' => '<p>'.$this->faker->paragraph().'</p>']),
            'body_text' => json_encode(['en' => $this->faker->paragraph()]),
            'channels' => json_encode(['mail']),
            'variables' => json_encode([]),
            'conditions' => json_encode([]),
            'preview_data' => json_encode([]),
            'metadata' => json_encode([]),
            'category' => 'general',
            'is_active' => true,
            'version' => 1,
            'type' => 'email',
        ];
    }
}
