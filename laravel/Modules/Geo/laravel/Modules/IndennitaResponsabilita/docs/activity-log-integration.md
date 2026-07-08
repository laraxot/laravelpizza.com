# Integrazione Activity Log nel Modulo IndennitaResponsabilita

## Descrizione

Il modulo IndennitaResponsabilita utilizza il modulo Activity per tracciare tutte le modifiche effettuate sui record di tipo `IndennitaResponsabilita`. Questo permette di:

- Visualizzare lo storico completo delle modifiche
- Identificare chi ha effettuato ogni modifica e quando
- Ripristinare versioni precedenti dei record
- Audit trail completo per compliance

## Implementazione

### Pagina Activity Log Custom

Il modulo implementa una pagina custom `ListSchedaLogActivities` che estende la classe base `ListLogActivities` del modulo Activity:

```php
<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages;

use Modules\Activity\Filament\Pages\ListLogActivities;
use Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource;

class ListSchedaLogActivities extends ListLogActivities
{
    protected static string $resource = IndennitaResponsabilitaResource::class;
}
```

**Percorso**: `Modules/IndennitaResponsabilita/app/Filament/Resources/IndennitaResponsabilitaResource/Pages/ListSchedaLogActivities.php`

### Route

La pagina è accessibile tramite la route:

```
GET /indennitaresponsabilita/admin/indennita-responsabilitas/{record}/activities
```

**Parametri**:
- `{record}`: ID del record IndennitaResponsabilita

**Nome route**: `filament.indennitaresponsabilita::admin.resources.indennita-responsabilitas.log-activity`

**Middleware**: 
- `panel:indennitaresponsabilita::admin`
- Autenticazione e CSRF protection
- Filament specific middleware

### Modello IndennitaResponsabilita

Il modello deve implementare il trait `LogsActivity` di Spatie per abilitare il tracciamento:

```php
<?php

namespace Modules\IndennitaResponsabilita\Models;

use Modules\Ptv\Models\BaseScheda;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class IndennitaResponsabilita extends BaseScheda
{
    use LogsActivity;
    
    /**
     * Opzioni per il logging delle attività.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'stabi',
                'descrizione',
                'importo',
                // ... altri campi da tracciare
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
```

## Configurazione Tracciamento

### Campi Tracciati

I seguenti campi vengono tracciati automaticamente:
- Tutti i campi definiti in `getActivitylogOptions()->logOnly([])`
- Le relazioni modificate (se configurate)
- Metadata come utente, timestamp, IP

### Opzioni Disponibili

```php
return LogOptions::defaults()
    ->logOnly(['campo1', 'campo2'])        // Solo campi specifici
    ->logAll()                              // Tutti i campi
    ->logOnlyDirty()                        // Solo campi modificati
    ->dontSubmitEmptyLogs()                 // Ignora log senza modifiche
    ->logFillable()                         // Solo campi fillable
    ->logExcept(['password', 'token'])      // Escludi campi sensibili
    ->useLogName('indennita-responsabilita'); // Nome log custom
```

## Errori Comuni

### Errore: No hint path defined for [activity]

**Sintomo**: Quando si accede alla pagina activities, si riceve:
```
InvalidArgumentException
No hint path defined for [activity].
```

**Causa**: Il ServiceProvider del modulo Activity non ha registrato correttamente il view namespace.

**Soluzione**: Vedere documentazione completa: [Activity - No Hint Path Defined](../../Activity/docs/errori/no-hint-path-defined.md)

**Quick Fix**:
```bash
# 1. Pulire cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# 2. Rigenerare autoload
composer dump-autoload -o

# 3. Verificare registrazione
php artisan package:discover --ansi
```

### Errore: Relationship not found

**Sintomo**: La pagina si carica ma non mostra le attività.

**Causa**: Il modello non ha il trait `LogsActivity` o la relazione `activities()` non è configurata.

**Soluzione**:
1. Verificare che il modello usi `LogsActivity` trait
2. Verificare configurazione di `getActivitylogOptions()`
3. Controllare che il campo `subject_type` nelle tabelle activity corrisponda al nome completo della classe

### View Personalizzata Non Trovata

**Sintomo**: Errore "View [activity::filament.pages.list-log-activities] not found"

**Causa**: 
- File blade non esiste nel modulo Activity
- Path non corretto
- View cache non aggiornata

**Soluzione**:
```bash
# Verificare file esiste
ls -la Modules/Activity/resources/views/filament/pages/list-log-activities.blade.php

# Se esiste, pulire cache view
php artisan view:clear
```

## Personalizzazione

### Aggiungere Colonne Custom nella Vista

Estendere il metodo `getFieldLabel()` per personalizzare le etichette:

```php
class ListSchedaLogActivities extends ListLogActivities
{
    protected static string $resource = IndennitaResponsabilitaResource::class;
    
    public function getFieldLabel(string $name): string
    {
        $customLabels = [
            'stabi' => 'N. Stabi',
            'importo' => 'Importo Indennità',
            // ... altre label custom
        ];
        
        return $customLabels[$name] ?? parent::getFieldLabel($name);
    }
}
```

### Filtrare Attività Visualizzate

Override del metodo `getActivities()`:

```php
public function getActivities()
{
    return $this->paginateQuery(
        $this->record->activities()
            ->with('causer')
            ->where('event', '!=', 'created') // Escludi eventi "created"
            ->latest()
            ->getQuery()
    );
}
```

### Disabilitare Ripristino

Se non si vuole permettere il ripristino delle versioni precedenti:

```php
public function canRestoreActivity(): bool
{
    return false; // Disabilita ripristino per tutti
    
    // Oppure condizionale:
    // return auth()->user()->hasRole('super-admin');
}
```

## Testing

### Test della Pagina Activity Log

```php
<?php

use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\User\Models\User;

test('can access activity log page', function () {
    $user = User::factory()->create();
    $indennita = IndennitaResponsabilita::factory()->create();
    
    $this->actingAs($user)
        ->get("/indennitaresponsabilita/admin/indennita-responsabilitas/{$indennita->id}/activities")
        ->assertOk()
        ->assertSeeLivewire('list-scheda-log-activities');
});

test('activity log tracks changes', function () {
    $user = User::factory()->create();
    $indennita = IndennitaResponsabilita::factory()->create([
        'importo' => 100.00,
    ]);
    
    $this->actingAs($user);
    
    $indennita->update(['importo' => 150.00]);
    
    $activities = $indennita->activities;
    
    expect($activities)->toHaveCount(1)
        ->and($activities->first()->causer_id)->toBe($user->id)
        ->and($activities->first()->properties['old']['importo'])->toBe(100.00)
        ->and($activities->first()->properties['attributes']['importo'])->toBe(150.00);
});
```

### Test del Ripristino

```php
test('can restore previous version', function () {
    $user = User::factory()->create();
    $indennita = IndennitaResponsabilita::factory()->create([
        'descrizione' => 'Versione Originale',
    ]);
    
    $this->actingAs($user);
    
    $indennita->update(['descrizione' => 'Versione Modificata']);
    
    $activity = $indennita->activities()->first();
    
    livewire(ListSchedaLogActivities::class, [
        'record' => $indennita->id,
    ])
        ->call('restoreActivity', $activity->id)
        ->assertNotified();
    
    expect($indennita->fresh()->descrizione)->toBe('Versione Originale');
});
```

## Performance

### Eager Loading

Per evitare N+1 query, la relazione `causer` viene caricata automaticamente:

```php
public function getActivities()
{
    return $this->paginateQuery(
        $this->record->activities()
            ->with('causer')  // ← Eager load utente
            ->latest()
            ->getQuery()
    );
}
```

### Paginazione

Le attività sono paginate automaticamente. Configurazione default:
- 10 record per pagina
- Paginazione standard (non infinite scroll)
- Ordinamento: più recenti prima

Personalizzare:

```php
protected int $recordsPerPage = 25;

public function getPaginationMode(): PaginationMode
{
    return PaginationMode::Simple; // o PaginationMode::Default
}
```

### Indici Database

Assicurarsi che la tabella `activity_log` abbia indici appropriati:

```php
// Migration activity_log
Schema::create('activity_log', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('log_name')->nullable();
    $table->text('description');
    $table->nullableMorphs('subject', 'subject');
    $table->nullableMorphs('causer', 'causer');
    $table->json('properties')->nullable();
    $table->timestamps();
    
    // Indici per performance
    $table->index('log_name');
    $table->index(['subject_type', 'subject_id']);
    $table->index(['causer_type', 'causer_id']);
    $table->index('created_at');
});
```

## Best Practice

1. **Configurare LogOptions appropriatamente**
   - Tracciare solo campi rilevanti
   - Escludere campi sensibili (password, token)
   - Usare `logOnlyDirty()` per evitare log inutili

2. **Testare il ripristino**
   - Verificare che il ripristino funzioni per tutti i campi tracciati
   - Testare edge cases (campi null, relazioni)

3. **Monitorare dimensione tabella activity_log**
   - Implementare pulizia periodica dei log vecchi
   - Archiviare log storici se necessario

4. **Documentare campi tracciati**
   - Aggiornare documentazione quando si modificano i campi tracciati
   - Spiegare perché certi campi sono esclusi

## Manutenzione

### Pulizia Log Vecchi

```bash
# Rimuovere log più vecchi di 12 mesi
php artisan activitylog:clean --days=365

# O programmare in scheduler
// app/Console/Kernel.php
$schedule->command('activitylog:clean --days=365')->monthly();
```

### Archiviazione

Per archiviare log storici prima di eliminarli:

```php
use Spatie\Activitylog\Models\Activity;

Activity::where('created_at', '<', now()->subYear())
    ->chunk(1000, function ($activities) {
        // Esporta in formato JSON o altro storage
        Storage::append('activity_archive.json', $activities->toJson());
        
        // Elimina da database
        $activities->each->delete();
    });
```

## Collegamenti

### Documentazione Correlata
- [Activity Module - README](../../Activity/docs/README.md)
- [Activity Module - Errore No Hint Path](../../Activity/docs/errori/no-hint-path-defined.md)
- [Spatie Activity Log Official Docs](https://spatie.be/docs/laravel-activitylog/v4/introduction)

### Moduli Correlati
- [Ptv Module - BaseScheda](../../Ptv/docs/base-scheda.md)
- [User Module - Authentication](../../User/docs/authentication.md)
- [Xot Module - Service Providers](../../Xot/docs/service-providers.md)

---

**Ultimo aggiornamento**: 27 Ottobre 2025  
**Versione Laravel**: 12.35.1  
**Dipendenze**: Activity Module v1.0, Spatie Activity Log v4.x

