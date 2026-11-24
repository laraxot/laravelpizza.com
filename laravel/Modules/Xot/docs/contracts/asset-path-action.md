---
title: "AssetPathAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\File\\AssetPathAction"
qmd: "AssetPathAction percorso disco asset public_path modulo resources query string logo email allegato"
---

# AssetPathAction

Restituisce il percorso su disco di un asset: sotto la document root per gli URL pubblici, sotto `resources/` del modulo per `Modulo::file`. Codice: `app/Actions/File/AssetPathAction.php:17-36`.

## Input

- `string $asset`: `Modulo::file` oppure un percorso pubblico, anche con query o frammento (`execute`, riga 21).

## Output

- `string`: percorso su disco (righe 23-35).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `FILE-ASSETPATH-INV-1` | Senza `::`: query e frammento sono tolti e lo slash iniziale è rimosso; il risultato è `public_path(...)`. | righe 23-28 | `tests/Unit/Actions/File/FileActionsTest.php:49`; `tests/Unit/Actions/File/AssetActionsTest.php:111` |
| `FILE-ASSETPATH-INV-2` | Con `::`: `Module::getModulePath($ns) . 'resources' . '/' . $file`. | righe 31-34 | come sopra |
| `FILE-ASSETPATH-INV-3` | Il primo `::` separa namespace e file; i successivi restano nel nome file. | riga 31 | Test: nessuno |

## Effetti collaterali

Nessuno.

## Errori

- Nessuna eccezione propria. Le eccezioni di nwidart per modulo inesistente si propagano.

## Non fa

- Non verifica che il file esista.
- Concatena `resources` senza separatore: dipende dal trailing slash di nwidart.
- Marker `@contract` aggiunto nel docblock della classe.
