<?php

declare(strict_types=1);

use Filament\Support\RawJs;
use Modules\Xot\Actions\Arr\DiffAssocRecursiveAction as ArrDiffAssocRecursiveAction;
use Modules\Xot\Actions\Arr\RangeIntersectAction as ArrRangeIntersectAction;
use Modules\Xot\Actions\Arr\SaveArrayAction as ArrSaveArrayAction;
use Modules\Xot\Actions\Arr\SaveJsonArrayAction as ArrSaveJsonArrayAction;
use Modules\Xot\Actions\Arr\SavePhpArrayAction as ArrSavePhpArrayAction;
use Modules\Xot\Actions\Array\ArrayToRawJsAction;
use Modules\Xot\Actions\Array\DiffAssocRecursiveAction as ArrayDiffAssocRecursiveAction;
use Modules\Xot\Actions\Array\RangeIntersectAction as ArrayRangeIntersectAction;
use Modules\Xot\Actions\Array\SaveJsonArrayAction as ArraySaveJsonArrayAction;
use Modules\Xot\Actions\Array\SavePhpArrayAction as ArraySavePhpArrayAction;

it('normalizes nested numeric strings in diff fixType for Arr namespace', function (): void {
    $input = [
        ['a' => '1', 'b' => 'x'],
        ['c' => '2.5'],
    ];

    $normalized = ArrDiffAssocRecursiveAction::fixType($input);

    expect($normalized)->toBe([
        ['a' => 1, 'b' => 'x'],
        ['c' => 2.5],
    ]);
});

it('throws when fixType receives a non-array item for Arr namespace', function (): void {
    ArrDiffAssocRecursiveAction::fixType([['ok' => '1'], 'invalid']);
})->throws(Exception::class);

it('returns recursive diff in Arr namespace', function (): void {
    $action = new ArrDiffAssocRecursiveAction;
    $left = [
        ['id' => '1', 'name' => 'a'],
        ['id' => '2', 'name' => 'b'],
    ];
    $right = [
        ['id' => 2, 'name' => 'b'],
    ];

    expect($action->execute($left, $right))->toBe([
        ['id' => 1, 'name' => 'a'],
    ]);
});

it('normalizes nested numeric strings in diff fixType for Array namespace', function (): void {
    $input = [
        ['a' => '10', 'b' => 'x'],
    ];

    $normalized = ArrayDiffAssocRecursiveAction::fixType($input);

    expect($normalized)->toBe([
        ['a' => 10, 'b' => 'x'],
    ]);
});

it('throws when fixType receives a non-array item for Array namespace', function (): void {
    ArrayDiffAssocRecursiveAction::fixType([123]);
})->throws(Exception::class);

it('returns recursive diff in Array namespace', function (): void {
    $action = new ArrayDiffAssocRecursiveAction;
    $left = [
        ['id' => '1', 'name' => 'alpha'],
        ['id' => '2', 'name' => 'beta'],
    ];
    $right = [
        ['id' => 1, 'name' => 'alpha'],
    ];

    expect($action->execute($left, $right))->toBe([
        1 => ['id' => 2, 'name' => 'beta'],
    ]);
});

it('covers all branches of range intersect in Arr namespace', function (): void {
    $action = new ArrRangeIntersectAction;

    expect($action->execute(1, 5, 2, 7))->toBe([2, 5])
        ->and($action->execute(2, 5, 1, 7))->toBe([2, 5])
        ->and($action->execute(1, 7, 2, 5))->toBe([2, 5])
        ->and($action->execute(1, 2, 3, 4))->toBeFalse()
        ->and($action->execute(10, 11, 1, 5))->toBeFalse()
        ->and($action->execute(7, 6, 5, 8))->toBeFalse()
        ->and($action->execute(4, 10, 2, 4))->toBe([4, 4]);
});

it('covers all branches of range intersect in Array namespace', function (): void {
    $action = new ArrayRangeIntersectAction;

    expect($action->execute(1, 5, 2, 7))->toBe([2, 5])
        ->and($action->execute(2, 5, 1, 7))->toBe([2, 5])
        ->and($action->execute(1, 7, 2, 5))->toBe([2, 5])
        ->and($action->execute(1, 2, 3, 4))->toBeFalse()
        ->and($action->execute(10, 11, 1, 5))->toBeFalse()
        ->and($action->execute(7, 6, 5, 8))->toBeFalse()
        ->and($action->execute(4, 10, 2, 4))->toBe([4, 4]);
});

it('writes JSON and PHP arrays via Arr actions', function (): void {
    $tmpDir = sys_get_temp_dir().'/xot-arr-actions-'.uniqid('', true);
    mkdir($tmpDir, 0777, true);

    $jsonFile = $tmpDir.'/data.json';
    $phpFile = $tmpDir.'/data.php';

    $jsonAction = new ArrSaveJsonArrayAction;
    $phpAction = new ArrSavePhpArrayAction;

    expect($jsonAction->execute(['a' => 1], $jsonFile))->toBeTrue()
        ->and(file_exists($jsonFile))->toBeTrue()
        ->and((string) file_get_contents($jsonFile))->toContain('"a"')
        ->and($phpAction->execute(['b' => 2], $phpFile))->toBeTrue()
        ->and(file_exists($phpFile))->toBeTrue()
        ->and((string) file_get_contents($phpFile))->toContain('return');
});

it('writes JSON and PHP arrays via Array actions', function (): void {
    $tmpDir = sys_get_temp_dir().'/xot-array-actions-'.uniqid('', true);
    mkdir($tmpDir, 0777, true);

    $jsonFile = $tmpDir.'/data.json';
    $phpFile = $tmpDir.'/data.php';

    $jsonAction = new ArraySaveJsonArrayAction;
    $phpAction = new ArraySavePhpArrayAction;

    expect($jsonAction->execute(['a' => 1], $jsonFile))->toBeTrue()
        ->and(file_exists($jsonFile))->toBeTrue()
        ->and((string) file_get_contents($jsonFile))->toContain('"a"')
        ->and($phpAction->execute(['b' => 2], $phpFile))->toBeTrue()
        ->and(file_exists($phpFile))->toBeTrue()
        ->and((string) file_get_contents($phpFile))->toContain('return');
});

it('dispatches save strategy by format in SaveArrayAction', function (): void {
    $tmpDir = sys_get_temp_dir().'/xot-save-array-action-'.uniqid('', true);
    mkdir($tmpDir, 0777, true);

    $action = new ArrSaveArrayAction;
    $jsonFile = $tmpDir.'/one.json';
    $phpFile = $tmpDir.'/one.php';

    expect($action->execute(['x' => 1], $jsonFile, 'json'))->toBeTrue()
        ->and($action->execute(['y' => 2], $phpFile, 'php'))->toBeTrue();
});

it('throws on unsupported save format in SaveArrayAction', function (): void {
    $action = new ArrSaveArrayAction;
    $action->execute(['x' => 1], '/tmp/unused', 'xml');
})->throws(InvalidArgumentException::class);

it('converts mixed PHP arrays to RawJs correctly', function (): void {
    $action = new ArrayToRawJsAction;

    $raw = $action->execute([
        'validKey' => true,
        'string key' => "O'Reilly",
        'number' => 12.5,
        'none' => null,
        'nested' => [
            'inner' => 1,
            'formatter' => RawJs::make('value => value * 2'),
        ],
    ]);

    expect($raw)->toBeInstanceOf(RawJs::class);

    $js = $raw->toHtml();
    expect($js)->toContain('validKey: true')
        ->and($js)->toContain("'string key': 'O\\'Reilly'")
        ->and($js)->toContain('number: 12.5')
        ->and($js)->toContain('none: null')
        ->and($js)->toContain('formatter: value => value * 2');
});
