<?php

declare(strict_types=1);

beforeEach(function (): void {
    if (! function_exists('moduleEnabled')) {
        $this->markTestSkipped('moduleEnabled() helper not available.');
    }
    if (! moduleEnabled('Cms')) {
        $this->markTestSkipped('Module Cms is disabled');
    }
});

it('redirects root / to /{locale}', function (): void {
    $locale = app()->getLocale();
    $response = $this->get('/');
    $response->assertRedirect('/'.$locale);
});

it('serves localized homepage at /{locale}', function (): void {
    $locale = app()->getLocale();
    $response = $this->get('/'.$locale);
    $response->assertStatus(200);
});
