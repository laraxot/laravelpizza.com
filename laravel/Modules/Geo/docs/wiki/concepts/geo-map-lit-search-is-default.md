# GeoMapLit Search — Collapsed by Default (Toggle Pattern)

## Decisione

`<geo-map-lit>` include sempre la ricerca indirizzo, ma **collassata di default**.

L'utente vede solo il pulsante lente (`.geo-search-toggle`) nell'angolo in alto a destra.
Cliccandolo, la search box si espande. Si chiude con il pulsante X, tasto Escape, o click esterno.

## Perché il toggle

La ricerca copre troppo spazio quando aperta di default sulla mappa segnalazioni-elenco.
Il pattern toggle (lens → expand → close) è lo stesso usato dai controlli fullscreen/zoom:
i controlli mappa non occupano spazio permanente, appaiono on-demand.

## Pattern implementato

```
_searchOpen = false (default)
  → renderSearch(ctx) → solo <button class="geo-search-toggle"> con geoIcon('magnifying-glass')

Click lens → _searchOpen = true
  → renderSearch(ctx) → <div class="geo-search-expanded"> con input + search btn + close btn

Close (X, Escape, click-outside) → closeSearch(ctx) → _searchOpen = false
```

## File coinvolti

- `laravel/Modules/Geo/resources/js/components/map-picker-search.js`
  - `renderSearch(ctx)` legge `ctx._searchOpen` per lo stato toggle
  - `closeSearch(ctx)` resetta `_searchOpen` + `searchQuery` + `searchResults`
- `laravel/Modules/Geo/resources/js/components/geo-map-lit.js`
  - `_searchOpen` è una Lit reactive property (`{ type: Boolean, state: true }`)
  - Escape handler: chiude search prima di fullscreen
  - Click-outside handler: `closeSearch(this)` se click fuori dal componente

## Uso Corretto (Blade)

```html
<geo-map-lit data-url="/data/tickets.json"></geo-map-lit>
```

No attributi per la search — è sempre presente e gestita internamente.

## Verifica Playwright

- Default: `.geo-search-toggle` visibile, `.geo-search-expanded` assente
- Click lens: `.geo-search-expanded` compare, input ricevibile
- Click X o Escape: torna a solo `.geo-search-toggle`
- Fullscreen, cluster, marker restano operativi

## Cronologia

- Prima di 2026-04-30: search sempre visibile (`.geo-address-search` sempre nel DOM)
- 2026-04-30: cambiato a toggle — lens di default, expand on click (story 8-83)
