# FileUpload Components in XotBaseResource

## Overview

Il metodo `getAttachmentsSchema()` in `XotBaseResource` gestisce la creazione dinamica di componenti FileUpload per i modelli che definiscono la proprietà `$attachments`. Questa documentazione descrive l'implementazione corretta e i problemi comuni.

## Architettura

### Proprietà del Modello

I modelli che supportano allegati devono definire:

```php
class Patient extends BaseModel
{
    /**
     * Lista degli allegati supportati dal modello.
     *
     * @var array<string>
     */
    public static array $attachments = [
        'health_card',
        'identity_document', 
        'isee_certificate',
        'pregnancy_certificate'
    ];
}
```

### Metodo getAttachmentsSchema()

```php
public static function getAttachmentsSchema(bool $multiple=true): array
{
    $model = static::getModel();
    $attachments = $model::$attachments;
    $uuid = Str::uuid()->toString();
    $schema = [];
    
    foreach ($attachments as $attachment) {
        $schema[] = Forms\Components\FileUpload::make($attachment)
            ->disk('local')
            ->directory('documents/'.$attachment.'/'.$uuid)
            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'])
            ->maxSize(5120*2) // 10MB
            ->required()
            ->multiple($multiple)
            ->preserveFilenames()
            ->columnSpanFull()
            ->afterStateUpdated(function ($state, Forms\Set $set) use ($attachment, $multiple) {
                if (!$state) return;
                
                // Normalizza sempre come array per consistenza
                $files = is_array($state) ? $state : [$state];
                $sessionId = session()->getId();
                $sessionDir = "session-uploads/{$sessionId}";
                $sessionFiles = [];
                
                foreach ($files as $file) {
                    if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                        // Nuovo file caricato
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $sessionPath = $file->storeAs($sessionDir, $fileName, 'local');
                        $sessionFiles[] = $sessionPath;
                    } else {
                        // File già salvato in precedenza
                        $sessionFiles[] = $file;
                    }
                }
                
                // Imposta il valore corretto nel form
                $finalValue = $multiple ? $sessionFiles : ($sessionFiles[0] ?? null);
                $set($attachment, $finalValue);
            });
    }
    
    return $schema;
}
```

## Problemi Comuni Risolti

### 1. Errore "foreach() argument must be of type array|object, string given"

**Causa**: Il callback `formatStateUsing` aveva una variabile non inizializzata:

```php
// ❌ ERRORE
->formatStateUsing(function ($state,$set) use ($attachment) {
    $sessionFiles[] = $state;  // $sessionFiles non inizializzato
    $set($attachment, $sessionFiles);
})
```

**Soluzione**: Rimosso `formatStateUsing` e migliorato `afterStateUpdated` con type checking.

### 2. Gestione Inconsistente dei Tipi

**Problema**: Filament si aspetta array per i file, ma a volte riceveva stringhe.

**Soluzione**: Normalizzazione dei dati:

```php
// Sempre normalizza come array
$files = is_array($state) ? $state : [$state];
```

### 3. Gestione Multiple/Single Files

**Problema**: Il parametro `$multiple` non veniva utilizzato correttamente.

**Soluzione**: Controllo esplicito del valore finale:

```php
$finalValue = $multiple ? $sessionFiles : ($sessionFiles[0] ?? null);
$set($attachment, $finalValue);
```

## Best Practices

### 1. Type Safety

```php
// ✅ Sempre verificare i tipi
if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
    // Gestione nuovo file
} else {
    // Gestione file esistente
}
```

### 2. Error Handling

```php
// ✅ Gestione graceful degli errori
->afterStateUpdated(function ($state, Forms\Set $set) use ($attachment, $multiple) {
    if (!$state) return;
    
    try {
        // Logica di gestione file
    } catch (\Exception $e) {
        \Log::error("Errore upload {$attachment}: " . $e->getMessage());
        // Fallback appropriato
    }
})
```

### 3. Naming Conventions

```php
// ✅ Nomi descrittivi per i file
$fileName = time() . '_' . $file->getClientOriginalName();
```

### 4. Directory Structure

```php
// ✅ Struttura organizzata per tipo e sessione
$directory = 'documents/'.$attachment.'/'.$uuid;
$sessionDir = "session-uploads/{$sessionId}";
```

## Configurazione per Diversi Contesti

### Per Moduli Pubblici (Registration)

```php
// Non richiedere autenticazione
public static function getAttachmentsSchema(bool $multiple=false): array
{
    // Configurazione per upload anonimi
    // Directory temporanee per sessione
    // Validazione rigorosa file types
}
```

### Per Admin Panel

```php
// Richiedere autenticazione
public static function getAttachmentsSchema(bool $multiple=true): array
{
    // Configurazione per utenti autenticati
    // Directory permanenti
    // Funzionalità download/preview
}
```

## Testing

### Unit Tests

```php
class FileUploadTest extends TestCase
{
    /** @test */
    public function it_handles_single_file_upload()
    {
        $file = UploadedFile::fake()->create('test.pdf', 1024);
        
        // Test logic
    }
    
    /** @test */
    public function it_handles_multiple_files_upload()
    {
        $files = [
            UploadedFile::fake()->create('test1.pdf', 1024),
            UploadedFile::fake()->create('test2.pdf', 1024)
        ];
        
        // Test logic
    }
    
    /** @test */
    public function it_validates_file_types()
    {
        $invalidFile = UploadedFile::fake()->create('test.exe', 1024);
        
        // Test validation
    }
}
```

### Integration Tests

```php
class RegistrationWidgetTest extends TestCase
{
    /** @test */
    public function it_persists_files_through_wizard_steps()
    {
        // Test file persistence across steps
    }
    
    /** @test */
    public function it_handles_session_expiry()
    {
        // Test behavior when session expires
    }
}
```

## Monitoring e Debugging

### Logging

```php
// Log per monitoraggio upload
\Log::info("File uploaded", [
    'attachment' => $attachment,
    'filename' => $fileName,
    'size' => $file->getSize(),
    'session_id' => session()->getId()
]);
```

### Metriche

- Numero di upload per tipo
- Dimensioni medie dei file
- Errori di upload per categoria
- Performance upload per sessione

## Sicurezza

### 1. Validazione File Types

```php
->acceptedFileTypes([
    'application/pdf', 
    'image/jpeg', 
    'image/png', 
    'image/jpg'
])
```

### 2. Limite Dimensioni

```php
->maxSize(5120*2) // 10MB max
```

### 3. Scansione Antivirus

```php
// Implementare scansione per file caricati
->afterStateUpdated(function ($state) {
    // Virus scanning logic
})
```

### 4. Pulizia File Temporanei

```php
// Job per pulizia periodica
class CleanupTemporaryFilesJob extends Job
{
    public function handle()
    {
        // Rimuovi file più vecchi di 24h
    }
}
```

## Performance

### 1. Chunk Upload per File Grandi

```php
->chunkSize(1024) // 1MB chunks
```

### 2. Compressione Immagini

```php
->imageResizeMode('cover')
->imageCropAspectRatio('16:9')
->imageResizeTargetWidth('1920')
->imageResizeTargetHeight('1080')
```

### 3. Storage Ottimizzato

```php
// Configurazione disk per performance
'local' => [
    'driver' => 'local',
    'root' => storage_path('app'),
    'permissions' => [
        'file' => [
            'public' => 0644,
            'private' => 0600,
        ],
        'dir' => [
            'public' => 0755,
            'private' => 0700,
        ],
    ],
],
```

## Riferimenti

- [Filament FileUpload Documentation](https://filamentphp.com/project_docs/3.x/forms/fields/file-upload)
- [Laravel File Storage](https://laravel.com/project_docs/10.x/filesystem)
- [docs/fileupload-foreach-error-fix.md](../../../project_docs/fileupload-foreach-error-fix.md)
- [Modules/User/project_docs/registration-widget.md](../../User/project_docs/registration-widget.md)

*Ultimo aggiornamento: 2025-01-03* 