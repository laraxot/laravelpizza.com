---
title: "Audit approfondito modulo Tenant"
type: audit
status: review
updated: 2026-11-16
module: Tenant
<<<<<<< .merge_file_RDwQrY
qmd: "audit approfondito Tenant risoluzione tenant Host header TrustHosts policy bypass tenant admin DatabaseConfig password sushi PHPStan Pest"
=======
qmd: "audit approfondito Tenant inventario risoluzione tenant Host header TrustHosts policy bypass tenant admin DatabaseConfig password sushi Filament Actions PHPStan Pest"
>>>>>>> .merge_file_JaXCLH
---

# Audit approfondito — Tenant

<<<<<<< .merge_file_RDwQrY
## Metodo

Source-first (2026-11-16): inventario filesystem, `rg` su policy/marker/label,
lettura purpose esistente, PHPStan globale Modules già a 0 errori. Nessuna UI
inventata. Pest dichiarato solo se eseguito.

## Inventario misurato

| Area | Conteggio |
|---|---:|
| PHP in `app/` | 56 |
| Test PHP | 65 |
| Models (`app/Models/*.php`) | 10 |
| Policy files (approx) | 4 |
| Resource Filament | 1 |
| Actions | 19 |
| Services | 0 |
| Migration | 3 |
| Lang IT files | 14 |
| Marker conflitto | 0 |
| Occorrenze `return true` in Policy | 2 |
| Ratio test/app | 1.16 |

## Scopo (da docs esistenti / codice)

## Lo scopo in una frase **Tenant permette a una sola installazione di servire piu' enti senza che nessuno veda i dati dell'altro, e di farlo cambiando configurazione invece che codice.**

## Finding preliminari (da inventario)

- Nessun finding automatico critico dall'inventario; completare review sicurezza/runtime con story dedicate.

## Finding approfonditi (codice)

- **P0** Isolamento DB non automatico: `TenantSetting` senza global scope; test ammette leak cross-tenant.
- **P1** Isolamento reale = path filesystem (`GetTenantFilePathAction`), non row-level.
- **P2** Doppione modello Tenant in User.

## Gate

```bash
cd laravel
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Tenant
# Pest solo fuori da 10.100.200.15 e con DB testing raggiungibile
./vendor/bin/pest Modules/Tenant/tests --no-coverage
```

PHPStan `Modules` (2026-11-16): **0 errori** sul tree completo.

## Piano

Vedi [piano-miglioramento.md](../piano-miglioramento.md).

## Riferimenti

- [audit.md](../audit.md)
- [ECC](../../ecc/tenant-ecc-audit.md)
- [Story](../stories/module-bmad-audit.story.md)
=======
>>>>>>> .merge_file_JaXCLH
SSoT dei finding del modulo. Sintesi: [audit.md](../audit.md) · ECC: [tenant-ecc-audit.md](../../ecc/tenant-ecc-audit.md) · Story: [module-bmad-audit.story.md](../stories/module-bmad-audit.story.md) · Piano: [piano-miglioramento.md](../piano-miglioramento.md).

## Perché esiste (business)

**Lo scopo in una frase:** Tenant permette a una sola installazione di servire più enti senza che nessuno veda i dati dell'altro, e di farlo cambiando configurazione invece che codice.

Tenant fa servire più enti da una sola installazione cambiando **configurazione, non codice**: l'ente si riconosce dall'host e legge `config/<tenant>/…`. È attraversato da ogni richiesta, quindi un errore qui è un errore di isolamento fra enti — muto, perché il codice funziona e i dati sono di un altro. Per questo il rischio sta in *come si sceglie il tenant* e *chi può amministrarlo*, non nel volume di codice (56 file PHP).

## Metodo

Source-first: `find`/`rg` (2026-11-16), lettura dei file citati, PHPStan e Pest eseguiti (Pest dichiarato solo se eseguito; nessuna UI inventata). Nota: il working tree del modulo è stato aggiornato da altri agenti durante l'audit (merge `fa8507f` alle 17:11); i `path:line` sono riletti dopo quel merge.

## Inventario misurato

| Area | N | Nota |
|---|---:|---|
| PHP `app/` | 56 | purpose citava 52 |
| Test PHP / `*Test.php` | 65 / 45 | unit 35, feature 6, + integration/performance; ratio 1.16; 10 file "coverage" |
| Models top-level | 10 | 19 con Traits/Policies/Contracts |
| Policy | 2 | `TenantBasePolicy` (astratta), `DomainPolicy` |
| Resource / Pages / Widgets | 1 / 5 / 0 | solo `DomainResource` |
| Actions (`app/Actions`) | 19 | config, json, domini, ente, modelli, traduzioni |
| Services | 0 | purpose cita `TenantService::filePath()`: la classe non esiste |
| Migration / Seeder | 3 / 9 | settings, subscriptions, database_configs |
| Lang IT / EN / DE (file) | 7 / 3 / presente | |
| Raw SQL / `label('…')` / estensioni dirette Filament | 0 / 0 / 0 | |
| `@phpstan-ignore` in `app/` | 3 | tutti `trait.unused` |
| Marker conflitto / TODO | 0 / 0 | |
| Docs `.md` / maiuscole / con data | 502 / 19 / 1 | 18 coppie con collisione di maiuscole |

## Finding

### P0

Nessuno confermato.

### P1

| ID | Finding | Evidenza | Perché conta |
|---|---|---|---|
| TEN-P1-01 | **Il tenant si sceglie da `SERVER_NAME` o dall'header `Host` e `TrustHosts` non è attivo**: `request()->getHost()` è il fallback; il middleware `TrustHosts` esiste ma è commentato in `Kernel` e `bootstrap/app.php` ha `withMiddleware` vuoto. Mitigazioni reali: ogni parte dell'host passa da `Str::slug`, il tenant deve esistere come cartella in `config/`, altrimenti fallback al default. | [GetTenantNameAction.php:114-148](../../../app/Actions/GetTenantNameAction.php); [Kernel.php:17](../../../../../app/Http/Kernel.php); [bootstrap/app.php:17](../../../../../bootstrap/app.php) | Con un vhost catch-all, un `Host:` scelto dal client seleziona la configurazione (e la connessione DB) di un altro ente. Isolamento affidato alla sola configurazione del web server. |
| TEN-P1-02 | **`tenant::admin` aggira ogni policy del modulo**: `before()` ritorna `true` per qualsiasi ability, `delete`/`forceDelete` compresi, senza alcuna guardia (quella `$ability !== ''` protegge solo il ramo `super-admin`). È una scelta dichiarata nel codice (ADR Xot `module-admin-role-policy-bypass`, "il ruolo che apre il pannello gestisce tutto il modulo"): il difetto non è la scelta ma che nessun test ne fissa il perimetro. | [TenantBasePolicy.php:14-22](../../../app/Models/Policies/TenantBasePolicy.php); la matrice `domain.*` di [DomainPolicy.php](../../../app/Models/Policies/DomainPolicy.php) non è mai raggiunta da chi ha il ruolo | Chi apre il pannello può cancellare domini senza permesso esplicito. |
| TEN-P1-03 | **Credenziali DB in chiaro**: `DatabaseConfig` ha `password` in `$fillable`, nessun cast `encrypted`, nessun `$hidden`; colonna `string` nullable. Il model ha seeder e factory; oggi nessuna Resource lo espone (latente). | [DatabaseConfig.php:22-52](../../../app/Models/DatabaseConfig.php); [create_database_configs_table.php:21](../../../database/migrations/2026_07_24_000002_create_database_configs_table.php) | Un `toArray()`/export/log serializza la password; un dump del DB la espone. Cast `encrypted` + `$hidden` prima che qualcuno costruisca la UI (migrazione additiva dei dati esistenti, mai distruttiva). |

### P2

| ID | Finding | Evidenza |
|---|---|---|
| TEN-P2-01 | `SushiToJson` (405 righe) e `SushiToJsons` (264) sono due varianti dello stesso trait; `SushiToJsons` è consumato solo da `BaseModelJsons`, che non ha sottoclassi nel repo (solo factory/test). DRY. | [SushiToJson.php](../../../app/Models/Traits/SushiToJson.php), [SushiToJsons.php](../../../app/Models/Traits/SushiToJsons.php), [BaseModelJsons.php](../../../app/Models/BaseModelJsons.php) |
| TEN-P2-02 | `handleJsonDeleting` fa `unlink()` (`Safe\unlink`) senza controllare l'esistenza: se il file JSON manca, la cancellazione del record lancia. Il file JSON **è** il dato. | [SushiToJsons.php:262](../../../app/Models/Traits/SushiToJsons.php) |
| TEN-P2-03 | Codice di test in namespace di produzione: `TestSushiModel` (`app/Models`), `TestCommand` (`tenant:test`) e il residuo `TestCommand.php.test`; trait con `@phpstan-ignore trait.unused` ([SushiToCsv.php:17-19](../../../app/Models/Traits/SushiToCsv.php), [SushiToPhpArray.php:16](../../../app/Models/Traits/SushiToPhpArray.php)). |
| TEN-P2-04 | `TenantSetting`/`TenantSubscription`: `tenant_id` stringa senza FK, nessuna policy, **nessun global scope**: l'isolamento a livello riga non è automatico e il test `keeps rows separable without global scope` ([MultiTenantScopeTest.php](../../../tests/Feature/MultiTenantScopeTest.php)) fissa proprio che una query senza filtro restituisce le righe di entrambi i tenant. La prima analisi lo classificava P0; qui è P2 perché latente (nessuna Resource né query applicativa li legge). Oggi l'isolamento reale fra enti è quello per percorso (`GetTenantFilePathAction`, `config/<tenant>/`), non row-level. | [TenantSetting.php:41](../../../app/Models/TenantSetting.php), [TenantSubscription.php:41](../../../app/Models/TenantSubscription.php) |
| TEN-P2-05 | Docs con collisione di maiuscole (18 coppie): `bmad/architecture.md`/`ARCHITECTURE.md`, `bmad/api.md`/`API.md`, `bmad/changelog.md`/`CHANGELOG.md`, `bmad/readme.md`/`README.md`, `index.md`/`INDEX.md` in 7 cartelle; si rompono su filesystem case-insensitive. Più `README.en.md`, `readme-en.md`, `readme.en.md`, `readme.it.md`. |
| TEN-P2-06 | Docs: 40 file citano `TenantService::` (classe inesistente: la regola vive in [GetTenantFilePathAction](../../../app/Actions/Config/GetTenantFilePathAction.php)); purpose "52 file"; `epics.md`/`decision-log.md` erano template; `architecture.md` uno stub; story con data nel nome `module-bmad-audit-20260928.story.md` accanto a `module-bmad-audit.story.md` (stesso argomento). |
| TEN-P2-07 | 10 file di test "coverage" (`TenantCoverageBoostTest`, `TenantGapsCoverageTest`, `TenantStatementCoverageTest`, …) accanto a test di regola reali. |
| TEN-P2-08 | `Tenant` ([Tenant.php:68](../../../app/Models/Tenant.php)) e la sua factory esistono ma nessuna migration del repo crea `tenants` (`rg "create('tenants'"` su `Modules/*/database` e `laravel/database`: 0); le 3 migration del modulo coprono solo settings, subscriptions, database_configs. Chi la crea? Domanda aperta in [brainstorming.md](../brainstorming.md). Anche `brainstorming.md` citava `ConfigResolverRegistry`, `StandardConfigResolver` e `app/Services/TenantService.php` (0 occorrenze fuori docs: `app/Services` non esiste). |
| TEN-P2-09 | Due model `Tenant`: `Modules\Tenant\Models\Tenant` e `Modules\User\Models\Tenant` (`extends BaseTenant`); nome identico in moduli diversi, da chiarire il confine. | [Tenant.php:69](../../../app/Models/Tenant.php), `Modules/User/app/Models/Tenant.php:80` |

## Verificato OK

- Path traversal: `GetTenantFilePathAction` rifiuta assoluti, `\0` e segmenti `..` ([GetTenantFilePathAction.php:19-20](../../../app/Actions/Config/GetTenantFilePathAction.php)); `tenantNameFromPath` verifica con `realpath` che il tenant stia sotto `config/`.
- `File::deleteDirectory` ([:64](../../../app/Actions/Config/GetTenantFilePathAction.php)) è dentro `runningUnitTests()` e punta a `storage/framework/testing`: i test non toccano `config/`.
- PHPStan livello max, nessun ignore non motivato; 0 raw SQL, 0 label hardcoded, 0 estensioni dirette Filament.
- `declare(strict_types=1)` ovunque; test su sqlite/transazioni.

## Gate (2026-11-16)

```bash
cd laravel
php -d memory_limit=4G ./vendor/bin/phpstan analyse Modules/Tenant --no-progress   # exit 0
# Pest solo fuori da 10.100.200.15 e con DB testing raggiungibile
./vendor/bin/pest Modules/Tenant/tests --no-coverage
```

- **PHPStan Tenant: 0 errori** (level max, `ignoreErrors` vuoto, tests inclusi).
- **Pest Tenant: SKIP documentato.** Bootstrap Pest bloccato (singolo test Rating >150 s a 1% CPU, run completo Rating timeout 420 s; `DB_HOST=10.100.200.53:3306` non raggiungibile, load medio ~95). Nessun DB distruttivo; host non produttivo.

## Prossimi passi

[epics.md](../epics.md): Epic A (host fidato) → B (perimetro `tenant::admin`) → C (credenziali) → D (pulizia) → E (docs).
