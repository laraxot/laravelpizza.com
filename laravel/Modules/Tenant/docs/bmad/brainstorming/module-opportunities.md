---
title: "Tenant — brainstorming BMAD"
type: brainstorming
status: active
module: Tenant
created: 2026-09-28
updated: 2026-09-28
qmd: "Tenant brainstorming rischi opportunità domande aperte"
---
tags: [docs, tenant, bmad]
# Tenant — brainstorming

## Punto di partenza

Multi-tenancy e contesto organizzativo. L'inventario corrente misura 53 file applicativi e 50 file di test.

## Domande ad alto valore

- Quale problema utente risolve il modulo e quale comportamento è vincolante?
- Quali dati sono autorevoli e quali sono proiezioni o cache?
- Quali ruoli possono leggere, creare, modificare o approvare?
- Quale errore deve essere osservabile senza esporre dati sensibili?
- Quale parte è riusabile e quale è specifica del dominio PTVX?

## Ipotesi da validare

- Le Action sono il punto di orchestrazione del caso d'uso.
- Le Resource Filament sono adattatori, non il luogo della regola di business.
- I test esistenti sono evidenza parziale e vanno confrontati con i flussi esposti.

## Rischi

- Duplicazione tra moduli o tra Form/Table.
- Contratti impliciti nei modelli Eloquent.
- Drift tra documentazione, codice e story status.
- WIP concorrente e marker di merge che falsano i gate.

## Output atteso

Le risposte devono diventare story BMAD con acceptance criteria misurabili, riferimenti a file reali e gate di verifica.

