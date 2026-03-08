<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Arr;

use Modules\Xot\Actions\Arr\DiffAssocRecursiveAction;


it('calculates recursive diff correctly', function (): void {
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

it('handles numeric strings in diff', function (): void {
    $arr1 = [
        'a' => ['id' => '1', 'name' => 'Test'],
    ];
    $arr2 = [
        'a' => ['id' => 1, 'name' => 'Test'],
    ];

    $action = app(DiffAssocRecursiveAction::class);
    $result = $action->execute($arr1, $arr2);

    // fixType converts '1' to 1, so they should be equal
    expect($result)->toBeEmpty();
});

it('throws exception for non-array items in fixType', function (): void {
    $data = ['a' => 'not-an-array'];

    expect(fn () => DiffAssocRecursiveAction::fixType($data))->toThrow(\Exception::class);
});
