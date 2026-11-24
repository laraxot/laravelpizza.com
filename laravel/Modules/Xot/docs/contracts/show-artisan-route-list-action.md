---
title: "ShowArtisanRouteListAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Artisan\\ShowArtisanRouteListAction"
qmd: "ShowArtisanRouteListAction elenco rotte route list vista xot acts artisan show_route_list HTML renderizzato"
---

# ShowArtisanRouteListAction

Renderizza in HTML l'elenco delle rotte registrate, con la vista `xot::acts.artisan.show_route_list`. Sostituisce `ArtisanService::showRouteList()`. Codice: `app/Actions/Artisan/ShowArtisanRouteListAction.php:15-35`.

## Input

- Nessuno (`execute()`, riga 19). Usa le rotte correnti di `Route::getRoutes()`.

## Output

- `string`: HTML della vista renderizzata (riga 33).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `ARTISAN-ROUTES-INV-1` | La vista riceve la collection di rotte correnti, la locale attiva e il nome vista. | righe 21-28 | Test: nessuno |
| `ARTISAN-ROUTES-INV-2` | Il risultato è sempre una stringa renderizzata. | righe 30-33 | Test: nessuno |

## Effetti collaterali

Nessuno. Sola lettura delle rotte e rendering.

## Errori

- `Webmozart\Assert` lancia se `view()` non restituisce un `View` (riga 31).

## Non fa

- Non filtra né ordina le rotte.
- Marker `@contract` aggiunto nel docblock della classe.
