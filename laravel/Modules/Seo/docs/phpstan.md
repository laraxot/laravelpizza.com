---
title: "phpstan"
type: note
tags: [seo, phpstan, quality]
updated: 2026-11-17
qmd: "seo phpstan level max pest assert sitemap"
module: Seo
status: active
---

# PHPStan — Modulo Seo

Gate: **0 errori** a `level: max` (wave 111 → 0).

Scopo del modulo sotto analisi: URL canoniche, alias di pagina, sitemap pubblica e share social — senza conoscere i modelli dei moduli consumer (`SitemapPathsContract`).

Dettaglio cause e fix: [wiki/concepts/phpstan-compliance.md](wiki/concepts/phpstan-compliance.md).

Pattern test: Pest resta Pest; asserzioni con `PHPUnit\Framework\Assert` (no `expect()` fluente) perche' `Pest\Mixins\Expectation` e' `@internal`.
