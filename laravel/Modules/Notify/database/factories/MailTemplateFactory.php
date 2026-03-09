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
            'name' => $faker->words(3, true)
            'slug' => $faker->slug()
            'subject' => $faker->sentence()
            'html_template' => $faker->randomHtml()
            'text_template' => $faker->text()
            'type' => $faker->randomElement(['email', 'notification', 'sms'])
            'is_active' => $faker->boolean(80)
            'created_at' => $faker->dateTimeBetween('-1 year')
            'updated_at' => $faker->dateTimeBetween('-1 year')
        ];
    }
}
