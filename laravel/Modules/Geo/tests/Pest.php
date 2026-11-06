<?php

declare(strict_types=1);

use Modules\Geo\Database\Factories\ComuneFactory;
use Modules\Geo\Database\Factories\RegionFactory;
use Modules\Geo\Models\Comune;
use Modules\Geo\Models\Region;

/*
 * Bootstrap Pest — modulo Geo.
 * Ogni file test dichiara uses(\Modules\Geo\Tests\TestCase::class) o LightTestCase/UnitTestCase FQCN.
 * Vietato uses()->in() qui (PHPStan method.internalClass).
 */

/*
 * |--------------------------------------------------------------------------
 * | Functions
 * |--------------------------------------------------------------------------
 */

/**
 * @param array<string, mixed> $attributes
 */
function createRegion(array $attributes = []): Region
{
    return RegionFactory::new()->createOne($attributes);
}

/**
 * @param array<string, mixed> $attributes
 */
function createComune(array $attributes = []): Comune
{
    return ComuneFactory::new()->createOne($attributes);
}
