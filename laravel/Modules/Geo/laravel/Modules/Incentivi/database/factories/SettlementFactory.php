<?php

declare(strict_types=1);

namespace Modules\Incentivi\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Incentivi\Models\Settlement;
use Modules\Incentivi\Models\Project;

class SettlementFactory extends Factory
{
    protected $model = Settlement::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'denominazione' => 'Settlement ' . rand(1, 100),
            'tipologia' => 'Tipo Test',
            'importo' => 1000.00,
            'project_id' => Project::factory(),
            'model_type' => Project::class,
            'model_id' => Project::factory(),
        ];
    }
}
