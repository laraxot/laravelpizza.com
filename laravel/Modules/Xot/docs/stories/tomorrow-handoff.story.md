---
title: Handoff BMAD: continua domani
type: story
module: Xot
status: ready-for-dev
priority: P0
created: 2026-10-20
updated: 2026-10-20
tags: [bmad, handoff, swarm, quality, livewire, services, docs]
qmd: "handoff tomorrow bmad stories quality livewire services docs spine phpstan"
related:
  - ./code-quality-pint-xot-cms-user.story.md
  - ./code-quality-strict-types-cms-media.story.md
  - ./code-quality-filament-label-audit.story.md
  - ./livewire-widgets-w1-job.story.md
  - ./livewire-widgets-w1-user-auth.story.md
  - ./docs-spine-wave2-activity.story.md
  - ./services-delete-again-boy-scout.story.md
  - ./phpstan-modules-continuous.story.md
  - ./services-to-actions-global-wave.story.md
  - ../bmad/code-quality-wave.md
  - ../bmad/stories/livewire-to-filament-widgets-fleet.story.md
  - ../bmad/filament-blueprint.md
  - ../conventions/docs-organization.md
---

# Handoff: continua domani

Hub unico per ripartire senza rileggere tutta la chat. Religione: PHPStan zero
non ferma il lavoro; BMAD + second brain + Filament blueprint restano obbligatori.

## Snapshot chiuso oggi (non rilanciare da zero)

| Gate | Esito |
|------|--------|
| `phpstan analyse Modules --memory-limit=2G` | OK |
| `Modules/*/app/Services` dirs/PHP | 0/0 |
| Filament direct extends produzione | 0 (baseline ratchet = 1 mock test) |
| Lotto XotBase Notify/UI/Geo | fatto |
| Docs spine wave1 (`readme.md` duplex) | fatto |

## Ordine consigliato (swarm: solo dentro la stessa wave, scope disgiunti)

| # | Story | Owner path | Parallel? |
|---|-------|------------|-----------|
| 0 | [phpstan-modules-continuous](./phpstan-modules-continuous.story.md) | coords | seriale all’apertura |
| 1a | [code-quality-pint-xot-cms-user](./code-quality-pint-xot-cms-user.story.md) | Xot/Cms/User contracts+filament | vs 1b |
| 1b | [code-quality-strict-types-cms-media](./code-quality-strict-types-cms-media.story.md) | Cms database/* + Media AwsTest | vs 1a |
| 1c | [code-quality-filament-label-audit](./code-quality-filament-label-audit.story.md) | Resource canary + lang keys | vs 1a/1b se file disgiunti |
| 2a | [livewire-widgets-w1-job](./livewire-widgets-w1-job.story.md) | Job Http/Livewire | vs 2b |
| 2b | [livewire-widgets-w1-user-auth](./livewire-widgets-w1-user-auth.story.md) | User Auth Livewire | vs 2a |
| 3 | [docs-spine-wave2-activity](./docs-spine-wave2-activity.story.md) | Activity/docs UPPERCASE | parallelo a 2* |
| 4 | [services-delete-again-boy-scout](./services-delete-again-boy-scout.story.md) | qualsiasi `app/Services` riesumato | continuo |

Fleet Livewire completa: [livewire-to-filament-widgets-fleet](../bmad/stories/livewire-to-filament-widgets-fleet.story.md)
(W0 già DONE; domani = W1).

## Hard rules

- Mai toccare `laravel/phpstan.neon` / altri `.neon`.
- Mai creare cartelle `docs/` nuove; solo file in `docs/` esistenti.
- Nomi `.md` kebab minuscolo (eccetto `README.md`).
- Services: delete-again, non convertire se Action esiste.
- Filament: solo `XotBase*`; no `->label()` hardcoded.

## Comandi apertura sessione

```bash
cd laravel
free -h | sed -n '1,2p'
find Modules -type d -path '*/app/Services' ! -path '*/tests/*' ! -path '*/vendor/*' | wc -l
./vendor/bin/phpstan analyse Modules --memory-limit=2G --no-progress
```

## Second brain

Initiative: BMAD stories handoff continua domani. Aggiornare Hindsight a fine
sessione con esiti story (done/blocked).
