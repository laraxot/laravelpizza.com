---
title: "Struttura canonica della documentazione"
qmd: "xot governance docs structure md"
type: note
tags: [documentation]
---

# Struttura canonica della documentazione

Questo documento è il riferimento per la riorganizzazione delle docs di moduli,
temi e prompt.

## Regole

- `README.md` è l'unico ingresso attivo di un modulo o tema.
- `docs/bmad/` contiene stories, architecture, brainstorming ed epics BMAD del
  relativo owner.
- `docs/wiki/` contiene regole e conoscenza mantenuta; `wiki`, `llm-wiki` e
  `project_docs` storici non vanno duplicati: si collegano alla fonte canonica.
- `docs/_archive/` conserva materiale superato senza competere con la docs
  attiva.
- `docs/chat/`, `root-code-workspace-files/` e directory annidate accidentalmente
  non sono sedi canoniche.
- I nuovi file markdown usano nomi minuscoli kebab-case; restano maiuscoli solo
  `README.md` e `CHANGELOG.md`.

## Layout minimo

```text
docs/
├── README.md
├── bmad/
├── architecture/
├── wiki/
├── api/
├── schema/
├── design/
└── _archive/
```

La migrazione è incrementale e reversibile: prima si crea l'indice, poi si
classificano i duplicati, infine si spostano soltanto directory chiaramente
accidentali dopo verifica dei link.

