<?php

declare(strict_types=1);

namespace Modules\Progressioni\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Progressioni\Models\EsclusiExtra;

/**
 * @extends Factory<EsclusiExtra>
 */
class EsclusiExtraFactory extends Factory
{
    protected $model = EsclusiExtra::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $motivi = [
            'Trasferimento ad altro ente',
            'Pensionamento',
            'Dimissioni volontarie',
            'Aspettativa non retribuita',
            'Licenziamento disciplinare',
            'Incompatibilità ambientale',
            'Mancato raggiungimento requisiti',
            'Assenze prolungate per malattia',
        ];

        return [
            'ente' => $this->faker->numberBetween(1, 999),
            'matr' => $this->faker->numberBetween(1000, 9999),
            'cognome' => $this->faker->lastName(),
            'nome' => $this->faker->firstName(),
            'motivo' => $this->faker->randomElement($motivi),
            'anno' => $this->faker->numberBetween(2020, 2025),
        ];
    }
}
