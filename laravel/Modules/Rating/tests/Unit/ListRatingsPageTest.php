<?php

declare(strict_types=1);

use Modules\Rating\Filament\Resources\RatingResource;
use Modules\Rating\Filament\Resources\RatingResource\Pages\BaseListRatings;
use Modules\Rating\Filament\Resources\RatingResource\Pages\ListRatings;
use Modules\Rating\Filament\Resources\RatingResource\Tables\RatingsTable;
use Modules\Rating\Tests\TestCase;
use PHPUnit\Framework\Assert;
use ReflectionMethod;

uses(TestCase::class);

/*
 * I metodi pubblici di pagina Filament sono deprecati a favore di `table()`; qui
 * invochiamo via reflection solo per fissare il contratto attuale di BaseListRatings.
 */
test('page no longer owns the column set', function (): void {
    // Le colonne sono state spostate nelle classi sotto Tables/: qui resta solo
    // l'ereditarieta' da XotBaseListRecords, che non ne dichiara nessuna.
    $page = new ListRatings;
    $method = new ReflectionMethod(BaseListRatings::class, 'getTableColumns');
    /** @var array<string, mixed> $columns */
    $columns = $method->invoke($page);

    Assert::assertSame([], array_keys($columns));
});

test('the column set lives in RatingsTable', function (): void {
    $columns = (new RatingsTable)->getTableColumns();

    Assert::assertSame([
        'id',
        'title',
        'slug',
        'rule',
        'is_disabled',
        'is_readonly',
        'order_column',
        'created_at',
        'updated_at',
    ], array_keys($columns));
});

/*
 * Filtri e azioni, come le colonne, li dichiara `RatingsTable` (la Table class che
 * `RatingResource::getTableClass()` sceglie): gli hook `getTable*()` di `XotBaseListRecords`
 * restituiscono `[]` per contratto, e invocarli sulla pagina misurava il posto sbagliato.
 *
 * @see Modules/Rating/docs/filament-table-architecture.md
 */
test('defines default empty filters and header actions', function (): void {
    Assert::assertSame(RatingsTable::class, RatingResource::getTableClass());

    $table = new RatingsTable;

    Assert::assertSame([], $table->getTableFilters());
    Assert::assertNotEmpty($table->getTableHeaderActions());
});

test('defines view edit delete actions and bulk delete', function (): void {
    $table = new RatingsTable;

    $actions = $table->getTableActions();
    $bulk = $table->getTableBulkActions();

    Assert::assertArrayHasKey('view', $actions);
    Assert::assertArrayHasKey('edit', $actions);
    Assert::assertArrayHasKey('delete', $actions);
    Assert::assertArrayHasKey('delete', $bulk);
});
