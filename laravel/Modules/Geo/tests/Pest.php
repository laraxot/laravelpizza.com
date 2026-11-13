<?php

declare(strict_types=1);

use Mockery\CompositeExpectation;
use Mockery\Expectation;
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
 * @param  array<string, mixed>  $attributes
 */
function createRegion(array $attributes = []): Region
{
    return RegionFactory::new()->createOne($attributes);
}

/**
 * @param  array<string, mixed>  $attributes
 */
function createComune(array $attributes = []): Comune
{
    return ComuneFactory::new()->createOne($attributes);
}

/*
 * Mockery 1.6 returns a CompositeExpectation from shouldReceive()/allows(), which forwards
 * once()/with()/andReturn() via __call and so is opaque to PHPStan. The composite holds no
 * public accessor, so its single Expectation is read once here to keep chained calls typed.
 */
if (! function_exists('geo_mockery_expect')) {
    function geo_mockery_expect(object $expectation): Expectation
    {
        if ($expectation instanceof CompositeExpectation) {
            $expectations = (fn (): array => $this->_expectations)->call($expectation);
            assert(count($expectations) === 1, 'geo_mockery_expect() supports a single expected method');
            $expectation = reset($expectations);
        }

        assert($expectation instanceof Expectation);

        return $expectation;
    }
}
