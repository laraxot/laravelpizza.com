<?php

declare(strict_types=1);
use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

it('GET /it/auth/password/{token} renders the shared Design Comuni shell', function (): void {
    $response = $this->get('/it/auth/password/test-token?email=test@example.com');

    $response->assertOk()
        ->assertSee('<header', false)
        ->assertSee('<main', false)
        ->assertSee('<footer', false)
        ->assertSee('data-dc', false);
});
