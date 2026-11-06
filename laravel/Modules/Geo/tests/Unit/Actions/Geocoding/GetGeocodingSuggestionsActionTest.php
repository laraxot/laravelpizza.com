<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\Geocoding;

use Modules\Geo\Actions\Geocoding\GetGeocodingSuggestionsAction;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);

test('GetGeocodingSuggestionsAction returns an empty list for an empty query', function (): void {
    Assert::assertSame([], app(GetGeocodingSuggestionsAction::class)->execute(''));
});

test('GetGeocodingSuggestionsAction stub answers an empty list, never an error, whatever the query', function (string $query): void {
    Assert::assertSame([], app(GetGeocodingSuggestionsAction::class)->execute($query));
})->with([
    'indirizzo' => ['Via Roma'],
    'apostrofo e accento' => ["Piazza dell'Unità"],
    'stringa lunga' => [str_repeat('Milano ', 50)],
]);

it('SENZA SORGENTE: returns address suggestions for a valid query (the action is a stub that always returns [])')->todo();

it('SENZA SORGENTE: returns at most the requested number of suggestions (execute() has no limit parameter)')->todo();
