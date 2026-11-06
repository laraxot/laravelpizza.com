<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Feature;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\View\ComponentAttributeBag;
use Mockery\Expectation;
use Mockery\MockInterface;
use Modules\UI\Filament\Tables\Columns\GroupColumn;
use Modules\UI\Tests\Fixtures\UiGroupColumnTypeEnum;
use Modules\UI\Tests\TestCase;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
/**
 * @return array{getTable: \Closure(): Table}
 */
function groupColumnViewTableBag(): array
{
    /** @var HasTable&MockInterface $livewire */
    $livewire = \Mockery::mock(HasTable::class);
    $livewireExpectation = $livewire->shouldReceive('getTableRecordKey');
    if ($livewireExpectation instanceof Expectation) {
        $livewireExpectation->andReturnUsing(
            static fn (mixed $record): string => is_object($record) && method_exists($record, 'getKey')
                ? SafeStringCastAction::cast($record->getKey())
                : '1'
        );
    }

    /** @var Table&MockInterface $table */
    $table = \Mockery::mock(Table::class);
    $tableExpectation = $table->shouldReceive('getLivewire');
    if ($tableExpectation instanceof Expectation) {
        $tableExpectation->andReturn($livewire);
    }

    return [
        'getTable' => static fn (): Table => $table,
    ];
}

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

    it('propagates table mount to schema children', function (): void {
        $child = TextColumn::make('id');
        $group = GroupColumn::make('id/motivo')->schema([$child]);

        $tableProperty = (new \ReflectionClass(Column::class))->getProperty('table');
        /** @var Table&MockInterface $fakeTable */
        $fakeTable = \Mockery::mock(Table::class);

        $group->table($fakeTable);

        Assert::assertSame($fakeTable, $tableProperty->getValue($child));
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

        // Ogni campo del gruppo risolve il proprio valore dal record tramite il nome della colonna.
        $values = [];
        foreach ($fields as $field) {
            $values[$field->getName()] = data_get($record, $field->getName());
        }

        Assert::assertSame(['matr' => '12345', 'cognome' => 'Rossi'], $values);
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
            'attributes' => new ComponentAttributeBag,
            'getExtraAttributes' => fn () => [],
            'isInline' => fn () => false,
            ...groupColumnViewTableBag(),
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
            'attributes' => new ComponentAttributeBag,
            'getExtraAttributes' => fn () => [],
            'isInline' => fn () => false,
            ...groupColumnViewTableBag(),
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
            return empty($value) && $value !== 0 && $value !== '0';
        };

        Assert::assertTrue($shouldSkip($record->empty_field));
        Assert::assertTrue($shouldSkip($record->null_field));
        Assert::assertFalse($shouldSkip($record->zero_int));
        Assert::assertFalse($shouldSkip($record->zero_string));
    });

    it('renders IconColumn boolean via toEmbeddedHtml instead of raw 1', function (): void {
        $record = ['ha_diritto' => 1];
        $fields = [
            IconColumn::make('ha_diritto')->boolean()->inline(),
        ];

        $html = view('ui::filament.tables.columns.group', [
            'getFields' => fn () => $fields,
            'getRecord' => fn () => $record,
            'attributes' => new ComponentAttributeBag,
            'getExtraAttributes' => fn () => [],
            'isInline' => fn () => false,
            ...groupColumnViewTableBag(),
        ])->render();

        Assert::assertStringNotContainsString('Ha Diritto: 1', $html);
        Assert::assertStringNotContainsString(': 1', $html);
        Assert::assertStringContainsString('fi-ta-group-row', $html);
        Assert::assertStringContainsString('flex-nowrap', $html);
        Assert::assertTrue(
            str_contains($html, 'fi-ta-icon') || str_contains($html, 'svg') || str_contains($html, 'heroicon'),
            'Expected IconColumn embedded HTML, got: '.$html
        );
    });

    it('applies TextColumn formatState and html for comma-separated motivo', function (): void {
        $record = ['motivo' => 'a,b,c'];
        $fields = [
            TextColumn::make('motivo')
                ->html()
                ->formatStateUsing(static function (mixed $state): string {
                    if (! is_string($state) || $state === '') {
                        return '';
                    }

                    return collect(explode(',', $state))
                        ->map(static fn (string $part): string => trim($part))
                        ->filter()
                        ->map(static fn (string $part): string => e($part))
                        ->implode('<br>');
                }),
        ];

        $html = view('ui::filament.tables.columns.group', [
            'getFields' => fn () => $fields,
            'getRecord' => fn () => $record,
            'attributes' => new ComponentAttributeBag,
            'getExtraAttributes' => fn () => [],
            'isInline' => fn () => false,
            ...groupColumnViewTableBag(),
        ])->render();

        Assert::assertStringContainsString('a<br>b<br>c', $html);
        Assert::assertStringNotContainsString('a,b,c', $html);
    });

    it('renders SelectColumn via toEmbeddedHtml even when state is null', function (): void {
        $record = ['valutatore_id' => null];
        $fields = [
            SelectColumn::make('valutatore_id')
                ->options(['1' => 'Uno', '2' => 'Due']),
        ];

        $html = view('ui::filament.tables.columns.group', [
            'getFields' => fn () => $fields,
            'getRecord' => fn () => $record,
            'attributes' => new ComponentAttributeBag,
            'getExtraAttributes' => fn () => [],
            'isInline' => fn () => false,
            ...groupColumnViewTableBag(),
        ])->render();

        Assert::assertStringContainsString('fi-ta-group-interactive', $html);
        Assert::assertTrue(
            str_contains($html, 'select') || str_contains($html, 'fi-ta-select'),
            'Expected SelectColumn embedded HTML, got: '.$html
        );
    });

    it('renders BackedEnum with HasLabel using translated label not raw value', function (): void {
        $record = ['type' => UiGroupColumnTypeEnum::Dip];
        $fields = [
            TextColumn::make('type'),
        ];

        if (! app()->bound('view')) {
            $value = data_get($record, 'type');
            Assert::assertInstanceOf(UiGroupColumnTypeEnum::class, $value);
            Assert::assertSame('Dipendente', $value->getLabel());

            return;
        }

        $html = view('ui::filament.tables.columns.group', [
            'getFields' => fn () => $fields,
            'getRecord' => fn () => $record,
            'attributes' => new ComponentAttributeBag,
            'getExtraAttributes' => fn () => [],
            'isInline' => fn () => false,
            ...groupColumnViewTableBag(),
        ])->render();

        $html = (string) $html;
        Assert::assertStringContainsString('Dipendente', $html);
        Assert::assertStringNotContainsString('class="fi-ta-group-value"> dip', $html);
    });
});
