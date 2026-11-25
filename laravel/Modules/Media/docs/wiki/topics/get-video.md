---
title: "Topic get-video"
type: digest
status: active
qmd: "digest ceiling 100 get-video"
---

# Topic get-video

Sintesi automatica di 4 documenti (chiave `get-video`).

## GetVideoDurationAction

_Fonte: `contracts/get-video-duration-action.md`_

# GetVideoDurationAction

Restituisce la durata in secondi di un video sul disco. Codice: `app/Actions/Video/GetVideoDurationAction.php:14-25`.

## Input

- `string $disk`, `string $file`.

## Output

- `?int`: `null` se il file non esiste; altrimenti la durata restituita da `getDurationInSeconds()`.

## Invarianti

- **GET-VIDEO-DURATION-INV-1** — File assente → `null`, senza avviare FFmpeg.
  Test: nessuno sul comportamento; `tests/Unit/Actions/MediaActionsCoverageTest.php:158-164` verifica solo classe e metodo.

## Effetti collaterali

- Lettura del file tramite FFprobe. Nessuna scrittura.

## Errori

- Le eccezioni di FFmpeg su file corrotto si propagano.

## Non fa

- Non cachea il risultato.

## GetVideoFrameContentAction

_Fonte: `contracts/get-video-frame-content-action.md`_

# GetVideoFrameContentAction

Restituisce il contenuto binario del fotogramma a un dato secondo, in cache per un'ora. Se FFmpeg fallisce restituisce un'immagine segnaposto. Codice: `app/Actions/Video/GetVideoFrameContentAction.php:17-49`.

## Input

- `string $disk_mp4`, `string $file_mp4`: video.
- `int $time`: secondo del fotogramma.

## Output

- `?string`: contenuto binario del frame; `''` se il file non esiste; contenuto di `img/video_not_exists.jpg` (disco `public_html`) se FFmpeg fallisce.

## Invarianti

- **GET-VIDEO-FRAME-CONTENT-INV-1** — File assente → `''` senza avviare FFmpeg.
  Test: `tests/Unit/Actions/MediaActionsCoverageTest.php:140-146` (solo classe e metodo).
- **GET-VIDEO-FRAME-CONTENT-INV-2** — Il risultato, anche il placeholder, è salvato nel store `file` per 3600 secondi con chiave `Str::slug` di disco, file e secondo.
  Test: nessuno.

## Effetti collaterali

- Scrittura nello store di cache `file`. Esecuzione FFmpeg quando la cache è vuota.

## Errori

- Qualsiasi `Exception` di FFmpeg è catturata senza log e sostituita dal placeholder.
- Se il placeholder manca sul disco, `get()` lancia.

## GetVideoScreenshotAction

_Fonte: `contracts/get-video-screenshot-action.md`_

# GetVideoScreenshotAction

Classe senza logica: dichiara solo la proprietà `$backoff = 3` e usa il trait `QueueableAction`. Codice: `app/Actions/Video/GetVideoScreenshotAction.php:12-21`.

## Input

- Nessuno.

## Output

- Nessuno.

## Invarianti

- **GET-VIDEO-SCREENSHOT-INV-1** — La classe non espone `execute()`: una chiamata diretta fallisce con `Call to undefined method`.
  Test: `tests/Unit/Actions/MediaActionsCoverageTest.php:122-128` verifica solo la proprietà `backoff`.

## Effetti collaterali

- Nessuno.

## Errori

- `Error` di PHP alla chiamata di `execute()`.

## Non fa

- Non genera screenshot. Nessun chiamante in `app/`, `Modules/` o `config/` (verificato con grep): è uno stub.

## Topic get-video

_Fonte: `wiki/topics/get-video.md`_

# Topic get-video

Sintesi automatica di 4 documenti (chiave `get-video`).

## GetVideoDurationAction

_Fonte: `contracts/get-video-duration-action.md`_

# GetVideoDurationAction

Restituisce la durata in secondi di un video sul disco. Codice: `app/Actions/Video/GetVideoDurationAction.php:14-25`.

## Input

- `string $disk`, `string $file`.

## Output

- `?int`: `null` se il file non esiste; altrimenti la durata restituita da `getDurationInSeconds()`.

## Invarianti

- **GET-VIDEO-DURATION-INV-1** — File assente → `null`, senza avviare FFmpeg.
  Test: nessuno sul comportamento; `tests/Unit/Actions/MediaActionsCoverageTest.php:158-164` verifica solo classe e metodo.

## Effetti collaterali

- Lettura del file tramite FFprobe. Nessuna scrittura.
