<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit\Filament;

use Filament\Tables\Columns\TextColumn;
use Modules\Media\Filament\Resources\MediaResource\Tables\MediaTable;
use Modules\Media\Tests\TestCase;
use PHPUnit\Framework\Assert;

/*
 * Colonne e azioni della tabella Media. `getTableFilters()` resta fuori: e' l'unico
 * metodo che interroga il database (`Media::distinct()`), e questo file non apre
 * connessioni.
 */

uses(TestCase::class)->group('no-media-db');

test('the table exposes the media columns in a stable order', function (): void {
    $columns = (new MediaTable)->getTableColumns();

    Assert::assertSame([
        'id',
        'name',
        'file_name',
        'mime_type',
        'collection_name',
        'disk',
        'size',
        'order_column',
        'model_type',
        'model_id',
        'created_at',
        'updated_at',
    ], array_keys($columns));
});

test('every column is a text column named after its own key', function (): void {
    foreach ((new MediaTable)->getTableColumns() as $key => $column) {
        Assert::assertInstanceOf(TextColumn::class, $column, $key);
        Assert::assertSame($key, $column->getName());
    }
});

test('the searchable columns are the descriptive ones, not the numeric ones', function (): void {
    $columns = (new MediaTable)->getTableColumns();

    foreach (['name', 'file_name', 'mime_type', 'collection_name', 'model_type', 'model_id'] as $key) {
        Assert::assertTrue($columns[$key]->isSearchable(), "{$key} dovrebbe essere ricercabile");
    }

    foreach (['id', 'disk', 'size', 'order_column'] as $key) {
        Assert::assertFalse($columns[$key]->isSearchable(), "{$key} non dovrebbe essere ricercabile");
    }
});

test('updated_at is the only column hidden behind the toggle', function (): void {
    $columns = (new MediaTable)->getTableColumns();

    Assert::assertTrue($columns['updated_at']->isToggledHiddenByDefault());
    Assert::assertFalse($columns['created_at']->isToggledHiddenByDefault());
});
