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
<<<<<<< .merge_file_G0DSG3
     * @return array<string, string>
=======
     * Define the model's default state.
     *
>>>>>>> .merge_file_zn8tMh
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject_id' => fake()->uuid(),
            'subject_type' => 'Modules\User\Models\User',
            'consent_type' => 'privacy_policy',
            'accepted' => true,
            'ip_address' => '127.0.0.1',
            'user_agent' => fake()->userAgent(),
        ];
    }
}
