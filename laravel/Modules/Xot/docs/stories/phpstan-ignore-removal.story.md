---
title: Rimozione delle annotazioni phpstan-ignore da Xot
type: story
module: Xot
status: in-progress
created: 2026-10-30
updated: 2026-10-30
tags: [phpstan, phpstan-ignore, trait-unused, not-deprecated, xot]
qmd: "phpstan ignore removal xot trait.unused callable.nonCallable EnumTrait HasUuid EnumIntegerTrait"
---

# Rimozione delle annotazioni phpstan-ignore da Xot

Regola di progetto: mai `@phpstan-ignore`, mai baseline. Questa pagina raccoglie l'esito per modulo Xot.
`reportUnmatchedIgnoredErrors` e' `false`: un'annotazione obsoleta non genera alcun avviso e resta nel codice
anche quando la causa e' sparita.

### Trait vari

Sezione dell'agente "Trait vari" (`Modules/Xot/app/Traits`, `Modules/Xot/app/Models/Traits`).

## Esito

Annotazioni rimosse: 8 su 10. Nessun cambio di comportamento, nessuna modifica a codice eseguibile.

| File | Prima | Dopo | Causa |
|---|---|---|---|
| `Traits/EnumTrait.php` | 1 (`callable.nonCallable`) | 0 | Obsoleta: `$definition` e' gia' tipizzato `callable(Blueprint): void` dal docblock di `getColumnDefinitions()`. |
| `Traits/HasCsrfToken.php` | 1 (`trait.unused`) | 0 | Il trait e' usato dalla classe anonima in `Xot/tests/Unit/XotExecuteCoverage50Test.php` (percorso analizzato). |
| `Traits/HasCustomRelations.php` | 1 (`trait.unused`) | 0 | Usato in `Xot/tests/Unit/Traits/HasCustomRelationsTest.php`. |
| `Traits/HasTableFunctionsTrait.php` | 1 (`trait.unused`) | 0 | Usato dalle fixture `Xot/tests/Fixtures/Traits/*Probe.php`. |
| `Traits/HasSchemalessAttributes.php` | 1 (`trait.unused`) | 0 | Usato dalla fixture `Xot/tests/Fixtures/Models/SchemalessTestModel.php`. |
| `Models/Traits/HasCommonScopes.php` | 1 (`trait.unused`) | 0 | Usato dalla fixture `Xot/tests/Fixtures/Models/HasCommonScopesProbe.php`. |
| `Models/Traits/HasDynamicFillable.php` | 1 (`trait.unused`) | 0 | Usato da `TechPlanner/app/Models/Client.php`. |
| `Models/Traits/HasExtraTrait.php` | 1 (`trait.unused`) | 0 | Usato da `User/app/Models/BaseInteractsWithExtra.php` e dalle fixture Xot. |

Su `HasExtraTrait` l'annotazione stava in un secondo docblock subito dopo quello descrittivo: ora il docblock
con i `@property` e' attaccato direttamente al trait.

Verifica: `trait.unused` e' una regola che si attiva solo se si analizza almeno una directory (con soli file
singoli non viene mai riportata). Analizzando le directory dei trait, `Xot/app/Enums`, `Xot/tests/Fixtures`,
`Xot/tests/Unit/Traits`, `TechPlanner/app/Models` e `User/app/Models` non risulta alcun `trait.unused` sui trait
Xot di sopra e `EnumTrait.php` (con le enum `YesNoEnum`, `GenderEnum`) e' pulito. Gli unici due `trait.unused`
emersi in quel sottoinsieme riguardano trait del modulo User, fuori dalla corsia.

### Esito: trait e pagine Filament (HasXotTable e correlati)

Sezione dell'agente "Filament Traits". Annotazioni: 34 prima, 7 dopo. Nessun cambio di comportamento: solo docblock e righe di commento.

| File | Prima | Dopo | Cosa e' cambiato |
|---|---|---|---|
| `Filament/Traits/HasXotTable.php` | 25 | 7 | 18 rimosse: 6 `method.deprecated` risolti con `@not-deprecated` sugli 11 hook del trait; 12 obsolete (`alreadyNarrowedType`, `argument.type`, `method.childReturnType`, `next-line` generici: PHPStan non riporta piu' nulla). |
| `Filament/Resources/Pages/XotBaseManageRelatedRecords.php` | 5 | 0 | `@not-deprecated` sui 5 hook `getTable*` della pagina. |
| `Filament/Traits/TransTrait.php` | 2 | 0 | Obsolete: `trans()`/`__()` accettano `array $replace`, nessun `argument.type`. |
| `Filament/Traits/NavigationPageLabelTrait.php` | 1 | 0 | Obsoleta: il trait e' usato da `Job` `CreateSchedule` e da `User` `PasswordExpired`. |
| `Traits/Filament/HasCustomModelLabel.php` | 1 | 0 | Obsoleta: usato dalla fixture `Xot/tests/Fixtures/Traits/HasCustomModelLabelProbeBase.php`. |

Causa radice dei `method.deprecated`: gli hook di progetto (`getTableColumns()`, `getTableFilters()`, `getTableActions()`,
`getTableBulkActions()`, `getTableHeaderActions()`, `getTableEmptyStateActions()`, `getTableHeading()`, `isTableStriped()`,
`shouldPersistTableFiltersInSession()`, `getDefaultTableSortColumn()`, `getDefaultTableSortDirection()`) hanno lo stesso nome di
metodi `@deprecated` di Filament, e PHPStan eredita la deprecazione dal genitore. Il tag PHPDoc `@not-deprecated` dichiara
che l'hook di progetto e' API attiva (non e' un ignore: nessun errore viene soppresso, cambia la dichiarazione). Rinominare gli
hook avrebbe rotto le sottoclassi e i progetti esterni.

Verifica: `phpstan analyse` pulito su `HasXotTable`, sui 5 utilizzatori diretti (`XotBaseTableWidget`, i due `XotBaseRelationManager`,
`XotBaseManageRelatedRecords` di `XotBaseResource/Pages`, `XotBaseResourceTable`) e sulle fixture di test che lo usano.

## Non rimosso (con motivo)

- `Models/Traits/HasUuid.php` (`trait.unused`): nessuna classe nel repo lo usa (ne' in `app` ne' in `tests`, ne' in `Themes`).
  Codice morto. Non cancellato: va deciso se ritirarlo o se serve a progetti esterni.
- `Traits/EnumIntegerTrait.php` (`trait.unused`): API di piattaforma per gli enum int-backed, documentata in
  `docs/wiki/rules/enum-pattern-filament.md`, senza consumer in questo repo. L'annotazione porta gia' il motivo.
  Si risolve solo ritirando il pattern o aggiungendo un consumer reale (per esempio un enum int-backed che lo usa).

### Rimosso in un secondo giro: HasXotTable (ultime 7 annotazioni `method.deprecated`)

Righe con `$this->getTableColumns()` (2), `getTableFilters()` (2), `getTableHeaderActions()`, `getTableActions()`,
`getTableBulkActions()`. Nel contesto di `XotBaseRelationManager` (due varianti), `XotBaseManageRelatedRecords`
(`XotBaseResource/Pages`) e `XotBaseTableWidget` PHPStan risolve il metodo sull'override dichiarato dalla classe stessa
(o, per il widget, sul metodo concreto ereditato da `TableWidget`, perche' il metodo astratto del trait non lo sostituisce),
che non aveva `@not-deprecated`. Fatto il 2026-10-30:

| File | Cambio |
|---|---|
| `Filament/Resources/RelationManagers/XotBaseRelationManager.php` | `@not-deprecated` su `getTableColumns/Actions/BulkActions/HeaderActions`; `getTableFilters()` ha ora un docblock (`array<string\|int, BaseFilter>`). |
| `Filament/Resources/XotBaseResource/RelationManager/XotBaseRelationManager.php` | `@not-deprecated` su `getTableColumns()`. |
| `Filament/Resources/XotBaseResource/Pages/XotBaseManageRelatedRecords.php` | `@not-deprecated` su `getTableColumns/HeaderActions/Actions`; `disableCreateAnother()` (deprecato in Filament) sostituito dall'equivalente `createAnother(false)`. |
| `Filament/Widgets/XotBaseTableWidget.php` | nuovo `getTableColumns()` (`return []`, come il metodo di Filament) con `@not-deprecated`. |
| `Filament/Resources/Pages/XotBaseListRecords.php` | `@not-deprecated` sui quattro stub `getTableColumns/Actions/Filters/BulkActions`. |
| `Filament/Traits/HasXotTable.php` | cancellate le 7 righe `@phpstan-ignore method.deprecated`. |

Perche' sono emerse due segnalazioni nuove al primo giro: dentro un metodo deprecato PHPStan non segnala le chiamate a
metodi deprecati. Togliendo la deprecazione ereditata, `disableCreateAnother()` in `XotBaseManageRelatedRecords` e la
chiamata di `User` `TenantsRelationManager` a `ListTenants::getTableColumns()` (stub di `XotBaseListRecords` senza tag) sono
diventate visibili. Entrambe si correggono alla radice (API non deprecata, tag sulla famiglia di stub), non con un ignore.

Verifica: `cd laravel && ./vendor/bin/phpstan analyse Modules --memory-limit=-1 --no-progress` -> 0 errori dopo il giro
(`HasXotTable` senza piu' alcuna annotazione).

## Non verificato

- `analyse Modules` intero lanciato dal coordinatore dopo tutte le lane e dopo il secondo giro `@not-deprecated`: 0 errori (con cache svuotata dopo le lane).
- Cinque trait (`HasCsrfToken`, `HasCustomRelations`, `HasTableFunctionsTrait`, `HasSchemalessAttributes`,
  `HasCommonScopes`) risultano "usati" solo da test o fixture in `Modules/`: se quei test venissero rimossi o spostati
  fuori dal percorso analizzato, `trait.unused` tornerebbe.
- Nessun test Pest eseguito (database di test con dati reali).

### Non verificato: trait e pagine Filament

- Il contesto "classe che usa `HasXotTable`" e' coperto da `analyse Modules` (0 errori); un utilizzatore esterno a `Modules/`
  (per esempio nei temi) non e' coperto dal percorso di `phpstan.neon`.
- `XotBaseTableWidget` dichiara ora `getTableColumns()` `protected` (come Filament): un'estensione fuori dal repo che lo
  ridefinisca con firma incompatibile non e' stata guardata.
- Nessun test Pest eseguito (database di test con dati reali).

## 2026-11-03: `HasDynamicFillable` nel progetto Quaeris

La tabella sopra da' `HasDynamicFillable` come "usato da `TechPlanner/app/Models/Client.php`". In questo progetto il modulo TechPlanner non c'e': dopo il pull PHPStan riportava `trait.unused`. Niente ignore e niente probe: aggiunto un test reale, `tests/Unit/Traits/HasDynamicFillableTest.php`, che esercita il trait su modelli anonimi (ammesso dalla regola no-phpstan-probe-models) e verifica il comportamento di `getFillable()`: valori degli enum in coda, nessun duplicato, fillable invariato senza enum. Vale in ogni progetto che condivide Xot. Usa `XotBaseTestCase`, che non apre il DB: 3 passed. PHPStan sull'intero progetto `[OK] No errors`.

Stesso giro, Quaeris: `ContactWidget::getTableQuery()` ha ricevuto `@not-deprecated` secondo questo pattern.
