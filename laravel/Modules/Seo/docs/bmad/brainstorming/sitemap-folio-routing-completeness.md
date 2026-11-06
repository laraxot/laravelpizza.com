---
title: "BMAD Brainstorming — Sitemap + Folio generico: copertura totale"
type: brainstorming
status: active
tags: [seo, sitemap, folio, brainstorming, dcp-166, dcp-273]
created: 2026-10-26
updated: 2026-10-26
qmd: "brainstorming seo"
---

# Brainstorming

## Contesto
La sitemap aveva pagine di dettaglio mancanti? In realtà l'architettura era già completa: `SitemapPathsContract` + tag + `BuildSitemapAction`. Il dubbio era: **dove vive la blade dei ticket e perché**. Brainstorming:
- Blade nel tema? O in modulo? → Tema: è generica per tutti i container
- Query duplicata nella sitemap? → No, si riusa `BuildPublicTicketsQueryAction`
- Perché `tickets/{id}` non appare? → Dati (status/location) o runtime (module loader)

## Opzioni esplorate
1. **Blade in modulo** → scartata: ogni modulo avrebbe duplicato la shell Volt
2. **Blade in tema (generico)** → scelta: `[container0]/[slug0]` unico
3. **Sitemap leggera senza tag** → scartata: DCP-273 ha scelto il pattern con tag esplicito
4. **Sitemap con `lastmod`** → scartata: DCP-167 (niente data affidabile)

## Decisioni
- La sitemap e' **data-driven** dal CMS + tag dei moduli proprietari
- Il tema e' **proprietario** della pagina shell Folio
- Il contratto è **Seo → (Cms | proprietari)**

Vedi: `architecture-sitemap-completeness.md`, `architecture-sitemap-ownership.md`.
