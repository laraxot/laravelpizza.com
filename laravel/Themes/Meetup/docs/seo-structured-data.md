---
title: "SEO, meta tag e dati strutturati"
type: guide
status: active
theme: Meetup
qmd: "seo meta tag title description canonical open graph twitter card json-ld schema.org structured data rich snippets webpage profilepage collectionpage itempage event sitemap robots x-cms::head metatags hreflang"
---

# SEO, meta tag e dati strutturati

Il SEO del sito e' fatto dal modulo Cms (`<head>`, schema delle pagine), dal modulo Seo (sitemap, robots, alias) e dal modulo Meetup (JSON-LD `Event`). Il tema fornisce layout e immagine di condivisione e non reinventa nulla. Le regole sotto evitano la regressione tipica: ogni pagina con lo stesso titolo e markup strutturato incompleto o contraddittorio.

## Il `<head>` lo scrive il CMS

`resources/views/components/layouts/main.blade.php` non contiene un `<head>` a mano: chiama `<x-cms::head :title :description :stylesheet>` (`Modules/Cms/app/View/Components/Head.php`, view `Modules/Cms/resources/views/components/head.blade.php`). La view emette `@head` e gli stack `head`/`styles`; i tag li compone `Head.php` con `HeadManager`: `title`, description, `canonical`, `hreflang` delle sole lingue scritte (`ResolveHreflangAlternatesAction`), `robots`, Open Graph (`og:title|description|url|image|site_name|locale|type`), Twitter Card `summary_large_image` e il JSON-LD della pagina (in home `Organization` e `WebSite`; altrove la pagina piu' le briciole). `@filamentStyles` e lo script del tema scuro si caricano solo con `panel-assets`. Esiste anche il componente piu' vecchio `<x-metatags>` (`Metatags.php`/`metatags.blade.php`) con la stessa logica.

Regole:

- **Mai scrivere a mano `<head>` o i meta nei layout/pagine**: si passa `:title` e `:description` a `<x-layouts.app>`/`<x-layouts.main>` (vengono ripuliti con `strip_tags`) e il resto lo decide il CMS. Senza valori espliciti titolo e descrizione vengono dal JSON della pagina (`Modules/Cms/docs/page-title-and-description.md`).
- Non passare `@vite` o `@livewireStyles` come slot del componente head (li include gia' lui): era la causa di un `ParseError` "expecting elseif/else/endif" nel layout. Le pagine che devono aggiungere tag usano `@push('head')` (il layout lo fa per `resources/js/app.js` e il dettaglio evento per il suo JSON-LD).
- Titolo unico per pagina (<= 60 caratteri, con il brand) e description unica (<= 160); un solo `h1`; gerarchia `h2/h3` ordinata; `alt` sulle immagini; HTML semantico (`header`, `nav`, `main#main-content`, `footer`).
- **Prestazioni = segnale di ranking**: il visitatore anonimo riceve `resources/css/site.css` e niente JS Filament; il CSS completo `app.css` e `@filamentScripts` solo dove servono (utente loggato o `*/auth*`). Nessun preconnect a Google Fonts o Analytics (invierebbe l'IP a terzi prima del consenso). Vedi [assets-and-build](assets-and-build.md).
- Immagine di condivisione: `public/images/social-share.jpg` 1200x630 generata da `node scripts/social-share-image.mjs` (usa `Modules/Meetup/resources/svg/logo.svg`); la usano `og:image`, `twitter:image` e `Event::toSchemaOrg()` come riserva.

## Sitemap, robots, alias

- `/sitemap.xml` (`Modules/Seo`, `BuildSitemapAction`): elenca le pagine e gli eventi **pubblicati** in tutte le lingue, mai le bozze; `/robots.txt` punta alla sitemap e tiene fuori `/*/admin` e `/it/auth`.
- Alias di pagina del tenant in `config/local/laravelpizza/seo.php` (`path_aliases`): `chi-siamo`/`contatti`/`contacts` -> `about`/`contact`, `login`/`register` -> `auth/login`/`auth/register`, `events-my`/`events-past` -> `events/my`/`events/past`; i default del modulo vengono da un altro progetto e qui causerebbero 404.
- Test: `Modules/Meetup/tests/Feature/SeoTechnicalTest.php` (evento completo collegato per `@id`, sold out, sitemap senza bozze, robots, home per lingua con `Organization` e `WebSite`, CSS leggero per anonimi) e `FrontOfficePrivacyAndSeoTest`.

## Tipi di pagina schema.org

Calcolati da `Modules\Cms\Actions\BuildPageSchemaAction::resolvePageType()` dal nome della rotta e dal percorso (ogni pagina emette `@type`, `name`, `url`, `inLanguage`, `description`):

| Pagina | `@type` | Note |
|---|---|---|
| home | `WebPage` | `Organization` e `WebSite` nel grafo |
| `/events` | `CollectionPage` | |
| `/events/{slug}` | `ItemPage` | `mainEntity` e' solo il riferimento `{ '@id': '<url>/events/<slug>#event' }`: l'`Event` completo lo pubblica la pagina con lo stesso `@id` (un `Event` con il solo URL sarebbe incompleto per Google) |
| `/profile/{id}` (rotte `profile.*`) | `ProfilePage` | `mainEntity` = `Person` dell'utente pubblico risolto dalla rotta |
| `/about` | `AboutPage` | |
| `/contact` | `ContactPage` | |
| `auth/*`, login, register | `WebPage` | non `ProfilePage` |

Regola: distinguere tipo di pagina ed entita' principale (la pagina dettaglio e' `ItemPage`, l'entita' e' `Event`; una pagina profilo e' `ProfilePage` + `Person`). Mai un solo JSON-LD generico per tutte le pagine; `ProfilePage` solo per profili pubblici reali, non per modifica account.

## Dati strutturati: regole per le Blade

- Il tema **non inventa campi schema.org**: consuma JSON-LD gia' normalizzato dal modello (`Event::toSchemaOrg()`, mapper del dominio Meetup) e lo rende solo se i dati minimi sono validi. Un solo payload canonico per la stessa entita' in tutte le view; mai fallback semantici deboli che producono markup parziale.
- Pagina evento: `Event` con `Place` annidato (luogo), `Organization`/`Person` (organizzatore), `Person` (relatori), `Offer` solo se c'e' registrazione o prezzo; niente `Review` se il feedback non e' pubblico; i modelli pivot non sono tipi autonomi. Il JSON-LD deve riflettere il contenuto visibile e non contenere email private.
- Le liste (organizzatori, relatori, sponsor, partecipanti) vengono dalle relazioni del modello backend (`belongsToManyX()`), mai da query ad hoc nelle Blade ne' da `belongsToMany()` semplice.
- Verifica: Rich Results Test di Google, validator.schema.org e test applicativi che controllano i nodi minimi nel markup finale ([testing](testing.md)).

## Open Graph e social

Titolo, descrizione e immagine di condivisione dalle stesse sorgenti del `<head>`; il componente di condivisione e i testi social sono localizzati ([social-share-and-marketing](social-share-and-marketing.md)).

## Vedi anche

- [events-pages](events-pages.md) — JSON-LD del dettaglio evento
- [dashboard-and-profile](dashboard-and-profile.md) — `ProfilePage`
- [accessibility](accessibility.md), [localization-standard](localization-standard.md)
