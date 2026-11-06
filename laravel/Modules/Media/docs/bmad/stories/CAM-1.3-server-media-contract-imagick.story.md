---
story_id: CAM-1.3
epic: CAM-1
title: "Contratto server Media e valutazione Imagick"
type: story
status: ready-for-dev
owner: Media
priority: P1
---

# CAM-1.3: Contratto server Media e valutazione Imagick

## Story

Come sistema Media, voglio validare e normalizzare gli allegati al confine di
fiducia, così il client non può bypassare MIME, dimensione, ownership o cleanup.

## Acceptance Criteria (LOCKED)

1. MIME e contenuto sono verificati server-side per JPEG, PNG, PDF e file
   contraffatti; l’estensione non è una difesa.
2. Temporary upload, sessione/utente, trasferimento e cleanup sono testati senza
   media orfani o ticket parziali.
3. L’ambiente dichiara se `Imagick` è disponibile e se `HEIC` è supportato da
   ImageMagick tramite `libheif`.
4. Imagick viene adottato solo se il probe HEIC passa e il percorso è raggiunto
   dopo il temporary upload; altrimenti il fallback browser e il rifiuto
   tradotto restano espliciti.

## Tasks / Subtasks

- [ ] Aggiungere test MIME reale, MIME vuoto, file troncato, oversize e
  ownership. (AC: #1, #2)
- [ ] Verificare cleanup di temporanei e rollback di `saveRelationships()`.
  (AC: #2)
- [ ] Eseguire probe `extension_loaded('imagick')` e
  `Imagick::queryFormats('HEIC')` nel runtime target. (AC: #3)
- [ ] Se il probe passa, documentare e configurare conversione server-side
  senza sostituire il percorso browser; se fallisce, documentare il motivo.
  (AC: #4)

## Dev Notes (LOCKED)

- Media Library viene dopo il temporary upload Livewire; una conversione Media
  non ripara un 413/422 precedente. [Source: ../mobile-camera-upload-investigation.md]
- Il modello `TemporaryUpload` mantiene il confine di sessione e richiede
  cleanup esplicito. [Source: ../../../app/Models/TemporaryUpload.php]
- Composer contiene adapter immagine, ma l’estensione PHP di sistema è una
  precondizione runtime distinta. [Source: ../../../../../composer.lock]
- Non ampliare la whitelist a `image/*`; mantenere il contratto Filament del
  campo. [Source: ../../../../Fixcity/docs/bmad/stories/mobile-camera-upload.story.md]

## Testing

- **Approach:** unit/feature Media + probe runtime ImageMagick + rollback test.
- **Key scenarios:** JPEG valido, PNG valido, PDF valido, HEIC se supportato,
  `.jpg` con contenuto non immagine, MIME vuoto, sessione diversa.
- **Per-AC verification:** AC #1 content sniffing; AC #2 database/storage
  cleanup; AC #3 runtime probe; AC #4 conversion path decision test.
- **Fixtures / mocks:** fixture binarie non fidate, temporary upload session,
  storage fake e ImageMagick reale nel runtime target.
- **Edge cases:** HEIC senza delegate, policy ImageMagick, file troncato,
  conversione fallita dopo upload.

## Dependency Maps

- **Blocked by:** CAM-1.1 per il limite trasporto.
- **Blocks:** CAM-1.5.
- **External:** `ext-imagick`, ImageMagick, `libheif`, storage.

## Owned File/Module Scope

- `laravel/Modules/Media/app/Models/TemporaryUpload.php`
- `laravel/Modules/Media/app/Actions/Image/`
- `laravel/Modules/Media/tests/Feature/`
- `laravel/Modules/Media/tests/Unit/`
- `laravel/Modules/Media/docs/bmad/`

## Learnings from Previous Stories

- Imagick non viene eseguito se il trasporto rifiuta prima il file; è una
  difesa server-side, non la soluzione unica. (from CAM-1.1)

## Dev Agent Record

### 2026-10-27, Claude (sessione a9bceaa6): prove sul confine di fiducia

**AC1, file contraffatto: rifiutato, ma tardi.** Saltando il client con `$wire.upload()` ho inviato `foto.jpg`, 4 KB che iniziano con
`<?php system(...)` e dichiarati `image/jpeg`, a un server con limiti PHP predefiniti, utente loggato, wizard passo dati.

- Il temporary upload risponde 200 e il file resta in `storage/app/livewire-tmp/` con estensione `.jpg` (3 file dopo 3 prove): Livewire
  non controlla il MIME perche' `temporary_file_upload.rules` e' `null`.
- Il rifiuto avviene a «Avanti» con la regola `mimetypes` del campo: «immagini deve essere un file di questo tipo: image/jpeg,
  image/png, application/pdf.» Il passo non avanza e non nasce nessun media. Prima della correzione in `Xot/lang/it/validation.php`
  l'utente leggeva la chiave grezza `validation.mimetypes`.
- Non e' una vulnerabilita' provata: il file sta su disco privato e non viene eseguito. E' il difetto che AC2 deve chiudere: il
  temporaneo rifiutato resta fino al cleanup di Livewire (`cleanup` e' `true`).
- Non provati: MIME vuoto, JPEG troncato, ownership e sessione, rollback di `saveRelationships()`.

**AC3, Imagick sul PC di sviluppo.** `php -m` non elenca `imagick`; `libheif.so.1` e' nel sistema; il pacchetto `php8.4-imagick` 3.8.1 e'
disponibile e non installato; GD 2.3.3 con WebP e AVIF. `Imagick::queryFormats('HEIC')` non si puo' eseguire senza l'estensione, quindi
AC3 resta aperto e non ho installato nulla: il difetto segnalato (PHP respinge l'upload prima che giri codice) non si risolve lato
server.

**AC4.** Vale la raccomandazione D2 della story FIXCITY-MEDIA-001: riduzione nel browser (HEIC vero gia' provato), Imagick solo se
l'owner vuole accettare HEIC sul server, dopo il probe su fixcity.eu.
