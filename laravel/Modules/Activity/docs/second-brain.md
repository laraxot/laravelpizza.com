---
title: second brain — puntatore modulo
type: reference
qmd: second brain modulo wiki locale laravel
updated: 2026-10-21
status: active
tags: [docs, activity, event-sourcing, audit, phpstan]
---

# Second brain (modulo)

Stub **puntatore**: disciplina e link esterni curati stanno nella wiki di progetto.

| Strato | Dove in questo package |
|--------|-------------------------|
| Input / note grezze | questa cartella `docs/` (escluso `docs/wiki/`) |
| Wiki compilata | `docs/wiki/` del modulo |
| Regole globali | wiki root del monorepo |

## Link operativi (relativi al repo)

- Modello: [../../../../docs/wiki/concepts/second-brain-operating-model.md](../../../../docs/wiki/concepts/second-brain-operating-model.md)
- Guida wiki modulo: [../../../../docs/wiki/how-to/module-wiki-documentation.md](../../../../docs/wiki/how-to/module-wiki-documentation.md)
- Benchmark lettura esterna (Karpathy, Obsidian, PARA, …): [../../../../docs/wiki/sources/second-brain-external-benchmarks.md](../../../../docs/wiki/sources/second-brain-external-benchmarks.md)
- **Filament (stack attuale): v5** — non v4. [filament-version.md](./filament-version.md) · policy: [../../../../docs/wiki/memories/filament-version-policy.md](../../../../docs/wiki/memories/filament-version-policy.md) · Xot: [../../Xot/docs/filament-5-laraxot-rules.md](../../Xot/docs/filament-5-laraxot-rules.md)
- **Modulo purpose (domain):** audit / event-sourcing (chi, quando, cosa). PHPStan Level 10 essenziale: log immutabile richiede null-safe `?->` su `Command`, risolti 19 `method.nonObject` in seeder 2026-10-21.
- **PHPStan status (2026-10-21):** [OK] 0 errori — fix `ActivityMassSeeder`: `null-safe ?->info/?->error`. Story: `docs/bmad/stories/phpstan-activity-mass-seeder.story.md`. No ignore / no baseline.
