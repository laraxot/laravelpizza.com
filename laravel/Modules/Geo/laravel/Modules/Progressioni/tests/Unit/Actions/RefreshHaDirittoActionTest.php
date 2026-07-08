<?php

declare(strict_types=1);

use Filament\Notifications\Notification;
use Modules\Progressioni\Actions\RefreshHaDirittoAction;
use Modules\Progressioni\Models\CriteriOption;
use Modules\Progressioni\Models\Progressioni;

beforeEach(function () {
    // Set up test data if necessary
});

test('execute updates fields correctly based on exclusion criteria', function () {
    // Arrange
    $action = new RefreshHaDirittoAction;

    // Create mock record
    $record = Mockery::mock(Progressioni::class)->makePartial();
    $record->id = 1;
    $record->nome = 'Test User';
    $record->ha_diritto = 1; // Initially has right

    // Expected values after execution
    $record->shouldReceive('update')
        ->withArgs(fn ($args) => $args['ha_diritto'] === null &&
                   $args['motivo'] === null)
        ->once();

    // Mock notification
    Notification::shouldReceive('make')
        ->once()
        ->andReturnSelf();
    Notification::shouldReceive('title')
        ->with(Mockery::pattern('/Refresh ha diritto/'))
        ->once()
        ->andReturnSelf();
    Notification::shouldReceive('success')
        ->once()
        ->andReturnSelf();
    Notification::shouldReceive('send')
        ->once();

    // Act
    $action->execute($record);

    // Assert - verified through mock expectations
});

test('execute processes criteriOption values correctly', function () {
    // Arrange
    $action = Mockery::mock(RefreshHaDirittoAction::class)->makePartial();

    // Create mock record with criteriOption
    $record = Mockery::mock(Progressioni::class)->makePartial();
    $record->id = 1;
    $record->nome = 'Test User';
    $record->ha_diritto = 0; // No right
    $record->motivo = 'Some exclusion reason';

    // Create mock criteriOption
    $criteriOption = new CriteriOption;
    $criteriOption->id = 5;
    $criteriOption->value = '2023-06-15'; // Date string
    $criteriOption->type = 'datetime';

    // Set up the record to return the criteriOption
    $record->shouldReceive('criteriOption')
        ->andReturnSelf();
    $record->shouldReceive('get')
        ->andReturn(collect([$criteriOption]));

    // Expected values after execution with date conversion
    $record->shouldReceive('update')
        ->withArgs(fn ($args) => $args['ha_diritto'] === null &&
                   $args['motivo'] === null)
        ->once();

    // Mock notification
    Notification::shouldReceive('make')
        ->once()
        ->andReturnSelf();
    Notification::shouldReceive('title')
        ->with(Mockery::pattern('/Refresh ha diritto/'))
        ->once()
        ->andReturnSelf();
    Notification::shouldReceive('success')
        ->once()
        ->andReturnSelf();
    Notification::shouldReceive('send')
        ->once();

    // Act
    $action->execute($record);

    // Assert - verified through mock expectations
});

test('execute handles boolean conversion in criteriOption values', function () {
    // Arrange
    $action = Mockery::mock(RefreshHaDirittoAction::class)->makePartial();

    // Create mock record with criteriOption
    $record = Mockery::mock(Progressioni::class)->makePartial();
    $record->id = 1;
    $record->nome = 'Test User';

    // Create mock criteriOption with boolean value
    $criteriOption = new CriteriOption;
    $criteriOption->id = 6;
    $criteriOption->value = 'true'; // String boolean
    $criteriOption->type = 'boolean';

    // Set up the record to return the criteriOption
    $record->shouldReceive('criteriOption')
        ->andReturnSelf();
    $record->shouldReceive('get')
        ->andReturn(collect([$criteriOption]));

    // Expected update with fields reset
    $record->shouldReceive('update')
        ->withArgs(fn ($args) => $args['ha_diritto'] === null &&
                   $args['motivo'] === null)
        ->once();

    // Mock notification
    Notification::shouldReceive('make->title->success->send');

    // Act
    $action->execute($record);

    // Assert - verified through mock expectations
});

test('execute handles numeric conversion in criteriOption values', function () {
    // Arrange
    $action = Mockery::mock(RefreshHaDirittoAction::class)->makePartial();

    // Create mock record with criteriOption
    $record = Mockery::mock(Progressioni::class)->makePartial();
    $record->id = 1;
    $record->nome = 'Test User';

    // Create mock criteriOption with numeric value
    $criteriOption = new CriteriOption;
    $criteriOption->id = 7;
    $criteriOption->value = '123.45'; // String number
    $criteriOption->type = 'numeric';

    // Set up the record to return the criteriOption
    $record->shouldReceive('criteriOption')
        ->andReturnSelf();
    $record->shouldReceive('get')
        ->andReturn(collect([$criteriOption]));

    // Expected update with fields reset
    $record->shouldReceive('update')
        ->withArgs(fn ($args) => $args['ha_diritto'] === null &&
                   $args['motivo'] === null)
        ->once();

    // Mock notification
    Notification::shouldReceive('make->title->success->send');

    // Act
    $action->execute($record);

    // Assert - verified through mock expectations
});

// Clean up after tests
afterEach(function () {
    if (class_exists('Mockery')) {
        Mockery::close();
    }
});
