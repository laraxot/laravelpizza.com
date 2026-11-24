---
title: "ConvertVideoAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Video\\ConvertVideoAction"
qmd: "ConvertVideoAction conversione video FFmpeg X264 bitrate 1000 disco salva URL"
---

# ConvertVideoAction

Converte un video su un disco in X264 a 1000 kbps e restituisce l'URL del file prodotto. Codice: `app/Actions/Video/ConvertVideoAction.php:17-42`.

## Input

- `string $disk_mp4`: disco di lettura e scrittura.
- `string $file_mp4`: video sorgente.
- `string $file_new`: percorso di destinazione sul disco.

## Output

- `string`: URL del file (`FilesystemAdapter::url()`).

## Invarianti

- **CONVERT-VIDEO-INV-1** — Il formato è `X264` con bitrate fisso di 1000 kbps.
  Test: `tests/Unit/Actions/MediaActionsCoverageTest.php:66-74` (solo classe e metodo).
- **CONVERT-VIDEO-INV-2** — L'URL restituito appartiene allo stesso disco di scrittura.
  Test: nessuno.

## Effetti collaterali

- Esegue FFmpeg in modo sincrono e scrive `$file_new` sul disco.

## Errori

- Le eccezioni di FFmpeg si propagano. `ResolveMediaExporterAction` lancia `RuntimeException` se la catena non restituisce un exporter.

## Non fa

- Non registra lo stato della conversione né il progresso.
- Non verifica che `$file_mp4` esista.
- `url()` può lanciare su dischi che non lo supportano.
