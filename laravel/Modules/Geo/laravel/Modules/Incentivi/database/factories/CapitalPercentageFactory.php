<?php

declare(strict_types=1);

namespace Modules\Incentivi\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Incentivi\Models\CapitalPercentage;

class CapitalPercentageFactory extends Factory
{
    protected $model = CapitalPercentage::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => 'Capital % Range ' . rand(1, 10),
            'descrizione' => 'Descrizione Test',
            'valore' => 2.0,
            'tipologia' => 'Tipo A',
            'da' => 0,
            'a' => 100000,
        ];
    }
}
