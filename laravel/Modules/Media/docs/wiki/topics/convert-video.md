---
title: "Topic convert-video"
type: digest
status: active
qmd: "digest ceiling 100 convert-video"
---

# Topic convert-video

Sintesi automatica di 4 documenti (chiave `convert-video`).

## ConvertVideoAction

_Fonte: `contracts/convert-video-action.md`_

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

## ConvertVideoByConvertDataAction

_Fonte: `contracts/convert-video-by-convert-data-action.md`_

# ConvertVideoByConvertDataAction

Converte un video secondo un `ConvertData` (formato e nome di uscita) e restituisce il percorso del file prodotto. Codice: `app/Actions/Video/ConvertVideoByConvertDataAction.php:19-52`.

## Input

- `ConvertData $data`: fornisce `exists()`, `getFFMpegFormat()`, `getConvertedFilename()`, `disk`, `file`.

## Output

- `string`: il nome del file convertito (percorso, non URL).

## Invarianti

- **CONVERT-VIDEO-BY-CONVERT-DATA-INV-1** — Sorgente inesistente → `Exception('Il file non esiste')` prima di ogni elaborazione.
  Test: `tests/Unit/Actions/MediaActionsCoverageTest.php:86-92` (solo struttura).
- **CONVERT-VIDEO-BY-CONVERT-DATA-INV-2** — Nome di uscita vuoto → `Exception`.
  Test: nessuno.

## Effetti collaterali

- Esegue FFmpeg in modo sincrono con preset `ultrafast` e scrive l'output sul disco. Nessun aggiornamento del database.

## Errori

- `Exception` generiche per sorgente mancante o nome di uscita vuoto. Le eccezioni di FFmpeg si propagano.

## Non fa

## ConvertVideoByMediaConvertAction

_Fonte: `contracts/convert-video-by-media-convert-action.md`_

# ConvertVideoByMediaConvertAction

Converte un video secondo `ConvertData` e aggiorna il record `MediaConvert` con il progresso, fino allo stato `completed`. Codice: `app/Actions/Video/ConvertVideoByMediaConvertAction.php:21-64`.

## Input

- `ConvertData $data`: come in `ConvertVideoByConvertDataAction`.
- `MediaConvert $record`: il record da aggiornare; `converted_file` è il percorso di uscita.

## Output

- `string`: `converted_file` del record.

## Invarianti

- **CONVERT-VIDEO-BY-MEDIA-CONVERT-INV-1** — Ad ogni avanzamento di FFmpeg il record riceve `percentage`, `remaining`, `rate`.
  Test: `tests/Unit/Actions/MediaActionsCoverageTest.php:104-110` (solo struttura).
- **CONVERT-VIDEO-BY-MEDIA-CONVERT-INV-2** — Lo stato `completed` è scritto solo dopo un `save()` riuscito.
  Test: nessuno.
- **CONVERT-VIDEO-BY-MEDIA-CONVERT-INV-3** — Sorgente inesistente o `converted_file` vuoto → `Exception`.
  Test: nessuno.

## Effetti collaterali

- Un `UPDATE` sul record per ogni tick di progresso, più un `UPDATE` finale di `status`.
- FFmpeg eseguito in modo sincrono, file scritto sul disco.

## Errori

## Topic convert-video

_Fonte: `wiki/topics/convert-video.md`_

# Topic convert-video

Sintesi automatica di 4 documenti (chiave `convert-video`).

## ConvertVideoAction

_Fonte: `contracts/convert-video-action.md`_

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
