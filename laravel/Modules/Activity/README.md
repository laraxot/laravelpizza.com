# Activity Module

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![Filament 5.x](https://img.shields.io/badge/Filament-5.x-blue.svg)](https://filamentphp.com/)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![PHP 8.3+](https://img.shields.io/badge/PHP-8.3+-blue.svg)](https://php.net)
[![Event Sourcing](https://img.shields.io/badge/Event-Sourcing-orange.svg)](https://martinfowler.com/eaaDev/EventSourcing.html)
[![Test Coverage 91%](https://img.shields.io/badge/Coverage-91%25-success.svg)](tests/)

> **Audit trail + Event sourcing in un unico modulo**: traccia ogni azione utente, ricostruisci lo stato di qualsiasi entita nel tempo, monitora login/logout e operazioni CRUD. Basato su Spatie ActivityLog + Event Sourcing.

---

## Cosa fa

Il modulo Activity combina due pattern enterprise in un'unica soluzione:

1. **Audit Trail** (Spatie ActivityLog): registra chi ha fatto cosa, quando, e su quale entita
2. **Event Sourcing** (Spatie Event Sourcing): memorizza ogni evento come fatto immutabile, con snapshot per performance

```php
// Logging automatico di un'azione
app(LogModelCreatedAction::class)->execute($model, $user);

// Logging login/logout via listener
app(LogUserLoginAction::class)->execute($user, $request->ip());

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
<<<<<<< .merge_file_lHi0B5
Activity <── healthcare_app   (survey CRUD, dashboard actions)
=======
<<<<<<< HEAD
Activity <── Survey    (survey CRUD, dashboard actions)
=======
Activity <── ModuloEsempio   (survey CRUD, dashboard actions)
>>>>>>> f04e1ab44 (refactor: update project references from <nome progetto> to PTVX)
>>>>>>> .merge_file_bD7FZH
Activity <── Cms       (page/content modifications)
Activity <── Media     (file upload/delete tracking)
Activity <── Tenant    (multi-tenant audit isolation)
Activity <── Lang      (traduzioni IT/EN/DE)
```

Ogni modulo puo generare eventi che Activity traccia automaticamente via listener o injection diretta delle Actions.

---

## Quick Start

```bash
# Abilita il modulo
php artisan module:enable Activity

# Esegui le migrazioni
php artisan migrate

# Verifica che funzioni
php artisan tinker
>>> Modules\Activity\Models\Activity::count();
```

### Tracciare un'azione custom

```php
use Modules\Activity\Actions\LogActivityAction;

// In qualsiasi punto del codice
app(LogActivityAction::class)->execute([
    'event' => 'survey.exported',
    'subject' => $survey,
    'data' => ['format' => 'pdf', 'pages' => 42],
]);
```

---

## Metriche del modulo

| Metrica | Valore |
|---------|--------|
| **Modelli** | 3 core + 4 policy |
| **Azioni Queueable** | 8 (zero Service class) |
| **Filament Resource** | 3 con CRUD completo |
| **Filament Pages** | 11 (9 CRUD + 2 speciali) |
| **Migrazioni** | 5 |
| **Factory** | 4 |
| **Seeder** | 5 |
| **Event Listener** | 2 (Login + Logout) |
| **Trait** | 2 (HasEvents + HasSnapshots) |
| **Test Coverage** | 91% |
| **PHPStan Level** | 10 |
| **Documentazione** | 140+ file |

---

## Documentazione

| Guida | Link |
|-------|------|
| **Indice** | [docs/README.md](docs/readme.md) |
| **Business Logic** | [docs/business-logic-overview.md](docs/business-logic-overview.md) |
| **Event Sourcing** | [docs/event-sourcing.md](docs/event-sourcing.md) |
| **Filosofia** | [docs/philosophy.md](docs/philosophy.md) |
| **Architettura** | [docs/architecture-rules.md](docs/architecture-rules.md) |
| **PHPStan Compliance** | [docs/phpstan-compliance.md](docs/phpstan-compliance.md) |
| **Testing** | [docs/testing-strategy-implementation.md](docs/testing-strategy-implementation.md) |
| **Filament Resources** | [docs/filament-resources.md](docs/filament-resources.md) |

---

**Module Type**: Audit & Event Sourcing
**Critical Level**: Alto (usato da tutti i moduli per tracking)
**Architecture**: SOLID, DRY, KISS compliant
**Quality**: PHPStan Level 10, 91% test coverage, Queueable Actions pattern

*Ogni azione tracciata, ogni stato ricostruibile: audit trail e event sourcing enterprise-grade.*
