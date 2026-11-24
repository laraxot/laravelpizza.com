---
title: "ADR — Le foto da fotocamera si riducono nel browser, con un campo dedicato e non per tutti i FileUpload"
type: decision
module: Media
tags: [adr, media, upload, fotocamera, filepond, resize, mobile]
created: 2026-11-24
updated: 2026-11-24
status: accepted
related:
  - ../../app/Filament/Forms/Components/CameraPhotoUpload.php
  - ../../resources/js/camera-image.js
  - ../stories/media-mobile-camera-upload.story.md
---

# ADR: le foto da fotocamera si riducono nel browser, con un campo dedicato e non per tutti i FileUpload

## Contesto

- Una foto da telefono pesa 3-10 MB; il server di riferimento accetta 2 MB per richiesta (nginx e PHP): HTTP 413 su
  `/livewire/upload-file` prima che PHP veda il file.
- Misura (story `../stories/media-mobile-camera-upload.story.md`, `file-upload.js` di Filament 5.10): foto 4000x3000 da
  9,9 MB ridotta a 2048 px = 1,84 MB, a 1920 px = 1,51 MB.
- Applicare il resize di FilePond a ogni campo (`FileUpload::configureUsing`) e' stato misurato: riscrive gli SVG, appiattisce
  le GIF animate in PNG, ingrassa i PNG piccoli.

Domanda: come far passare le foto grandi senza toccare gli altri upload e senza dipendere dai limiti del server?

## Decisione

- Pannello: campo `CameraPhotoUpload` (`app/Filament/Forms/Components/CameraPhotoUpload.php`, estende
  `XotBaseSpatieMediaLibraryFileUpload`) con resize FilePond `contain`, lato massimo `MAX_SIDE` = 2048 px, senza upscale.
  E' **opt-in**: lo usa solo il campo che riceve foto.
- Front office: `resources/js/camera-image.js` (`window.MediaCameraImage.normalize(file)`) riduce e converte HEIC prima
  dell'upload; due pulsanti, "Scatta una foto" (`capture="environment"`) e "Scegli file" (galleria e PDF).
- `maxSize` del campo resta sul file originale (FilePond lo controlla prima del resize); la validazione server non cambia.

## Alternative scartate

- Resize globale su ogni `FileUpload`: danni misurati su SVG, GIF e PNG piccoli.
- `filament-take-picture-field` / `getUserMedia`: anteprima a bassa risoluzione, permessi del browser, stato base64 nel
  payload Livewire (stesso limite di 2 MB), niente galleria ne' PDF.
- Upload a blocchi (Uppy): rotte e riassemblaggio in piu', un secondo flusso accanto a Livewire.
- Alzare il limite del server: utile e fuori dal codice (proprietario dell'hosting), ma non basta per foto da 10 MB su reti lente.
- `capture` sull'unico input: su Android e iOS apre solo la fotocamera, niente galleria ne' PDF.

## Conseguenze

- Pro: foto sotto 2 MB senza cambiare il server; gli altri upload restano intatti.
- Contro: la riduzione dipende dal browser; un PNG grande a 2048 px puo' ancora superare 2 MB (FilePond di Filament 5.10 non
  permette di forzare l'output JPEG).
- Debito: il commento della classe e il test citano `docs/camera-photo-upload-research.md`, che non esiste piu' nel modulo;
  le misure sono nella story. Due numeri divergenti: `CameraPhotoUpload::MAX_SIDE` = 2048, default di `normalize()` in `camera-image.js` = 1920 (il
  chiamante puo' passare `maxSide`); la story voleva un solo numero.

## Verifica

- `Modules/Media/tests/Unit/Filament/CameraPhotoUploadTest.php`: resize `MAX_SIDE` x `MAX_SIDE`, modo `contain`, niente
  upscale; un campo puo' scegliere una misura propria.
- Solo revisione: nessun `FileUpload::configureUsing(...)` con resize nei service provider.
