---
title: "ShowArtisanErrorLogAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Artisan\\ShowArtisanErrorLogAction"
qmd: "ShowArtisanErrorLogAction mostra log errori storage logs vista xot acts artisan error-show url basename"
---

# ShowArtisanErrorLogAction

Prepara la vista di consultazione dei log in `storage/logs`, con il contenuto del file richiesto e l'elenco degli URL trovati nel log. Sostituisce `ArtisanService::errorShow()`. Codice: `app/Actions/Artisan/ShowArtisanErrorLogAction.php:19-53`.

## Input

- Nessun argomento. Legge dalla query string il parametro `log` (riga 27).

## Output

- `Renderable` (vista `xot::acts.artisan.error-show`), con `view`, `lang`, `files`, `content`, `urls` (righe 41-49, 49).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `ARTISAN-ERRSHOW-INV-1` | Il nome del log è ridotto con `basename()`: nessun path traversal fuori da `storage/logs`. | riga 33 | Test: nessuno |
| `ARTISAN-ERRSHOW-INV-2` | Il contenuto è letto solo se `log` non è vuoto e il file esiste; altrimenti `content` è `''`. | righe 34-36 | Test: nessuno |
| `ARTISAN-ERRSHOW-INV-3` | `urls` sono i valori unici del pattern `url":"..."` nel contenuto. | righe 38-40 | Test: nessuno |
| `ARTISAN-ERRSHOW-INV-4` | `files` è l'elenco di tutti i file in `storage/logs`, non solo i `.log`. | riga 26 | Test: nessuno |

## Effetti collaterali

Sola lettura dal filesystem. Nessuna scrittura, nessuna coda, nessun servizio esterno.

## Errori

- `Webmozart\Assert` lancia se `view()` non restituisce un'istanza di `View` (riga 50).

## Non fa

- Non pagina e non limita la dimensione del file letto: `File::get` legge tutto.
- Non filtra per livello di errore.
- Marker `@contract` aggiunto nel docblock della classe.
