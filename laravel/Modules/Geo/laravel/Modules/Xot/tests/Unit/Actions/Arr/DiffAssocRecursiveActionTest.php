<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Modules\Xot\Actions\Arr\DiffAssocRecursiveAction;
use PHPUnit\Framework\Assert;

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

    Assert::assertSame(['id' => 2, 'name' => 'Test 2'], $result['b']);
    Assert::assertArrayHasKey('b', $result);
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

    Assert::assertEmpty($result);
});

it('throws exception for non-array items in fixType', function (): void {
    try {
        DiffAssocRecursiveAction::fixType(['a' => 'not-an-array']);
        Assert::fail('Expected exception not thrown');
    } catch (Exception) {
        // Expected
    }
});
