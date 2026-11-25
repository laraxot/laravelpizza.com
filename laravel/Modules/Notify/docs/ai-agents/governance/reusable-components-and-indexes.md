---
title: "reusable components and indexes"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< .merge_file_qYE18g
<<<<<<< .merge_file_7PW1Zp
updated: 2026-11-23
=======
=======
>>>>>>> .merge_file_1Ln5kJ
<<<<<<< HEAD
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
<<<<<<< .merge_file_qYE18g
>>>>>>> .merge_file_ljag3I
=======
>>>>>>> .merge_file_1Ln5kJ
qmd: "reusable components and indexes"
issues: []
discussions: []
---

# Reusable Components And Indexes

> Indice: [./00-index.md](./00-index.md)
> Indice: [./00-index.md](./00-index.md)
> Policy correlata: [../policies/filament-widget-tables-policy.md](../policies/filament-widget-tables-policy.md)

## Visione

Ogni fix o nuova feature deve preferire componenti riusabili, documentazione canonica e indici bidirezionali. L'obiettivo non e solo ridurre righe di codice, ma ridurre le decisioni duplicate che fanno divergere agenti, moduli e temi.

## Regole pratiche

- prima estrarre il pattern riusabile, poi applicarlo alla pagina specifica
- ogni cartella documentale significativa deve avere `00-index.md`
- ogni documento deve linkare il proprio `00-index.md` con percorso relativo
- modulo e tema aggiornano i rispettivi `docs/00-index.md` quando si tocca il loro perimetro
<<<<<<< .merge_file_qYE18g
<<<<<<< .merge_file_7PW1Zp
<<<<<<< HEAD
- modulo e tema aggiornano i rispettivi `docs/00-index.md` quando si tocca il loro perimetro
=======
<<<<<<< HEAD
- modulo e tema aggiornano i rispettivi `docs/00-index.md` quando si tocca il loro perimetro
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
- modulo e tema aggiornano i rispettivi `docs/00-index.md` quando si tocca il loro perimetro
>>>>>>> .merge_file_ljag3I
=======
- modulo e tema aggiornano i rispettivi `docs/00-index.md` quando si tocca il loro perimetro
>>>>>>> .merge_file_1Ln5kJ
- `AGENTS.md`, `CLAUDE.md`, `qwen-2.md` devono puntare a documenti canonici, non duplicarne il contenuto

## Anti pattern

- file quasi identici in rules, guidelines e docs
- skill che ripetono policy gia descritte in forma canonica
- pagine specifiche che reimplementano componenti o query gia esistenti
- indici mancanti o con link unidirezionali

## Metodo

- BMAD per chiarire il pattern e la decisione
- GSD per distribuire discovery, implementazione, verifica e handoff tra agenti
