# ListLogActivitiesAction - Documentazione Completa

## Panoramica

`ListLogActivitiesAction` è un'Action Filament completa per visualizzare lo storico delle attività di un record direttamente da una tabella. Fornisce un'interfaccia user-friendly per accedere rapidamente alle informazioni di audit trail.

## Business Logic

L'Action implementa la logica per:

### 1. Visualizzazione Attività Recenti
- Mostra le ultime 5 attività in un modal elegante
- Visualizzazione avatar e nome dell'utente che ha effettuato le modifiche
- Orario formattato delle modifiche
- Indicatore visivo per modifiche vs altre operazioni

### 2. Auto-Discovery Intelligente
- Trova automaticamente la Resource Filament per il modello
- Identifica la pagina delle attività appropriata
- Gestisce casi edge con fallback alla pagina base

### 3. Navigazione Fluida
- Transizione seamless dal modal alla pagina completa
- Mantiene il contesto del record selezionato
- Preserva filtri e ordinamento

## Implementazione Tecnica

### Estensione della Classe Base
```php
class ListLogActivitiesAction extends XotBaseAction
```

**Caratteristiche Tecniche**:
- Estende `Modules\Xot\Filament\Actions\XotBaseAction` (regola Laraxot)
- Implementa `setUp()` per configurazione completa
- Usa traduzioni strutturate del modulo Activity (NO label hardcoded)
- Supporta injection di dipendenze tramite closure

### ⚠️ Filament 4 - Panel Context Automatico

**IMPORTANTE**: Questo progetto utilizza **Filament 4**, NON Filament 3.

In Filament 4, quando si chiama `Resource::getUrl()` da un contesto Livewire (come `ListRecords`), Filament **determina automaticamente il panel corretto** dal contesto del livewire. Non è necessario passare esplicitamente il panel.

**✅ CORRETTO (Filament 4)**:
```php
// Filament 4 determina automaticamente il panel dal contesto
return $resource::getUrl('log-activity', ['record' => $record]);
```

**❌ ERRATO**:
```php
// NON esiste Filament\Support\Facades\Filament::getCurrentPanel() in Filament 4
$panel = Filament::getCurrentPanel(); // ❌ CLASSE NON ESISTENTE
return $resource::getUrl('log-activity', ['record' => $record], panel: $panelId);
```

Vedi [Filament 4 Important Notes](../../../../../docs/filament4-important.md) per dettagli completi.

### Metodi Principali

#### `setUp()`
Configura completamente l'Action:
- Label, tooltip, icona e colore
- Contenuto modal dinamico
- Azione di navigazione

#### `getActivitiesModalContent()`
Genera HTML per il modal:
- Query attività con eager loading
- Rendering componenti responsive
- Gestione casi vuoti

#### `navigateToFullActivitiesPage()`
Gestisce navigazione:
- Auto-discovery pagina appropriata
- Redirect con parametri corretti
- Fallback intelligente

## Utilizzo Pratico

### In una Resource Filament

```php
<?php

namespace Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource;

use Modules\Activity\Filament\Actions\ListLogActivitiesAction;
use Modules\Xot\Filament\Resources\XotBaseResource;

class IndennitaResponsabilitaResource extends XotBaseResource
{
    protected function getTableActions(): array
    {
        return [
            ListLogActivitiesAction::make(),
        ];
    }
}
```

### In una Page Custom

```php
<?php

class MyCustomPage extends XotBasePage
{
    protected function getActions(): array
    {
        return [
            ListLogActivitiesAction::make()
                ->record($this->record),
        ];
    }
}
```

## Configurazione Avanzata

### Personalizzazione Comportamento

```php
ListLogActivitiesAction::make()
    ->label('Storico Personalizzato')
    ->icon('heroicon-o-document-text')
    ->color('primary')
    ->modalHeading('Modifiche Record')
```

### Override Auto-Discovery

```php
ListLogActivitiesAction::make()
    ->action(function (Model $record): void {
        // Logica personalizzata per navigazione
        $this->redirect(MyCustomActivityPage::getUrl(['record' => $record]));
    })
```

## Traduzioni

L'Action usa le traduzioni strutturate del modulo Activity:

### File Traduzioni (IT)
```php
// lang/it/actions.php
'list_log_activities' => [
    'label' => 'Cronologia',
    'tooltip' => 'Visualizza storico modifiche',
    'modal' => [
        'heading' => 'Storico Modifiche',
        'description' => 'Visualizza tutte le modifiche',
    ],
    'view_all' => 'Visualizza Tutto',
    'close' => 'Chiudi',
]
```

### File Traduzioni (EN)
```php
// lang/en/actions.php
'list_log_activities' => [
    'label' => 'History',
    'tooltip' => 'View modification history',
    'modal' => [
        'heading' => 'Modification History',
        'description' => 'View all modifications',
    ],
    'view_all' => 'View All',
    'close' => 'Close',
]
```

## Integrazione con Altri Moduli

### Pattern Consigliato
1. **Aggiungere nelle Table Actions** di ogni Resource importante
2. **Configurare traduzioni** per coerenza UI
3. **Testare con modelli diversi** per verificare auto-discovery
4. **Personalizzare se necessario** per casi specifici

### Esempi di Integrazione

#### Modulo Performance
```php
// PerformanceResource.php
protected function getTableActions(): array
{
    return [
        ListLogActivitiesAction::make(),
        // Altre actions...
    ];
}
```

#### Modulo User
```php
// UserResource.php
protected function getTableActions(): array
{
    return [
        Tables\Actions\EditAction::make(),
        ListLogActivitiesAction::make(),
        Tables\Actions\DeleteAction::make(),
    ];
}
```

## Testing

### Test Unitari
```php
<?php

use Modules\Activity\Filament\Actions\ListLogActivitiesAction;
use Modules\Performance\Models\Performance;

it('can render activities modal content', function () {
    $record = Performance::factory()->create();

    $action = ListLogActivitiesAction::make();
    $content = $action->getActivitiesModalContent($record);

    expect($content)->toContain('Modifiche');
    expect($content)->toContain('Nessuna modifica');
});
```

### Test Integrazione
```php
it('navigates to correct activities page', function () {
    $record = Performance::factory()->create();

    // Test auto-discovery
    $pageClass = $action->getActivitiesPageClass($record);
    expect($pageClass)->toBeString();
    expect(class_exists($pageClass))->toBeTrue();
});
```

## Troubleshooting

### Problema: Modal Vuoto
**Causa**: Nessuna attività registrata per il record
**Soluzione**: Verificare che il modello abbia il trait `HasActivityLog` configurato

### Problema: Navigazione Fallita
**Causa**: Pagina delle attività non trovata
**Soluzione**: Verificare che esista una pagina `List{ModelName}LogActivities` per il modello

### Problema: Traduzioni Mancanti
**Causa**: Chiavi di traduzione non definite
**Soluzione**: Aggiungere chiavi in `lang/it/actions.php` e `lang/en/actions.php`

## Best Practices

### ✅ Pattern Corretto
- Usa sempre nelle table actions delle risorse importanti
- Lascia che l'auto-discovery trovi la pagina appropriata
- Personalizza solo se necessario per casi specifici

### ❌ Anti-Pattern
- Non estendere l'Action per modifiche minori
- Non disabilitare l'auto-discovery senza motivo
- Non duplicare logica di rendering attività

## Performance

### Ottimizzazioni Implementate
- **Eager Loading**: Caricamento causer con le attività
- **Limit Query**: Solo ultime 5 attività per modal
- **Lazy Evaluation**: Calcolo solo quando necessario
- **Cache Friendly**: Nessun impatto su performance tabella

### Considerazioni
- L'Action non carica attività fino all'apertura del modal
- Query ottimizzate con indici appropriati
- Rendering HTML on-demand per performance

## Collegamenti

### Documentazione Correlata
- [ListLogActivities Page](../list-log-activities.md)
- [Activity Log Setup](../setup.md)
- [Spatie Activity Log](https://spatie.be/docs/laravel-activitylog)

### Esempi di Utilizzo
- [Performance Module Integration](../../performance/docs/activity-integration.md)
- [User Module Integration](../../user/docs/activity-integration.md)

*Ultimo aggiornamento: Sistema di documentazione automatica*
