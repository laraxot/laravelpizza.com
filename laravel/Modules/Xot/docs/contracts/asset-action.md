---
title: "AssetAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\File\\AssetAction"
qmd: "AssetAction URL asset pubblico modulo tema public resources symlink assets themes eccezione test bench"
---

# AssetAction

Risolve l'URL pubblico di un asset, secondo namespace (modulo o tema) e presenza del file. Non copia nulla: gli asset sono serviti da symlink. Codice: `app/Actions/File/AssetAction.php:14-129`.

## Input

- `string $path`: asset, con o senza namespace (`execute`, riga 28), es. `Xot::img/logo.svg` o `/img/x.png`.

## Output

- `string`: URL relativo (senza host) dell'asset (righe 28-54, 122-128).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `FILE-ASSET-INV-1` | Un URL `http://` o `https://` è restituito invariato. | righe 32-34 | `tests/Unit/Actions/File/FileActionsTest.php:54`; `tests/Unit/Actions/File/AssetActionsTest.php` |
| `FILE-ASSET-INV-2` | Se `public_path($path)` esiste, è restituito `$path` invariato. | righe 36-38 | come sopra |
| `FILE-ASSET-INV-3` | Senza `::`, il namespace è `adm_theme` in area admin, altrimenti `pub_theme`. | righe 40-45 | come sopra |
| `FILE-ASSET-INV-4` | Namespace `pub_theme`/`adm_theme`: URL `themes/{tema}/{percorso}` senza verificare che il file esista. | righe 49-51, 75-81 | come sopra |
| `FILE-ASSET-INV-5` | Namespace modulo: se `Modules/{M}/public/{file}` esiste, URL `assets/{m-minuscolo}/{file}`. Altrimenti, se `resources/{file}` esiste, stesso URL. | righe 86-113 | come sopra |
| `FILE-ASSET-INV-6` | Se il file non esiste in nessuna delle due cartelle: in TestBench restituisce il percorso originale, altrove `\Exception`. | righe 106-111 | come sopra |
| `FILE-ASSET-INV-7` | Nel percorso, il primo punto del segmento iniziale diventa `/`, e un `/` iniziale è rimosso. | righe 59-70 | come sopra |

## Effetti collaterali

Nessuna scrittura. Legge `XotData::make()` e il filesystem. `publicUrl()` usa `asset()` e rimuove l'host.

## Errori

- `\Exception` per asset di modulo assente fuori da TestBench. Il messaggio cita il percorso in `public/`, anche quando la ricerca ha riguardato `resources/`.
- `Webmozart\Assert` lancia se il nome del tema non è una stringa.

## Non fa

- Non copia i file: la copia per richiesta è stata rimossa (docblock, righe 116-121).
- Non verifica l'esistenza dei file di tema (`INV-4`).
- Marker `@contract` aggiunto nel docblock della classe.
