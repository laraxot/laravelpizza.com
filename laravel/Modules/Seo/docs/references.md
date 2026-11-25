---
title: "Seo: riferimenti esterni"
type: reference
status: active
module: Seo
tags: [seo, riferimenti, pacchetti]
qmd: "seo riferimenti esterni pacchetti laravel seo schema-org indexnow localization tutorial"
related:
  - ./architecture.md
---

# Riferimenti esterni

Pacchetti e letture consultati per le scelte del modulo. Nessuno e' una dipendenza di Seo, tranne dove indicato.

## Pacchetti SEO per Laravel valutati

- [artesaos/seotools](https://github.com/artesaos/seotools)
- [ralphjsmit/laravel-seo](https://github.com/ralphjsmit/laravel-seo) e il plugin Filament
  [ralphjsmit/laravel-filament-seo](https://github.com/ralphjsmit/laravel-filament-seo)
- [archtechx/laravel-seo](https://github.com/archtechx/laravel-seo), [helori/laravel-seo](https://github.com/helori/laravel-seo),
  [ARCANEDEV/LaravelSeo](https://github.com/ARCANEDEV/LaravelSeo), [digitaldreams/laravel-seo-tools](https://github.com/digitaldreams/laravel-seo-tools)
- [spatie/schema-org](https://github.com/spatie/schema-org): candidato naturale per il JSON-LD pianificato
  (vedi [roadmap.md](./roadmap.md)).
- [spatie/laravel-sitemap](https://github.com/spatie/laravel-sitemap): dichiarato in `composer.json`; la sitemap attuale
  e' costruita da `BuildSitemapAction`.
- Splade, titoli e meta: https://splade.dev/docs/title-meta
- Pacchetto IndexNow per Laravel (articolo): https://banatube.medium.com/supercharge-your-laravel-websites-seo-with-the-laravel-indexnow-package-fb48e9dd84de

## Letture

- Guide e consigli SEO per Laravel: https://laravelarticle.com/ultimate-laravel-seo-guide,
  https://bonnick.dev/posts/laravel-seo-tips, https://www.seomoves.co.uk/laravel-seo/
- SEO programmatico: https://larafast.com/blog/programmatic-seo-how-to-do-that-in-laravel
- Inertia e SEO: https://dev.to/hazzazbinfaiz/trick-to-make-laravel-inertia-seo-friendly-3h3j
- Localizzazione SEO-friendly: https://www.coine.it/web-developing/laravel-localization-seo-friendly/
- Fonti di protocollo usate dalle ADR: indexnow.org/documentation e la documentazione Google Search Central sulle
  funzioni AI di Search (vedi [adr/search-engine-presence.md](./adr/search-engine-presence.md)).
