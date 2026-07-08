<?php

declare(strict_types=1);

namespace Modules\Incentivi\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Incentivi\Models\Activity;
use Modules\Incentivi\Models\Project;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => 'Activity ' . rand(1, 1000),
            'tipo' => 'Tipo Activity',
            'quota_percentuale' => 10,
            'importo' => 500.00,
            'anno_competenza' => '2024',
            'project_id' => Project::factory(),
        ];
    }
}
