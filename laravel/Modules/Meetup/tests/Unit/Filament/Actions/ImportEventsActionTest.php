<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Filament\Actions;

use Modules\Meetup\Actions\Event\ImportEventsFromJsonAction;
use Modules\Meetup\Filament\Actions\ImportEventsAction;
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

test('it has no badge and is shown only in the local environment', function () {
    // Importa eventi DI ESEMPIO: in produzione non deve comparire, e il conteggio eventi sul pulsante confondeva.
    $action = ImportEventsAction::make();

    expect($action->getBadge())->toBeNull()
        ->and($action->isVisible())->toBe(app()->environment('local'));
});

test('it executes the import action and sends notification', function () {
    $this->mock(ImportEventsFromJsonAction::class)
        ->shouldReceive('execute')
        ->once()
        ->andReturn(5);

    $action = ImportEventsAction::make();

    expect(fn () => $action->call())->not->toThrow(\Throwable::class);
});
