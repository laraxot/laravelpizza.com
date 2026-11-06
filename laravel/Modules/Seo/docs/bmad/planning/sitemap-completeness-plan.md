---
title: "BMAD Planning — Sitemap completeness (DCP-166 + DCP-273)"
type: planning
status: active
tags: [seo, sitemap, planning, dcp-166, dcp-273]
created: 2026-10-26
updated: 2026-10-26
qmd: "planning seo"
---

# Planning

## Obiettivo
Assicurare che `sitemap.xml` contenga tutte le pagine pubbliche: CMS, blog (`/it/blog/{slug}`), eventi (`/it/events/{slug}`), ticket (`/it/tickets/{id}`). Se un URL manca, la causa deve essere verificabile (data o runtime), non un bug dell'architettura.

## Fasi

1. **Verifica dati** (nessun codice da cambiare, solo ispezione)
   - `php artisan tinker`: `Ticket::find(35)->location`, `status->value`
   - `ThemeArticleQueries::publishedPostSlugs()` → verifica output
2. **Verifica tag** (codice già corretto, ma da documentare)
   - `BlogServiceProvider::register()` e `FixcityServiceProvider::register()` → tag OK
3. **Documentazione** (fatto: docs sopra)
4. **Test** (esistente: `SeoLinksTest.php` — verificare che passa con dati pubblici)
