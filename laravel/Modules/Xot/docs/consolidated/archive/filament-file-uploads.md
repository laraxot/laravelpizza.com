# Gestione dei File Upload in Filament

## Panoramica

Questo documento descrive le best practice per la gestione dei file upload nei form Filament di <nome progetto>, con particolare attenzione alla configurazione corretta dei componenti e alla mappatura dei campi del database.

## Configurazione del Componente FileUpload

Il componente `FileUpload` di Filament è utilizzato per gestire il caricamento di file nei form. È importante configurarlo correttamente per garantire che i file vengano salvati nella posizione corretta e che i dati vengano memorizzati nel formato appropriato nel database.

### Configurazione Base

```php
use Filament\Forms\Components\FileUpload;

FileUpload::make('field_name')
    ->directory('path/to/directory')
    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
    ->maxSize(5120) // 5MB
```

### File Singoli vs. Multiple

Per i campi che devono contenere un singolo file:

```php
// ✅ CORRETTO per un singolo file
FileUpload::make('avatar')
    ->directory('avatars')
    ->image()
```

Per i campi che devono contenere più file:

```php
// ✅ CORRETTO per file multipli
FileUpload::make('certifications')
    ->multiple()
    ->directory('certifications')
```

## Mappatura dei Campi del Database

È fondamentale che i campi utilizzati nei componenti `FileUpload` corrispondano ai campi disponibili nel database. Per una documentazione dettagliata sulla mappatura dei campi, consulta la [Mappatura dei Campi Database nel Modulo Patient](/laravel/Modules/Patient/project_docs/DATABASE_FIELD_MAPPING.md).

### Campi per File Singoli

I campi per file singoli memorizzano il percorso del file come stringa:

```php
$table->string('avatar')->nullable();
```

### Campi per File Multipli

I campi per file multipli memorizzano un array di percorsi come JSON:

```php
$table->json('certifications')->nullable();
```

## Errori Comuni

### 1. Utilizzo di Nomi di Campo Errati

```php
// ❌ ERRATO: 'certification' non esiste nella tabella users
FileUpload::make('certification')
    ->directory('certifications')

// ✅ CORRETTO: utilizzare 'certifications' (plurale)
FileUpload::make('certifications')
    ->multiple()
    ->directory('certifications')
```

### 2. Mancata Configurazione di `multiple()`

```php
// ❌ ERRATO: manca multiple() per un campo JSON
FileUpload::make('certifications')
    ->directory('certifications')

// ✅ CORRETTO: aggiungere multiple() per un campo JSON
FileUpload::make('certifications')
    ->multiple()
    ->directory('certifications')
```

## Gestione dei File nel Modello

I modelli che utilizzano file devono essere configurati correttamente per gestire i dati dei file:

```php
// Per campi JSON (file multipli)
protected $casts = [
    'certifications' => 'array',
];

// In Laravel 12.x, utilizzare il metodo casts()
protected function casts(): array
{
    return array_merge(parent::casts(), [
        'certifications' => 'array',
    ]);
}
```

## Esempio Completo: Gestione delle Certificazioni dei Dottori

```php
// Nel modello Doctor
protected function casts(): array
{
    return array_merge(parent::casts(), [
        'certifications' => 'array',
    ]);
}

// Nel form Filament
Forms\Components\FileUpload::make('certifications')
    ->multiple()
    ->directory('doctors/certifications')
    ->acceptedFileTypes(['application/pdf'])
    ->maxSize(5120)
```

## Documentazione Correlata

- [Mappatura dei Campi Database nel Modulo Patient](/laravel/Modules/Patient/project_docs/DATABASE_FIELD_MAPPING.md)
- [Migrazioni del Database](/project_docs/database-migrations.md)
- [Gestione degli Utenti](/project_docs/user-management.md)
- [Pattern di Ereditarietà dei Modelli](/project_docs/model-inheritance-patterns.md)
- [Documentazione Ufficiale di Filament](https://filamentphp.com/project_docs/3.x/forms/fields/file-upload)
