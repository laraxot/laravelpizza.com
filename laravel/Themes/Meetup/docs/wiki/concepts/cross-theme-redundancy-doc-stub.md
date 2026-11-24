---
title: "stub redondancy analysis cross-theme"
type: concept
module: Meetup
tags: [redundancy, documentation-debt, themes]
created: 2026-05-22
updated: 2026-05-23
related:
  - ../../../../../../docs/wiki/concepts/code-redundancy-audit.md
sources: []
---

# Stub `REDUNDANCY_ANALYSIS.md` (Meetup e altri temi)

## Scopo

Più temi e un modulo duplicano lo **stesso file** `docs/REDUNDANCY_ANALYSIS.md` con una sola riga che punta a `docs/analysis/redundancies/summary.md` (path **non presente** nel tree attuale del repo o non versionato qui). È **ridondanza documentale**: stesso messaggio ripetuto senza contenuto operativo locale.

File osservati (stesso testo sostanzialmente):

- `laravel/Themes/Meetup/docs/REDUNDANCY_ANALYSIS.md`
- `laravel/Themes/TwentyOne/docs/REDUNDANCY_ANALYSIS.md`
- `laravel/Themes/Barthelemy/docs/REDUNDANCY_ANALYSIS.md`
- `laravel/Modules/Sixteen/docs/REDUNDANCY_ANALYSIS.md`
- `laravel/Modules/UI/docs/REDUNDANCY_ANALYSIS.md`
- analogamente `laravel/Themes/Sixteen/docs/REDUNDANCY_ANALYSIS.md` (punto ingresso pubblico tema principale FixCity).

## Direzione tecnica canonica

- Inventario tecnico **cross-modulo** (codice PHP + Filament): [`Modules/docs/redundancy-report`](../../../../../Modules/docs/redundancy-report.md) (cwd `laravel/`).
- Indice navigazione **Xot** + overlap doc wizard: [`redundancy-catalog`](../../../../../Modules/Xot/docs/wiki/concepts/redundancy-catalog.md).

## Tracker

- Issue GitHub: [#90 — Code redundancy audit](https://github.com/laraxot/base_fixcity_fila5/issues/90)
- Consolidare questo stub sostituendolo con un link alla summary reale quando `docs/analysis/redundancies/summary.md` esiste, oppure deprecare il file verso wiki `docs/wiki/concepts/code-redundancy-audit.md`.

