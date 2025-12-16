<?php

declare(strict_types=1);

namespace Modules\Notify\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Models\Contact;

/**
 * @extends Factory<Contact>
 */
class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Contact>
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            // 'model_id' => $this->faker->randomNumber(5, false),
            'model_type' => fake()->word,
            'contact_type' => fake()->word,
            'value' => fake()->word,
            'verified_at' => fake()->dateTime,
            'updated_at' => fake()->dateTime,
            'created_at' => fake()->dateTime,
            'updated_by' => fake()->word,
            'created_by' => fake()->word,
            // 'user_id' => $this->faker->randomNumber(5, false),
            'token' => fake()->word,
        ];
    }
}
