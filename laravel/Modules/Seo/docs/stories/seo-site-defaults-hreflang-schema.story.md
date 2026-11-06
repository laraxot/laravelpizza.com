---
title: "Seo: defaults di sito, hreflang, politica robots e schema.org per laravel/head"
type: story
module: Seo
status: review
priority: high
created: 2026-10-30
updated: 2026-10-30
tags: [seo, laravel-head, hreflang, robots, schema-org, defaults, queueable-actions]
qmd: "Seo Head::defaults hreflang alternates robots noindex schema Organization WebSite BreadcrumbList laravel/head actions Cms dipendenza circolare"
related:
  - ../../../../../docs/stories/seo-head-maximum-schema-org-hreflang.story.md
  - ../../../Cms/docs/stories/seo-head-component.story.md
  - ./inbound-article-event-schema.story.md
  - ../wiki/concepts/metatag-data-contract.md
---

# Seo: defaults di sito, hreflang, politica robots e schema.org

Corsia B della story [SEO al massimo del front office](../../../../../docs/stories/seo-head-maximum-schema-org-hreflang.story.md).
Il componente `<x-cms::head>` è della corsia A (Cms); qui stava il piano di **politica e dati**: cosa dire nel `<head>`, non come comporlo.

> **Esito:** la politica è stata realizzata, ma **in `Modules/Cms`** e non in Seo (vedi «Perché in Cms alla fine»). Questa story resta come
> traccia della decisione; gli acceptance criteria sotto indicano dove sta ciascun pezzo.

## Scopo

Come visitatore o crawler voglio che ogni pagina dichiari titolo, descrizione, lingua, alternative linguistiche, indicizzabilità e
dati strutturati corretti, così che i risultati di ricerca e le anteprime siano esatti e le pagine riservate non vengano indicizzate.

## Perché in Cms alla fine

Il piano iniziale metteva le Action in Seo, perché Seo possiede `MetatagData`, la sitemap e `RedirectToCanonicalPath`. Non regge:

1. **Dipendenza circolare.** Seo dipende da Cms (la sitemap legge `Modules\Cms\Models\Page`). Il componente vive in Cms e deve chiamare
   le Action: se stessero in Seo, Cms dipenderebbe da Seo.
2. **`Head::defaults()` è eager.** `laravel/head` esegue la closure al momento della registrazione (boot), non per richiesta: lingua,
   URL corrente e traduzioni non ci possono stare. `ApplySiteHeadDefaultsAction` come previsto non ha senso e non è stata scritta; i dati
   dipendenti dalla richiesta si scrivono a runtime nel componente.
3. **Una sola regola, due consumatori.** Head e sitemap leggono le stesse Action di Cms (`ResolveRobotsPolicyAction`,
   `ResolveWrittenLocalesAction`): la dipendenza Seo → Cms c'era già, nessuna nuova.

## Acceptance criteria

- [~] ~~`ApplySiteHeadDefaultsAction` in `Head::defaults()`~~ — **abbandonato** (defaults eager). Brand e descrizione del sito vengono dal
      tema (`pub_theme::header.brand.name`, `pub_theme::seo.site.description`), risolti per richiesta in `Cms\View\Components\Head`.
      Nessun segnaposto e nessuna chiave grezza `metatag.*`: senza dato il tag si omette.
- [x] `ResolveHreflangAlternatesAction` → `Modules/Cms/app/Actions/Head/`. URL assolute, self-reference, `x-default`, vuoto sotto due lingue,
      limitato alle lingue in cui la pagina è scritta.
- [x] `ResolveRobotsPolicyAction` → `Modules/Cms/app/Actions/Head/`. Un solo elenco `HIDDEN_SEGMENTS`, letto da head e sitemap.
- [x] `BuildHeadSchemaAction` → `Modules/Cms/app/Actions/Head/`: home `Organization` + `WebSite`; pagine interne entità pagina + `BreadcrumbList`.
      Niente `FAQPage` (rich result terminato il 7-5-2026), `HowTo`, `SearchAction`. `Cms\BuildPageSchemaAction` resta e viene riusata per l'entità pagina.
- [~] Una chiamata di pagina `Head::title(...)` non cancella le altre voci: il componente non chiama mai `Head::flush()`; **manca un test che lo provi**.
- [~] Test Pest senza database: 6 test verdi in esecuzione isolata (`ResolveWrittenLocalesActionTest`, `HeadSeoPolicyTest`); copertura di hreflang e schema ancora da scrivere.
      PHPStan `Modules` a 0 errori, niente `@phpstan-ignore`.

## Tasks

- [x] Fonte unica delle lingue: `ResolveWrittenLocalesAction` (lingue con titolo CMS non vuoto), usata da hreflang, robots e sitemap.
- [x] Mappare i tag di `x-cms::head` sui quattro strati di `laravel/head` (esito nell'hub e nel concept `laravel-head-layers-and-seo-checklist`).
- [x] Le Action e il collegamento al componente; `BuildSitemapAction` usa le stesse regole.
- [ ] Decidere con i dati del tenant il tipo dell'organizzazione (`Organization` o `LocalBusiness`) e quali proprietà (indirizzo, telefono, P.IVA, `sameAs`)
      pubblicare. **Decisione dell'utente:** finché mancano dati reali si pubblica solo nome, URL e logo.
- [ ] Test per hreflang (`build()` è pura) e per `BuildHeadSchemaAction`.
- [ ] Unificare con la corsia C (`BuildRobotsTxtAction::PRIVATE_SEGMENTS`) l'elenco dei segmenti riservati e togliere da `robots.txt` i `Disallow`
      per le aree `noindex`: con `Disallow` il crawler non legge il `noindex`.

## Owned File/Module Scope

Chiusa la corsia: i file stanno in `laravel/Modules/Cms/app/Actions/Head/`, `laravel/Modules/Cms/app/View/Components/Head.php`,
`laravel/Modules/Cms/tests/Unit/Actions/Head/`; in Seo solo `app/Actions/Sitemap/BuildSitemapAction.php` e questa documentazione.

## Claim

| Chi | Scope | Stato |
|---|---|---|
| sessione 56da8100 (claude) | Action in Cms, sitemap, documenti | fatto, in `review`; lock rilasciati |

## Dev Agent Record

- Misura (Playwright headless, solo GET, 8 pagine × 390/1280 px × chiaro/scuro): da 254 controlli falliti su 19 tipi a 28 su 1 tipo
  (`og-completo`: manca `og:image`, serve l'asset). CLS massimo 0,022. `/sitemap.xml` 200 con 36 URL (solo `it` e `en`).
- `/de` e `/es` restano `noindex` e senza hreflang finché il contenuto CMS non è tradotto; poi si indicizzano da soli.
- Dettagli, tabella dei difetti e numeri prima/dopo: hub e concept `laravel-head-layers-and-seo-checklist` (second brain).

## Non verificato

- Rich Results Test e Schema Markup Validator (richiedono una URL pubblica); Lighthouse (nessun display in questo ambiente).
- `Head::errors()` per le pagine di errore di Folio/Livewire; `wire:navigate` (i JSON-LD si accumulano nel DOM del browser).
- Asset sociali e icone assenti in `public/themes/Two/`: `images/social-share.jpg` (1200×630), `favicon.ico`, `favicon-180x180.png`, `site.webmanifest`.

## Ripartenza

Aprire l'hub, leggere «Esiti della revisione del componente» e l'elenco «Aperto»; controllare i lock con `claims-open.py`; poi partire dai test
mancanti (hreflang, schema, `Head::title` che non cancella le altre voci).

## Secondo giro (2026-10-30)

`BuildSitemapAction` non ha piu' una propria costante di pagine escluse: chiama `Cms\Actions\Head\ResolveRobotsPolicyAction::isPageIndexable($slug, $middleware)`, la stessa regola del `<head>`. Una pagina e' in sitemap se la sua lingua e' scritta (titolo **e** contenuto), non ha middleware `auth` e non e' una pagina di prova/riservata. Effetto misurato: 36 → 32 URL (fuori le due pagine di blog e due servizi con titolo inglese ma corpo italiano, ora `noindex`). Il test `tests/Unit/Actions/Robots/RobotsSegmentsMatchHeadPolicyTest.php` garantisce che ogni segmento chiuso da `robots.txt` (`BuildRobotsTxtAction::PRIVATE_SEGMENTS`) sia anche `noindex` nel `<head>`.

## GitHub (tracciamento)

- Issue: https://github.com/laraxot/base_techplanner_fila5/issues/18 (coordinamento multi-agente del repo base)
- Discussion: https://github.com/laraxot/base_techplanner_fila5/discussions/54
- Nota: riusate le due di coordinamento del repo base; nessuna issue o discussion nuova creata da questa passata (decisione dell'utente se aprirne una per modulo/tema owner).
