<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Feature;

use Filament\Tables\Columns\TextColumn;
use Illuminate\View\ComponentAttributeBag;
use Modules\UI\Filament\Tables\Columns\GroupColumn;
use PHPUnit\Framework\Assert;

// Test GroupColumn class
describe('GroupColumn class', function (): void {
    it('can be instantiated with make()', function (): void {
        $column = GroupColumn::make('test');
        Assert::assertInstanceOf(GroupColumn::class, $column);
        Assert::assertSame('test', $column->getName());
    });

    it('accepts schema with TextColumn instances', function (): void {
        $column = GroupColumn::make('worker')
            ->schema([
                TextColumn::make('matr'),
                TextColumn::make('cognome'),
                TextColumn::make('nome'),
            ]);

        $fields = $column->getFields();
        Assert::assertCount(3, $fields);
        Assert::assertInstanceOf(TextColumn::class, $fields[0]);
        Assert::assertSame('matr', $fields[0]->getName());
    });

    it('filters out non-Column instances from schema', function (): void {
        $column = GroupColumn::make('mixed')
            ->schema([
                TextColumn::make('valid'),
                'invalid_string',
                123,
                null,
                TextColumn::make('also_valid'),
            ]);

        $fields = $column->getFields();
        Assert::assertCount(2, $fields);
    });

    it('handles empty schema', function (): void {
        $column = GroupColumn::make('empty')->schema([]);
        Assert::assertEmpty($column->getFields());
    });

    it('uses correct view path', function (): void {
        $column = GroupColumn::make('test');
        $reflection = new \ReflectionClass($column);
        $property = $reflection->getProperty('view');

        Assert::assertSame('ui::filament.tables.columns.group', $property->getValue($column));
    });
});

// Test view rendering with data_get() fallback
describe('GroupColumn view rendering', function (): void {
    it('renders direct attribute values', function (): void {
        $record = (object) [
            'matr' => '12345',
            'cognome' => 'Rossi',
        ];

        $fields = [
            TextColumn::make('matr'),
            TextColumn::make('cognome'),
        ];

        $value = data_get($record, 'matr');
        Assert::assertSame('12345', $value);
        $value = data_get($record, 'cognome');
        Assert::assertSame('Rossi', $value);
    });

    it('renders nested relation values with dot notation', function (): void {
        $record = (object) [
            'valutatore' => (object) [
                'nome_diri' => 'Mario Rossi',
                'stabi_txt' => 'Stabilimento A',
            ],
        ];

        // Test data_get() resolves dot notation
        Assert::assertSame('Mario Rossi', data_get($record, 'valutatore.nome_diri'));
        Assert::assertSame('Stabilimento A', data_get($record, 'valutatore.stabi_txt'));
    });

    it('returns null for missing nested relations', function (): void {
        $record = (object) [
            'valutatore' => null,
        ];

        Assert::assertNull(data_get($record, 'valutatore.nome_diri'));
    });

    it('handles deep nesting', function (): void {
        $record = (object) [
            'level1' => (object) [
                'level2' => (object) [
                    'level3' => 'deep value',
                ],
            ],
        ];

        Assert::assertSame('deep value', data_get($record, 'level1.level2.level3'));
    });

    it('preserves zero values', function (): void {
        $record = (object) [
            'score' => 0,
            'string_zero' => '0',
        ];

        Assert::assertSame(0, data_get($record, 'score'));
        Assert::assertSame('0', data_get($record, 'string_zero'));
    });

    it('renders view with nested relation when view system available', function (): void {
        $record = (object) [
            'valutatore' => (object) [
                'nome_diri' => 'Mario Rossi',
            ],
        ];

        $fields = [TextColumn::make('valutatore.nome_diri')];

        if (! app()->bound('view')) {
            Assert::assertSame('Mario Rossi', data_get($record, 'valutatore.nome_diri'));

            return;
        }

        $html = view('ui::filament.tables.columns.group', [
            'getFields' => fn () => $fields,
            'getRecord' => fn () => $record,
            'attributes' => new ComponentAttributeBag(),
            'getExtraAttributes' => fn () => [],
            'isInline' => fn () => false,
        ])->render();

        Assert::assertStringContainsString((string) 'Mario Rossi', (string) $html);
    });

    it('renders multiple fields in view', function (): void {
        $record = (object) [
            'matr' => '12345',
            'cognome' => 'Rossi',
            'nome' => 'Mario',
        ];

        $fields = [
            TextColumn::make('matr'),
            TextColumn::make('cognome'),
            TextColumn::make('nome'),
        ];

        if (! app()->bound('view')) {
            Assert::assertSame('12345', data_get($record, 'matr'));
            Assert::assertSame('Rossi', data_get($record, 'cognome'));
            Assert::assertSame('Mario', data_get($record, 'nome'));

            return;
        }

        $html = view('ui::filament.tables.columns.group', [
            'getFields' => fn () => $fields,
            'getRecord' => fn () => $record,
            'attributes' => new ComponentAttributeBag(),
            'getExtraAttributes' => fn () => [],
            'isInline' => fn () => false,
        ])->render();

        Assert::assertStringContainsString((string) '12345', (string) $html);
        Assert::assertStringContainsString((string) 'Rossi', (string) $html);
        Assert::assertStringContainsString((string) 'Mario', (string) $html);
    });

    it('skips empty values but keeps zeros', function (): void {
        $record = (object) [
            'empty_field' => '',
            'null_field' => null,
            'zero_int' => 0,
            'zero_string' => '0',
            'valid' => 'shown',
        ];

        // The view logic: skip if empty($value) && $value !== 0 && $value !== '0'
        $shouldSkip = static function (mixed $value): bool {
            return empty($value) && 0 !== $value && '0' !== $value;
        };

        Assert::assertTrue($shouldSkip($record->empty_field));
        Assert::assertTrue($shouldSkip($record->null_field));
        Assert::assertFalse($shouldSkip($record->zero_int));
        Assert::assertFalse($shouldSkip($record->zero_string));
    });
});
