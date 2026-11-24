---
title: "Architettura — Media"
type: architecture
<<<<<<< HEAD
<<<<<<< HEAD
tags: [architecture, structure, module, media, storage]
=======
=======
=======
<<<<<<< HEAD
tags: [architecture, structure, module, media, storage]
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_fG7tBd
tags: [architecture, structure]
=======
tags: [architecture, structure, module, media, storage]
>>>>>>> .merge_file_YVd6a5
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
created: 2026-07-14
status: review
updated: 2026-11-16
module: Media
qmd: "architettura Media spatie medialibrary Media MediaConvert TemporaryUpload Filament Resource Actions S3 CloudFront MediaConvert FFmpeg MediaBasePolicy verificata sul codice"
related:
  - ./purpose.md
  - ./audits/media-audit.md
  - ./decision-log.md
  - ../purpose.md
---

# Architettura — Media

Verificata sul codice il 2026-11-16 (127 PHP in `app/`, 51 Action, 0 Services). Sostituisce due documenti fusi che citavano `UploadMediaAction`, `ProcessMediaAction`, `DeleteMediaAction`, `MediaCollections`, `MediaItem`, `CollectionResource`: **nessuno esiste** ([audit P1-6](./audits/media-audit.md#p1-6--documentazione-che-contraddice-il-codice)). Scopo: [purpose.md](./purpose.md).

## Componenti reali

| Strato | Elementi |
|---|---|
| Modelli | `Media` (estende `Spatie\MediaLibrary\MediaCollections\Models\Media`), `MediaConvert`, `TemporaryUpload` (connessione `media`, `MassPrunable` senza `prunable()`), `BaseModel` |
| Provider | `MediaServiceProvider`, `EventServiceProvider`, `RouteServiceProvider` (route `web`/`api` vuote) |
| Filament | `MediaResource` (+ `ConvertWidget`), `MediaConvertResource`, `TemporaryUploadResource`; cluster `Test` con `AwsTest`, `S3Test`; `ConvertAction` |
| Storage / CDN | `Actions/Storage/GetFilesystemAdapterAction`, `Actions/S3/*` (Upload, Delete, CheckFileExists, GetFileInfo), `Actions/CloudFront/GetCloudFrontSignedUrlAction`, `Datas/CloudFrontData` |
| Video / immagini | `Actions/Video/*` (Convert via FFmpeg o AWS MediaConvert, durata, screenshot), `Actions/Ffmpeg/ResolveMediaExporterAction`, `Actions/Image/*`, `Conversions/{ImageGenerators,VideoGenerators}`, `Console/Commands/ConvertVideoCommand` |
| Sottotitoli | `Actions/Subtitle/*` (SRT→VTT, estrazione testo, aggiornamento campo modello) |
| Upload | `Actions/TemporaryUpload/*`, `Actions/Upload/GetEffectiveUploadLimitAction`, `GenerateTemporaryUploadPathAction`, `AttachMediaAction`, `SaveAttachmentsAction`, `GetAttachmentsSchemaAction`, `Rules/FileExtensionRule`, `Enums/AttachmentTypeEnum` |
| Diagnostica | `Actions/Diagnostic/{Aws,S3}/*` (usate dalle pagine del cluster `Test`) |
| Senza caller | `Actions/Stream/StreamVideoAction`, `Http/Controllers/ConvertController`, `Http/Requests/CreateTemporaryUploadFromDirectS3UploadRequest` ([P1-5](./audits/media-audit.md#p1-5--codice-senza-caller-che-se-cablato-è-insicuro)) |

## Flussi

1. **Allegato.** `GetAttachmentsSchemaAction` (chiamata da `XotBaseResource` e `Datas/MediaConfigData`) costruisce il campo; `SaveAttachmentsAction` (via `Datas/SaveAttachmentsData`) salva su libreria media-library → disco (S3 o locale). Il file nasce in `TemporaryUpload` prima dell'entità proprietaria; la pulizia dei non confermati **non funziona** (P1-2). `AttachMediaAction` non ha caller in produzione.
2. **Conversione video.** Oggi l'unico percorso raggiunto è `ConvertAction` (azione di tabella) e `MediaConvertsTable` → `ConvertVideoByMediaConvertAction` (AWS MediaConvert); stato in `MediaConvert`. `ConvertVideoAction` e `ConvertVideoByConvertDataAction` (FFmpeg) non hanno caller fuori dai test; `ConvertVideoCommand` non è referenziato. Esecuzione asincrona: perimetro del modulo Job.
3. **URL privati.** `GetCloudFrontSignedUrlAction` genera URL firmati CloudFront.
4. **Diagnostica.** Pagine `AwsTest`/`S3Test` → Action `Diagnostic/*` e chiamate dirette al client S3 (`putObject`/`deleteObject`, `AwsTest.php:345,360`).

## Autorizzazione

`MediaBasePolicy::before()` → `true` per `super-admin` e `media::admin` (bypass voluto, ADR Xot module-admin-role-policy-bypass); `MediaPolicy`, `MediaConvertPolicy`, `TemporaryUploadPolicy` decidono per permesso (`media.viewAny`, `media.delete`, `media.forceDelete`, …). **Nessun guard** sulle pagine del cluster `Test` (P1-1).

## Confini e dipendenze

- Dipende da Xot (64 `use` nel modulo, probe) e UI (7). Usato (file con `use Modules\Media\`, no test) da Notify 8, User 4, Rating 2, IndennitaResponsabilita 1, Progressioni 1, Ptv 1, Xot 1. **Non da Activity né Lang.**
- Vincolo trasversale: `public_path()` = `public_html/` ([purpose](./purpose.md)).

## Pattern

Logica in Spatie Queueable Action, nessun Service, estensione di `XotBaseResource`/`XotBasePage`, `strict_types` ovunque.

## Decisioni collegate

[decision-log.md](./decision-log.md): D-1 (prune), D-2 (cast `id`), D-3 (allegati-prova), D-4 (guard diagnostica), D-5 (codice morto).
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< .merge_file_fG7tBd
=======
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
=======
<<<<<<< .merge_file_fG7tBd
=======
>>>>>>> laraxot/dev
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev

## Convenzioni (dalla versione precedente, ancora valide)

- Modelli al singolare (`Media`, `MediaConvert`, `TemporaryUpload`); Action `{Verb}{Noun}Action` (es. `ConvertVideoAction`).
- Test in `tests/` (Pest, mai PHPUnit diretto), suddivisi in `Feature/` e `Unit/`; niente `RefreshDatabase`, database dedicato da `.env.testing`.
- Dipendenze iniettate nel costruttore delle Action; binding nei Service Provider.
- Scelta di fondo: Spatie MediaLibrary (collaudata, gestisce le trasformazioni); tabella `media` con `model_type`, `model_id`, `collection_name`, `file_name`, `mime_type`, `size`, `custom_properties`.

## Affermazioni della versione precedente non riscontrate nel codice (2026-11-16)

La vecchia architettura (fusa con `ARCHITECTURE.md`) dichiarava anche: streaming HLS/DASH, watermark automatico,
storage con isolamento per tenant, dipendenza da Tenant e User, uso da Activity, Lang e generazione PDF, «97 file PHP».
Nel codice: nessuna occorrenza di HLS/DASH; `Actions/Image/Merge.php` fa solo una sovrapposizione «tipo watermark»,
non automatica; 0 `use Modules\Tenant` e 0 `use Modules\User` in `app/`; i consumatori reali sono quelli elencati in
«Confini e dipendenze»; i file PHP in `app/` sono 127. Non vanno ripristinate senza una verifica sul codice.
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> .merge_file_YVd6a5
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_YVd6a5
=======
<<<<<<< HEAD
=======
>>>>>>> .merge_file_YVd6a5
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
