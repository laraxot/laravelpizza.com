---
id: IM-SEO-001
title: "Metadati e Schema.org per articoli ed eventi"
type: story
module: Seo
epic: "III Authoring Filament"
status: backlog
priority: P1
owner: module:Seo
scope: "laravel/Modules/Seo/docs/"
created: 2026-10-15
updated: 2026-10-15
tags: [bmad, seo, schema-org, accessibility]
qmd: "Article Event JSON-LD canonical metadata RSS SEO"
related: [IM-BLOG-002, IM-BLOG-003, IM-SIXTEEN-001]
issues: []
discussions: []
---
# Metadati e Schema.org per articoli ed eventi

## Richiesta / scopo
Come persona che cerca una guida o un evento voglio risultati coerenti, localizzati e non ingannevoli.

## Acceptance Criteria
- [ ] `Article` e `Event` JSON-LD derivano dai dati pubblicati del Blog.
- [ ] Date, luogo, stato, lingua, canonical e immagini rispettano i dati reali.
- [ ] Un contenuto non pubblicato non produce dati strutturati pubblici.
- [ ] RSS/sitemap sono inclusi solo se già supportati dal contratto Seo.

## Tasks / Subtasks
- [ ] Verificare helper/metadati Seo esistenti.
- [ ] Documentare mapping e casi mancanti.
- [ ] Aggiungere test di validità e locale quando ready.

## Owned File / Module Scope
Seo docs e implementazione Seo futura; nessuna logica tema.

## Testing / Verifica
JSON parse/schema validation, canonical/link locale e PHPStan.

## Dipendenze
IM-BLOG-002, IM-BLOG-003.
