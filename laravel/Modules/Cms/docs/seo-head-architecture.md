---
title: "Architettura del componente Head SEO"
type: concept
module: Cms
status: approved
created: 2026-10-30
updated: 2026-11-11
tags: [cms, seo, blade, architecture, schema-org, theme-two]
qmd: "cms seo head blade component theme two schema org laravel head"
related:
  - "./stories/seo-head-component.story.md"
  - "./foot-component-architecture.md"
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
contratto Seo viene progressivamente collegato. I temi che lo usano (TwentyOne, Sixteen) passano soltanto
override semantici (per esempio il titolo della pagina), non ricostruisce meta tag
in ogni layout.

## Integrazione `laravel/head`

La libreria è già installata e offre title, meta, Open Graph, canonical, robots e
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
- nessuno script o stile di un tema specifico dentro il componente: Vite si risolve da `pub_theme` (`themes/<tema>`) e gli
  script/stili propri di un tema (FOUC guard, bootstrap Alpine) entrano con `@push('head')` / `@push('styles')` dal layout.

## Adozione per tema (stato misurato 2026-11-11)

| Tema | Usa `<x-cms::head>` | Dove |
|------|---------------------|------|
| TwentyOne | sì | `resources/views/layouts/base.blade.php:3`, `resources/views/components/layouts/app.blade.php:5` |
| Sixteen | sì: `<x-cms::head>` in `components/layouts/{main,auth,guest}`, `layouts/{base,guest}`, `mobile/layout` | policy tenant in `config/{tenant}/fixcity/head.php`; vedi la [story](./stories/head-sixteen-layout-migration.story.md) |
| Barthelemy, Meetup | no | — |

Nel repo non esiste un tema «Two»: le versioni precedenti di questo documento lo citavano per errore (testo copiato da un
altro repo). Il precedente di adozione è TwentyOne.

### Cosa il componente decide al posto del tema

Da sapere prima di adottarlo. Misurato confrontando il render del componente con la testa attuale di Sixteen (tabella completa
nella story); le decisioni D-1…D-6 su questi punti sono ancora aperte:

- il **brand** viene da `pub_theme::header.brand.name`, poi da `metatag.php` (`title`), poi da `config('app.name')`: un `title`
  segnaposto nel tenant finisce in `<title>`, `og:site_name`, `application-name` e nel JSON-LD `Organization`;
- il **titolo** è `Pagina — Brand`, con separatore fisso (`ComposeDocumentTitleAction`);
- i percorsi **`noindex`** sono costanti dentro `ResolveRobotsPolicyAction` (`HIDDEN_SEGMENTS`, `HIDDEN_SLUGS`): né quella Action né
  `ResolveHreflangAlternatesAction` leggono configurazione, e il tema non può aggiungerne;
- **canonical e hreflang** partono da `request()->path()`: la query, `?page=N` compresa, non viene conservata;
- uno `@stack` rende solo ciò che è già stato accumulato: nel layout un `@push('head')` va scritto **prima** del tag
  `<x-cms::head>`, altrimenti si perde senza errori.

## Non-obiettivi

Non si installano nuovi pacchetti Schema.org, non si modificano in massa le copie
legacy/fixture sotto `resources/views/views`, e non si sposta la logica di routing
CMS nel componente head.
