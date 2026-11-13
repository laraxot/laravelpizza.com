# Story: pagine CMS in sottocartella — slug relativo + prefisso di cartella

**Modulo owner:** Cms (loader `SushiToJsons` in `Modules/Tenant`, risoluzione in `Modules/Cms`)
**Stato:** done per le pagine `restaurants/*`; aperto per `services/*` e `blog/*` (vedi sotto)
**Supersede:** nulla. Non collegata da altre story.

## Regola verificata

`SushiToJsons::collectRowsFromJsonFiles` antepone il nome della cartella a `id` e `slug` dei file
in sottocartella (`prefixRowKeys`). Quindi:

- file `pages/restaurants/menu.json` con `"slug": "menu"` → slug finale `restaurants.menu`;
- file con `"slug": "restaurants.menu"` dentro `restaurants/` → `restaurants.restaurants.menu`
  (non raggiungibile).

Il resolver (`ResolvePageAction`) cerca `container0.slug0` e `container0.index`; quindi nel file
lo slug è solo il nome locale, la cartella è il contenitore.

## Pagine create

- `pages/restaurants/index.json` → `restaurants.index` (URL `/{lang}/restaurants`)
- `pages/restaurants/menu.json` → `restaurants.menu` (URL `/{lang}/restaurants/menu`)
- `pages/restaurants/book.json` → `restaurants.book` (URL `/{lang}/restaurants/book`)

Ogni pagina ha `content_blocks` per `it` ed `en`. `menu` usa `menu.categories` (senza dipendenza
dallo slug: `public_menu` leggerebbe lo slug come ristorante e risponderebbe 404).

## Verifica

- JSON valido, nessuno slug duplicato.
- `Page::where('slug', …)` trova le tre pagine, con blocchi (`restaurants.index`: 1,
  `restaurants.menu`: 2, `restaurants.book`: 2).
- `/it/restaurants`, `/it/restaurants/menu`, `/it/restaurants/book`, `/en/restaurants/book`: 200,
  H1 corretto, `data-slug` corretto. Log invariato.

## Aperto (non toccato)

Le pagine esistenti `pages/services/*.json` e `pages/blog/*.json` hanno lo slug già con la
cartella (es. `services/documentazione`), quindi nel DB diventano `services.services/documentazione`
e non sono raggiungibili con `/services/documentazione`. Stesso schema per `blog/*`. Va deciso se
correggerle (slug relativo) e come gestire il vecchio `services.json` che usa lo stesso contenitore.
