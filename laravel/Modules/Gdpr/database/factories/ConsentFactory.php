<?php

declare(strict_types=1);

namespace Modules\Gdpr\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Gdpr\Models\Consent;

/**
 * @extends Factory<Consent>
 */
class ConsentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Consent>
     */
    protected $model = Consent::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Colonne reali di `consents`, come le scrive SaveGdprConsentsAction (user_id + user_type, `type` = trattamento,
        // `accepted_at`): le chiavi subject_type / consent_type / accepted non esistono e facevano fallire ogni insert.
        return [
            'subject_id' => fake()->uuid(),
            'user_id' => fake()->uuid(),
            'user_type' => 'Modules\User\Models\User',
            'type' => 'privacy_policy',
            'accepted_at' => now(),
            'ip_address' => '127.0.0.1',
            'user_agent' => fake()->userAgent(),
        ];
    }
}
