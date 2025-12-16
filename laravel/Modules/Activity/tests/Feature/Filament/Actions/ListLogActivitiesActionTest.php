<?php

declare(strict_types=1);

use Modules\Activity\Filament\Actions\ListLogActivitiesAction;
use Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource;
use Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages\ListIndennitaResponsabilitas;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\Xot\Datas\XotData;

use function Pest\Laravel\actingAs;

/**
 * Test per ListLogActivitiesAction.
 *
 * Verifica il corretto funzionamento dell'action per visualizzare
 * lo storico delle attività di un record.
 */
beforeEach(function () {
    $userClass = XotData::make()->getUserClass();
    $this->user = $userClass::factory()->create();
});

test('action has correct default name', function () {
    expect(ListLogActivitiesAction::getDefaultName())
        ->toBe('list_log_activities');
});

test('action is configured correctly', function () {
    $action = ListLogActivitiesAction::make();

    expect($action->getName())
        ->toBe('list_log_activities');
});

test('action is visible in table actions', function () {
    actingAs($this->user);

    $record = IndennitaResponsabilita::factory()
        ->has(activity()->factory()->count(3))
        ->create();

    livewire(ListIndennitaResponsabilitas::class)
        ->assertTableActionExists('list_log_activities');
});

test('action generates correct URL for activity log page', function () {
    actingAs($this->user);

    $record = IndennitaResponsabilita::factory()->create();

    $expectedUrl = IndennitaResponsabilitaResource::getUrl('log-activity', ['record' => $record]);

    livewire(ListIndennitaResponsabilitas::class)
        ->assertTableActionHasUrl('list_log_activities', $expectedUrl, record: $record);
});

test('action is visible only when record has activities', function () {
    actingAs($this->user);

    $recordWithActivities = IndennitaResponsabilita::factory()
        ->has(activity()->factory()->count(2))
        ->create();

    $recordWithoutActivities = IndennitaResponsabilita::factory()->create();

    livewire(ListIndennitaResponsabilitas::class)
        ->assertTableActionVisible('list_log_activities', record: $recordWithActivities)
        ->assertTableActionHidden('list_log_activities', record: $recordWithoutActivities);
});

test('action tooltip is translated correctly', function () {
    actingAs($this->user);

    $record = IndennitaResponsabilita::factory()
        ->has(activity()->factory())
        ->create();

    livewire(ListIndennitaResponsabilitas::class)
        ->assertTableActionHasTooltip(
            'list_log_activities',
            __('activity::actions.list_log_activities.tooltip'),
            record: $record
        );
});

test('action uses correct icon', function () {
    $action = ListLogActivitiesAction::make();

    expect($action->getIcon())
        ->toBe('heroicon-o-clock');
});

test('action uses gray color for non-invasive UI', function () {
    $action = ListLogActivitiesAction::make();

    expect($action->getColor())
        ->toBe('gray');
});
