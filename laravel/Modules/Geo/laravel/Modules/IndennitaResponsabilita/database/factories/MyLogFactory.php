<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\IndennitaResponsabilita\Models\MyLog;

/**
 * @extends Factory<\Modules\IndennitaResponsabilita\Models\MyLog>
 */
class MyLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = MyLog::class;

    /**
     * Define the model's default state.
     *
     * @return array{}
     */
    public function definition(): array
    {
        return [];
    }
}
