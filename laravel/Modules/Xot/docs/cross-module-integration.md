# Integrazione Cross-Module - Laraxot PTVX

## Panoramica
Questo documento descrive le best practices per l'integrazione tra moduli diversi in Laraxot PTVX, con particolare attenzione alle Filament Resources che utilizzano modelli di altri moduli.

## Principi Fondamentali

### 1. Separazione delle Responsabilità
- **Modulo proprietario**: Contiene il modello e la logica di business
- **Modulo consumatore**: Contiene le Filament Resources per la gestione UI
- **Namespace espliciti**: Utilizzare sempre il namespace completo per i modelli cross-module

### 2. Architettura Modulare
```php
// Modulo Sigma (proprietario del modello)
namespace Modules\Sigma\Models;
class Integparam extends BaseModel { ... }

// Modulo Progressioni (consumatore)
namespace Modules\Progressioni\Filament\Resources;
class IntegparamResource extends XotBaseResource
{
    protected static ?string $model = \Modules\Sigma\Models\Integparam::class;
}
```

## Pattern di Implementazione

### Filament Resource Cross-Module
```php
<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources;

use Modules\Sigma\Models\Integparam;
use Modules\Xot\Filament\Resources\XotBaseResource;

class IntegparamResource extends XotBaseResource
{
    protected static ?string $model = Integparam::class;
    
    public static function getFormSchema(): array
    {
        return [
            // Schema del form
        ];
    }
    
    public static function getTableColumns(): array
    {
        return [
            // Colonne della tabella
        ];
    }
}
```

### Traduzioni Dedicati
```php
// Modules/Progressioni/lang/it/integparam.php
return [
    'navigation' => [
        'label' => 'Parametri Integrazione',
        'group' => 'Gestione Progressioni',
    ],
    'fields' => [
        'ente' => [
            'label' => 'Ente',
            'placeholder' => 'Inserisci codice ente',
            'help' => 'Codice identificativo dell\'ente',
        ],
        // Altri campi...
    ],
];
```

## Best Practices

### 1. Namespace e Import
- **Import espliciti**: Utilizzare sempre `use` per i modelli cross-module
- **Namespace completo**: Specificare il namespace completo nella proprietà `$model`
- **Evitare alias**: Non utilizzare alias per i modelli cross-module

### 2. Gestione delle Traduzioni
- **File dedicati**: Creare file di traduzione specifici per le risorse cross-module
- **Struttura espansa**: Utilizzare sempre la struttura espansa per i campi
- **Namespace traduzioni**: Utilizzare il namespace del modulo consumatore

### 3. Validazione e Sicurezza
- **Validazione appropriata**: Implementare validazione specifica per i campi cross-module
- **Autorizzazioni**: Verificare i permessi per l'accesso ai dati cross-module
- **Sanitizzazione**: Sanitizzare sempre i dati prima del salvataggio

### 4. Performance
- **Query ottimizzate**: Evitare N+1 problems nelle query cross-module
- **Eager loading**: Utilizzare `with()` per caricare relazioni necessarie
- **Indici database**: Verificare la presenza di indici appropriati

## Esempi di Implementazione

### Esempio: IntegparamResource (Progressioni → Sigma)
```php
// Modello in Sigma
namespace Modules\Sigma\Models;
class Integparam extends BaseModel
{
    protected $fillable = [
        'ente', 'matr', 'conome', 'nome', 'anv2kd', 'anv2ka',
        'anvist', 'anvpar', 'anvimp', 'anvqta', 'anvvoc', 'anvdes'
    ];
}

// Filament Resource in Progressioni
namespace Modules\Progressioni\Filament\Resources;
class IntegparamResource extends XotBaseResource
{
    protected static ?string $model = \Modules\Sigma\Models\Integparam::class;
    
    public static function getFormSchema(): array
    {
        return [
            Section::make('Dati Anagrafici')
                ->schema([
                    TextInput::make('ente')->required()->maxLength(10),
                    TextInput::make('matr')->required()->maxLength(10),
                    // Altri campi...
                ]),
        ];
    }
}
```

### Esempio: Traduzioni Cross-Module
```php
// Modules/Progressioni/lang/it/integparam.php
return [
    'navigation' => [
        'label' => 'Parametri Integrazione',
        'group' => 'Gestione Progressioni',
        'icon' => 'heroicon-o-cog-6-tooth',
    ],
    'fields' => [
        'ente' => [
            'label' => 'Ente',
            'placeholder' => 'Inserisci codice ente',
            'help' => 'Codice identificativo dell\'ente',
        ],
        // Altri campi...
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo parametro',
            'success' => 'Parametro creato con successo',
        ],
        // Altre azioni...
    ],
];
```

## Gestione degli Errori

### Errori Comuni
1. **Namespace non trovato**: Verificare che il modello esista nel modulo proprietario
2. **Traduzioni mancanti**: Creare file di traduzione dedicati
3. **Permessi insufficienti**: Implementare policy appropriate
4. **Performance degradate**: Ottimizzare le query cross-module

### Soluzioni
1. **Verifica namespace**: Controllare sempre il namespace completo
2. **Documentazione**: Mantenere documentazione aggiornata per le integrazioni
3. **Testing**: Implementare test per le funzionalità cross-module
4. **Monitoring**: Monitorare le performance delle query cross-module

## Documentazione

### File di Documentazione
- **Modulo proprietario**: Documentare il modello e le sue relazioni
- **Modulo consumatore**: Documentare l'integrazione e le Filament Resources
- **Documentazione root**: Collegamenti bidirezionali tra le documentazioni

### Esempio di Documentazione
```markdown
# Integrazione Modulo Sigma - Progressioni

## Panoramica
Il modulo Progressioni integra il modello `Integparam` del modulo Sigma per gestire i parametri di integrazione.

## Architettura
- **Modello**: `Modules\Sigma\Models\Integparam`
- **Filament Resource**: `Modules\Progressioni\Filament\Resources\IntegparamResource`
- **Traduzioni**: `Modules\Progressioni\lang\it\integparam.php`

## Collegamenti
- [Modulo Sigma](/laravel/Modules/Sigma/docs/README.md)
- [Modulo Progressioni](/laravel/Modules/Progressioni/docs/README.md)
```

## Checklist per Integrazioni Cross-Module

### Pre-Implementazione
- [ ] Verificare che il modello esista nel modulo proprietario
- [ ] Controllare i permessi e le policy necessarie
- [ ] Pianificare la struttura delle traduzioni
- [ ] Documentare l'integrazione

### Implementazione
- [ ] Creare la Filament Resource con namespace espliciti
- [ ] Implementare form schema e table columns
- [ ] Creare file di traduzione dedicati
- [ ] Implementare pagine (List, Create, Edit, View)

### Post-Implementazione
- [ ] Testare la funzionalità cross-module
- [ ] Verificare le performance delle query
- [ ] Aggiornare la documentazione
- [ ] Implementare test automatizzati

## Collegamenti
- [Modulo Sigma](/laravel/Modules/Sigma/docs/README.md)
- [Modulo Progressioni](/laravel/Modules/Progressioni/docs/README.md)
- [Filament Resources Best Practices](/docs/filament-best-practices.md)
- [Translation Standards](/docs/translation-standards.md)

*Ultimo aggiornamento: 5 giugno 2025* 