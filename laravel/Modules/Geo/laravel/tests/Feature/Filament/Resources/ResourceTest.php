<?php

declare(strict_types=1);

use Filament\Facades\Filament;
use Modules\User\Models\User;

use function Pest\Laravel\get;

test('le risorse filament sono registrate correttamente', function () {
    $resources = Filament::getResources();

    expect($resources)->toBeArray()->and($resources)->not->toBeEmpty();
});

test('un utente autenticato può accedere alle risorse', function () {
    $user = User::factory()->create();

    $resources = Filament::getResources();

    foreach ($resources as $resource) {
        $slug = $resource::getSlug();

        actingAs($user)->get("/admin/{$slug}")->assertStatus(200);
    }
});

test('un utente non autenticato non può accedere alle risorse', function () {
    $resources = Filament::getResources();

    foreach ($resources as $resource) {
        $slug = $resource::getSlug();

        get("/admin/{$slug}")->assertRedirect('/admin/login');
    }
});

test('le risorse hanno i componenti necessari', function () {
    $resources = Filament::getResources();

    foreach ($resources as $resource) {
        expect($resource::hasTable())
            ->toBeTrue('La risorsa deve avere una tabella')
            ->and($resource::hasForm())
            ->toBeTrue('La risorsa deve avere un form');
    }
});
