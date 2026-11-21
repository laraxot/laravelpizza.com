---
title: "Audit approfondito modulo Xot"
type: audit
status: review
updated: 2026-11-16
module: Xot
qmd: "audit Xot core confini Actions-over-Services public_path data-sacred PHPStan max XotBasePolicy before once TestDatabaseGuard"
---

# Audit approfondito — Xot

## Scopo (il perché)

Xot è il **kernel Laraxot**: classi base (`XotBaseResource`, `XotBasePage`,
`XotBasePolicy`, `XotBaseMigration`, `XotBaseServiceProvider`), Actions riusabili
(Spatie Queueable), contratti (`UserContract`), guardie di test. Esiste perché ogni
modulo non debba reinventare Filament/policy/migrazioni: un'unica regola, scritta una volta
([purpose.md](../purpose.md)). Per questo il rischio di Xot è la **dipendenza al contrario**
(il core che conosce i moduli feature) e le **regole implicite** che ereditano tutti.

## Metodo

Source-first, 2026-11-16: `find`/`grep` sul filesystem, lettura di `XotBasePolicy`,
`Concerns/DeniesUndeclaredFilamentAbilities`, `Application::publicPath`, `TestDatabaseGuard`,
`BuildTestSqliteCommand`, `HandleArtisanActRequestAction`, ispezione di `Onceable` nel vendor.

## Inventario misurato

| Area | N | Nota |
|---|---:|---|
| PHP in `app/` | 602 | |
| Test PHP | 329 | 220 file con `test()/it()/describe()` |
| Models | 51 | |
| Policy | 15 | 2 `return true` |
| Resource / Pages / Widget | 7 / 29 / 16 | |
| Actions (file sotto `Actions/`) | 257 | 210 file usano `QueueableAction` |
| Services | 2 | `Services/RouteService.php` (354 righe), `Services/Artisan/Handlers/ModuleCommandHandler.php` |
| Migration | 10 | |
| Lang IT | 149 file | |
| Marker conflitto | 0 | |
| `dd/dddx` attivi | 0 | ~40 occorrenze tutte in commenti (es. `RouteService.php:111-263`) |
| `property_exists` | 0 attivi | 1 su componente Livewire (`HasXotTable.php:524`, lecito), 3 in docblock |
| `@phpstan-ignore` in `app/` | 20 | 10 sono `trait.unused` su trait senza consumer |
| `--force` in codice | 6 file | vedi P2-X4 |
| `public_path()` | 9 chiamate | nessun `laravel/public` letterale |
| `extends ServiceProvider` plain | 4 | 2 astratte base (ok), `RouteServiceProvider`, `FilamentOptimizationServiceProvider` |
| `use Modules\<altro>` | 481 verso Xot, 55 verso altri (33 classi distinte) | User 13, UI 11, Tenant 11, Lang 9, Cms 6, Notify 4, Media 1 |
| `->label('...')` non commentati | 18 (+6 vuoti) | es. `Filament/Builders/FilterBuilder.php` ×6 |

## Controlli positivi (verificati, da non rompere)

- `laravel/app/Application.php:16-18`: `publicPath()` → `{repo}/public_html`. Nessuna riga di Xot
  ricostruisce `laravel/public`.
- `Xot/tests/Support/TestDatabaseGuard.php:63`: il bootstrap dei test **rifiuta** ogni
  connessione il cui DB non finisce per `_test` (verificato lanciando Pest: errore esplicito).
- `Xot/tests/XotBaseTestCase.php:178`: nessun `TestCase` modulo può usare `migrate:fresh`;
  `RefreshDatabase` vietato; `tests/XotModuleSchema.php` è additivo.
- `HandleArtisanActRequestAction.php:71`: "Dati sacri: mai `--force` (solo migrate additivo)".
- `BuildTestSqliteCommand.php:86-110`: riscrive **ogni** connessione su SQLite prima di
  `migrate --force`, quindi il flag non può toccare MySQL.
- PHPStan modulo: 0 errori (vedi Gate).

## Finding

### P1-X1 — il core importa i moduli feature

`module.json` → `"requires": []` e `composer.json` non dichiara User/UI/Tenant/Lang/Cms/Notify/Media,
ma `Xot/app` importa classi da tutti (55 `use`): `UI\Filament\Tables\Columns\IDColumn` (6),
`Lang\Actions\SaveTransAction` (5), `Tenant\Actions\Config\GetTenantConfigArrayAction` (4),
`User\Models\Tenant` (3), `Cms\Models\Panels\XotBasePanel`, `Notify\Datas\SmtpData`, … I moduli
feature dipendono da Xot, quindi il grafo ha cicli: Xot non è avviabile/testabile da solo e un
rename in User/UI rompe il kernel. Rimedio KISS: contratti in `Xot/app/Contracts` (già esistono
`UserContract`, `TenantContract` in User → spostare) e import via container; elencare le
dipendenze reali in `module.json`. Mappa target in [module-boundary.md](../architecture/module-boundary.md).

### P1-X2 — `Services/` residuale contro Actions-over-Services

Solo 2 file, quindi correggibile: `RouteService` (354 righe, ~28 blocchi `dddx` commentati,
**1** chiamante fuori da Xot) e `ModuleCommandHandler` (13 righe, wrapper di
`RunArtisanCommandAction`). Convertire in Action o cancellare. Regola:
[actions-over-services](../../../../../../bashscripts/ai/wiki/rules/actions-over-services.md) (nota: `AGENTS.md` cita `Modules/Xot/docs/actions-over-services.md`, che non esiste: link morto da correggere).

### P2-X1 — `XotBasePolicy::before()` con `once()`

`Xot/app/Models/Policies/XotBasePolicy.php:21` memoizza con `once()`; il vendor
(`Illuminate/Support/Onceable.php`) hasha le variabili catturate con `spl_object_id($user)`,
ma la cache vive nella **istanza** della policy (che il Gate ricrea) → beneficio ≈ 0 e, in worker
long-running, rischio teorico di id riusato dopo il GC con ruoli cambiati. Rimuovere `once()`
(il costo è 2 `hasRole`, già memoizzati da Spatie). Il bypass `{modulo}::admin` è invece una
**scelta ADR** (`docs/wiki/decisions/module-admin-role-policy-bypass.md`): ma costringe ogni
policy sensibile a sovrascrivere `before()` — vedi **P0-U1** in
[User](../../../../User/docs/bmad/audits/user-audit.md).

### P2-X2 — 10 trait senza consumer con `@phpstan-ignore trait.unused`

`Models/Traits/HasCommonScopes.php`, `HasDynamicFillable.php`, `HasUuid.php`,
`Traits/Filament/HasCustomModelLabel.php`, `HasCsrfToken.php`, `HasCustomRelations.php`,
`EnumIntegerTrait.php` (motivato: API di piattaforma), `HasSchemalessAttributes.php`,
`HasTableFunctionsTrait.php`, `Datas/Concerns/HasYearsConfig.php`. La regola PTVX è "errori
corretti, non ignorati". Eliminare (git ricorda) o creare un consumer; resta ammesso solo
`EnumIntegerTrait` con la motivazione già scritta.

### P2-X3 — `HandleArtisanActRequestAction` senza chiamanti, input non validato

`Actions/Artisan/HandleArtisanActRequestAction.php:48-71`: da `Request::input('module')` costruisce
`'module:disable '.$moduleName` (concatenazione di stringa in un comando) ed espone
`queue:flush`, `optimize`, `config:cache`. Nessuna route/pagina lo richiama (grep su
`Modules/*/routes|Http|Filament`, `routes`, `app`): codice latente. Se venisse collegato
sarebbe una RCE-lite. Cancellare o proteggere con `SuperAdminOnlyTrait` + `Rule::in(moduli)`.

### P2-X4 — `--force` residui da annotare

`Console/Commands/GenerateFilamentResources.php:59` forza `make:filament-resource` (sovrascrive
file di Resource esistenti: generatore dev, non DB); `ThemeLinkCommand`, `ModuleLinkCommand`,
`SymlinkPublishCommand` hanno `--force` opt-in sui symlink (non cancellano cartelle reali:
`SymlinkPublishCommand.php:155`). Nessun `--force` su migrate fuori da SQLite di test. Accettabile;
aggiungere un guard `app()->isProduction()` al generatore.

### P2-X6 — link relativi rotti in docs

`docs/bmad/architecture.md` (3: `architecture/composite-filter-column-span.md`, `architecture/sync-modules-cli.md`, `architectural-rule-resource-vs-form.md`) e `docs/bmad/brainstorming.md` (2: `brainstorming/ternary-filter-compact-ui.md`, `discussions/01-traits-composition.md`) puntano a file inesistenti. Rimuovere o ricreare dove serve.

### P2-X5 — 18 `->label('...')` letterali e 14 import `Filament\...` diretti

`Filament/Builders/FilterBuilder.php`, `Resources/XotBaseResource/Pages/XotBaseManageRelatedRecords.php`,
`Traits/HasTableFunctionsTrait.php`. I 14 import `ListRecords/Page/Widget` sono usati come
type-hint nelle classi base (leciti in Xot, che è la fonte delle `XotBase*`).

## Gate

```bash
cd laravel
rm -rf /tmp/phpstan && php -d memory_limit=3G ./vendor/bin/phpstan analyse Modules/Xot --no-progress
./vendor/bin/pest Modules/Xot/tests --no-coverage      # NON eseguito
```

- PHPStan `Modules/Xot`: **0 errori** (rerun finale). Prima passata: 6+ errori
  `staticMethod.alreadyNarrowedType` in `tests/Unit/HostApp/FeatureFlagsTest.php:169-231`, file
  modificato nello stesso minuto da un altro agente (mtime 17:15) e verde alla seconda passata.
- Pest: **skip documentato**. DB di test `10.100.200.53:3306` irraggiungibile (TCP chiuso) e
  `TestDatabaseGuard` blocca `ptv_lara`. Nessun test lanciato contro MySQL locale (dati sacri).

## Piano

[epics.md](../epics.md) · [decision-log.md](../../decision-log.md) · [piano-miglioramento.md](../piano-miglioramento.md)

## Riferimenti

- [audit.md](../audit.md) · [story](../stories/module-bmad-audit.story.md) · [ECC](../../ecc/xot-ecc-audit.md)
- [Indice audit moduli](../module-audit-index.md)
