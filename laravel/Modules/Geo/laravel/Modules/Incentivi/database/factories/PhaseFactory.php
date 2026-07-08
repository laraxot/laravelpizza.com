<?php

declare(strict_types=1);

namespace Modules\Incentivi\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Incentivi\Models\Phase;
use Modules\Incentivi\Models\Project;

class PhaseFactory extends Factory
{
    protected $model = Phase::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Phase ' . rand(1, 10),
            'description' => 'Description Test',
            'start_date' => '2024-01-01',
            'end_date' => '2024-03-31',
            'project_id' => Project::factory(),
        ];
    }
}
