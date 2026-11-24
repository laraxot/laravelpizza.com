---
title: "PHPStan merge bootstrap — Job"
type: story
module: Job
status: done
priority: high
tags: [phpstan, merge, conflict-resolution, bootstrap, job]
qmd: "job phpstan merge bootstrap conflict markers Status livewire schedule"
related:
  - "./02.Job-merge-conflict-resolution.story.md"
  - "./01.Job-phpstan-fix.story.md"
  - "./12.1.retire-job-http-livewire.story.md"
  - "../../../TechPlanner/docs/stories/phpstan-merge-bootstrap.story.md"
---

# PHPStan merge bootstrap — Job

## Scopo

Chiudere i residui di marker merge nei PHP Job che bloccavano il bootstrap qualità
(PHPStan / lint) dopo collisioni forward-only. Story canonica per questo batch;
storico ampio già in [02.Job-merge-conflict-resolution.story.md](./02.Job-merge-conflict-resolution.story.md).

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
non chiude [12.1](./12.1.retire-job-http-livewire.story.md).
