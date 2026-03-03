<?php

declare(strict_types=1);

use Modules\Xot\Actions\Array\DiffAssocRecursiveAction;

beforeEach(function (): void {
    $this->action = app(DiffAssocRecursiveAction::class);
});

it('returns diff between arrays of rows', function (): void {
    $arr1 = [['id' => 1], ['id' => 2]];
    $arr2 = [['id' => 1]];
    $result = $this->action->execute($arr1, $arr2);
    expect($result)->toHaveCount(1)->toContain(['id' => 2]);
});

it('fixType throws when item is not array', function (): void {
    expect(fn () => DiffAssocRecursiveAction::fixType([['x' => 1], 'bad']))
        ->toThrow(Exception::class);
});

it('fixType converts numeric strings to numbers', function (): void {
    $result = DiffAssocRecursiveAction::fixType([['id' => '10', 'price' => '2.5']]);

    expect($result)->toBe([['id' => 10, 'price' => 2.5]]);
});
