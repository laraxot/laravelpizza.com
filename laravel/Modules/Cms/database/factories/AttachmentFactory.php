<?php

declare(strict_types=1);

namespace Modules\Cms\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Cms\Models\Attachment;

class AttachmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Attachment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
