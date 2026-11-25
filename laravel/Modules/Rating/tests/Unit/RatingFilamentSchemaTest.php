<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Unit;

use Filament\Schemas\Components\Component as SchemaComponent;
use Filament\Tables\Columns\Column;
use Modules\Rating\Filament\Resources\RatingMorphResource\Schemas\RatingMorphForm;
use Modules\Rating\Filament\Resources\RatingMorphResource\Schemas\RatingMorphInfolist;
use Modules\Rating\Filament\Resources\RatingMorphResource\Tables\RatingMorphsTable;
use Modules\Rating\Filament\Resources\RatingMorphResource\Tables\RatingMorphTable;
use Modules\Rating\Filament\Resources\RatingResource\Schemas\RatingForm;
use Modules\Rating\Filament\Resources\RatingResource\Schemas\RatingInfolist;
use Modules\Rating\Filament\Resources\RatingResource\Tables\RatingsTable;
use Modules\Rating\Filament\Resources\RatingResource\Tables\RatingTable;
use Modules\Rating\Tests\TestCase;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/**
 * Convenzione XotBase: gli schema sono array **associativi** — la chiave è il nome del
 * campo e sostituisce la label esplicita. Un array a chiavi numeriche è una regressione,
 * non uno stile diverso.
 *
 * @param  array<array-key, mixed>  $schema
 */
function ratingAssertKeyedSchema(array $schema, string $tipo): void
{
    Assert::assertNotEmpty($schema);

    foreach (array_keys($schema) as $chiave) {
        Assert::assertIsString($chiave, "chiave numerica in {$tipo}");
        Assert::assertNotSame('', $chiave);
    }
}

test('le tabelle espongono colonne indicizzate per campo', function (): void {
    /** @var list<class-string<XotBaseResourceTable>> $classi */
    $classi = [
        RatingsTable::class,
        RatingTable::class,
        RatingMorphsTable::class,
        RatingMorphTable::class,
    ];

    foreach ($classi as $classe) {
        $tabella = new $classe;
        $colonne = $tabella->getTableColumns();

        ratingAssertKeyedSchema($colonne, $classe);
        Assert::assertContainsOnlyInstancesOf(Column::class, $colonne);
    }
});

test('le tabelle dichiarano filtri e azioni senza esplodere', function (): void {
    /** @var list<class-string<XotBaseResourceTable>> $classi */
    $classi = [
        RatingsTable::class,
        RatingTable::class,
        RatingMorphsTable::class,
        RatingMorphTable::class,
    ];

    foreach ($classi as $classe) {
        $tabella = new $classe;
        $actionsMethod = new \ReflectionMethod($tabella, 'getTableActions');

        Assert::assertIsArray($tabella->getTableFilters());
        Assert::assertIsArray($actionsMethod->invoke($tabella));
        Assert::assertIsArray($tabella->getTableBulkActions());
    }
});

test('RatingsTable copre i campi anagrafici del rating', function (): void {
    Assert::assertSame(
        ['id', 'title', 'slug', 'rule', 'is_disabled', 'is_readonly', 'order_column', 'created_at', 'updated_at'],
        array_keys((new RatingsTable)->getTableColumns()),
    );
});

test('i form espongono uno schema indicizzato per campo', function (): void {
    // RatingMorphForm non e' piu' uno stub vuoto: BaseRatingMorphForm dichiara rating_id,
    // value, percentage e note, quindi sta nello stesso controllo di RatingForm.
    foreach ([new RatingForm, new RatingMorphForm] as $form) {
        $schema = $form->getFormSchema();

        ratingAssertKeyedSchema($schema, $form::class);
        Assert::assertContainsOnlyInstancesOf(SchemaComponent::class, $schema);
    }
});

test('il form del rating morph dichiara i campi attesi', function (): void {
    Assert::assertSame(
        ['rating_id', 'value', 'percentage', 'note'],
        array_keys((new RatingMorphForm)->getFormSchema()),
    );
});

test('gli infolist espongono uno schema indicizzato per campo', function (): void {
    foreach ([new RatingInfolist, new RatingMorphInfolist] as $infolist) {
        ratingAssertKeyedSchema($infolist->getInfolistSchema(), $infolist::class);
    }
});

test('il form del rating dichiara i campi attesi', function (): void {
    Assert::assertSame(
        ['title', 'color', 'rule', 'parent_id', 'flags', 'txt'],
        array_keys((new RatingForm)->getFormSchema()),
    );
});

test('i form usano una sola colonna e nessuno step wizard', function (): void {
    foreach ([new RatingForm, new RatingMorphForm] as $form) {
        Assert::assertSame(1, $form->getFormColumns());
        Assert::assertSame([], $form->getSteps());
    }
});
