# Stub di test per XotBaseExporter

## Scopo

Gli stub sotto `tests/Unit/Exports/` non sono produzione: servono a esercitare
`XotBaseExporter` in isolamento (celle xlsx tipizzate, eager-load relations,
colonne da `getXlsFields`).

| Stub | Perche' |
|------|---------|
| `XotBaseExporterStub` | Classe concreta del parent astratto; espone `resolveColumns`/`columnName` ai test. **Non** ridefinisce `xlsxCell()`: eredita `OpenSpout\Common\Entity\Cell` da `XlsxCellFactory`. |
| `ExporterEagerLoadModelStub` | Model con `ratings()` / `ratingMorphs()` cosi' `modifyQuery()` fa eager-load e il test verifica le chiavi senza DB reale. |
| `ExportActionStub`, `ListRecordsStub`, `ResourceWithXlsFieldsStub` | Contesto minimo Filament/Livewire per job CSV e colonne. |

PSR-4: `Modules\Xot\Tests\` → `tests/` (minuscolo). Nessuna cartella `Tests/` parallela.

## Contratto celle (xlsxCell)

`XotBaseExporter::xlsxCell(mixed $value, ?Style $style = null): Cell` delega a
`XlsxCellFactory::make()`. OpenSpout `Cell` e' astratta: le istanze reali sono
`NumericCell`, `StringCell`, `EmptyCell`, `FormulaCell`, …: mai una sottoclasse
di test inventata.

Anti-pattern rifiutato: `CellConcrete` + return type piu' stretto del parent +
`(string) $mixed`. Rompe covarianzza, autoload e tipizzazione del binder PhpSpreadsheet.

## Generics relazioni (eager-load)

`HasMany` / `MorphMany` richiedono entrambi i template:

```php
/** @return HasMany<ExporterEagerLoadModelStub, $this> */
public function ratings(): HasMany

/** @return MorphMany<ExporterEagerLoadModelStub, $this> */
public function ratingMorphs(): MorphMany
```

`TDeclaringModel` deve essere `$this` (non `static`): Laravel tipizza
`hasMany`/`morphMany` con `$this`, altrimenti PHPStan segnala `return.type`
e/o `generics.lessTypes`.

## Collegamenti

- Parent: `app/Exports/XotBaseExporter.php`, `app/Exports/XlsxCellFactory.php`
- Test: `tests/Unit/Exports/XotBaseExporterTest.php`
- Story eager-load: [export-eager-load-contract.story.md](../bmad/stories/export-eager-load-contract.story.md)

## Case: tests/ vs Tests/

PSR-4 mappa `Modules\Xot\Tests\` → `tests/`. Una cartella `Tests/` parallela (fuori autoload) viene comunque analizzata da PHPStan e introduce stub fantasma (`CellConcrete`, namespace Fixtures vs Unit). SSoT stub: `tests/Unit/Exports/`.

## ExportActionStub

Concrete di `Modules\Xot\Filament\Actions\XotBaseExportAction` (non di un Action inesistente sotto `Modules\Xot\Actions`). Serve solo a rendere istanziabile l'astratta cosi' il test puo' leggere `getJob()` dopo `setUp()`.

## Anti-ricreazione Tests/

Non creare `Modules/Xot/Tests/` (maiuscolo). PSR-4 punta a `tests/`. Una seconda tree (anche con symlink) fa analizzare a PHPStan stub fantasma/corrotti (`phpstan.parse`). SSoT stub exporter: `tests/Unit/Exports/`. Stubs Filament: `tests/Fixtures/Stubs/`.

## SSoT ExporterEagerLoadModelStub

Un solo file: `tests/Unit/Exports/ExporterEagerLoadModelStub.php` (namespace `Modules\Xot\Tests\Unit\Exports`).

Vietato:
- `Tests/` (maiuscolo): fuori PSR-4, PHPStan lo scansiona e puo' dare `Could not read file` / parse error in race
- `tests/Fixtures/ExporterEagerLoadModelStub.php`: namespace diverso, doppia classe

