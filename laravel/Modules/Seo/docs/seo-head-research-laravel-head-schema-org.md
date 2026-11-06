---
title: "Ricerca: laravel/head, SEO 2026 e schema.org per il head"
type: research
module: Seo
status: active
created: 2026-10-30
updated: 2026-10-30
tags: [seo, laravel-head, schema-org, hreflang, canonical, open-graph, robots, sitemap, core-web-vitals]
related:
  - ../../../../docs/stories/seo-head-maximum-schema-org-hreflang.story.md
  - stories/seo-site-defaults-hreflang-schema.story.md
  - ../../Cms/docs/seo-head-architecture.md
---

# Ricerca: laravel/head, SEO 2026 e schema.org

Secondo parere indipendente per il componente `<x-cms::head>` (Cms) e per la politica e i dati del `<head>` (Seo),
nato dall'hub `docs/stories/seo-head-maximum-schema-org-hreflang.story.md`. Letto dal sorgente di `laravel/head` v0.2.2 e dalle pagine ufficiali
indicate; [Inference] segna una deduzione. Non sostituisce l'hub: ne corregge alcune ipotesi (vedi «Correzioni al piano»).

## 1. Cosa fa davvero `laravel/head` 0.2.2

- `@head` rende `app('head')->renderForView()`. L'ordine dei tag e' fisso: title, description, canonical, robots, Open Graph, Twitter, paginazione,
  alternate (hreflang), feed, performance (preload/preconnect), meta (viewport, theme-color), link generici (icon, manifest), schema.
- Strati di precedenza: defaults, gruppo di rotte, rotta, runtime, errore. `Head::flush()` azzera tutto.
- Metodi utili: `title(exact:, prefix:, suffix:)`, `description()`, `canonical(url, forceHttps, trailingSlash)`, `alternates([...])`,
  `og(...)`, `ogImage(url, alt, width, height)`, `twitter(...)`, `robots(...)`, `hiddenFromRobots()`, `preload*`, `preconnect`, `themeColor`,
  `favicon`, `appleTouchIcon`, `manifest`, `schema(...)`. Macro di rotta `withHead(...)`.
- Schema: factory per article, blogPosting, event, product, offer, brand, breadcrumbs, faq, organization, person, webPage, webSite; un nome
  sconosciuto (`Schema::localBusiness()`, `service()`, `aboutPage()`, `contactPage()`) crea un oggetto generico con `@type` in StudlyCase.
- **Non copre:** `<meta charset>` (si scrive a mano prima di `@head`), `og:locale:alternate` ripetuto, sitemap, robots.txt, controlli di reciprocita'
  hreflang, `@graph`, helper per `PostalAddress`/`ImageObject`/`sameAs`, lunghezza di title e description.

### Limiti verificati sul sorgente

1. **`@graph` rifiutato fuori produzione.** Il validatore pretende `@context` uguale a `https://schema.org`, un `@type` alla radice e nessun valore
   `null` o stringa vuota a qualsiasi livello; un array `{"@context","@graph"}` non ha `@type` e lancia `InvalidSchema` (in produzione logga e rende).
   Due vie: un nodo radice `WebPage` con `isPartOf`, `publisher`, `breadcrumb` annidati e `@id` stabili, oppure un builder custom registrato con `Head::extend()`.
2. **`og:locale:alternate` ripetuto non si puo' fare con `meta()`:** i meta sono deduplicati per attributo, chiave e media, quindi resta l'ultimo.
   Serve un builder custom o tag scritti a mano.
3. **`canonical()` forza `https` per default** mentre `og(url:)`, `ogImage` e `alternates` non vengono normalizzati: da qui il canonical `https` e `og:url` `http`
   misurati sul sito. Costruire un'unica origine e derivare tutto da li'. L'host del canonical viene dalla richiesta: con l'indirizzo di sviluppo uscirebbe quello.
4. **Deduplica degli schema:** gli array sono chiavati per hash del contenuto, gli oggetti per identita' dell'istanza (due oggetti uguali escono due volte).
5. **Ordine:** viewport e theme-color escono dopo Open Graph e Twitter. Per un ordine corretto tenere `charset` e `viewport` letterali prima del componente.
6. **Folio** ha una sola rotta di fallback: `withHead()` per pagina non e' applicabile; chiamare `Head::...` nella pagina o nel componente prima del render.
7. **Escape corretto:** il JSON-LD usa `JSON_HEX_TAG|AMP|APOS|QUOT`, quindi `</script>` esce come `</script>`. Titolo e attributi passano da `e()`.
8. `->id('x')` non e' garantito scrivere `@id` (usare `set('@id', ...)`); `Organization::logo()` accetta una stringa (per un `ImageObject` usare `set('logo', [...])`).
   [Inference] punto 8 non riprovato con una chiamata reale.
9. Un valore meta pari a una chiave di traduzione grezza (`metatag.author`) passa: il pacchetto non lo riconosce. Omettere il tag se il valore e' vuoto o uguale alla chiave.

## 2. Buone pratiche per questo sito

| Tema | Regola | Fonte |
|---|---|---|
| Title | Unico per pagina, brand una sola volta, nessun limite ufficiale di caratteri (troncato per larghezza). 50-60 e' convenzione, non regola. | https://developers.google.com/search/docs/appearance/title-link |
| Description | Nessun limite ufficiale; descrizioni identiche su tutte le pagine non aiutano. Quella attuale e' il segnaposto del pannello admin. | https://developers.google.com/search/docs/appearance/snippet |
| Canonical | Assoluto, `https`, uno solo, nell'`<head>`, autoreferenziale; mai verso redirect, 404 o `noindex`; un canonical con `hreflang` o `lang` e' ignorato. | https://developers.google.com/search/docs/crawling-indexing/consolidate-duplicate-urls |
| hreflang | Ogni versione elenca se stessa e tutte le altre (se non e' reciproco e' ignorato); URL assoluti; ISO 639-1 piu' regione opzionale; `x-default` solo per selettore lingua o home. Il canonical di ogni lingua punta a se stessa. | https://developers.google.com/search/docs/specialty/international/localized-versions |
| Lingua | Niente redirect automatico per `Accept-Language` o IP; link visibili alle altre lingue. | https://developers.google.com/search/docs/specialty/international/managing-multi-regional-sites |
| `og:locale` | Forma `ll_CC` (`it_IT`, `de_DE`, `es_ES`, `en_GB`); `og:locale:alternate` ripetibile. Obbligatori `og:title`, `og:type`, `og:image`, `og:url`. | https://ogp.me/ |
| Immagine social | Almeno 1200x630 (circa 1,91:1), `og:image:width/height` e `alt`. Oggi `/images/logo.png` risponde 404. | https://developers.facebook.com/docs/sharing/webmasters/images/ |
| Robots | Login, registrazione, reset e profilo: `noindex` nella pagina (che deve restare scansionabile). `Disallow` non toglie dall'indice. `noarchive` e' ignorato da Google. | https://developers.google.com/search/docs/crawling-indexing/robots-meta-tag |
| robots.txt | Alla radice dell'host, UTF-8, `Sitemap:` assoluto, non bloccare CSS e JS. | https://developers.google.com/search/docs/crawling-indexing/robots/create-robots-txt |
| Sitemap | Max 50.000 URL o 50 MB, solo URL canonici, `priority` e `changefreq` ignorati, `lastmod` solo se affidabile; hreflang nella sitemap equivale a quello nell'head, ma le due fonti non devono divergere. | https://developers.google.com/search/docs/crawling-indexing/sitemaps/build-sitemap |
| Favicon | `<link rel="icon">` nell'head della home, quadrata, file scansionabile. Manifest e `theme-color` non sono trattati da Google. | https://developers.google.com/search/docs/appearance/favicon-in-search |
| Core Web Vitals | LCP <= 2,5 s al 75o percentile; risorsa LCP nell'HTML iniziale con `fetchpriority="high"`, mai lazy-load; preload dei font con `crossorigin`; niente script sincroni nell'head. | https://web.dev/articles/optimize-lcp |
| Ordine dell'head | charset e viewport, title, preconnect/preload prioritari, script async, script sincroni, stili, il resto; OG e icone per ultimi. | https://rviscomi.github.io/capo.js/user/rules/ |

[Inference] il CSS del tema arriva da `@vite` a fine `<body>`: spostarlo nell'head e' un guadagno di rendering da misurare con Lighthouse prima di dichiararlo.

## 3. schema.org: cosa usare e cosa no

Regole di Google: preferire JSON-LD, marcare solo contenuto visibile e veritiero, mai recensioni o valutazioni inventate
(https://developers.google.com/search/docs/appearance/structured-data/sd-policies). Il campo che il CMS non ha si omette.

- **Organization** (https://developers.google.com/search/docs/appearance/structured-data/organization): nessuna proprieta' obbligatoria; raccomandate `name`,
  `legalName`, `url`, `logo` (almeno 112x112, scansionabile), `address`, `telephone`, `email`, `contactPoint`, `sameAs`, `vatID`. Il logo oggi non esiste (404):
  omettere finche' non c'e' un file vero. I `sameAs` dai campi social del tenant, solo se non vuoti.
- **LocalBusiness** (https://developers.google.com/search/docs/appearance/structured-data/local-business): obbligatori `name` e `address`; sottotipo piu' specifico.
  Senza un indirizzo pubblico dal tenant resta `Organization`. `ProfessionalService` e' marcato come deprecato su schema.org (https://schema.org/ProfessionalService);
  `Dentist` non va se il sito e' di un fornitore di servizi agli studi: il dentista e' il cliente, non l'organizzazione che pubblica il sito.
- **WebSite** (https://developers.google.com/search/docs/appearance/site-names): `name` e `url`, solo in home, nome coerente con `og:site_name` e title.
  `SearchAction`/sitelinks searchbox e' stato rimosso da Google (29-11-2024): non aggiungerlo (https://developers.google.com/search/docs/appearance/structured-data/sitelinks-searchbox).
- **WebPage, AboutPage, ContactPage, CollectionPage:** nessun rich result, servono a collegare il grafo (`isPartOf`, `about`, `publisher`, `breadcrumb`, `inLanguage`).
- **BreadcrumbList** (https://developers.google.com/search/docs/appearance/structured-data/breadcrumb): almeno 2 `ListItem`, `name` e `position`; non in home; nomi e URL nella lingua della pagina.
- **Service** (https://schema.org/Service): un nodo per servizio realmente elencato, con `provider` che rimanda all'`@id` dell'organizzazione; senza `offers` ne' prezzi.
- **Article/BlogPosting** (https://developers.google.com/search/docs/appearance/structured-data/article): `headline`, `datePublished` e `dateModified` ISO 8601, `author` dal record, `image`.
- **Person:** solo per autori o staff reali e consenzienti; niente email o telefono.
- **FAQPage:** Google indica la fine del rich result FAQ dal 7 maggio 2026 (era gia' limitato a siti governativi e sanitari dal 2023): non aggiungere il markup per ottenere un risultato
  (https://developers.google.com/search/docs/appearance/structured-data/faqpage). Il contenuto FAQ resta HTML visibile.
- **ProfilePage:** valida per Google solo per pagine di creatori, non per profili utente applicativi (https://developers.google.com/search/docs/appearance/structured-data/profile-page);
  quelle pagine vanno in `noindex` e il markup non deve contenere dati personali.
- **Review, aggregateRating:** omessi, nessun dato reale.

### Grafo con `@id` stabili (schema)

```json
{"@context":"https://schema.org","@graph":[
 {"@type":"Organization","@id":"https://HOST/#organization","name":"{dal tenant}","url":"https://HOST/"},
 {"@type":"WebSite","@id":"https://HOST/#website","url":"https://HOST/","name":"{nome sito}","publisher":{"@id":"https://HOST/#organization"}},
 {"@type":"AboutPage","@id":"https://HOST/it/about#webpage","url":"https://HOST/it/about","inLanguage":"it","isPartOf":{"@id":"https://HOST/#website"},"breadcrumb":{"@id":"https://HOST/it/about#breadcrumb"}},
 {"@type":"BreadcrumbList","@id":"https://HOST/it/about#breadcrumb","itemListElement":[{"@type":"ListItem","position":1,"name":"Home","item":"https://HOST/it"},{"@type":"ListItem","position":2,"name":"{titolo}"}]}]}
```

`@graph` e' JSON-LD valido (https://www.w3.org/TR/json-ld11/); che Google lo elabori per i rich result non e' scritto nelle sue pagine: da provare con il Rich Results Test.
Con il validatore del pacchetto vale il limite 1 sopra.

## 4. Correzioni al piano dell'hub

- **D6 prevede `FAQPage` su `/faq`:** il rich result FAQ e' terminato; il markup non porta beneficio e il pacchetto lo valida come qualunque altro. Da togliere dall'AC, o tenerlo come scelta
  consapevole senza aspettative di risultato.
- **D6 prevede un tipo piu' specifico di `Organization`:** `ProfessionalService` e' deprecato e `Dentist` e' sbagliato; `LocalBusiness` solo con indirizzo pubblico dal tenant.
- **D2 evita `flush()`:** confermato dal sorgente (azzera tutti gli strati).
- **Nuovo vincolo:** `og:locale:alternate` e `@graph` richiedono un builder custom (`Head::extend()`), non bastano i metodi del pacchetto.
- **Pagine private nel markup:** i profili utente non devono esporre dati personali in JSON-LD; verificare l'azione che costruisce lo schema di profilo.

## 5. Come verificare senza strumenti a pagamento

- Rich Results Test (https://search.google.com/test/rich-results) e Schema Markup Validator (https://validator.schema.org/); Search Console per l'ispezione URL.
- Da riga di comando, per ogni pagina e lingua: un solo `<head>`, un solo `<title>`; stato 200 senza redirect di canonical e di ogni alternate;
  ogni blocco JSON-LD si decodifica e ogni `@id` referenziato esiste nel grafo; `title`, `description`, `canonical`, `robots` e `og:*` esattamente una volta;
  nessuna chiave `metatag.` grezza; codici hreflang validi, URL assoluti, reciprocita' (scaricare B e verificare che elenchi A).

## 6. Non verificato

Specifiche delle Twitter/X Card (la pagina ufficiale ha risposto 402), regola dei primi 1024 byte per il charset, specifica W3C del manifest, elaborazione di `@graph` da parte di Google
per i rich result, comportamento di `->id()`.
