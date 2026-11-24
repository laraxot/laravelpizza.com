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
