---
title: "Baseline BMAD per i moduli PTVX"
type: memory
status: active
created: 2026-09-28
updated: 2026-09-28
tags: [bmad, modules, architecture, brainstorming, epics, stories, second-brain]
qmd: "BMAD moduli architecture brainstorming epics stories baseline documentazione"
---

# Baseline BMAD per i moduli PTVX

Il 2026-09-28 è stata creata una baseline BMAD locale per i 18 moduli con
`module.json` sotto `laravel/Modules/`. Per ogni modulo sono stati creati quattro
artefatti nei docs del modulo:

- `docs/bmad/architecture/module-boundary.md`;
- `docs/bmad/brainstorming/module-opportunities.md`;
- `docs/bmad/epics/module-roadmap.md`;
- `docs/bmad/stories/module-bmad-audit.story.md`.

I conteggi PHP/test e le aree `app/` sono inventario statico verificato; le ipotesi
di dominio sono marcate come domande da validare e non come fatti. Le story restano
`ready-for-dev` finché API pubbliche, flussi critici, test e gate del singolo modulo
non vengono verificati. Non sono stati sovrascritti i 594 artefatti BMAD già esistenti.
