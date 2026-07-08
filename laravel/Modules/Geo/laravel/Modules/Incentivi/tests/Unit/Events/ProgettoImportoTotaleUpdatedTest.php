<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Events;

use Modules\Incentivi\Events\ProgettoImportoTotaleUpdated;
use Modules\Incentivi\Tests\TestCase;

uses(TestCase::class);

test('event can be created', function () {
    $event = new ProgettoImportoTotaleUpdated(1, 100000);

    expect($event)->toBeInstanceOf(ProgettoImportoTotaleUpdated::class);
});

test('event stores project id correctly', function () {
    $projectId = 123;
    $importoTotale = 250000;

    $event = new ProgettoImportoTotaleUpdated($projectId, $importoTotale);

    expect($event->projectId)->toBe($projectId);
});

test('event stores importo totale correctly', function () {
    $projectId = 456;
    $importoTotale = 500000;

    $event = new ProgettoImportoTotaleUpdated($projectId, $importoTotale);

    expect($event->importoTotale)->toBe($importoTotale);
});

test('event extends ShouldBeStored', function () {
    $event = new ProgettoImportoTotaleUpdated(1, 100000);

    expect($event)->toBeInstanceOf(\Spatie\EventSourcing\StoredEvents\ShouldBeStored::class);
});

test('event handles zero importo', function () {
    $event = new ProgettoImportoTotaleUpdated(1, 0);

    expect($event->projectId)->toBe(1)
        ->and($event->importoTotale)->toBe(0);
});

test('event handles large importo values', function () {
    $largeImporto = 10000000;
    $event = new ProgettoImportoTotaleUpdated(999, $largeImporto);

    expect($event->projectId)->toBe(999)
        ->and($event->importoTotale)->toBe($largeImporto);
});
