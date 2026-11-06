---
title: "Struttura dei metodi del modello Log"
type: architecture
module: Xot
status: active
created: 2026-11-05
updated: 2026-11-05
tags: [xot, eloquent, model, traits, architecture]
qmd: "Xot Log model file content accessor helper trait HasExtraTrait relationship methods"
related:
  - ../index.md
---

# Struttura dei metodi del modello Log

`Log` espone il contenuto del file di log come attributo Eloquent e mantiene
calcolo e delega nello stesso trait.

| Trait | Modello e metodi |
|---|---|
| [LogMutators](../../../app/Models/Traits/LogMutators.php) | `Log`: `getFileContentAttribute`/`getFileContent` |
| [HasExtraTrait](../../../app/Models/Traits/HasExtraTrait.php) | Trait relazionale già esistente: relazione `extra` e accesso agli extra schemaless |

Il resto di `Log` conserva le operazioni di elenco e serializzazione proprie del
modello.
