<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Filament\TableFilters;

use Modules\Meetup\Filament\TableFilters\EventStartDateFilter;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('it can instantiate event start date filter', function () {
    $filter = EventStartDateFilter::make();
    
    expect($filter)->toBeInstanceOf(EventStartDateFilter::class)
        ->and($filter->getName())->toBe('start_date');
});

test('it applies from and until constraints to query', function () {
    $filter = EventStartDateFilter::make();
    $query = Event::query();

    $filter->apply($query, [
        'isActive' => true,
        'from' => '2026-01-01',
        'until' => '2026-01-31',
    ]);

    $sql = $query->toSql();
    $bindings = $query->getBindings();

    expect($sql)->toContain('start_date')
        ->and($bindings)->toContain('2026-01-01')
        ->and($bindings)->toContain('2026-01-31');
});
