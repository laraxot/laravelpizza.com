<?php

declare(strict_types=1);

it('can render registration page', function (): void {
    $response = $this->get('/en/auth/register');
    $response->assertStatus(200);
});
