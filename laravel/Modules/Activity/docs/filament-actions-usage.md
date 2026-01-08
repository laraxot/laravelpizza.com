# Filament Actions nel Modulo Activity

## Panoramica

Il modulo Activity fornisce Actions Filament riutilizzabili per semplificare l'integrazione dell'Activity Log nelle Resources.

## Business Logic

**Problema DRY**: Senza Actions riutilizzabili, ogni Resource deve implementare manualmente:
```php
// ❌ Codice ripetuto in ogni Resource
Action::make('activities')
    ->label('Cronologia')
    ->tooltip('Visualizza storico modifiche')
    ->icon('heroicon-o-clock')
    ->color('gray')
    ->url(fn ($record) => MyResource::getUrl('log-activity', ['record' => $record]))
    ->visible(fn ($record) => $record->activities()->exists())
```

**Soluzione KISS**: Action riutilizzabile che incapsula la logica:
```php
// ✅ Una sola riga
ListLogActivitiesAction::make()
```

## Actions Disponibili

### ListLogActivitiesAction

**Percorso**: `Modules/Activity/app/Filament/Actions/ListLogActivitiesAction.php`

**Scopo**: Aggiunge un pulsante "Cronologia" nelle table actions che reindirizza alla pagina di visualizzazione dello storico attività.

**Documentazione completa**: [ListLogActivitiesAction](./actions/list-log-activities-action.md)

#### Utilizzo Base

```php
use Modules\Activity\Filament\Actions\ListLogActivitiesAction;

class ListMyModels extends XotBaseListRecords
{
    public function getTableActions(): array
    {
        return [
            'edit' => EditAction::make(),
            'delete' => DeleteAction::make(),
            'activities' => ListLogActivitiesAction::make(),
        ];
    }
}
```

#### Personalizzazioni

```php
// Con visibilità condizionale
'activities' => ListLogActivitiesAction::make()
    ->visible(fn (Model $record) => $record->activities_count > 0)

// Con autorizzazione
'activities' => ListLogActivitiesAction::make()
    ->authorize(fn () => auth()->user()->can('view_activity_log'))

// Con icona custom
'activities' => ListLogActivitiesAction::make()
    ->icon('heroicon-o-document-text')
    ->color('primary')
```

## Pattern di Implementazione

### Setup Completo in una Resource

**Step 1**: Creare la pagina Log Activities

```php
// Modules/MyModule/app/Filament/Resources/MyResource/Pages/ListMyModelActivities.php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Filament\Resources\MyResource\Pages;

use Modules\Activity\Filament\Pages\ListLogActivities;
use Modules\MyModule\Filament\Resources\MyResource;

class ListMyModelActivities extends ListLogActivities
{
    protected static string $resource = MyResource::class;
}
```

**Step 2**: Registrare la pagina nella Resource

```php
// Modules/MyModule/app/Filament/Resources/MyResource.php
public static function getPages(): array
{
    return [
        'index' => Pages\ListMyModels::route('/'),
        'create' => Pages\CreateMyModel::route('/create'),
        'edit' => Pages\EditMyModel::route('/{record}/edit'),
        'log-activity' => Pages\ListMyModelActivities::route('/{record}/activities'),
    ];
}
```

**Step 3**: Aggiungere l'Action nella List page

```php
// Modules/MyModule/app/Filament/Resources/MyResource/Pages/ListMyModels.php
use Modules\Activity\Filament\Actions\ListLogActivitiesAction;

class ListMyModels extends XotBaseListRecords
{
    public function getTableActions(): array
    {
        return [
            'edit' => EditAction::make(),
            'activities' => ListLogActivitiesAction::make(),
        ];
    }
}
```

**Step 4**: Configurare il modello per tracciare le attività

```php
// Modules/MyModule/app/Models/MyModel.php
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class MyModel extends BaseModel
{
    use LogsActivity;
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'description', 'status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
```

## Ottimizzazione Performance

### Eager Loading Activities Count

Per evitare N+1 query quando si controlla la visibilità dell'action:

```php
class ListMyModels extends XotBaseListRecords
{
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->withCount('activities');  // ← Eager load conteggio
    }
    
    public function getTableActions(): array
    {
        return [
            'activities' => ListLogActivitiesAction::make()
                ->visible(fn (Model $record) => 
                    $record->activities_count > 0  // ← Usa conteggio precaricato
                ),
        ];
    }
}
```

### Caching Risultati

Per applicazioni con molte attività:

```php
public function getActivities()
{
    return $this->paginateQuery(
        $this->record->activities()
            ->with('causer')
            ->remember(300)  // ← Cache per 5 minuti
            ->latest()
            ->getQuery()
    );
}
```

## File di Traduzione

### Struttura Espansa Richiesta

Tutte le lingue supportate devono avere la struttura completa:

```php
// Modules/Activity/lang/{locale}/actions.php
return [
    'list_log_activities' => [
        'label' => 'Translation',
        'tooltip' => 'Translation',
        'icon' => 'heroicon-o-clock',
        'color' => 'gray',
        'modal' => [
            'heading' => 'Translation',
            'description' => 'Translation',
        ],
        'messages' => [
            'no_activities' => 'Translation',
            'loading' => 'Translation',
        ],
    ],
];
```

### Lingue Supportate

- ✅ Italiano (it)
- ✅ Inglese (en)
- ✅ Tedesco (de)
- 🔄 Altre lingue: creare file seguendo lo stesso pattern

## Testing

### Test Suite Completa

Il modulo include test per:
- ✅ Nome default corretto
- ✅ Configurazione action
- ✅ Visibilità nelle table actions
- ✅ Generazione URL corretta
- ✅ Visibilità condizionale (solo con attività)
- ✅ Traduzioni tooltip
- ✅ Icona corretta
- ✅ Colore appropriato

**Eseguire i test**:
```bash
cd /var/www/html/ptvx/laravel
php artisan test --filter=ListLogActivitiesAction
```

## Casi d'Uso Reali

### 1. IndennitaResponsabilita

```php
// Modules/IndennitaResponsabilita/...Pages/ListIndennitaResponsabilitas.php
public function getTableActions(): array
{
    return [
        'compila' => Action::make('compila')
            ->icon('heroicon-m-pencil-square')
            ->url(fn ($record) => IndennitaResponsabilitaResource::getUrl('compila', ['record' => $record])),
        'pdf' => PdfAction::make()
            ->visible(fn ($record) => $record->ratings?->sum('pivot.value') > 0),
        'edit' => EditAction::make(),
        'activities' => ListLogActivitiesAction::make(),  // ← Aggiungi qui
    ];
}
```

### 2. Performance Module

```php
// Modules/Performance/...Pages/ListPerformances.php
public function getTableActions(): array
{
    return [
        'view' => ViewAction::make(),
        'edit' => EditAction::make(),
        'activities' => ListLogActivitiesAction::make()
            ->authorize(fn () => auth()->user()->can('view_audit_log')),
    ];
}
```

### 3. Con Badge Conteggio

```php
'activities' => ListLogActivitiesAction::make()
    ->badge(fn (Model $record) => $record->activities_count)
    ->badgeColor('warning')
```

## Best Practice

1. **Sempre eager load** `activities_count` per performance
2. **Sempre verificare** visibilità basata su dati reali, non assunzioni
3. **Sempre usare** traduzioni dai file, mai hardcoded
4. **Sempre testare** con record con e senza attività
5. **Sempre configurare** `getActivitylogOptions()` nel modello

## Troubleshooting

### Action Non Visibile

**Causa**: Visibilità condizionale fallisce

**Soluzione**:
```php
// Rimuovere temporaneamente ->visible() per debug
'activities' => ListLogActivitiesAction::make()
    // ->visible(...)  ← Commenta per test
```

### URL Non Corretto

**Causa**: Pagina 'log-activity' non registrata

**Soluzione**: Verificare `getPages()` in Resource:
```php
public static function getPages(): array
{
    return [
        // ...
        'log-activity' => Pages\ListModelActivities::route('/{record}/activities'),
    ];
}
```

### Errore 404

**Causa**: La classe della pagina non esiste

**Soluzione**: Creare la classe che estende `ListLogActivities`:
```php
<?php

namespace Modules\MyModule\Filament\Resources\MyResource\Pages;

use Modules\Activity\Filament\Pages\ListLogActivities;

class ListMyModelActivities extends ListLogActivities
{
    protected static string $resource = MyResource::class;
}
```

## Collegamenti

### Documentazione Interna
- [README Activity Module](../README.md)
- [ListLogActivitiesAction Details](./actions/list-log-activities-action.md)
- [ListLogActivities Page](./pages/list-log-activities.md)

### Regole e Convenzioni
- [Filament Custom Actions Rules](../../../.cursor/rules/filament-custom-actions.mdc)
- [Translation Best Practices](../../Xot/docs/translation-best-practices.md)
- [Service Provider Architecture](../../Xot/docs/service-provider-architecture.md)

### Moduli Correlati
- [IndennitaResponsabilita - Activity Log Integration](../../IndennitaResponsabilita/docs/activity-log-integration.md)
- [Xot - Filament Base Components](../../Xot/docs/filament/README.md)

---

**Ultimo aggiornamento**: 27 Ottobre 2025  
**Pattern**: DRY + KISS per Actions riutilizzabili  
**Conformità**: ✅ PHPStan livello 9+, ✅ Pint, ✅ Test Suite


