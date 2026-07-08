<?php

namespace Modules\Sigma\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Sigma\Models\TableList;

/**
 * @extends Factory<TableList>
 */
class TableListFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = TableList::class;

    /**
     * Define the model's default state.
     */
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [];
    }
}
