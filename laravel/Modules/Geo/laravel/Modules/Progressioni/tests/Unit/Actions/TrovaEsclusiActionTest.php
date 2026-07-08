<?php

declare(strict_types=1);

use Modules\Progressioni\Actions\TrovaEsclusiAction;
use Modules\Progressioni\Models\CriteriEsclusione;
use Modules\Progressioni\Models\CriteriOption;
use Modules\Progressioni\Models\Progressioni;

beforeEach(function () {
    // Set up test data if necessary
});

test('execute processes exclusion criteria correctly', function () {
    // Arrange
    $action = Mockery::mock(TrovaEsclusiAction::class)->makePartial();

    $year = 2023;
    $data = ['anno' => $year];

    // Mock progressioni records that should be processed
    $mockRecords = collect([
        Mockery::mock(Progressioni::class),
        Mockery::mock(Progressioni::class),
    ]);

    // Mock the query to return our test records
    $mockQuery = Mockery::mock('query');
    $mockQuery->shouldReceive('whereNull')->with('motivo')->andReturnSelf();
    $mockQuery->shouldReceive('whereIn')->with('ha_diritto', [1, null])->andReturnSelf();
    $mockQuery->shouldReceive('get')->andReturn($mockRecords);

    Progressioni::shouldReceive('where')
        ->with('anno', $year)
        ->andReturn($mockQuery);

    // Mock the criteria exclusion records
    $mockCriterio = new CriteriEsclusione;
    $mockCriterio->id = 1;
    $mockCriterio->cod = 'E1';
    $mockCriterio->label = 'Test Criteria';

    // Mock the criteria options
    $mockOption = new CriteriOption;
    $mockOption->criteri_esclusione_id = 1;
    $mockOption->label = 'Test Option';
    $mockOption->value = 'testValue';

    // Set up expectations for the check methods to be called
    $action->shouldReceive('checkCriteriOption')
        ->with(Mockery::type(Progressioni::class), Mockery::type(CriteriOption::class), $year)
        ->andReturn(true) // First record fails the check (should be excluded)
        ->once();

    $action->shouldReceive('checkCriteriOption')
        ->with(Mockery::type(Progressioni::class), Mockery::type(CriteriOption::class), $year)
        ->andReturn(false) // Second record passes the check (should not be excluded)
        ->once();

    // Records should be updated according to check results
    $mockRecords[0]->shouldReceive('update')
        ->with(['ha_diritto' => 0, 'motivo' => 'Test Criteria: Test Option'])
        ->once();

    $mockRecords[1]->shouldNotReceive('update');

    // Mock criteria retrieval
    CriteriEsclusione::shouldReceive('with')
        ->with('criteriOption')
        ->andReturnSelf();

    CriteriEsclusione::shouldReceive('get')
        ->andReturn(collect([$mockCriterio]));

    // Mock the criteriOption relationship on the criteria
    $mockCriterio->criteriOption = collect([$mockOption]);

    // Act
    $action->execute($data);

    // Assert - verified through mock expectations
});

test('checkCriteriOption correctly processes boolean value', function () {
    // Arrange
    $action = new TrovaEsclusiAction;

    $progressioni = Mockery::mock(Progressioni::class);

    // Create a criteria option with boolean value
    $option = new CriteriOption;
    $option->value = 'true'; // String 'true' should be converted to boolean

    // Mock the method that would be called by checkCriteriOption
    $action = Mockery::mock(TrovaEsclusiAction::class)->makePartial();
    $action->shouldReceive('check_boolean')
        ->with($progressioni, true, 2023)
        ->andReturn(true)
        ->once();

    // Act
    $result = $action->checkCriteriOption($progressioni, $option, 2023);

    // Assert
    expect($result)->toBeTrue();
});

test('checkCriteriOption correctly processes datetime value', function () {
    // Arrange
    $action = new TrovaEsclusiAction;

    $progressioni = Mockery::mock(Progressioni::class);

    // Create a criteria option with date value
    $option = new CriteriOption;
    $option->value = '2023-01-01'; // String date should be parsed
    $option->type = 'datetime'; // Specify type as datetime

    // Mock the method that would be called by checkCriteriOption
    $action = Mockery::mock(TrovaEsclusiAction::class)->makePartial();
    $action->shouldReceive('check_datetime')
        ->andReturn(true)
        ->once();

    // Act
    $result = $action->checkCriteriOption($progressioni, $option, 2023);

    // Assert
    expect($result)->toBeTrue();
});

test('check_datetime compares dates correctly', function () {
    // This would be an implementation test with real dates
    // For now, we'll do a simpler test of the method

    $action = new TrovaEsclusiAction;

    // Create test progressioni record
    $progressioni = Mockery::mock(Progressioni::class);
    $progressioni->data_assunzione = '2020-01-01'; // Earlier than threshold

    // Create a date threshold that's later
    $dateThreshold = '2022-01-01';

    // The check should return true (excluded) if assunzione date is before threshold
    $operator = '<';
    $year = 2023;

    // Make the method accessible for testing
    $reflectionClass = new ReflectionClass(TrovaEsclusiAction::class);
    $method = $reflectionClass->getMethod('check_datetime');
    $method->setAccessible(true);

    // Act - this should return true (exclude) since 2020-01-01 < 2022-01-01
    $result = $method->invoke($action, $progressioni, $dateThreshold, $operator, $year);

    // Assert
    expect($result)->toBeTrue();

    // Now test the opposite case
    $progressioni->data_assunzione = '2023-01-01'; // Later than threshold

    // Act - this should return false (don't exclude) since 2023-01-01 !< 2022-01-01
    $result = $method->invoke($action, $progressioni, $dateThreshold, $operator, $year);

    // Assert
    expect($result)->toBeFalse();
});

test('check_boolean evaluates condition correctly', function () {
    $action = new TrovaEsclusiAction;

    // Create test progressioni record
    $progressioni = Mockery::mock(Progressioni::class);
    $progressioni->has_assenze_lunghe = true;

    // Make the method accessible for testing
    $reflectionClass = new ReflectionClass(TrovaEsclusiAction::class);
    $method = $reflectionClass->getMethod('check_boolean');
    $method->setAccessible(true);

    // Test true condition
    $result = $method->invoke($action, $progressioni, true, 2023);
    expect($result)->toBeTrue();

    // Test false condition
    $progressioni->has_assenze_lunghe = false;
    $result = $method->invoke($action, $progressioni, true, 2023);
    expect($result)->toBeFalse();
});

// Clean up after tests
afterEach(function () {
    if (class_exists('Mockery')) {
        Mockery::close();
    }
});
