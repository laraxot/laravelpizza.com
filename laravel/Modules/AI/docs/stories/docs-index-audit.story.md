---
tags: [documentation]
updated: 2026-09-26
qmd: "docs index audit.story"
issues: []
discussions: []
title: "Docs index audit - AI module"
status: done
type: story
created: 2026-09-03
---

# Docs index audit - AI module

**Trovato**: `Modules/AI/docs/` conteneva 180 file `.md` senza un indice affidabile. Esistevano tre tentativi di indice (`00-index.md`, `INDEX.md`, `index.md` vuoto), con `00-index.md` che linkava a file maiuscoli inesistenti (es. `PRD.md`) mentre i file reali sono minuscoli (`prd.md`). Individuati cluster di duplicati: 35 file in `mcp/` (numerati, non numerati, stub underscore verso `Themes/docs/shared-components/`), 9 stub `module: theme` sparsi in root e `tutorials/`, 5 boilerplate prodotto mai popolati (`product_*.md`), oltre a coppie identiche o superate (`phpstan-remediation*.md`, `structure.md`/`project-structure.md`, `wiki/agents.md`/`llm-wiki/agents.md`).

**Fatto**: riscritto `Modules/AI/docs/index.md` come indice unico organizzato per argomento (13 sezioni tematiche + wiki + storico), con link relativi verificati verso tutti i 180 file `.md` della cartella (nessuno rinominato o cancellato). I duplicati/stub/superati sono raggruppati in una sezione "Storico / da consolidare" con nota sul perche' di ciascun cluster, cosi' da restare visibili senza toccare i file. `00-index.md` e `INDEX.md` non sono stati modificati, solo segnalati come superati.

**Resta da fare**: eventuale consolidamento fisico dei cluster segnalati (in particolare `mcp/` triplicato e i boilerplate prodotto) va deciso e schedulato a parte, non e' stato eseguito qui perche' fuori scope (solo indice, nessuna modifica/cancellazione di doc esistenti). Verificare se le liste di conflitti (`merge-conflict-files-list.md`, `merge-conflicts-list.md`) sono ormai storiche e possono essere archiviate.
