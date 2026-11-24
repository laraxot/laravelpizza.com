---
title: "PHPStan Modules zero — standing swarm"
status: verified-zero
updated: 2026-11-24
qmd: "phpstan modules zero swarm conflict markers bootstrap"
---

# Story — PHPStan Modules zero (standing)

## Why

Gate `./vendor/bin/phpstan analyse Modules` must reach 0. Bootstrap failed on merge markers (`unexpected <<`) in `XotBaseServiceProvider`. Fix purpose/why at source; no `@phpstan-ignore`; `mixed` last resort.

## Coordinamento

| Agente | Scope | Claim |
|--------|-------|-------|
| coordinator | inventory + XotBaseServiceProvider bootstrap guard | 2026-11-24 done |
| coordinator | ground truth `analyse Modules` → 116 (`Geo` 102, `User` 7, `Xot` 4, `Notify` 3); TSV `.cursor-scratch/phpstan-wave/` | 2026-11-24 16:51 done |
| coordinator | bootstrap restore Lang+Notify markers; cold remeasure → **107** (`Geo` 99, `Meetup` 2, `Notify` 6) | 2026-11-24 17:11 |
| coordinator | **STOP repair su User**: `merge_remote_repo_2.sh laraxot` cwd=`Modules/User` (git gc). Gate bloccato da marker User (`module.json`, `HasTeams.php`). Ripresa dopo uscita sync. | 2026-11-24 17:19 |
| coordinator | post-sync: AssetAction/PanelMixin/lang parse; cold run **37** (`User` 28 lang dups, `Xot` 8 deadCode/assign, `UI` 1 trait.unused). Geo **0**. | 2026-11-24 17:30 |
| coordinator | cold after cache clear: **2** Meetup (`Event::scopePublished` vs `HasCommonScopes` su `XotBaseModel`). Root: trait tolto da `XotBaseModel`, resta su `NotificationTemplate`. | 2026-11-24 17:40 |
| coordinator | **VERIFY ZERO** `./vendor/bin/phpstan analyse Modules` → `file_errors: 0`. Cache stale poteva inventare 594 `class.notFound` su XotBaseModel: sempre `clear-result-cache` prima del conteggio. | 2026-11-24 17:41 |
| lane-user-lang-2 | User lang `array.duplicateKey` wave | swarm bg |
| lane-xot-ui-residual | Xot deadCode + RelationX + UI TableLayoutTrait | **done 2026-11-24** — `analyse Modules/Xot Modules/UI` → **0**. Dead return già assenti (MetatagData/ListRecords/ExportXls); SchemaWidget solo `$resolver()`; `UI\Traits\TableLayoutTrait` in `docs/parcheggio` (vivo: `Filament/Actions/Table`); RelationX ok post-cache-clear; `HasCommonScopes`→`Module` (non su XotBaseModel: rompe Event::scopePublished); test UI riallineati al trait Filament |
| lane-geo-types | `HasCoordinatePicker` missingType.iterableValue → delegate Nominatim to helpers | swarm bg `aa649b2e` |
| lane-meetup-notify | Event `Builder<$this>` + Notify HasTenantNotifications generics | swarm bg `9f3faa4c` |
| lane-geo-phpstan | `Modules/Geo` PHPStan zero | **done 2026-11-24** — before ~102; after 0 (`analyse Modules/Geo`). Root: HasCoordinatePicker `use` CoordinatePickerHelpers + thin wrappers; removed dead GeographicalScopes/HasPlaceTrait/SushiToJsons/HasAddresses; GeoTrait+orderByDistance; Location uses HasAddress (cross-module trait was unused in Geo scope) |
| lane-user-lang | User lang `array.duplicateKey` | done — 0 User errors on cold run |
| lane-xot-notify-traits | Xot/Notify trait.unused | done — wire/parcheggio per censimento cross-base |
| lane-composer-user-xot-notify | TSV User(7)+Xot(4)+Notify(3) | **done 2026-11-24** — before 7/4/3; after **0/0/0** (`analyse Modules/{User,Xot,Notify}`). User: lang dup keys (peer). Xot: wire `HasCommonScopes`+`HasCustomRelations`→`XotBaseModel`, `HasSchemalessAttributes`→`BaseExtra`, `RequiresOperationalPermissions`→`OperationalXotBasePolicy`, `HasExtraTrait`→`Feed`, `NavigationPageLabelTrait`→`Test`. Notify: rate/tracking→`GenericNotification`; tenant→`TenantNotifiable` (peer). tests esclusi da neon → consumer in `app/`. |
| lane-xot | `Modules/Xot/app/**` production conflict PHP | 2026-11-24 done — 24 file app PHP: marker rimossi; preferito laraxot/dev su Safe/tipi/Excel/symlink/tenant-register; HEAD su EnvPage/XotBasePage/ListRecords/Metatag filament_primary; no `@phpstan-ignore` |
| lane-user | `Modules/User/app/**` + migrations/lang conflicts | superseded by lane-user-lang for PHPStan |
| lane-cms | `Modules/Cms/app/**` + config | 2026-11-24 done — vedi [cms-app-merge-conflict-lane.story.md](../../../Cms/docs/bmad/stories/cms-app-merge-conflict-lane.story.md) |
| lane-geo | `Modules/Geo` PHPStan zero | **in-progress 2026-11-24** — HasCoordinatePicker `self::normalizeCoordinate`; removed dead traits GeographicalScopes/HasPlaceTrait/SushiToJsons/HasAddresses; GeoTrait+orderByDistance; claim: composer-geo-phpstan |
| lane-lang-ui-notify-media | Lang/UI/Media/Notify/Job/Gdpr app conflicts | swarm bg |
| lane-theme-meetup | `Themes/Meetup/**` only: 5 marker files + silent sync regressions (`find_sync_regressions.py Themes/Meetup`, SYNC_BASE=`dd46996a4`) | 2026-11-24 session 9bacbaa5 — **done 17:24 dopo l'uscita dello script**: 0 regressioni (`find_sync_regressions.py`), `ThemeIntegrityTest` 3/3; non toccare il tema da altre lane |
| lane-markers-non-php | marker in file NON php fuori da `docs/` e `tests/`: `.gitignore` (9 moduli), User `package.json`/`vite.config.js`/`tailwind.config.js`, Geo `.gitattributes`/`vite.config.js`/`resources/js/components/map-filter-lit.js`/`public/assets/coordinate-picker-lit.{js,css}`, resti `.merge_file_*` dello script; poi `tests/` (Cms 116, User 35, Xot 24, Geo 16) e `docs/` | 2026-11-24 17:28 session 9bacbaa5, in-progress. Non tocca `app/` (altre lane). Kit: `bashscripts/tools/git/sync-repair/` |

## Rules

- **Sync script in corso = non riparare.** `merge_remote_repo_2.sh` visita i pacchetti in ordine di `gitmodules.ini` (Activity, Cms, Gdpr, Geo, Job, Lang, Media, Meetup, Notify, Seo, Tenant, UI, User, Xot, poi `Themes/Meetup`) e rimette marker in ognuno. Si controlla per directory, non con il `pgrep` globale: vedi `bashscripts/docs/sync-repair-tools.md`. Si ripara dopo la sua uscita, un pacchetto gia' visitato e' stabile.
- **`trait.unused`: solo due trait hanno consumatori VERI in altri progetti e NON si parcheggiano ne' si cancellano.** Censimento completo delle 10 trait (sessione 9bacbaa5, 2026-11-24): parola intera + import `Modules\<M>\` in `_bases/base_{quaeris,ptvx,fixcity,passaparola,restaurant,roosko,predict}_fila5/laravel/{Modules/*/app,app}`.
  - `Xot\Models\Policies\Concerns\RequiresOperationalPermissions`: roosko, **33 file** (tutte le policy di `Labeling` e `Processing`). Ha anche uno scopo di sicurezza (ADR `module-admin-role-policy-bypass`: senza, chi ha `{modulo}::admin` puo' rettificare pesi ed eliminare conferimenti). File `.php` vivo con `@phpstan-ignore trait.unused` nel docblock, come alla base `dd46996a4`; il parcheggio delle 16:41 e' stato annullato alle 17:11.
  - `Xot\Traits\HasCustomRelations`: quaeris (`QuestionChart`, `SurveyPdf`). La corsia xot-notify l'ha collegata a `XotBaseModel` (17:05): ora e' usata e non serve nessun ignore, scelta migliore dell'annotazione.
  - Le altre 8 (Geo `GeographicalScopes`/`HasPlaceTrait`/`SushiToJsons`, Notify `HasNotificationRateLimiting`/`Tracking`/`HasTenantNotifications`, Xot `HasCommonScopes`/`HasSchemalessAttributes`): zero consumatori in tutti i progetti, parcheggio/rimozione ok ([42](../../../../../bashscripts/docs/prompts/42-rimozione-file-obsoleti.md)).
  - Il censimento per **nome corto** da' falsi positivi: `HasSchemalessAttributes` compare in `User/Profile.php` di ogni progetto ma e' la trait Spatie con alias, e `BaseExtra` importa quella Xot ma usa `SchemalessAttributesTrait` (`use` morto). L'analisi di **una cartella sola** da' `trait.unused` fasulli su trait usate fuori dal path (`DeniesUndeclaredFilamentAbilities`, usata da `XotBasePolicy` e `RolePolicy`): vale solo il run su `Modules`.
- Prefer keeping intentional guards from laraxot/dev when HEAD side is empty.
- Never recreate `require …/Xot/routes/empty.php` (ADR `no-shared-empty-route-file`).
- Update module `docs/` with reusable decisions; md kebab, no dates in filenames.
- After conflicts cleared: re-run PHPStan JSON ground truth, then type-fix waves.

## Trait.unused wave (2026-11-24) — Xot + Notify

PHPStan `paths: Modules/` con `excludePaths: docs/*, tests/*` → i test non contano; no probe, no `@phpstan-ignore`.

| Trait | Decisione |
|-------|-----------|
| `RequiresOperationalPermissions` | wired via `OperationalXotBasePolicy` (base Roosko/Waste) |
| `HasCommonScopes` | **solo** `Notify\Models\NotificationTemplate` (DRY `scopeActive`). **Mai** su `XotBaseModel`: rompe `Meetup\Event::scopePublished` (status ≠ published_at) |
| `HasCustomRelations` | gia' su `XotBaseModel` (consumer piattaforma) |
| `HasSchemalessAttributes` (Xot) | wired su `BaseExtra` (Spatie resta su Profile) |
| `HasNotificationRateLimiting` / `Tracking` | wired su `GenericNotification` |
| `HasTenantNotifications` | wired su `TenantNotifiable` (+ opz. Notification) |

Verify: `./vendor/bin/phpstan analyse Modules/Xot Modules/Notify --no-progress --memory-limit=2G`

## Verify

```bash
cd laravel && php -l Modules/Xot/app/Providers/XotBaseServiceProvider.php
./vendor/bin/phpstan analyse Modules --error-format=json --no-progress
```
