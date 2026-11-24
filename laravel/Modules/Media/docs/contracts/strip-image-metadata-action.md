---
title: "Contratto — StripImageMetadataAction"
type: contract
action: "Modules\Media\Actions\Image\StripImageMetadataAction"
tags: [contract, action, media, privacy, exif, gps]
created: 2026-11-24
updated: 2026-11-24
---

# StripImageMetadataAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/Image/StripImageMetadataAction.php`. Perche': [ADR](../adr/strip-image-metadata-server-side.md).
Nessun chiamante in questo repo: la usa il modulo del progetto ospite dopo il salvataggio di una foto allegata (vedi `../stories/media-mobile-camera-upload.story.md`).

## Input

- Un `Spatie\MediaLibrary\MediaCollections\Models\Media` gia' salvato, con il file sul suo `disk`.

## Output

- `void`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| MEDIA-STRIP-INV-1 | Un JPEG esce senza Exif ne' GPS e con l'orientamento Exif gia' applicato ai pixel (larghezza e altezza scambiate per Orientation=6). | `MEDIA-STRIP-INV-1` |
| MEDIA-STRIP-INV-2 | Un PNG esce senza chunk `tEXt`/`iTXt` (testo, XMP), con le stesse dimensioni. | `MEDIA-STRIP-INV-2` |
| MEDIA-STRIP-INV-3 | Un mime diverso da `image/jpeg` e `image/png` (PDF, ...) resta identico byte per byte e il record non cambia. | `MEDIA-STRIP-INV-3` |
| MEDIA-STRIP-INV-4 | Dopo la riscrittura la colonna `size` del record e' la dimensione del nuovo file. | `MEDIA-STRIP-INV-4` |
| MEDIA-STRIP-INV-5 | La scelta si fa sul `mime_type` del record, non sul contenuto: un JPEG registrato come `application/octet-stream` non viene toccato. | `MEDIA-STRIP-INV-5` |

## Effetti collaterali

- Sovrascrive il file originale sul disco del media (`getPathRelativeToRoot()`), stesso percorso.
- `UPDATE media SET size = ...`.

## Errori

- File mancante sul disco: ritorna senza fare nulla.
- Immagine non decodificabile da GD: l'eccezione di Intervention Image risale al chiamante.

## Non fa

- Non tocca conversioni e immagini responsive gia' generate (vanno rigenerate dopo, se servono).
- Non converte formati (HEIC, WEBP restano come sono: il mime non e' gestito).
- Non conserva una copia dell'originale con i metadati: la posizione e' persa per sempre, ed e' voluto.
- JPEG ri-codificato a qualita' 90: non e' una copia lossless.
