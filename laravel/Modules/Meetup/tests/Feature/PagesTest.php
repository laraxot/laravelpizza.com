<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature;

use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('can access terms page', function (): void {
    $response = $this->get('/it/terms');
    $response->assertStatus(200)
        ->assertSee('Termini e condizioni')
        ->assertDontSee('Contenuto dei termini e condizioni');
});

test('can access privacy page', function (): void {
    $response = $this->get('/it/privacy');
    $response->assertStatus(200)
        ->assertSee('Informativa sulla privacy')
        ->assertSee('Garante per la protezione dei dati personali')
        ->assertDontSee("Contenuto dell'informativa");
});

test('the cookie policy linked by the cookie notice exists in both languages', function (string $locale): void {
    $this->get('/'.$locale.'/cookie-policy')->assertOk()->assertSee('XSRF-TOKEN');
})->with(['it', 'en']);
