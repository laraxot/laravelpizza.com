<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

pest()->extend(TestCase::class)
    ->use(DatabaseTransactions::class)
    ->in(__DIR__);

it('can display login page', function () {
    $response = get('/it/auth/login');

    $response->assertStatus(200);
});

it('can display login page in english', function () {
    $response = get('/en/auth/login');

    $response->assertStatus(200);
});

it('can display register page', function () {
    $response = get('/it/auth/register');

    $response->assertStatus(200);
    $response->assertSee('Unisciti alla Pizza Revolution');
});

it('can display register page in english', function () {
    $response = get('/en/auth/register');

    $response->assertStatus(200);
});

it('shows login link on register page', function () {
    $response = get('/it/auth/register');

    $response->assertStatus(200);
    $response->assertSee('Accedi');
});

it('shows register link on login page', function () {
    $response = get('/it/auth/login');

    $response->assertStatus(200);
    $response->assertSee('Registrati');
});

it('register page has proper form structure', function () {
    $response = get('/it/auth/register');

    $response->assertStatus(200);
    $response->assertSee('type="email"');
    $response->assertSee('type="password"');
    $response->assertSee('first_name');
    $response->assertSee('last_name');
});

it('login page has proper form structure', function () {
    $response = get('/it/auth/login');

    $response->assertStatus(200);
    $response->assertSee('type="email"');
    $response->assertSee('type="password"');
});
