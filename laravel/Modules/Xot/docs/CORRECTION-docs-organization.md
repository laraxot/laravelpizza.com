---
title: "Correction: docs organization: INDEX.md condiviso e correzione Ticket"
status: correction
scope: [laravel/Modules/docs, laravel/Themes/docs, laravel/Modules/Ticket/docs]
updated: 2026-10-20
reference: Modules/Xot/docs/conventions/docs-organization.md
type: note
tags: [docs, xot]
qmd: "correzione   docs organization xot"
---

# Correzione: docs organization

Cosa diceva la memoria / stato precedente: `Modules/docs/` e `Themes/docs/` non avevano `INDEX.md`; i moduli avevano solo `INDEX.md` locale senza riferimento alla convenzione transversale (`docs-organization.md`) ni all'indice prompt (`bashscripts/docs/prompts/INDEX.md`). Il gap del widget commenti Ticket era solo annotato come ❌ senza traccia di correzione documentata.

Cosa è vero ora:
- `laravel/Modules/docs/INDEX.md` creato (riferimento a `Xot/docs/conventions/docs-organization.md`, `README.md`, `testing-convention.md`);
- `laravel/Themes/docs/INDEX.md` creato (riferimento ai temi attivi, convenzione docs, prompt index);
- `laravel/Modules/Ticket/docs/INDEX.md` aggiornato: aggiunto blocco "Correzioni documentate" che registra il gap widget commenti (non in bmad-output/); riferimento a `../../docs/INDEX.md`; aggiornato `stato`.

Evidenza: file creati/aggiornati elencati nel report subagent; `.gitignore` di `graphify-out/` confermato (non versionato, rigenerabile).

Riferimenti integri:
- Convenzione: [`docs-organization.md`](conventions/docs-organization.md)
- Prompt docs index: [`bashscripts/docs/prompts/INDEX.md`](../../../bashscripts/docs/prompts/INDEX.md)
- Second brain ciclo: [`bashscripts/docs/prompts/57-second-brain.md`](../../../bashscripts/docs/prompts/57-second-brain.md)
