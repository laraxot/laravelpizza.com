---
title: "Media: foto da fotocamera mobile, scelta galleria e riduzione nel browser"
type: story
status: review
priority: P1
module: Media
created: 2026-10-27
updated: 2026-10-27
tags: [bmad, story, media, upload, fotocamera, mobile, capture, filepond, heic, livewire]
qmd: "upload fotocamera mobile capture environment galleria filepond imageResizeTargetWidth heic riduzione foto 2 MB"
related:
  - ../../../Fixcity/docs/stories/dcp-378-foto-da-fotocamera-oltre-il-limite-di-upload.story.md
  - ../../../Fixcity/resources/views/filament/forms/components/dc-file-upload.blade.php
  - ../../../../Themes/Sixteen/resources/js/components/camera-upload.js
---

# Media: foto da fotocamera mobile, scelta galleria e riduzione nel browser

> **Obsoleto: `npm run copy` non esiste piu' (2026-11-11).** Gli asset dei temi
> arrivano nella document root con un symlink, non con una copia. Per il
> procedimento valido vedi
> [Xot/docs/theme-assets-workflow.md](/laravel/Modules/Xot/docs/theme-assets-workflow.md).
> Le istruzioni di copia qui sotto sono lasciate come documentazione storica.

Fase BMAD: Analisi, Solutioning, Dev, Verifica.

## Richiesta

Come cittadino che segnala da telefono voglio scattare una foto **oppure** scegliere una foto o un PDF gia' salvati,
e voglio che il caricamento riesca anche se la foto pesa 4-8 MB.
Come operatore nel pannello admin voglio lo stesso dal campo allegati del ticket.

## Ricerca (fonti studiate)

| Fonte | Come risolve | Cosa prendiamo |
|---|---|---|
| [filament#11974](https://github.com/filamentphp/filament/discussions/11974) | `->extraInputAttributes(['capture' => 'environment'])`: il telefono apre la fotocamera. Il core non lo prevede per il desktop. Chiesta la riduzione prima dell'upload | `capture`, ma **non** sull'unico input: vedi difetto 1 |
| [filament-take-picture-field](https://github.com/emmanpbarrameda/filament-take-picture-field) (v1.4) | `getUserMedia` + `<video>` + canvas, stato Livewire come data URL base64, salvato con `Storage::put` in `dehydrateStateUsing`. Opzioni `captureMaxDimensions`, `imageQuality`. Serve HTTPS | La riduzione lato client (lato massimo, qualita' JPEG). Scartato il resto, vedi sotto |
| [dev-notes take-picture](https://emmanpbarrameda.github.io/dev-notes/filament-take-picture-field/) | `getUserMedia` solo in contesto sicuro (HTTPS o localhost) | Nota: niente `crypto.randomUUID` fuori da HTTPS (gia' rispettato) |
| [uppy-upload-plugin](https://github.com/SpykApp/uppy-upload-plugin) | Uppy (Webcam, Compressor) e **upload a blocchi da 5 MB** su rotte proprie per superare i limiti nginx/Cloudflare | Idea dei blocchi annotata per i PDF; non adottata ora |
| answeroverflow, Medium (3 articoli) | Non leggibili (HTTP 429/403) | Nessuna |

## Stato misurato (prima)

1. Wizard pubblico `dc-file-upload.blade.php`: un solo input con `multiple` **e** `capture="environment"`.
   Su Android Chrome e iOS Safari `capture` apre direttamente la fotocamera: il cittadino non puo' scegliere
   una foto dalla galleria ne' un PDF, anche se il campo li accetta. Test attuale lo blinda (`assertSame('environment', capture)`).
2. Riduzione foto (DCP-378): logica scritta inline nella vista Fixcity, HEIC in `Themes/Sixteen/resources/js/components/camera-upload.js`.
   Non riusabile da altri moduli.
3. Pannello admin (`TicketForm`, ramo non Design Comuni): `SpatieMediaLibraryFileUpload` FilePond senza riduzione.
   Foto da 4 MB, limite server 2 MB (nginx + PHP, vedi DCP-378): HTTP 413.

## Decisioni (Ponytail)

| Problema | Soluzione | Perche' |
|---|---|---|
| `capture` blocca galleria e PDF | Due pulsanti: "Scatta una foto" (input `capture="environment"`, `accept="image/*"`) e "Scegli file" (input senza `capture`, `multiple`, mime del campo) | Schema nativo: la fotocamera del sistema ha messa a fuoco, flash, HDR; nessuna dipendenza, nessun HTTPS richiesto |
| Logica di riduzione chiusa in Fixcity | Modulo JS `Modules/Media/resources/js/camera-image.js`: `window.MediaCameraImage.normalize(file)` (HEIC -> JPEG con `heic2any` caricato solo se serve, poi lato lungo 2048 px JPEG 0,85 sopra 1 MB). Il tema lo importa con `@modules` come per Geo | Media e' il proprietario degli upload; un solo punto per tutti i moduli |
| Admin FilePond senza riduzione | `CameraPhotoUpload::make('images')` (Media, story parallela [camera-photo-upload-component](camera-photo-upload-component.story.md)): resize nativo FilePond 1920 `contain`, senza upscale | Funzione gia' presente in Filament 5 (plugin FilePond image-transform); il limite `maxSize` si controlla prima della riduzione, quindi resta 10 MB |

Scartati:

- `filament-take-picture-field` / `getUserMedia`: anteprima a bassa risoluzione, permessi del browser, stato base64
  nel payload Livewire (soggetto allo stesso limite di 2 MB), non gestisce galleria ne' PDF. Utile solo per webcam desktop: YAGNI.
- Uppy / upload a blocchi: risolverebbe i PDF oltre 2 MB, ma aggiunge rotte, riassemblaggio e un secondo flusso accanto a Livewire.
  La via semplice resta alzare il limite da Ploi (azione del proprietario, DCP-378).
- `capture` nel campo admin: blocca i PDF su mobile, stesso difetto 1.

## Criteri di accettazione

- [x] Wizard: due input file; solo quello della fotocamera ha `capture="environment"` (senza `multiple`, `accept="image/*"`); quello "Scegli file" ha `multiple` e solo i mime del campo.
- [x] Accessibilita': gruppo con `role="group"`, input fuori dal Tab, pulsanti senza `aria-label`.
- [x] Wizard: entrambi passano dalla stessa coda (`pick`) e da `window.MediaCameraImage.normalize`.
- [x] `Modules/Media/resources/js/camera-image.js` esiste; `Themes/Sixteen/resources/js/components/camera-upload.js` rimosso; `window.FixcityCameraUpload` non piu' usato.
- [x] Build del tema riuscita; `heic2any` resta in un chunk separato.
- [x] Admin: il campo `images` ha resize 2048 contain senza upscale.
- [x] Una foto JPEG 4000x3000 da circa 10 MB esce dal modulo sotto 2 MB, orientata (Chrome headless, profilo iPhone).
- [x] PHPStan 0 errori sui file PHP toccati; test Pest aggiornati.

## Discussione con altri agenti

Due revisori indipendenti hanno letto story e codice prima dell'implementazione. Entrambi: "approvo con modifiche".

| Agente | Osservazione | Esito |
|---|---|---|
| Architettura Laravel | `heic2any` sta solo in `Themes/Sixteen/node_modules`: importato da `Modules/Media` la build fallisce senza `resolve.dedupe` | **Accolto**: `heic2any` in `dedupe` |
| Architettura Laravel | FilePond valida `maxFileSize` prima del transform: 4 MB con limite 10 MB passa | Confermato, `maxSize` resta 10 MB |
| Architettura Laravel | Forzare l'output JPEG di FilePond (`imageTransformOutputMimeType`) per i PNG grandi | **Non applicabile**: Filament 5.10 non espone l'opzione (cercata in `FileUpload.php` e `file-upload.js`). Rischio residuo: PNG 2048 px oltre 2 MB, raro da fotocamera |
| Architettura Laravel | Il canvas perde il GPS, che serve a localizzare | **Scartato**: il server lo toglie gia' apposta (`StripTicketPhotoMetadataListener`, privacy); la posizione arriva dal passo indirizzo |
| UX mobile | Due pulsanti giusti: su Android con `application/pdf` in `accept` la voce Fotocamera spesso non compare | Accolto |
| UX mobile | Togliere HEIC/HEIF da `accept` di "Scegli file": se dichiarati, iOS consegna HEIC; se no, li converte in JPEG da solo | **Accolto**. `heic2any` resta solo come rete per HEIC da desktop/Android |
| UX mobile | Niente `multiple` sull'input fotocamera (uno scatto per tocco) | Accolto |
| UX mobile | Accessibilita': `role="group"` + `aria-labelledby`, input nascosti fuori dal Tab (`tabindex="-1"`, `aria-hidden`), via l'`aria-label` che copre il testo visibile (WCAG 2.5.3) | Accolto |
| UX mobile | Memoria: liberare il canvas dopo ogni foto (`width = height = 0`) | Accolto |
| Sessione parallela (story [camera-photo-upload-component](camera-photo-upload-component.story.md)) | **Collisione 17:30**: le due sessioni hanno toccato `TicketForm` insieme. Oggi il campo e' `CameraPhotoUpload::make('images')` (Media, default 1920 `contain`, no upscale, nomi non deprecati) **piu'** le 4 chiamate inline `imageResize*` 2048 di questa story, che vincono perche' vengono dopo | Da decidere qui: proposta = togliere le 4 chiamate inline (PHPStan: 4 errori `Call to deprecated method imageResize*()` alla riga 337) e lasciare il componente |
| Sessione parallela | **Misura** col `file-upload.js` vero di Filament 5.10 (qualita' JPEG non configurabile, circa 0,92), foto 4000x3000 9,9 MB caso peggiore: 2048 px = **1,84 MB**, 1920 px = **1,51 MB**. Con l'overhead multipart 2048 sta a ridosso dei 2 MB | Proposta: 1920 anche in `camera-image.js` per avere un solo numero (`CameraPhotoUpload::MAX_SIDE`) |
| Sessione parallela | Resize globale (`FileUpload::configureUsing`) misurato e scartato: SVG riscritti, GIF animate diventano PNG, PNG piccoli ingrassano. Dettagli: [camera-photo-upload-research.md](../camera-photo-upload-research.md) | Coerente con questa story (opt-in) |
| Sessione parallela | `maxSize` limitato al limite del server: **misurato** che FilePond scarta l'originale da 9,9 MB prima del resize | Coerente con questa story (`maxSize` resta 10 MB) |
| Utente | «forse installando imagick era piu' semplice» | No per il 413: nginx rifiuta il corpo prima che PHP lo veda, e serve root. Si' come miglioramento per HEIC lato server (GD non legge HEIC) insieme all'aumento del limite in Ploi |

## Imagick (richiesta dell'utente durante il lavoro)

Il server ha Imagick 6.9.12 con HEIC, HEIF, AVIF e WEBP; e' gia' il `image_driver` di Media Library.
Ipotesi: passare `StripImageMetadataAction` (Media) da GD a Imagick per non sforare il `memory_limit` FPM (128 MB) con foto da 48 MP.
Misura (JPEG 8000x6000, EXIF Orientation=6, `memory_limit=128M`): **GD** ok in 11,8 s, picco PHP 59 MB; **Imagick** ok in 19,4 s, picco 59 MB.
Entrambi ruotano e tolgono l'EXIF. La libgd di sistema alloca fuori dal `memory_limit`: l'ipotesi e' falsa, la modifica e' stata annullata.
Dove Imagick servirebbe davvero: convertire HEIC sul server (GD non lo legge) e togliere `heic2any` (1,35 MB di JS) dal client.
Richiede di ammettere `image/heic` nella collezione `attachments` e convertire prima del salvataggio: decisione rimandata all'utente.

## Fusione con la story parallela (2026-10-27, 18:00)

Accolta la proposta della sessione parallela: un solo numero e un solo componente.
- `TicketForm`: tolte le 4 chiamate inline 2048; resta `CameraPhotoUpload::make('images')`.
- `dc-file-upload`: `maxSide` = `$getAutomaticallyResizeImagesWidth()` del campo (fallback `CameraPhotoUpload::MAX_SIDE`), passato a `normalize(file, { maxSide })`.
- `camera-image.js`: default 1920.
- Punto 9 della loro discussione (stato "Preparazione foto" + `error_prepare` in it, en, de, es): implementato qui, la voce compare prima della riduzione;
  una voce tolta mentre si riduce non parte.
- Test: `TicketFormImagesUploadTypesTest` verifica `CameraPhotoUpload` e `MAX_SIDE`; le stringhe dei test di render seguono la nuova chiamata.

Prova del componente Alpine **vero** (attributo `x-data` estratto dal render, Chrome headless iPhone 13, `$wire` simulato):
foto 11,61 MB, PDF 3 KB e GIF in un'unica scelta: stato `preparing` subito; foto inviata a 1,06 MB, 1920x1440, `image/jpeg`;
PDF inviato intatto; GIF rifiutato con «Formato non consentito». Build ricompilata: `maxSide=1920` nel bundle.

## Verifica

- Render reale del widget (`Livewire::test(CreateTicketWizardWidget::class)->html()` via tinker, app di produzione, sola lettura):
  input fotocamera `capture=environment`, `accept=image/*`, senza `multiple`; input file `accept=image/jpeg,image/png,application/pdf`, `multiple`;
  entrambi `tabindex=-1`; gruppo `role=group` con `aria-labelledby`; testi "Scatta una foto" e "Scegli file"; aiuto invariato.
- Campo admin: `contain`, `2048`, `2048`, upscale `false` (getter Filament).
- `camera-image.js` in Chrome headless 155, profilo iPhone 13: JPEG 4000x3000 rumore da 11,28 MB con EXIF Orientation=6 diventa
  1,61 MB, 1536x2048, `image/jpeg`, riquadro rosso in alto a destra (rotazione corretta), 2,9 s. PDF restituito intatto. `a.HEIC` riconosciuto.
- Build del tema (`npm run build`): `window.MediaCameraImage` in `app-*.js`; `heic2any` solo in `vendor-image-conversion-*.js`,
  import dinamico (manifest: `dynamicImports`).
- PHPStan sui 4 file PHP toccati: 0 errori. Pint: passed. `php -l` sulle 4 traduzioni: ok.
- Pest **non eseguibile** su questo server (`.env.testing` usa l'utente DB `marco` della macchina dev, `SQLSTATE[HY000] [1045]`): 14 test falliscono
  al bootstrap, prima delle asserzioni. Test aggiornati per CI: `CreateTicketWizardDataStepTest`, `WizardUploadHelpTextTest`, `TicketFormImagesUploadTypesTest`.
- Non verificato: prova su iPhone e Android reali (menu della fotocamera e della galleria), HEIC reale.

## Prossimi passi

- **nginx ancora a 2 MB.** Alle 17:30 del 2026-10-27 PHP e' passato a 20 MB (`upload_max_filesize`, `post_max_size`, FPM e CLI), ma
  `/etc/nginx/conf.d/upload.conf` dice ancora `client_max_body_size 2M`. Il client ora controlla 10 MB (regola del campo): un PDF da 3-10 MB
  passa il browser e muore con 413. Le foto no, perche' vengono ridotte sotto 2 MB. Da Ploi alzare anche nginx a 20 MB (serve root).
- Decidere sulla conversione HEIC con Imagick sul server (vedi sopra).

## Aggiornamento (2026-10-27 17:42, sessione camera-photo-upload-component)

Il commit `354ef7b492` (componente `CameraPhotoUpload`) ha incluso per errore la cancellazione **gia' in stage** di
`Themes/Sixteen/resources/js/components/camera-upload.js` fatta da questa story. Working tree invariato (il file era gia' cancellato
su disco), ma in git la cancellazione precede l'aggiunta di `Modules/Media/resources/js/camera-image.js`, ancora non tracciato.
Forward-only: nessun revert. Va chiuso committando `camera-image.js` con il resto di questa story.
