<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Filament\TableFilters;

use Illuminate\Database\Eloquent\Builder;
use Modules\Meetup\Filament\TableFilters\EventStartDateFilter;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('it can instantiate event start date filter', function () {
    $filter = EventStartDateFilter::make();
    
    expect($filter)->toBeInstanceOf(EventStartDateFilter::class)
        ->and($filter->getName())->toBe('start_date');
});

test('it applies date filter to query', function () {
    $filter = EventStartDateFilter::make();
    $query = Event::query();
    
    // Use reflection to access internal modifyQueryUsing property
    $reflection = new \ReflectionClass($filter);
    // The property is defined in InteractsWithTableQuery trait
    $property = null;
    $currentClass = $reflection;
    while ($currentClass && !$property) {
        try {
            $property = $currentClass->getProperty('modifyQueryUsing');
        } catch (\ReflectionException $e) {
            $currentClass = $currentClass->getParentClass();
        }
    }
    
    if (!$property) {
        throw new \Exception('Could not find property modifyQueryUsing');
    }
    
    $property->setAccessible(true);
    $queryClosure = $property->getValue($filter);
    
    $data = [
        'from' => '2026-01-01',
        'until' => '2026-12-31',
    ];
    
    // In Filament evaluate is used, but we can call closure directly if it matches signature
    // In our filter: function (Builder $query, array $data): Builder
    $resultQuery = $queryClosure($query, $data);
    
    expect($resultQuery)->toBeInstanceOf(Builder::class);
    $sql = $resultQuery->toSql();
    expect($sql)->toContain('start_date');
});
