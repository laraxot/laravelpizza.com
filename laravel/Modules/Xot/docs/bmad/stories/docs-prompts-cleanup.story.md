---
title: "Cleanup duplicati docs e prompts"
type: story
status: draft
qmd: "docs-prompts-cleanup"
---

# Epic
Cleanup ridondanza docs e prompt — PTVX

# Acceptance Criteria
- Rimosse 4 copie duplicate/near-duplicate in bashscripts/docs/prompts/ (04b-controller-to-folio-actions.md, 28-livewire-to-filament-widgets.md, 29-testing-standards.md, 27-confidence-bootstrap.md)
- Rimosse 4 cartelle annidate duplicate (User/docs/docs, User/docs/_archive/docs, Job/docs/build_local/docs, Job/docs/wiki/build_local/docs)
- Rimosse copie .bak in User/docs/
- Nessun riferimento attivo rotto (verificato con rg prima della rimozione)
- PHPStan level max su Modules/ resta a 0 errori

# Tasks
1. Verifica riferimenti con rg per ogni file candidato (fatto via subagent)
2. Cancella 4 file duplicati in bashscripts/docs/prompts/
3. Rimuovi 4 cartelle annidate duplicate
4. Rimuovi file *.bak in User/docs/
5. Scrivi questa story BMAD
6. Esegui qmd update
7. Esegui PHPStan gate su Modules/

# References
- docs/task-summary.md (sezioni 1-5)
- Rapporti verifica subagent (prompts + module docs)
- Regole: no-date-nel-nome, zero-ridondanza, nessun-commit-senza-richiesta
