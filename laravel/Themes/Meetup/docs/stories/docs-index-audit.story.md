---
title: "Docs index audit — tema Meetup"
type: story
theme: Meetup
status: done
updated: 2026-09-03
---

# Docs index audit — tema Meetup

Fase BMAD: implementazione documentale (docs-only), nessun codice applicativo toccato.

- Audit di tutti i 28 file `.md` sotto `Themes/Meetup/docs/` (find ricorsivo), nessun file esistente rinominato/cancellato.
- Creato `docs/index.md`: indice per argomento (overview, concetti, wiki on-demand, template, qualita'/audit, LLM wiki, raw, storico).
- Individuati 8 file duplicati/stub con canonical dangling, raggruppati in "Storico / da consolidare" senza cancellarli: `code-quality-report.md`, `REDUNDANCY_ANALYSIS.md`, `codex-error-fix.md`, `merge-conflicts-list.md`, `ON-DEMAND-PATTERN.md`, `PERFORMANCE-OPTIMIZATION.md`, `PROJECT-STRUCTURE.md`, `QMD-SETUP.md`.
- Verifica reale: contenuto di `docs/index.md` copre tutti i file trovati da `find docs -type f`; nessun link rotto verso file interni al tema.
