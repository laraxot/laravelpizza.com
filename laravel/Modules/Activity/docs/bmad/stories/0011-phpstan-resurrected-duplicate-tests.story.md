---
title: "PHPStan: test duplicati resuscitati dalla sync (LogoutListener, Snapshot)"
type: story
epic: tooling-quality
module: Activity
status: review
created: 2026-11-25
qmd: "phpstan activity test resuscitati sync one-empty logoutlistener snapshot duplicati reflectionnamedtype"
related:
  - ../../../../Xot/docs/bmad/stories/merge-conflict-markers-committed-bonifica.story.md
---
# Test duplicati resuscitati dalla sync

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

## Causa

A `SYNC_BASE` (`c826d2258b`) il root aveva ridotto `tests/Unit/Listeners/LogoutListenerTest.php`
a stub vuoto (duplicato di `LoginLogoutListenerBehaviorTest` + `tests/Unit/LogoutListenerTest`).
Il commit `d24d597f8b` ha portato marker con lato HEAD vuoto; la risoluzione "one-empty" ha
ripreso il lato `laraxot/dev`, cioe' il vecchio test completo. Stessa dinamica per
`tests/Unit/Models/SnapshotBusinessLogicTest.php` (`uses()` prima degli `use` senza namespace →
`TestCase` globale inesistente).

PHPStan Modules: 7 errori, tutti qui (`ReflectionType::getName`, `Logout(…, null)`,
`is_subclass_of` sempre vero, asserzioni ridondanti, `class.notFound TestCase`).

**Lezione:** "un lato vuoto" non significa "tieni l'altro" quando il lato vuoto e' una
cancellazione voluta del root: confrontare con il blob a `SYNC_BASE`.

## Fix

- File mantenuti (regola: niente cancellazione di test senza consenso) ma ridotti alle sole
  asserzioni non coperte altrove: contratto di firma `handle(Logout)` con `ReflectionNamedType`;
  `$connection` dichiarata, `getFillable()`, `@property` documentate.
- Rimosso tutto cio' che era gia' coperto (istanza, `hasMethod`, utente null, `is_subclass_of`).

## Gate

- [x] PHPStan sui file: `[OK] No errors`; Pint passed
- [x] PHPStan Modules completo (cache fredda): `{"errors":0,"file_errors":0}` alle 10:2x
- [ ] Pest: skip documentato — `TestDatabaseGuard` rifiuta `10.100.200.53` anche via
      `bashscripts/tools/pest-scratch-db.sh` (nessun MariaDB locale in questo WSL)


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
