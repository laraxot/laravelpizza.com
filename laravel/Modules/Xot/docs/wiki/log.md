---
title: "Activity Log"
module: "Xot"
---

# Activity Log — Xot

> **Purpose:** Append-only chronological activity record tracking ingests, queries, and lint passes.

## Log Entries

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

## [2026-05-07] ingest | Array Keys Rule
- **Created**: [array-keys-rule.md](./array-keys-rule.md)
- **Rule**: Tutti i metodi che restituiscono array DEVONO usare chiavi stringhe
- **Reason**: Leggibilità, Type-safety (PHPStan L10), manutenzione, consistenza
- **Updated**: XotBaseResourceTable return types, structure.txt, index.md
- **Commit**: docs: add array-keys-rule for Filament schemas
