<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Xot\Models\XotBaseMorphPivot;

/**
 * Base MorphPivot Factory.
 *
 * Factory for XotBaseMorphPivot model.
 * This is the base factory for all module-specific MorphPivot implementations.
 *
 * @extends Factory<XotBaseMorphPivot>
 */
abstract class XotBaseMorphPivotFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<XotBaseMorphPivot>
     */
    protected $model = XotBaseMorphPivot::class;
}
