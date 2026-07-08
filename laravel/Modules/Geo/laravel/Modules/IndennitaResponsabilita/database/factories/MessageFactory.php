<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\IndennitaResponsabilita\Models\Message;

/**
 * @extends Factory<\Modules\IndennitaResponsabilita\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array{}
     */
    public function definition(): array
    {
        return [];
    }
}
