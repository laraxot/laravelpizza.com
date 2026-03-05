<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Filament\Resources;

use Modules\Meetup\Filament\Resources\EventResource\Pages\CreateEvent;
use Modules\Meetup\Filament\Resources\EventResource\Pages\EditEvent;
use Modules\Meetup\Filament\Resources\EventResource\Pages\ListEvents;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('list events page can be instantiated', function () {
    $page = new ListEvents();
    expect($page)->toBeInstanceOf(ListEvents::class);
});

test('create event page can be instantiated', function () {
    $page = new CreateEvent();
    expect($page)->toBeInstanceOf(CreateEvent::class);
});

test('edit event page can be instantiated', function () {
    $page = new EditEvent();
    expect($page)->toBeInstanceOf(EditEvent::class);
});
