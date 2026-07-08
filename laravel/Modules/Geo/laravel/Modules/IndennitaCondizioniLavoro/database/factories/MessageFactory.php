<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\IndennitaCondizioniLavoro\Models\Message;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\IndennitaCondizioniLavoro\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Message::class;

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
