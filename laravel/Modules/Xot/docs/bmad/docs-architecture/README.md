---
title: "Documentation architecture"
type: architecture
status: active
updated: 2026-10-13
tags: [bmad, documentation, modules, themes, qmd, graphify, second-brain]
qmd: "FixCity documentation architecture modules themes BMAD QMD Graphify Second Brain"
---

# Documentation architecture

Questa è la fonte BMAD per organizzare la documentazione del monorepo FixCity.
Non sostituisce i documenti tecnici dei moduli o di Sixteen: definisce come
trovarli, quale documento è autorevole e come evitare nuova duplicazione.

## Obiettivo

- mantenere separati codice, decisioni, storie, verifiche ed evidenze;
- rendere ogni modulo e tema navigabile da `README.md` e `00-INDEX.md`;
- permettere a QMD e Graphify di indicizzare contenuto semanticamente utile;
- conservare in Second Brain soltanto decisioni e conoscenza durevole;
- non cancellare, rinominare o spostare materiale storico senza una mappa verificata.

## Ordine di lettura

1. questo README;
2. [taxonomy.md](taxonomy.md), [ownership.md](ownership.md) e
   [module-theme-docs-contract.md](module-theme-docs-contract.md);
3. l'indice `00-INDEX.md` del modulo o tema interessato;
4. la story BMAD e l'eventuale ADR/decision log;
5. report parity, screenshot e raw evidence solo per la verifica.

## Documenti correlati

- [project-documentation.md](../project-documentation.md): baseline brownfield;
- [decision-log.md](../decision-log.md): decisioni cross-project;
- [front-office-design-comuni/](../front-office-design-comuni/): piano Design Comuni;
- [migration-plan.md](migration-plan.md): consolidamento progressivo senza perdita.
