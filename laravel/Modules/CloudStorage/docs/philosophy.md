# CloudStorage Module - Filosofia Completa

**Data Creazione**: 2025-01-18  
**Status**: Documentazione Filosofica Completa  
**Versione**: 1.0.0  
**Autore**: Analisi Completa del Sistema

---

## 📋 Indice Completo

1. [Panoramica Generale](#panoramica-generale)
2. [Filosofia e Principi](#filosofia-e-principi)
3. [Architettura](#architettura)
4. [Modelli e Relazioni](#modelli-e-relazioni)
5. [Pattern Architetturali](#pattern-architetturali)
6. [Workflow e Flussi](#workflow-e-flussi)
7. [Integrazioni](#integrazioni)
8. [Sicurezza](#sicurezza)
9. [Best Practices](#best-practices)

---

## Panoramica Generale

### Il Modulo CloudStorage

Il modulo **CloudStorage** fornisce un'astrazione multi-provider per la gestione di file su cloud storage providers (Google Drive, Dropbox, AWS S3, etc.). Il modulo gestisce il ciclo di vita completo dei file: upload, processamento, storage, condivisione, e cancellazione.

### Stack Tecnologico

- **Spatie Laravel Google Cloud Storage**: Integrazione Google Drive
- **Google API Client**: Comunicazione con Google APIs
- **Laravel Storage**: Astrazione storage Laravel
- **Encryption**: Crittografia file sensibili
- **Queue System**: Upload asincroni e processamento

### Scopo Principale

1. **Multi-Provider Abstraction**: Astrazione unificata per diversi cloud providers
2. **File Lifecycle Management**: Gestione completa del ciclo di vita dei file
3. **Security & Encryption**: Sicurezza e crittografia per file sensibili
4. **Usage Analytics**: Tracciamento accessi e download
5. **Sharing & Permissions**: Sistema di condivisione e permessi

---

## Filosofia e Principi

### Principio Fondamentale

**Il modulo CloudStorage è un'astrazione, non un'implementazione specifica.**

### Comandamenti Sacri

#### 1. Multi-Provider First

**Comandamento**: Il modulo deve supportare multipli provider senza dipendere da uno specifico.

**Violazione**: Hardcoding logica specifica per un provider è eresia.

**Manifestazione**:
```php
// ✅ CORRETTO - Provider abstraction
$file = CloudStorageFile::create([
    'provider' => 'google_drive', // Configurabile
    'storage_path' => $path,
]);

// ❌ ERESIA - Hardcoded provider
$file = GoogleDriveFile::create([...]); // Solo Google Drive
```

#### 2. File Lifecycle è Sacro

**Comandamento**: Ogni file ha uno stato preciso: pending → uploading → completed → (deleted/failed).

**Violazione**: Saltare stati o modificare stati manualmente è eresia.

**Manifestazione**:
```php
// ✅ CORRETTO - Lifecycle management
$file->status = 'pending';
$file->save();
// ... upload process ...
$file->status = 'uploading';
$file->save();
// ... upload complete ...
$file->status = 'completed';
$file->save();

// ❌ ERESIA - Skip states
$file->status = 'completed'; // Senza passare per uploading
```

#### 3. Encryption è Opzionale ma Sicura

**Comandamento**: Encryption è opzionale, ma quando abilitata deve essere sicura.

**Violazione**: Encryption debole o chiavi esposte è eresia.

**Manifestazione**:
```php
// ✅ CORRETTO - Secure encryption
if ($file->is_encrypted) {
    $key = $file->encryption_key; // Hidden in model
    $decrypted = decrypt($file->content, $key);
}

// ❌ ERESIA - Weak encryption
$file->content = base64_encode($content); // Non è encryption
```

#### 4. User Ownership è Obbligatoria

**Comandamento**: Ogni file deve avere un owner (user_id).

**Violazione**: File senza owner è eresia.

**Manifestazione**:
```php
// ✅ CORRETTO - User ownership
$file = CloudStorageFile::create([
    'user_id' => auth()->id(),
    'name' => 'document.pdf',
]);

// ❌ ERESIA - No owner
$file = CloudStorageFile::create([
    'name' => 'document.pdf', // Senza user_id
]);
```

#### 5. Metadata è Strutturato

**Comandamento**: Metadata deve essere strutturato (array), non stringa.

**Violazione**: Metadata come stringa JSON è eresia.

**Manifestazione**:
```php
// ✅ CORRETTO - Structured metadata
$file->metadata = [
    'dimensions' => ['width' => 1920, 'height' => 1080],
    'duration' => 120, // seconds
];

// ❌ ERESIA - String metadata
$file->metadata = '{"width":1920,"height":1080}'; // String, non array
```

---

## Architettura

### Struttura Modulo

```
Modules/CloudStorage/
├── app/
│   ├── Models/
│   │   ├── BaseModel.php
│   │   ├── CloudStorageFile.php
│   │   ├── CloudStorageProvider.php
│   │   ├── CloudStorageUpload.php
│   │   ├── CloudStorageShare.php
│   │   └── CloudStorageQuota.php
│   ├── Services/
│   │   └── GoogleDriveService.php
│   ├── Actions/
│   ├── Filament/
│   └── Providers/
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
└── docs/
```

### Inheritance Chain

```
Illuminate\Database\Eloquent\Model
    ↓
Modules\Xot\Models\XotBaseModel
    ↓
Modules\CloudStorage\Models\BaseModel
    ↓
CloudStorageFile / CloudStorageProvider / etc.
```

**Regola Sacra**: Tutti i modelli CloudStorage estendono `BaseModel`, mai `XotBaseModel` direttamente.

### Connection Database

Il modulo usa una connection database dedicata: `cloudstorage`.

**Manifestazione**:
```php
abstract class BaseModel extends XotBaseModel
{
    protected $connection = 'cloudstorage';
}
```

---

## Modelli e Relazioni

### 1. CloudStorageFile

**Scopo**: Rappresenta un file memorizzato su cloud storage.

**Proprietà Chiave**:
- `name`: Nome file display
- `original_name`: Nome originale upload
- `mime_type`: Tipo MIME
- `size`: Dimensione in bytes
- `path`: Path locale
- `storage_path`: Path cloud storage
- `provider`: Provider cloud (google_drive, dropbox, aws_s3)
- `status`: Stato file (pending, uploading, completed, failed, deleted)
- `is_public`: File pubblico
- `is_encrypted`: File crittografato
- `encryption_key`: Chiave crittografia (hidden)
- `checksum`: Checksum integrità
- `metadata`: Metadata strutturato
- `user_id`: Owner file
- `folder_id`: Folder parent (TODO: implementare CloudStorageFolder)

**Relazioni**:
```php
// User ownership
public function user(): BelongsTo
{
    $userClass = \Modules\Xot\Datas\XotData::make()->getUserClass();
    return $this->belongsTo($userClass);
}

// Folder (TODO: implementare)
// public function folder(): BelongsTo
// {
//     return $this->belongsTo(CloudStorageFolder::class, 'folder_id');
// }
```

**Scopes**:
- `scopeStatus(Builder $query, string $status)`: Filtra per stato
- `scopeProvider(Builder $query, string $provider)`: Filtra per provider
- `scopePublic(Builder $query)`: Solo file pubblici
- `scopePrivate(Builder $query)`: Solo file privati
- `scopeEncrypted(Builder $query)`: Solo file crittografati
- `scopeCompleted(Builder $query)`: Solo file completati
- `scopeRecentlyAccessed(Builder $query, int $days)`: File accessi recenti

**Accessors**:
- `getHumanReadableSizeAttribute()`: Dimensione leggibile (KB, MB, GB)
- `getExtensionAttribute()`: Estensione file
- `getIsImageAttribute()`: È immagine?
- `getIsVideoAttribute()`: È video?
- `getIsDocumentAttribute()`: È documento?

**Metodi**:
- `markAsAccessed()`: Marca come accessato, incrementa view_count
- `incrementDownloads()`: Incrementa download_count
- `isCompleted()`: Verifica se completato
- `isPending()`: Verifica se pending
- `isUploading()`: Verifica se uploading
- `isFailed()`: Verifica se failed
- `isDeleted()`: Verifica se deleted

### 2. CloudStorageProvider

**Scopo**: Rappresenta configurazione provider cloud storage.

**Proprietà Chiave**:
- `name`: Nome provider
- `provider_key`: Chiave identificativa provider
- `api_key`: API key provider
- `api_secret`: API secret provider
- `access_token`: Access token OAuth
- `refresh_token`: Refresh token OAuth
- `bucket_name`: Nome bucket/container
- `region`: Regione storage
- `is_active`: Provider attivo
- `is_default`: Provider predefinito
- `priority`: Priorità provider
- `max_file_size`: Dimensione massima file
- `max_storage_size`: Storage massimo
- `used_storage_size`: Storage utilizzato
- `file_count`: Numero file
- `folder_count`: Numero folder
- `status`: Stato provider
- `last_sync_at`: Ultima sincronizzazione
- `last_error_at`: Ultimo errore
- `error_message`: Messaggio errore
- `retry_count`: Contatore retry
- `max_retries`: Retry massimi

**Relazioni**: Nessuna relazione diretta (configurazione standalone)

### 3. CloudStorageUpload

**Scopo**: Rappresenta sessione upload e chunked upload tracking.

**Proprietà Chiave**:
- `user_id`: Utente upload
- `file_name`: Nome file
- `original_name`: Nome originale
- `mime_type`: Tipo MIME
- `size`: Dimensione totale
- `total_chunks`: Numero totale chunk
- `uploaded_chunks`: Chunk caricati
- `chunk_size`: Dimensione chunk
- `upload_token`: Token upload
- `upload_path`: Path upload
- `temp_path`: Path temporaneo
- `final_path`: Path finale
- `provider`: Provider cloud
- `status`: Stato upload
- `progress_percentage`: Percentuale progresso
- `started_at`: Data inizio
- `completed_at`: Data completamento
- `failed_at`: Data fallimento
- `error_message`: Messaggio errore
- `retry_count`: Contatore retry
- `max_retries`: Retry massimi

**Relazioni**: Nessuna relazione diretta (sessione standalone)

### 4. CloudStorageShare

**Scopo**: Rappresenta condivisione file/folder e permessi.

**Proprietà Chiave**:
- `file_id`: ID file condiviso
- `folder_id`: ID folder condiviso
- `shared_by_user_id`: Utente che condivide
- `shared_with_user_id`: Utente con cui condividere
- `share_token`: Token condivisione
- `share_link`: Link condivisione
- `permission_level`: Livello permesso (read, write, admin)
- `is_public`: Condivisione pubblica
- `is_password_protected`: Protetto da password
- `password_hash`: Hash password
- `expires_at`: Scadenza condivisione
- `access_count`: Contatore accessi
- `last_accessed_at`: Ultimo accesso
- `max_downloads`: Download massimi
- `download_count`: Contatore download
- `status`: Stato condivisione

**Relazioni**: 
- `file()`: BelongsTo CloudStorageFile
- `folder()`: BelongsTo CloudStorageFolder (TODO)
- `sharedBy()`: BelongsTo User
- `sharedWith()`: BelongsTo User

### 5. CloudStorageQuota

**Scopo**: Rappresenta quota storage per utente/provider.

**Proprietà Chiave**:
- `user_id`: Utente quota
- `provider_id`: Provider quota
- `quota_limit`: Limite quota
- `quota_used`: Quota utilizzata
- `quota_percentage`: Percentuale utilizzo
- `file_count_limit`: Limite numero file
- `file_count_used`: File utilizzati
- `last_calculated_at`: Ultimo calcolo
- `settings`: Impostazioni quota
- `metadata`: Metadata quota

**Relazioni**:
- `user()`: BelongsTo User
- `provider()`: BelongsTo CloudStorageProvider

---

## Pattern Architetturali

### 1. Service Pattern

**Logica**: Servizi gestiscono comunicazione con provider esterni.

**Manifestazione**:
```php
class GoogleDriveService
{
    protected Client $client;
    protected Drive $driveService;
    
    public function __construct()
    {
        // Configurazione Google Client
        $this->client = new Client;
        $this->client->setClientId(config('services.google.client_id'));
        // ...
        $this->driveService = new Drive($this->client);
    }
    
    public function getFiles(): array
    {
        // Logica recupero file
    }
}
```

**Filosofia**: Servizi incapsulano logica provider-specific, modelli rimangono provider-agnostic.

### 2. Factory Pattern

**Logica**: Factories per creazione dati test.

**Manifestazione**:
```php
CloudStorageFileFactory::new()
    ->provider('google_drive')
    ->status('completed')
    ->create();
```

**Filosofia**: Factories permettono creazione dati test consistenti e riproducibili.

### 3. Policy Pattern

**Logica**: Policies gestiscono autorizzazioni file.

**Manifestazione**:
```php
class CloudstorageBasePolicy extends XotBasePolicy
{
    // Autorizzazioni file
}
```

**Filosofia**: Policies centralizzano logica autorizzazioni, modelli rimangono semplici.

---

## Workflow e Flussi

### 1. Upload Workflow

**Flusso**:
1. Creazione `CloudStorageUpload` (status: pending)
2. Inizio upload (status: uploading)
3. Upload chunk (progress_percentage aggiornato)
4. Completamento upload (status: completed)
5. Creazione `CloudStorageFile` (status: completed)
6. Eliminazione `CloudStorageUpload`

**Manifestazione**:
```php
// 1. Creazione upload session
$upload = CloudStorageUpload::create([
    'user_id' => auth()->id(),
    'file_name' => 'document.pdf',
    'status' => 'pending',
]);

// 2. Inizio upload
$upload->status = 'uploading';
$upload->started_at = now();
$upload->save();

// 3. Upload chunk
foreach ($chunks as $chunk) {
    // Upload chunk
    $upload->uploaded_chunks++;
    $upload->progress_percentage = ($upload->uploaded_chunks / $upload->total_chunks) * 100;
    $upload->save();
}

// 4. Completamento
$upload->status = 'completed';
$upload->completed_at = now();
$upload->save();

// 5. Creazione file
$file = CloudStorageFile::create([
    'user_id' => $upload->user_id,
    'name' => $upload->file_name,
    'status' => 'completed',
    'provider' => $upload->provider,
]);

// 6. Eliminazione upload session
$upload->delete();
```

### 2. Sharing Workflow

**Flusso**:
1. Creazione `CloudStorageShare` (file_id, shared_by_user_id, shared_with_user_id)
2. Generazione `share_token` e `share_link`
3. Impostazione permessi (permission_level)
4. Tracciamento accessi (access_count, last_accessed_at)
5. Scadenza automatica (expires_at)

**Manifestazione**:
```php
// 1. Creazione share
$share = CloudStorageShare::create([
    'file_id' => $file->id,
    'shared_by_user_id' => auth()->id(),
    'shared_with_user_id' => $targetUser->id,
    'share_token' => Str::random(64),
    'share_link' => route('cloudstorage.share', ['token' => $token]),
    'permission_level' => 'read',
    'expires_at' => now()->addDays(7),
]);

// 2. Accesso share
$share->increment('access_count');
$share->last_accessed_at = now();
$share->save();
```

### 3. Provider Sync Workflow

**Flusso**:
1. Recupero file da provider esterno
2. Sincronizzazione con database locale
3. Aggiornamento `CloudStorageProvider` (last_sync_at, file_count, used_storage_size)
4. Gestione errori (last_error_at, error_message, retry_count)

**Manifestazione**:
```php
// 1. Recupero file provider
$provider = CloudStorageProvider::where('is_active', true)->first();
$service = app(GoogleDriveService::class);
$files = $service->getFiles();

// 2. Sincronizzazione
foreach ($files as $fileData) {
    CloudStorageFile::updateOrCreate(
        ['storage_path' => $fileData['id']],
        [
            'name' => $fileData['name'],
            'provider' => $provider->provider_key,
            'status' => 'completed',
        ]
    );
}

// 3. Aggiornamento provider
$provider->last_sync_at = now();
$provider->file_count = CloudStorageFile::where('provider', $provider->provider_key)->count();
$provider->used_storage_size = CloudStorageFile::where('provider', $provider->provider_key)->sum('size');
$provider->save();
```

---

## Integrazioni

### 1. Google Drive Integration

**Service**: `GoogleDriveService`

**Configurazione**:
- `services.google.client_id`
- `services.google.client_secret`
- `services.google.redirect`
- `services.google.scopes`

**Manifestazione**:
```php
$service = app(GoogleDriveService::class);
$files = $service->getFiles();
```

**Filosofia**: Service incapsula logica Google-specific, modelli rimangono provider-agnostic.

### 2. Laravel Storage Integration

**Manifestazione**:
```php
Storage::disk('cloudstorage')->put($path, $content);
```

**Filosofia**: Usa Laravel Storage abstraction quando possibile, service provider-specific quando necessario.

### 3. Queue Integration

**Manifestazione**:
```php
UploadFileAction::dispatch($file)->onQueue('cloudstorage');
```

**Filosofia**: Upload e processamento asincroni per performance e scalabilità.

---

## Sicurezza

### 1. Encryption

**Principio**: Encryption opzionale ma sicura quando abilitata.

**Manifestazione**:
```php
if ($file->is_encrypted) {
    $key = $file->encryption_key; // Hidden in model
    $decrypted = decrypt($file->content, $key);
}
```

**Best Practice**: Usa Laravel encryption, non implementazioni custom.

### 2. Access Control

**Principio**: Ogni file ha owner, sharing controllato da policies.

**Manifestazione**:
```php
// Policy check
if (Gate::allows('view', $file)) {
    // Accesso consentito
}
```

**Best Practice**: Usa Laravel Policies, non logica custom nei controller.

### 3. Token Security

**Principio**: Token condivisione devono essere sicuri e scadenti.

**Manifestazione**:
```php
$share->share_token = Str::random(64); // Sicuro
$share->expires_at = now()->addDays(7); // Scadente
```

**Best Practice**: Token lunghi, random, con scadenza.

---

## Best Practices

### 1. Provider Abstraction

**Pratica**: Usa provider abstraction, non logica provider-specific.

**Esempio**:
```php
// ✅ CORRETTO
$file->provider = 'google_drive';
$service = app(CloudStorageService::class)->getProvider($file->provider);

// ❌ SBAGLIATO
if ($file->provider === 'google_drive') {
    $service = app(GoogleDriveService::class);
}
```

### 2. Lifecycle Management

**Pratica**: Rispetta lifecycle file, non saltare stati.

**Esempio**:
```php
// ✅ CORRETTO
$file->status = 'pending';
$file->save();
// ... process ...
$file->status = 'uploading';
$file->save();

// ❌ SBAGLIATO
$file->status = 'completed'; // Skip states
```

### 3. Metadata Structure

**Pratica**: Metadata sempre strutturato (array), non stringa.

**Esempio**:
```php
// ✅ CORRETTO
$file->metadata = ['width' => 1920, 'height' => 1080];

// ❌ SBAGLIATO
$file->metadata = '{"width":1920,"height":1080}';
```

### 4. User Ownership

**Pratica**: Ogni file deve avere owner.

**Esempio**:
```php
// ✅ CORRETTO
$file = CloudStorageFile::create([
    'user_id' => auth()->id(),
    'name' => 'document.pdf',
]);

// ❌ SBAGLIATO
$file = CloudStorageFile::create([
    'name' => 'document.pdf', // No owner
]);
```

### 5. Queue for Heavy Operations

**Pratica**: Upload e processamento pesanti in queue.

**Esempio**:
```php
// ✅ CORRETTO
UploadFileAction::dispatch($file)->onQueue('cloudstorage');

// ❌ SBAGLIATO
$file->upload(); // Synchronous, blocks request
```

---

## Conclusioni

### Filosofia Completa

Il modulo CloudStorage è un'astrazione multi-provider che gestisce il ciclo di vita completo dei file su cloud storage. Il modulo segue principi di semplicità, sicurezza, e provider-agnostic design.

### Principi Fondamentali

1. **Multi-Provider First**: Astrazione, non implementazione specifica
2. **File Lifecycle è Sacro**: Rispetta stati, non saltare
3. **Encryption è Opzionale ma Sicura**: Quando abilitata, deve essere sicura
4. **User Ownership è Obbligatoria**: Ogni file ha owner
5. **Metadata è Strutturato**: Array, non stringa

### Prossimi Passi

1. Implementare `CloudStorageFolder` model
2. Aggiungere supporto per altri provider (Dropbox, AWS S3)
3. Implementare quota management completo
4. Aggiungere test coverage completo
5. Documentare API endpoints

---

**Ultimo Aggiornamento**: 2025-01-18  
**Versione**: 1.0.0

