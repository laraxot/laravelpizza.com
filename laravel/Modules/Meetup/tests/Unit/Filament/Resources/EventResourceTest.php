<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Filament\Resources;

use Modules\Meetup\Filament\Resources\EventResource;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('it uses correct model', function () {
    expect(EventResource::getModel())->toBe(Event::class);
});

test('it has form schema', function () {
    $schema = EventResource::getFormSchema();
    expect($schema)->toBeArray()
        ->and(isset($schema['event_details']))->toBeTrue();
});
