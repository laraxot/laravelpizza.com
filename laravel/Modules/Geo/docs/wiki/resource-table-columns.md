---
title: "resource table columns"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "resource table columns"
issues: []
discussions: []
---

# Colonne delle Resource — verifica 2026-09-10

## Evidenze e decisioni

Address: route, street_number, locality, administrative_area_level_3/2, postal_code, type e is_primary sono confermati dalla migrazione 2025_05_28_000001. Location: city, street, zip e processed dalla migrazione 2022_11_02_044205. Indicatori booleani con IconColumn; coordinate opzionali.

## Contratto e verifica

Ogni getTableColumns restituisce array<string, Column>. Le colonne primarie supportano lettura e ricerca; metadati tecnici restano selezionabili. Nessun campo aggiunto senza evidenza nel modello e nello schema/produttore Sushi. QMD search tentato prima delle modifiche: indisponibile per incompatibilità ABI better-sqlite3 (127/147); consultati direttamente sorgenti e documentazione.
