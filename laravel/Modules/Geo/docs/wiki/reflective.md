---
title: "Reflective Notes"
type: reflection-log
status: active
created: "2026-06-15"
updated: "2026-06-16"
tags: [reflection, phpstan, xot, quality-gate]
related:
  - "./patterns/xotbase-resource-table-configure.md"
  - "./patterns/phpstan-optional-contracts.md"
  - "./memories/phpstan-modules-inventory.md"
---

# Reflective Notes

## 2026-06-16 — `pest()->extend()` in `Pest.php` eager-autoloaded crasha PHPStan

**Perche e successo:** `Tenant` registra `tests/Pest.php` in `composer.json > autoload-dev.files` (serve per esporre gli helper `createTenant()`/`makeTenant()` quando CI lancia `pest Modules/Tenant/tests` — Pest **non** auto-carica il `Pest.php` di un modulo non presente nei testsuite di `phpunit.xml`). Ma quel `Pest.php` chiamava anche `pest()->extend(TestCase::class)->in(...)`: il `PendingCall::__destruct` invoca `TestSuite::getInstance()` e, in eager-autoload fuori dal runner Pest (PHPStan/artisan), lancia `InvalidPestCommand` → crash.

**Diagnosi chiave:** la chiamata `->in()` era **ridondante** — 23/24 test Tenant gia' dichiarano `uses(TestCase::class)` per file (pattern corretto, identico a `User`/`Notify`). Solo 1 file (`ApplicationPublicPathCoverageTest`) mancava il `uses()` e si appoggiava al binding globale.

**Come evitarlo:** in `Pest.php` eager-autoloaded mettere **solo** funzioni helper pure (nessuna pending call `pest()`/`expect()->extend()`). Il binding del TestCase va per-file con `uses(TestCase::class)`. Fix forward-only: rimosso `pest()->extend()->in()` da `Tenant/Pest.php`, aggiunto `uses()` al file mancante, ripristinato l'autoload `files` (Notify non aveva mai `pest()`: pure helpers, gia' safe).

**Prova:** `phpstan analyse Modules/Tenant|Notify` → 0 errori, nessun crash; `pest Modules/Tenant/tests/Unit/ApplicationPublicPathCoverageTest.php` → 3 passed.

## 2026-06-16 — Binding TestCase per-file: l'import deve precedere `uses()`

**Perche e successo:** rimosso il `pest()->extend()->in()` globale di Tenant, la suite non collezionava piu (`TestCaseClassOrTraitNotFound`). Cause nei singoli file: (a) `uses(TestCase::class)` **prima** della riga `use Modules\Tenant\Tests\TestCase;` → `TestCase::class` si risolve namespace-relative (`...\Unit\Models\TestCase`); (b) `uses(Tests\TestCase::class)` senza import → stringa verso classe inesistente; (c) file senza alcun `uses()`. Il `->in()` globale mascherava tutto questo.

**Come evitarlo:** in Pest l'import del TestCase **deve stare prima** della chiamata `uses()` (il `::class` e' risolto a compile-time ma un `use` posto dopo non si applica alla call gia' compilata sopra). Ogni test deve avere `uses(\…\TestCase::class)` con import corretto. Non affidarsi a binding globali `->in()` se il `Pest.php` e' eager-autoloaded.

**Scoperta collaterale (non risolta — fuori scope PHPStan-zero):** sbloccata la collection sono emersi drift test↔implementazione **pre-esistenti** mascherati dalla suite non avviabile: `GetTenantNameActionTest` (l'azione ritorna il path host-reversed solo se esiste la cartella `config/` corrispondente — logica multi-tenant intenzionale), `ResolveTenantModelClassActionTest` (mock con FQCN fittizi filtrati da `class_exists`). Richiedono fixture di dominio dedicate.

## 2026-06-16 — Regressione `App\Application::publicPath()` (realpath rimosso)

**Perche e successo:** `publicPath()` era stato semplificato a `return $publicRoot.'/'.$path` perdendo la canonicalizzazione `realpath`. Il test di copertura (mai eseguito davvero per il binding rotto sopra) codificava la spec corretta a 3 rami: (1) candidate esiste → `realpath(candidate)`; (2) solo `public_html` esiste → `realpath(root).'/'.segment`; (3) niente esiste → fallback normalizzato. L'import `Safe\Exceptions\FilesystemException` + `//use function Safe\realpath` erano residui della versione corretta.

**Come evitarlo:** quando un test "coverage" fallisce dopo un fix di binding, verificare se codifica una spec piu' ricca dell'implementazione corrente. Usare `Safe\realpath` (lancia `FilesystemException` su path assente) per restare compatibili col safe-rule PHPStan invece di `realpath()` nativo (flaggato unsafe).

**Prova:** 3/3 test verdi; `phpstan analyse app/Application.php` → 0 errori; `/admin/login` HTTP 200 (asset via `publicPath`).

## 2026-06-16 — Cache risultati PHPStan stale = errori fantasma

**Perche e successo:** primo giro su `User` riportava 14 errori `class.notFound` su `App\Models\User` in `CreateUserAction.php`, ma il file **non** referenzia piu quella classe (grep vuoto). Erano voci nella result-cache `/tmp/phpstan` da una sessione precedente, servite finche non invalidate.

**Come evitarlo:** in audit "porta a ZERO" eseguire sempre `./vendor/bin/phpstan clear-result-cache` prima della verifica finale. Mai usare `2>/dev/null` nel loop di conteggio: maschera i crash OOM dei worker paralleli e falsa lo "0 errori". I worker paralleli ignorano `--memory-limit` CLI (cap interno ~512M): per audit affidabile analizzare **per-modulo** sequenziale.

**Prova:** `clear-result-cache` + audit per-modulo (2G) → 0 errori, 0 crash su tutti i 33 moduli con `phpstan.neon` corrente (non modificato).

## 2026-06-15 — Ingresso Ptv in scope PHPStan

**Perche e successo:** `Ptv` e uscito da `excludePaths` nel neon. Le action Scheda usavano `class-string` dinamiche senza narrowing, contratti scheda senza `@property` Eloquent, e riferimenti a classi Performance/Activitylog non allineati al vendor reale.

**Come evitarlo:** per action batch su modelli generici introdurre un resolver tipizzato (`EloquentModelResolver`). I contratti dominio che espongono relazioni devono `@phpstan-require-extends Model`. Non dichiarare metodi di pacchetti disabilitati (activity log).

**Prova:** `phpstan analyse Modules` → 0 errori (701 file in scope).

**Pattern:** [`phpstan-scheda-actions.md`](../../laravel/Modules/Ptv/docs/wiki/concepts/phpstan-scheda-actions.md), [`block-rendering-and-optional-services.md`](../../laravel/Modules/UI/docs/wiki/concepts/block-rendering-and-optional-services.md).

## 2026-06-15 — PHPStan dipendenze opzionali e generic Eloquent

**Perche e successo:** il full scan analizzava solo i moduli non esclusi, ma `UI` e `User` importavano contratti di moduli assenti (`Geo`, `Cms`, `Comment`) o dichiaravano relazioni Eloquent con generic non allineati alla non-covarianza Larastan.

**Come evitarlo:** il modulo consumer deve esporre contratti locali o action-bridge verso moduli opzionali. I contratti Eloquent cross-modulo devono usare il declaring model `$this`, non `Model` generico, quando la relazione nasce da `$this->hasOne()` o `$this->belongsToManyX()`.

**Prova:** `cd laravel && ./vendor/bin/phpstan analyse Modules` -> 0 errori su 701 file con `phpstan.neon` corrente.

**Pattern collegato:** [`phpstan-optional-contracts.md`](patterns/phpstan-optional-contracts.md).

## 2026-06-15 — Collection Eloquent vs Support in action polimorfiche

**Perche e successo:** `Check::execute()` accetta `Illuminate\Support\Collection<int, Model>`. Passare `Eloquent\Collection<int, CriteriEsclusione>` fallisce per covarianza del template `TValue`.

**Come evitarlo:** usare `iterable<int, Model>` nella signature delle action che consumano relazioni Eloquent eterogenee; oppure bridge `Collection::make($eloquent->all())` solo se serve API Collection. Per attributi dinamici su modello transiente usare `setAttribute()` non property magic.

**Prova:** `phpstan analyse Modules/Ptv` -> 0 errori dopo allineamento `BaseSchedaResource`, `TrovaEsclusiBy*`.

## 2026-06-15 — Mai bypassare relazioni Eloquent per PHPStan

**Perché è successo:** `ListaAszTipCodEsclusoSubito` era stato “fixato” sostituendo `$scheda->asz()->ofRangeDate()` con `Asz00k1::query()` + filtri `matr`/`ente`/`aszann` duplicati — shortcut statico al posto del contratto relazione.

**Regola:** le relazioni sono DRY contract; PHPStan si risolve su contratto/generics (`HasMany<Asz00k1, Model>`), non re-query manuale.

**Come evitarlo:** TRIGGER_MAP riga cardinale → [eloquent-relationship-encapsulation.md](rules/eloquent-relationship-encapsulation.md); audit `bashscripts/tools/audit-eloquent-relationship-duplication.sh`.

**Prova:** revert + `phpstan analyse Modules` → 0 errori.

## 2026-06-15 — PHPStan Xot `new static()`

**Perche e successo:** `XotBaseResourceTable::configure()` era un metodo statico su classe astratta che istanziava `new static()`. PHPStan segnala correttamente due rischi: chiamata diretta sulla classe astratta e costruttori non coerenti nelle sottoclassi.

**Come evitarlo:** nelle basi astratte Xot non usare `new static()` per costruire classi concrete. Risolvere la classe concreta via container, proteggere la chiamata diretta alla base e validare il tipo con `Webmozart\Assert`.

**Prova:** `cd laravel && ./vendor/bin/phpstan analyse Modules` -> 0 errori su 892 file con `phpstan.neon` corrente.

**Insight collegato:** durante il rilancio una classe nuova (`GdprConsentForm`) ha richiesto `XotBaseSchemaWidget`, gia referenziata anche da Lang ma assente in Xot. La base vuota sopra `XotBaseWidget` mantiene DRY il contratto per widget schema-based.
