---
title: "Sitemap completeness — final verification summary"
type: concept
status: active
tags: [seo, sitemap, verification, dcp-166, dcp-273, dcp-274]
created: 2026-10-26
updated: 2026-10-26
---

# Sitemap completeness — final verification

## What was fixed
1. ✅ Sitemap includes blog detail URLs (`/it/blog/{slug}`) — via `ListPublishedArticlePathsAction`
2. ✅ Sitemap includes ticket detail URLs (`/it/tickets/{id}`) — via `ListPublicTicketPathsAction`
3. ✅ All sitemap sources tagged with `SitemapPathsContract::TAG` (Blog + Fixcity)
4. ✅ Folio generic blade `[container0]/[slug0]/index.blade.php` serves all detail pages
5. ✅ Blog sitemap source registered in `BlogServiceProvider::register()`
6. ✅ Fixcity sitemap source registered in `FixcityServiceProvider::register()`

## What's still missing (data-level, not code-level)

| URL | Status | Reason |
|-----|--------|--------|
| `/it/blog/una-segnalazione-utile-inizia-da-tre-informazioni` | ❌ missing | Article not published / not yet created in dev DB |
| `/it/tickets/35` | ❌ missing | Ticket not public (status not in `canViewByAll()` or `location=null`) |
| `/it/ricerca?q=test` | ❌ missing | No Folio page for `/it/ricerca` — header form posts to a 404 |
| `/it/search` | ❌ missing | No search result page exists (404) |

## Documentation created
- `Modules/Seo/docs/wiki/concepts/sitemap-coverage-contract.md`
- `Modules/Seo/docs/bmad/architecture-sitemap-completeness.md`
- `Modules/Seo/docs/bmad/planning/sitemap-completeness-plan.md`
- `Modules/Seo/docs/stories/dcp-274-sitemap-completeness-verification.story.md`
- `Modules/Fixcity/docs/wiki/concepts/sitemap-ticket-folio-routing.md`
- `Modules/Blog/docs/wiki/concepts/sitemap-blog-folio-routing.md`
- `Modules/Seo/docs/bmad/architecture-sitemap-ownership.md`
- `Themes/Sixteen/docs/wiki/concepts/folio-generic-blade-ownership.md`
- `Modules/Seo/docs/decision-log.md` (updated 2026-10-26)

## Next steps
1. Create test data: ticket 35 (public status + location), blog article (published)
2. Fix search route — create `/it/ricerca` Folio page
3. Update `SeoLinksTest.php` to pass with current data

## Verification status (2026-10-26)
- `BuildSitemapAction` reads tagged sources correctly ✓
- `BlogServiceProvider` + `FixcityServiceProvider` tag sources correctly ✓
- `ThemeArticleQueries` returns published posts/events ✓
- `BuildPublicTicketsQueryAction` returns valid Builder for public tickets ✓
- `ResolvePageAction` resolves ticket detail via `BuildPublicTicketDetailAction` ✓
- `SeoLinksTest` fails (404) — needs data for verification
EOF
echo "Verification summary doc OK"