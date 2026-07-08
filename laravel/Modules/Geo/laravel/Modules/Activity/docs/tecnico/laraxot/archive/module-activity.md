# Modulo Activity

## Overview
Il modulo Activity fornisce un sistema completo di logging e monitoraggio delle attività nel sistema.

## Funzionalità Principali

### 1. Logging Attività
- Tracciamento automatico delle azioni CRUD
- Log delle modifiche ai modelli
- Registrazione delle attività utente

### 2. Monitoraggio Sistema
- Monitoraggio delle performance
- Tracciamento degli errori
- Statistiche di utilizzo

### 3. Audit Trail
- Cronologia completa delle modifiche
- Chi ha fatto cosa e quando
- Ripristino delle modifiche

## Configurazione

```json
// laravel/Modules/Activity/module.json
{
    "name": "Activity",
    "providers": [
        "Modules\\Activity\\Providers\\ActivityServiceProvider"
    ],
    "aliases": {
        "Activity": "Modules\\Activity\\Facades\\Activity"
    },
    "files": [],
    "requires": []
}
```

## Utilizzo

### Logging Attività
```php
use Modules\Activity\Facades\Activity;

// Log manuale
Activity::log('Utente ha modificato il profilo', [
    'user_id' => auth()->id(),
    'changes' => $changes
]);

// Log automatico per modelli
protected static $logAttributes = ['name', 'email'];
protected static $logOnlyDirty = true;
```

### Query Attività
```php
// Recupera tutte le attività
$activities = Activity::all();

// Filtra per utente
$userActivities = Activity::where('user_id', $userId)->get();

// Filtra per tipo
$modelChanges = Activity::where('type', 'model_change')->get();
```

## Integrazione con Filament

### Resource
```php
use Modules\Activity\Filament\Resources\ActivityResource;

class ActivityResource extends XotBaseResource
{
    protected static ?string $model = Activity::class;
    
    public static function getTableColumns(): array
    {
        return [
            TextColumn::make('user.name')
                ->label('Utente'),
            TextColumn::make('description')
                ->label('Descrizione'),
            TextColumn::make('created_at')
                ->label('Data')
                ->dateTime('d/m/Y H:i:s'),
        ];
    }
}
```

## Testing

```php
class ActivityTest extends TestCase
{
    public function test_can_log_activity(): void
    {
        $user = User::factory()->create();
        
        Activity::log('Test activity', [
            'user_id' => $user->id
        ]);
        
        $this->assertDatabaseHas('activities', [
            'description' => 'Test activity',
            'user_id' => $user->id
        ]);
    }
}
```

## Best Practices

1. **Logging**:
   - Log solo le attività significative
   - Includi dati contestuali rilevanti
   - Evita dati sensibili

2. **Performance**:
   - Utilizza code per il logging asincrono
   - Implementa la pulizia periodica dei log
   - Ottimizza le query di recupero

3. **Sicurezza**:
   - Verifica i permessi di accesso
   - Proteggi i dati sensibili
   - Implementa la rotazione dei log

## Note di Implementazione

1. **Dipendenze**:
   - Richiede il modulo User
   - Integra con il modulo Tenant
   - Utilizza il modulo Job per il logging asincrono

2. **Personalizzazione**:
   - Configurabile per diversi livelli di logging
   - Personalizzabile per diversi tipi di attività
   - Estensibile per nuove funzionalità

3. **Manutenzione**:
   - Pulizia periodica dei log
   - Backup dei dati di attività
   - Monitoraggio delle performance 