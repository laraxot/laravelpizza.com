# Media module overview

## Scopo ("perché esiste")

Il modulo `Media` fornisce la gestione centralizzata dei contenuti multimediali (file, metadati, conversioni) per l’applicazione.

Nel codebase corrente il “cuore” non è un’implementazione custom, ma un’integrazione orchestrata di:

- `spatie/laravel-medialibrary` (modello `Modules\Media\Models\Media` estende `Spatie\MediaLibrary\MediaCollections\Models\Media`)
- storage Laravel (disk e path)
- pipeline di conversione video (FFmpeg / `pbmedia/laravel-ffmpeg`)
- backoffice Filament (Resources/RelationManagers per ispezione e gestione record)

## Entry points (boot e integrazione framework)

- **Nwidart module registration**: `module.json`
  - Provider: `Modules\Media\Providers\MediaServiceProvider`
  - Provider Filament panel: `Modules\Media\Providers\Filament\AdminPanelProvider`

- **Service Provider**: `Modules/Media/app/Providers/MediaServiceProvider.php`
  - Estende `Modules\Xot\Providers\XotBaseServiceProvider`
  - Nome modulo: `Media`

- **Route provider**: `Modules/Media/app/Providers/RouteServiceProvider.php`
  - Estende `Modules\Xot\Providers\XotBaseRouteServiceProvider`

- **Filament panel provider**: `Modules/Media/app/Providers/Filament/AdminPanelProvider.php`
  - Estende `Modules\Xot\Providers\Filament\XotBasePanelProvider`

## Modelli e dominio (business logic)

### `Modules\Media\Models\Media`

- Estende `SpatieMedia` (Spatie MediaLibrary)
- È la fonte di verità per i record media (metadati, disk, path, conversions, responsive images)
- In questo progetto il modello include anche logiche di auditing (`created_by`, `updated_by`, `deleted_by`) e integrazione con profili/utenti tramite contratti (`ProfileContract`, `UserContract`) — da verificare dove viene popolato il contesto.

### `Modules\Media\Models\MediaConvert`

- Modello applicativo (estende `BaseModel` del modulo) che rappresenta lo stato di una conversione/trascodifica.
- Espone attributi derivati “virtuali” tramite accessor:
  - `disk` (derivato dalla relazione `media`)
  - `file` (path + filename)
  - `converted_file` (costruzione file output in `path/conversions/…`)

**Invariante**: `MediaConvert` ha senso solo se è associato a `Media` (`media_id`). Se `media` è `null`, gli accessor ritornano `null`.

## Filament (backoffice)

Il modulo espone risorse Filament per gestire e osservare i record:

- `Modules\Media\Filament\Resources\MediaResource`
- `Modules\Media\Filament\Resources\MediaConvertResource`
- Relation manager: `Modules\Media\Filament\Resources\HasMediaResource\RelationManagers\MediaRelationManager` (estende `XotBaseRelationManager`)

### Regola architetturale (religione / “zen”)

- **Non estendere classi Filament direttamente** quando esiste una controparte XotBase.
- Le risorse devono estendere `Modules\Xot\Filament\Resources\XotBaseResource`.
- I relation manager devono estendere `Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager`.

## Pipeline conversione video (FFmpeg)

Nel modulo sono presenti azioni e risorse che orchestrano conversioni (es. WebM) tramite FFmpeg. L’integrazione tipica prevede:

- individuazione del file sorgente (disk + path)
- costruzione path target
- export/convert con progress
- persistenza di stato/progress (tipicamente su `MediaConvert` o su notification/logging)

## Invarianti (politica / regole non negoziabili)

- **Single source of truth** per i media record: `Modules\Media\Models\Media` (Spatie MediaLibrary)
- **Disk + path** devono essere coerenti con configurazione storage; evitare path assoluti in docs e codice.
- **Backoffice = Filament**, con wrapper XotBase.
- **Docs**: mantenere link relativi e naming lowercase.

## Osservazioni sulla documentazione esistente (da riallineare)

- Alcuni documenti sono generici o riferiti ad altri domini/progetti (es. riferimenti “SaluteOra” in `file-management.md`).
- Ci sono duplicati e varianti con suffissi `_1`, file `.txt`, e copie `~head`.

## Da migliorare (DRY + KISS)

- **Pulizia docs**: eliminare duplicati (`*_1.md`), file `.txt` paralleli e file `~head` (consolidare su un solo documento per argomento).
- **Riallineare business logic**: riscrivere i documenti che parlano di “healthcare/SaluteOra” se non sono pertinenti al progetto corrente.
- **Link**: sostituire link assoluti nei `.md` con link relativi (policy progetto).
- **Filament wrappers**: audit completo del modulo per assicurare che Widgets/Pages/Resources estendano solo XotBase/UIBase.
- **Testing**: migrare test legacy PHPUnit-style verso Pest e spezzare file troppo grandi per ridurre warning PHPMD.
