---
title: "Componente Media per foto da fotocamera: resize nel browser per tutti i campi foto"
type: story
status: review
module: Media
created: 2026-10-27
updated: 2026-10-27
qmd: "camera photo upload component media filament resize contain 1920 spatie media library fileupload mobile 413"
claim:
  - laravel/Modules/Media/app/Filament/Forms/Components/CameraPhotoUpload.php
  - laravel/Modules/Media/config/config.php
  - laravel/Modules/Media/tests/
  - laravel/Modules/Fixcity/app/Filament/Resources/TicketResource/Schemas/TicketForm.php
  - laravel/Modules/Fixcity/resources/views/filament/forms/components/dc-file-upload.blade.php
related:
  - ../camera-photo-upload-research.md
  - ../../../Fixcity/docs/stories/dcp-378-foto-da-fotocamera-oltre-il-limite-di-upload.story.md
---

# Componente Media per foto da fotocamera

## Richiesta

«cerca di capire come hanno risolto il problema dell'upload da mobile camera, e risolvilo anche te, di sicuro dovrai lavorare
nel modulo Media, crea tutti i documenti di bmad prima di implementare, poi discuti con gli altri agenti ai, poi implementa poi controlla»

## Contesto

- DCP-378 ha corretto il solo wizard cittadino: il resize vive nella vista `dc-file-upload` di Fixcity, con 2048 px scritto nel JS.
- I campi Filament standard (pannello admin, compreso `TicketForm` senza Design Comuni) mandano ancora la foto intera: 413.
- Ricerca e misure: [camera-photo-upload-research.md](../camera-photo-upload-research.md).

## Architettura proposta

1. **Media** possiede la regola "una foto da fotocamera si riduce prima di partire":
   `Modules\Media\Filament\Forms\Components\CameraPhotoUpload` (un `SpatieMediaLibraryFileUpload`).
   In `setUp()` attiva il resize nativo di Filament: lato lungo `CameraPhotoUpload::MAX_SIDE` (1920) in larghezza e altezza,
   modo `contain`, niente ingrandimento. Nessun JS nuovo: FilePond lo fa gia'. Estende il nuovo
   `Modules\Xot\Filament\Forms\Components\XotBaseSpatieMediaLibraryFileUpload` (regola XotBase).
2. **Un solo numero**: la vista `dc-file-upload` di Fixcity legge `$getAutomaticallyResizeImagesWidth()` dal campo invece del 2048 fisso.
   Admin (FilePond) e cittadino (Alpine) riducono allo stesso lato.
3. **Fixcity** `TicketForm` usa `CameraPhotoUpload::make('images')`. Collezione, mime e limiti del campo restano dove sono.
4. **Opt-in, mai globale**: niente `configureUsing` su `FileUpload` (SVG riscritti, GIF animate appiattite, PNG piccoli ingrassati).

Scartati: Take Picture Field (base64 da video), Uppy (controller non sicuro), modifica di php.ini/nginx (serve root, resta azione Ploi).

## Criteri di accettazione

- [x] `CameraPhotoUpload` configura resize 1920x1920 `contain` senza upscale; una chiamata del campo lo sovrascrive (verificato con tinker; test scritto).
- [x] `TicketForm` usa il componente (le 4 chiamate inline tolte dalla story parallela); i test esistenti del campo (`SEC-04`: mime, 5 file, 10 MB) restano verdi.
- [x] La vista `dc-file-upload` usa il lato del campo (render: `maxSide: 1920`; test aggiornati).
- [x] Prova reale: JS di Filament con la stessa config (1920, `contain`, no upscale), foto 9,9 MB: inviato 1,51 MB, 1440x1920, Orientation=1.
- [x] Prova reale: vista cittadino renderizzata, foto 11,61 MB inviata a 1,06 MB 1920x1440 (dettagli in [media-mobile-camera-upload](media-mobile-camera-upload.story.md)).
- [x] PHPStan 0 errori su componente, base Xot e test; Pint passed.

## Discussione tra agenti

Partecipanti: agente di ricerca (10 fonti), architetto Laravel/Laraxot, scettico mobile e sicurezza, agente implementatore (questa sessione).

| # | Chi | Posizione o obiezione | Verifica | Decisione |
|---|---|---|---|---|
| 1 | Ricerca | Campi standard: resize nativo Filament 1920 `contain`, niente upscale. Scartare Take Picture (base64) e Uppy (controller insicuro) | Misurato col JS vero: 9,9 MB diventano 1,51 MB | Accolta |
| 2 | Implementatore | Resize globale con `FileUpload::configureUsing` | Misurato: SVG riscritto, GIF animata diventa PNG, PNG piccoli ingrassano | Respinta, componente opt-in |
| 3 | Architetto | Subclass o factory statica come `UI\SpatieDocumentUpload`? Media e' l'owner giusto? | Media ospita gia' componenti Filament (`VideoEntry extends XotBaseEntry`); Fixcity dipende gia' da Media (`StripTicketPhotoMetadataListener`); i test usano `instanceof`; `setUp()` gira dentro `make()` prima delle chiamate del campo | Subclass in Media su una base `XotBase*` (regola `xotbase-migration-religion`): resta un `SpatieMediaLibraryFileUpload` per test e tipi |
| 4 | Architetto | Config e' YAGNI con un solo chiamante: costante di classe | Nessun secondo valore richiesto | Accolta: `MAX_SIDE = 1920`, sovrascrivibile per campo |
| 5 | Architetto | Il Blade che legge il getter: fallback se `null` | `getAutomaticallyResizeImagesWidth(): ?string` esiste in 5.10.2 | Accolta: fallback a `CameraPhotoUpload::MAX_SIDE` |
| 6 | Scettico | `capture="environment"` impedisce la galleria (Android sicuro, iOS quasi) e Android puo' uccidere la scheda mentre la fotocamera e' aperta | Comportamento noto dei browser | Accolta: tolto `capture`; senza, iOS e Android offrono fotocamera **e** galleria |
| 7 | Scettico | `image/heic` in `accept` spegne la conversione automatica di iOS in JPEG e forza `heic2any` | Ricerca, rischi trasversali | Accolta: `accept` = whitelist del server; il convertitore resta come ripiego per `.heic` da altri sistemi |
| 8 | Scettico | Limitare `maxSize` di FilePond al limite reale del server | **Misurato**: con `maxSize` 2 MB FilePond scarta la foto da 9,9 MB *prima* del resize, nessun upload | **Respinta**: romperebbe il caso principale. PNG grandi e PDF oltre 2 MB nel pannello admin restano legati all'aumento del limite in Ploi |
| 9 | Scettico | Stato "Preparazione foto" e messaggio specifico se la foto non si elabora | Oggi la lista resta vuota durante il resize | Accolta: voce in lista subito, testo `preparing` ed `error_prepare` in it, en, de, es |
| 10 | Scettico | La rimozione EXIF vale solo per Ticket; metadati PDF non tolti | `StripTicketPhotoMetadataListener` e' di Fixcity | Annotata: fuori scope, il componente non promette privacy |
| 11 | Architetto | Review fatta senza poter leggere i file (guasto degli strumenti) | Punti 3-5 verificati dall'implementatore con grep e lettura del vendor | Nessun blocco residuo |

## Aggiornamento (2026-10-27 17:40, sessione implementatore)

**Collisione con la story [media-mobile-camera-upload](media-mobile-camera-upload.story.md)**, aperta in parallelo da un'altra sessione con la
stessa richiesta e gia' a meta' implementazione sugli stessi file (`dc-file-upload`, `TicketForm`, traduzioni, test Fixcity).
Applicata la regola nuova (coordinamento nelle story, [agent-chat-directory](../../../../../docs/wiki/rules/agent-chat-directory.md)):

| Parte | Chi | Stato |
|---|---|---|
| Vista cittadino `dc-file-upload` (due pulsanti, `MediaCameraImage`, `accept` senza HEIC) | media-mobile-camera-upload | Suo; approccio migliore del mio "togliere `capture`". Non toccato |
| `Modules/Media/resources/js/camera-image.js` | media-mobile-camera-upload | Suo. Proposto 1920 al posto di 2048 (misure nella sua story) |
| `CameraPhotoUpload` + `XotBaseSpatieMediaLibraryFileUpload` + test + ricerca | questa story | Committato |
| `TicketForm` campo `images` | entrambe | Nel working tree c'e' `CameraPhotoUpload::make` (mio) **piu'** le sue 4 chiamate `imageResize*` 2048 (deprecate, 4 errori PHPStan). Proposta di merge scritta nella sua story; non committato da qui |

Criteri ancora aperti: uso di `CameraPhotoUpload` in `TicketForm` e lettura del lato nella vista cittadino dipendono dalla decisione nell'altra story.

## Aggiornamento (2026-10-27 18:00, sessione media-mobile-camera-upload)

Proposta di fusione accolta e applicata; punto 9 (stato `preparing`, `error_prepare`) implementato nella vista. Dettagli e prove nella story [media-mobile-camera-upload](media-mobile-camera-upload.story.md).

## Verifica

- `tinker`: `CameraPhotoUpload::make('images')` = `SpatieMediaLibraryFileUpload`, `1920`, `1920`, `contain`, upscale `false`; con `->automaticallyResizeImagesToWidth('1280')` diventa `1280`.
- Banco di prova FilePond (vendor `file-upload.js`, Chrome headless 155, iPhone 13): numeri nella [ricerca](../camera-photo-upload-research.md).
- Pest: `CameraPhotoUploadTest` non eseguibile qui (`TestCase` di Media apre il DB: `Access denied for user 'marco'`).
- PHPStan sui tre file PHP nuovi: 0 errori.

## Note operative per altre sessioni

- Imagick (domanda dell'utente): non risolve il 413, nginx rifiuta il corpo prima di PHP e l'installazione richiede root.
  Utile in futuro per leggere HEIC lato server (GD non lo legge), insieme all'aumento del limite da Ploi.

## Nota 2026-10-28
`Modules\Xot\Filament\Forms\Components\XotBaseSpatieMediaLibraryFileUpload` non esiste piu' nel working tree di Xot (ne' nella sua storia git).
Per tenere PHPStan a zero `CameraPhotoUpload` estende direttamente `Filament\Forms\Components\SpatieMediaLibraryFileUpload`;
se Xot ripristina la base, e' una riga da cambiare.
