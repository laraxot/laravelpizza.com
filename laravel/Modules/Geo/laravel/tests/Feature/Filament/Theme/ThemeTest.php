<?php

declare(strict_types=1);

use Filament\Facades\Filament;
use Modules\User\Models\User;

use function Pest\Laravel\get;

test('il tema di filament è configurato correttamente', function () {
    expect(Filament::getFontFamily())
        ->toBe('Inter')
        ->and(Filament::getSidebarWidth())
        ->toBe('20rem')
        ->and(Filament::getCollapsedSidebarWidth())
        ->toBe('5.4rem')
        ->and(Filament::getBrandName())
        ->toBe('Performance');
});

test('la pagina di login mostra il tema corretto', function () {
    get('/admin/login')
        ->assertStatus(200)
        ->assertSee('var(--font-family)')
        ->assertSee('var(--sidebar-width)')
        ->assertSee('var(--collapsed-sidebar-width)');
});

test('il pannello admin mostra il tema corretto per utenti autenticati', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get('/admin')
        ->assertStatus(200)
        ->assertSee('var(--font-family)')
        ->assertSee('var(--sidebar-width)')
        ->assertSee('var(--collapsed-sidebar-width)');
});
