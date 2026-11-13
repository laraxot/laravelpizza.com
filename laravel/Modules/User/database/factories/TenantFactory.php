<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\User\Models\Tenant;

/**
 * @extends Factory<Tenant>
 */
class TenantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Tenant>
     */
    protected $model = Tenant::class;

    /**
     * Define the model's default state.
     */
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Lo slug non si fissa qui: lo genera HasSlug dal nome effettivo (anche quando il test
        // sovrascrive 'name'), unico per tabella. Calcolarlo dal nome casuale della definition
        // produceva slug scollegati dal nome ("Test Tenant" -> "dibbert-zieme-KGEFT7").
        return [
            'id' => (string) Str::ulid(),
            'name' => $this->faker->company(),
        ];
    }
}
