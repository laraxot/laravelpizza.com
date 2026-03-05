<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Filament\TableFilters;

use Modules\Meetup\Filament\TableFilters\EventStartDateFilter;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('it can instantiate event start date filter', function () {
    $filter = EventStartDateFilter::make();
    
    expect($filter)->toBeInstanceOf(EventStartDateFilter::class)
        ->and($filter->getName())->toBe('start_date');
});
