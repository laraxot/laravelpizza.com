---
title: "QMD and Graphify indexing"
type: rule
status: active
updated: 2026-10-13
tags: [qmd, graphify, documentation, search]
qmd: "QMD Graphify indexing markdown front matter canonical docs"
---

# QMD e Graphify

QMD deve indicizzare i documenti canonici e le story; Graphify deve visualizzare
link e ownership, non trasformare screenshot o dump HTML in regole.

Ogni documento nuovo usa un titolo descrittivo e parole chiave nel campo `qmd`.
I riferimenti preferiscono link relativi e identificativi stabili (`DCP-###`,
`FR-###`, `NFR-###`) invece di nomi temporali.

Prima di considerare l'indice sano:

- il target di ogni link dell'indice esiste;
- i documenti `raw/` e `screenshots/` sono esclusi o classificati evidence;
- i duplicati sono mappati, non indicizzati come decisioni concorrenti;
- la ricerca QMD restituisce il canonico e non soltanto un report storico.
