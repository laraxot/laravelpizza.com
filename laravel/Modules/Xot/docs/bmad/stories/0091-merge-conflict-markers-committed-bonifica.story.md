---
qmd: merge-conflict-markers-committed phpstan bootstrap syntax-error swarm resolve
epic: tooling-quality
title: Bonifica marker di conflitto committati in Modules (43 file PHP)
status: in-progress
module: Xot
---
# Bonifica marker di conflitto committati

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

## Contesto

Commit `d24d597f8b` ha committato marker di merge non risolti (`<<<<<<< HEAD` /
`=======` / `>>>>>>> laraxot/dev`, inclusi marker `.merge_file_*` annidati) in
43 file PHP sotto `laravel/Modules/`. PHPStan fallisce al bootstrap con
`syntax error, unexpected token "<<"` perché un file `app/` viene autoloadato
durante l'avvio Filament.

## Scope

- Activity, Job, Lang, Media, Notify, UI, User, Xot — file in `app/` e `tests/`.
- Per ogni file: leggere entrambi i lati del conflitto, capire lo scopo della
  modifica, scegliere/accorpare la versione semanticamente corretta, mai
  buttare via una feature.
- File `lang/*.php`: attenzione alla regola "una chiave per riga".

## Acceptance criteria

- [ ] Zero occorrenze di `^<{7}|^={7}|^>{7}` in `laravel/Modules/**/*.php`
- [ ] `php -l` verde su tutti i file toccati
- [ ] `phpstan analyse Modules` completa e si esegue fino alla fine
- [ ] Pest mirato sui test toccati (o skip documentato)


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
