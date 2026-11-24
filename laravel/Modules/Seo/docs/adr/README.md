---
title: "ADR del modulo Seo"
type: index
tags: [adr, decisioni, seo]
created: 2026-11-18
updated: 2026-11-24
---

# ADR del modulo Seo

Il **perché** di come Seo rende il sito trovabile: sitemap e `robots.txt` dinamici, IndexNow, nessun file "per l'AI",
una sitemap che Seo costruisce senza conoscere i moduli che la alimentano, e due elenchi (`Disallow` e `noindex`) che
sembrano duplicati ma non vanno fusi.

Leggili prima di: aggiungere pagine di un modulo alla sitemap, toccare `robots.txt` o le regole `noindex`, aggiungere un
servizio verso i motori di ricerca, o importare un altro modulo da `Modules/Seo/app`.

Formato (cinque sezioni, `type: decision`, nome file senza date né numeri) e regole:
[action-behavioral-contract](../../../Xot/docs/rules/action-behavioral-contract.md).

## Indice

- [Presenza nei motori di ricerca](search-engine-presence.md) — sitemap dichiarata, IndexNow per le URL nuove, identità dell'entità, niente `llms.txt`.
- [La sitemap la costruisce solo Seo, alimentata da sorgenti taggate](sitemap-built-in-seo-fed-by-tagged-sources.md) — i moduli implementano `SitemapPathsContract` e si registrano col tag; Seo importa solo Xot e Cms.
- [robots.txt chiude solo aree già noindex nel head](robots-disallow-subset-of-head-noindex.md) — `PRIVATE_SEGMENTS` ⊆ `HIDDEN_SEGMENTS`, perché un `Disallow` nasconde il `noindex`.
