<?php

declare(strict_types=1);

namespace Modules\Incentivi\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Incentivi\Models\StabiDirigente;

class StabiDirigenteFactory extends Factory
{
    protected $model = StabiDirigente::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'stabi' => rand(1, 100),
            'repar' => rand(1, 100),
            'nome_stabi' => 'Stabi Test',
            'ente' => 90,
            'matr' => rand(1000, 9999),
            'nome_diri' => 'Dirigente Test',
            'nome_diri_plus' => 'Dirigente Plus Test',
            'budget' => 5000.00,
            'valutatore_id' => rand(1, 100),
            'anno' => 2024,
            'post_type' => 'project',
            'post_id' => rand(1, 100),
        ];
    }
}
