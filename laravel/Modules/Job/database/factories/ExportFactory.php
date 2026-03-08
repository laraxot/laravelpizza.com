<?php

declare(strict_types=1);

namespace Modules\Job\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Modules\Job\Models\Export;

/**
 * @extends Factory<Export>
 */
class ExportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Export>
     */
    protected $model = Export::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            // 'id' => // @var mixed faker->randomNumber(5, false
            // 'queue' => // @var mixed faker->word,
            // 'payload' => // @var mixed faker->text,
            // 'attempts' => // @var mixed faker->boolean,
            // 'reserved_at' => // @var mixed faker->randomNumber(5, false
            // 'available_at' => // @var mixed faker->randomNumber(5, false
            // 'created_at' => // @var mixed faker->randomNumber(5, false
        ];
    }
}
