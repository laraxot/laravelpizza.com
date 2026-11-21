---
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "no ai tool scaffold dirs"
issues: []
discussions: []
title: No AI/tool scaffold directories in module tree
---

# Perché queste cartelle non devono esistere qui

Regola canonica: [module-theme-root-cleanup.md — Rule 5](../../../../docs/wiki/rules/module-theme-root-cleanup.md).

Rimosse in questo modulo: `_docs/`, `scripts/`, `bashscripts/`, `docs/archive|archived|legacy|workbench/`, `.circleci/`, `.claude-audit/`, `tests/.claude-audit/`, `_bmad-output/`, `test-results/`, `.devcontainer/`, `.kilocode/`, `.kiro/`, `.ralph/` (dove presenti) e aggiunte al `.gitignore` di questo modulo.

**Perché**: questo modulo vive anche come repo Git indipendente (multi-repo); ogni agente/tool AI o pipeline CI che gira in quella root scrive lì la propria cache/scaffold locale (skill `.kiro/`, output `_bmad-output/`, stato `.ralph/`, audit `.claude-audit/`, log `test-results/`), ignorando che quella root è in realtà un sotto-albero del monorepo con le proprie convenzioni: `docs/` unica per la conoscenza riusabile, `bashscripts/` unica alla root del monorepo, `build/` unico per gli artefatti generati. Un secondo posto per la stessa categoria di contenuto è entropia, non struttura — se il tool lo rigenera, il `.gitignore` aggiornato lo tiene fuori dal tracking invece di doverlo ripulire ogni sessione.
