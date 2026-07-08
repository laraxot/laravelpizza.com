# Module Structure in Laraxot

## Directory Structure

### Base Structure
```
Module/
├── app/
│   ├── Filament/
│   │   └── Resources/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Requests/
│   │   └── Resources/
│   ├── Models/
│   └── Providers/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── Resources/
│   ├── lang/
│   │   ├── en/
│   │   └── it/
│   └── views/
└── routes/
    ├── api.php
    └── web.php
```

## Key Components

### Models
- Estendere i modelli base appropriati
- Implementare le relazioni necessarie
- Definire le proprietà fillable e hidden
- Utilizzare i traits per funzionalità comuni

### Controllers
- Mantenere i controller snelli
- Utilizzare Form Requests per la validazione
- Implementare le autorizzazioni appropriate
- Seguire il pattern Resource Controller quando possibile

### Resources
- Estendere XotBaseResource per le risorse Filament
- Implementare getFormSchema() per la definizione dei form
- Utilizzare il sistema di traduzione automatico

### Views
- Organizzare le views in modo modulare
- Utilizzare i componenti Blade
- Implementare la localizzazione
- Seguire le best practices di Laravel

## Translations

### Structure
```php
// Resources/lang/it/filament.php
return [
    'resources' => [
        'model_name' => [
            'fields' => [
                'field_name' => 'Nome Campo',
            ],
            'placeholders' => [
                'field_name' => 'Inserisci valore...',
            ],
        ],
    ],
];
```

### Implementation
- Utilizzare il sistema di traduzione automatico
- Mantenere coerenza tra le lingue
- Documentare tutti i campi possibili
- Non rimuovere mai le traduzioni esistenti

## Routes

### Web Routes
```php
Route::middleware(['web', 'auth'])->group(function () {
    Route::resource('resource', ResourceController::class);
});
```

### API Routes
```php
Route::middleware('api')->prefix('api')->group(function () {
    Route::apiResource('resource', ResourceApiController::class);
});
```

## Configuration
- Mantenere le configurazioni nel file config.php
- Utilizzare le variabili d'ambiente quando appropriato
- Documentare tutte le opzioni di configurazione
- Fornire valori predefiniti sensati
