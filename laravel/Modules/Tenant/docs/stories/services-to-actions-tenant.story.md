---
title: "[STORY] Tenant: via TenantService e Services/Config, tutto sulle Action"
type: story
status: done
priority: high
created: 2026-10-08
updated: 2026-10-08
module: Tenant
tags: [services, queueable-action, tenant, dead-code, swarm]
qmd: "tenant service config resolver registry eliminati action probe tenant finto"
issue: "https://github.com/provtv/module_tenant_fila5/issues/18"
discussion: "https://github.com/provtv/module_tenant_fila5/discussions/19"
related:
  - tenant-services-to-actions.story.md
  - ../concepts/tenant-service-to-actions-migration.md
  - ../../../../bashscripts/ai/wiki/rules/no-services-rule.md
  - ../../../../bashscripts/ai/wiki/memories/tenant-config-chain-never-wired.md
---

# Tenant: via TenantService e Services/Config, tutto sulle Action

Fase BMAD: Dev + Verify + Docs. Epic: `bmad-output/epic-code-standards-services-mixed-const.md` (onda 2, cluster Tenant).

## Richiesta

Convertire `app/Services/TenantService.php` (11 metodi, "13 chiamanti") e la famiglia `app/Services/Config/**` in Spatie Queueable
Actions, valutando con prove se la catena `ConfigResolverRegistry` + strategie ha senso come Action. Comportamento identico: un errore
qui rompe config e database di tutta l'app.

## Stato trovato

Questa e' la seconda volta che la conversione serve: la story `tenant-services-to-actions.story.md` (2026-09-04) aveva gia' eliminato
tutto, e prima ancora i commit `a85698f` (2026-07-02, catena) e `5f9fc59` (2026-07-12) erano gia' passati. Nel working tree i 7 file
erano tornati, insieme ai test che li usavano: l'HEAD del repo del modulo (`6b31874`) e' una squash che li contiene. Stessa dinamica
descritta in `bashscripts/ai/wiki/memories/ai-merge-laraxot-dev-resurrects-services-and-consts.md`.

## Analisi

### TenantService: facade 1:1, nessun use case proprio

Ogni metodo era `app(XAction::class)->execute(...)` su un'Action che esiste ed e' gia' `QueueableAction`. Non c'e' niente da creare.

| Metodo | Action (gia' esistente) |
|---|---|
| `getName()` | `Actions\GetTenantNameAction` |
| `filePath($f)` | `Actions\Config\GetTenantFilePathAction` |
| `config($k, $d)` | `Actions\Config\ResolveTenantConfigValueAction` |
| `getConfigPath($k)` | `Actions\Config\GetTenantConfigPathAction` |
| `getConfig($n)` | `Actions\Config\GetTenantConfigArrayAction` |
| `saveConfig($n, $d)` | `Actions\Config\SaveTenantConfigAction` |
| `getConfigNames()` | `Actions\Config\GetTenantConfigNamesAction` |
| `modelClass($n)` | `Actions\Models\ResolveTenantModelClassAction` |
| `model($n)` | `Actions\Models\ResolveTenantModelInstanceAction` |
| `trans($k)` | `Actions\Translations\TranslateTenantKeyAction` |
| `allModules()` | `Actions\Modules\GetTenantModulesAction` |

Mappa dei chiamanti (`rg` su Modules, Themes, config, provider, stringhe, blade, test):
- **Codice vivo: uno solo**, `Geo/app/Services/HereService.php` (`config('services.here.api_key')`). Ora usa `ResolveTenantConfigValueAction`
  (la stessa Action gia' usata da `Geo/Actions/Here/GetHereRouteSummaryAction`, che lo sostituisce).
- Test: `TenantCoverageBoostTest`, `TenantStatementCoverageTest` (facade) e `TenantGapsCoverageTest` (solo i resolver).
- Solo commenti o file inerti: 7 in Notify (`Datas/SMS/*`, `Datas/SmtpData.php`, codice commentato), `Cms/.../Breadcrumb.php` e
  `Cms/tests/.../SaveFooterConfigActionTest.php` (commenti), `User/resources/views/pages/index.blade.php` (riga commentata), 2 file
  `Xot/app/Datas/*.php.fixed` (non autoloadati). Non toccati (moduli di altri, nessun effetto a runtime): vedi "Aperto".
- Nessun binding in provider, nessuna config, nessuna stringa di classe.

### app/Actions/TenantAction.php: la facade rimasta travestita da Action

Copia della stessa facade (stesso docblock "TenantService - Facade sottile", `use QueueableAction` ma nessun `execute()`, 11 metodi statici),
**zero chiamanti** in tutto il monorepo. E' esattamente il contenitore che la procedura vieta; un chiamante convertito "per comodo" verso
questa classe avrebbe rimesso il Service sotto un altro nome. Eliminata.

### Services/Config/**: catena mai collegata, e incompatibile con il path vivo

Zero riferimenti di produzione. La storia (pickaxe `-S` su tutti i rami, fuori dalla cartella della catena) non trova un solo file che
abbia mai usato `ConfigResolverRegistry` o `findResolver`: nata il 2026-01-20 gia' scollegata, non e' logica tolta da un vecchio fix
PHPStan. I compiti delle tre strategie vivono altrove: modulo/connessioni database in `TenantServiceProvider::mergeModuleConnections()`,
`morph_map` in `registerMorphMap()`/`buildMorphMap()`, il resto in `ResolveTenantConfigValueAction`.

Prova che trasformarla in `ResolveTenantConfigAction` e collegarla cambierebbe il comportamento (probe sul tenant finto `probe/tenant`,
config `probe.tenant.*`, stessa app bootstrappata):

| Chiave | Path vivo (`ResolveTenantConfigValueAction`) | Catena (`findResolver($k)->resolve($k)`) |
|---|---|---|
| `database` | 28 connessioni (base + moduli + `probe_conn`) | `DatabaseConfigResolver` senza 2o argomento: `null`; `StandardConfigResolver`: solo `probe_conn` (il `merge` superficiale sostituisce `connections`) |
| `app.zz_missing` con default `'dflt'` | `'dflt'` | `Exception: Configuration key not found` |
| `app.name` | `Probe Tenant App` | `Probe Tenant App` (unico caso uguale) |

Inoltre il contratto non e' rispettato dalla sua stessa strategia: `ConfigResolverInterface::resolve($key, $default)` ma
`DatabaseConfigResolver` legge il secondo argomento come `$extraConf`. Collegare la catena avrebbe fatto perdere le connessioni database a
tutta l'app; lasciarla fuori da `Services/` ma dentro `Actions/` o `Contracts/` avrebbe solo spostato codice morto. Decisione: eliminata,
con il suo contratto e `ConfigStringKeyFilter` (duplicato byte per byte di `FilterConfigStringKeysAction` e
`MergeRecursiveStringKeyConfigAction`, entrambe esistenti e testate). Nessuna Action nuova, nessun Contract spostato.

## Modifiche

- Eliminati (recuperabili da `HEAD` del repo `laravel/Modules/Tenant`, `6b31874`): `app/Services/TenantService.php`,
  `app/Services/Config/ConfigResolverRegistry.php`, `ConfigStringKeyFilter.php`, `Contracts/ConfigResolverInterface.php`,
  `Resolvers/{Database,MorphMap,Standard}ConfigResolver.php`, `app/Actions/TenantAction.php`. La cartella `app/Services` non esiste piu'.
- `Geo/app/Services/HereService.php`: import e chiamata (2 righe) su `ResolveTenantConfigValueAction`, commento `dddx` allineato.
- `tests/Unit/TenantCoverageBoostTest.php`: via i 7 import Services e 5 `use` Action rimasti inutilizzati; il test del facade e' diventato
  `file path, config path and config value derive from the current tenant name` (Action reali, solo `GetTenantNameAction` finta); il test
  della catena e' ridotto a `DatabaseConfig model casts port and options` (la parte che non c'entrava con i resolver); tolte le asserzioni
  su `ConfigStringKeyFilter` (coperte da `FilterConfigStringKeysAction` e `MergeRecursiveStringKeyConfigAction`, stesso file).
- `tests/Unit/TenantStatementCoverageTest.php`: via il `describe` dei 4 test di resolver/registry; il test `...TenantService::model delegate` e'
  `ResolveTenantModelInstanceAction instantiates the resolved model class`; imports non piu' usati rimossi.
- `tests/Unit/TenantGapsCoverageTest.php`: via i 3 test dei resolver e il blocco `DatabaseConfigResolver` in coda al test del provider.
- Docs: nota datata in `docs/concepts/tenant-service-to-actions-migration.md`, link in `docs/00-INDEX.md`.

Le Action sottostanti e il provider non sono state modificate: `git status` del modulo mostra solo le 8 cancellazioni, i 3 test e i
file docs, piu' le modifiche di altri (`SushiToJsonPerformanceTest`).

## const e mixed

Nessuna `const` e nessun `mixed` nudo nei file toccati (tre test, `HereService`; `array<string, mixed>` di `HereService` e' la forma della
risposta JSON esterna di HERE, resta). Nei file eliminati non c'erano const.

## Verifica

- **Probe prima/dopo** (`/tmp/.../scratchpad/svc-tenant/probe.php`, bootstrap reale dell'app senza DB, tenant finto `probe/tenant`, file
  temporanei fuori dal repo): 19 uscite (nome, path, config con override, default, connessioni database, morph_map, getConfig/saveConfig su
  file, trans hit/miss, allModules, `model`, richiesta HTTP di `HereService` con `Http::fake`). Prima: via `TenantService`; dopo: via Action,
  `TenantService` cancellato. `diff before-service.json after-action.json`: **identici** (72 righe, 19 chiavi). Prima era gia' verificato
  `TenantService == Action`.
- `php -l` su `HereService.php` e sui tre test: nessun errore.
- PHPStan (`phpstan analyse` su `Modules/Geo/app/Services/HereService.php`, i 3 test e `Modules/Tenant/app`): `[OK] No errors`.
- Pest sui 3 test (gira anche qui, sqlite): 28 passati, 13 falliti. I 13 non dipendono da questa modifica: 12 sono
  `RuntimeException: Unexpected mockery expectation type` in `Tenant/tests/TestCase.php:208` (`expectMockery`, `Mockery::allows()` non
  restituisce `Expectation` con la versione installata), 1 e' `DomainsTable` senza la colonna `updated_at`; tutti su righe che non ho
  toccato. I test riscritti da me passano (`derive from the current tenant name`, `DatabaseConfig model casts`,
  `instantiates the resolved model class`).
- `rg` su Modules, Themes, config, app, bootstrap, routes (escluse docs e vendor): zero riferimenti a `Tenant\Services`, `TenantAction`,
  `ConfigResolver*`, `ConfigStringKeyFilter`, tranne i commenti elencati sopra e i due `.php.fixed`.

## Decisioni

- Eliminare invece di convertire la catena: e' codice morto con semantica diversa dal path vivo; un'Action o un Contract nuovi la
  avrebbero resa raggiungibile e pericolosa. Se un domani serve una strategia per chiave, si estende `ResolveTenantConfigValueAction`
  (che ha il comportamento verificato), non si riesuma la catena.
- Nessuna Action nuova: le 11 esistono tutte e coprono i 11 use case.
- Cancellata anche `TenantAction` (fuori dall'elenco, stesso modulo e stesso Service in abiti da Action, zero chiamanti).

## Aperto

- Commenti obsoleti che nominano `TenantService` in moduli non miei: `Notify/app/Datas/SMS/{SmsFactor,Agiletelecom,Twilio,Plivo,Nexmo,Gammu}Data.php`,
  `Notify/app/Datas/SmtpData.php`, `Cms/app/Filament/Clusters/Appearance/Pages/Breadcrumb.php`,
  `Cms/tests/Unit/Actions/SaveFooterConfigActionTest.php`, `User/resources/views/pages/index.blade.php`, `Xot/app/Datas/{XotData,xotdata}.php.fixed`.
- `Geo/app/Services/HereService.php` e' un residuo: esiste gia' `Geo/Actions/Here/GetHereRouteSummaryAction`; il Service Geo va al suo cluster.
- Rischio di nuova riesumazione dei file cancellati se un merge da `laraxot/dev` riporta la versione vecchia: controllare `git status` del
  modulo dopo il prossimo merge.
- I 13 test falliti sopra (TestCase `expectMockery`, `DomainsTable`) sono preesistenti e fuori perimetro.

## Riesuma 2026-10-20

Pull ha riportato `TenantService` + Config resolvers. Re-`rg`: zero produzione viva (solo commenti).
Rimosso di nuovo l'intero albero `app/Services/` del modulo. Nessuna Action nuova.

