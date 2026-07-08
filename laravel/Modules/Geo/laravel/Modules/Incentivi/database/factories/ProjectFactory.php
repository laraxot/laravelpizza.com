<?php

declare(strict_types=1);

namespace Modules\Incentivi\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Incentivi\Models\Project;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => 'Project ' . rand(1, 1000),
            'tipo' => 'Tipo A',
            'stato' => 'compilazione',
            'data_aggiudicazione' => '2024-01-01',
            'data_inizio_esecuzione' => '2024-01-01',
            'data_fine_esecuzione' => '2024-12-31',
            'ente_finanziatore' => 'Ente Test',
            'oggetto' => 'Oggetto Test',
            'determina' => 'DET-001',
            'percentuale_fondo' => 2.0,
            'importo_totale' => 100000.000,
            'importo_effettivo_fondo' => 2000.000,
            'componente_incentivante' => 1600.000,
            'componente_innovazione' => 400.000,
            'rup' => 'RUP Test',
            'dec' => 'DEC Test',
            'ditta_nome' => 'Ditta Test',
            'ditta_sede' => 'Sede Test',
            'ditta_partitaiva' => '01234567890',
            'ditta_oneri_sicurezza' => 500.00,
            'ditta_trattativa' => 'Trattativa Test',
            'department_id' => 1,
        ];
    }
}
