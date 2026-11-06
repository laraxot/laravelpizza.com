---
title: "Xot - docs-consolidation-orphan-files.story.md"
module: Xot
bmad: true
status: in-progress
updated: 2026-10-23
tags: [docs, xot, bmad]
qmd: "docs consolidation   orphan files + structure normalization   2026-10-06 xot"
---

# Docs consolidation: orphan files + structure normalization: 2026-10-06

## Epic
Documentation organization + knowledge base maintainability.

## Story
Come team documentarista, vogliamo consolidare file .md orfani in Modules/*/docs/ (304 in Notify, 99 in IndennitaResponsabilita, 56 in Incentivi, etc.) e normalizzare la struttura docs in tutti i moduli (e temi), così che il knowledge base sia navigabile, ricercabile e ben organizzato.

## Acceptance criteria
- [ ] Audit completato: inventario files orfani per modulo (input: docs-audit-*.json)
- [ ] Consolidamento: ogni modulo ha max 5 files top-level (README.md, PURPOSE.md, INDEX.md, CHANGELOG.md, _module_<name>.code-workspace)
- [ ] Struttura standard: docs/bmad/ (stories, architecture), docs/wiki/ (concepts), docs/schema/ (database), docs/raw/ (scratch)
- [ ] Cartelle tool-specific empty → rimosse (cursor/, windsurf/, headroom/, .github/skills se empty)
- [ ] README.md ogni modulo specifica confini (cosa vive dove)
- [ ] Zero regressioni: git status clean, no data loss (file spostati, non cancellati)

## Dettagli lavoro

### Fase 1: Classificazione files orfani
Input: docs-audit-*.json (already generated, a9fbfbb202ff7709b subagent in-progress)
- Per ogni file orfano: categorizza (logic → bmad/, concept → wiki/, schema → schema/, scratch → raw/)
- Identifica duplicati (stesso contenuto, nomi diversi) → dedup + keep canonical

### Fase 2: Consolidamento per modulo
**Priorità**:
1. **Notify**: 304 orphan → highest priority
2. **IndennitaResponsabilita**: 99 orphan + duplicate cartelle (architecture/ + architecture-decisions/) → unisci
3. **Incentivi**: 56 orphan
4. **Job, Lang, Media**: 29-36 orphan
5. **Resto**: < 10 orphan

Per ogni modulo:
- [ ] Organizza files in cartelle appropriate (bmad/, wiki/, schema/, raw/)
- [ ] Crea/aggiorna docs/README.md (confini)
- [ ] Crea docs/wiki/index.md (navigation)
- [ ] Rimuovi tool-specific vuote

### Fase 3: Themes consolidamento
- [ ] Themes/One/Three/Zero: stessa struttura normale
- [ ] Consolidamento orphan files (se presenti)
- [ ] README.md + wiki/index.md

### Fase 4: Verifica finale
- [ ] git status clean (no untracked, no modifications se non intenzionali)
- [ ] Conta files consolidati per modulo (report)
- [ ] Verifica niente data loss (git history grep per file names)

## Referenze
- Docs audit: a9fbfbb202ff7709b subagent (in-progress, attesa notifica)
- Memoria pattern: [[docs-organizing-audit-pattern]] (se crei)
- Story correlata: phpstan-modules-swarm-random (Fase 2: docs organizing)

## Stato
⏳ IN_PROGRESS (Subagent a9fbfbb202ff7709b lanciato ma non ancora completato)

## Assegnazione
- Coordinatore iniziale: a9fbfbb202ff7709b (docs organizing subagent)
- Handoff: prossimo agente se blocchi o overlap con altri lavori

## Note
Questa è una story di **consolidamento**, non rewriting. Files spostati, non ricreati. Data integrity non negoziabile. Se un file ha contenuto spurio/duplicato, documentar motivo della dedup nella story.