<?php

declare(strict_types=1);

use Modules\Xot\Datas\XotData;
use Filament\Facades\Filament;
use LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin;
use Livewire\Livewire;
use Modules\Notify\Filament\Resources\MailTemplateResource\Pages\ListMailTemplates;
use Modules\Notify\Models\MailTemplate;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = XotData::make()->getUserClass()::factory()->create();
    $this->user->assignRole('notify::admin');

    actingAs($this->user);

    // Set panel corrente
    Filament::setCurrentPanel(
        Filament::getPanel('notify::admin')
    );
});

test('spatie-translatable plugin is registered in notify::admin panel', function () {
    $panel = Filament::getPanel('notify::admin');

    $plugin = $panel->getPlugin('spatie-translatable');

    expect($plugin)
        ->toBeInstanceOf(SpatieTranslatablePlugin::class)
        ->and($plugin->getDefaultLocales())
        ->toContain('it', 'en');
});

test('locale switcher action exists in ListMailTemplates', function () {
    MailTemplate::factory()->count(3)->create();

    Livewire::test(ListMailTemplates::class)
        ->assertActionExists('locale_switcher');
});

test('ListMailTemplates renders without plugin registration error', function () {
    MailTemplate::factory()->count(3)->create();

    Livewire::test(ListMailTemplates::class)
        ->assertSuccessful()
        ->assertCanSeeTableRecords(MailTemplate::all());
});
