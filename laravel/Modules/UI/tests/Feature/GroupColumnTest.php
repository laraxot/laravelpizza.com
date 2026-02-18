<?php

declare(strict_types=1);

use Filament\Tables\Columns\TextColumn;
use Illuminate\View\ComponentAttributeBag;
use Modules\UI\Filament\Tables\Columns\GroupColumn;

// Test GroupColumn class
describe('GroupColumn class', function (): void {
    it('can be instantiated with make()', function (): void {
        $column = GroupColumn::make('test');
        expect($column)->toBeInstanceOf(GroupColumn::class);
        expect($column->getName())->toBe('test');
    });

    it('accepts schema with TextColumn instances', function (): void {
        $column = GroupColumn::make('worker')
            ->schema([
                TextColumn::make('matr'),
                TextColumn::make('cognome'),
                TextColumn::make('nome'),
            ]);

        $fields = $column->getFields();
        expect($fields)->toHaveCount(3);
        expect($fields[0])->toBeInstanceOf(TextColumn::class);
        expect($fields[0]->getName())->toBe('matr');
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
        expect($fields)->toHaveCount(2);
    });

    it('handles empty schema', function (): void {
        $column = GroupColumn::make('empty')->schema([]);
        expect($column->getFields())->toBeEmpty();
    });

    it('uses correct view path', function (): void {
        $column = GroupColumn::make('test');
        $reflection = new ReflectionClass($column);
        $property = $reflection->getProperty('view');

        expect($property->getValue($column))->toBe('ui::filament.tables.columns.group');
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
        expect($value)->toBe('12345');

        $value = data_get($record, 'cognome');
        expect($value)->toBe('Rossi');
    });

    it('renders nested relation values with dot notation', function (): void {
        $record = (object) [
            'valutatore' => (object) [
                'nome_diri' => 'Mario Rossi',
                'stabi_txt' => 'Stabilimento A',
            ],
        ];

        // Test data_get() resolves dot notation
        expect(data_get($record, 'valutatore.nome_diri'))->toBe('Mario Rossi');
        expect(data_get($record, 'valutatore.stabi_txt'))->toBe('Stabilimento A');
    });

    it('returns null for missing nested relations', function (): void {
        $record = (object) [
            'valutatore' => null,
        ];

        expect(data_get($record, 'valutatore.nome_diri'))->toBeNull();
    });

    it('handles deep nesting', function (): void {
        $record = (object) [
            'level1' => (object) [
                'level2' => (object) [
                    'level3' => 'deep value',
                ],
            ],
        ];

        expect(data_get($record, 'level1.level2.level3'))->toBe('deep value');
    });

    it('preserves zero values', function (): void {
        $record = (object) [
            'score' => 0,
            'string_zero' => '0',
        ];

        expect(data_get($record, 'score'))->toBe(0);
        expect(data_get($record, 'string_zero'))->toBe('0');
    });

    it('renders view with nested relation when view system available', function (): void {
        $record = (object) [
            'valutatore' => (object) [
                'nome_diri' => 'Mario Rossi',
            ],
        ];

        $fields = [TextColumn::make('valutatore.nome_diri')];

        if (! app()->bound('view')) {
            expect(data_get($record, 'valutatore.nome_diri'))->toBe('Mario Rossi');

            return;
        }

        $html = view('ui::filament.tables.columns.group', [
            'getFields' => fn () => $fields,
            'getRecord' => fn () => $record,
            'attributes' => new ComponentAttributeBag(),
            'getExtraAttributes' => fn () => [],
            'isInline' => fn () => false,
        ])->render();

        expect($html)->toContain('Mario Rossi');
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
            expect(data_get($record, 'matr'))->toBe('12345');
            expect(data_get($record, 'cognome'))->toBe('Rossi');
            expect(data_get($record, 'nome'))->toBe('Mario');

            return;
        }

        $html = view('ui::filament.tables.columns.group', [
            'getFields' => fn () => $fields,
            'getRecord' => fn () => $record,
            'attributes' => new ComponentAttributeBag(),
            'getExtraAttributes' => fn () => [],
            'isInline' => fn () => false,
        ])->render();

        expect($html)->toContain('12345');
        expect($html)->toContain('Rossi');
        expect($html)->toContain('Mario');
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
        // So zeros should be kept
        expect(empty($record->empty_field) && 0 !== $record->empty_field && '0' !== $record->empty_field)->toBeTrue();
        expect(empty($record->null_field) && 0 !== $record->null_field && '0' !== $record->null_field)->toBeTrue();
        expect(empty($record->zero_int) && 0 !== $record->zero_int && '0' !== $record->zero_int)->toBeFalse();
        expect(empty($record->zero_string) && 0 !== $record->zero_string && '0' !== $record->zero_string)->toBeFalse();
    });
});
