---
title: "01.Tenant phpstan fix.story"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-10-07
qmd: "01.Tenant phpstan fix.story"
issues: []
discussions: []
---

# BMAD Story - Tenant PHPStan Fix
Date: Sun Sep  6 04:36:00 PM CEST 2026
Status: Done — vedi `phpstan-tenant-fix.md` per il dettaglio completo (0 errori confermati
con cache pulita, 2026-09-06, sessione claude sonnet 5). Story superseded da quella, non
cancellata per non perdere la cronologia dello swarm.

## 2026-10-07 - `SushiConnectionByName` (`trait.unused`)

Il trait non era morto: mancava la riga `use SushiConnectionByName;` nei quattro trait `SushiToJson`, `SushiToJsons`, `SushiToCsv`, `SushiToPhpArray`. Ripristinata in avanti, 0 errori PHPStan sui file toccati. Scopo, causa radice, verifica e seguiti in `7.4.sushi-connection-by-name.story.md` (sezione 2026-10-07).
