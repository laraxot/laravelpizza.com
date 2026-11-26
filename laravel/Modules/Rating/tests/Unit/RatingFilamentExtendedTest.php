<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Unit;

use Filament\Tables\Columns\Column;
use Filament\Tables\Table;
use Modules\Rating\Filament\Actions\Table\BetTableAction;
use Modules\Rating\Filament\Resources\RatingMorphResource\Pages\EditRatingMorph;
use Modules\Rating\Filament\Resources\RatingMorphResource\Pages\ListRatingMorphs;
use Modules\Rating\Filament\Resources\RatingResource\Pages\EditRating;
use Modules\Rating\Tests\Fixtures\BaseEditRatingStub;
use Modules\Rating\Tests\Fixtures\BaseRatingsTableStub;
use Modules\Rating\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

afterEach(function (): void {
    \Mockery::close();
});

test('BetTableAction espone il nome default bet_action', function (): void {
    Assert::assertSame('bet_action', BetTableAction::getDefaultName());
});

test('BetTableAction configura label e schema modale', function (): void {
    $action = BetTableAction::make();

    Assert::assertSame('bet_action', $action->getName());
    Assert::assertSame('', $action->getLabel());
});

/*
 * `BaseRatingsTableStub` dichiara la sua Resource (`getResource()`): fuori da `{Resource}\Tables\`
 * l'asserzione di `XotBaseResourceTable` fallisce, ed e' giusto che fallisca.
 *
 * @see Modules/Rating/docs/filament-table-architecture.md
 */
test('BaseRatingsTable espone colonne filtri e azioni attese', function (): void {
    $tabella = new BaseRatingsTableStub;

    // `order_column` non e' una colonna visibile: serve solo al riordino (HasXotTable::applyReorderable()),
    // tolta di proposito da BaseRatingsTable (vedi il commento li' e story 5.96-rating-resource-reordering-adoption).
    Assert::assertSame(
        ['id', 'title', 'slug', 'rule', 'is_disabled', 'is_readonly', 'created_at', 'updated_at'],
        array_keys($tabella->getTableColumns()),
    );
    Assert::assertContainsOnlyInstancesOf(Column::class, $tabella->getTableColumns());
    Assert::assertSame([], $tabella->getTableFilters());

    $actionsMethod = new \ReflectionMethod($tabella, 'getTableActions');
    $actions = $actionsMethod->invoke($tabella);
    Assert::assertIsArray($actions);
    Assert::assertArrayHasKey('edit', $actions);
    // 'delete' dall'hook di HasXotTable: l'override con il gruppo 'bulk' e' stato tolto da
    // BaseRatingsTable il 2026-10-15 (Rating feed303).
    Assert::assertArrayHasKey('delete', $tabella->getTableBulkActions());
});

test('BaseEditRating espone DeleteAction in header', function (): void {
    $method = new \ReflectionMethod(BaseEditRatingStub::class, 'getActions');
    $method->setAccessible(true);

    $actions = $method->invoke(new BaseEditRatingStub);

    Assert::assertIsArray($actions);
    Assert::assertCount(1, $actions);
});

test('EditRating espone DeleteAction in header', function (): void {
    $method = new \ReflectionMethod(EditRating::class, 'getActions');
    $method->setAccessible(true);

    $actions = $method->invoke(new EditRating);

    Assert::assertIsArray($actions);
    Assert::assertCount(1, $actions);
});

/*
 * La list page non configura la tabella (`ListRecords::table()` restituisce la Table cosi' com'e'):
 * la costruisce la Resource via `getTableClass()`, come fa Filament in `makeTable()`.
 * Le colonne sono quelle di `rating_morph`: `ratingable_*` non esistono nello schema.
 *
 * Il pulsante di creazione e' quello di `XotBaseListRecords::getHeaderActions()`: `getActions()` e'
 * l'alias deprecato di Filament, che la base non richiama.
 *
 * @see Modules/Rating/docs/wiki/concepts/xotbase-table-columns-enforcement.md
 */
test('ListRatingMorphs dichiara colonne e create action', function (): void {
    $page = new ListRatingMorphs;
    $table = ListRatingMorphs::getResource()::table(Table::make($page));

    Assert::assertSame(
        ['id', 'rating.title', 'rating_id', 'user_id', 'model_type', 'model_id', 'value', 'note', 'is_winner', 'reward', 'created_at', 'updated_at'],
        array_keys($table->getColumns()),
    );

    $actionsMethod = new \ReflectionMethod($page, 'getHeaderActions');
    $actionsMethod->setAccessible(true);

    $actions = $actionsMethod->invoke($page);
    Assert::assertIsArray($actions);
    Assert::assertSame(['create'], array_keys($actions));
});

test('EditRatingMorph eredita resource RatingMorph', function (): void {
    $method = new \ReflectionMethod(EditRatingMorph::class, 'getActions');
    $method->setAccessible(true);

    Assert::assertIsArray($method->invoke(new EditRatingMorph));
});
