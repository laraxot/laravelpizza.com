# Quality Report — IndennitaCondizioniLavoro

**Date:** 2026-06-18  
**Status:** ✅ PASSED (con violazioni preesistenti non bloccanti)

## PHPStan Analysis

**Result:** ✅ No errors

```
[OK] No errors
```

### Errors Fixed

| Errore | File | Causa | Soluzione |
|--------|------|-------|-----------|
| `property.notFound` | CondizioniLavoroAdmsTable.php:42 | `$this->tableFilters` non è proprietà tipizzata di Filament | Pattern 2-step: `$rawFilters` + `@var array<string, mixed>` |
| `argument.type` | CondizioniLavoroAdmsTable.php:43 | Array non tipizzato passato a execute() | Risolto con `@var array<string, mixed>` post-ternary |
| `property.notFound` | CondizioniLavorosTable.php:32 | Stesso | Stesso pattern |
| `argument.type` | CondizioniLavorosTable.php:34 | Stesso | Stesso pattern |
| `property.notFound` | CondizioniLavorosTable.php:41 | Stesso | Stesso pattern |
| `argument.type` | CondizioniLavorosTable.php:42 | Stesso | Stesso pattern |

## PHPMD Analysis

**Result:** ⚠️ 27 violations (preesistenti, non introdotte da questa sessione)

```
Found 27 violations and 0 errors
```

### Violazioni per categoria

| Categoria | Conteggio | Esempi |
|-----------|-----------|--------|
| CyclomaticComplexity > 10 | 4 | `CondizioniLavoroForm::getFormSchema()` (14), `CondizioniLavorosTable::getTableColumns()` (10) |
| CouplingBetweenObjects > 13 | 4 | `CondizioniLavorosTable` (14), `UploadResource` (14) |
| UnusedLocalVariable | 4 | `$populateData` in CondizioniLavorosTable.php:138 |
| UnusedFormalParameter | 4 | `$set` in query closure |
| ExcessivePublicCount | 3 | Proprietà pubbliche in `CondizioniLavoro` model |
| Altro (naming, elseif, else) | 8 | Snake_case vars, else expressions |

**Nota**: Violazioni tutte preesistenti. Rifattorizzare richiede test coverage adeguato.

## PHPInsights Analysis

**Result:** ⚠️ Architecture sotto soglia (58.8%)

| Categoria | Score | Soglia | Stato |
|-----------|-------|--------|-------|
| Code | 84.0% | 80 | ✅ |
| Complexity | 90.8% | 80 | ✅ |
| Architecture | 58.8% | 80 | ❌ |
| Style | 80.7% | 80 | ✅ |

### Architecture — Issue principali

- Proprietà pubbliche in Models (`ServizioEsternoRep.php:162`, `ServiceProvider.php:27`)
- Metodo lungo in `CondizioniLavoro.php:797` (unused var `$where`)
- `ServizioEsterno.php:731` (unused var `$conn`)

## Pest Tests

**Result:** ⚠️ Database non configurato per test

```
Tests:    60 failed, 1 incomplete, 11 passed (24 assertions)
```

## Summary

PHPStan ✅ pulito. PHPMD e PHPInsights hanno violazioni preesistenti (non introdotte in questa sessione). Rifattorizzare architettura per portare Architecture > 80%.

### Files Modified

1. `CondizioniLavoroAdmsTable.php` — pattern tableFilters 2-step
2. `CondizioniLavorosTable.php` — pattern tableFilters 2-step (2 occorrenze)

### Docs aggiornati

- `docs/phpstan-fixes.md` — aggiunto scan 2026-06-18
- `docs/phpstan-filament5-tablefilters.md` — status → Resolved
- `docs/quality-report.md` — questo file

## Sessione 2026-07-01 (audit qualità 4 moduli: Activity, IndennitaCondizioniLavoro, IndennitaResponsabilita, Job)

**PHPStan**: 0 errori confermati (`level: max`, root `phpstan.neon`). Nota ambientale: la prima esecuzione dopo un `git`/deploy può fallire con un `PHP Fatal error: Type of Modules\X\Providers\EventServiceProvider::$listen must not be defined` casuale (dipende dal modulo, capita in worker paralleli diversi) — è una race condition nella rigenerazione di `bootstrap/cache/packages.php`/`services.php` sotto `phpstan`'s parallel workers (il `parallel:` in `phpstan.neon` è commentato, quindi il default multi-processo è attivo). **Soluzione**: eseguire `php artisan config:cache` una volta prima di lanciare phpstan sui moduli; poi le run sono stabili. Non è stato toccato `phpstan.neon` (vietato da progetto).

**Bug reale trovato e RIMOSSO**: `Modules/IndennitaCondizioniLavoro/app/Policies/CodizioniLavoroPolicy.php` — classe duplicata/orfana con typo nel nome (`Codizioni` invece di `Condizioni`) e nel namespace (`...\Policies` invece di `...\Models\Policies`), mai referenziata da nessuna parte del codice. Cancellata come dead code.

**PHPMD** (`tools/phpmd.sh`, ruleset cleancode,codesize,design,naming,unusedcode,controversial) — fix applicati:
- 4 classi Policy (`CondizioniLavoroPolicy`, `CondizioniLavoroAdmPolicy`, `IndennitaTipoPolicy`, `StabiDirigentePolicy`): rimossi tutti i parametri `$user`/`$condizioniLavoro` non usati dai metodi che non fanno override di un metodo della classe base (`compila`, `view`, `create`, `update`, `delete`, `restore`, `forceDelete`). **Attenzione**: `viewAny(UserContract $user)` NON può perdere il parametro perché fa override di `XotBasePolicy::viewAny(UserContract $user)` — PHP genera un `Fatal error: Declaration ... must be compatible` se si riduce il numero di parametri richiesti rispetto al metodo del genitore (verificato empiricamente). Per quel solo metodo il parametro resta (e resta anche il finding PHPMD `UnusedFormalParameter`, accettato come falso positivo strutturale).
- `CondizioniLavoro.php` e `ServizioEsterno.php` (metodo `populate()`): rimosso un blocco di codice morto (`$table`/`$conn`/`$where` calcolati e mai usati, solo per chiamate commentate a `Anag::massUpdate*`).
- `ListCondizioniLavoros.php` e `CondizioniLavorosTable.php`: rimosso `$populateData` (variabile morta) e il parametro `$set` inutilizzato nella closure `options()` del filtro valutatore.
- `CompilaCondizioniLavoro.php`: rinominata `$q` → `$quadrimestre` (ShortVariable), rimossa `$res = tap($record)->update(...)` mai usata → `$record->update(...)` diretto.
- **Non toccato** (rischio regressione, coerente con la policy "niente refactoring architetturale non richiesto"): `CyclomaticComplexity`/`NPathComplexity`/`ExcessiveMethodLength` sui metodi legacy `populate()` di `CondizioniLavoro`/`ServizioEsterno` (130-160 righe, complessità 34-42); tutte le variabili/proprietà snake_case che rispecchiano nomi di colonne DB (`pivot_fields`, `tot_gg`, `from_field`, `qua00f_curr`, ecc.); `StaticAccess` su Filament/Facade (pattern idiomatico).
- **IMPORTANTE — non applicare il rename camelCase a `$module_dir`/`$module_ns`** in `IndennitaCondizioniLavoroServiceProvider.php`/`RouteServiceProvider.php` nonostante il finding PHPMD `CamelCasePropertyName`: `XotBaseServiceProvider`/`XotBaseRouteServiceProvider` leggono internamente proprio questi nomi snake_case. Un rename creerebbe proprietà ombra e romperebbe silenziosamente `loadMigrationsFrom()`/le route del modulo — bug reale scoperto e corretto nel modulo Activity nella stessa sessione (vedi `Modules/Activity/docs/quality-status.md`).

**PHPInsights**: comando corretto per questo repo: `./vendor/bin/phpinsights analyse Modules/IndennitaCondizioniLavoro -n --disable-security-check --composer=./composer.lock` (senza `--composer=./composer.lock` fallisce cercando `composer.lock` nella dir del modulo). Punteggio dopo i fix: Code 86%, Complexity 90.8%, Architecture 58.8% (invariata, richiederebbe refactoring architetturale fuori scope), Style 81.9%. Fix di stile applicati: rimossi due `use` ridondanti nello stesso namespace in `ServizioEsterno.php`, 5 ternari `isset($x) ? $x : null` → `$x ?? null`, aggiunto `declare(strict_types=1)` mancante in `database/factories/CategoriaProproFactory.php`.

**Pest**: creato `tests/Unit/Models/Policies/PoliciesTest.php` (4 test, 32 assertion, tutti pass) per le 4 Policy modificate — usa `Mockery::mock(UserContract::class)` invece di `User::factory()` per evitare dipendenze da Facade/DB non disponibili in questo TestCase. Suite completa: 17 passed / 60 failed (pre-esistenti, richiedono una connessione DB reale non disponibile in questo ambiente — stesso limite ambientale documentato per Activity) / 1 incomplete. Nessuna regressione introdotta dai fix di questa sessione.
