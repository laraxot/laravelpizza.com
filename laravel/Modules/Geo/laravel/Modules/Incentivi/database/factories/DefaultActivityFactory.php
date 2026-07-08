<?php

declare(strict_types=1);

namespace Modules\Incentivi\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Incentivi\Models\DefaultActivity;

class DefaultActivityFactory extends Factory
{
    protected $model = DefaultActivity::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => 'Default Activity ' . rand(1, 100),
            'tipo' => 'Default Type',
            'quota_percentuale' => 5,
            'importo' => 0,
            'anno_competenza' => '2024',
        ];
    }
}
