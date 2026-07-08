<?php

declare(strict_types=1);

use Modules\Progressioni\Tests\TestCase;

uses(TestCase::class);

use Filament\Facades\Filament;
use Livewire\Livewire;
use Modules\Progressioni\Filament\Resources\AssenzaResource;
use Modules\Progressioni\Filament\Resources\AssenzaResource\Pages\ListAssenzas;
use Modules\Progressioni\Models\Assenza;
use Modules\Xot\Datas\XotData;

beforeEach(function () {
    $this->user = XotData::make()->getUserClass()::factory()->create();
    $this->user->assignRole('progressioni::admin');

    $this->actingAs($this->user);

    Filament::setCurrentPanel(
        Filament::getPanel('progressioni::admin')
    );
});

test('AssenzaResource is registered in progressioni panel', function () {
    $panel = Filament::getPanel('progressioni::admin');

    expect($panel->getResources())
        ->toContain(AssenzaResource::class);
});

test('AssenzaResource should register navigation', function () {
    expect(AssenzaResource::shouldRegisterNavigation())
        ->toBeTrue();
});

test('AssenzaResource exposes standard crud pages', function () {
    $pages = AssenzaResource::getPages();

    expect($pages)->toHaveKeys(['index', 'create', 'edit']);
});

test('ListAssenzas page renders successfully', function () {
    Assenza::factory()->create([
        'anno' => (int) date('Y'),
    ]);

    Livewire::test(ListAssenzas::class)
        ->assertSuccessful();
});
