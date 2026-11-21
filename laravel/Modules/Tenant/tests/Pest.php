<?php

declare(strict_types=1);

use Modules\Tenant\Models\Tenant;
use Webmozart\Assert\Assert;

/*
 * Nessun binding del TestCase qui: ogni file di test lega Modules\Tenant\Tests\TestCase con uses().
 *
 * @see Modules/Tenant/docs/testing.md#binding-del-testcase
 */

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

/**
 * @param  array<string, mixed>  $attributes
 */
function createTenant(array $attributes = []): Tenant
{
    /** @var Tenant $tenant */
    $tenant = Tenant::factory()->create($attributes);
    Assert::isInstanceOf($tenant, Tenant::class); // Added for PHPStan

    return $tenant;
}

/**
 * @param  array<string, mixed>  $attributes
 */
function makeTenant(array $attributes = []): Tenant
{
    /** @var Tenant $tenant */
    $tenant = Tenant::factory()->make($attributes);
    Assert::isInstanceOf($tenant, Tenant::class); // Added for PHPStan

    return $tenant;
}

// Removed TenantUser functions as the model doesn't exist in this module
