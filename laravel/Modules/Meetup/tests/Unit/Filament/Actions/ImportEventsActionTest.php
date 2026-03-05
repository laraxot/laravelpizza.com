<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Filament\Actions;

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
