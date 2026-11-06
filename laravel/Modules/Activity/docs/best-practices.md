---
title: "Best Practices – Activity"
type: note
status: draft
updated: 2026-10-08
tags: [docs, activity]
qmd: "best practices   activity activity"
---
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
