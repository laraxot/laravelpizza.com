---
title: "schema"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "schema"
issues: []
discussions: []
status: active
---

# Seo Module — Wiki Schema

## Struttura wiki

```
docs/
  wiki/
    index.md       ← indice navigabile (obbligatorio)
    log.md         ← log operazioni (obbligatorio)
    schema.md      ← questo file
    concepts/      ← pattern e regole architetturali
    entities/      ← meta tags, sitemap, robots
```

## Regole ingest

- `docs/` = raw source layer (immutabile)
- `docs/wiki/` = compiled wiki layer (LLM aggiorna)
- Nuovi concetti → `concepts/<kebab-case>.md`

## QMD collection

```bash
qmd search "seo meta" -c mod-seo
```
