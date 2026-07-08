<?php

declare(strict_types=1);

use Modules\Progressioni\Tests\TestCase;

uses(TestCase::class);

use Filament\Facades\Filament;
use LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin;
use Livewire\Livewire;
use Modules\Notify\Models\MailTemplate;
use Modules\Progressioni\Filament\Resources\MailTemplateResource;
use Modules\Progressioni\Filament\Resources\MailTemplateResource\Pages\ListMailTemplates;
use Modules\Xot\Datas\XotData;

beforeEach(function () {
    $this->user = XotData::make()->getUserClass()::factory()->create();
    $this->user->assignRole('progressioni::admin');

    $this->actingAs($this->user);

    // Set panel corrente
    Filament::setCurrentPanel(
        Filament::getPanel('progressioni::admin')
    );
});

test('spatie-translatable plugin is registered in progressioni::admin panel', function () {
    $panel = Filament::getPanel('progressioni::admin');

    $plugin = $panel->getPlugin('spatie-translatable');

    expect($plugin)
        ->toBeInstanceOf(SpatieTranslatablePlugin::class);
});

test('MailTemplateResource is registered in progressioni panel', function () {
    $panel = Filament::getPanel('progressioni::admin');

    $resources = $panel->getResources();

    expect($resources)
        ->toContain(MailTemplateResource::class);
});

test('MailTemplateResource should register navigation', function () {
    expect(MailTemplateResource::shouldRegisterNavigation())
        ->toBeTrue();
});

test('MailTemplateResource has navigation properties', function () {
    expect(MailTemplateResource::getNavigationIcon())
        ->toBe('heroicon-o-envelope')
        ->and(MailTemplateResource::getNavigationGroup())
        ->toBe('Configurazione')
        ->and(MailTemplateResource::getNavigationSort())
        ->toBe(90);
});

test('MailTemplateResource filters only progressioni templates', function () {
    // Crea template per Progressioni
    $progressioniTemplate = MailTemplate::factory()->create([
        'slug' => 'progressioni-benvenuto',
        'mailable' => 'Modules\\Progressioni\\Mail\\WelcomeMail',
    ]);

    // Crea template per altri moduli
    $otherTemplate = MailTemplate::factory()->create([
        'slug' => 'notify-generale',
        'mailable' => 'Modules\\Notify\\Mail\\GenericMail',
    ]);

    // Query della resource
    $query = MailTemplateResource::getEloquentQuery();
    $results = $query->get();

    expect($results)
        ->toContain($progressioniTemplate)
        ->not->toContain($otherTemplate);
});

test('ListMailTemplates page renders successfully', function () {
    MailTemplate::factory()->count(3)->create([
        'slug' => 'progressioni-test',
    ]);

    Livewire::test(ListMailTemplates::class)
        ->assertSuccessful();
});
