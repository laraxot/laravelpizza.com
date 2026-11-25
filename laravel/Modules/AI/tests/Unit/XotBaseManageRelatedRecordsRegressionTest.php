<?php

declare(strict_types=1);
use Modules\Xot\Filament\Resources\Pages\XotBaseManageRelatedRecords;
use Modules\Xot\Filament\Traits\HasXotTable;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;
use Modules\Xot\Filament\Traits\TransFuncTrait;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;

uses(TestCase::class);

/**
 * Guardia meccanica contro due regressioni avvenute nello stesso giorno
 * (2026-09-11):
 *
 * 1. Un editing concorrente rimuoveva `use TraitX;` dal corpo della classe
 *    lasciando l'import inutilizzato, causando fatal error silenziosi
 *    (transFunc()/getModelClass() non piu' disponibili) invece di un errore
 *    di sintassi visibile subito.
 * 2. Una "sesta direzione" ha reintrodotto `HasXotTable` su questa classe
 *    (una pagina, non una Table class) pensando che servisse a preservare
 *    layout toggle/sort/poll — violando la story gia' esistente
 *    18.27.hasxottable-fuori-dai-componenti-filament.story.md (2026-09-08,
 *    che nomina esplicitamente questa classe fra le 5 da tenere fuori dal
 *    trait). La "settima direzione" corregge: NESSUN trait Xot su questa
 *    classe, `getModelClass()` ridichiarato direttamente (stesso pattern di
 *    `XotBaseListRecords::getModelClass()`), `table()` chiama i setter
 *    nativi di `Table` dopo aver delegato a `$resourceClass::table()`.
 *
 * @see Modules/Xot/docs/stories/xotbasemanagerelatedrecords-convention-over-configuration.story.md
 * @see Modules/Xot/docs/stories/18.27.hasxottable-fuori-dai-componenti-filament.story.md
 */
it('usa i trait richiesti (NavigationLabelTrait, TransFuncTrait) e NON HasXotTable', function (): void {
    $traits = class_uses_recursive(XotBaseManageRelatedRecords::class);

    // La pagina chiama static::transFunc(): il metodo arriva da TransFuncTrait, usato
    // da NavigationLabelTrait (vedi la docblock della classe). TransTrait non serve qui.
    Assert::assertArrayHasKey(NavigationLabelTrait::class, $traits);
    Assert::assertArrayHasKey(TransFuncTrait::class, $traits);

    // Story 18.27: XotBaseManageRelatedRecords e' nominata esplicitamente
    // fra le classi che NON devono usare HasXotTable (implementa HasTable,
    // "famiglia B" — il trait e' riservato a XotBaseResourceTable,
    // "famiglia A"). Riusarlo qui reintroduce gli ignore method.deprecated
    // e collide con getTableSortColumn()/getTableSortDirection() nativi.
    Assert::assertArrayNotHasKey(
        HasXotTable::class,
        $traits,
        'XotBaseManageRelatedRecords non deve usare HasXotTable (story 18.27) — la tabella della Resource correlata lo usa gia internamente.'
    );
});

it('ridichiara getModelClass() direttamente (mai da un trait)', function (): void {
    $reflection = new ReflectionClass(XotBaseManageRelatedRecords::class);

    Assert::assertTrue($reflection->hasMethod('getModelClass'));

    $declaringClass = $reflection->getMethod('getModelClass')->getDeclaringClass()->getName();
    Assert::assertSame(
        XotBaseManageRelatedRecords::class,
        $declaringClass,
        'getModelClass() deve essere dichiarato direttamente su questa classe, non ereditato da un trait: '
        .'un incidente reale (2026-09-11) e nato da questo metodo che spariva insieme a un trait rimosso.'
    );
});

it('espone i metodi chiave della delega (getRelatedResourceClass, i 5 hook di contenuto)', function (): void {
    $reflection = new ReflectionClass(XotBaseManageRelatedRecords::class);

    Assert::assertTrue($reflection->hasMethod('getRelatedResourceClass'));

    // I 5 override point per-pagina: sostituiscono getTableColumns()/
    // getTableHeaderActions()/getTableActions()/getTableBulkActions()/
    // getTableFilters() con il default reale della Resource correlata.
    // `configureRelatedTable()` (hook bespoke di una direzione precedente,
    // mai chiamato da table()) resta rimosso: 3 pagine reali
    // (ManageNotifyThemes, ManageQuestionCharts, ManageMailTemplates) lo
    // sovrascrivevano senza che nulla lo invocasse mai — funzionalita'
    // reale persa in silenzio, migrate ai hook reali (o a table() per
    // intero dove serviva query scoping, vedi ManageMailTemplates).
    foreach (['getTableColumns', 'getTableHeaderActions', 'getTableActions', 'getTableBulkActions', 'getTableFilters'] as $hook) {
        Assert::assertTrue($reflection->hasMethod($hook), "manca l'hook {$hook}");
        // CRITICO (vedi HasXotTable): deve restare PUBLIC, Filament/Livewire
        // lo chiama dall'esterno.
        Assert::assertTrue($reflection->getMethod($hook)->isPublic(), "{$hook} deve essere public");
    }

    Assert::assertFalse(
        $reflection->hasMethod('configureRelatedTable'),
        'configureRelatedTable() e\' l\'hook bespoke morto della direzione precedente: mai chiamato da table(), non deve tornare.'
    );
});

it('form() e table() sono final (2026-09-11, sera): nessuna pagina puo\' piu\' sovrascriverli per intero', function (): void {
    // Motivazione completa nel docblock di classe: form()/table() erano
    // "sovrascrivibili per intero" solo a parole (il docblock lo chiamava
    // "alternativa legittima"), mai verificato contro i consumer reali —
    // 3 pagine lo facevano senza mai chiamare parent::, contraddicendo il
    // docblock stesso. `final` chiude il contratto Template Method col
    // linguaggio, non solo con un commento: la stessa classe di bug
    // (reimplementazione parziale di table()) diventa un fatal error di
    // compilazione invece di una regressione runtime silenziosa.
    $reflection = new ReflectionClass(XotBaseManageRelatedRecords::class);

    Assert::assertTrue($reflection->getMethod('form')->isFinal(), 'form() deve essere final');
    Assert::assertTrue($reflection->getMethod('table')->isFinal(), 'table() deve essere final');

    Assert::assertTrue($reflection->hasMethod('getFormSchema'), 'manca l\'hook getFormSchema()');
    Assert::assertTrue($reflection->getMethod('getFormSchema')->isPublic(), 'getFormSchema() deve essere public');

    Assert::assertTrue($reflection->hasMethod('modifyRelatedQuery'), 'manca l\'hook modifyRelatedQuery() (query scoping, es. ManageMailTemplates)');
});

it('table() usa columns(), mai pushColumns() (colonne duplicate)', function (): void {
    // $resourceClass::table($table) (il primo passo di table(), sotto) ha
    // GIA' popolato $table con le colonne reali della Resource correlata
    // (via HasXotTable::table() lato ContactsTable/ecc., che usa columns()
    // internamente). Se il setter successivo qui fosse pushColumns()
    // (accoda, non resetta — vedi Filament\Tables\Table\Concerns\HasColumns)
    // invece di columns() (resetta poi accoda), ogni colonna finirebbe
    // duplicata in $table->getColumnsLayout(). Bug reale trovato per audit
    // del sorgente (2026-09-11), mai arrivato in produzione.
    $reflection = new ReflectionMethod(XotBaseManageRelatedRecords::class, 'table');
    $lines = file_get_contents((string) $reflection->getFileName());
    $body = implode('', \array_slice(
        explode("\n", $lines),
        $reflection->getStartLine() - 1,
        $reflection->getEndLine() - $reflection->getStartLine() + 1,
    ));

    Assert::assertStringContainsString('->columns(', $body);
    Assert::assertStringNotContainsString('->pushColumns(', $body);
});

it('getModelClass() non tratta getRelationship() come se potesse restituire una stringa', function (): void {
    // Regressione ricomparsa piu' volte lo stesso giorno (2026-09-11): una
    // variante di getModelClass() assumeva `is_string($relationship)` come
    // caso possibile. Falso: Filament\Resources\Pages\ManageRelatedRecords::
    // getRelationship() e' tipizzato `Relation|Builder`, mai `string` —
    // verificato via Reflection sul metodo nativo. Quel ramo morto nascondeva
    // anche un buco reale: il caso `Builder` (non `Relation`) non era gestito
    // affatto e finiva sempre nel throw finale. PHPStan lo conferma da solo
    // (is_string sempre falso, method_exists su mixed) ogni volta che la
    // variante rotta torna: questo test lo rende esplicito anche a chi non
    // lancia PHPStan.
    $reflection = new ReflectionMethod(XotBaseManageRelatedRecords::class, 'getModelClass');
    $lines = file_get_contents((string) $reflection->getFileName());
    $body = implode('', \array_slice(
        explode("\n", $lines),
        $reflection->getStartLine() - 1,
        $reflection->getEndLine() - $reflection->getStartLine() + 1,
    ));

    Assert::assertStringNotContainsString('is_string(', $body);
    Assert::assertStringContainsString('getRelationship()', $body);
});
