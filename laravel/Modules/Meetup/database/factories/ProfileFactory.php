<?php

declare(strict_types=1);

namespace Modules\Meetup\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Meetup\Models\Profile;
use Modules\User\Models\User;

/**
 * Factory per profili Meetup.
 *
 * Schema ridotto rispetto a BaseProfile (User): solo colonne presenti nella tabella
 * profiles (connessione meetup): user_id, first_name, last_name, fiscal_code, phone, email, notes.
 *
 * @extends Factory<Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Profile>
     */
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => null,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'fiscal_code' => null,
            'phone' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'notes' => null,
        ];
    }

    /**
     * State: associa a un utente creato automaticamente.
     */
    public function withUser(): static
    {
        return $this->state(fn (array $attributes): array => [
            'user_id' => User::factory(),
        ]);
    }

    /**
     * State: imposta codice fiscale italiano (formato 16 caratteri).
     */
    public function withFiscalCode(): static
    {
        return $this->state(fn (array $attributes): array => [
            'fiscal_code' => fake()->regexify('[A-Z]{6}[0-9]{2}[A-Z][0-9]{2}[A-Z][0-9]{3}[A-Z]'),
        ]);
    }

    /**
     * State: profilo organizzatore eventi.
     */
    public function organizer(): static
    {
        return $this->state(fn (array $attributes): array => [
            'notes' => fake()->randomElement([
                'Organizzatore Laravel Meetup',
                'Co-organizer eventi tech',
                'Community manager',
            ]),
        ]);
    }

    /**
     * State: profilo speaker/relatore.
     */
    public function speaker(): static
    {
        return $this->state(fn (array $attributes): array => [
            'notes' => fake()->randomElement([
                'Speaker Laravel e PHP',
                'Relatore workshop Livewire',
                'Tech speaker',
            ]),
        ]);
    }
}
