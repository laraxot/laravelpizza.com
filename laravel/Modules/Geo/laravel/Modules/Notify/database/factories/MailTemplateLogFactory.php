<?php

declare(strict_types=1);

namespace Modules\Notify\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Notify\Models\MailTemplateLog;

/**
 * @extends Factory<MailTemplateLog>
 */
class MailTemplateLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = MailTemplateLog::class;

    /**
     * Define the model's default state.
     */
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [];
    }
}
