---
title: "Architettura del componente Head SEO"
type: concept
module: Cms
status: approved
created: 2026-10-30
updated: 2026-10-30
tags: [cms, seo, blade, architecture, schema-org, theme-two]
qmd: "cms seo head blade component theme two schema org laravel head"
related:
  - "./stories/seo-head-component.story.md"
  - "../../Seo/docs/wiki/concepts/metatag-data-contract.md"
---

# Architettura del componente Head SEO

> Il head è una responsabilità di composizione del layout; i valori SEO sono
> responsabilità del modulo Seo e dei resolver CMS che li alimentano.

## Confine

Il modulo Cms espone il componente class-based e la view che produce il markup
HTML. Il modulo Seo conserva il contratto `MetatagData` e le operazioni di merge/
replace; il runtime pubblico usa oggi il DTO condiviso di Xot già consumato dal
CMS. Questa compatibilità evita di introdurre una terza sorgente SEO mentre il
contratto Seo viene progressivamente collegato. Il tema Two passa soltanto
override semantici (per esempio il titolo della pagina), non ricostruisce meta tag
in ogni layout.

## Integrazione `laravel/head`

La libreria è una dipendenza del modulo (`laravel/head ^0.2.2` in `composer.json`, richiede
`illuminate/* ^13.17`): `vendor/` non è versionato, quindi va installata con Composer in ogni
ambiente (vedi [stories/phpstan-head-schema.story.md](./stories/phpstan-head-schema.story.md)).
Offre title, meta, Open Graph, canonical, robots e
Schema.org. Il componente la usa come unica sorgente di rendering tramite `@head`;
non vengono stampati a mano title, description, OG o JSON-LD concorrenti.

La politica robots e le alternate hreflang sono risolte da Action dedicate del Cms.
Le pagine non tradotte ricevono `noindex`; la homepage pubblica `Organization` e
`WebSite`, mentre le pagine interne pubblicano l'entità pagina e `BreadcrumbList`.

## Regole markup

- un charset e un viewport;
- un title e una description per documento pubblico;
- robots solo se il resolver fornisce una direttiva;
- canonical e alternate devono rispettare locale e routing Folio;
- robots deve riflettere indicizzabilità e disponibilità della traduzione;
- JSON-LD deve essere JSON valido e viene serializzato dal renderer Laravel Head;
- nessuno script CSS/JS del tema Sixteen: il runtime è quello di Two.

## Non-obiettivi

Non si installano nuovi pacchetti Schema.org, non si modificano in massa le copie
legacy/fixture sotto `resources/views/views`, e non si sposta la logica di routing
CMS nel componente head.
