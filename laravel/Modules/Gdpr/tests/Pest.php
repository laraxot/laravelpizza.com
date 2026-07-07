<?php

declare(strict_types=1);

<<<<<<< HEAD
use Illuminate\Testing\TestResponse;
use Modules\Gdpr\Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Pest Configuration
|--------------------------------------------------------------------------
|
| This file configures Pest for the Gdpr module tests.
|
*/

uses(TestCase::class)->in(__DIR__);

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
*/

expect()->extend('toBeRedirectedTo', function ($expected) {
    return function (TestResponse $response) use ($expected) {
        return $response->assertRedirect($expected);
    };
});

/*
|--------------------------------------------------------------------------
| Hooks
|--------------------------------------------------------------------------
|
*/

beforeEach(function () {
    // DatabaseTransactions trait handles rollback automatically
});

afterEach(function () {
    // DatabaseTransactions trait handles rollback automatically
});
=======
/*
 * Bootstrap Pest — modulo Gdpr.
 * Ogni file test dichiara uses(\Modules\Gdpr\Tests\TestCase::class).
 * Vietato pest()->extend() / expect()->extend() / uses()->in() qui (PHPStan method.internalClass).
 */
>>>>>>> 40b96bcd6 (.)
