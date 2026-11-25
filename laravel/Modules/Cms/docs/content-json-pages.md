---
title: "Contenuti JSON: pagine, sezioni, slug, lingue"
type: concept
module: Cms
status: active
qmd: "cms contenuti json pagine sezioni slug sushi SushiToJsons content_blocks traduzioni pagine legali middleware pagina"
---

# Contenuti JSON del Cms

Le pagine pubbliche non stanno nel database: ogni pagina e' un file JSON del tenant, letto come riga Eloquent dal
trait `SushiToJsons` (modulo Tenant). Il JSON del tenant e' l'input editoriale di `<x-page>`: Folio possiede il
percorso, il Cms legge i dati, il tema veste i blocchi (flusso in [architecture.md](architecture.md)).

## Dove stanno i file

```
config/local/<tenant>/database/content/
├── pages/            slug "home" -> home.json, "events.my" -> events/my.json
├── sections/         header, footer e altre sezioni condivise
└── page_contents/    contenuti collegati (un file per id)
```

`<tenant>` deriva dall'`APP_URL`. `SushiToJsons::collectRowsFromJsonFiles()` legge ricorsivamente
`database/content/<tabella>/**.json`: per un file `a/b/x.json` prefissa `id` e `slug` con `a.b.`
(sotto-pagine: [cms-subpages-folders.md](cms-subpages-folders.md)). I file senza estensione `.json` sono ignorati. Un
override per modulo e' ammesso (stesso slug in `Modules/<Modulo>/config/database/content/pages/`: non e' un conflitto).

I file sotto `database/content/` sono **dati sacri del tenant**. Prima di un commit "a blocco" che tocca piu' moduli o temi
controllare che il diff non contenga cancellazioni in quel percorso: una pulizia di documentazione ne ha gia' cancellati
21 insieme (recuperati dalla versione genitore del commit, senza checkout/reset: il repository va solo in avanti).
Un JSON invalido (virgola finale) fa sparire la pagina: validare dopo ogni modifica a mano.

## Schema di una pagina

```json
{
  "id": "events",
  "slug": "events",
  "title": {"it": "Eventi", "en": "Events"},
  "middleware": ["auth"],
  "content": null,
  "content_blocks": {"it": [ {"type": "hero", "slug": "hero-1", "active": true,
                              "data": {"view": "pub_theme::components.blocks.hero.main", "title": "..."}} ],
                     "en": []},
  "sidebar_blocks": {"it": []},
  "footer_blocks": null
}
```

Campi del modello `Page` (`$fillable`): `content`, `description`, `layout`, `slug`, `title`, `middleware`, `blocks`,
`content_blocks`, `sidebar_blocks`, `footer_blocks`. Tipi di blocco e view: [content-blocks-system.md](content-blocks-system.md).

## Lingue

`title` e i blocchi sono mappe `lingua -> valore`. `HasBlocks::getBlocks($side)` sceglie la lingua cosi':

1. lingua corrente (`app()->getLocale()`), senza fallback automatico;
2. se manca, la lingua primaria (`XotData::primary_lang`);
3. se manca anche quella, array vuoto.

Ogni blocco diventa un `BlockData(type, data, slug, active)`: un blocco con `"active": false` non si renderizza. La
stringa `{{ ... }}` nei dati e' valutata solo se rientra in un'espressione sicura (`SAFE_EXPRESSION`) o in una
traduzione (`trans()`); il resto resta testo. Se `data.query` e' un array, `ResolveBlockQueryAction` esegue la query e
unisce i risultati ai dati del blocco (es. elenco eventi). `BlockData` va costruito con `new` (come fa `HasBlocks`):
`BlockData::collection()` rigenera l'oggetto e perde i dati risolti dalla query. `data.view` deve esistere, altrimenti
`RuntimeException('view not found: ...')`.

## Regole sullo slug

1. **Una pagina = un file per slug nella stessa cartella.** Due file con lo stesso slug nella stessa cartella danno
   `CMS content collision: ... matched N records for slug [...]` (errore 500, lanciato da `HasBlocks`).
2. Il nome della pagina e' lo slug: niente file piatti con trattino per le sotto-pagine (`events-my.json`).
3. Pagine di test: file `tests.<slug>.json` con `"slug": "tests.<slug>"` (mai `homepage.json` con slug
   `tests.homepage`); lo slug vuoto di `/tests` e' `tests.index`. Due pagine duplicate in una stessa cartella hanno gia'
   prodotto due 500 (2026-10-13).
4. Le pagine legali (`privacy`, `terms`, e `cookie-policy` dove il footer la linka) devono esistere come JSON con
   slug uguale al nome: il renderer `pages/[slug].blade.php` si aspetta pagine risolvibili per slug e il footer le linka.
   Prima si crea il JSON, poi si linka. Il testo HTML di questi blocchi passa da `SanitizeHtmlAction`.

## Sezioni con template alternativo

`<x-section slug="header" tpl="..." />` cerca la view `pub_theme::components.sections.<slug>.<tpl>` (`tpl` di default
`v1`, il footer usa `full`). Una sezione con blocchi `blocks.<lingua>[].data` richiede il template
`sections/<slug>/<tpl>.blade.php` nel tema, che unisce i `data` dei blocchi come fanno gli altri template.
Header e footer sono sezioni condivise: non appartengono allo slug di una pagina.

## Middleware di pagina nel JSON

Il campo `middleware` (es. `["auth"]`) e' applicato da `PageSlugMiddleware` sulla pagina Folio. Sono ammessi solo i nomi
di `cms.config.page_middleware_allowlist` (`auth`, `guest`, `throttle`, anche con parametri `throttle:60,1`); altri
nomi o classi rendono la pagina 503. Lo slug cercato, in ordine: il percorso stesso (`/profile/edit` -> `profile.edit`),
il nome della rotta Folio, `{container0}.{slug0}`, `{container0}.{container1}` per le rotte a tre segmenti
(`/restaurants/{slug}/menu` -> `restaurants.menu`), `{container0}.{slug}`, poi `slug0`/`slug` da soli. Le rotte
`profile`, `user` e `users` con un identificativo non diventano mai un fallback pubblico: 404 se `ResolvePageAction` non
trova un contenuto autorizzato. Dettaglio: [wiki/concepts/cms-page-middleware-json-ssot.md](wiki/concepts/cms-page-middleware-json-ssot.md),
[adr/page-middleware-allowlist.md](adr/page-middleware-allowlist.md).

## Cosa fare quando si aggiunge una pagina

1. Creare il JSON in `pages/` (o in `pages/<contenitore>/` per una sotto-pagina) con titolo e blocchi in **tutte** le
   lingue supportate.
2. Usare solo view di blocco esistenti nel tema attivo.
3. Se serve accesso riservato: `"middleware": ["auth"]`.
4. Provare `/it/<slug>` e `/en/<slug>`; per pagine con `auth`, da ospite e da loggato.
