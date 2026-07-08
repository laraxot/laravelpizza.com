<?php

declare(strict_types=1);

use Modules\Progressioni\Tests\TestCase;

uses(TestCase::class);

use Filament\Facades\Filament;
use Livewire\Livewire;
use Modules\Progressioni\Filament\Resources\Asz00fResource;
use Modules\Progressioni\Filament\Resources\Asz00fResource\Pages\ListAsz00fs;
use Modules\Progressioni\Filament\Resources\Asz00fResource\Widgets\Asz00fStatsOverview;
use Modules\Xot\Datas\XotData;

beforeEach(function () {
    $this->user = XotData::make()->getUserClass()::factory()->create();
    $this->user->assignRole('progressioni::admin');

    $this->actingAs($this->user);

    Filament::setCurrentPanel(
        Filament::getPanel('progressioni::admin')
    );
});

test('Asz00fResource is registered in progressioni panel', function () {
    $panel = Filament::getPanel('progressioni::admin');

    expect($panel->getResources())
        ->toContain(Asz00fResource::class);
});

test('Asz00fResource should register navigation', function () {
    expect(Asz00fResource::shouldRegisterNavigation())
        ->toBeTrue();
});

test('Asz00fResource exposes standard crud pages', function () {
    $pages = Asz00fResource::getPages();

    expect($pages)->toHaveKeys(['index', 'create', 'edit']);
});

test('Asz00fResource registers stats overview widget', function () {
    expect(Asz00fResource::getWidgets())
        ->toContain(Asz00fStatsOverview::class);
});

test('ListAsz00fs page renders successfully', function () {
    Livewire::test(ListAsz00fs::class)
        ->assertSuccessful();
});
