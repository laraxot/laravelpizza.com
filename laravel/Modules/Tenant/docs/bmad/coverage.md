---
title: "Tenant Module Test Coverage"
module: "Tenant"
type: concept
tags: [coverage]
created: 2026-07-14
updated: 2026-09-07
qmd: "coverage"
related:
  - "./phpstan-corrections-january.md"
  - "./stories/phpstan-tenant-fix.md"
---
# Tenant Module Test Coverage

## Overview
This module has comprehensive test coverage with various test types implemented.

## Test Results
- **Tests Passed**: 0
- **Assertions**: 0
- **Test Types**: Unit, Feature, Integration tests

## Coverage Statistics
## Status

**2026-09-06**: philosophy.md created. PHPStan analyzed (OK). Pest suite (TBD). Coverage target: +5% per module.

### 2026-09-06 (sessione claude sonnet 5 — `phpstan-tenant-fix.md`)

PHPStan `Modules/Tenant` con cache pulita: **0 errori** prima e dopo le modifiche (nessuna
regressione introdotta). Dettaglio completo delle modifiche in
`docs/stories/phpstan-tenant-fix.md`: rimossi 7 docblock `@property-read User|null
$creator/$updater` stray (nessuna relazione reale, in conflitto con `ProfileContract` gia'
dichiarato su `BaseModel`), allineata `Tenant::users()` a `XotData::make()->getUserClass()`
+ `UserContract` (era `User::class` concreto), ristretto `TenantSetting::$value` da `mixed`
a `string|null` (colonna migration `text()` senza cast).

Pest (`./vendor/bin/pest Modules/Tenant/tests -c Modules/Tenant/phpunit.xml --no-coverage`):
run lanciato ma non ancora concluso entro il timeout di sessione (macchina condivisa con
molti agenti concorrenti attivi in questo momento — vedi
`docs/chat/2026-09-06-sonnet5-pest-fixes-plus-unclaimed-modules-wave.md`). Nessuno dei 7 file
model toccati ha un test dedicato mancante da aggiungere: i cambi sono solo su
docblock/type-hint (nessun comportamento runtime alterato), l'unico cambio con superficie di
comportamento e' `Tenant::users()` che resta semanticamente identico (stesso `hasMany`,
stessa foreign key di default, solo la resolution della classe concreta e' ora dinamica via
`XotData` invece di hardcoded — comportamento identico su questa installazione dato che
`getUserClass()` risolve a `Modules\User\Models\User`). PHPMD
(`./tools/phpmd.sh Modules/Tenant/app text phpmd.xml`): nessuna violazione nei file toccati.

- **Files**: 0
- **Lines of Code**: 0
- **Classes**: 0
- **Methods**: 0
- **Coverage Rate**: 0%

### 2026-09-07 (sessione claude sonnet 5 — campagna "PHPStan zero", `docs/stories/phpstan-tenant-fix.md`)

Al `git status` di apertura, `Modules/Tenant` aveva gia' un WIP concorrente non committato
(un altro agente stava applicando il fix repo-wide gia' chiuso in
`Modules/Xot/docs/stories/18.19.xotbaseresource-final-getformschema-table-illegal-override-repo-wide-fix.story.md`:
rimozione dell'override inline `getFormSchema()` su `DomainResource.php` — dead code, la
Resource-level bridge e' `final` e non lo chiama mai — e conversione da `static` a metodo di
**istanza** di `DomainForm::getFormSchema()` / `DomainInfolist::getInfolistSchema()`, coerente
col parent astratto `XotBaseResourceForm`/`XotBaseResourceInfolist`). Quel WIP era pero'
incompleto: i chiamanti nei test non erano stati aggiornati.

PHPStan `Modules/Tenant` (cache pulita) rilevava **3 errori reali** (tutti `method.staticCall`,
conseguenza diretta di quel WIP incompleto):

- `tests/Unit/TenantCoverageBoostTest.php:166` — `DomainForm::getFormSchema()` chiamata
  statica su metodo di istanza.
- `tests/Unit/TenantCoverageBoostTest.php:167` — `DomainInfolist::getInfolistSchema()` idem.
- `tests/Unit/TenantStatementCoverageTest.php:378` — `DomainResource::getFormSchema()`
  (ereditato da `XotBaseResource::getFormSchema()`, anch'esso istanza) chiamata staticamente.

**Causa radice**: `XotBaseResourceForm::getFormSchema()` e
`XotBaseResourceInfolist::getInfolistSchema()` sono `abstract public function` (mai
`static`); una chiamata `Class::metodo()` su un metodo non statico e' un `Error` fatale a
runtime in PHP 8, non solo un warning — confermato con una chiamata isolata sulle 2 righe
originali (`git stash` mirato ai soli 2 file di test, run isolato, ripristino):

```
Error: Non-static method Modules\Tenant\Filament\Resources\DomainResource\Schemas\DomainForm::getFormSchema() cannot be called statically
Error: Non-static method Modules\Xot\Filament\Resources\XotBaseResource::getFormSchema() cannot be called statically
```

**Fix** (pattern gia' documentato in
`bashscripts/ai/wiki/memories/geo-addressform-schema-reuse-static-call-bug.md` per i
chiamanti esterni legittimi): risolvere l'istanza dal container e chiamare il metodo su
quella, mai sulla classe:

- `DomainForm::getFormSchema()` → `app(DomainForm::class)->getFormSchema()`
- `DomainInfolist::getInfolistSchema()` → `app(DomainInfolist::class)->getInfolistSchema()`
- Il test `TenantStatementCoverageTest.php` verificava lo schema sulla `DomainResource`
  (bridge morto per costruzione, ritorna sempre `[]`): riscritto per verificare
  `app(DomainForm::class)->getFormSchema()`, dove lo schema reale vive davvero.
- Rimossi gli `use Filament\Forms\Components\{RichEditor,TextInput}` diventati orfani su
  `DomainResource.php` dopo la rimozione dell'override inline, e l'import ora inutilizzato
  di `DomainResource` in `TenantStatementCoverageTest.php`.

**Verifica**:
- PHPStan (`clear-result-cache` + `analyse Modules/Tenant --no-progress`): **3 → 0 errori**.
- PHPMD (`./tools/phpmd.sh Modules/Tenant text phpmd.xml`): stesse 4 violazioni pre-esistenti
  gia' note (`module_dir`/`module_ns` su `RouteServiceProvider`/`TenantServiceProvider`,
  template XotBase), nessuna nuova, nessuna nei file toccati.
- PHPInsights: `ComposerNotFound` (bug noto tooling quando scoped a un singolo modulo, vedi
  memoria `phpinsights-composer-lock-scoped-path`), non bloccante, non imputabile a questo fix.
- Pest, run completo (`./vendor/bin/pest Modules/Tenant/tests -c Modules/Tenant/phpunit.xml
  --no-coverage`, 515s su macchina condivisa con carico molto alto — load average ~40/24 core,
  8+ suite Pest di altri agenti in esecuzione in parallelo nello stesso momento):
  **120 passed / 21 failed / 32 skipped (940 assertions)**. I 2 test isolati dal fix
  (`TenantCoverageBoostTest::domain resource schemas and tables are executable`,
  `TenantStatementCoverageTest::DomainForm getFormSchema is executable`) passano entrambi
  (prima: `Error` fatale, non solo failure). I 21 failed residui sono pre-esistenti e non
  toccati da questa sessione (`ApplicationPublicPathCoverageTest`, `SushiToJsonTraitTest`,
  `Traits/SushiToJsonTest`, e diversi "Unexpected mockery expectation type" in
  `TenantCoverageBoostTest`/`TenantGapsCoverageTest`/`TenantStatementCoverageTest` —
  nessuno riferisce `DomainForm`/`DomainInfolist`/`DomainResource`, verificato per esclusione
  che non sono stati introdotti da questo fix).

**Coverage** (valore di riferimento: pass/fail Pest, non code coverage %, coerente con le
sessioni precedenti che non hanno mai completato un run con `--coverage` su questo modulo):
baseline nota piu' recente 2026-09-04 = 81 passed/64 failed/28 skipped (modulo evoluto molto
da allora); oggi 2026-09-07 = **120 passed/21 failed/32 skipped**. Nessuna regressione, 2 test
in piu' passano rispetto a un ipotetico run sullo stato pre-fix (che sarebbe fallito con
`Error` fatale su quei 2 test).

File toccati: `app/Filament/Resources/DomainResource.php` (solo cleanup import, il resto era
gia' WIP altrui), `app/Filament/Resources/DomainResource/Schemas/DomainForm.php` (gia' WIP
altrui, non ritoccato), `app/Filament/Resources/DomainResource/Schemas/DomainInfolist.php`
(idem), `tests/Unit/TenantCoverageBoostTest.php`, `tests/Unit/TenantStatementCoverageTest.php`.

## Test Categories
- Unit Tests
- Feature Tests
- Integration Tests

## Status
All tests are passing and coverage is being maintained.