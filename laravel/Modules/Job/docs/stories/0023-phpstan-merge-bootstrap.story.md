---
title: "PHPStan merge bootstrap — Job"
type: story
module: Job
status: done
priority: high
tags: [phpstan, merge, conflict-resolution, bootstrap, job]
qmd: "job phpstan merge bootstrap conflict markers Status livewire schedule"
related:
  - "./02.job-merge-conflict-resolution.story.md"
  - "./01.job-phpstan-fix.story.md"
  - "./12.1.retire-job-http-livewire.story.md"
  - "../../../TechPlanner/docs/stories/phpstan-merge-bootstrap.story.md"
---
# PHPStan merge bootstrap — Job

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

## Scopo

Chiudere i residui di marker merge nei PHP Job che bloccavano il bootstrap qualità
(PHPStan / lint) dopo collisioni forward-only. Story canonica per questo batch;
storico ampio già in [02.job-merge-conflict-resolution.story.md](0002-job-merge-conflict-resolution.story.md).

## Perimetro risolto

| File | Decisione |
|------|-----------|
| `app/Http/Livewire/Schedule/Status.php` | **theirs-short**: `@return Collection<int, Event>` — `Event` già importato; FQCN ridondante |

## Acceptance

- [x] Zero marker `<<<<<<<` nel PHP Job toccato
- [x] `php -l` verde su `Status.php`
- [x] Themes: nessuno marker PHP (scan condiviso)

## Note

`phpstan.neon` non toccato. Livewire Schedule Status resta in `Http/Livewire` finché
non chiude [12.1](0005-retire-job-http-livewire.story.md).


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
