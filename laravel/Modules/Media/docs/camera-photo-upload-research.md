---
title: "Upload di foto da fotocamera mobile: ricerca e misure"
type: research
module: Media
created: 2026-10-27
updated: 2026-10-27
qmd: "foto fotocamera mobile upload resize filepond automaticallyResizeImagesToWidth take picture field uppy 413 limite 2 MB"
related:
  - stories/camera-photo-upload-component.story.md
  - ../../Fixcity/docs/stories/dcp-378-foto-da-fotocamera-oltre-il-limite-di-upload.story.md
---

# Upload di foto da fotocamera mobile: ricerca e misure

## Problema

Una foto da telefono pesa 3-10 MB. In produzione nginx e PHP accettano 2 MB per richiesta (impostazione Ploi, file di root).
Livewire carica il file in una sola richiesta su `/livewire-*/upload-file`: oltre 2 MB risponde 413.
Il wizard cittadino e' stato corretto in DCP-378; i circa 40 campi `FileUpload` dei pannelli admin hanno lo stesso difetto.

## Fonti studiate

| Fonte | Tecnica | Supera 2 MB senza toccare il server? | Giudizio |
|---|---|---|---|
| filament discussion 11974 | `extraInputAttributes(['capture' => 'environment'])` per aprire la fotocamera | No (non riduce) | Utile solo per aprire la fotocamera |
| Take Picture Field (emmanpbarrameda), plugin, sorgente, note | `getUserMedia`, fotogramma video su canvas, `toDataURL` JPEG in base64 nello stato | Si', perche' il fotogramma e' piccolo (1280x720) | Scartato: qualita' da video, +33% base64 a ogni richiesta Livewire, niente file, non compatibile con Media Library |
| answeroverflow 1407995948604329994 | Non letta (429 e controllo anti-bot) | | |
| Medium, haryo (event app 4) | `image()->imageEditor()`, conversioni Spatie WebP | No (lavora dopo l'upload) | Utile per lo storage, non per il limite |
| Uppy upload plugin (SpykApp), plugin e sorgente | Upload a pezzi (`blob.slice`) su `/uppy/upload`, Compressor 0.8 | Si', con `chunkSize` sotto 2 MB | **Scartato per sicurezza**: il client sceglie disco e cartella, estensione dal nome del client, nessun controllo MIME, nessuna auth oltre `web`. Carica Uppy da CDN esterno. Fallisce il controllo di sicurezza del marketplace |
| Medium, ur.syid07 | Cartelle e `FileService` | No | Non pertinente; il service viola la regola no-services |
| Medium, mamounkamal | Conversione Spatie `format('webp')->optimize()->queued()` | No | Utile dopo, non risolve |
| Filament 5.10.2 (vendor) | FilePond image-resize + image-transform + exif-orientation, gia' nel bundle | Si' | **Scelto** per i campi standard |

## Misure con il JS vero di Filament

Banco di prova: `vendor/filament/forms/dist/components/file-upload.js` eseguito in Chrome headless 155 (profilo iPhone 13),
configurazione identica a quella generata da `FileUpload::toHtml()`, file catturato in `uploadUsing` (quello che va a `$wire.upload`).
Foto di prova: JPEG 4000x3000, 9,9 MB, EXIF Orientation=6 (caso peggiore: rumore, poco comprimibile).

| Configurazione | File inviato | Esito con limite 2 MB |
|---|---|---|
| Nessun resize (oggi, tutti i campi admin) | 9,9 MB, 4000x3000, Orientation=6 | 413 |
| Resize 2048, `contain` | 1,84 MB, 1536x2048, Orientation=1 | Passa, margine stretto |
| Resize 1920, `contain` | 1,51 MB, 1440x1920 | Passa |

FilePond ruota i pixel e riscrive l'orientamento a 1: nessuna doppia rotazione con `StripImageMetadataAction` lato server.
Filament non espone la qualita' JPEG (resta il default del browser, circa 0,92).

### Perche' non un resize globale (`FileUpload::configureUsing`)

Stessa prova, resize 1920 su `image/*`:

| File | Effetto |
|---|---|
| SVG (logo) | Riscritto da FilePond (138 B diventano 595 B) |
| GIF animata | Diventa PNG statico |
| PNG piccolo 300x300 | Ricodificato e piu' pesante (363 B diventano 3059 B) |
| PNG 3000x3000 | Resta PNG, 2,7 MB: fallisce comunque |

Il resize va attivato solo sui campi che ricevono foto, non su loghi, favicon, banner o allegati CMS.

## Rischi trasversali

- iOS: con `image/heic` nell'attributo `accept` Safari consegna HEIC grezzo invece di convertirlo in JPEG.
- `capture="environment"` su Android apre solo la fotocamera: niente galleria.
- Memoria iOS: canvas a piena risoluzione su foto da 48 MP puo' fallire; il resize in un passo a 1920 px lo evita.
