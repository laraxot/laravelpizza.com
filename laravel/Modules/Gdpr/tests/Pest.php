<?php

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
    return function (Illuminate\Testing\TestResponse $response) use ($expected) {
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