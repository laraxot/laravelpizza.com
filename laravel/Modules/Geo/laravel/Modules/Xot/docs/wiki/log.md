---


## [2026-06-30] governance | no legacy folders + model seeder parity

- Rimossa ogni eccezione per cartelle `legacy/`, anche sotto `docs/`.
- Ribadito: `node_modules/` solo locale per build, mai nel repository.
- Rafforzata regola: X modelli owner persistenti = X migrazioni canoniche + X seeder canonici; no seeder demo in cartelle parallele.

## [2026-06-30] parità modello — 1 migrazione + 1 seeder

- Hub: [module-model-migration-seeder-parity.md](../../../../docs/wiki/concepts/module-model-migration-seeder-parity.md)
- Seeder parity: User 37/37, Job 15/15, Predict 16/16, Lang OK
- Backlog: consolidamento migrazioni duplicate (GAP migration)

title: "Activity Log"
type: log
module: Xot
tags: [xot, phpstan, pest, qmd, ponytail-audit]
created: 2026-04-20
updated: 2026-06-30
qmd: "Xot log phpstan pest bridge discipline ponytail audit"
issues:
  - "https://github.com/laraxot/module_xot_fila5/issues/28"
  - "https://github.com/laraxot/base_predict_fila5/issues/237"
discussions:
  - "https://github.com/laraxot/module_xot_fila5/discussions/29"
---

## [2026-06-30] ponytail audit remediation — repo-wide

- Delete dead: `RouteDynService`, `ContextCompressor`, UI NullMap stack, Geo probe test dupes.
- Predict: seeder ad-hoc → `*.php.bak` (no cartella `Legacy/`); wiki [seeder-canonical-orchestrator.md](../../laravel/Modules/Predict/docs/wiki/concepts/seeder-canonical-orchestrator.md) + regola [no-legacy-folders-code.md](../../docs/wiki/concepts/no-legacy-folders-code.md).
- Prompts: 49 file → `archive/ponytail-2026-06-30/`; canonici `start.txt` + `rules.txt`.
- User `UserContract` = alias Xot; Helper senza wrapper string legacy.

## [2026-06-30] prompts | start.txt v17 — ponytail ultra (SSoT script)

- Rimosso ~300 righe bash duplicate di `run-session-gate.sh`; gate = un comando.
- Regole sacre restano: PHPStan 0, git forward-only, Spatie teams, policy, hygiene prompt.

## [2026-06-30] prompts | start.txt v16 — gate BaseUser teams API

- §1.6: runtime verifica `method_exists(User, teams|membershipTeams)` oltre autoload PSR-4.
- §6.1: tabella fix PHPStan + link `phpstan-trait-probes.md`; pattern Spatie `insteadof` su `BaseUser`.
- `run-session-gate.sh` allineato a §1.6.

**Ultimo run:** 2026-06-30 run #4 (remediation wave — lang, test, seeders, wire-elements)

## [2026-06-30] parità modello — 1 migrazione + 1 seeder (repo-wide)

- Regola canonica: [module-model-migration-seeder-parity.md](../../../../docs/wiki/concepts/module-model-migration-seeder-parity.md)
- Script: `ensure-module-entity-seeders.sh` (+~120 stub), `audit-module-artifact-parity.sh`
- Seeder parity OK: User 37/37, Job 15/15, Predict 16/16, Lang 3/3
- Backlog: migrazioni duplicate `add_*` / `create_*` multipli (GAP migration resta su 12+ moduli)
- Gate: `run-session-gate.sh` §1.1c

## [2026-06-30] regola no-Legacy folders — User lang + Predict seeders

- **Mai** cartelle `Legacy/`, `archive.bak/` nel codice — solo `.bak` in-place ([no-legacy-folders-code.md](../../../../docs/wiki/concepts/no-legacy-folders-code.md))
- User: rimossa `lang/archive.bak/` → `lang/{locale}/*.php.bak` — [lang-backup-in-place.md](../../User/docs/wiki/concepts/lang-backup-in-place.md)
- Predict: seeders ad-hoc flat `database/seeders/*.php.bak` (no `Legacy/`)

## [2026-06-30] ponytail wave 4 — remediation audit

- Test naming: 12 duplicati → `.php.bak`; Tenant `DomainTest.php`
- Predict: `wire-elements/pro.bak`, PHPStan 0
- Hub: [ponytail-audit.md](../../../../docs/audit/ponytail-audit.md) run #4

## [2026-06-30] prompts | start.txt v15 — baseline PHPStan 0 + Spatie teams

- **PHPStan:** `Modules/` a **0 errori** (level max, ~5357 file) — regola gate aggiornata: mantenere baseline, non ~25 backlog.
- **Runtime gate:** check autoload `BaseUser` (trait collision `teams()` prima di PHPStan).
- **§5:** GitHub / perimetro cross-modulo (condensato da welcome).
- **Pattern second brain:** tabella fix (trait probe, MorphMany, Spatie `teams()` vs `membershipTeams()`).
- **Standard Spatie rigido:** `teams()` = package; Laraxot membership = `membershipTeams()` — wiki User trait-alias.
- **Script:** `run-session-gate.sh` — cursor/windsurf ponytail separati + `ponytail-sync` check.

## [2026-06-30] PHPStan Modules — zero errori + Spatie teams()

- **Fatal risolto:** `HasTeams::teams()` → `membershipTeams()`; `HasSpatiePermission` trait puro (Spatie `teams()` canonico).
- **Contratto:** `UserContract::teams()` Spatie + `membershipTeams()` Laraxot.
- **Wiki:** [trait-alias-conflict-resolution.md](../../User/docs/wiki/concepts/trait-alias-conflict-resolution.md)
- **Verifica:** `cd laravel && ./vendor/bin/phpstan analyse Modules` → `[OK] No errors`.

## [2026-06-30] prompts | start.txt v14 — gate --markdown, ponytail-sync, path IDE

- `run-session-gate.sh --markdown [--phpstan]` precompila §7; exit code 1 su bloccanti.
- Junction `.cursor`/`.windsurf` → `.agents`; regole in `.cursor/rules/` (= `.agents/rules/`).
- Sync ponytail: `bashscripts/tools/ponytail-sync.sh`; §4+§5 condensati → link AGENTS.md.
- PHPStan gate: `trait.unused≈N` nel report; baseline documentata in §6.1.

## [2026-06-30] prompts | start.txt v13 — gate DRY + path Cursor rules

- Nuovo `bashscripts/tools/run-session-gate.sh` (implementa §1; flag `--phpstan` opzionale).
- §1.4: check regole Cursor su `bashscripts/ai/.cursor/rules/` (junction `.cursor` → `.agents` non ha `rules/`).
- Nuova `laravel-model-policies-sacred.mdc` nel mirror Cursor rules.
- §1.1: branch ahead/behind + untracked fuori scope.
- §6.1: fallback `phpstan-modules-gate.sh`; nota `trait.unused` e pattern neon obsoleti.

## [2026-06-30] prompts | start.txt v11 — gate output deterministico

- Sostituiti i pattern `pipeline | head || echo ok` nei controlli test/conflitti.
- Motivo: `head` puo' uscire 0 anche con input vuoto, lasciando il gate senza riga `ok`.
- Nuovo pattern: cattura in variabile, `test -n ... && printf || echo ok`.

## [2026-06-30] prompts | start.txt v10 — guard anti-append legacy

- Nuovo `guard-prompt-start-hygiene.sh` (BLOCCANTE se marker chef/query in coda)
- Rimosso di nuovo blocco legacy righe 340+ (append ricorsivo da welcome.txt)
- §1.1b: test naming solo `*/tests/*` (no falsi positivi `lang/`)
- `welcome.txt`: nota esplicita — non appendere a `start.txt`

## [2026-06-30] prompts | start.txt v9 — igiene e gate affidabile

- Rimosso blocco legacy duplicato in coda (violava §igiene prompt)
- PHPStan: exit code catturato **prima** di pipe/tail + riga `Found N errors`
- §1.1b igiene test (casing duplicati, PHPUnit legacy → Pest)
- §1.4 infra: WARN locale per `.claude`/`.cursor/rules` (skill ponytail resta obbligatoria)
- §1.9 QMD con fallback `rg` su wiki se `qmd` assente
- §1.10 GitHub cross-repo informativo
- Appendice eccellenza condensata (reflective, patterns — senza duplicare AGENTS.md)

## [2026-06-30] prompts | start.txt v8 — gate sessione

- Header allineato v8; PHPStan timeout 180s + tabella exit 0/1/124
- §1.5b `audit-policy-inventory.sh` + hub [policy-module-inventory.md](../../../../../docs/wiki/concepts/policy-module-inventory.md)
- Output gate: riga inventario policy 1:1
- README prompts aggiornato

## [2026-06-30] ponytail-audit | Phase 1-2 inlining complete, Phase 3 architectural review open

- **Phase 1-2 IMPLEMENTED** ✅:
  - `HandlersRepository` inlined into `HandlerDecorator` (-25 lines, -1 dep)
  - `MobilePushNotification` interface eliminated (-29 lines, -1 dep)
  - Files marked `.bak` (not deleted, per Ponytail methodology)
  - PHPStan Level 10: ✅ PASS
  - PHPMD: style warnings only (exception naming `$e` is standard)
  
- **Phase 3 PENDING REVIEW** ⏳:
  - 161 Data classes consolidation strategy (HIGH)
  - `BaseGeoService` polymorphism intent (MEDIUM)
  - `TeamContract` plugin extension intent (MEDIUM)
  - GitHub Issue: #237 — [Ponytail Audit Phase 3: Architectural Review](https://github.com/laraxot/base_predict_fila5/issues/237)

- Quality gate: ✅ PHPStan, ✅ PHPMD, ⏳ Pest timeout (repo-wide), ⏳ PHPInsights timeout (repo-wide)

## [2026-06-30] prompts | ripulitura fratelli + guard

- Risolti conflitti in `trans.txt` (riscrittura), `phpstan.txt` (32), `docs.txt` (34), `filament_class.txt` (38), `webmozarts_assert_rules.txt` (17).
- Nuovo `bashscripts/tools/guard-prompt-conflicts.sh`; hub [prompts-sibling-hygiene.md](../../../../../../docs/wiki/concepts/prompts-sibling-hygiene.md).
- `start.txt` v7: integra guard prompt in §1.3.

## [2026-06-30] prompts | start.txt v6 — second brain + guard policy

- `start.txt` v6: hub [llm-wiki.md](../../../../../../docs/wiki/index/llm-wiki.md), [sacred-artifacts-never-delete.md](../../../../../../docs/wiki/concepts/sacred-artifacts-never-delete.md), [quality-gate-canonical-commands.md](../../../../../../docs/wiki/concepts/quality-gate-canonical-commands.md).
- Gate §1.5 `guard-model-policy-delete.sh`; §1.4 `laravel-model-policies-sacred.mdc`; fallback `grep` se `rg` assente.
- Prompt fratelli con `<<<<<<<`: WARN (non bloccante sessione); solo `start.txt`/`rules.txt` bloccanti.
- PHPStan: exit 124 timeout documentato; `find` cartelle root PHP mirato (esclude legacy `Config/`).
- `prompts/README.md`: `start.txt` come primo step Quick Start.

## [2026-06-30] prompts | start.txt v5 — gate infrastruttura e igiene

- `start.txt` v5: sezioni `.claude` junction, ponytail, ponytail-audit hub, policy/actions protetti, fallback PHPStan modulo/file, anti-append ricorsivo.
- `rules.txt`: conflitti Git risolti forward-only; allineato a policy stub + Queueable Actions + migrations.
- Gate sessione: git pulito; conflitti PHP ok; 16 prompt fratelli ancora con `<<<<<<<` (esclusi start.txt e rules.txt); runtime PSR-4 ok; composer skeleton ok; PHPStan full-scan timeout/output binario noto.

## [2026-06-30] prompts | start.txt v4 — gate one-shot e igiene prompt

- `start.txt` v4: blocco **gate rapido one-shot**, regola igiene (no append query utente), `find -mindepth 1` per audit cartelle, link a `module-root-php-folders-forbidden.md`, `start.txt` canonico se `rules.txt` in conflitto.
- Gate: composer skeleton ok; artisan 13.17; runtime PSR-4 ok; 3 conflitti PHP Geo/Job; `rules.txt` in conflitto; 5 cartelle root maiuscole Xot (`Datas`, `View`, `Helpers`, `Services`, `Filament`).

## [2026-06-30] prompts | start.txt v3 — dedup e regole struttura modulo

- Ripulito `start.txt`: rimossi duplicati legacy; regole struttura modulo e Pest-only integrate.

## [2026-06-30] composer | verifica allineamento FixCity + wiki hub progetto

- Verificato: `laravel/composer.json` Predict gia' skeleton (piu' stretto di FixCity: no responsecache/phpmd/seeders nel root).
- Nuova pagina progetto: [`docs/wiki/concepts/composer-root-minimal-nwidart.md`](../../../../../../docs/wiki/concepts/composer-root-minimal-nwidart.md).
- Nuova pagina Xot: [`composer-merge-plugin-modules-only.md`](concepts/composer-merge-plugin-modules-only.md).
- Raw confronto aggiornato: [`composer-root-skeleton-fixcity-comparison-2026-06-30.md`](../raw/notes/composer-root-skeleton-fixcity-comparison-2026-06-30.md).

## [2026-06-30] composer | gate start.txt + autoload runtime temi

- Root `composer.json`: solo `App\\` e `Tests\\` in autoload (skeleton nwidart).
- Action: `RegisterRuntimePsr4NamespacesAction` per temi e seeders legacy app.
- Pagina: [`theme-psr4-autoload-without-merge.md`](concepts/theme-psr4-autoload-without-merge.md).

## [2026-06-30] composer | root skeleton allineato a FixCity

- Root `laravel/composer.json` ripulito: solo `php`, `laravel/framework`, `nwidart/laravel-modules`.
- Rimosso merge di `Themes/*/composer.json`; vietato anche PSR-4 root per temi e `Database\\Seeders\\`.
- Pagina corretta: [`theme-psr4-autoload-without-merge.md`](concepts/theme-psr4-autoload-without-merge.md).
- Aggiornata: [`composer-root-skeleton-modular.md`](concepts/composer-root-skeleton-modular.md).
- Raw: [`composer-root-skeleton-fixcity-comparison-2026-06-30.md`](../raw/notes/composer-root-skeleton-fixcity-comparison-2026-06-30.md).

## [2026-06-29] phpstan | HasXotTable grid label/state normalization

- `getGridTableColumns()` normalizza label e state tramite helper string-safe invece di cast/branch inline su `Htmlable|string|null` e `HasLabel`.
- PHPMD follow-up: aggiunti import espliciti per `Exception`, `HasLabel`, `Stringable`; rimossi import inutilizzati; eliminato commento inline `@var` superfluo.
- Motivo: PHPStan moltiplicava `function.alreadyNarrowedType`, `binaryOp.invalid` e `method.nonObject` nei contesti Filament che usano `HasXotTable`.
- Verifica: `cd laravel && ./vendor/bin/phpstan analyse Modules` -> 0 errori su 6428 file.
- Verifica PHPMD: `cd laravel && ./tools/phpmd.sh Modules/Xot/app/Filament/Traits/HasXotTable.php text phpmd.ruleset.xml` -> exit 0.

## [2026-06-15] phpstan | getRouteParameters helper

- Nuova pagina: [`concepts/get-route-parameters-helper.md`](concepts/get-route-parameters-helper.md).
- Helper globale in `helpers/Helper.php` per route params (Progressioni, Blade legacy).
- Risolve `function.notFound` su moduli in scope PHPStan.

## [2026-06-15] phpstan | HasRelationshipModelClass trait split

- Nuova pagina: [`concepts/has-relationship-model-class.md`](concepts/has-relationship-model-class.md).
- `getModelClass()` su RelationManager/ManageRelatedRecords isolato da `HasXotTable` per PHPStan level max.
- Consumer: 4 classi base Filament Xot con `insteadof`.

## [2026-06-15] phpstan | generic contratti User/Profile

- `UserContract::profile()` e `UserContract::tenants()` allineati alle relazioni Eloquent con declaring model `$this`.
- `ProfileContract::user()` allineato a `BelongsTo<Model&UserContract, $this>`.
- Motivo: Larastan non tratta i template relation come covarianti; il contratto deve descrivere lo stesso declaring model restituito da `hasOne()` / `belongsTo()`.
- Verifica: `cd laravel && ./vendor/bin/phpstan analyse Modules` -> 0 errori.

## [2026-06-13] docs | Hub platform-completion-roadmap + gate PHPStan zero

- Creato [overviews/platform-completion-roadmap.md](overviews/platform-completion-roadmap.md) — SSoT completamento 16 moduli + 4 temi.
- Aggiornati [PHPSTAN-BEST-PRACTICES.md](PHPSTAN-BEST-PRACTICES.md), [phpstan-pest-bridge-discipline.md](concepts/phpstan-pest-bridge-discipline.md).
- Fix test: `FileActionsTest`, `GetClassNameByPathActionTest` (pattern `@var` / `assertIsString`).
- Base [#372](https://github.com/laraxot/base_fixcity_fila5/issues/372).

## [2026-06-12] testing | Pest global class imports

- Aggiunto `rules/pest-global-class-imports.md`.
- Durante STORY-345 i run coverage hanno evidenziato warning PHP da `use ReflectionClass;` in test senza namespace.
- Regola: rimuovere l'import globale inutile; l'uso diretto `new ReflectionClass(...)` resta valido nei file global namespace.
## [2026-06-10] testing | Module TestCase XotBase hierarchy

- Aggiunto `rules/module-testcase-xotbase-hierarchy.md`.
- Decisione verificata: XotBaseTestCase non estende `Nwidart\Modules\Tests\BaseTestCase` perche' la classe non esiste in `nwidart/laravel-modules v13.0.0`.
- Activity/Xot TestCase usano XotBaseTestCase; transazioni e connessioni restano nei TestCase dei moduli.


## [2026-06-10] testing | module TestCase hierarchy XotBase

- Canon: `Modules/<Module>/tests/TestCase.php` -> `Modules\Xot\Tests\XotBaseTestCase` -> `Illuminate\Foundation\Testing\TestCase`.
- Scartata ipotesi `Nwidart\Modules\Tests\BaseTestCase`: nel package installato v13.0.0 e' dev-only/non autoloadata.
- Nuove pagine: `rules/module-testcase-xotbase-hierarchy.md`, `memories/testcase-hierarchy-nwidart-dev-only.md`.
- Coordinamento: issue Xot #33, discussion Xot #34.

## [2026-06-10] phpstan | Pest bridge discipline

- Aggiunto `concepts/phpstan-pest-bridge-discipline.md`.
- Xot puo' ospitare helper/bridge riusabili, ma i test dei moduli restano Pest e `laravel/phpstan.neon` resta dell'utente.

## [2026-06-07] phpstan | DTO factory self per run Modules no-flag

- `cd laravel && ./vendor/bin/phpstan analyse Modules` -> **4993 file, [OK] No errors**.
- DTO Xot concreti: factory `make()` con ritorno `self` e `new self()`, evitando `new static()` e PHPDoc `@var static` usati solo per placare PHPStan.
- Coinvolti: `ArticleData`, `AuthData`, `CookieData`, `FilemanagerData`, `MailData`, `NotificationData`, `OptionData`, `PwaData`, `RouteData`, `SearchEngineData`, `SubscriptionData`.

## [2026-06-07] quality | PHPStan shared Xot patterns

- Full gate root: `cd laravel && ./vendor/bin/phpstan analyse Modules --memory-limit=-1` → **4993 file, zero errori**.
- Pattern Xot: `formClass(): ?class-string` invece di stringa vuota, `getFormFill()` normalizzato a `array<string,mixed>`, `view-string` locale prima di `->view()`, dynamic fillable via hook `getDynamicFillableEnums()`.
- Propagazione: `Client` override hook dynamic fillable; `XotBaseResource::getPages()` evita shape sealed per risorse con pagine extra.

## [2026-06-05] docs | HackerNoon harness — tips 001-022 in wiki locale

- Stub/checklist: second-brain → canon Xot, ai-harness, [hackernoon map](../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md), [llm-wiki.txt](../../../../../bashscripts/tools/prompts/llm-wiki.txt)
- GitHub: [#272](https://github.com/laraxot/base_fixcity_fila5/issues/272) / [D#273](https://github.com/laraxot/base_fixcity_fila5/discussions/273)

---
title: "Activity Log"
module: "Xot"
---

# Activity Log — Xot

## [2026-06-05] docs | AI harness canon + stub moduli allineati

- [ai-harness-xot-discipline.md](concepts/ai-harness-xot-discipline.md) — owner harness PHPStan/XotBase
- Stub second-brain in 9+ moduli puntano a canon Xot + mappa HackerNoon #272

> **Purpose:** Append-only chronological activity record tracking ingests, queries, and lint passes.

## Log Entries

## [2026-05-26] docs | codice nominale pivot / ThemeComposer / ProfileFactory scan

- **Verifica sorgenti + script**: scaffold `Dashboard`/`RouteServiceProvider` per modulo (**atteso** moduli Laravel); divergenza reale famiglia **`BasePivot`** vs **`XotBasePivot`**; **`ProfileFactory`** basename ripetuto con hash diverso (User/Gdpr/Fixcity); **Cms ThemeComposer** duplicato nel path `resources/views/` fuori da PSR-4.
- **Deliverable**: [`redundancy/audit-profondo-ridondanze-holistic.md`](redundancy/audit-profondo-ridondanze-holistic.md) §5; modulo Cms **[`docs/redundancy-report.md`](../../../../Cms/docs/redundancy-report.md)** §5; [`concepts/redundancy-catalog.md`](concepts/redundancy-catalog.md) (riga Cms).

## [2026-05-25] docs | audit profondo ridondanze — second brain ripulito da merge-marker

- **Obiettivo**: consolidare osservabilità delle ripetizioni (codice + documentazione) senza toccare applicativo.
- **Deliverable**: [`redundancy/audit-profondo-ridondanze-holistic.md`](redundancy/audit-profondo-ridondanze-holistic.md); aggiornato [`byte-identical-files-static-scan.md`](redundancy/byte-identical-files-static-scan.md) (riesame numeri SHA256 rigorosi `.php` vs `.blade.php`); sistemati hub [`concepts/ridondanze-cross-cutting-codebase.md`](concepts/ridondanze-cross-cutting-codebase.md) e [`concepts/redundancy-catalog.md`](concepts/redundancy-catalog.md) (prima gravemente corrotti da `<<<<<<<`).
- **Nota modulo Fixcity tema**: superfici duplicate cross-modulo in [`fixcity-cross-module-duplicate-surfaces.md`](../../../Fixcity/docs/wiki/redundancy/fixcity-cross-module-duplicate-surfaces.md).

## [2026-05-24] refactor | wizard — normalizzazione stato **rimossa dalla base**

- **Motivo progetto**: il submit deve usare **`$this->form->getState()`** così come lo espone Filament/schema, senza helper PHP che appiattiscono wrapper (`wizard`) nel widget base.
- **Codice**: `XotBaseWizardWidget` contiene solo costruzione `Wizard` + policy `?step=` + vista tema; **nessun** `normalizeWizardFormState()` / `getWizardSchemaWrapperKey()` sulla classe.
- **Fixcity**: `CreateTicketWizardWidget::submit()` legge `getState()` e fa merge opzionale `owner_id` se auth; vedi [`CreateTicketWizardWidget.php`](../../Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php).

## [2026-05-24] refactor | wizard — normalizzazione stato dentro `XotBaseWizardWidget` (niente trait file) — **superata**

- **Nota storica**: per un breve periodo i metodi `normalizeWizardFormState` erano stati spostati sulla base al posto del trait file; **da 2026-05-24 (direzione corrente)** quei metodi non esistono più: vedi voce sopra.

- **Problema (storicamente)**: `CreateTicketWizardWidget` poteva ancora referenziare `NormalizesWizardFormState` mentre il file `.php` mancava → fatal Composer su molte working tree (`include … No such file`).
- **Soluzione intermedia (superata)**: metodi `protected` su `XotBaseWizardWidget` al posto del trait.
- **Soluzione attuale**: nessuna normalizzazione post-`getState()` nella base; schema/dehydrate definiscono la forma.

## [2026-05-23] fix | wizard — riferimento storico errato a trait `NormalizesWizardFormState` (fatal autoload)

- **Canonico oggi**: non creare **`NormalizesWizardFormState.php`**; non usare **`use Modules\Xot\Filament\Traits\NormalizesWizardFormState`**.
- **Nota storica / superata**: questa voce descriveva un tentativo di ripristino del trait; il trait **non** è parte dell'architettura.

- **Symptomo**: `/it/tests/segnalazione-crea` → errore fetale `Failed to open stream ... NormalizesWizardFormState.php` durante load di `CreateTicketWizardWidget`; niente markup wizard.
- **Fix (storico)**: rimuovere `use` trait fantasma / allineare al codice corrente; dopo pull eseguire `composer dump-autoload`.

## [2026-05-23] refactor | wizard widget — `HasWizard` sul widget Xot + trait satellite

- **Motivo UX**: ripristinare parità tipo bozza progetto storica (**alias `getParentWizardComponent`**, cancel SPA-aware, vista `pub_theme::components.wizard`).
- **File**: [`XotBaseWizardWidget.php`](../../app/Filament/Widgets/XotBaseWizardWidget.php); normalizzazione stato submit: metodi `protected` sulla stessa classe (2026-05-24), non più trait dedicato. Verificare eventualmente `DelegatesFilamentWizardSchemaMethods` se ancora presente in tree.

## [2026-05-23] audit | ridondanze codice — scan SHA256 cross-moduli/temi (#89/#90)

- Gruppi byte-identical (SHA256; cross-owner senza `/tests/`): **431** `.php` (**72** cross-owner), **179** Blade (**53** cross-owner). [`redundancy/byte-identical-files-static-scan.md`](redundancy/byte-identical-files-static-scan.md). Hub [`concepts/ridondanze-cross-cutting-codebase.md`](concepts/ridondanze-cross-cutting-codebase.md). Indice wiki root [`code-redundancy-audit.md`](../../../../../docs/wiki/concepts/code-redundancy-audit.md). Commenti `#89`, `#90`, `#80`.


## [2026-05-22] docs | DRY second brain + merge doc wizard HasWizard

- **`second-brain-local-discipline`:** solo [`concepts/second-brain-local-discipline.md`](concepts/second-brain-local-discipline.md) mantiene il corpo; negli altri nove moduli stesso basename → stub puntatore canonica.
- **Wizard refactor:** contenuto consolidato in [`filament-wizard-refactoring.md`](filament-wizard-refactoring.md); [`XotBaseWizardWidget-HasWizard-refactor.md`](XotBaseWizardWidget-HasWizard-refactor.md) ridotto a stub (permalink storici).
- Hub aggiornato: [`concepts/ridondanze-cross-cutting-codebase.md`](concepts/ridondanze-cross-cutting-codebase.md).

## [2026-05-21] docs | inventario ridondanze codebase + scaffold docs

- Nuovo hub concettuale [`concepts/ridondanze-cross-cutting-codebase.md`](concepts/ridondanze-cross-cutting-codebase.md): incrocia **`docs/redundancy-report.md`**, duplicazioni `second-brain-local-discipline`, doc wizard quasi gemelle nel tema Sixteen e cluster legacy modulo User; puntatori verso **`filament/redundancy-rules.md`**.

## [2026-05-21] docs | LAMP — `docs/lamp/install.txt` riscritto

- Guida strutturata: Sury PHP 8.4, pacchetti deduplicati, `pdo-dblib`/odbc, sezioni opzionali (imagick/swoole/redis), Xdebug solo dev, Apache `libapache2-mod-php8.4`, `update-alternatives`, link incrociati verso [`wiki/concepts/php84-upgrade-extension-checklist.md`](wiki/concepts/php84-upgrade-extension-checklist.md) e [`docs/README.md`](../README.md).

## [2026-05-21] dependency | model-states installato — PHP 8.4 — #87

- `spatie/laravel-model-states` **2.14.1** in `vendor/`; PHPStan `Modules/Xot/app/States` OK dopo `clear-result-cache`.
- Comandi reali: `php8.4 … composer update -W` da `laravel/`; **non** `composer run go` (migrations wipe). Lock root generato ma **`.gitignore` `*.lock`**.
- [`phpstan-fixes-log.md`](concepts/phpstan-fixes-log.md), [checklist PHP 8.4](concepts/php84-upgrade-extension-checklist.md).

## [2026-05-21] docs | checklist PHP 8.4 — prima bozza `composer run go`

- Correzioni intermedie in [`concepts/php84-upgrade-extension-checklist.md`](concepts/php84-upgrade-extension-checklist.md). **Revisione finale** stesso giorno: snippet con `php8.4 … composer update -W` + avviso su `composer run go` distruttivo.

## [2026-04-28] dependency | matrice compatibilita' pacchetti Laravel 13 in Xot

- verificata compatibilita' reale dei pacchetti rimossi nel passaggio a Laravel 13 con focus su runtime `php 8.3`.
- confermato che `fruitcake/laravel-debugbar` (`v4.2.8`) e' gia' dichiarato in `Modules/Xot/composer.json` (`require-dev`) e risolto nel lock root.
- confermato owner runtime Xot per `fast-paginate` e `morph-to-one`; entrambi oggi bloccati per assenza di supporto stable a `Laravel 13`.
- chiarito che `model-states` ha owner condiviso `UI` + `Xot`, mentre `responsecache` non ha integrazione runtime forte verificata nel codice corrente.
- nuova pagina: `docs/wiki/concepts/laravel13-modular-package-compatibility-matrix.md`.

## [2026-06-30] governance | Composer root skeleton modulare

- Confrontato `base_fixcity_fila5/laravel/composer.json` con Predict.
- Aggiornata la regola: root minimo con `php`, `laravel/framework`, `nwidart/laravel-modules`; merge solo `Modules/*/composer.json`.
- Chiariti anti-pattern: niente `Modules\\`, `Database\\Seeders\\` o `Themes\\*\\` nell'autoload root, niente merge dei temi, niente dipendenze funzionali nel root.
- Raw note: `docs/raw/notes/composer-root-skeleton-fixcity-comparison-2026-06-30.md`.
- Wiki: `docs/wiki/concepts/composer-root-skeleton-modular.md`.

## [2026-04-27] governance | policy module matrix

- aggiunta matrice modulo-per-modulo con base policy consigliata (`XotBasePolicy` vs `UserBasePolicy`).
- inserite priorita' di allineamento per ridurre drift nei moduli ibridi.
- nuova pagina: `docs/wiki/concepts/policy-module-matrix.md`.

## [2026-04-27] governance | policy base strategy across modules

- documentata strategia di base per scegliere tra `XotBasePolicy` e `UserBasePolicy`.
- mantenuta separazione: `XotBasePolicy` come base tecnica cross-modulo, `UserBasePolicy` come specializzazione identity-domain.
- nuovo decision tree operativo in `docs/wiki/concepts/policy-base-strategy.md`.

## [2026-04-23] quality | PHPStan cluster map and false friends

- Documentati i cluster statici ricorrenti emersi da `phpstan analyse Modules` con focus su Xot: `implode`, `array_fill_keys`, `mixed`, funzioni unsafe e mismatch con API Filament.
- Nuova pagina: `docs/wiki/concepts/phpstan-cluster-map-and-false-friends.md`.

## [2026-04-23] governance | XotBaseField calculated view rule

- Formalizzata la regola corretta per i componenti che estendono `XotBaseField`: niente `protected string $view` nei singoli field, ma risoluzione centralizzata via `getDefaultView()` nel base class.
- Verifica runtime eseguita sulla URL reale `tests/segnalazione-crea`: dopo il fix `CoordinatePicker` torna a renderizzare correttamente.

## [2026-04-22] ops | context-mode + QMD per story BMAD

- **regola root**: `docs/wiki/concepts/context-compression-discipline.md`
- **scope Xot**: base classes e documentazione framework vanno recuperate tramite QMD/context-mode con snippet minimi quando uno skill BMAD rischia il limite `131072 tokens`.
- **verifica**: context-mode plugin/MCP connessi; QMD indicizza moduli/temi/root/bashscripts.

## [2026-05-12] ops | opencode compaction overflow hardening

- installato `@tarquinen/opencode-dcp@latest` nel config globale OpenCode.
- creato `opencode.json` al git root con `compaction.auto=true`, `compaction.prune=true`, `compaction.reserved=40000`.
- chiarito che il punto operativo corretto e' il git root, non `laravel/opencode.json`.
- aggiornata la source wiki `sources/context-compression-and-retrieval.md` per riflettere il nuovo setup stabile.

## [2026-04-22] governance | Filament wizard summary via Infolists

- **regola root**: `docs/wiki/concepts/filament-summary-infolist-rule.md`
- **scope Xot**: quando wrapper, trait o base widget espongono/validano `getSummarySchema()`, il summary read-only deve essere modellato con `Filament\Infolists\Components\*`, non con `SchemaView`.
- **fonte ufficiale**: https://filamentphp.com/docs/5.x/infolists/overview

## [2026-04-20] pattern | UnitTestCase senza MySQL per test puri

- **motivo**: `Modules\Geo\Tests\TestCase` richiedeva MySQL anche per 17 test puramente PHP → `PDOException` su ambienti senza DB configurato
- **soluzione**: creato `UnitTestCase` in Geo che usa `CreatesApplication` (Xot) senza `DatabaseTransactions`
- **pages**:
  - `docs/wiki/concepts/unit-test-case-pattern.md` (**NUOVA**): template riutilizzabile per ogni modulo
  - `docs/wiki/index.md`: aggiornato sezione Testing Patterns
- **applicabilità**: pattern replicabile in qualsiasi modulo per test Pest/PHPUnit senza DB

---

_No activity yet. Start by ingesting raw documents._

### Format

```
[YYYY-MM-DD HH:MM:SS UTC] [OPERATION] Description
```

**Operations:**
- `INGEST` — Added raw document to wiki
- `QUERY` — Answered question from wiki
- `LINT` — Maintained wiki quality
- `UPDATE` — Modified existing wiki page

---

**Last Activity:** None  
**Total Operations:** 0

## [2026-04-27] cross-reference | Policy Decision
- Linked: ../User/docs/wiki/concepts/policy-inheritance-boundary.md
- Decision: Mantenere separazione XotBasePolicy (foundation) vs UserBasePolicy (application)
- XotBasePolicy: zero dipendenze, system processes, API token
- UserBasePolicy: Spatie Permission, user-authenticated, RBAC
- Commit: docs: add cross-reference to policy boundary decision

2026-06-30 | start.txt v12 — cleanup: rimosso §1.10 duplicato, rg pre-check, test-naming in output, PHPStan consolidato in §6, appendice compressa
