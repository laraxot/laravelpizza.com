<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature;

use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('header navigation shows localized auth labels for german', function (): void {
    $response = $this->get('/de');
    $response->assertStatus(200);

    preg_match('/<nav[^>]*id="main-navigation".*?<\/nav>/s', $response->getContent(), $matches);
    $header = html_entity_decode($matches[0] ?? $response->getContent(), ENT_QUOTES | ENT_HTML5, 'UTF-8');

    expect($header)
        ->toContain('Anmelden')
        ->toContain('Registrieren')
        ->not->toContain('Accedi')
        ->not->toContain('Registrati');
});

test('header navigation shows localized auth labels for english', function (): void {
    $response = $this->get('/en');
    $response->assertStatus(200);

    preg_match('/<nav[^>]*id="main-navigation".*?<\/nav>/s', $response->getContent(), $matches);
    $header = html_entity_decode($matches[0] ?? $response->getContent(), ENT_QUOTES | ENT_HTML5, 'UTF-8');

    expect($header)
        ->toContain('Log in')
        ->toContain('Sign up')
        ->not->toContain('Accedi')
        ->not->toContain('Registrati');
});

test('header navigation shows localized auth labels for italian', function (): void {
    $response = $this->get('/it');
    $response->assertStatus(200);

    preg_match('/<nav[^>]*id="main-navigation".*?<\/nav>/s', $response->getContent(), $matches);
    $header = html_entity_decode($matches[0] ?? $response->getContent(), ENT_QUOTES | ENT_HTML5, 'UTF-8');

    expect($header)
        ->toContain('Accedi')
        ->toContain('Registrati');
});

test('header navigation shows localized auth labels for french', function (): void {
    $response = $this->get('/fr');
    $response->assertStatus(200);

    preg_match('/<nav[^>]*id="main-navigation".*?<\/nav>/s', $response->getContent(), $matches);
    $header = html_entity_decode($matches[0] ?? $response->getContent(), ENT_QUOTES | ENT_HTML5, 'UTF-8');

    expect($header)
        ->toContain('Se connecter')
        ->toContain('S\'inscrire')
        ->not->toContain('Accedi')
        ->not->toContain('Registrati');
});

test('header navigation shows localized auth labels for spanish', function (): void {
    $response = $this->get('/es');
    $response->assertStatus(200);

    preg_match('/<nav[^>]*id="main-navigation".*?<\/nav>/s', $response->getContent(), $matches);
    $header = html_entity_decode($matches[0] ?? $response->getContent(), ENT_QUOTES | ENT_HTML5, 'UTF-8');

    expect($header)
        ->toContain('Iniciar sesión')
        ->toContain('Registrarse')
        ->not->toContain('Accedi')
        ->not->toContain('Registrati');
});

test('header navigation shows localized auth labels for russian', function (): void {
    $response = $this->get('/ru');
    $response->assertStatus(200);

    preg_match('/<nav[^>]*id="main-navigation".*?<\/nav>/s', $response->getContent(), $matches);
    $header = html_entity_decode($matches[0] ?? $response->getContent(), ENT_QUOTES | ENT_HTML5, 'UTF-8');

    expect($header)
        ->toContain('Войти')
        ->toContain('Регистрация')
        ->not->toContain('Accedi')
        ->not->toContain('Registrati');
});

test('header guest auth ctas keep secondary primary visual hierarchy', function (): void {
    $response = $this->get('/en');
    $response->assertStatus(200);

    preg_match('/<nav[^>]*id="main-navigation".*?<\/nav>/s', $response->getContent(), $matches);
    $header = html_entity_decode($matches[0] ?? $response->getContent(), ENT_QUOTES | ENT_HTML5, 'UTF-8');

    expect($header)
        ->toContain('border-white/15 bg-white/5')
        ->toContain('bg-gradient-to-r from-red-500 via-red-600 to-orange-500');
});
