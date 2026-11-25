---
id: story-continuation-job-module
title: "Job Module — Table Audit and $model Property"
type: continuation
scope: module:Job
github: {issues: "https://github.com/laraxot/module_xot_fila5/issues/115", discussions: "https://github.com/laraxot/module_xot_fila5/discussions/117"}
qmd: "continuation story table audit model property"
---
# Job Module — Continuation Task

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

## Stato
Modulo con modifiche non ancora sincronizzate nel proprio .git.

## Task
1. Aggiungere `protected static string $model =` a tutte le table class mancanti
2. Audit `getTableColumns()` — verificare campi modello
3. Migliorare UI/UX (badge, toggleable, sortable)
4. `php -l` su tutti i file toccati
5. `git commit -m "BMAD: table audit"`

## Modelli attesi (da verificare)
- Tabella: `Modules\$m\Filament\Resources\*`
- Modello: `Modules\$m\Models\*`


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
