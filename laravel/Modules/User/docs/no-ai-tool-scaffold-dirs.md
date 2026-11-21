---
title: "No AI/tool scaffold directories in module tree — User"
module: "User"
type: concept
tags: [hygiene, gitignore, ai-scaffold, module-root]
created: 2026-07-16
updated: 2026-07-16
related:
  - "../../../../docs/wiki/rules/module-theme-root-cleanup.md"
---

# Perché queste cartelle non devono esistere qui

Estende la regola canonica [module-theme-root-cleanup.md — Rule 5](../../../../docs/wiki/rules/module-theme-root-cleanup.md).

## Rimosse in questo modulo (2026-07-16)

- `bashscripts/`, `scripts/ci/`, `.claude-audit/`, `test-results/` — scaffold di
  agenti/CI, copie locali di automazione già presente alla root del monorepo.
- `docs/scripts/` e le archivi/legacy annidate: `docs/{bug-fixes,performance,bugs,
  console_commands,filament,fixes,_integration}/{archive,legacy}` e `docs/roadmap/legacy`.

Le archivi contenevano duplicati (coppie `nome.md` + `nome-archive-1.md`/`nome-.md`) di
documentazione già viva nella cartella genitore. Nessun contenuto unico da migrare.

Pattern consolidati nel `.gitignore` del modulo, incluse le varianti annidate
`docs/**/archive/`, `docs/**/legacy/` ecc.

## Perché ricompaiono — le quattro cause

1. **Default dei tool AI**: la versione vecchia di un doc finisce in una `archive/` accanto
   invece di essere cancellata (la storia è già in Git).
2. **Scratch space degli agenti**: `.claude-audit/`, `_bmad-output/`, `test-results/`,
   `bashscripts/` sono cache/scaffold scritti nella root che l'agente vede.
3. **Template CI copia-incolla**: `scripts/ci/`, `.circleci/`.
4. **Leakage dell'IDE**: `.vscode/`, `.cursor/`, `.devcontainer/`.

Causa strutturale: il modulo vive anche come **repo Git indipendente** (multi-repo); ogni
tool che gira in quella root ignora che è un sotto-albero del monorepo con le sue
convenzioni.

## Zen

Una sola fonte di verità per categoria: `docs/` per la conoscenza (mai `archive/`/`legacy/`
parallele), la root `bashscripts/` del monorepo per l'automazione, `build/` per gli
artefatti. Ogni duplicato è un secondo posto dove rispondere alla stessa domanda ("qual è
la versione giusta?") — entropia, non struttura. Boy scout rule: cancella **e** aggiorna il
`.gitignore` deduplicando, così il tool smette di rigenerarli nel tracking.
