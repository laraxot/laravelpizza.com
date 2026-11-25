<?php

declare(strict_types=1);

namespace Modules\Rating\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Rating\Models\AbstractRatingsHost;

/**
 * @extends Factory<AbstractRatingsHost>
 */
class AbstractRatingsHostFactory extends Factory
{
    /** @var class-string<AbstractRatingsHost> */
    protected $model = AbstractRatingsHost::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
        ];
    }
}
