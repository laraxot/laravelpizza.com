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
| coordinator | sync pizza mid-session: boot `<<` Cms→Media→Notify. Cms+Media routes fixed (no empty.php). **WAIT** Notify cwd sync; Filament discover Notify fallisce. | 2026-11-24 18:05 |
| coordinator | inventory + XotBaseServiceProvider bootstrap guard | 2026-11-24 done |
| coordinator | ground truth `analyse Modules` → 116 (`Geo` 102, `User` 7, `Xot` 4, `Notify` 3); TSV `.cursor-scratch/phpstan-wave/` | 2026-11-24 16:51 done |
| coordinator | bootstrap restore Lang+Notify markers; cold remeasure → **107** (`Geo` 99, `Meetup` 2, `Notify` 6) | 2026-11-24 17:11 |
| coordinator | **STOP repair su User**: `merge_remote_repo_2.sh laraxot` cwd=`Modules/User` (git gc). Gate bloccato da marker User (`module.json`, `HasTeams.php`). Ripresa dopo uscita sync. | 2026-11-24 17:19 |
| coordinator | post-sync: AssetAction/PanelMixin/lang parse; cold run **37** (`User` 28 lang dups, `Xot` 8 deadCode/assign, `UI` 1 trait.unused). Geo **0**. | 2026-11-24 17:30 |
| coordinator | cold after cache clear: **2** Meetup (`Event::scopePublished` vs `HasCommonScopes` su `XotBaseModel`). Root: trait tolto da `XotBaseModel`, resta su `NotificationTemplate`. | 2026-11-24 17:40 |
| coordinator | **VERIFY ZERO** `./vendor/bin/phpstan analyse Modules` → `file_errors: 0`. Cache stale poteva inventare 594 `class.notFound` su XotBaseModel: sempre `clear-result-cache` prima del conteggio. | 2026-11-24 17:41 |
| coordinator | riporta utente 116 (Geo Helpers `Traits\` class.notFound + trait.unused + lang dups): autoload morto su `CoordinatePickerHelpers` (`class_exists` false finché `composer dump-autoload -o`); cold dopo dump → **0**. Sync attivo era su `base_ptvx`, non su pizza. | 2026-11-24 17:49 |
| coordinator | handoff cold verify: `composer dump-autoload -o` + `phpstan clear-result-cache` + `analyse Modules` → `file_errors=0`; status resta **verified-zero**. Artifact: [phpstan-modules-zero-handoff.md](./phpstan-modules-zero-handoff.md). Docs: Geo coordinate-picker helpers path/`use` FQCN; Meetup `event-published-scope`; prompt 37 dump-autoload. | 2026-11-24 17:52 |
| lane-xot-bootstrap-phpstan | Xot `php -l` app=0; `artisan about --only=environment` OK; ExportXls già clean (Excel raw laraxot/dev); cold `analyse Modules` → **0**; TSV `.cursor-scratch/phpstan-wave/` SUMMARY empty + BY_MODULE=(none)/0. Conferma: nessun marker/`empty.php` in app. | 2026-11-24 17:42 **done** |
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
| lane-markers-non-php | marker in file NON php fuori da `docs/` e `tests/`: `.gitignore` (9 moduli), User `package.json`/`vite.config.js`/`tailwind.config.js`, Geo `.gitattributes`/`vite.config.js`/`resources/js/components/map-filter-lit.js`/`public/assets/coordinate-picker-lit.{js,css}`, resti `.merge_file_*` dello script; poi `tests/` (Cms 116, User 35, Xot 24, Geo 16) e `docs/` | 2026-11-24 17:28 session 9bacbaa5, in-progress. Non tocca `app/` (altre lane). Kit: `bashscripts/tools/git/sync-repair/`. **17:54 fatto**: Geo `map-filter-lit.js` risolto (feature `initial-selected` tenuta, `node --check` ok), assets Geo `coordinate-picker-lit.{js,css}` ricostruiti da `npm ci` + `vite build` in scratch (manifest identico, 0 marker), User/Geo config, 9 `.gitignore`. Restano 3 md (Notify `.github`, Xot `CHANGELOG.md`) e tests/docs: **in attesa uscita sync** |
| coordinator | **17:43 sync RIAVVIATO in questo progetto**: due istanze `merge_remote_repo_2.sh laraxot` (pid 2037889 su Cms, 2169936 su Activity) e `git gc --prune=now --aggressive` su bashscripts; alle 18:01 sono quattro. **18:23**: un'altra corsia ha ripulito quasi tutto (marker 3601 -> 183: 164 in `docs/`, 14 in `tests/`, 4 `.gitignore` e 1 md Notify rimarkerati dal sync); produzione PHP senza parse error; `analyse Modules` con cache privata = **0 errori** (run con il sync ancora attivo, vale solo per questo istante). **18:29: di nuovo rosso.** Il sync e' arrivato su UI: marker risaliti a 1619 (docs 1473, tests 32) e 5+ file di produzione `UI/app/Actions/**` rimarkerati, piu' i `.gitignore` di Activity/Lang/Notify/UI. Quattro istanze attive sullo stesso albero (due su Job: 2037889 e 2362698; una su User: 2169936; una di ptvx su Xot): si pestano a vicenda. Il gate non resta a zero finche' girano; lo stop e' una decisione dell'utente. Strumento nuovo per quando escono: `nested_resolve.py` (sezione in `sync-repair-tools.md`). Il file di cache condiviso `storage/app/phpstan/resultCache.php` puo' risultare illeggibile con piu' finestre: usare `-c scratchpad/phpstan/private.neon` (tmpDir privato). Marker tornati a 3601 (Notify 2919, User 256, Cms 216, Geo 87); 3 file di produzione rimarkerati (`Cms/routes/api.php` = parse error nel boot, `head.blade.php`, `foot.blade.php`). Il verde delle 17:43 (`analyse Modules` con cache privata `-c scratchpad/phpstan/private.neon`: 0 errori) non vale piu'. Le mie `--apply` delle 17:44 (resolve_by_common_blob + classify) sono partite 25 secondi dopo l'avvio e sono state in parte sovrascritte; backup di tutti i file con marker prima (`scratchpad/markers-backup.tar.gz`). **Non riparare finche' il sync non esce** (waiter `wait_sync_exit.sh`, controllo cwd e `PWD` subito prima di ogni `--apply`), poi rilanciare tutta la pipeline | 2026-11-24 18:01 |
| lane-docs-audit | audit read-only dei `docs/` di moduli e temi (`docs-organizer.py audit`, 19:10): 18 perimetri, **16.334 md, 27.604 link relativi di cui 14.722 rotti (53%)**, 2.822 corpi duplicati, 810 collisioni di maiuscole, 1.927 stub, 26 nomi con data; front matter completo 0-25% (Seo 89%). Il grosso e' concentrato: User ha 4 `INDEX.md`/`index.md` di archivio con ~11.000 link (`archive/index.md` 3089, `INDEX.md` 3076, `_archive/INDEX.md` 2976, `index.md` 2165), UI `_archive/INDEX.md` 992: sono indici generati da script deprecato, da rigenerare o scartare, non da riparare link per link. Causa dei rotti in User: MOVED_MANY 9144, MOVED_UNIQUE 3279, NO_MATCH 2878. Piano dopo l'uscita del sync: `docs-organizer.py links --fix --tail` (solo bersagli univoci), `dups --fix` (copie -> superseded), niente rinomine a mano; i `md-filenames.py plan` (7 rinomine) | 2026-11-24 19:10, in attesa sync |
| lane-dry-mixed-prompts | tre analisi read-only in swarm: ridondanza PHP tra moduli (`dry/report.md`), audit `mixed` con firme proposte (`mixed/report.md`), audit dei 68 prompt di `bashscripts/docs/prompts` con diff proposti (`prompts/proposed.diff`); nulla applicato, report in scratchpad | swarm bg 19:08 |
| lane-nested-markers | prototipo di risolutore per marker annidati (Notify docs ~2900 file: il kit li lascia intatti), solo su copie in scratch, validato a campione | swarm bg 17:58 |
| lane-ai-corpus | analisi read-only di `bashscripts/ai` (13k md: skill, wiki, memories): cosa si puo' ridurre senza rompere il ponte `.agents` | swarm bg 17:58 |
| lane-bashscripts-md | richiesta utente «troppi .md in bashscripts»: `docs/` gia' raggruppato per scopo da altra finestra, riparati 24 file di riferimenti e 18 link. Dettaglio: [bashscripts-docs-layout-by-purpose](../../../../../../bashscripts/docs/stories/bashscripts-docs-layout-by-purpose.story.md) | 2026-11-24 18:01 (resto aperto nella story) |

## Rules

- **Sync script in corso = non riparare.** `merge_remote_repo_2.sh` visita i pacchetti in ordine di `gitmodules.ini` (Activity, Cms, Gdpr, Geo, Job, Lang, Media, Meetup, Notify, Seo, Tenant, UI, User, Xot, poi `Themes/Meetup`) e rimette marker in ognuno. Si controlla per directory, non con il `pgrep` globale: vedi `bashscripts/docs/operations/sync-repair-tools.md`. Si ripara dopo la sua uscita, un pacchetto gia' visitato e' stabile.
- **`trait.unused`: solo due trait hanno consumatori VERI in altri progetti e NON si parcheggiano ne' si cancellano.** Censimento completo delle 10 trait (sessione 9bacbaa5, 2026-11-24): parola intera + import `Modules\<M>\` in `_bases/base_{quaeris,ptvx,fixcity,passaparola,restaurant,roosko,predict}_fila5/laravel/{Modules/*/app,app}`.
  - `Xot\Models\Policies\Concerns\RequiresOperationalPermissions`: roosko, **33 file** (tutte le policy di `Labeling` e `Processing`). Ha anche uno scopo di sicurezza (ADR `module-admin-role-policy-bypass`: senza, chi ha `{modulo}::admin` puo' rettificare pesi ed eliminare conferimenti). File `.php` vivo con `@phpstan-ignore trait.unused` nel docblock, come alla base `dd46996a4`; il parcheggio delle 16:41 e' stato annullato alle 17:11.
  - `Xot\Traits\HasCustomRelations`: quaeris (`QuestionChart`, `SurveyPdf`). La corsia xot-notify l'ha collegata a `XotBaseModel` (17:05): ora e' usata e non serve nessun ignore, scelta migliore dell'annotazione.
  - Le altre 8 (Geo `GeographicalScopes`/`HasPlaceTrait`/`SushiToJsons`, Notify `HasNotificationRateLimiting`/`Tracking`/`HasTenantNotifications`, Xot `HasCommonScopes`/`HasSchemalessAttributes`): zero consumatori in tutti i progetti, parcheggio/rimozione ok ([42](../../../../../../bashscripts/docs/prompts/42-rimozione-file-obsoleti.md)).
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

## Marker di conflitto: stato misurato (24 novembre, 18:02, `git grep` per repo e `rg` concordano)

Causa: `bashscripts/git/subtrees/merge_remote_repo_2.sh` (deprecato, 3 istanze vive in questo repo) fa `commit -am .`, merge a storie non correlate e `push -uf`, e a ogni passata riscrive i marker. Riparare prima che esca e' lavoro buttato. Vedi [[sync-unrelated-histories-repair]].

- **Gia' committati e pushati**: 118 file non-test e non-docs negli HEAD annidati (User 70, UI 15, Lang 13, Notify 13, Cms 3, Media 2, Activity 1, Xot 1; 65 sotto `app/`). `laraxot/dev` uguale a HEAD in Activity, Media, Notify, UI, User e Xot. 114 sono gia' riparati a mano nella working tree ma non committati; 9 file PHP di `Lang/app` sono stati rotti di nuovo alle 18:02.
- **PHPStan**: lo zero errori vale per le 17:41. Finche' lo script riscrive `Lang/app` (9 file con `php -l` che fallisce) il conto non e' zero per colpa dei marker, non del codice.
- **Il bootstrap si rompe con un solo marker in `routes/` o `config/`**: `Cms/routes/api.php` ha dato ParseError e `artisan` non partiva (riparato in `2b64656e`, 17:59). Per questo `xot:build-test-sqlite` e il test `RequiresOperationalPermissionsTest` (ripristinato da `4f7a60841^`, guarda che il ruolo del pannello non conceda permessi operativi) non sono ancora stati eseguiti.
- **Test**: `phpunit.xml` esegue come `Project` solo `Modules/Meetup/tests` e li' i marker sono 0. Nella suite dei moduli sono rotti 159 file (Cms 114, User 30, Xot 13, Lang 1, Notify 1).
- **Il kit non basta da solo**: `classify_conflict_hunks.py` in dry-run su 162 file di test lascia 161 file a giudizio (142 hunk divergenti, 6 meccanici; i 115 file di Cms/Notify con marker annidati vengono saltati). Serve `resolve_by_common_blob.py` (tre vie, `SYNC_BASE=dd46996a4`, 0 marker verificati sotto `laravel/`).
- **Ordine dopo l'uscita dello script**: backup di `laravel/Modules` e `laravel/Themes`; dry-run e poi `--apply` di `resolve_by_common_blob.py` per pacchetto; `classify_conflict_hunks.py --apply`; `find_sync_regressions.py` e `find_remote_only_losses.py` (con `--before` l'ultimo commit remoto vero prima del 24/11); resto a mano; `phpstan clear-result-cache`, PHPStan completo, `pest --testsuite=Project`. Comandi esatti: `bashscripts/docs/operations/sync-repair-tools.md`.

## Verify

```bash
cd laravel && php -l Modules/Xot/app/Providers/XotBaseServiceProvider.php
./vendor/bin/phpstan analyse Modules --error-format=json --no-progress
```
