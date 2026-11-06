---
title: "Documentation consolidation migration plan"
type: plan
status: active
updated: 2026-10-13
tags: [documentation, migration, deduplication, safety]
qmd: "documentation consolidation migration plan no deletion no rename"
---

# Piano di consolidamento

## Fase 1: attuata in questo ciclo

- definire tassonomia, ownership e ciclo di vita;
- adottare gli indici già presenti come ingressi, senza creare copie;
- collegare BMAD, moduli, temi, QMD e Second Brain;
- aggiornare la baseline brownfield.

## Fase 2: audit controllato

- inventariare per ogni docs root file, indici, link rotti, duplicati e lock;
- classificare `canonical`, `evidence`, `legacy`, `raw`;
- produrre una migration map per ogni rinomina proposta;
- correggere prima gli indici, poi i link.

## Fase 3: consolidamento

Solo con una story per perimetro: marcare i duplicati `superseded`, spostare
materiale in sottocartelle tematiche e aggiornare tutti i riferimenti. Nessuna
cancellazione massiva e nessun rename automatico.

## Gate

`git diff --check`, link check sugli indici, front matter check, Graphify/QMD
re-index e revisione della story. Il debito documentale non deve aumentare.
