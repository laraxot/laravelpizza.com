<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature;

use Illuminate\Testing\TestResponse;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

/**
 * Le etichette attese vengono dai file di traduzione del tema: il test verifica che l'intestazione segua la lingua
 * dell'URL, senza fissare una parola precisa (in tedesco "Einloggen" o "Anmelden" sono entrambe corrette).
 */
function headerOf(TestResponse $response): string
{
    preg_match('/<nav[^>]*id="main-navigation".*?<\/nav>/s', (string) $response->getContent(), $matches);

    return html_entity_decode($matches[0] ?? (string) $response->getContent(), ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

test('header navigation shows the auth labels in the language of the url', function (string $locale): void {
    $response = $this->get('/'.$locale);
    $response->assertStatus(200);

    $login = __('pub_theme::navigation.auth.login', [], $locale);
    $register = __('pub_theme::navigation.auth.register', [], $locale);

    expect($login)->not->toBe('pub_theme::navigation.auth.login')
        ->and(headerOf($response))->toContain($login)->toContain($register);

    if ($locale !== 'it') {
        expect(headerOf($response))->not->toContain('Accedi')->not->toContain('Registrati');
    }
})->with(['it', 'en', 'de', 'fr', 'es', 'ru']);

test('header guest auth ctas keep secondary primary visual hierarchy', function (): void {
    $response = $this->get('/en');
    $response->assertStatus(200);

    expect(headerOf($response))
        ->toContain('border-white/15 bg-white/5')
        ->toContain('bg-gradient-to-r from-red-500 via-red-600 to-orange-500');
});
