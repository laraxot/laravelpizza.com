<?php

declare(strict_types=1);

use Modules\Gdpr\Models\GdprConsent;
use Modules\Gdpr\Models\GdprRequest;
use Modules\Gdpr\Tests\TestCase;

/*
 * |--------------------------------------------------------------------------
 * | Test Case
 * |--------------------------------------------------------------------------
 * |
 * | The closure you provide to your test functions is always bound to a specific PHPUnit test
 * | case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
 * | need to change it using the "pest()" function to bind a different classes or traits.
 * |
 */

pest()->extend(TestCase::class)->in('Feature', 'Unit');

/*
 * |--------------------------------------------------------------------------
 * | Expectations
 * |--------------------------------------------------------------------------
 * |
 * | When you're writing tests, you often need to check that values meet certain conditions. The
 * | "expect()" function gives you access to a set of "expectations" methods that you can use
 * | to assert different things. Of course, you may extend the Expectation API at any time.
 * |
 */

expect()->extend('toBeGdprConsent', fn () => $this->toBeInstanceOf(GdprConsent::class));

expect()->extend('toBeGdprRequest', fn () => $this->toBeInstanceOf(GdprRequest::class));

/*
 * |--------------------------------------------------------------------------
 * | Functions
 * |--------------------------------------------------------------------------
 * |
 * | While Pest is very powerful out-of-the-box, you may have some testing code specific to your
 * | project that you don't want to repeat in every file. Here you can also expose helpers as
 * | global functions to help you to reduce the number of lines of code in your test files.
 * |
 */

function createGdprConsent(array $attributes = []): GdprConsent
{
    return GdprConsent::factory()->create($attributes);
}

function makeGdprConsent(array $attributes = []): GdprConsent
{
    return GdprConsent::factory()->make($attributes);
}

function createGdprRequest(array $attributes = []): GdprRequest
{
    return GdprRequest::factory()->create($attributes);
}

function makeGdprRequest(array $attributes = []): GdprRequest
{
    return GdprRequest::factory()->make($attributes);
}
