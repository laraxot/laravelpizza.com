<<<<<<< .merge_file_5jewXC
<<<<<<< HEAD
# Best Practices – Activity

## Principi DRY/KISS
- **DRY**: Centralizza logica di orchestrazione in `ActivityService`. Usa repository pattern per entità.
- **KISS**: Usa ID semplici per identificatori esterni, non UUID complessi in interfacce.
- **Clean Code**: Applica `Spatie Color` per icone tematiche senza duplicare codice.

## Componenti
- Usa `ActivityLog` per registrare eventi critici.
- Usa progetti con `status` calcolato (`active`, `paused`, `completed`).

## Test
- Implementa test di integrazione per flussi di lavoro complessi.
- Copri casi limite come transizioni di stato non valide.

## Documentazione
- Aggiorna `docs/INDEX.md` con nuovi modelli e relazioni.
- Collega a `Projects` e `Tasks` per contesto operativo.
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
---
title: "Best Practices – Activity"
type: note
status: draft
updated: 2026-10-08
tags: [docs, activity]
qmd: "best practices   activity activity"
---
>>>>>>> .merge_file_HM2FiY
# Best Practices – Activity

## Principi DRY/KISS
- **DRY**: Centralizza la logica di orchestrazione in Actions (es. `LogActivityAction`), mai in Services.
- **KISS**: Usa ID semplici per identificatori esterni, non UUID complessi in interfacce.
- **Clean Code**: Applica `Spatie Color` per icone tematiche senza duplicare codice.

## Componenti
- Usa `LogActivityAction` per registrare eventi critici (modello `Activity`).
- Usa progetti con `status` calcolato (`active`, `paused`, `completed`).

## Test
- Implementa test di integrazione per flussi di lavoro complessi.
- Copri casi limite come transizioni di stato non valide.

## Documentazione
- Aggiorna `docs/00-index.md` con nuovi modelli e relazioni.
- Collega a `Projects` e `Tasks` per contesto operativo.
<<<<<<< .merge_file_5jewXC
=======
=======
>>>>>>> 35d8cf69 (Initial commit)
---
module: theme
topic: best-practices
canonical: ../../../Themes/docs/shared-components/BEST_PRACTICES.md
---

See canonical documentation: ../../../Themes/docs/shared-components/BEST_PRACTICES.md
<<<<<<< HEAD
>>>>>>> 0a02158a (.)
=======
>>>>>>> 35d8cf69 (Initial commit)
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_HM2FiY
