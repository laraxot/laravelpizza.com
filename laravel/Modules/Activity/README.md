---
title: Activity
module: activity
related: Xot, User
status: production
---

# Activity Module

**Module**: `activity`
**Namespace**: `Modules\Activity\`
**Status**: ✅ Production

---

## Overview

Il modulo Activity combina due pattern enterprise in un'unica soluzione:

### Key Features

- Feature 1
- Feature 2
- Feature 3

### Module Dependencies

- [Xot](../Xot/README.md) (required)
- [User](../User/README.md) (required)
// Ricostruzione stato da eventi (event sourcing)
$aggregate = MyAggregate::retrieve($uuid);
$aggregate->recordThat(new OrderPlaced($data));
$aggregate->persist();
```

---

## Architettura

```
Azioni Utente (CRUD, Login, Logout, Custom)
    |
    v
8 Queueable Actions (logging asincrono)
    |
    +-- ActivityLogger (orchestratore)
    +-- LogModelCreated/Updated/DeletedAction
    +-- LogUserLogin/LogoutAction
    +-- RestoreActivityAction
    |
    v
Storage duale
    +-- Activity table (audit trail: chi, cosa, quando)
    +-- StoredEvents table (event sourcing: eventi immutabili)
    +-- Snapshots table (performance: stato aggregato)
    |
    v
Filament Admin (3 Resource + Dashboard)
```

---

## Modelli

| Modello | Base | Ruolo |
|---------|------|-------|
| **Activity** | Spatie ActivityLog | Record audit: subject, causer, properties, batch UUID |
| **StoredEvent** | Spatie EloquentStoredEvent | Evento immutabile: aggregate UUID, event class, metadata |
| **Snapshot** | Spatie EventSourcing | Stato aggregato per ricostruzione veloce |

Ogni modello ha la propria **Policy** per autorizzazione fine-grained.

---

## Azioni (Queueable Actions)

Zero Service class. Tutta la logica in 8 azioni queueable:

| Action | Trigger | Dati tracciati |
|--------|---------|----------------|
| **ActivityLogger** | Orchestratore centrale | Routing verso action specifiche |
| **LogActivityAction** | Evento generico | Event name, data, user, timestamp |
| **LogModelCreatedAction** | Model::created | Modello, attributi, user |
| **LogModelUpdatedAction** | Model::updated | Modello, old/new values, user |
| **LogModelDeletedAction** | Model::deleted | Modello, ultimo stato, user |
| **LogUserLoginAction** | Auth::login | IP, user agent, timestamp |
| **LogUserLogoutAction** | Auth::logout | Durata sessione, timestamp |
| **RestoreActivityAction** | Recovery manuale | Ripristino da evento stored |

---

## Filament Integration

### Resource (3)

| Resource | Pagine | Funzione |
|----------|--------|----------|
| **ActivityResource** | List, Create, Edit | Gestione record audit trail |
| **StoredEventResource** | List, Create, Edit | Gestione eventi stored (event sourcing) |
| **SnapshotResource** | List, Create, Edit | Gestione snapshot aggregati |

### Pagine speciali

| Pagina | Funzione |
|--------|----------|
| **Dashboard** | Analytics e statistiche attivita |
| **ListLogActivities** | Vista log con paginazione custom |

---

## Event Sourcing: come funziona

### Registrazione eventi

```php
// Ogni azione genera un evento immutabile
$storedEvent = StoredEvent::create([
    'aggregate_uuid' => $uuid,
    'event_class' => OrderPlaced::class,
    'event_properties' => ['order_id' => 123, 'total' => 99.90],
    'meta_data' => ['user_id' => 1, 'ip' => '192.168.1.1'],
]);
```

### Ricostruzione stato

```php
// Ricostruisci lo stato completo di un aggregato
// Gli snapshot evitano di rileggere tutti gli eventi
$snapshot = Snapshot::where('aggregate_uuid', $uuid)->latest()->first();
// Applica solo gli eventi successivi allo snapshot
```

### Listener automatici

```php
// LoginListener e LogoutListener registrati in EventServiceProvider
// Tracking automatico di ogni autenticazione
class LoginListener
{
    public function handle(Login $event): void
    {
        app(LogUserLoginAction::class)->execute($event->user, request()->ip());
    }
}
```

---

## Trait per i modelli

| Trait | Funzione |
|-------|----------|
| **HasEvents** | Aggiunge event sourcing a qualsiasi modello |
| **HasSnapshots** | Aggiunge capacita di snapshot per performance |

```php
// Aggiungi tracking a qualsiasi modello
class Order extends BaseModel
{
    use HasEvents, HasSnapshots;
    // Ogni CRUD viene automaticamente tracciato
}
```

---

## Integrazione con altri moduli

```
Activity <── User      (login/logout events, user actions)
Activity <── Quaeris   (survey CRUD, dashboard actions)
Activity <── Cms       (page/content modifications)
Activity <── Media     (file upload/delete tracking)
Activity <── Tenant    (multi-tenant audit isolation)
Activity <── Lang      (traduzioni IT/EN/DE)
```

Ogni modulo puo generare eventi che Activity traccia automaticamente via listener o injection diretta delle Actions.

---

## Quick Start

### Installation

```bash
# Already included in main project
# No additional setup required
```

### Basic Usage

```php
use Modules\Activity\Models\YourModel;

$item = YourModel::first();
```

### Configuration

Configuration file: `config/activity.php`

Key settings:
- `setting1` - Description
- `setting2` - Description

---

## Architecture

### Directory Structure

```
Activity/
├── src/
│   ├── Models/
│   ├── Controllers/
│   ├── Resources/
│   ├── Actions/
│   └── Traits/
├── routes/
│   ├── api.php
│   └── web.php
├── database/
│   ├── migrations/
│   └── seeders/
├── tests/
│   ├── Unit/
│   └── Feature/
├── config/
│   └── activity.php
├── docs/
│   └── README.md
└── composer.json
```

### Key Components



---

## API Reference

Reference

---

## Usage Examples

### Common Tasks

#### Task 1: Description

```php
// Code example
```

---

## Testing

### Running Tests

```bash
# Run all module tests
composer test -- Modules/Activity
```

---

## Troubleshooting

### Common Issues

#### Issue: Problem description

**Solution**: How to fix this issue

---

## Related Modules

### Dependencies

- [Xot](../Xot/README.md) - Required module
- [User](../User/README.md) - Required module

### Dependents

- [Comment](../Comment/README.md) - Depends on this module

---

Navigation: [Project Home](../../docs/INDEX.md) | [Modules](../../docs/modules/README.md)
