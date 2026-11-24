---
title: "ADR — La sitemap la costruisce solo Seo; i moduli le danno i percorsi con un contratto taggato"
type: decision
status: accepted
module: Seo
tags: [adr, seo, sitemap, contracts, container-tag, dipendenze]
created: 2026-11-24
updated: 2026-11-24
related:
  - ../../app/Contracts/SitemapPathsContract.php
  - ../../app/Contracts/SitemapLastModifiedContract.php
  - ../../app/Actions/Sitemap/BuildSitemapAction.php
  - ../../tests/Unit/Architecture/SitemapOwnershipTest.php
---

# ADR: la sitemap la costruisce solo Seo, i moduli le passano i percorsi con un contratto taggato

## Contesto

- `/sitemap.xml` deve elencare le pagine CMS e anche le pagine di dettaglio che appartengono ad altri moduli (articoli
  del Blog, segnalazioni, eventi), in tutte le lingue, con gli hreflang.
- Errori già commessi e ricordati in `tests/Unit/Architecture/SitemapOwnershipTest.php`: la classe che costruisce la
  sitemap messa nel modulo del progetto ospite, e una bozza di sitemap in Seo che importava i modelli di Blog per
  elencare gli articoli.
- Seo è un modulo condiviso: se importa i modelli dei moduli che lo usano, ogni progetto si porta dietro moduli che non ha.

Domanda: come fa la sitemap a contenere le pagine di altri moduli senza che Seo li conosca?

## Decisione

- Solo Seo costruisce la sitemap: `app/Actions/Sitemap/BuildSitemapAction.php`, rotta `seo.sitemap` in `routes/web.php`.
- Un modulo che ha URL di dettaglio implementa `Modules\Seo\Contracts\SitemapPathsContract` (percorsi senza lingua) e,
  se ha date vere, `SitemapLastModifiedContract`; si registra nel **proprio** service provider con il tag
  `SitemapPathsContract::TAG` (esempio: `Modules/Blog/app/Providers/BlogServiceProvider.php`).
- Seo può importare solo `Modules\Seo`, `Modules\Xot`, `Modules\Cms` (`SEO_ALLOWED_MODULES` nel test). Allungare la
  lista è una decisione di architettura, non una comodità.
- La stessa sorgente serve anche `seo:indexnow`, che legge la sitemap per sapere quali URL inviare.

## Alternative scartate

- Seo che interroga i modelli dei moduli (Blog, segnalazioni): dipendenza al contrario, Seo non installabile senza di loro.
- Sitemap scritta dal modulo del progetto ospite: ogni progetto la riscrive e la regola `noindex` del `<head>` (Cms
  `ResolveRobotsPolicyAction`) non viene applicata in modo uniforme.
- Configurazione con l'elenco delle classi sorgente: un modulo disattivato lascerebbe una classe inesistente in config;
  con il tag, il modulo che non c'è semplicemente non si registra.
- `spatie/laravel-sitemap` con crawler: scansiona il sito in produzione e trova anche pagine che non vanno indicizzate.

## Conseguenze

- Pro: un modulo nuovo entra in sitemap (e in IndexNow) implementando un'interfaccia, senza toccare Seo.
- Contro: un modulo che si dimentica il tag non compare in sitemap, senza errori.
- `<lastmod>` viene da due fonti: stringa `Y-m-d` per le pagine CMS (`lastModified()` della pagina), `DateTimeInterface`
  dalle sorgenti che implementano `SitemapLastModifiedContract` (formattata ATOM). Una sorgente senza data vera non la
  inventa: niente `<lastmod>`.

## Verifica

- `cd laravel && vendor/bin/pest Modules/Seo/tests/Unit/Architecture/SitemapOwnershipTest.php`: fallisce se una classe
  fuori da Seo usa `Spatie\Sitemap` o dichiara `BuildSitemapAction`, o se `Modules/Seo/app` importa un modulo diverso da
  Seo, Xot, Cms.
- `vendor/bin/pest Modules/Seo/tests/Feature/IndexNow/IndexNowTest.php` (test «resends a sitemap url only when its
  lastmod is newer…») registra una sorgente di prova con il tag e ne legge i percorsi e le date.
