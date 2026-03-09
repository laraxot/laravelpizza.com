<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

it('GET /de localizes guest auth labels in header', function (): void {
    $this->get('/de')
        ->assertOk()
        ->assertSee('lang="de"', false)
        ->assertSeeText('Anmelden')
        ->assertSeeText('Registrieren')
        ->assertDontSeeText('Accedi')
        ->assertSee('/de/auth/login', false)
        ->assertSee('/de/auth/register', false);
});
