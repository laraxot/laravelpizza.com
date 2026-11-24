---
title: "ADR — I metadati delle foto si tolgono sul server ri-codificando con GD"
type: decision
module: Media
tags: [adr, media, privacy, exif, gps, gd, imagick]
created: 2026-11-24
updated: 2026-11-24
status: accepted
related:
  - ../../app/Actions/Image/StripImageMetadataAction.php
  - ../contracts/strip-image-metadata-action.md
  - ../stories/media-mobile-camera-upload.story.md
---

# ADR: i metadati delle foto si tolgono sul server ri-codificando con GD

## Contesto

- Una foto da telefono porta nell'Exif la posizione GPS, il modello del dispositivo e la data; un PNG puo' portare testo e
  XMP. Allegata a una segnalazione pubblica, rivela dove abita o si trovava chi l'ha scattata.
- La riduzione nel browser (canvas, `camera-image.js`) perde gia' l'Exif, ma non copre tutti i percorsi: upload senza
  riduzione, client diversi, PDF e immagini piccole che non vengono ridotte.
- Misura nella story `../stories/media-mobile-camera-upload.story.md` (JPEG 8000x6000, Orientation=6, `memory_limit=128M`):
  GD ok in 11,8 s con picco PHP 59 MB; Imagick ok in 19,4 s con lo stesso picco. Entrambi ruotano e tolgono l'Exif.

Domanda: dove e con quale libreria garantire che nessun metadato resti nel file salvato?

## Decisione

- `StripImageMetadataAction` (`app/Actions/Image/`) riscrive l'originale sul suo disco: Intervention Image con driver GD
  decodifica (applicando l'orientamento Exif ai pixel) e ri-codifica con `strip: true` (JPEG qualita' 90, PNG).
- Solo `image/jpeg` e `image/png`, scelti dal `mime_type` del record; ogni altro tipo resta intatto.
- Aggiorna `size` sul record. La chiama il modulo del progetto ospite dopo il salvataggio della foto.

## Alternative scartate

- Affidarsi alla riduzione nel browser: non e' una garanzia, il server riceve cio' che il client manda.
- Imagick: misurato piu' lento (19,4 s contro 11,8 s) e con lo stesso picco di memoria; l'ipotesi che servisse per restare
  sotto `memory_limit` era falsa (libgd alloca fuori dal limite PHP). Resta utile solo per leggere HEIC sul server.
- Togliere solo i tag Exif senza ri-codificare (exiftool, riscrittura dei segmenti APP1): una dipendenza di sistema in piu' e
  il rischio di lasciare blocchi che non si conoscono (XMP, chunk PNG); la ri-codifica porta via tutto cio' che non e' pixel.
- Tenere l'originale con i metadati in un disco privato: e' proprio il dato da non conservare.

## Conseguenze

- Pro: il file salvato porta solo pixel; l'orientamento resta corretto anche per viewer che ignorano l'Exif.
- Contro: ri-codifica JPEG con perdita (qualita' 90); GD non legge HEIC, che quindi non e' gestito.
- Le conversioni gia' generate prima della chiamata non vengono riscritte: chiamarla prima di generarle.

## Verifica

- `Modules/Media/tests/Unit/Actions/Image/StripImageMetadataActionTest.php` (group `MEDIA-STRIP-INV-1` ... `MEDIA-STRIP-INV-5`):
  fixture con GPS e Orientation=6 costruite byte per byte, controllo che il GPS ci fosse prima, PNG con `tEXt`/`iTXt`, PDF intatto.
