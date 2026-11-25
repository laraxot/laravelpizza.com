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
---
title: "Best Practices – Activity"
type: note
status: draft
updated: 2026-10-08
tags: [docs, activity]
qmd: "best practices   activity activity"
---
See canonical documentation: best-practices-3.md

# Best Practices – Activity

## Principi DRY/KISS
- **DRY**: Centralizza la logica di orchestrazione in Actions (es. `LogActivityAction`), mai in Services (il modulo non ha `app/Services`).
- **KISS**: Usa ID semplici per identificatori esterni, non UUID complessi in interfacce.
- **Clean Code**: Etichette e colori stanno negli enum (`HasLabel`/`HasColor`, es. `LogLevelEnum`) con le traduzioni in `lang/`, non duplicati nelle viste.

## Componenti
- Usa `LogActivityAction` per registrare eventi critici (modello `Activity`).
- I modelli del modulo usano la connessione `activity`: vedi [ADR](adr/activity-models-on-dedicated-connection.md).

## Test
- Implementa test di integrazione per flussi di lavoro complessi.
- Copri casi limite come input non validi e file di log fuori da `storage/logs`.

## Documentazione
- Aggiorna `docs/00-index.md` con nuovi modelli e relazioni.
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
---
module: theme
topic: best-practices
canonical: ../../../Themes/docs/shared-components/best-practices-2.md
---

See canonical documentation: ../../../Themes/docs/shared-components/best-practices-2.md
See canonical documentation: best-practices-3.md
