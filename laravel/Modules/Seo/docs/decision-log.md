---
type: decision-log
title: "Decision Log — Seo"
links: {github_issue: "#XXX", discussion: "#XXX"}
updated: 2026-10-07
tags: [docs, seo]
qmd: "decision log seo seo"
status: draft
---

> Nota 2026-10-08 (docs-audit): e' il template vuoto (Decisions / Open Questions senza voci). Contenuto non riscritto, verificare prima di usarlo.
# Decision Log — Seo

## Decisions
## Open Questions


## 2026-10-26 — Sitemap completeness + Folio generic blade ownership

**Decisione**: il generico `[container0]/[slug0]/index.blade.php` in `Themes/Sixteen` serve TUTTI i dettagli (blog, events, tickets, profile). I moduli NON possiedono blade proprie; forniscono solo modelli e azioni di risoluzione.

**Perché**:
- Il tema Sixteen è proprietario della pagina shell Folio
- `ResolvePageAction` risolve dinamicamente via `container0_model_map`
- `SitemapPathsContract` + tag (`seo.sitemap.paths`) è il contratto per i dettagli

**Artefatti creati**:
- `Modules/Seo/docs/wiki/concepts/sitemap-coverage-contract.md`
- `Modules/Seo/docs/bmad/brainstorming/sitemap-folio-routing-completeness.md`
- `Modules/Seo/docs/bmad/architecture-sitemap-completeness.md`
- `Modules/Seo/docs/bmad/planning/sitemap-completeness-plan.md`
- `Modules/Seo/docs/stories/dcp-274-sitemap-completeness-verification.story.md`
- `Modules/Fixcity/docs/wiki/concepts/sitemap-ticket-folio-routing.md`
- `Modules/Blog/docs/wiki/concepts/sitemap-blog-folio-routing.md`
- `Modules/Fixcity/docs/sitemap.md`
- `Modules/Blog/docs/sitemap.md`
- `Themes/Sixteen/docs/wiki/concepts/folio-generic-blade-ownership.md`

**Impatto**: se `/it/tickets/35` manca dalla sitemap, la causa è dati (status/location) o runtime (module loader), non codice.
