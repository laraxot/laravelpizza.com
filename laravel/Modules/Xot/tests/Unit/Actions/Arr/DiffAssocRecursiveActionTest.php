<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Arr;

use Modules\Xot\Actions\Arr\DiffAssocRecursiveAction;
use Tests\TestCase;

uses(TestCase::class);

test('diff assoc recursive action works correctly', function () {
    $arr1 = [
        'a' => ['id' => 1, 'name' => 'Test'],
        'b' => ['id' => 2, 'name' => 'Test 2'],
    ];
    $arr2 = [
        'a' => ['id' => 1, 'name' => 'Test'],
    ];

    $action = app(DiffAssocRecursiveAction::class);
    $result = $action->execute($arr1, $arr2);

    expect($result)->toHaveCount(1)
        ->and($result)->toHaveKey('b')
        ->and($result['b'])->toBe(['id' => 2, 'name' => 'Test 2']);
});

test('diff assoc recursive action handles numeric strings', function () {
    $arr1 = [
        'a' => ['id' => '1', 'name' => 'Test'],
    ];
    $arr2 = [
        'a' => ['id' => 1, 'name' => 'Test'],
    ];

    $action = app(DiffAssocRecursiveAction::class);
    $result = $action->execute($arr1, $arr2);

    // fixType converts '1' to 1, so they should be equal and diff should be empty
    expect($result)->toBeEmpty();
});

test('diff assoc recursive action throws exception for non-array item', function () {
    $arr1 = [
        'a' => 'not an array',
    ];

    $action = app(DiffAssocRecursiveAction::class);
    expect(fn () => $action->execute($arr1, []))->toThrow(\Exception::class);
});
