---
<<<<<<< HEAD
title: "INDEX — Media"
type: index
status: active
created: 2026-11-23
updated: 2026-11-23
decision-makers: []
---

<!-- File: docs/contracts/INDEX.md · formato MADR breve. -->

# <!-- Titolo: indice operativo Media -->

Elenco operativo dei contract comportamentali del modulo Media.

| Operazione | Contract | Classe | Invarianti |
|---|---|---|---|
| Generazione percorso file | [path-generator](path-generator.md) | `PathGenerator` | MEDIA-INV-1, MEDIA-INV-2, MEDIA-INV-3 |

(End of file - total 16 lines)
=======
title: "INDEX contratti — Media"
type: index
module: Media
status: active
created: 2026-11-23
updated: 2026-11-24
qmd: "media contracts index copertura invarianti backlog upload s3"
---

# Indice dei contratti — Media

Copertura = `coperto` solo se per ogni ID esiste `->group('<ID>')` nei test del modulo
(`rg -n "group\('MEDIA-" laravel/Modules/Media/tests`: nessun risultato; esiste solo il gruppo `no-media-db`, non un ID).

| Operazione | Contract | Classe | Invarianti | Copertura | Comando |
|---|---|---|---|---|---|
| Generare il percorso di un upload temporaneo | [generate-temporary-upload-path-action](generate-temporary-upload-path-action.md) | `Modules\Media\Actions\GenerateTemporaryUploadPathAction` | MEDIA-PATH-INV-1, MEDIA-PATH-INV-2, MEDIA-PATH-INV-3, MEDIA-PATH-INV-4 | non coperto (test esistenti senza group) | `vendor/bin/pest --group=MEDIA-PATH-INV-1` |
| Rimuovere i metadati da un'immagine | [strip-image-metadata-action](strip-image-metadata-action.md) | `Modules\Media\Actions\Image\StripImageMetadataAction` | MEDIA-STRIP-INV-1, MEDIA-STRIP-INV-2, MEDIA-STRIP-INV-3 | non coperto (INV-1/2 test senza group; INV-3 nessuno) | `vendor/bin/pest --group=MEDIA-STRIP-INV-1` |

I comandi `--group` darebbero zero test finche' i gruppi non sono aggiunti (fuori scope docs).
Marker `@contract` mancante in entrambe le classi (fuori scope docs).

## Backlog contract

Action ad alto rischio (upload, storage esterno, cancellazioni) senza contract:

- `laravel/Modules/Media/app/Actions/TemporaryUpload/GetTemporaryUploadPathAction.php`, `GetTemporaryUploadConversionPathAction.php`, `GetTemporaryUploadResponsivePathAction.php`: duplicano il calcolo del percorso e usano `Assert::string` sulla chiave (vedi nota nel contract dei percorsi).
- `laravel/Modules/Media/app/Actions/S3/UploadFileAction.php`, `S3/DeleteFileAction.php` (cancella un oggetto S3; errori restituiti come array `success=false`), `S3/GetFileInfoAction.php`
- `laravel/Modules/Media/app/Actions/CloudFront/GetCloudFrontSignedUrlAction.php` (URL firmato con scadenza di default 30)
- `laravel/Modules/Media/app/Actions/AttachMediaAction.php`, `SaveAttachmentsAction.php` (scrivono media sul record)
- `laravel/Modules/Media/app/Actions/Upload/GetEffectiveUploadLimitAction.php` (limite effettivo di upload)
- `laravel/Modules/Media/app/Actions/Video/Convert*Action.php` e `Stream/StreamVideoAction.php`
- `laravel/Modules/Media/app/Actions/Diagnostic/**`: diagnostica AWS/S3 (21 file, con chiamate ai servizi)

Totale Action nel modulo: 51 file in `app/Actions` (`find app/Actions -name '*.php' | wc -l`), di cui 2 con contract.
>>>>>>> laraxot/dev
