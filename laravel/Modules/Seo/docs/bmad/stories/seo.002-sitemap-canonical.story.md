---
title: "Seo — Sitemap + canonical redirect + robots.txt per tenant"
id: "seo.002-sitemap-canonical"
module: Seo
type: story
status: todo
priority: high
created: 2026-11-04
---

# Seo.002 — Sitemap, canonical, robots.txt

## Contesto

I test di sitemap e canonical esistono ma alcune funzionalità non sono
complete. robots.txt non è gestito per tenant.

## Obiettivo

Completare sitemap automatica da CMS, canonical redirect e robots.txt per tenant.

## Acceptance criteria

- [ ] Sitemap generata automaticamente da pagine CMS (integrazione con modulo Cms)
- [ ] `RedirectToCanonicalPath` middleware completo e testato
- [ ] `RedirectToPageAlias` middleware completo e testato
- [ ] robots.txt dinamico per tenant (via config Tenant)
- [ ] PHPStan zero errori su tutti i file coinvolti
- [ ] Test verde per: `CanonicalPathRedirectTest`, `SitemapDetailTemplatesTest`

## Note tecniche

- Sitemap usa `spatie/laravel-sitemap`
- Canonical dipende da configurazione metatag per pagina
- robots.txt letto da `config/<SERVER_NAME>/seo.php` (pattern Tenant)
