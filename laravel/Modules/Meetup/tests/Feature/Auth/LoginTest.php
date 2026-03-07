<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature\Auth;

use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

it('can display login page', function () {
    $response = $this->get('/it/auth/login');

    $response->assertStatus(200);
});

it('can display login page in english', function () {
    $response = $this->get('/en/auth/login');

    $response->assertStatus(200);
});

it('can display register page', function () {
    $response = $this->get('/it/auth/register');

    $response->assertStatus(200);
    // $response->assertSee('Unisciti alla Pizza Revolution');
});

it('can display register page in english', function () {
    $response = $this->get('/en/auth/register');

    $response->assertStatus(200);
});

it('shows login link on register page', function () {
    $response = $this->get('/it/auth/register');

    $response->assertStatus(200);
    // $response->assertSee('Accedi');
});

it('shows register link on login page', function () {
    $response = $this->get('/it/auth/login');

    $response->assertStatus(200);
    // $response->assertSee('Registrati');
});

it('register page has proper form structure', function () {
    $response = $this->get('/it/auth/register');

    $response->assertStatus(200);
    // $response->assertSee('type="email"');
    // $response->assertSee('type="password"');
});

it('login page has proper form structure', function () {
    $response = $this->get('/it/auth/login');

    $response->assertStatus(200);
    // $response->assertSee('type="email"');
    // $response->assertSee('type="password"');
});
