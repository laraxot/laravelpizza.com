---
status: done
date: 2026-11-25
decision-makers:
  - Xot
title: "No docs archive folders — Git-only restore"
type: story
module: Xot
qmd: "story 0175 no docs archivio archive gitignore ADR 0041 pest"
related:
  - ../../adr/0041-no-docs-archive-folders.md
  - ../../../../../../docs/adr/0006-no-docs-archive-folders.md
  - ../../../../../../bashscripts/ai/wiki/memories/docs-second-brain.md
  - ../../../../../../.cursor/rules/no-docs-archive.mdc
---

# Story 0175 — No docs archive folders

## Context and Problem Statement

Cartelle `docs/archivio/`, `archive/`, `_archive/` (e simili) fungono da backup
parallelo a Git: secondo SSoT, tetto docs gonfiato, canone non curato. Come
vietarle senza perdere ripristinabilità?

## Decision Drivers

- Ordine utente: niente dump `.md` in cartelle archivio; ripristino = Git
- KISS/DRY + ceiling ≤100 `.md` per owner docs
- Enforcement meccanico (`.gitignore` + Pest)

## Considered Options

- Tenere archivio + stub — rifiutato (secondo SSoT)
- Quarantena fuori da `docs/` — rifiutato (ancora dump)
- **Vietare i nomi cartella sotto `docs/`; storia = Git** — scelto

## Decision Outcome

Chosen: ban di `archivio|archive|_archive|archived|historical|backup|backups`
sotto ogni `docs/` (moduli, temi, root). ADR Xot 0041, pointer root 0006,
rule Cursor, memoria second brain, blocco `.gitignore` su 21 root, Pest
`NoDocsArchiveFoldersTest`.

### Consequences

- Good: canone unico; restore via `git show` / `git checkout <rev> -- path`.
- Bad: gli agenti non possono più “parcheggiare” md (mitigato da ignore + test).

### Confirmation

- `find` su Modules/Themes/docs → 0 cartelle vietate
- Marker `Xot ADR 0041` in 21 `.gitignore`
- Pest `Modules/Xot/tests/Unit/Docs/NoDocsArchiveFoldersTest.php`: **2 passed** (8 assertions), exit 0
- Sprint `Xot/no-docs-archive-folders` → done
