---
title: "Documentation lifecycle"
type: rule
status: active
updated: 2026-10-13
tags: [documentation, lifecycle, bmad, second-brain]
qmd: "documentation lifecycle draft active stale superseded archive"
---

# Ciclo di vita

`draft` → `active` → `stale` → `superseded` → `archive`.

- `draft`: non usare per decisioni;
- `active`: fonte corrente, verificata dal codice o da una decisione;
- `stale`: utile ma richiede revisione, con motivo e data;
- `superseded`: mantenuto per riferimento, con link al sostituto;
- `archive`: materiale storico o raw, non indicizzato come regola.

La documentazione non si aggiorna con claim retroattivi: si aggiunge una nota
datata e si collega la nuova evidence. I log e le decisioni sono append-only.
Prima di spostare o cancellare un file: `rg` sui riferimenti, controllo degli
agenti/lock, aggiornamento dell'indice e verifica dei link.
