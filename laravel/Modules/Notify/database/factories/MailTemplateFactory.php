<?php

declare(strict_types=1);


namespace Modules\Notify\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Notify\Models\MailTemplate;

class MailTemplateFactory extends Factory
{
    protected $model = MailTemplate::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'slug' => $this->faker->slug(),
            'subject' => $this->faker->sentence(),
            'html_template' => $this->faker->randomHtml(),
            'text_template' => $this->faker->text(),
            'type' => $this->faker->randomElement(['email', 'notification', 'sms']),
            'is_active' => $this->faker->boolean(80),
            'created_at' => $this->faker->dateTimeBetween('-1 year'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year'),
        ];
    }
}
