<?php

declare(strict_types=1);

use Tests\TestCase;

use function Pest\Laravel\get;

uses(TestCase::class);

test('route home returns successful response with correct view', function (): void {
    get('/')->assertSuccessful()->assertViewIs('pub_theme::home');
});

test('route login returns successful response with correct view', function (): void {
    get('/it/login')->assertSuccessful()->assertViewIs('pub_theme::auth.login');
});
