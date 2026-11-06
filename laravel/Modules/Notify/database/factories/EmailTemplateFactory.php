<?php

declare(strict_types=1);

namespace Modules\Notify\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Notify\Models\EmailTemplate;

/** @extends Factory<EmailTemplate> */
class EmailTemplateFactory extends Factory
{
    protected $model = EmailTemplate::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'subject' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(3, true),
            'variables' => ['user_name', 'email', 'date'],
            'categories' => [$this->faker->word()],
            'version' => 1,
            'is_active' => true,
        ];
    }
}