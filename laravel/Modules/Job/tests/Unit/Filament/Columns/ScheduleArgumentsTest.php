<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit\Filament\Columns;

use Modules\Job\Tests\Fixtures\ScheduleArgumentsProbe;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('ScheduleArguments::getTags()', function (): void {
    test('con stato ad array e withValue scarta le voci senza valore', function (): void {
        $column = ScheduleArgumentsProbe::make('arguments');
        $column->fakeState = [
            'primo' => ['name' => 'uno', 'value' => '1'],
            'senza' => ['name' => 'due', 'value' => null],
            'vuoto' => ['name' => 'tre', 'value' => ''],
        ];

        Assert::assertSame(['uno=1'], $column->getTags());
    });

    test('con withValue usa il name della voce, non la chiave dell array', function (): void {
        $column = ScheduleArgumentsProbe::make('arguments');
        $column->fakeState = ['chiave-ignorata' => ['name' => 'etichetta', 'value' => 'v']];

        Assert::assertSame(['etichetta=v'], $column->getTags());
    });

    test('con withValue e voce senza name ricade sulla chiave', function (): void {
        $column = ScheduleArgumentsProbe::make('arguments');
        $column->fakeState = ['fallback' => ['value' => 'v']];

        Assert::assertSame(['fallback=v'], $column->getTags());
    });

    test('senza withValue formatta ogni coppia come chiave=valore', function (): void {
        $column = ScheduleArgumentsProbe::make('arguments');
        $column->fakeState = ['x' => 'primo', 'y' => 'secondo'];
        $column->withValue(false);

        Assert::assertSame(['x=primo', 'y=secondo'], $column->getTags());
    });

    test('senza withValue non filtra nulla, nemmeno i valori vuoti', function (): void {
        $column = ScheduleArgumentsProbe::make('arguments');
        $column->fakeState = ['x' => '', 'y' => 'pieno'];
        $column->withValue(false);

        Assert::assertSame(['x=', 'y=pieno'], $column->getTags());
    });

    test('con stato a stringa spacca sul separatore', function (): void {
        $column = ScheduleArgumentsProbe::make('arguments');
        $column->fakeState = 'uno,due,tre';
        $column->separator(',');

        Assert::assertSame(['uno', 'due', 'tre'], $column->getTags());
    });

    test('una stringa vuota col separatore non produce un tag vuoto', function (): void {
        $column = ScheduleArgumentsProbe::make('arguments');
        $column->fakeState = '';
        $column->separator(',');

        Assert::assertSame([], $column->getTags());
    });

    test('senza separatore lo stato a stringa non viene interpretato', function (): void {
        $column = ScheduleArgumentsProbe::make('arguments');
        $column->fakeState = 'uno,due';

        Assert::assertSame([], $column->getTags());
    });

    test('un solo elemento non vuoto sopravvive al filtro', function (): void {
        $column = ScheduleArgumentsProbe::make('arguments');
        $column->fakeState = 'solo';
        $column->separator(',');

        Assert::assertSame(['solo'], $column->getTags());
    });
});

describe('ScheduleArguments::withValue()', function (): void {
    test('restituisce la colonna per permettere la catena fluente', function (): void {
        $column = ScheduleArgumentsProbe::make('arguments');

        Assert::assertSame($column, $column->withValue(false));
    });

    test('chiamata senza argomenti riattiva il filtro sui valori', function (): void {
        $column = ScheduleArgumentsProbe::make('arguments');
        $column->fakeState = ['k' => ['name' => 'n', 'value' => null]];
        $column->withValue(false);
        $column->withValue();

        Assert::assertSame([], $column->getTags());
    });
});
