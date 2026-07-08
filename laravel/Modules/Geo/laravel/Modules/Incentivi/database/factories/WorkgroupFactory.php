<?php

declare(strict_types=1);

namespace Modules\Incentivi\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Incentivi\Models\Workgroup;

class WorkgroupFactory extends Factory
{
    protected $model = Workgroup::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'denominazione' => 'Workgroup ' . rand(1, 50),
        ];
    }
}
