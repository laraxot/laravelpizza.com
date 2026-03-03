<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Collection;

use Modules\Xot\Actions\Collection\TransCollectionAction;
use Tests\TestCase;
use Illuminate\Support\Facades\Lang;

uses(TestCase::class);

test('trans collection action translates collection', function () {
    $collection = collect(['item1', 'item.2', 'no_trans']);
    $transKey = 'test';
    
    Lang::addLines([
        'test.item1' => 'Translated 1',
        'test.item_2' => 'Translated 2',
    ], 'it');
    
    app()->setLocale('it');
    
    $action = app(TransCollectionAction::class);
    $result = $action->execute($collection, $transKey);
    
    expect($result->get(0))->toBe('Translated 1')
        ->and($result->get(1))->toBe('Translated 2')
        ->and($result->get(2))->toBe('no_trans');
});

test('trans collection action handles null transKey', function () {
    $collection = collect(['item1', 123]);
    $action = app(TransCollectionAction::class);
    $result = $action->execute($collection, null);
    
    expect($result->get(0))->toBe('item1')
        ->and($result->get(1))->toBe('123');
});
