# UpdateCoordinatesBulkAction - Azione Riutilizzabile per Aggiornamento Coordinate

**Data**: 2025-01-27  
**Modulo**: Geo  
**Status**: ✅ **IMPLEMENTATO**

## Panoramica

L'azione `UpdateCoordinatesBulkAction` è una BulkAction Filament riutilizzabile che consente di aggiornare le coordinate geografiche (latitude/longitude) di più record contemporaneamente utilizzando il geocoding.

## Architettura

### Separazione Responsabilità

L'implementazione segue rigorosamente il principio di separazione delle responsabilità:

1. **Filament BulkAction** (`UpdateCoordinatesBulkAction`): Gestisce UI, notifiche, validazioni Filament
2. **Spatie QueueableAction** (`UpdateCoordinatesFromAddressAction`): Gestisce business logic (geocoding, aggiornamento modello)

### Filosofia

Questa azione risiede nel modulo **Geo** perché:
- La logica di geocoding appartiene al dominio Geo
- È riutilizzabile da qualsiasi modulo che gestisce modelli con indirizzi
- Centralizza la funzionalità evitando duplicazione (DRY)
- Segue la filosofia "Single Source of Truth"

## File Creati

### 1. Spatie QueueableAction

**File**: `Modules/Geo/app/Actions/UpdateCoordinatesFromAddressAction.php`

**Responsabilità**:
- Eseguire geocoding usando `GetAddressDataFromFullAddressAction`
- Aggiornare coordinate (latitude/longitude) del modello
- Gestire errori e logging
- Supportare esecuzione sincrona e asincrona (queue)

**Metodo principale**:
```php
public function execute(Model $model): bool
```

**Supporta modelli con**:
- Proprietà `full_address` (string|null) - indirizzo completo
- Proprietà `latitude` (float|null) - coordinata latitudine
- Proprietà `longitude` (float|null) - coordinata longitudine

### 2. Filament BulkAction

**File**: `Modules/Geo/app/Filament/Actions/UpdateCoordinatesBulkAction.php`

**Responsabilità**:
- Configurare UI (label, icon, comportamento)
- Iterare su Collection di record
- Chiamare `UpdateCoordinatesFromAddressAction` per ogni record
- Gestire notifiche di successo/errore
- Identificare record per messaggi di errore

**Configurazione**:
- Label: `geo::actions.update_coordinates.bulk.label`
- Icon: `heroicon-o-map-pin`
- Comportamento: Deseleziona record dopo completamento

### 3. Traduzioni

**File**: `Modules/Geo/lang/it/actions.php`

**Struttura**:
```php
'update_coordinates' => [
    'errors' => [...],
    'bulk' => [
        'label' => '...',
        'errors' => [...],
        'notifications' => [...],
    ],
],
```

## Utilizzo

### In ListRecords Page

```php
namespace Modules\TechPlanner\Filament\Resources\ClientResource\Pages;

use Modules\Geo\Filament\Actions\UpdateCoordinatesBulkAction;

class ListClients extends XotBaseListRecords
{
    /**
     * @return array<string, \Filament\Actions\BulkAction>
     */
    public function getTableBulkActions(): array
    {
        return [
            'updateCoordinates' => UpdateCoordinatesBulkAction::make(),
        ];
    }
}
```

## Pattern Applicato

### Clean Code

- ✅ Logica business separata dalla UI
- ✅ Single Responsibility Principle
- ✅ DRY: unica implementazione, riutilizzabile
- ✅ Type Safety: PHPStan Level 9+ compliance

### Filosofia Geo

- ✅ Componente riutilizzabile nel modulo della sua logica
- ✅ Separazione UI (Filament) da Business Logic (Actions)
- ✅ Supporto per qualsiasi modello con `full_address`

## Migrazione da TechPlanner

**Prima** (violazione Clean Code):
```php
// Logica inline in ListClients.php (50+ righe)
public function getTableBulkActions(): array
{
    return [
        'updateCoordinates' => BulkAction::make('updateCoordinates')
            ->action(function (Collection $records) {
                // Logica geocoding inline...
            }),
    ];
}
```

**Dopo** (Clean Code):
```php
// Uso azione riutilizzabile
public function getTableBulkActions(): array
{
    return [
        'updateCoordinates' => UpdateCoordinatesBulkAction::make(),
    ];
}
```

## Vantaggi

1. **Riutilizzabilità**: Utilizzabile da Client, Worker, Place, qualsiasi modello con indirizzi
2. **Manutenibilità**: Modifiche centralizzate in un solo punto
3. **Testabilità**: Business logic testabile in isolamento
4. **Type Safety**: PHPStan compliance garantita
5. **Clean Code**: Separazione responsabilità chiara

## Collegamenti

- [Filosofia Componenti Riutilizzabili](./reusable-components-philosophy.md)
- [Pattern QueueableActions](../../Xot/docs/queueable-actions-pattern.md)
- [GetAddressDataFromFullAddressAction](./../app/Actions/GetAddressDataFromFullAddressAction.php)

---

*Ultimo aggiornamento: 2025-01-27*
