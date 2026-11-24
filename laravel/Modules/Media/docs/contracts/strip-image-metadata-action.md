---
<<<<<<< HEAD
title: "Contratto — StripImageMetadataAction"
type: contract
action: "Modules\Media\Actions\Image\StripImageMetadataAction"
tags: [contract, action, media, privacy, exif, gps]
created: 2026-11-24
updated: 2026-11-24
=======
title: "StripImageMetadataAction — contratto"
type: contract
owner: Media
status: accepted
action: "Modules\\Media\\Actions\\Image\\StripImageMetadataAction"
tags: [contract, action, immagini, exif, gps, privacy]
created: 2026-11-24
updated: 2026-11-24
qmd: "contract StripImageMetadataAction media exif gps privacy immagine MEDIA-STRIP-INV"
>>>>>>> laraxot/dev
---

# StripImageMetadataAction

<<<<<<< HEAD
Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/Image/StripImageMetadataAction.php`. Perche': [ADR](../adr/strip-image-metadata-server-side.md).
Nessun chiamante in questo repo: la usa il modulo del progetto ospite dopo il salvataggio di una foto allegata (vedi `../stories/media-mobile-camera-upload.story.md`).

## Input

- Un `Spatie\MediaLibrary\MediaCollections\Models\Media` gia' salvato, con il file sul suo `disk`.
=======
Riscrive l'originale JPEG o PNG di un media senza metadati (EXIF, posizione GPS, fotocamera, XMP, chunk di testo).

> Nel codice `app/` non risultano chiamanti (`rg StripImageMetadataAction app`: solo la definizione): l'Action non e' collegata a nessun flusso di upload; i test la esercitano direttamente.

## Input

- `Spatie\MediaLibrary\MediaCollections\Models\Media $media`: usa `mime_type`, `disk`, `getPathRelativeToRoot()`.
>>>>>>> laraxot/dev

## Output

- `void`.

## Invarianti

<<<<<<< HEAD
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
=======
- **MEDIA-STRIP-INV-1** — Per `image/jpeg` e `image/png` il file e' ricodificato con `strip: true`: GPS ed EXIF spariscono, l'orientamento EXIF e' applicato prima (la foto non ruota) e `size` del record e' aggiornato.
  Verifica non marcata: `Modules/Media/tests/Unit/Actions/Image/StripImageMetadataActionTest.php:157` e `:191`; nessun `->group('MEDIA-STRIP-INV-1')`.
- **MEDIA-STRIP-INV-2** — Per ogni altro `mime_type` (es. PDF) il file e il record restano invariati.
  Stessa verifica non marcata (`:213`).
- **MEDIA-STRIP-INV-3** — Se il file non e' leggibile dal disco (`get()` restituisce `null`) l'Action esce senza modificare nulla.
  Non coperto.

## Effetti collaterali

- Sovrascrive l'originale sul disco del media (`put`): l'operazione e' irreversibile, i metadati originali non sono conservati.
- `save()` del record con la nuova `size`.
- Qualita' JPEG fissa a 90: la ricodifica e' con perdita.

## Errori

- Le eccezioni di Intervention Image (file corrotto) e del disco si propagano.
- L'Action decide dal `mime_type` registrato, non dal contenuto: un JPEG registrato con altro mime mantiene il GPS (lo documenta il test `:225`).

## Non fa

- Non tocca conversioni o immagini responsive gia' generate.
- Non elimina metadati da PDF o altri formati.
- Non e' invocata automaticamente al caricamento.
>>>>>>> laraxot/dev
