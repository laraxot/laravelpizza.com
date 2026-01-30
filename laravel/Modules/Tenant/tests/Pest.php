<?php

declare(strict_types=1);

use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Tests\TestCase;
use Webmozart\Assert\Assert;

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

pest()->extend(TestCase::class)->in('Feature', 'Unit', 'Integration', 'Performance');

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

// NOTE: The 'toBeTenant' expectation was removed as it was not used elsewhere
// and caused PHPStan errors related to '$this' binding.

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

function createTenant(array $attributes = []): Tenant
{
    /** @var Tenant $tenant */
    $tenant = Tenant::factory()->create($attributes);
    Assert::isInstanceOf($tenant, Tenant::class); // Added for PHPStan

    return $tenant;
}

function makeTenant(array $attributes = []): Tenant
{
    /** @var Tenant $tenant */
    $tenant = Tenant::factory()->make($attributes);
    Assert::isInstanceOf($tenant, Tenant::class); // Added for PHPStan

    return $tenant;
}

// Removed TenantUser functions as the model doesn't exist in this module
