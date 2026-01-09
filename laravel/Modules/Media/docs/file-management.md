# Gestione dei File in SaluteOra

## Panoramica

Questo documento descrive le best practice per la gestione dei file in SaluteOra, inclusi il caricamento, l'archiviazione e l'accesso ai file in diverse parti dell'applicazione.

## Struttura delle Directory

SaluteOra utilizza una struttura organizzata per l'archiviazione dei file:

```
/storage
  /app
    /public
      /avatars            # Avatar degli utenti
      /certifications     # Certificazioni dei dottori
      /documents          # Documenti generali
      /reports            # Report e documenti generati
      /temp               # File temporanei
```

## Caricamento dei File

### Utilizzo di Filament

Per i form amministrativi, SaluteOra utilizza il componente `FileUpload` di Filament:

```php
use Filament\Forms\Components\FileUpload;

FileUpload::make('certifications')
    ->multiple()
    ->directory('certifications')
    ->acceptedFileTypes(['application/pdf'])
    ->maxSize(5120) // 5MB
```

Per una documentazione dettagliata sull'utilizzo di `FileUpload`, consulta la [Gestione dei File Upload in Filament](/docs/filament-file-uploads.md).

### Utilizzo di Livewire

Per i form frontend, SaluteOra utilizza Livewire:

```php
public function save()
{
    $this->validate([
        'document' => 'required|file|mimes:pdf|max:5120',
    ]);

    $path = $this->document->store('documents', 'public');

    // Salvataggio del percorso nel database
    $this->model->update(['document_path' => $path]);
}
```

## Archiviazione dei File nel Database

### File Singoli

Per i campi che contengono un singolo file, utilizzare un campo stringa:

```php
Schema::table('users', function (Blueprint $table) {
    $table->string('avatar')->nullable();
});
```

### File Multipli

Per i campi che contengono più file, utilizzare un campo JSON:

```php
Schema::table('users', function (Blueprint $table) {
    $table->json('certifications')->nullable();
});
```

Per una documentazione dettagliata sulla mappatura dei campi, consulta la [Mappatura dei Campi Database nel Modulo Patient](/laravel/Modules/Patient/docs/DATABASE_FIELD_MAPPING.md).

## Accesso ai File

### Generazione di URL

Per generare URL per i file archiviati:

```php
$url = Storage::url($path);
```

### Controllo degli Accessi

SaluteOra implementa un sistema di controllo degli accessi per i file sensibili:

```php
// In un controller
public function download($id)
{
    $document = Document::findOrFail($id);

    if (! auth()->user()->can('view', $document)) {
        abort(403);
    }

    return Storage::download($document->path);
}
```

## Gestione dei File Temporanei

Per i file che devono essere elaborati prima di essere archiviati permanentemente:

```php
$tempPath = $file->store('temp', 'public');

// Elaborazione del file...

// Spostamento nella posizione finale
Storage::move($tempPath, 'documents/' . $fileName);
```

## Eliminazione dei File

Quando un record viene eliminato, è importante eliminare anche i file associati:

```php
// Nel modello
protected static function booted()
{
    static::deleting(function ($model) {
        if ($model->avatar) {
            Storage::delete($model->avatar);
        }

        if ($model->certifications) {
            foreach ($model->certifications as $certification) {
                Storage::delete($certification);
            }
        }
    });
}
```

## Best Practices

1. **Validazione Rigorosa**: Validare sempre i file in base al tipo, dimensione e altri criteri di sicurezza
2. **Nomi File Sicuri**: Generare nomi file sicuri per evitare conflitti e problemi di sicurezza
3. **Controllo degli Accessi**: Implementare un controllo degli accessi rigoroso per i file sensibili
4. **Pulizia dei File Temporanei**: Implementare un job pianificato per eliminare i file temporanei non utilizzati
5. **Backup**: Includere i file caricati nei backup regolari del sistema

## Documentazione Correlata

- [Gestione dei File Upload in Filament](/docs/filament-file-uploads.md)
- [Mappatura dei Campi Database nel Modulo Patient](/laravel/Modules/Patient/docs/DATABASE_FIELD_MAPPING.md)
- [Migrazioni del Database](/docs/database-migrations.md)
- [Gestione degli Utenti](/docs/user-management.md)
- [Pattern di Ereditarietà dei Modelli](/docs/model-inheritance-patterns.md)
