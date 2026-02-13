<?php

use Illuminate\Foundation\Testing\TestCase;
use Modules\Xot\Tests\CreatesApplication;

uses(TestCase::class, CreatesApplication::class);

test('can render registration page', function (): void {
    $response = $this->get('/en/auth/register');
    expect($response->status())->toBe(200);
});
