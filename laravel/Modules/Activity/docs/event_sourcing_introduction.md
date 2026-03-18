# Event Sourcing in `saluteora`

## Introduction to Event Sourcing
Event Sourcing is an architectural pattern where application state is derived from a sequence of events. Instead of storing the current state in a database, the application stores all events that led to the current state. This approach is particularly beneficial in a healthcare context like `saluteora` for tracking patient activities, medical records, and system interactions with full auditability.

### Key Concepts
- **Events**: Discrete actions or changes in the system (e.g., `PatientRegistered`, `AppointmentScheduled`).
- **Event Store**: A database or log where all events are stored in sequence.
- **Aggregates**: Domain objects that handle commands and produce events (e.g., a `Patient` aggregate).
- **Projectors**: Components that listen to events and build read models or projections for querying.
- **Reactors**: Components that react to events to trigger side effects (e.g., sending notifications).

### Benefits for Healthcare Applications
- **Audit Trail**: Every action is recorded, crucial for compliance with healthcare regulations.
- **Reconstruction**: Ability to reconstruct past states for debugging or analysis.
- **Flexibility**: Easy to extend with new features by adding new event types and projectors.
- **Accuracy**: Ensures data integrity by replaying events to validate current state.

## Spatie Laravel Event Sourcing
The `spatie/laravel-event-sourcing` package provides a robust implementation of event sourcing for Laravel applications. It simplifies creating aggregates, storing events, and building projections.

### Installation
```bash
composer require spatie/laravel-event-sourcing
php artisan vendor:publish --provider="Spatie\EventSourcing\EventSourcingServiceProvider" --tag="event-sourcing-migrations"
php artisan migrate
```

### Core Components
1. **Aggregates**: Represent domain entities and handle business logic.
2. **Events**: Define what happened in the system.
3. **Projectors**: Build read models from events for efficient querying.
4. **Reactors**: Handle side effects like notifications or external API calls.

## Application in `saluteora`
In a healthcare system like `saluteora`, event sourcing can be applied to:
- **Patient Management**: Track registration, updates to personal information, and medical history as events.
- **Appointment Scheduling**: Record scheduling, rescheduling, and cancellation of appointments.
- **Medical Records**: Log diagnoses, treatments, and prescriptions with full history.
- **Billing and Insurance**: Track financial transactions and claims processing.

### Example: Patient Registration
```php
// app/Aggregates/PatientAggregate.php
namespace App\Aggregates;

use Spatie\EventSourcing\AggregateRoots\AggregateRoot;
use App\Events\PatientRegistered;
use App\Events\PatientUpdated;

class PatientAggregate extends AggregateRoot
{
    public function register(array $data)
    {
        $this->recordThat(new PatientRegistered($data));
        return $this;
    }

    public function update(array $data)
    {
        $this->recordThat(new PatientUpdated($data));
        return $this;
    }
}

// app/Events/PatientRegistered.php
namespace App\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class PatientRegistered extends ShouldBeStored
{
    public function __construct(public array $data)
    {
    }
}

// app/Events/PatientUpdated.php
namespace App\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class PatientUpdated extends ShouldBeStored
{
    public function __construct(public array $data)
    {
    }
}

// app/Projectors/PatientProjector.php
namespace App\Projectors;

use Spatie\EventSourcing\Projectionist\EloquentStoredEventRepository;
use Spatie\EventSourcing\Projectionist\Projector;
use App\Events\PatientRegistered;
use App\Events\PatientUpdated;
use App\Models\Patient;

class PatientProjector implements Projector
{
    public function onPatientRegistered(PatientRegistered $event, string $aggregateUuid)
    {
        Patient::create([
            'uuid' => $aggregateUuid,
            'data' => $event->data,
        ]);
    }

    public function onPatientUpdated(PatientUpdated $event, string $aggregateUuid)
    {
        $patient = Patient::where('uuid', $aggregateUuid)->first();
        $patient->update(['data' => array_merge($patient->data, $event->data)]);
    }
}
```

### Usage in Controller
```php
// app/Http/Controllers/PatientController.php
use App\Aggregates\PatientAggregate;

public function store(Request $request)
{
    $patientData = $request->validate([
        'name' => 'required',
        'dob' => 'required|date',
        'address' => 'required',
    ]);

    PatientAggregate::make()->register($patientData)->persist();

    return redirect()->route('patients.index');
}
```

## Best Practices for `saluteora`
1. **Granular Events**: Define specific events for each action (e.g., `PatientRegistered`, `AppointmentScheduled`) to ensure detailed tracking.
2. **Audit Compliance**: Store events indefinitely to meet healthcare audit requirements.
3. **Performance Optimization**: Use projectors to build efficient read models for frequent queries, avoiding real-time event replay in production.
4. **Security**: Encrypt sensitive event data (e.g., patient information) within the event store.
5. **Reactors for Notifications**: Implement reactors for sending emails or SMS notifications on critical events like appointment confirmations.

## Resources
- [Spatie Laravel Event Sourcing](https://github.com/spatie/laravel-event-sourcing)
- [Spatie Documentation](https://docs.spatie.be/laravel-event-projector/v1/introduction)
- [Microsoft Azure Event Sourcing Pattern](https://docs.microsoft.com/en-us/azure/architecture/patterns/event-sourcing)
- [Larabank Examples](https://github.com/spatie/larabank-traditional)

This introduction to event sourcing sets the foundation for implementing a robust activity tracking system in `saluteora`, ensuring full traceability and compliance with healthcare standards.
