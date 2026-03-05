<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Filament\Widgets;

use Filament\Tables\Table;
use Modules\Meetup\Filament\Widgets\RecentEventsWidget;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('it can instantiate recent events widget', function () {
    $widget = new RecentEventsWidget();
    expect($widget)->toBeInstanceOf(RecentEventsWidget::class);
});

test('it has correct heading', function () {
    $widget = new RecentEventsWidget();
    // Using reflection to check internal state if needed, 
    // but just checking it doesn't crash on table() call is good too.
    $table = $widget->table(new Table($widget));
    expect($table->getHeading())->toBe('Recent Events');
});
