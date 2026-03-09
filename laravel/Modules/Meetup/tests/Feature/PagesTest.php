<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature;

use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('can access terms page', function (): void {
    $response = $this->get('/it/terms');
    $response->assertStatus(200)
             ->assertSee('Termini e Condizioni');
});

test('can access privacy page', function (): void {
    $response = $this->get('/it/privacy');
    $response->assertStatus(200)
             ->assertSee('Privacy Policy');
});
