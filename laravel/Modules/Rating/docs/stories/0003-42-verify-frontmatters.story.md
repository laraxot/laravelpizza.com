---
issues: []
discussions: []
id: rating-story-01-42-verify-frontmatters
slug: 01-42-verify-frontmatters
title: "Verifica frontmatters: tutte le story BMAD hanno GitHub links corretti"
description: "Verificare che tutte le story BMAD (rating-contract-usage, get-ratings-form-schema, etc.) abbiano i campi corretti: gh_issue, gh_discussion, repository, related_repo_remote. Aggiornare quelle incomplete o errate."
type: story
document_type: story
category: quality
status: in-progress
version: 1.0.0
language: it-IT
module: Rating
epic: 1
story: 42
scope: module:Rating
audience: [ai-agents, developers]
tags: [frontmatter, verification, github-links, bmad]
created: 2026-09-09
updated: 2026-09-09
qmd: "Verifica frontmatters tutte le story BMAD GitHub links corretti"
repository: "provtv/module_rating_fila5"
gh_issue: "https://github.com/provtv/module_rating_fila5/issues/35"
gh_discussion: "https://github.com/provtv/module_rating_fila5/discussions/36"
related_repo_remote: "provtv/module_rating_fila5"
---
# Story 01.42: Verifica frontmatters: tutte le story BMAD hanno GitHub links corretti

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

## Obiettivo

Verificare che ogni story BMAD in `laravel/Modules/Rating/docs/stories/` abbia:
- `gh_issue` → link all'issue corretto su GitHub
- `gh_discussion` → link alla discussion corretto su GitHub
- `repository` → URL del repository del modulo
- `related_repo_remote` → nome del remote (es. `provtv/module_rating_fila5`)

## Stories da verificare

- [ ] `2.1.pest-contract-xotbasepest.story.md`
- [ ] `5.86.get-ratings-form-schema-trait-update.story.md`
- [ ] `5.87.rating-contract-usage.story.md`
- [ ] `5.94.readme-agnostico-e-guardia-che-cercava-il-placeholder.story.md`
- [ ] `5.91.rating-contract-usage.story.md` (eventuale duplicato)
- [ ] `01.40.select-per-rating-con-figli.story.md` (appena creata)
- [ ] `01.41.hasratings-trait-correction.story.md` (appena creata)
- [ ] `01.30.rating-readme-agnostic-zshrc.story.md` (appena creata)

## Procedure

1. Per ogni story: leggere il frontmatter e verificare che i campi siano completi.
2. Creare/aggiornare le issue/discussion su GitHub se mancanti.
3. Aggiornare il frontmatter con i link corretti.
4. Aggiornare `related_repo_remote` con il nome del remote corretto (eseguire `git remote -v`).

## GitHub (tracciamento)

- Repository: `https://github.com/provtv/module_rating_fila5`
- Issue: `https://github.com/provtv/module_rating_fila5/issues/35`
- Discussion: `https://github.com/provtv/module_rating_fila5/discussions/36`
- Remote Rating: `provtv/module_rating_fila5`

### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
