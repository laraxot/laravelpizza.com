---
title: "GetVideoFrameContentAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Video\\GetVideoFrameContentAction"
qmd: "GetVideoFrameContentAction fotogramma video contenuto cache file un'ora immagine placeholder fallback"
---

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

## Non fa

- Un errore transitorio di FFmpeg viene servito come placeholder e memorizzato per un'ora: nessun log, nessun ritento.
- Due percorsi che producono lo stesso slug (es. `a/b` e `a-b`) condividono la chiave di cache (dubbio, non verificato).
