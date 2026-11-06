---
title: "DCP-429: conversione HEIC lato server, decisione su Imagick"
type: story
status: needs-decision
module: Media
created: 2026-10-27
updated: 2026-10-27
tags: [bmad, story, media, imagick, heic, gd, decisione]
qmd: "imagick heic libheif gd image_driver conversione lato server fixcity.eu exif privacy decisione"
related:
  - ../bmad/stories/fix-mobile-camera-upload.story.md
  - ../../../Fixcity/docs/bmad/stories/mobile-camera-upload.story.md
issues: []
discussions: []
---

# DCP-429: Imagick lato server?

In attesa dell'utente. L'utente ha chiesto (2026-10-27) se installare Imagick sarebbe stato piu' semplice. Per l'errore segnalato non lo sarebbe: il rifiuto (422 o 413) avviene prima di qualunque codice PHP, quindi un ridimensionamento lato server non vede mai il file. Imagick servirebbe solo dopo l'upload.

## Fatti misurati

- Su questa macchina `php -m` mostra `gd`, `exif`, `fileinfo`; Imagick non e' caricato. GD ha WebP e AVIF.
- `config/media-library.php:207`: `'image_driver' => env('IMAGE_DRIVER', 'gd')`.
- `TicketForm` accetta `image/jpeg`, `image/png`, `application/pdf`. Il browser converte HEIC in JPEG con `heic2any` (caricato su richiesta) e riduce le foto prima dell'upload.
- La produzione (fixcity.eu, altro server) non e' stata ispezionata: non si sa se ha Imagick ne' se la build include il delegato HEIC (libheif).

## Domande da chiudere

1. Cosa fa il client con una foto gia' sotto la soglia di peso: la ricodifica (e quindi perde i metadati EXIF, compresa la posizione GPS) o la invia intatta? Le foto delle segnalazioni sono pubbliche: se partono con EXIF, la posizione puo' finire online. Da verificare nel codice di `camera-upload.js` e con un file con GPS.
2. Serve una rete di sicurezza lato server per HEIC quando il decoder del browser non e' disponibile?
3. Il server ripulisce i metadati delle immagini caricate, con GD (che ricodifica e non conserva EXIF) o con altro?

## Acceptance criteria

1. Domanda 1 chiusa con una prova: un JPEG con GPS passa dal flusso reale e il file salvato si ispeziona (`exiftool` o `exif_read_data`); l'esito e' scritto qui.
2. L'utente decide: (a) niente Imagick, solo browser e GD; (b) Imagick come fallback HEIC lato server, con requisiti (estensione, libheif, `policy.xml` di ImageMagick, memoria e tempo limite); (c) altro.
3. Se (b): la richiesta di installare un pacchetto di sistema e' fatta all'utente, che la esegue o la autorizza; niente `apt` dal repo. Il passaggio da `gd` a `imagick` dell'`image_driver` e' valutato sulle conversioni esistenti di medialibrary.
4. Se (a): nota nella story madre che la scelta e' consapevole.
5. Se la domanda 1 mostra EXIF in uscita, si apre una story di sicurezza a parte con priorita' alta.

## Tasks

- [ ] Rispondere alla domanda 1 con una prova.
- [ ] Presentare le opzioni all'utente con la raccomandazione ponytail: (a) finche' non c'e' un bisogno misurato.
- [ ] Registrare la decisione e chiudere o riscrivere in `ready-for-dev`.

## Owned file scope

`laravel/Modules/Media/` e `laravel/config/media-library.php` solo se la decisione e' (b).

## Coordinamento

| Data | Agente | Scope | Nota |
|------|--------|-------|------|
| 2026-10-27 | Claude | stesura | nessuna installazione eseguita |
