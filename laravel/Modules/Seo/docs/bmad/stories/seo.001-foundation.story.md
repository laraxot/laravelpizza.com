---
title: "Seo — Fondazione BMAD + metatag completo"
id: "seo.001-foundation"
module: Seo
type: story
status: todo
priority: high
created: 2026-11-04
---

# Seo.001 — Fondazione BMAD

## Contesto

Il modulo Seo ha test presenti (MetatagFacadeAdapterTest, CanonicalPathRedirectTest,
SitemapDetailTemplatesTest, SocialShareWidgetTest, ecc.) ma zero stories BMAD.
L'architettura è parzialmente definita in `docs/bmad/`.

## Obiettivo

Creare le stories fondamentali per portare Seo a completamento.

## Acceptance criteria

- [ ] `docs/bmad/prd.md` creato (se non presente)
- [ ] PHPStan zero errori su `Modules/Seo`
- [ ] `MetatagData` e `MetatagFacadeAdapter` documentati in wiki
- [ ] Coverage Pest ≥ 70%
- [ ] Tutti i test esistenti passano green

## Note tecniche

- Seguire architettura `docs/bmad/architecture-sitemap-ownership.md` esistente
- Non duplicare scope Cms
