---
title: "Activity Log"
<<<<<<< HEAD
=======
type: log
module: Xot
tags: [xot, phpstan, pest, qmd]
created: 2026-04-20
updated: 2026-06-29
qmd: "Xot log phpstan pest bridge discipline"
issues:
  - "https://github.com/laraxot/module_xot_fila5/issues/28"
discussions:
  - "https://github.com/laraxot/module_xot_fila5/discussions/29"
---

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
>>>>>>> 40b96bcd6 (.)
module: "Xot"
---

# Activity Log — Xot

<<<<<<< HEAD
=======
## [2026-06-05] docs | AI harness canon + stub moduli allineati

- [ai-harness-xot-discipline.md](concepts/ai-harness-xot-discipline.md) — owner harness PHPStan/XotBase
- Stub second-brain in 9+ moduli puntano a canon Xot + mappa HackerNoon #272

>>>>>>> 40b96bcd6 (.)
> **Purpose:** Append-only chronological activity record tracking ingests, queries, and lint passes.

## Log Entries

<<<<<<< HEAD
## [2026-05-05] fix | PHPStan Error Resolution - spatie/browsershot (PACKAGE INSTALLATION)

- **Problem**: PHPStan riportava `Class Spatie\Browsershot\Browsershot not found`
- **Analysis**: Il codice che usa Browsershot è attivamente usato in produzione:
  - `MakePdfSpatieTestAction` - Generazione PDF
  - `ExportChartPngQueueableAction` - Export chart PNG
  - `ExportChartSvgQueueableAction` - Export chart SVG
  - Test: `MakePdfSpatieTestActionTest`
- **Fix**: Aggiunto `"spatie/browsershot": "^5.0"` a `Modules/Xot/composer.json`
- **Command**: `composer update spatie/browsershot`
- **Philosophy**: Se il codice è usato → installa la dipendenza; se è dead code → rimuovi
- **Status**: ⏳ Installing
- **Story**: 8-121

## [2026-05-05] fix | PHPStan Error Resolution - spatie/laravel-model-states (DEAD CODE REMOVAL)

- **Problem**: PHPStan riportava `Class Spatie\ModelStates\State not found` in `XotBaseState` e `XotBaseTransition`
- **Analysis**: Nessuna classe nel codebase estende `XotBaseState` o `XotBaseTransition` - codice orfano
- **Attempted Fix #1**: Aggiungere `spatie/laravel-model-states` al composer.json
- **Issue**: Conflitto di dipendenze con PHP 8.3 e illuminate/contracts
- **Final Fix**: RIMOZIONE dead code (YAGNI principle - You Ain't Gonna Need It)
- **Files Removed**:
  - `Modules/Xot/app/States/XotBaseState.php`
  - `Modules/Xot/app/States/Transitions/XotBaseTransition.php`
  - `Modules/Xot/tests/Unit/XotBaseTransitionTest.php`
  - `Modules/Xot/app/States/` directory (vuota)
- **Philosophy**: 
  - Zero tolerance per errori ignorati
  - Se non puoi installare la dipendenza e il codice non è usato → rimuovi il codice
  - YAGNI: Don't add functionality until you need it
- **Status**: ✅ Risolto (rimosso ~20 errori PHPStan)
- **Story**: 8-121

## [2026-05-04] architecture | XotBaseWizardWidget view calculation rule

- documentata regola architetturale: sottoclassi di `XotBaseWizardWidget` NON devono definire `$view` property
- la view viene calcolata automaticamente: admin → default Filament, frontoffice → `pub_theme::components.wizard`
- aggiunta documentazione: `docs/wiki/concepts/xotbasewizard-view-calculation.md`
- creata regola Windsurf: `.windsurf/rules/xotbasewizard-no-view-property.mdc`
- aggiornato PHPDoc in `XotBaseWizardWidget.php` con dettagli view resolution
- audit: nessuna violazione trovata nei moduli esistenti

## [2026-04-30] governance | Claude Code Laraxot rules path-scoped

- aggiunta pagina `docs/wiki/concepts/claude-code-laraxot-rules-path-scoping.md`.
- allineata la configurazione `.claude/rules` alla documentazione ufficiale Claude Code: le rules specifiche di codice devono avere frontmatter `paths`.
- obiettivo: ridurre contesto always-on mantenendo attive le regole XotBase/Filament solo sui file pertinenti.
=======
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
>>>>>>> 40b96bcd6 (.)

## [2026-04-28] dependency | matrice compatibilita' pacchetti Laravel 13 in Xot

- verificata compatibilita' reale dei pacchetti rimossi nel passaggio a Laravel 13 con focus su runtime `php 8.3`.
- confermato che `fruitcake/laravel-debugbar` (`v4.2.8`) e' gia' dichiarato in `Modules/Xot/composer.json` (`require-dev`) e risolto nel lock root.
- confermato owner runtime Xot per `fast-paginate` e `morph-to-one`; entrambi oggi bloccati per assenza di supporto stable a `Laravel 13`.
- chiarito che `model-states` ha owner condiviso `UI` + `Xot`, mentre `responsecache` non ha integrazione runtime forte verificata nel codice corrente.
- nuova pagina: `docs/wiki/concepts/laravel13-modular-package-compatibility-matrix.md`.

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

<<<<<<< HEAD
=======
## [2026-05-12] ops | opencode compaction overflow hardening

- installato `@tarquinen/opencode-dcp@latest` nel config globale OpenCode.
- creato `opencode.json` al git root con `compaction.auto=true`, `compaction.prune=true`, `compaction.reserved=40000`.
- chiarito che il punto operativo corretto e' il git root, non `laravel/opencode.json`.
- aggiornata la source wiki `sources/context-compression-and-retrieval.md` per riflettere il nuovo setup stabile.

>>>>>>> 40b96bcd6 (.)
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
<<<<<<< HEAD

## [2026-05-07] ingest | Array Keys Rule
- **Created**: [array-keys-rule.md](./array-keys-rule.md)
- **Rule**: Tutti i metodi che restituiscono array DEVONO usare chiavi stringhe
- **Reason**: Leggibilità, Type-safety (PHPStan L10), manutenzione, consistenza
- **Updated**: XotBaseResourceTable return types, structure.txt, index.md
- **Commit**: docs: add array-keys-rule for Filament schemas
=======
>>>>>>> 40b96bcd6 (.)
