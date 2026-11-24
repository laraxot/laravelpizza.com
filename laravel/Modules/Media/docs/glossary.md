---
title: "Glossario di dominio Media"
type: glossary
owner: Media
updated: 2026-11-24
qmd: "media glossario dominio upload temporaneo conversione responsive collezione disk s3 cloudfront allegato percorso"
---

# Glossario di dominio Media

Termini verificati nel codice con `rg`. Se glossario e codice divergono vale il codice.
Percorsi relativi a `laravel/Modules/Media/`.

| Termine | Significato | Nel codice |
|---|---|---|
| Media | File allegato a un record, con `uuid`, `collection_name`, `mime_type`, `disk`, `conversions_disk`, conversioni. | `app/Models/Media.php`, risorsa `app/Filament/Resources/MediaResource.php` |
| Collezione | Nome del gruppo di file di un record (`collection_name`). | `Media::$collection_name` |
| Disk | Storage su cui sta il file (`disk`) e, separato, quello delle conversioni (`conversions_disk`). | `Media::$disk`, `Media::$conversions_disk` |
| Conversione | Derivato del file originale (miniature, formati video). | `app/Models/MediaConvert.php`, `Media::$entry_conversions` |
| Upload temporaneo | Caricamento ancora non associato in modo definitivo a un modello; legato alla sessione. | `app/Models/TemporaryUpload.php` (`session_id`, `file_name`, `file_size`), `Media::findWithTemporaryUploadInCurrentSession()` |
| Percorso temporaneo | Cartella `tmp/<md5>/...` deterministica da `uuid` e `id` del media, distinta per originale, conversione e responsive. | `app/Actions/GenerateTemporaryUploadPathAction.php`, [ADR](adr/0001-upload-temporanei-con-percorso-scopato-e-policy.md) |
| Path generator | Contratto che fornisce i tre percorsi (originale, conversioni, responsive). | `app/Contracts/PathGenerator.php`, `PathGeneratorContract.php` |
| Immagini responsive | Versioni dell'immagine a piu' larghezze, con percorso proprio. | `GenerateTemporaryUploadPathAction::getPathForResponsiveImages()` |
| Tipo di allegato | `image`, `video`, `document`, `manual`. | `app/Enums/AttachmentTypeEnum.php` |
| Allegare media | Associa file a un record che implementa `HasMedia`. | `app/Actions/AttachMediaAction.php`, `app/Actions/SaveAttachmentsAction.php` (disk di default `attachments`) |
| Limite di upload effettivo | Il piu' piccolo tra limite PHP, regola Livewire e `maxSize()` del campo. | `app/Actions/Upload/GetEffectiveUploadLimitAction.php` |
| Foto da fotocamera | Campo Filament per scattare e caricare una foto. | `app/Filament/Forms/Components/CameraPhotoUpload.php` |
| Rimozione metadati | Ricodifica di JPEG/PNG senza EXIF e GPS. | `app/Actions/Image/StripImageMetadataAction.php` |
| S3 | Storage a oggetti usato per upload, lettura info e cancellazione. | `app/Actions/S3/UploadFileAction.php`, `DeleteFileAction.php`, `GetFileInfoAction.php`, `CheckFileExistsAction.php` |
| URL firmato CloudFront | URL temporaneo per accedere a un oggetto tramite CloudFront. | `app/Actions/CloudFront/GetCloudFrontSignedUrlAction.php` |
| Conversione video | Trasformazione di un video, locale o tramite servizi esterni. | `app/Actions/Video/ConvertVideoAction.php`, `ConvertVideoByMediaConvertAction.php`, `ConvertVideoByConvertDataAction.php` |
| Sottotitoli | Conversione da SRT a VTT ed estrazione del testo. | `app/Actions/Subtitle/ConvertSrtToVttAction.php`, `ExtractSubtitlePlainTextAction.php` |
| Diagnostica AWS | Verifiche di credenziali, permessi, bucket e CloudFront. | `app/Actions/Diagnostic/Aws/RunFullAwsDiagnosticAction.php`, `app/Actions/Diagnostic/S3/` |
| Policy dei media | Autorizzazioni CRUD per `media.*` e `temporary_upload.*`. | `app/Models/Policies/MediaPolicy.php`, `TemporaryUploadPolicy.php` |
