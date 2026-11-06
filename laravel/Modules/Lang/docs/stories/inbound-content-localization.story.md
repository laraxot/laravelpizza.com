---
id: IM-LANG-001
title: "Localizzazione editoriale e URL canonici"
type: story
module: Lang
epic: "I Governance editoriale"
status: backlog
priority: P1
owner: module:Lang
scope: "laravel/Modules/Lang/docs/"
created: 2026-10-15
updated: 2026-10-15
tags: [bmad, localization, accessibility, seo]
qmd: "blog event locale translation localized URL canonical"
related: [IM-BLOG-002, IM-SEO-001, IM-SIXTEEN-001]
issues: []
discussions: []
---
# Localizzazione editoriale e URL canonici

## Richiesta / scopo
Come persona che usa una lingua supportata voglio contenuto, date, CTA e URL coerenti, senza chiavi grezze o redirect inventati.

## Acceptance Criteria
- [ ] Lingua, alternate/canonical e route usano i meccanismi Laravel esistenti.
- [ ] Fallback è esplicito e non mischia contenuti non tradotti senza indicazione.
- [ ] Date e timezone sono formattate nella locale corretta.
- [ ] Header/footer JSON e contenuti Blog seguono lo stesso contratto.

## Tasks / Subtasks
- [ ] Mappare helper di localizzazione già presenti.
- [ ] Documentare fallback e contenuto mancante.
- [ ] Testare IT/EN e una locale aggiuntiva supportata.

## Owned File / Module Scope
Docs Lang e integrazioni soltanto quando le story owner sono ready.

## Testing / Verifica
Route/link check localizzato e test di fallback.

## Dipendenze
IM-BLOG-002, IM-SEO-001.
