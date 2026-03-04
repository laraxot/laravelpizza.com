<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Collection;

use Illuminate\Support\Facades\Lang;
use Modules\Xot\Actions\Collection\TransCollectionAction;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

it('translates collection items correctly', function (): void {
    $collection = collect(['apple', 'banana', 'orange.juice']);
    $transKey = 'fruits';

    Lang::addLines([
        'fruits.apple' => 'Mela',
        'fruits.banana' => 'Banana',
        'fruits.orange_juice' => 'Spremuta d\'arancia',
    ], 'it');

    app()->setLocale('it');

    $action = app(TransCollectionAction::class);
    $result = $action->execute($collection, $transKey);

    expect($result->all())->toBe([
        'Mela',
        'Banana',
        'Spremuta d\'arancia',
    ]);
});

it('returns original items if transKey is null', function (): void {
    $collection = collect(['a', 1, null]);
    $action = app(TransCollectionAction::class);
    $result = $action->execute($collection, null);

    expect($result->all())->toBe(['a', '1', '']);
});

it('returns original item if translation not found', function (): void {
    $collection = collect(['unknown']);
    $action = app(TransCollectionAction::class);
    $result = $action->execute($collection, 'missing');

    expect($result->all())->toBe(['unknown']);
});
