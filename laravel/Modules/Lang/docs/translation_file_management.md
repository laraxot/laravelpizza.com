# Gestione File di Traduzione

## Panoramica

Il sistema di gestione dei file di traduzione permette di visualizzare, modificare e gestire tutte le traduzioni dell'applicazione attraverso un'interfaccia Filament centralizzata.

## Architettura

### Modello TranslationFile

Il modello `TranslationFile` utilizza il pattern Sushi per creare un modello Eloquent che rappresenta i file di traduzione come record del database.

```php
class TranslationFile extends BaseModel
{
    use \Sushi\Sushi;

    protected $fillable = [
        'id',
        'name', 
        'path',
    ];

    public function getRows(): array
    {
        $files = app(GetAllTranslationAction::class)->execute();
        $rows = Arr::map($files, function($item) {
            $item['id'] = $item['key'];
            return $item;
        });
        return $rows;
    }
}
```

### Action GetAllTranslationAction

L'action `GetAllTranslationAction` è responsabile di:
- Scansionare tutti i file di traduzione nei moduli
- Generare una lista strutturata dei file disponibili
- Fornire metadati per ogni file (chiave, percorso)

```php
public function execute(): array
{
    $lang = app()->getLocale();
    $path = base_path('Modules/*/lang/'.$lang.'/*.php');
    $files = glob($path);
    
    $files = Arr::map($files, function($file) {
        $module_low = Str::of($file)->between('Modules/','/lang/')->lower()->toString();
        return [
            'key' => $module_low.'::'.basename($file,'.php'),
            'path' => $file,
        ];
    });
    
    return $files;
}
```

### Resource TranslationFileResource

Il resource Filament fornisce l'interfaccia per:
- Visualizzare la lista dei file di traduzione
- Modificare le traduzioni inline
- Gestire le chiavi di traduzione

## Struttura dei Dati

### File di Traduzione

I file di traduzione seguono la struttura standard Laravel:

```php
// Modules/User/lang/it/auth.php
return [
    'login' => [
        'title' => 'Accedi',
        'email' => 'Indirizzo Email',
        'password' => 'Password',
        'remember' => 'Ricordami',
        'submit' => 'Accedi',
    ],
    'register' => [
        'title' => 'Registrati',
        'name' => 'Nome Completo',
        'email' => 'Indirizzo Email',
        'password' => 'Password',
        'submit' => 'Registrati',
    ],
];
```

### Metadati File

Ogni file di traduzione è rappresentato con:
- `id`: Chiave univoca (es: `user::auth`)
- `name`: Nome del file (es: `auth`)
- `path`: Percorso completo del file
- `key`: Chiave completa con namespace (es: `user::auth`)

## Funzionalità

### 1. Visualizzazione File

- Lista di tutti i file di traduzione disponibili
- Raggruppamento per modulo
- Informazioni su percorso e dimensione

### 2. Modifica Traduzioni

- Editor inline per modificare le traduzioni
- Validazione della sintassi PHP
- Backup automatico prima delle modifiche
- Preview delle modifiche

### 3. Gestione Chiavi

- Aggiunta di nuove chiavi di traduzione
- Rimozione di chiavi obsolete
- Riorganizzazione della struttura

### 4. Sincronizzazione

- Sincronizzazione tra lingue diverse
- Identificazione di chiavi mancanti
- Esportazione per traduzione esterna

## Best Practices

### 1. Struttura Chiavi

```php
// ✅ Corretto - Struttura gerarchica
return [
    'auth' => [
        'login' => [
            'title' => 'Accedi',
            'email' => 'Indirizzo Email',
        ],
    ],
];

// ❌ Errato - Chiavi piatte
return [
    'auth_login_title' => 'Accedi',
    'auth_login_email' => 'Indirizzo Email',
];
```

### 2. Naming Convention

- Usare `snake_case` per le chiavi
- Organizzare in gruppi logici
- Mantenere coerenza tra moduli

### 3. Validazione

- Verificare la sintassi PHP prima del salvataggio
- Controllare la presenza di chiavi obbligatorie
- Validare la struttura dei dati

## Sicurezza

### 1. Backup Automatico

- Creazione di backup prima di ogni modifica
- Versioning delle modifiche
- Possibilità di rollback

### 2. Controllo Accessi

- Verifica dei permessi per la modifica
- Log delle modifiche effettuate
- Audit trail completo

### 3. Validazione Input

- Sanitizzazione del codice PHP
- Controllo della sintassi
- Prevenzione di codice malevolo

## Integrazione con Filament

### 1. Resource Configuration

```php
class TranslationFileResource extends XotBaseResource
{
    protected static ?string $model = TranslationFile::class;

    public static function getFormSchema(): array
    {
        return [
            Components\TextInput::make('key')
                ->required()
                ->maxLength(255),
            Components\Textarea::make('content')
                ->required()
                ->rows(20)
                ->monospace(),
        ];
    }
}
```

### 2. Custom Actions

- Azioni per sincronizzare le traduzioni
- Comandi per esportare/importare
- Validazione automatica

### 3. Widget e Dashboard

- Widget per statistiche traduzioni
- Dashboard per monitoraggio
- Alert per chiavi mancanti

## Comandi Artisan

### 1. Sincronizzazione

```bash
php artisan lang:sync
```

### 2. Validazione

```bash
php artisan lang:validate
```

### 3. Esportazione

```bash
php artisan lang:export
```

## Collegamenti

- [Translation Standards](./translation-standards.md)
- [Translation System](./translation-system.md)
- [Best Practices](./translation-keys-best-practices.md)
- [Laravel Localization](https://laravel.com/docs/localization)

## Note per lo Sviluppo

1. **Performance**: Utilizzare cache per i file di traduzione
2. **Scalabilità**: Gestire grandi volumi di traduzioni
3. **Manutenibilità**: Struttura modulare e estendibile
