<?php

declare(strict_types=1);


namespace Modules\Notify\Database\Factories;

use Modules\Notify\Models\MailTemplateLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class MailTemplateLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = MailTemplateLog::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
