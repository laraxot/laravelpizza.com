<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Feature;

it('can render registration page', function (): void {
    $response = $this->get('/en/auth/register');
    $response->assertStatus(200);
});
