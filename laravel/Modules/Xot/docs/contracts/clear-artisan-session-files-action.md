---
title: "ClearArtisanSessionFilesAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Artisan\\ClearArtisanSessionFilesAction"
qmd: "ClearArtisanSessionFilesAction svuota sessioni file framework sessions senza estensione artisan"
---

# ClearArtisanSessionFilesAction

Cancella i file di sessione su disco in `storage/framework/sessions`. Sostituisce `ArtisanService::sessionClear()`. Codice: `app/Actions/Artisan/ClearArtisanSessionFilesAction.php:13-29`.

## Input

- Nessuno (`execute()`, riga 17). Percorso fisso: `storage_path('framework/sessions')`.

## Output

- `string`: `Session cleared! (N Files )`, dove `N` è il numero di file trovati (riga 27).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `ARTISAN-SESSION-INV-1` | Vengono cancellati solo i file senza estensione (`getExtension() === ''`) con percorso reale valido. | righe 19-25 | Test: nessuno |
| `ARTISAN-SESSION-INV-2` | `N` è il conteggio di tutti i file trovati, non dei cancellati. | righe 19, 27 | Test: nessuno |

## Effetti collaterali

Cancellazione fisica dei file di sessione con `File::delete`, senza controllo dell'esito. Gli utenti con sessione su file perdono la sessione.

## Errori

- Nessuna eccezione propria. Dubbio come per `ClearArtisanDebugbarFilesAction`.

## Non fa

- Non verifica che la cartella sia quella del driver di sessione configurato: il percorso è fisso.
- Marker `@contract` aggiunto nel docblock della classe.
