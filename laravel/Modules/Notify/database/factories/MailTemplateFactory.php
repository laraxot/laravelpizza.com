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
            'name' => // @var mixed faker->words(3, true
            'slug' => // @var mixed faker->slug(
            'subject' => // @var mixed faker->sentence(
            'html_template' => // @var mixed faker->randomHtml(
            'text_template' => // @var mixed faker->text(
            'type' => // @var mixed faker->randomElement(['email', 'notification', 'sms']
            'is_active' => // @var mixed faker->boolean(80
            'created_at' => // @var mixed faker->dateTimeBetween('-1 year'
            'updated_at' => // @var mixed faker->dateTimeBetween('-1 year'
        ];
    }
}
