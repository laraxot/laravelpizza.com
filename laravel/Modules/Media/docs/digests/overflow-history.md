---
title: "Overflow history (ceiling 100)"
type: digest
status: active
qmd: "digest ceiling 100 overflow-history"
---

# Overflow history (ceiling 100)

Overflow force-cap: 38 file oltre target 100.

### `contracts/attach-media-action.md` — AttachMediaAction


# AttachMediaAction

Classe vuota che usa solo il trait `QueueableAction`. Codice: `app/Actions/AttachMediaAction.php:12-15`.

## Input

- Nessuno: la classe non dichiara `execute()`.

## Output

- Nessuno.

## Invarianti

- **ATTACH-MEDIA-INV-1** — La classe non espone `execute()`: una chiamata diretta fallisce con `Call to undefined method`, perché il trait definisce `execute()` solo sul proxy restituito da `onQueue()`.
  Test: `tests/Unit/Actions/AttachMediaActionTest.php:24-26` verifica solo che l'istanza sia creata.

## Effetti collaterali


### `contracts/base-s3-action.md` — BaseS3Action


# BaseS3Action

Classe astratta base delle Action S3: costruisce il client S3 e risolve bucket, region e credenziali. Codice: `app/Actions/S3/BaseS3Action.php:11-67`.

## Input

- Costruttore: `LoggerInterface $logger`.

## Output

- Nessun `execute()`: è astratta. Le sottoclassi sono `CheckFileExistsAction`, `DeleteFileAction`, `GetFileInfoAction`, `UploadFileAction`.

## Invarianti

- **BASE-S3-INV-1** — Ogni valore è letto prima da `media.aws.*`, poi da `filesystems.disks.s3.*`, infine dal default: il primo valore stringa non vuoto vince.
  Test: `tests/Unit/Actions/MediaActionsCoverageTest.php:181-195` (verifica l'ereditarietà, non i valori).
- **BASE-S3-INV-2** — Il default della region è `us-east-1`; il bucket e le credenziali hanno default `''`.
  Test: nessuno.


### `contracts/build-config-debug-data-action.md` — BuildConfigDebugDataAction


# BuildConfigDebugDataAction

Compone il blocco «Configurazione» della diagnostica S3, mostrando i valori senza esporre i segreti. Codice: `app/Actions/Diagnostic/S3/BuildConfigDebugDataAction.php:16-38`.

## Input

- Nessuno. Legge `filesystems.disks.s3.*` e `services.cloudfront.*`.

## Output

- `array<string, mixed>`: `title` (`📋 Configuration`), `status=info`, `data` con chiave AWS troncata, presenza (✅/❌) di secret e chiave privata CloudFront, region, bucket, `AWS_USE_PATH_STYLE_ENDPOINT` (default `'false'`), URL e key pair CloudFront.

## Invarianti

- **BUILD-CONFIG-DEBUG-DATA-INV-1** — Il segreto AWS e la chiave privata CloudFront compaiono solo come presenza, mai come valore.
  Test: nessuno.
- **BUILD-CONFIG-DEBUG-DATA-INV-2** — La chiave di accesso è troncata a 8 caratteri più 

### `contracts/check-bucket-policy-action.md` — CheckBucketPolicyAction


# CheckBucketPolicyAction

Legge la policy del bucket e la mostra formattata. Codice: `app/Actions/Diagnostic/S3/CheckBucketPolicyAction.php:21-57`.

## Input

- Nessuno. Usa `CreateFilesystemS3ClientAction`.

## Output

- Policy presente: `status=info`, `data` con `Policy Exists` e la policy in JSON indentato.
- `NoSuchBucketPolicy`: `status=info`, `Policy Exists = ℹ️ No (This is usually OK)`.
- Altro `AwsException`: `status=error`, `Error` (codice) e `Message`.

## Invarianti

- **CHECK-BUCKET-POLICY-INV-1** — L'assenza di policy (`NoSuchBucketPolicy`) non è un errore.
  Test: nessuno.
- **CHECK-BUCKET-POLICY-INV-2** — Il JSON della policy viene decodificato e ricodificato con indentazione.

### `contracts/check-file-exists-action.md` — CheckFileExistsAction


# CheckFileExistsAction

Dice se una chiave esiste nel bucket con `headObject`. Codice: `app/Actions/S3/CheckFileExistsAction.php:10-43`.

## Input

- `string $key`: chiave dell'oggetto.

## Output

- `bool`: `true` se la HEAD riesce; `false` se S3 risponde 404.

## Invarianti

- **CHECK-FILE-EXISTS-INV-1** — Solo lo status 404 produce `false`; ogni altro `S3Exception` viene registrato come errore e rilanciato.
  Test: `tests/Unit/Actions/MediaActionsCoverageTest.php:218-224` (solo classe, metodo e superclasse).
- **CHECK-FILE-EXISTS-INV-2** — Ogni esito è registrato a livello `info` (esistenza) o `error` (eccezione).
  Test: nessuno.


### `contracts/convert-srt-to-vtt-action.md` — ConvertSrtToVttAction


# ConvertSrtToVttAction

Converte un file SRT in WebVTT: aggiunge l'intestazione `WEBVTT` e cambia la virgola in punto nei timestamp. Codice: `app/Actions/Subtitle/ConvertSrtToVttAction.php:17-46`.

## Input

- `string $srtFile`: percorso relativo a `public_path()`.
- `string $webVttFile`: percorso di destinazione relativo a `public_path()`.

## Output

- `void`.

## Invarianti

- **CONVERT-SRT-TO-VTT-INV-1** — Il file di output inizia con `WEBVTT` e una riga vuota.
  Test: `tests/Unit/Actions/Subtitle/ConvertSrtToVttActionTest.php:29`.
- **CONVERT-SRT-TO-VTT-INV-2** — La virgola è sostituita con il punto solo nella riga dei timestamp: la riga a indice 1 e ogni riga che segue una riga vuota più un'altra riga.
  Test: `tests/Unit/Actions/Subtitle/ConvertSrtToVttActionTest.php:19` («timing 

### `contracts/create-filesystem-s3-client-action.md` — CreateFilesystemS3ClientAction


# CreateFilesystemS3ClientAction

Costruisce il client S3 e legge il nome del bucket dalla configurazione del disco `s3`. Codice: `app/Actions/Diagnostic/Aws/CreateFilesystemS3ClientAction.php:16-33`.

## Input

- Nessuno. Legge `filesystems.disks.s3.{region,key,secret,bucket}`.

## Output

- `execute()`: `S3Client` (versione `latest`, region con default `eu-west-1` se la chiave non esiste).
- `bucket()`: `string`, oppure `''` se il valore non è una stringa.

## Invarianti

- **CREATE-FILESYSTEM-S3-CLIENT-INV-1** — Il client usa le credenziali del disco `s3` e la region di config, con default `eu-west-1` solo quando la chiave manca.
  Test: `tests/Unit/Actions/DiagnosticActionsTest.php:28` (verifica il tipo di ritorno, nient'altro).
- **CREATE-FILESYSTEM-S3-CLIENT-INV-2** — `bucket()` non

### `contracts/create-filesystem-sts-client-action.md` — CreateFilesystemStsClientAction


# CreateFilesystemStsClientAction

Costruisce il client STS con le stesse credenziali e region del disco `s3`. Codice: `app/Actions/Diagnostic/Aws/CreateFilesystemStsClientAction.php:16-26`.

## Input

- Nessuno. Legge `filesystems.disks.s3.{region,key,secret}`.

## Output

- `StsClient` (versione `latest`, region default `eu-west-1`).

## Invarianti

- **CREATE-FILESYSTEM-STS-CLIENT-INV-1** — Il client usa le stesse credenziali e la stessa region del client S3 costruito da `CreateFilesystemS3ClientAction`.
  Test: `tests/Unit/Actions/DiagnosticActionsTest.php:29` (solo tipo di ritorno).

## Effetti collaterali


### `contracts/delete-file-action.md` — DeleteFileAction


# DeleteFileAction

Cancella un oggetto dal bucket e restituisce un array di esito. Non lancia. Codice: `app/Actions/S3/DeleteFileAction.php:10-53`.

## Input

- `string $key`: chiave dell'oggetto.

## Output

- Successo: `['success' => true, 'key', 'deleteMarker', 'versionId']`.
- Errore S3: `['success' => false, 'key', 'error' => messaggio, 'errorCode' => status HTTP]`.

## Invarianti

- **DELETE-FILE-INV-1** — Ogni `S3Exception` diventa `success=false`: il chiamante deve leggere `success`.
  Test: `tests/Unit/MediaCoverage100RemainingTest.php:64` (cancellazione di una chiave mancante); `tests/Unit/Actions/MediaActionsCoverageTest.php:190` (solo struttura).
- **DELETE-FILE-INV-2** — `deleteMarker` e `versionId` sono `false` e `null` quando il bucket non ha versioning.
  Test: nessuno.

### `contracts/extract-subtitle-plain-text-action.md` — ExtractSubtitlePlainTextAction


# ExtractSubtitlePlainTextAction

Estrae il testo di un file di sottotitoli XML concatenando gli `item` di ogni `sentence`. Codice: `app/Actions/Subtitle/ExtractSubtitlePlainTextAction.php:16-40`.

## Input

- `string $filePath`: percorso del file XML.

## Output

- `string`: testo degli item in ordine, ognuno seguito da uno spazio (nessun `trim`).

## Invarianti

- **EXTRACT-SUBTITLE-PLAIN-TEXT-INV-1** — Si leggono solo i percorsi `annotation/type/sentence/item`; altre strutture danno stringa vuota.
  Test: `tests/Unit/Actions/Subtitle/SubtitleTextActionsTest.php:21`.

## Effetti collaterali


### `contracts/format-debug-output-action.md` — FormatDebugOutputAction


# FormatDebugOutputAction

Trasforma i blocchi di diagnostica in testo leggibile. Codice: `app/Actions/Diagnostic/S3/FormatDebugOutputAction.php:18-102`.

## Input

- `array<string, mixed> $debugResults`: lista di blocchi con `title`, `status`, `data`.
- `string $emptyMessage`: testo restituito se la lista è vuota.

## Output

- `string`: blocchi uniti con `\n`. Ogni blocco ha intestazione `=== title ===`, riga `Status:`, righe `chiave: valore` (array in JSON indentato) e una linea di 50 trattini.

## Invarianti

- **FORMAT-DEBUG-OUTPUT-INV-1** — Lista vuota → `$emptyMessage` invariato.
  Test: `tests/Unit/Actions/Diagnostic/FormatDebugOutputActionTest.php:19`.
- **FORMAT-DEBUG-OUTPUT-INV-2** — Un blocco senza `title`, `status` o `data` (anche se `null`) viene ignorato in silenzio.
  Test

### `contracts/generate-temporary-upload-path-action.md` — GenerateTemporaryUploadPathAction


# GenerateTemporaryUploadPathAction

Genera il percorso di storage sotto `tmp/` per originale, conversioni e immagini responsive di un `Media`. Decisione di fondo: [ADR 0001](../adr/0001-upload-temporanei-con-percorso-scopato-e-policy.md).
Implementa il contratto del [PathGenerator](path-generator.md) tramite `getPath()`, `getPathForConversions()`, `getPathForResponsiveImages()`.

## Input

- `Media $media`: servono solo `id` (chiave) e `uuid`.
- `string $purpose`: `original` (default), `conversion`, `responsive`; qualsiasi altro valore e' trattato come `original`.

## Output

- `string`: `tmp/<md5(uuid+id)>/<md5(id+uuid+suffisso)>`; per `original` il percorso termina con `/`, per gli altri no.

## Invarianti

- **MEDIA-PATH-INV-1** — Il percorso dipende solo da `uuid` e `id` del media, m

### `contracts/get-attachments-schema-action.md` — GetAttachmentsSchemaAction


# GetAttachmentsSchemaAction

Costruisce un `FileUpload` Filament per ogni nome di allegato, con i limiti letti da `MediaConfigData`. Codice: `app/Actions/GetAttachmentsSchemaAction.php:18-64`.

## Input

- `array<array-key, string> $attachments`: nomi dei campi (uno per allegato).
- `string $disk = 'attachments'`: disco di destinazione.

## Output

- `list<FileUpload>`: un componente per allegato, nello stesso ordine.

## Invarianti

- **GET-ATTACHMENTS-SCHEMA-INV-1** — Ogni componente accetta i mime type e rispetta la dimensione massima di `MediaConfigData`; è obbligatorio, singolo, senza riordino, con anteprima e download.
  Test: `tests/Unit/Actions/GetAttachmentsSchemaActionTest.php:20` («returns attachment schema») e `:40` («has correct names»): non verificano i limiti del mime type

### `contracts/get-aws-config-snapshot-action.md` — GetAwsConfigSnapshotAction


# GetAwsConfigSnapshotAction

Restituisce uno snapshot delle variabili AWS e CloudFront, con la chiave di accesso troncata. Codice: `app/Actions/Diagnostic/Aws/GetAwsConfigSnapshotAction.php:18-31`.

## Input

- Nessuno. Legge `filesystems.disks.s3.{key,region,bucket}` e `filesystems.cloudfront.{url,key_pair_id}`.

## Output

- `array<string, mixed>` con le chiavi `AWS_ACCESS_KEY_ID`, `AWS_DEFAULT_REGION`, `AWS_BUCKET`, `CLOUDFRONT_URL`, `CLOUDFRONT_KEY_PAIR_ID`.

## Invarianti

- **GET-AWS-CONFIG-SNAPSHOT-INV-1** — `AWS_ACCESS_KEY_ID` mostra i primi 8 caratteri seguiti da `...`; il segreto non compare mai nell'output.
  Test: nessuno.
- **GET-AWS-CONFIG-SNAPSHOT-INV-2** — Se la chiave non è una stringa il valore è `''`.
  Test: nessuno.


### `contracts/get-cloud-front-signed-url-action.md` — GetCloudFrontSignedUrlAction


# GetCloudFrontSignedUrlAction

Genera un URL CloudFront firmato per una chiave S3. Codice: `app/Actions/CloudFront/GetCloudFrontSignedUrlAction.php:14-33`.

## Input

- `string $key`: chiave dell'oggetto; gli slash iniziali sono rimossi (`ltrim`).
- `int $expiry = 30`: durata in **minuti** (moltiplicata per 60 alla riga 29).

## Output

- `string`: URL firmato restituito da `CloudFrontClient::getSignedUrl()`.

## Invarianti

- **GET-CLOUD-FRONT-SIGNED-URL-INV-1** — L'URL è `base_url` + `/` + chiave senza slash iniziali; la scadenza è `time() + expiry * 60`.
  Test: nessuno sul comportamento; `tests/Unit/Actions/MediaActionsCoverageTest.php:258-264` verifica solo classe e metodo `execute`.
- **GET-CLOUD-FRONT-SIGNED-URL-INV-2** — Configurazione letta da `CloudFrontData::make()` (namespace

### `contracts/get-effective-upload-limit-action.md` — GetEffectiveUploadLimitAction


# GetEffectiveUploadLimitAction

Calcola il numero massimo di byte che un upload temporaneo Livewire può davvero portare nella richiesta web. Codice: `app/Actions/Upload/GetEffectiveUploadLimitAction.php:20-57`.

## Input

- `?int $fieldMaxKb = null`: limite del campo, in kilobyte; `null` non lo applica.

## Output

- `int`: il minimo tra tre limiti in byte: 90% di `UploadedFile::getMaxFilesize()` (PHP), `livewire.temporary_file_upload.rules` (regola `max:` in kilobyte, default 12288) e il limite del campo.

## Invarianti

- **GET-EFFECTIVE-UPLOAD-LIMIT-INV-1** — Il risultato non supera mai il limite PHP ridotto del 10% per il multipart.
  Test: `tests/Unit/Actions/Upload/GetEffectiveUploadLimitActionTest.php:22` e `:26` (confronto con soglie).
- **GET-EFFECTIVE-UPLOAD-LIMIT-INV-2** — Sen

### `contracts/get-file-info-action.md` — GetFileInfoAction


# GetFileInfoAction

Legge i metadati di un oggetto con `headObject`, senza scaricarlo. Codice: `app/Actions/S3/GetFileInfoAction.php:10-66`.

## Input

- `string $key`: chiave dell'oggetto.

## Output

- Successo: `exists=true` con `key`, `effectiveUri`, `contentLength`, `contentType`, `lastModified`, `etag`, `metadata` (valori `null` o `[]` se assenti).
- Errore S3: `exists=false` con `error` e `errorCode` (status HTTP).

## Invarianti

- **GET-FILE-INFO-INV-1** — Il successo non scarica il corpo dell'oggetto.
  Test: nessuno.
- **GET-FILE-INFO-INV-2** — Ogni `S3Exception` diventa `exists=false`: anche un 403 risulta come «non esiste».
  Test: `tests/Unit/MediaCoverage100RemainingTest.php:57` (chiave mancante); `tests/Unit/Actions/MediaActionsCoverageTest.php:204` (solo struttura).

### `contracts/get-filesystem-adapter-action.md` — GetFilesystemAdapterAction


# GetFilesystemAdapterAction

Restituisce un disco come `FilesystemAdapter`, il tipo che espone `mimeType()`, `url()` e `temporaryUrl()`. Codice: `app/Actions/Storage/GetFilesystemAdapterAction.php:17-31`.

## Input

- `string $disk`: nome del disco.

## Output

- `FilesystemAdapter`: il disco richiesto.

## Invarianti

- **GET-FILESYSTEM-ADAPTER-INV-1** — Un disco che non è `FilesystemAdapter` lancia `RuntimeException`; un adapter valido è restituito così com'è.
  Test: nessuno.

## Effetti collaterali


### `contracts/merge.md` — Merge


# Merge

Unisce più immagini in verticale in un unico file PNG. Espone due punti di ingresso: `handle()` con percorsi assoluti e `execute()` con percorsi relativi a `public_path()`. Codice: `app/Actions/Image/Merge.php:21-126`.

## Input

- `handle(string $path1, string $path2, string $outputPath)`: percorsi assoluti.
- `execute(array $filenames, string $outputFilename)`: lista di percorsi relativi a `public_path()`.

## Output

- Entrambi restituiscono `bool`: `true` se il file di output esiste dopo l'operazione.

## Invarianti

- **MERGE-INV-1** — Con due immagini in `handle()`, l'altezza è la somma delle altezze e la larghezza è la massima.
  Test: `tests/Unit/MediaCoverage100RemainingTest.php:88-101` («Image Merge con due png minimi»; verifica anche che esista `execute`).
- **MERGE-IN

### `contracts/parse-subtitle-xml-action.md` — ParseSubtitleXmlAction


# ParseSubtitleXmlAction

Legge un file di sottotitoli XML e produce una riga per ogni `item`, con inizio, fine, intervallo `HH:MM:SS,mmm` e testo. Codice: `app/Actions/Subtitle/ParseSubtitleXmlAction.php:22-98`.

## Input

- `string $filePath`: percorso del file. Solo l'estensione `xml` (minuscola o no) viene elaborata.

## Output

- `list<SubtitleRow>`: `sentence_i`, `item_i`, `start` e `end` in secondi (`ms / 1000`), `time`, `text`.

## Invarianti

- **PARSE-SUBTITLE-XML-INV-1** — Un file senza estensione o con estensione diversa da `xml` produce `[]` senza errore.
  Test: `tests/Unit/Actions/Subtitle/ParseSubtitleXmlActionTest.php:19` (estensione non xml) e `:25` (percorso senza estensione).
- **PARSE-SUBTITLE-XML-INV-2** — Gli indici `sentence_i` e `item_i` partono da 0 e si resettan

### `contracts/path-generator.md` — PathGenerator e PathGeneratorContract


# PathGenerator e PathGeneratorContract

Interfacce in `app/Contracts/PathGenerator.php` e `app/Contracts/PathGeneratorContract.php`: firme identiche, tre metodi
che restituiscono la cartella di un `Modules\Media\Models\Media`. Definiscono il contratto per la generazione dei percorsi
dei file media nel sistema.

| Metodo | Restituisce |
|---|---|
| `getPath(Media $media): string` | cartella del file originale |
| `getPathForConversions(Media $media): string` | cartella delle conversioni |
| `getPathForResponsiveImages(Media $media): string` | cartella delle immagini responsive |

Ogni metodo riceve `$media`, l'istanza del modello Media, e ritorna il percorso come stringa.

Stato verificato (2026-11-24): nessuna classe del repo implementa o usa nessuna delle due interfacce. Il generatore d

### `contracts/resolve-aws-s3-error-solution-action.md` — ResolveAwsS3ErrorSolutionAction


# ResolveAwsS3ErrorSolutionAction

Traduce un codice di errore AWS S3 in un suggerimento testuale. Codice: `app/Actions/Diagnostic/Aws/ResolveAwsS3ErrorSolutionAction.php:13-28`.

## Input

- `?string $errorCode`: codice AWS, oppure `null`.

## Output

- `string`: suggerimento. Mappa fissa di cinque codici (`SignatureDoesNotMatch`, `AccessDenied`, `NoSuchBucket`, `InvalidAccessKeyId`, `BucketRegionError`).

## Invarianti

- **RESOLVE-AWS-S3-ERROR-SOLUTION-INV-1** — `null` restituisce il messaggio fisso «Unknown error - check AWS credentials and configuration».
  Test: `tests/Unit/Actions/DiagnosticActionsTest.php:33` (verifica il messaggio).
- **RESOLVE-AWS-S3-ERROR-SOLUTION-INV-2** — Un codice fuori mappa produce «Consult AWS documentation for error: <codice>».
  Test: `tests/Unit/Action

### `contracts/resolve-media-exporter-action.md` — ResolveMediaExporterAction


# ResolveMediaExporterAction

Verifica che il valore prodotto da una catena fluent FFmpeg sia un `MediaExporter` e lo restituisce invariato. Codice: `app/Actions/Ffmpeg/ResolveMediaExporterAction.php:18-29`.

## Input

- `mixed $value`: risultato della catena fluent.

## Output

- `MediaExporter`: lo stesso oggetto ricevuto.

## Invarianti

- **RESOLVE-MEDIA-EXPORTER-INV-1** — Un `MediaExporter` è restituito senza modifiche (stessa istanza).
  Test: `tests/Unit/MediaGapCloserCoverageTest.php:82-85` (istanza del resolver, non il caso di input sbagliato).
- **RESOLVE-MEDIA-EXPORTER-INV-2** — Ogni altro valore lancia `RuntimeException` con il tipo ricevuto nel messaggio.
  Test: nessuno esplicito.


### `contracts/run-full-aws-diagnostic-action.md` — RunFullAwsDiagnosticAction


# RunFullAwsDiagnosticAction

Esegue in sequenza sette diagnostiche AWS e raccoglie i risultati per chiave. Codice: `app/Actions/Diagnostic/Aws/RunFullAwsDiagnosticAction.php:16-27`.

## Input

- Nessuno. Le diagnostiche leggono la configurazione `filesystems`.

## Output

- `array<string, mixed>` con le chiavi `s3`, `s3_permissions`, `s3_operations`, `cloudfront`, `cloudfront_signed`, `iam_credentials`, `iam_policies`. Ogni valore è l'array restituito dalla singola `Test*Action`.

## Invarianti

- **RUN-FULL-AWS-DIAGNOSTIC-INV-1** — Le chiavi sono sempre queste sette, nello stesso ordine, e ognuna contiene il risultato della propria Action.
  Test: nessuno.

## Effetti collaterali


### `contracts/run-s3-save-test-action.md` — RunS3SaveTestAction


# RunS3SaveTestAction

Salva un file di prova sul disco `s3`, genera URL CloudFront e temporanei, poi cancella il file di prova. Codice: `app/Actions/Diagnostic/S3/RunS3SaveTestAction.php:19-50`.

## Input

- `?string $attachmentPath`: percorso di un allegato da includere nel test; `null` o vuoto lo salta.
- `string $testFilePrefix = 'test-upload-'`: prefisso del file di prova (il nome aggiunge `time()` e `.txt`).

## Output

- `array`: `test_file` con `path`, `cloudfront_url` (5 min), `temporary_url` (5 min); `uploaded_file` a `null` oppure con gli stessi campi per l'allegato (30 min).

## Invarianti

- **RUN-S3-SAVE-TEST-INV-1** — Il file di prova è cancellato al termine del flusso normale.
  Test: nessuno.
- **RUN-S3-SAVE-TEST-INV-2** — `uploaded_file` è valorizzato solo se `$attachmen

### `contracts/save-attachments-action.md` — SaveAttachmentsAction


# SaveAttachmentsAction

Importa in media library gli allegati caricati su un disco temporaneo e salva sul record il percorso relativo di ciascun media.
Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/SaveAttachmentsAction.php`.

## Input

- `$record`: un modello `HasMedia` (deve avere anche `update()`, cioe' essere un Eloquent Model).
- `$attachments`: nomi dei campi allegato (sono anche i nomi delle collezioni media).
- `$data`: dati del form, `campo => percorso` del file gia' caricato su `$disk`.
- `$disk`: disco di origine e di destinazione (default `attachments`).

## Output

- `void`.

## Invarianti


### `contracts/stream-video-action.md` — StreamVideoAction


# StreamVideoAction

Invia un file video dal disco al client con supporto all'header `Range`. Codice: `app/Actions/Stream/StreamVideoAction.php:21-178`.

## Input

- `string $disk`, `string $path`: disco e percorso del file.
- `?Media $media`: se presente, il proprietario è verificato.

## Output

- `void`. Scrive header e corpo direttamente sulla risposta, poi termina il processo con `exit`.

## Invarianti

- **STREAM-VIDEO-INV-1** — Un utente non autenticato riceve `401` (`abort`).
  Test: `tests/Unit/MediaGapAttackCoverageTest.php:88` (solo presenza della classe; nessun test del caso 401 trovato).
- **STREAM-VIDEO-INV-2** — Se `$media` è presente, `created_by` deve coincidere con l'utente (confronto `!=`) oppure l'utente deve avere `super-admin`; altrimenti `403`.
  Test: nessuno.

### `contracts/strip-image-metadata-action.md` — StripImageMetadataAction


# StripImageMetadataAction

Riscrive l'originale JPEG o PNG di un media senza metadati (EXIF, posizione GPS, fotocamera, XMP, chunk di testo).
Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/Image/StripImageMetadataAction.php`. Perche': [ADR](../adr/strip-image-metadata-server-side.md).

> Nessun chiamante nel modulo ne' in questo progetto (`rg StripImageMetadataAction` trova solo la definizione e il test): la
> richiama il codice del progetto ospite che la adotta, dopo il salvataggio di una foto allegata (vedi
> [la story](../stories/media-mobile-camera-upload.story.md)).

## Input

- `Spatie\MediaLibrary\MediaCollections\Models\Media $media` gia' salvato, con il file sul suo `disk`: usa `mime_type`, `disk`, `getPathRela

### `contracts/svg-exists-action.md` — SvgExistsAction


# SvgExistsAction

Dice se un nome di icona è registrato in uno dei set BladeUI Icons. Codice: `app/Actions/Image/SvgExistsAction.php:16-50`.

## Input

- `string $svgName`: nome completo, es. `heroicon-o-user`.

## Output

- `bool`: `true` se il nome è nella lista di almeno un set.

## Invarianti

- **SVG-EXISTS-INV-1** — Stringa vuota (`empty()`) restituisce `false` senza interrogare il registro. Attenzione: `empty('0')` è vero, quindi anche `'0'` restituisce `false`.
  Test: nessuno.
- **SVG-EXISTS-INV-2** — Il confronto è esatto e case-sensitive sul nome.
  Test: nessuno.
- **SVG-EXISTS-INV-3** — La struttura dei set (array con chiave `icons` iterabile) è verificata con `Assert`; una struttura diversa lancia eccezione.

### `contracts/template.md` — <operazione> — contratto comportamentale


# <operazione> — contratto comportamentale

Classe o superficie: `<FQCN>`  
Riferimento nel codice: `@contract docs/contracts/<file>.md`

## Input

- <input e validazione>

## Output

- <risultato osservabile>

## Invarianti

| ID | Regola | Verifica |
|---|---|---|
| `<MODULE>-INV-1` | <regola che deve restare vera> | <test o controllo ripetibile> |


### `contracts/test-bucket-permissions-action.md` — TestBucketPermissionsAction


# TestBucketPermissionsAction

Prova in sequenza i permessi del bucket: list, put, get, delete di un oggetto di prova. Codice: `app/Actions/Diagnostic/S3/TestBucketPermissionsAction.php:22-112`.

## Input

- `string $testKeyPrefix = 'test-permissions-'`: prefisso della chiave di prova (aggiunge `time()` e `.txt`).

## Output

- `array`: `title` (`🔒 S3 Permissions`), `status`, `data` con `ListBucket`, `PutObject`, `GetObject`, `DeleteObject` (✅ OK o ❌ codice). Se la put fallisce, get e delete sono `Skipped`.

## Invarianti

- **TEST-BUCKET-PERMISSIONS-INV-1** — Se nessuna eccezione esce, lo `status` è sempre `success`, anche quando una probe fallisce: `success` indica solo che la diagnostica è stata completata.
  Test: nessuno.
- **TEST-BUCKET-PERMISSIONS-INV-2** — Se la put fallisce, get 

### `contracts/test-connection-details-action.md` — TestConnectionDetailsAction


# TestConnectionDetailsAction

Verifica il bucket con `headBucket`, legge la sua region con `getBucketLocation` e la confronta con la config. Codice: `app/Actions/Diagnostic/S3/TestConnectionDetailsAction.php:19-53`.

## Input

- Nessuno. Usa `CreateFilesystemS3ClientAction`.

## Output

- Successo: `status=success`, `data` con `Bucket Accessible`, `Bucket Region`, `Config Region`, `Region Match` (✅ o ⚠️).
- `AwsException`: `status=error` con `Error Code`, `Message`, `Solution`.

## Invarianti

- **TEST-CONNECTION-DETAILS-INV-1** — Una `LocationConstraint` vuota è letta come `us-east-1`.
  Test: nessuno.
- **TEST-CONNECTION-DETAILS-INV-2** — Un mismatch di region non cambia lo `status`: resta `success` con l'avviso nel `Region Match`.
  Test: nessuno.

### `contracts/test-credentials-action.md` — TestCredentialsAction


# TestCredentialsAction

Verifica le credenziali con STS `GetCallerIdentity` e restituisce account e ARN. Codice: `app/Actions/Diagnostic/S3/TestCredentialsAction.php:18-43`.

## Input

- Nessuno. Usa `CreateFilesystemStsClientAction`.

## Output

- Successo: `status=success`, `data` con `Valid = ✅ Yes`, `Account ID`, `User ARN`.
- `AwsException`: `status=error`, `data` con `Valid = ❌ No`, `Error` (codice), `Message`.

## Invarianti

- **TEST-CREDENTIALS-INV-1** — Una risposta valida produce `success` con account e ARN.
  Test: nessuno.
- **TEST-CREDENTIALS-INV-2** — `AwsException` diventa `status=error`.
  Test: nessuno.

### `contracts/test-file-upload-download-action.md` — TestFileUploadDownloadAction


# TestFileUploadDownloadAction

Prova upload, download, confronto del contenuto, esistenza e dimensione di un file su S3. Codice: `app/Actions/Diagnostic/S3/TestFileUploadDownloadAction.php:21-83`.

## Input

- Nessuno. Il file è `test-file-<time()>.txt` con un contenuto fisso.

## Output

- Successo: `status=success`, `details` con `file_uploaded`, `file_downloaded`, `content_verified`, `file_exists_check`, `file_size`, `cleanup_completed`, `test_file`.
- Errore: `status=error` con `message` e `details` (per le eccezioni: classe, file e riga).

## Invarianti

- **TEST-FILE-UPLOAD-DOWNLOAD-INV-1** — Il successo richiede che il contenuto scaricato sia identico a quello caricato.
  Test: nessuno.
- **TEST-FILE-UPLOAD-DOWNLOAD-INV-2** — Se `put` restituisce falso l'Action risponde con errore

### `contracts/test-iam-credentials-action.md` — TestIamCredentialsAction


# TestIamCredentialsAction

Verifica le credenziali chiamando STS `GetCallerIdentity`. Codice: `app/Actions/Diagnostic/Aws/TestIamCredentialsAction.php:17-43`.

## Input

- Nessuno. Usa `CreateFilesystemStsClientAction`.

## Output

- Successo: `status=success`, `details` con `Account`, `ARN`, `User ID` (`Unknown` se assenti).
- `AwsException`: `status=error`, `message` = `IAM credentials error: <codice>`, `details` con `Error` e `Solution` fissa.

## Invarianti

- **TEST-IAM-CREDENTIALS-INV-1** — Una risposta STS valida produce `success` con i tre campi identità.
  Test: nessuno.
- **TEST-IAM-CREDENTIALS-INV-2** — `AwsException` non esce dall'Action: diventa `status=error`.
  Test: nessuno.

### `contracts/test-iam-policies-action.md` — TestIamPoliciesAction


# TestIamPoliciesAction

Verifica indirettamente le policy IAM provando `headBucket` e `listObjectsV2` sul bucket. Codice: `app/Actions/Diagnostic/Aws/TestIamPoliciesAction.php:17-47`.

## Input

- Nessuno. Usa `CreateFilesystemS3ClientAction` (client e bucket).

## Output

- Successo: `status=success` con `S3 Access`, `List Objects`, `Bucket Access` sempre `OK`.
- `AwsException`: `status=error`, `message` = `IAM policies error: <codice>`, `Solution` fissa.

## Invarianti

- **TEST-IAM-POLICIES-INV-1** — Il successo richiede entrambe le chiamate (HEAD bucket e list con `MaxKeys=1`) senza eccezioni.
  Test: nessuno.

## Effetti collaterali

### `contracts/update-model-subtitle-field-action.md` — UpdateModelSubtitleFieldAction


# UpdateModelSubtitleFieldAction

Estrae il testo di un sottotitolo e lo salva in un campo del modello. Codice: `app/Actions/Subtitle/UpdateModelSubtitleFieldAction.php:13-25`.

## Input

- `Model $model`: il modello da aggiornare.
- `string $filePath`: file XML di sottotitoli.
- `string $fieldName = 'txt'`: campo di destinazione.

## Output

- `Model`: lo stesso modello dopo `update()`.

## Invarianti

- **UPDATE-MODEL-SUBTITLE-FIELD-INV-1** — Il valore salvato è quello restituito da `ExtractSubtitlePlainTextAction`.
  Test: `tests/Unit/Actions/Subtitle/SubtitleTextActionsTest.php:46`.


### `contracts/upload-file-action.md` — UploadFileAction


# UploadFileAction

Carica un file locale su S3 con `ObjectUploader` (multipart automatico per i file grandi). Codice: `app/Actions/S3/UploadFileAction.php:26-112`.

## Input

- `string $localFilePath`: file locale leggibile.
- `string $destinationFilePath`: chiave S3 di destinazione.
- `array<string, mixed> $options`: opzioni AWS, unite a un default (`ACL=private`, `ContentType` da `mime_content_type` o `application/octet-stream`); i valori passati vincono.

## Output

- Successo: `['success' => true, 'objectUrl', 'etag', 'key', 'bucket']`.
- Errore: `['success' => false, 'error' => messaggio]` (con `errorTrace` per le eccezioni in upload).

## Invarianti

- **UPLOAD-FILE-INV-1** — Un file inesistente o non leggibile non produce eccezione: restituisce `success=false` e registra un errore
