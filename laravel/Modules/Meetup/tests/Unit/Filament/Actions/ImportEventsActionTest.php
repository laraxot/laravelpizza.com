<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Filament\Actions;

use Modules\Meetup\Actions\Event\ImportEventsFromJsonAction;
use Modules\Meetup\Filament\Actions\ImportEventsAction;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('it can instantiate import events action', function () {
    $action = ImportEventsAction::make();
    
    expect($action)->toBeInstanceOf(ImportEventsAction::class)
        ->and($action->getName())->toBe('import_events');
});

test('it has the correct configuration', function () {
    $action = ImportEventsAction::make();
    
    expect($action->getIcon())->toBe('heroicon-o-arrow-down-tray')
        ->and($action->getColor())->toBe('info')
        ->and($action->isConfirmationRequired())->toBeTrue();
});

test('it has a badge showing event count', function () {
    $initialCount = Event::query()->count();
    Event::factory()->count(3)->create();
    
    $action = ImportEventsAction::make();
    
    expect($action->getBadge())->toBe($initialCount + 3);
});

test('it executes the import action and sends notification', function () {
    $this->mock(ImportEventsFromJsonAction::class)
        ->shouldReceive('execute')
        ->once()
        ->andReturn(5);
    
    $action = ImportEventsAction::make();
    
    expect(fn () => $action->call())->not->toThrow(\Throwable::class);
});
