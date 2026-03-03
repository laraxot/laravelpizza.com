<?php

declare(strict_types=1);

use Modules\Xot\Actions\Arr\DiffAssocRecursiveAction;

beforeEach(function (): void {
    $this->action = app(DiffAssocRecursiveAction::class);
});

it('returns elements from arr_1 not in arr_2', function (): void {
    $arr1 = [['id' => 1, 'name' => 'a'], ['id' => 2, 'name' => 'b']];
    $arr2 = [['id' => 1, 'name' => 'a']];

    $result = $this->action->execute($arr1, $arr2);

    expect($result)->toBeArray()->toHaveCount(1);
    expect($result)->toContain(['id' => 2, 'name' => 'b']);
});

it('returns empty array when arr_1 equals arr_2', function (): void {
    $arr = [['id' => 1, 'name' => 'a']];
    $result = $this->action->execute($arr, $arr);

    expect($result)->toBeArray()->toBeEmpty();
});

it('returns all elements when arr_2 is empty', function (): void {
    $arr1 = [['id' => 1], ['id' => 2]];
    $arr2 = [];

    $result = $this->action->execute($arr1, $arr2);

    expect($result)->toBeArray()->toHaveCount(2);
});

it('fixType converts numeric strings to numbers', function (): void {
    $data = [['id' => '1', 'count' => '42']];
    $result = DiffAssocRecursiveAction::fixType($data);

    expect($result)->toBe([['id' => 1, 'count' => 42]]);
});

it('fixType throws when item is not array', function (): void {
    $data = [['id' => 1], 'not-array'];

    expect(fn () => DiffAssocRecursiveAction::fixType($data))
        ->toThrow(Exception::class);
});
