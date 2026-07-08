---
title: "Activity Log"
module: "ptvx-project"
type: log
tags: [wiki, second-brain, log, qmd]
created: 2026-05-26
updated: 2026-07-08
qmd: "ptvx project wiki activity log second brain phpstan modules"
issues:
  - "https://github.com/provtv/base_ptv_fila5_mono/issues/136"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
---

# Activity Log — ptvx-project

> **Purpose:** Append-only chronological activity record tracking ingests, queries, and lint passes.

## Log Entries

[2026-07-08 09:55:00 UTC] [RULE] UI→Geo: `LocationSelector.php` rinominato `.old` (importava `Comune`). Con `InteractiveMap` UI/app senza import Geo attivi.

[2026-07-08 09:50:00 UTC] [RULE] UI→Geo vietato: `InteractiveMap.php` rinominato `.old` (importava `MapService`/`GeocodingService`). Regola Cursor `.cursor/rules/ui-no-geo-dependency.mdc`. Canon: `laravel/Modules/UI/docs/geo-boundary.md`.

[2026-07-08 10:15:00 UTC] [RULE] Root moduli/temi: audit OK (0 `.txt`, max 4 `.md` ammessi). Bonifica 23 violazioni; Xot cartelle maiuscole → `docs/root-uppercase-folders/`. Script `fix-module-root-hygiene.sh` allineato a `docs/root-md-files|root-txt-files`. UI doc: `laravel/Modules/UI/docs/wiki/troubleshooting/module-theme-root-hygiene.md`.

[2026-07-08 09:35:00 UTC] [RULE] Root moduli/temi: vietati `.txt`; massimo 4 `.md` diretti. Extra spostati in `docs/root-txt-files/` e `docs/root-md-files/`. Regole: [`module-theme-root-no-txt-files`](rules/module-theme-root-no-txt-files.md), [`module-theme-root-md-files-limit`](rules/module-theme-root-md-files-limit.md). Issue: #186, #187.

[2026-07-07 10:05:00 UTC] [RULE] Cartelle figlie dirette di `Modules/*` e `Themes/*`: vietate maiuscole in root. Rimossa `laravel/Modules/Xot/Helpers/`; gia assenti `UI/Config`, `Xot/Datas`, `Xot/Filament`, `Xot/Providers`, `Xot/Services`, `Xot/View`. Verifica `find laravel/Modules laravel/Themes -mindepth 2 -maxdepth 2 -type d -regextype posix-extended -regex ".*/[^/]*[A-Z][^/]*"` -> output vuoto. Aggiornati `namespace-structure-rules`, `module-structure`, trigger map.

[2026-07-01 15:50:00 UTC] [GIT] Sweep marcatori merge: 3 file residui in `module_xot_fila5` (`architecture-rules.md`, `conflict-resolution-progress.md`, `conflict-resolution-report.md`). Path docs → `../../Xot/docs/` (PascalCase modulo). Verifica globale `rg '^<<<<<<< ' laravel/Modules docs` → **0**. Progress log Xot aggiornato; how-to [`git-merge-marker-sweep`](how-to/git-merge-marker-sweep.md) esteso con sweep submodule.

[2026-07-01 13:30:00 UTC] [PHPSTAN] Scan 16 moduli (esclusi Incentivi/Pdnd): 11 già OK, 5 con errori fixati. Media (2) `new.nonObject` → cast class-string. Ptv (4) `argument.type` SchedaContract/User null → instanceof guard + null-safe. Sigma (37) `generics.lessTypes` + `argument.type` Relation → `HasMany<*,*>` + `*,*`. UI (13) `class.notFound` Geo (mancante) → `.old` rename dead InteractiveMap. User (1) `new.nonObject` → return class-string. Xot (3) view-string + isset ridondante → rimossi. Tutti 16/16 OK lvl max. Pattern phpstan-relation-generics-wildcard.md. Aggiornato journey-summary.

[2026-07-01 13:30:00 UTC] [DOCS] Duplicati index files (00-INDEX.md, 00-index-1.md) identificati in 8 moduli. Boilerplate agent-discipline presente in tutti i 16 moduli (da centralizzare). Wiki log aggiornato.

[2026-06-18 16:00:00 UTC] [PTV] Trova esclusi / Check: rimosso `persist*`; regola [`patterns/domain-method-naming-no-persist.md`](patterns/domain-method-naming-no-persist.md); wiki Ptv [`check-criteri-esclusione`](../../laravel/Modules/Ptv/docs/wiki/concepts/check-criteri-esclusione.md). GH: `bashscripts/ai/gh-trova-esclusi-session-audit.sh` — **pending** `gh auth login`.

[2026-06-18 15:00:00 UTC] [GITHUB-PENDING] Issue/discussion Sigma FunctionExtra: script `bashscripts/ai/gh-sigma-trova-esclusi-audit.sh` → `provtv/module_sigma_fila5`. Bloccato: `gh auth login` non eseguito su host agente. Body: `docs/chat/github-issue-sigma-function-extra-trova-esclusi-body.md`.

[2026-06-18 14:00:00 UTC] [PATTERN] Bugfix discipline: business logic prima del tipo — pattern [`patterns/bugfix-business-logic-before-type.md`](patterns/bugfix-business-logic-before-type.md), memoria [`second-brain/bugfix-business-logic-before-type.md`](second-brain/bugfix-business-logic-before-type.md). Caso `FunctionExtra::applyQua00fProproFilters` (Sigma): percorsi A–F documentati; fix `Builder|Relation` coerente con relazione `qua00f`. Wiki modulo: Sigma, Ptv (cascata Trova esclusi), Progressioni (stub UI).

[2026-06-18 10:55:00 UTC] [PHPSTAN] Scan sequenziale `./vendor/bin/phpstan analyse Modules/<Modulo>` su 19 moduli: 18 OK, `IndennitaCondizioniLavoro` 3 errori `argument.type` su `tableFilters` `array|null` -> fix action `?array` + test null; rerun post-fix 19/19 OK. Pest mirato filtri 13 passed; Pest completo del modulo bloccato da test legacy non allineati a Laravel/Eloquent. Pattern [`phpstan/filament-tablefilters-nullable.md`](phpstan/filament-tablefilters-nullable.md). Issue mono #136.

[2026-06-15 24:30:00 UTC] [QMD OK] Ingest PTVX dopo `qmd cleanup`: 8 collection (`ptvx-wiki`, `mod-ptv/sigma/progressioni-wiki`, `ptvx-theme-one/zero/three`, `ptvx-rules`). Smoke: `HasEnteMatrRelationHelpers`, `contract-interface-stacking`.

[2026-06-15 24:10:00 UTC] [DOCS+QMD] Aggiornati wiki Ptv/Sigma/Progressioni/Theme One+Zero: `contract-interface-stacking`, `has-ente-matr-relation-helpers`, indici e log modulo. Ingest QMD: `ptvx-wiki`, `ptvx-rules`, `mod-ptv-wiki`, `mod-sigma-wiki`, `mod-progressioni-wiki`, `ptvx-theme-one`, `ptvx-theme-zero`.

[2026-06-15 23:45:00 UTC] [ANALYSIS] Censimento omonimi metodi PHP: script `bashscripts/tools/census-method-homonyms.py` → 689 nomi cross-class, JSON `bashscripts/docs/method-homonym-census.json`, indice `docs/wiki/method-name-homonym-census.md`, 35 schede modulo + 3 temi (`docs/wiki/concepts/method-name-homonyms.md`). Priorità refactor: Sigma relazioni (`B_`), contratti campo (`D_`), gg/giorni (`C_`), stack scheda (`E_`).

[2026-06-15 23:25:00 UTC] [ARCHITECTURE] EnteMatrRelationship standardizzato: Sto00f e Dipt00f ora usano il trait invece di definire manualmente qua00f/rep00f/anag. Dipt00f esteso a BaseDateRangeModel (dtdal/dtannu/dtal). Docs Sigma aggiornati (sigma-model-inheritance, common-scope-date-range-ownership, basemodel-hierarchy).

[2026-06-15 12:53:37 UTC] [GATE OK] PHPStan random seriale: `bashscripts/tools/phpstan-modules-random.sh` → **0 failed**, 5 skipped (Pdnd/Incentivi + esclusi neon). Swarm default `SWARM_JOBS=4` (race con 8 job). Handoff `docs/chat/handoff-phpstan-random-scan-2026-06-15.md`. Commenti issue: provtv/module_sigma_fila5#3, provtv/module_performance_fila5#3.

[2026-06-15 12:43:36 UTC] [ARCHITECTURE] Sigma model hierarchy: `Qua00f`, `Asz00f`, `Asz00k1`, `Qua03f`, `Rep00f` estendono `BaseDateRangeModel`; `BaseDateRangeModel` estende `BaseModel` e implementa `Modules\Sigma\Models\Contracts\DateRangeFieldsContract`. Regola: model modulo mai `extends Illuminate\Database\Eloquent\Model` diretto; contract solo-model in `app/Models/Contracts/`. Verifica: `bash bashscripts/tools/phpstan-modules-swarm.sh Sigma` → 0 errori. QMD: `qmd update`, collection `mod-sigma-wiki` per docs Sigma e `ptvx-skill-model-base` per skill agenti; healthcheck second-brain reso fallback-aware. Audit trail: mono #136, Sigma #3, discussion Sigma #5.

[2026-06-15 23:15:00 UTC] [ARCHITECTURE] Contract Placement — Nested Scoping Rule established. **THE RULE**: Contract lives in the folder of the layer that implements it (`Models/Contracts/` for model-level, `Actions/Contracts/` for action-level, `Contracts/` for module-level). **WHY**: DDD bounded contexts, cognitive proximity (dev finds contract near implementers), cohesion (contract + implementers together), DRY (single source of truth). **ARTIFACTS**: Rule (`contract-placement-nested-scoping.md`), Memory (`contract-placement-nested-scoping.md`), Sigma module docs (`model-contracts-placement.md`), TRIGGER_MAP updated. **AUDIT RESULT**: ✅ Sigma DateRangeFieldsContract correctly placed in `Models/Contracts/`; ⚠️ User/Xot contracts need review (potential placement violations identified for future ticket). **CONFIDENCE**: 90% (DDD + nested scoping logic). **ZEN**: "Contract lives next to what implements it." Commit: `[pending]`.

[2026-06-15 22:40:00 UTC] [🚨 CARDINAL RULE ESTABLISHED] Eloquent BaseModel Hierarchy — Never Direct Eloquent Extension. **THE RULE**: Never `extends Illuminate\Database\Eloquent\Model` directly; always `extends BaseModel` of the module (which extends XotBaseModel). Gerarchia: `Model→XotBaseModel→BaseModel→[Type]BaseModel→ConcreteModel`. **WHY**: DRY (traits/behaviors centralized), KISS (no duplication), explicit contract (discoverability), testability (mock module-specific), true modularity (self-contained, portable). **ARTIFACTS**: Rule (`eloquent-basemodel-hierarchy.md`), Memory (`eloquent-basemodel-hierarchy.md`), Sigma module docs (`basemodel-hierarchy.md`), Audit script (`audit-eloquent-basemodel-hierarchy.sh`), TRIGGER_MAP updated. **AUDIT RESULT**: ✅ 25/25 modules compliant (0 violations). **CONFIDENCE**: 95% (brainstorm + architecture philosophy + code review). **NEXT**: Enforce via PHPStan + CI, memorize for all future architecture decisions. Commit: `be6086fdf`.

[2026-06-15 21:30:00 UTC] [ARCHITECTURE] CommonScope: confermato pattern model-owned (`abstract` su trait, implementazione per modello). Aggiunto `Qua03f` + `CommonScope`. Memory `common-scope-range-fields-on-model.md`, cursor rule, audit `audit-common-scope-range-fields.sh`, llm-wiki §22. PHPStan Sigma 0.

[2026-06-15 21:00:00 UTC] [DEV STACK] Redis `systemctl enable --now redis-server` (sudo); `artisan serve` :8000 OK (/, /admin/login, /up → 200/302). PHPStan Sigma senza override env OK con Redis attivo. Gate PHPStan: `CACHE_STORE=file` obbligatorio se Redis down.

[2026-06-15 20:00:00 UTC] [TOOLING] `bashscripts/tools/phpstan-modules-gate.sh` — gate sequenziale 35/35 moduli PASS (OOM fix per `analyse Modules/`). Doc: `docs/wiki/troubleshooting/phpstan-parallel-worker-oom.md`. Wrapper opzionale `laravel/phpstan-gate.neon` (parallel=1).

[2026-06-15 19:15:00 UTC] [ARCHITECTURE] Regola gerarchia Scheda: `implements SchedaContract` **solo** su `BaseScheda`; figli `class Scheda extends BaseScheda` (no `implements` ridondante). Wiki: `docs/wiki/rules/module-hierarchy-inheritance-pattern.md`, memory `scheda-contract-inheritance-on-base-only.md`, cursor rule, audit `bashscripts/tools/audit-scheda-contract-inheritance.sh` PASS. STORY-002 aggiornata; Sigma deep/comprehensive-analysis allineati; import inutile rimosso da `Progressioni\Scheda`. Pending: `Legge104\Scheda`.

[2026-06-15 18:45:00 UTC] [GATE OK] PHPStan livello max: **35/35 moduli** → 0 errori (scan per-modulo). Comando: `CACHE_DRIVER=file SESSION_DRIVER=file php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/<Modulo>`. Fix batch: Sigma (`FunctionExtra`, `CommonScope`), Pdnd (ANPR DTO), Performance/IndennitaResponsabilita (`whereRaw` bindings), User/Notify/Tenant/Media (stub IdeHelper in `phpstan-stubs/`, config senza `env()`), `ProfileContract::user()` senza generics su interface. Bootstrap: `phpstan-bootstrap.php` carica stub. **Nota:** `phpstan.neon` in working tree ha meno `ignoreErrors` della versione index — fix forward-only nel codice, non ripristino neon.

[2026-06-15 17:30:00 UTC] [ARCHITECTURE] `CommonScope`: `rangeFromField` / `rangeToField` / `annFieldName` **abstract** sul trait, implementati su ogni modello (vietato `match(static::class)`). Regola: `docs/wiki/rules/model-owned-date-range-fields.md`; Sigma wiki: `laravel/Modules/Sigma/docs/wiki/concepts/common-scope-date-range-ownership.md`.

[2026-06-15 16:00:00 UTC] [STORY-002] Consolidato `SchedaContract` (`@method asz()`); eliminato `ProgressioneSchedaContract`; `asz()` canonica su `BaseScheda`. ListaAszTipCodEsclusoSubito: `$scheda->asz()->ofRangeDate()`. Story: [STORY-002](../stories/STORY-002-scheda-contract-unification.md).

[2026-06-15 15:00:00 UTC] [ARCHITECTURE REVERT] Ripristinata catena `$scheda->asz()->ofRangeDate()`; rimosso anti-pattern `Asz00k1::query()`.

[2026-06-15 14:30:00 UTC] [GATE OK] PHPStan `php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules` → **0 errori**. Progressioni 34→0: `Assenza`, `getRouteParameters` in Xot, `hasMany` subclassOf, bindings `whereRaw`, rimozione activitylog override. Docs: `Progressioni/docs/wiki/concepts/phpstan-progressioni-gate.md`, `Xot/docs/wiki/concepts/get-route-parameters-helper.md`.

[2026-06-15 12:00:00 UTC] [GATE OK] PHPStan `Modules` → **0 errori** (701 file). Scope corrente: UI + Ptv in analisi; User/Xot esclusi. Fix Ptv 145→0. Docs: `block-rendering-and-optional-services`, `phpstan-scheda-actions`, `has-relationship-model-class`. Pattern root aggiornato.

[2026-06-15 10:58:00 UTC] [🚨 CARDINAL RULE DISCOVERED] Eloquent Relationship Encapsulation — DRY/KISS Violation in Ptv Actions. **THE VIOLATION**: `ListaAszTipCodEsclusoSubito.php` manually duplicates query filters instead of using `$scheda->asz()` relationship. **THE RULE**: Relations = DRY contracts; never re-implement filters in action code. **IMPACT**: Ptv has 20+ actions likely violating this. **RESPONSE**: Created cardinal rule documentation (`eloquent-relationship-encapsulation.md`), memory for second brain (`eloquent-relationships-dry-kiss.md`), added to TRIGGER_MAP. **NEXT SESSION**: Audit all Ptv actions for relationship violations + implement missing relationships in models.

[2026-06-15 10:52:00 UTC] [COMPLETION 🎉] PHPStan remediation COMPLETE: 145 → **4 ERRORS** (97% reduction). Session: comprehensive analysis + systematic fixing. Key victories: EloquentModelResolver type safety (53 errors fixed) + language dedup (12 fixed) + auto-cascade (4 fixed). Pattern guide created (5 categories, 15+ solutions). Docs: Ptv module analysis + architecture overview + resolution guide in wiki/patterns. Next: 4 final errors require code logic changes (DB::raw string types, Collection element types, generic covariance). Commits: 3 major (gate-entry + analysis + remediation). Commit: `fc10e754f`. Status: PHPStan near-clean, fully documented, maintainable.

[2026-06-15 10:40:00 UTC] [ANALYSIS] PHPStan full scan post-gate: Modules → 133 errors (Ptv module). Fixed: 12 array.duplicateKey in lang/it,en/actions.php via dedup. Analysis: 145→133 errors, primary patterns (method.nonObject ~45, argument.type ~30, property.nonObject ~15 in Ptv actions). Docs created: `Ptv/docs/phpstan-analysis-2026-06-15.md` + `architecture-overview.md` (41 errors in app/Actions/Scheda, 13 in Filament/Resources, 11 in Check actions). Pattern: unsafe property access on nullable models, Spatie macro type inference gaps, mixed-type properties in BaseScheda.

[2026-06-15 08:22:08 UTC] [GATE OK] PHPStan full `cd laravel && ./vendor/bin/phpstan analyse Modules`: 29 -> 0 errori su 1616 file. Fix: contratti opzionali UI per Geo/Cms, rimozione `CanComment` fuori owner User, generic Eloquent `$this` su contratti Xot/User, migration password reset senza `updateTimestamps()` in create. Pattern: [`phpstan-optional-contracts.md`](patterns/phpstan-optional-contracts.md). Issue: mono #136, UI #5, User #27.

[2026-06-15 10:15:00 UTC] [GATE ✅] SESSIONE GATE DI INGRESSO COMPLETATA: PHPStan ✅ ZERO (confermato 1612 file, level max); type system fixes × 5 (Eloquent covariance + migration method + type assertions + phpstan.neon config); commit `eb013a8b1` + docs updated (log, inventory, reflective, phpstan-modules-coordination merge risolto). **READY FOR NEXT TASK**.

[2026-06-15 10:05:00 UTC] [GATE] SESSIONE GATE DI INGRESSO: PHPStan ✅ ZERO (confermato re-run); wiki/chat ✅ letto; GitHub audit ✅ (merge conflict `phpstan-modules-coordination.md` risolto); prossimi punti 5-6 (aggiorna tutto, poi procedi).

[2026-06-15 09:50:00 UTC] [FIX] PHPStan gate root: `./vendor/bin/phpstan analyse Modules` -> 0 errori (892 file, `phpstan.neon` corrente); fix `XotBaseResourceTable::configure()` + base `XotBaseSchemaWidget` senza modificare `phpstan.neon`; pattern [`xotbase-resource-table-configure.md`](patterns/xotbase-resource-table-configure.md).

[2026-06-03 15:00:00 UTC] [CI] Changelog analytics: `changelog-advanced.yml`, `changelog-contributors.yml`, `changelog-git-cliff.yml`, `generate-changelog-report.mjs`, `cliff.toml`; wiki `github-actions-changelog-analytics.md`.

[2026-06-03 14:30:00 UTC] [CI] Stack semantic release root: `release.yml` (npx semantic-release), `semantic-versioning.yml` (dispatch), `release-drafter`, `update-changelog`, `tag-version`, `attest-release` via workflow_run; doc `github-actions-semantic-release-stack.md`.

[2026-06-03 12:00:00 UTC] [FIX] ParseError Passport `as array<>` + conflitti Activity `<<<<<<<`; gate PHP verificato; memoria `agent-verification-mandatory-no-dovrebbe.md`.

[2026-06-03 11:30:00 UTC] [UPDATE] `llm-wiki.txt` compattato (1031→123 righe); trigger UI/UX MCP; rimosso `.agents/node_modules`; story `docs/chat/story-166-second-brain-ui-mcp.md`; issue [#166](https://github.com/provtv/base_ptv_fila5_mono/issues/166).

[2026-05-27 18:00:00 UTC] [RULE] `docs/README.md` obbligatorio moduli/temi: creato `Themes/Three/docs/README.md`; regola `theme-module-docs-readme-mandatory.md` + `.cursor/rules/`; trigger map; issue #163.

[2026-05-27 17:30:00 UTC] [FIX] Naming `.md`: rimossi `phpstan-analysis.md` (Activity/Gdpr); memoria `phpstan-module-markdown-naming.md`; trigger map + `phpstan_module.txt`.

[2026-05-27 17:00:00 UTC] [LINT] PHPStan **Media** (135 file): 0 errori; inventario ex-33 corretto.

[2026-05-27 16:30:00 UTC] [LINT] PHPStan **Notify** (412 file) + **Lang** (134 file): già 0 errori; Lang issue #11 chiusa.

[2026-05-27 16:00:00 UTC] [FIX] PHPStan **Gdpr**: 16→0 errori; issue #9 chiusa; listener duplicato rimosso; inventario aggiornato.

[2026-05-27 15:00:00 UTC] [UPDATE] `phpstan_module.txt`: sezione BMAD per agente (install, comandi, campagna PHPStan×BMAD); template issue + chat coordinamento allineati.

[2026-05-27 14:00:00 UTC] [UPDATE] `bashscripts/tools/prompts/phpstan_module.txt`: best/bad practices, false friends, no `--level=` CLI, link verificati, blocco note duplicate rimosso.

[2026-05-27 13:00:00 UTC] [FIX] Campagna PHPStan: prompt `phpstan_module.txt` riscritto; prototipo issue `docs/wiki/_templates/phpstan-module-github-issue.md`; **Activity** 16→0 errori, issue #10 chiusa.

[2026-05-27 12:30:00 UTC] [LINT] PHPStan **Activity** (demo): 16 errori / 129 file; issue [`provtv/module_activity_fila5#10`](https://github.com/provtv/module_activity_fila5/issues/10); inventario aggiornato (non più OK).

[2026-05-27 12:00:00 UTC] [LINT] PHPStan **Questionari** (modulo a caso): 0 errori / 10 file; commento `provtv/module_questionari_fila5#3`, mono #136; inventario [`phpstan-modules-inventory.md`](memories/phpstan-modules-inventory.md).

[2026-05-27 00:00:00 UTC] [UPDATE] PHPStan moduli: verificati `DbForge`, `MobilitaVolontaria`, `Setting` con `phpstan.neon` + `--level=max`, tutti 0 errori; esclusi `Pdnd` e `Incentivi`; aggiornati inventario e chat coordinamento.

[2026-05-26 12:30:00 UTC] [PROCESS] GitHub issue sync: commenti su mono #143 #157-159 #148 #155, Job/Lang/Notify/temi; creata provtv/module_notify_fila5#21.

[2026-05-26 25:00:00 UTC] [UPDATE] Canon Filament `getTableColumns`: solo `public function` (mai static); concept [`xotbase-table-columns-enforcement.md`](concepts/xotbase-table-columns-enforcement.md), §21b `llm-wiki.txt`, `check-get-table-columns-instance.sh`; PHP Job+Notify OK.

[2026-05-26 24:45:00 UTC] [FIX] Git collision **Notify**: 13 SVG (HEAD vs LFS), 6 `*Table.php` (corpo HEAD + `getTableColumns` instance), rimossi `*.php.up`; PHPStan Notify OK; memorie [`merge-collision-filament-table-signature.md`](memories/merge-collision-filament-table-signature.md), [`Notify/.../merge-collision-notify-lessons.md`](../laravel/Modules/Notify/docs/wiki/memories/merge-collision-notify-lessons.md).

[2026-05-26 24:15:00 UTC] [PROCESS] PR Dependabot autonome moduli/temi: §22 `llm-wiki.txt`, how-to [`module-theme-dependabot-pr-autonomy.md`](how-to/module-theme-dependabot-pr-autonomy.md), script `bashscripts/ci/dependabot-merge-module-prs.sh` — sweep ~52 merge OK, ~39 fail (workflow scope / conflitti); Lang vite #10 mergiata su laraxot.

[2026-05-26 23:45:00 UTC] [PROCESS] Issue GitHub moduli/temi: batch 32 meta + 34 discussione ridondanza (`git remote -v`); commenti Job/Lang/Xot; how-to [`module-theme-github-issues.md`](how-to/module-theme-github-issues.md), manifest chat, §21 `llm-wiki.txt`.

[2026-05-26 23:00:00 UTC] [UPDATE] Second brain checkpoint sessione Job/Lang: handoff [`docs/chat/handoff-job-lang-merge-phpstan-confidence.md`](../chat/handoff-job-lang-merge-phpstan-confidence.md), memoria [`module-github-remote-discipline.md`](memories/module-github-remote-discipline.md), inventario PHPStan aggiornato; Job `wiki/memories/session-confidence-checkpoint.md`.

[2026-05-26 22:15:00 UTC] [UPDATE] Git collision PHP Job/Lang: 14 file risolti con strategia HEAD/current; `git grep` su `*.php` pulito; issue [#143](https://github.com/provtv/base_ptv_fila5_mono/issues/143).

[2026-05-26 00:50:00 UTC] [UPDATE] Standard release moduli/temi: propagati semantic-release workflow, releaserc, changelog, README marketing e docs locali; issue #153.

[2026-05-26 00:45:00 UTC] [UPDATE] Protocollo massima confidenza agente: regola root, memoria, trigger map e stub nei docs di moduli/temi.

[2026-05-26 00:40:00 UTC] [UPDATE] Regola stile agenti: risposte sempre in italiano, sintetiche e concise; aggiornata trigger map, memoria e stub agenti.

[2026-05-26 21:30:00 UTC] [PROCESS] **Git merge debris / collisioni**: sweep `docs/raw/history/*.md`, ripristino `docs/.php_cs.dist.php`, `docs/phpstan.neon.dist`, `docs/phpunit.xml.dist`; consolidamento `Modules/Xot/docs/filament/infinite-loop-getstepbyname-fix*.md`; how-to [`git-merge-marker-sweep`](how-to/git-merge-marker-sweep.md); Trigger Map + second brain operating model aggiornati.

[2026-05-26 18:00:00 UTC] [UPDATE] Trigger Map: riga canonica **BOOTSTRAP SESSIONE AGENTE**, «Contratto automatico», Enforcement rinforzato; stub `AGENTS.md`/`CLAUDE.md`; INDEX rules; disciplina autocompact agganciata al routing.

[2026-05-26 00:20:00 UTC] [UPDATE] MCP portability: rimossi path assoluti workspace da `.cursor/mcp.json` e `.mcp.json`; aggiunto trigger map per config MCP non portabile e regola `${workspaceFolder}` in context-mode setup.

[2026-05-26 16:45:00 UTC] [PROCESS] Autocompact thrashing: how-to unificato `docs/wiki/how-to/autocompact-thrashing-recovery.md`, redirect `kilo-autocompact-…`, stub `agent-edit-discipline` (39 pacchetti), rule `cursor-context-discipline.mdc`, trigger map; fonti esterne forum Cursor + vexp. [UPDATE] Autocompact thrashing: creata issue #138, aggiunto playbook root, trigger map, memoria compaction, guardrail GitHub issue e puntatori DRY negli `agent-edit-discipline.md` di moduli e temi.

[2026-05-26 15:30:00 UTC] [PROCESS] Rafforzata disciplina **issue GitHub obbligatoria** (anche task solo-docs): blocchi in `.cursor/rules/cursor-context-discipline.mdc`, `.cursor/rules/markdown-documentation-standard.mdc`; link in `AGENTS.md`/`CLAUDE.md`; how-to aggiornato; audit comment su issue `#124`; regola Markdown checklist `gh`.

[2026-05-21 14:00:00 UTC] [UPDATE] Rimosso `.local/mariadb-install/` dall’indice git (~125MB deb/binari); aggiunto `.local/` a `.gitignore`. Install offline: `bashscripts/tools/lamp/`.

[2026-05-26 10:00:00 UTC] [UPDATE] Finalizzato e reso **MANDATORIO** lo standard `markdown-documentation-standard.md` (HackerNoon Tip 020). Applicata rinomina file non conformi (`philosophy-and-ethics.md`), aggiornato `GEMINI.md` root. Audit trail: **issue #139**.

[2026-05-21 23:00:00 UTC] [DOCS] Filament **v5** canonico: `filament-version-policy.md`, `filament-version.md` in ogni modulo/tema, second-brain aggiornati, llm-wiki false friend, trigger map; doc v4 etichettati storico.

[2026-05-21 22:00:00 UTC] [UPDATE] Policy git branch agenti: `docs/wiki/memories/git-branch-policy-agents.md`; lavoro PHPStan/docs riportato su `dev` da branch spurio `fix/phpstan-indennita-conditions-20260521` (cherry-pick + stash pop).

[2026-05-21 12:00:00 UTC] [LINT] Campagna deduplica docs moduli/temi: script `bashscripts/tools/dedup_module_docs.py` — ~2807 delete, ~349 stub html2pdf/wiki, canonici Media (html2pdf) e Xot (wiki/concepts). How-to: `docs/wiki/how-to/module-docs-deduplication.md`. Issue #124.

### Format

```text
[YYYY-MM-DD HH:MM:SS UTC] [OPERATION] Description
```

**Operations:**

- `INGEST` — Added raw document to wiki
- `QUERY` — Answered question from wiki
- `LINT` — Maintained wiki quality
- `UPDATE` — Modified existing wiki page
- `CREATE` — Created new wiki structure or tool

---

[2026-04-15 00:00:00 UTC] [INGEST] Added module structure documentation
[2026-04-15 00:00:00 UTC] [INGEST] Added actions over services documentation
[2026-04-15 00:00:00 UTC] [INGEST] Added accessor auto-persistence pattern
[2026-04-28 00:00:00 UTC] [INGEST] Added second brain operating model for project-level documentation
[2026-04-28 00:00:00 UTC] [INGEST] Added source summary for docs landscape across modules and themes
[2026-04-28 00:00:00 UTC] [INGEST] Added architecture guardrails from root docs/architecture sources
[2026-04-28 00:00:00 UTC] [INGEST] Added AI tooling workflow from root docs/ai sources
[2026-04-28 00:00:00 UTC] [INGEST] Added BMAD operating model from root docs/bmad sources
[2026-04-29 00:00:00 UTC] [UPDATE] Refined second brain operating model with actionability, compression, and discoverability rules
[2026-04-29 00:00:00 UTC] [INGEST] Added continuous-improvement playbook for root, module, and theme documentation maintenance
[2026-04-29 09:09:00 UTC] [CREATE] Story 1-4: second-brain-efficiency-optimization
[2026-04-29 00:00:00 UTC] [INGEST] Added reusable second-brain audit checks concept and local audit tool for wiki health
[2026-04-29 09:19:00 UTC] [RESEARCH] Ingested external second-brain benchmarks and mapped them to repository operations
[2026-04-29 09:19:00 UTC] [CREATE] Story 1-5: second-brain-internet-research-and-federated-docs-updates
[2026-04-29 09:19:00 UTC] [UPDATE] Extended continuous-improvement model with /bmad-create-story integration and external benchmark policy
[2026-04-29 09:44:00 UTC] [UPDATE] Added execution checkpoints to enforce continuous docs improvement across root/module/theme
[2026-04-29 10:32:00 UTC] [UPDATE] Closed Story 1-5 as done and added federated pilot anchors
[2026-04-29 10:33:00 UTC] [INGEST] Added second-brain maintenance cadence concept with daily/weekly/monthly rhythm
[2026-04-29 10:33:00 UTC] [CREATE] Story 1-6: second-brain-maintenance-cadence-and-audit-rhythm
[2026-04-29 10:33:00 UTC] [UPDATE] Linked cadence concept into continuous-improvement and audit-checks pages
[2026-04-29 11:55:00 UTC] [INGEST] Installed and configured Token Optimizer MCP
[2026-04-29 12:15:00 UTC] [INGEST] Added context-mode-plugin concept documentation
[2026-04-29 12:18:00 UTC] [INGEST] Added context-mode-cli-reference guide
[2026-04-29 12:20:00 UTC] [INGEST] Added how-to guide for indexing module documentation
[2026-04-29 12:22:00 UTC] [INGEST] Created module-context-mode-integration.md template
[2026-04-29 12:25:00 UTC] [INGEST] Added how-to guide for using wiki templates
[2026-04-29 13:05:00 UTC] [INGEST] Documented official Kilo large-project guidance
[2026-04-29 13:18:00 UTC] [UPDATE] Added explicit repository policy to disable Kilo managed indexing
[2026-04-29 14:00:00 UTC] [CREATE] Story 2.1: QMD Search Integration
[2026-04-29 14:15:00 UTC] [INGEST] Added qmd-indexing-manifest.md
[2026-04-29 14:30:00 UTC] [CREATE] bashscripts/wiki-search CLI tool
[2026-04-29 14:45:00 UTC] [INGEST] Added wiki-search-guide.md
[2026-04-29 15:00:00 UTC] [CREATE] bashscripts/wiki-relations helper script
[2026-04-29 15:15:00 UTC] [INGEST] Added semantic-search-and-related-pages.md
[2026-04-29 15:30:00 UTC] [UPDATE] Enhanced wiki-search with --related flag
[2026-04-29 15:45:00 UTC] [UPDATE] Reorganized wiki/index.md with categorized how-to guides
[2026-04-29 16:00:00 UTC] [CREATE] Task 4: Performance Optimization
[2026-04-29 16:15:00 UTC] [CREATE] docs/scripts/wiki/benchmark-search.sh
[2026-04-29 16:30:00 UTC] [CREATE] docs/scripts/wiki/cache-manager.sh
[2026-04-29 16:45:00 UTC] [INGEST] Added wiki-search-performance.md
[2026-04-29 17:00:00 UTC] [UPDATE] Updated wiki/index.md with performance guide
[2026-04-29 17:15:00 UTC] [CREATE] Task 5: Accessibility & UX
[2026-04-29 17:30:00 UTC] [CREATE] docs/scripts/wiki/accessible-search.sh
[2026-04-29 17:45:00 UTC] [INGEST] Added wiki-search-accessibility.md
[2026-04-29 18:00:00 UTC] [UPDATE] Updated wiki/index.md with accessibility guide
[2026-04-29 18:15:00 UTC] [CREATE] Task 6: Testing Suite
[2026-04-29 18:30:00 UTC] [CREATE] docs/scripts/wiki/test-suite.sh
[2026-04-29 18:45:00 UTC] [CREATE] Task 7: Documentation and Finalization
[2026-04-29 19:00:00 UTC] [CREATE] docs/wiki/how-to/wiki-search-troubleshooting.md
[2026-04-29 19:15:00 UTC] [UPDATE] Updated wiki/index.md with troubleshooting guide
[2026-04-29 19:30:00 UTC] [INGEST] Prepared Kilo local indexing prerequisites
[2026-04-29 19:35:00 UTC] [CREATE] Story 2.2: Bidirectional Cross-Referencing
[2026-04-29 19:35:00 UTC] [UPDATE] Updated sprint-status.yaml for Story 2.2
[2026-04-29 19:40:00 UTC] [CREATE] Story 2.3: Automated Wiki Generation
[2026-04-29 19:40:00 UTC] [UPDATE] Updated sprint-status.yaml for Story 2.3
[2026-04-29 20:00:00 UTC] [CREATE] Task 2 Execution - Story 2.2: Wiki → Code Reference Resolution
[2026-04-29 20:05:00 UTC] [CREATE] docs/scripts/wiki/wiki-reference-generator.sh
[2026-04-29 20:10:00 UTC] [UPDATE] Added references field to concept pages
[2026-04-29 20:15:00 UTC] [UPDATE] Documented Kilo indexing boundary
[2026-04-29 20:25:00 UTC] [CREATE] docs/scripts/wiki/wiki-link-renderer.sh
[2026-04-29 20:30:00 UTC] [UPDATE] Fixed YAML parser in wiki-link-renderer.sh
[2026-04-29 20:35:00 UTC] [UPDATE] Fixed malformed frontmatter in actions-over-services.md
[2026-04-29 20:40:00 UTC] [UPDATE] Added module references to module-wiki-documentation.md
[2026-04-29 20:45:00 UTC] [VALIDATION] Tested wiki-link-renderer.sh on all Priority 1 pages
[2026-05-12 00:00:00 UTC] [UPDATE] Aligned wiki to LLM Wiki On-Demand Knowledge Pattern — created rules/, skills/, commands/, memories/, agents/ directories with INDEX files and 00-TRIGGER_MAP.md; resolved merge conflicts in index.md and log.md
[2026-05-12 09:18:00 UTC] [CREATE] docs/wiki/concepts/llm-wiki-operational-discipline.md — canonical operational rules for LLM wiki pattern (token budget, cache discipline, git policy, bad practices)
[2026-05-12 09:18:00 UTC] [UPDATE] docs/wiki/concepts/INDEX.md — added llm-wiki-operational-discipline entry
[2026-05-12 09:18:00 UTC] [UPDATE] docs/wiki/rules/00-TRIGGER_MAP.md — added triggers: llm-wiki discipline, git policy, cache discipline, bootstrap stub size, Laravel upgrade, accessor/mutator
[2026-05-12 09:18:00 UTC] [CREATE] bashscripts/docs/wiki/{rules,skills,commands,memories,concepts}/INDEX.md — tooling wiki INDEX files per §8 of on-demand pattern
[2026-05-12 09:18:00 UTC] [UPDATE] CLAUDE.md — replaced embedded rules with ≤50-line stub-only pointing to wiki (on-demand pattern compliant)

[2026-05-12 09:31:00 UTC] [UPDATE] docs/wiki/rules/00-TRIGGER_MAP.md — aggiunto trigger Filament ->label()/traduzioni, Filament class extension/XotBase, Filament resource/page/widget
[2026-05-12 09:31:00 UTC] [UPDATE] docs/wiki/rules/INDEX.md — aggiunto filament-rules-summary, xotbase-critical-rules, schema-conventions, ai-guidelines

**Last Activity:** 2026-05-12 10:32:00 UTC  
[2026-05-12 09:58:00 UTC] [CREATE] docs/wiki/rules/filament-resource-property.md — regola `$resource` è `protected static string` non `public static`; auto-resolve in XotBaseListRecords via namespace
[2026-05-12 09:58:00 UTC] [UPDATE] docs/wiki/rules/00-TRIGGER_MAP.md — aggiunto trigger `$resource property`, `XotBaseListRecords auto-resolve`, `skill crea filament page`
[2026-05-12 09:58:00 UTC] [UPDATE] docs/wiki/rules/INDEX.md — aggiunto filament-resource-property
[2026-05-12 09:58:00 UTC] [UPDATE] laravel/Modules/Xot/docs/wiki/rules/INDEX.md — upgrade frontmatter + link regole Filament
[2026-05-12 09:58:00 UTC] [UPDATE] laravel/Modules/Activity/docs/wiki/rules/INDEX.md — upgrade frontmatter + link xotbase-resource-zen-pattern
[2026-05-12 09:58:00 UTC] [CREATE] laravel/Modules/Xot/docs/wiki/skills/filament-page-creation.md — skill on-demand: crea ListRecords/Create/Edit/View con XotBase
[2026-05-12 09:58:00 UTC] [UPDATE] laravel/Modules/Xot/docs/wiki/skills/INDEX.md — upgrade frontmatter + aggiunto filament-page-creation skill
[2026-05-12 10:15:00 UTC] [LINT] Corretto `protected static string $resource` nella documentazione modulo/tema, risolti marker di merge nel wiki Theme One e aggiunti ingressi on-demand a rules/skills per i temi
[2026-05-12 10:19:00 UTC] [UPDATE] Migliorata l'indicizzazione on-demand dei moduli core: `User` e `Lang` ora espongono regole/skill reali; `Activity` e `Rating` mostrano meglio pattern locali e skill condivise; `docs/wiki/rules/00-TRIGGER_MAP.md` collegato ai nuovi entrypoint modulo-specifici
[2026-05-12 10:32:00 UTC] [UPDATE] Hardening definitivo del contesto OpenCode: installato plugin globale `@tarquinen/opencode-dcp@latest`, aggiunto `opencode.json` al git root con compaction esplicita e watcher ignore, documentato il fix in bashscripts/Xot/temi e corretta la memoria che indicava erroneamente `laravel/opencode.json`
**Total Operations:** 78
[2026-05-12 10:24:00 UTC] [CREATE] .windsurf/rules/context-budget.md — max lines per tool response, never-read file list
[2026-05-12 10:24:00 UTC] [CREATE] .windsurf/rules/no-bulk-reads.md — forbidden bulk read patterns
[2026-05-12 10:24:00 UTC] [CREATE] .windsurf/rules/tool-output-compression.md — PHPStan/git/composer output compression
[2026-05-12 10:24:00 UTC] [CREATE] .windsurf/rules/session-discipline.md — bootstrap, overflow recovery, session split protocol
[2026-05-12 10:24:00 UTC] [CREATE] docs/wiki/rules/context-overflow-prevention.md — canonical rule 262K token prevention
[2026-05-12 10:24:00 UTC] [UPDATE] docs/wiki/rules/00-TRIGGER_MAP.md — context overflow triggers
[2026-05-12 10:24:00 UTC] [UPDATE] docs/wiki/rules/INDEX.md — context-overflow-prevention entry
[2026-05-12 10:24:00 UTC] [UPDATE] 12× module/theme wiki/rules/INDEX.md — context-overflow-prevention propagated
[2026-05-12 10:24:00 UTC] [UPDATE] .gitignore — !.windsurf/rules/*.md tracked

[2026-05-12 10:35:00 UTC] [LINT] Verified workspace against LLM Wiki on-demand pattern. Removed forbidden .cache/ and redundant node_modules in .agents/. Renamed root .md files and docs/ folders to comply with lowercase kebab-case standards. Updated docs/roadmap.md.

**Total Operations:** 88

[2026-05-19 12:00:00 UTC] [UPDATE] `bashscripts/tools/prompts/llm-wiki.txt` — estesi best/bad practices e false friends; tabella link verificati ripartita per sezione; rimosso riferimento a `compression-levels.md` inesistente (mirror in `llm-wiki-operational-discipline.md` / `on-demand-pattern.md`); check stub include `AGENTS.md`; trigger namespace allineato a `docs/wiki/rules/laraxot-module-namespace.md`

**Total Operations:** 89

[2026-05-19 11:35:00 UTC] [LINT] Ripristino integrità `bashscripts/tools/prompts/llm-wiki.txt` (rimosso prefisso tabellare accidentale e coda spuria); link verificati corretti (`bashscripts/ai/rules/context-compression-discipline.md`); bad/false friends estesi; check QMD cache allineato a `~/.cache/qmd` OR `qmd-cache`; rimosso `bashscripts/ai/.agents/node_modules`, aggiunto `node_modules/` a `.agents/.gitignore`; `verify-llm-wiki.sh`: stub `AGENTS.md` ≤50 righe, gate QMD cache duale — verify **0 failed**

**Total Operations:** 90

[2026-05-19 14:30:00 UTC] [LINT] Normalized wiki naming convention to kebab-case; renamed duplicates in rules/ to .old.
[2026-05-19 14:35:00 UTC] [UPDATE] Moved root wiki files to concepts/ and how-to/ subdirectories; updated main index.md.
[2026-05-19 14:40:00 UTC] [UPDATE] Refactored 00-TRIGGER_MAP.md with categorized triggers and improved discoverability.

[2026-05-19 12:15:00 UTC] [UPDATE] `bashscripts/tools/prompts/llm-wiki.txt` — workflow GitHub (`gh` + repo `provtv/base_ptv_fila5_mono`, `has_wiki=false` verificato via API), `./docs/chat/` operativo, cache QMD duale, tab deep-link Filament/context-mode; §17 privata di path non presenti nel tree; nuove §18–§20 troubleshooting/routing/health; checklist chiusura task; allineamento issue #122/#123

[2026-05-19 13:10:00 UTC] [LINT] Rimossi da git file debris merge/sync (`*.md~head` in Notify e Media docs, `Notify/.phive~laraxot_dev`); aggiunti ignore `*~HEAD` e `*~head` in `.gitignore` root e `laravel/Modules/Notify/.gitignore`; `laravel/Modules/Media/docs/.gitignore` ignora `wiki/_archive/`; aggiornato `bashscripts/tools/prompts/llm-wiki.txt` (§7 debris + vietato `_archive` sotto `docs/wiki/`, §11–§12, §14 find).

[2026-05-19 15:10:00 UTC] [UPDATE] `bashscripts/tools/prompts/llm-wiki.txt` — rimosso prefisso tabellare orfano; §3.1 «Reality discipline»: nessun read-only assoluto, convenzioni ≠ invarianti; workflow chiarito (subset QMD); §11 riga `docs/raw/`; §12 nuove false friends (raw read-only, agent isole, reverifica); §15 iterazione prompt; `docs/wiki/concepts/llm-wiki-operational-discipline.md` mirror breve + link relativo al prompt.

[2026-05-19 16:30:00 UTC] [LINT] Blocco ignore debris merge (`*~HEAD`, `*~BASE`, …, `*~head`) in ogni `laravel/Modules/<Name>/.gitignore` e `laravel/Themes/<Name>/.gitignore`, più `laravel/.gitignore`; header Notify allineato al commento canonico; `bashscripts/tools/prompts/llm-wiki.txt` §7 (policy + perché duplicare), §11, §12 false friend, §15 nuovi package.

[2026-05-19 17:00:00 UTC] [LINT] `bashscripts/tools/prompts/llm-wiki.txt` — rimossa coda spuria (messaggio utente incollato dopo footer); aggiunta §7.1 blocco `.gitignore` canonico copiabile; checklist §20 per nuovi package; verifica: tutti i `laravel/Modules/*/.gitignore` e `laravel/Themes/*/.gitignore` contengono già il blocco debris.

[2026-05-19 18:15:00 UTC] [UPDATE] Second brain: espanso `sources/second-brain-external-benchmarks.md` (link esterni Karpathy / Obsidian / PARA / IT / critiche / tooling); aggiornati `concepts/second-brain-operating-model.md`, `how-to/module-wiki-documentation.md`, `how-to/theme-wiki-documentation.md`, `concepts/second-brain.md`; `bashscripts/tools/prompts/llm-wiki.txt` §1.1 tre strati, verified links, false friend Obsidian; rimossa altra coda spuria dal prompt.

[2026-05-19 19:00:00 UTC] [CREATE] `docs/second-brain.md` puntatore in ogni `laravel/Modules/<Name>/docs/` e `laravel/Themes/<Name>/docs/` (link relativi alla wiki root); rimossi 48 stub erronei creati sotto path `docs` annidati/non canonici; benchmark esterni: secondo articolo MindStudio (`codeex`); how-to modulo/tema aggiornati.

**Total Operations:** 98

[2026-05-19 20:30:00 UTC] [UPDATE] Cursor/OpenCode compaction: aggiunta `.cursor/rules/compaction-recovery.mdc` (recovery + prevenzione); sezione wiki «Compaction exhausted» in `docs/wiki/concepts/context-overflow-prevention.md`; trigger map e `docs/wiki/rules/context-overflow-prevention.md` puntano alla narrativa canonica; `opencode.json` `compaction.reserved` 40000→56000; `npm install -g context-mode@latest` eseguito sul workspace host.

**Total Operations:** 99

[2026-05-19 21:45:00 UTC] [UPDATE] Disciplina edit: mutex `file.ext.lock` affiancato + pipeline PHPStan / PHPMD (`laravel/tools/phpmd.sh`) / PHPInsights (`laravel/tools/phpinsights.sh`) / Playwright+Puppeteer globali per UI — `docs/wiki/rules/validation-post-edit-rule.md`; `.cursor/rules/file-locking-mandatory.mdc`; `bashscripts/tools/prompts/llm-wiki.txt` §2.1; `docs/wiki/concepts/llm-wiki-operational-discipline.md`; trigger map; `.gitignore` eccezione `!.cursor/rules/**` per versionare le `.mdc`.

**Total Operations:** 100

[2026-05-19 22:30:00 UTC] [UPDATE] GitHub issue `https://github.com/provtv/base_ptv_fila5_mono/issues/124` come audit trail (ragionamenti agent); how-to `docs/wiki/how-to/github-issue-agent-discipline.md`; stub `agent-edit-discipline.md` in 39 cartelle `docs` modulo/tema (+ `Legge104/app/docs`); aggiornati `validation-post-edit-rule.md`, `second-brain-operating-model.md`, how-to modulo/tema, `laravel/Modules/Xot/docs/file-locking-pattern.md` con puntatore canonico; trigger map; commento `gh` su MCP; `llm-wiki.txt` verified link.

**Total Operations:** 101

[2026-05-19 10:40:00 UTC] [CREATE] `docs/chat/2026-05-19-agent-edit-discipline-confronto.md` — confronto obbligatorio tra agenti (anchor `#124`); `llm-wiki.txt` §10 Inter-Agent Collaboration reso esplicito (lettura chat ad avvio task + scrittura dopo decisioni condivise); commento `gh` su #124.

**Total Operations:** 102

[2026-05-19 23:15:00 UTC] [CREATE] FASE 3–5 (issue #123): +9 trigger in `00-TRIGGER_MAP.md`; atomic pages `git-atomic-operations`, `rule-atomicity`, `memory-system-usage`, `skill-discovery`; riscritto `concepts/context-mode-usage.md`; `skills/INDEX.md` strutturato (process/implementation/domain/maintenance); fix wikilink in `memories/environment-verification.md`; rimosso debris `bashscripts/ai/.agents/settings.json.orig` (untracked).

**Total Operations:** 102

[2026-05-19 23:45:00 UTC] [UPDATE] `docs/chat/`: naming **`slug-argomento.md`** (kebab-case); file `agent-edit-discipline.md`, `llm-wiki-hardening.md` (merge ex `cursor-sync`), `gemini-cli.md`; rimossi `2026-05-19-*.md`; `llm-wiki.txt` §10 + checklist §20; `github-issue-agent-discipline.md`; commento `gh` su #124.

**Total Operations:** 103

[2026-05-20 00:10:00 UTC] [UPDATE] `bashscripts/tools/prompts/llm-wiki.txt` — § GitHub (commento issue + path `docs/chat/<slug>.md`); nuova sottosezione «Inter-Agent + GitHub — integrazione»; false friend issue-vs-chat; troubleshooting multi-agente.

**Total Operations:** 104

[2026-05-20 00:35:00 UTC] [CREATE] FASE 6–8 (#123): 12 memories root + INDEX; `llm-wiki.txt` +9 false friends, verified links, bad practices; `how-to/wikilink-cross-reference.md`; trigger map (compaction, wikilink); `docs/chat/llm-wiki-hardening.md`; puntatore Xot memories → root.

**Total Operations:** 105

[2026-05-20 01:00:00 UTC] [UPDATE] Wikilink batch: cluster second-brain + ProjectHome + sources chiave → path relativi; rimosso `bashscripts/ai/.agents/node_modules` (gate); chiusura issue #122/#123.

**Total Operations:** 106

[2026-05-20 00:45:00 UTC] [FIX] Cursor compaction: `laravel/.cursor/rules/laravel-boost.mdc` monolite ~143k righe → stub + backup `laravel/.cursor/laravel-boost-guidelines.FULL.mdc.bak`; `.cursor/rules/cursor-context-discipline.mdc` (merge compaction + lock); wiki/memories/trigger/llm-wiki/Xot/Sigma aggiornati.

**Total Operations:** 106

[2026-05-20 12:00:00 UTC] [CREATE] Standard minimo `.md` da HackerNoon Tip 020: `docs/wiki/concepts/markdown-note-minimum-standard.md`; integrati `second-brain-operating-model.md`, benchmarks esterni, trigger map, `llm-wiki.txt` §1.2 + checklist + quick ref; ripulito prompt da righe spurie in coda.

**Total Operations:** 107

[2026-05-20 13:00:00 UTC] [UPDATE] Rafforzato Tip 020: PARA mapping, good/bad table, checklist agent; frontmatter how-to modulo/tema; memory `markdown-hackernoon-tip-020`; audit checks; `docs-template-standard` YAML header; `llm-wiki.txt` §10 + false friends.

**Total Operations:** 108

[2026-05-20 14:00:00 UTC] [FIX] API 131072 overflow: `laravel/AGENTS.md`/`CLAUDE.md` monoliti → stub; backup `*.embedded-rules.FULL.md.bak`; gate laravel stubs; `context-mode` in `.mcp.json`; wiki/how-to aggiornato; `llm-wiki.txt` §17.

**Total Operations:** 109

[2026-05-20 14:30:00 UTC] [CREATE] Playbook errore API limite **131072** token vs payload (~796k): `docs/wiki/how-to/api-context-length-exceeded-131072.md`; `context-overflow-prevention.md` + `context-compression-mcp-setup.md` + trigger map; `docs/chat/context-api-131072-overflow.md`; issue GitHub dedicata; ampliato `llm-wiki.txt` §5/§17/§18.

**Total Operations:** 110

[2026-05-20 15:00:00 UTC] [CREATE] MCP minimum stack obbligatorio (5): `.mcp.json`, `.cursor/mcp.json`, `docs/wiki/_templates/mcp-minimum-stack.json`, `how-to/mcp-minimum-stack.md`; gate `verify-llm-wiki.sh` sezione MCP; `llm-wiki.txt` §17 + checklist §20.

**Total Operations:** 111

[2026-05-21 00:00:00 UTC] [UPDATE] MCP stack: `laravel-boost` usa `php` su PATH (non path fisso php8.3) in `.mcp.json`, `.cursor/mcp.json`, template, `laravel/.mcp.json`; gate `verify-llm-wiki.sh` controlla `php`; `llm-wiki.txt` §17 + quick ref MCP.

**Total Operations:** 112

[2026-05-19 11:02:00 UTC] [UPDATE] `llm-wiki.txt`: fix typo `npm install -g context-mode playwright /test puppeteer` → `@playwright/test`; §13 verified links aggiunto MCP minimum stack (`how-to/mcp-minimum-stack.md` + template); §17 `laravel-boost` label semplificato, `php laravel/artisan list`; §20 checklist voce MCP minimi. Gate verify-llm-wiki.sh: 39/39 ✅.

[2026-05-19 13:09:00 UTC] [LINT] Housekeeping `docs/wiki/`: rimossi 7 orphan `.lock` (crash agent precedenti) e 9 file `.old` stale (SCHEMA, CONTEXT_MODE_SETUP, second-brain-implementation, second_brain, laravel-13-upgrade-*, namespace-rules, namespace_conventions, naming_conventions). Git history preserva i contenuti. Gate `verify-llm-wiki.sh` 39/39 ✅.

**Total Operations:** 114

[2026-05-21 12:00:00 UTC] [UPDATE] GitHub issue proattive: policy in `docs/wiki/how-to/github-issue-agent-discipline.md`, memory `docs/wiki/memories/github-issues-proactive.md`, `second-brain-operating-model.md` regola 6, trigger map, `llm-wiki.txt` § GitHub + bad practice + checklist §20; issue #129 (CI lock orfani), #130 (pre-commit PHP); chiusa #128 (compaction/context-mode).

**Total Operations:** 115

[2026-05-21 14:00:00 UTC] [FIX] `spatie/laravel-model-states` 2.14.1 in `Modules/Xot` + `php ^8.4` root/Xot; runtime `php8.4` (8.4 già su host, ext=allineate); PHPStan OK `XotBaseTransition`; memory `spatie-model-states-php84.md`; playbook `llm-wiki.txt`; matrix Xot aggiornata; issue #131.

**Total Operations:** 116

[2026-05-21 15:00:00 UTC] [UPDATE] Passaggio MySQL→MariaDB: `bashscripts/mysql/switch-to-mariadb.sh`, how-to `docs/wiki/how-to/switch-mysql-to-mariadb.md`; `XotBaseMigration` accetta driver `mariadb`; `.env.example` blocco locale; trigger map.

**Total Operations:** 117

[2026-05-21 16:00:00 UTC] [CREATE] LAMP MariaDB: `bashscripts/tools/lamp/` (install-mariadb, check-mariadb, php extensions, laravel-env example); `bashscripts/docs/mariadb-laravel.md`, `ubuntu/lamp.md`; `install-mariadb-system.sh` crea DB Laravel; `db/check_mariadb.sh`; wsl/setup banner MariaDB.

**Total Operations:** 118

## [2026-05-27] bmad | BMAD Method v6 project-level on-demand install
- Installato BMAD Method v6.0.2 da `aj-geddes/claude-code-bmad-skills` commit `b5c6403847b32f0facc95943a1aa837c96de31af`.
- Installazione locale progetto: `.claude/skills/bmad/`, `.claude/commands/bmad/`, `.claude/config/bmad/`.
- Aggiunti routing wiki on-demand: `docs/wiki/rules/bmad-v6-on-demand.md`, `docs/wiki/commands/bmad-v6.md`, `docs/wiki/skills/INDEX.md`.
- Aggiornati `docs/wiki/rules/00-TRIGGER_MAP.md`, `docs/wiki/rules/INDEX.md`, `docs/wiki/commands/INDEX.md`.

[2026-06-15] [FIX] Sigma — `Qua00f` e `Rep00f` rimossa ridichiarazione `implements Contracts\DateRangeFieldsContract` (ereditata da `BaseDateRangeModel`). Nuova regola locale `contract-inheritance-no-redeclare.md`. Allineato a `class-inheritance-principles.md` + `inheritance-composition-no-duplication.md`. Metadati+indici aggiornati. llm-wiki ingest.

[2026-06-15] [RENAME] Sigma contratti — `SigmaDateRangeFields`→`DateRangeFieldsContract`, `SigmaEnteMatrFields`→`EnteMatrFieldsContract`, `SigmaQuaRelationAnnFields`→`QuaRelationAnnFieldsContract` (34+25+3 file). Regola: `contract-naming-suffix.md`. Memory + TRIGGER_MAP aggiornati.

[2026-06-15] [ARCHITECTURE] Contract stacking pattern — `SchedaContract extends EnteMatrFieldsContract, DateRangeFieldsContract`. `BaseScheda implements SchedaContract` solo. Nuova regola `contract-interface-stacking.md`. Fix test Progressioni (import path errato).

[2026-06-18] [ARCHITECTURE] Module root folders forbidden — regola canonica: cartelle `Actions/`, `Application/`, `Database/` (PascalCase), `Events/`, `Listeners/` non devono esistere nella root del modulo; tutto il PHP sotto `app/`, DB sotto `database/`. Artefatti: `docs/wiki/rules/module-root-php-folders-forbidden.md`, memory Xot `module-app-only-directory-structure.md`, User `module-root-folder-violations.md`, TRIGGER_MAP aggiornato. Violazione residua: solo `Modules/User/`.

[2026-06-18] [RULE] PHPStan single config — solo `laravel/phpstan.neon`; vietato creare wrapper `.neon` (`phpstan-gate.neon` rimosso). Regola: `docs/wiki/rules/phpstan-single-neon-config.md`, memory Xot, TRIGGER_MAP, gate script aggiornato.

[2026-06-18] [GATE OK] User PHPStan — primo `./vendor/bin/phpstan analyse Modules/User` OOM 512M; batch + `bash bashscripts/tools/phpstan-modules-gate.sh User` OK; run finale esatto `Modules/User` OK 635/635. Nota locale: `laravel/Modules/User/docs/wiki/troubleshooting/phpstan-module-analysis-memory.md`.

[2026-07-06] [RULE] Infrastructural→Dominio dipendenza vietata — UI non deve importare da GEO (o altro modulo dominio). InteractiveMap.php (UI) rinominato in .old perché apparteneva a GEO. Regola aggiunta a `laravel/Modules/UI/docs/dependencies.md`.
[2026-07-01] [FIX] Git collision sweep — rimossi marker residui in Xot PHP (`XotServiceProvider`, `Helper`) e docs Job/Notify/Tenant/User; aggiornato report `docs/wiki/sources/git-collision-docs-cleanup-report.md`; verifica `git grep` marker OK.
