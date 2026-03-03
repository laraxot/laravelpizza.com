# Meetup Module Factories

Documentazione completa delle factory per il modulo Meetup.

---

## EventFactory

Factory principale per la creazione di eventi Laravel meetup con dati realistici.

### Utilizzo Base

```php
use Modules\Meetup\Models\Event;

// Crea evento con dati casuali
$event = Event::factory()->create();

// Crea 10 eventi
$events = Event::factory()->count(10)->create();
```

### Stati Disponibili

#### upcoming()
Crea eventi futuri (1-90 giorni da oggi):

```php
$upcomingEvent = Event::factory()->upcoming()->create();
```

#### past()
Crea eventi passati (fino a 1 anno fa):

```php
$pastEvent = Event::factory()->past()->create();
```

#### online()
Crea eventi online:

```php
$onlineEvent = Event::factory()->online()->create();
```

#### free()
Crea eventi gratuiti:

```php
$freeEvent = Event::factory()->free()->create();
```

#### cancelled()
Crea eventi cancellati:

```php
$cancelledEvent = Event::factory()->cancelled()->create();
```

### Combinazione Stati

```php
// Evento online gratuito futuro
$event = Event::factory()
    ->upcoming()
    ->online()
    ->free()
    ->create();
```

### Dati Generati

La factory genera automaticamente:

- **Titoli realistici**: "Laravel Meetup - Milano", "PHP Conference - Roma"
- **Location**: Impact Hub Milano, Talent Garden Roma, ecc.
- **Date**: Start date + end date con durata 2-4 ore
- **Descrizione**: 3 paragrafi di testo
- **Metadata**: difficulty, topics (Laravel, PHP, Vue.js, ecc.)
- **Offers**: Schema.org compliant con prezzi 0-50 EUR
- **Keywords**: 5 parole chiave casuali
- **User/Organizer**: Creati automaticamente via User::factory()

### Override Campi

```php
$event = Event::factory()->create([
    'title' => 'Custom Event Title',
    'location' => 'Custom Location',
    'max_attendees' => 500,
]);
```

---

## EventUserFactory

Factory per la tabella pivot `event_user` (partecipanti agli eventi).

### Utilizzo Base

```php
use Modules\Meetup\Models\EventUser;

// Crea relazione evento-utente
$eventUser = EventUser::factory()->create();
```

### Stati Disponibili

#### forEvent()
Associa a un evento specifico:

```php
$event = Event::factory()->create();

EventUser::factory()
    ->forEvent($event)
    ->count(10)
    ->create();
```

#### forUser()
Associa a un utente specifico:

```php
$user = User::factory()->create();

EventUser::factory()
    ->forUser($user)
    ->count(5)
    ->create();
```

### Esempio Completo

```php
// Crea evento con 50 partecipanti
$event = Event::factory()->create();

EventUser::factory()
    ->forEvent($event)
    ->count(50)
    ->create();
```

---

## EventSponsorFactory

Factory per la tabella pivot `event_sponsor` (sponsor degli eventi).

### Utilizzo Base

```php
use Modules\Meetup\Models\EventSponsor;

// Crea relazione evento-sponsor
$eventSponsor = EventSponsor::factory()->create();
```

### Stati Disponibili

#### forEvent()
Associa a un evento specifico:

```php
$event = Event::factory()->create();

EventSponsor::factory()
    ->forEvent($event)
    ->count(3)
    ->create();
```

#### forSponsor()
Associa a uno sponsor specifico:

```php
$sponsor = User::factory()->create();

EventSponsor::factory()
    ->forSponsor($sponsor)
    ->count(5)
    ->create();
```

### Esempio Completo

```php
// Crea evento con 3 sponsor
$event = Event::factory()->create();

EventSponsor::factory()
    ->forEvent($event)
    ->count(3)
    ->create();
```

---

## EventPerformerFactory

Factory per la tabella pivot `event_performer` (speaker/relatori degli eventi).

### Utilizzo Base

```php
use Modules\Meetup\Models\EventPerformer;

// Crea relazione evento-speaker
$eventPerformer = EventPerformer::factory()->create();
```

### Stati Disponibili

#### forEvent()
Associa a un evento specifico:

```php
$event = Event::factory()->create();

EventPerformer::factory()
    ->forEvent($event)
    ->count(2)
    ->create();
```

#### forPerformer()
Associa a uno speaker specifico:

```php
$speaker = User::factory()->create();

EventPerformer::factory()
    ->forPerformer($speaker)
    ->count(10)
    ->create();
```

### Esempio Completo

```php
// Crea evento con 2 speaker
$event = Event::factory()->create();

EventPerformer::factory()
    ->forEvent($event)
    ->count(2)
    ->create();
```

---

## Scenario Completo

Esempio di creazione di un evento completo con partecipanti, sponsor e speaker:

```php
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Modules\Meetup\Models\EventSponsor;
use Modules\Meetup\Models\EventPerformer;

// Crea evento futuro online gratuito
$event = Event::factory()
    ->upcoming()
    ->online()
    ->free()
    ->create([
        'title' => 'Laravel Italia Meetup 2026',
        'max_attendees' => 200,
    ]);

// Aggiungi 150 partecipanti
EventUser::factory()
    ->forEvent($event)
    ->count(150)
    ->create();

// Aggiungi 3 sponsor
EventSponsor::factory()
    ->forEvent($event)
    ->count(3)
    ->create();

// Aggiungi 2 speaker
EventPerformer::factory()
    ->forEvent($event)
    ->count(2)
    ->create();
```

---

## Seeder Esempio

```php
<?php

namespace Modules\Meetup\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Modules\Meetup\Models\EventSponsor;
use Modules\Meetup\Models\EventPerformer;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // 10 eventi futuri
        Event::factory()
            ->upcoming()
            ->count(10)
            ->create()
            ->each(function (Event $event): void {
                // Partecipanti (20-80)
                EventUser::factory()
                    ->forEvent($event)
                    ->count(rand(20, 80))
                    ->create();
                
                // Sponsor (1-3)
                EventSponsor::factory()
                    ->forEvent($event)
                    ->count(rand(1, 3))
                    ->create();
                
                // Speaker (1-2)
                EventPerformer::factory()
                    ->forEvent($event)
                    ->count(rand(1, 2))
                    ->create();
            });

        // 5 eventi passati
        Event::factory()
            ->past()
            ->count(5)
            ->create();
    }
}
```

---

## Best Practices

### 1. Usa Stati per Scenari Specifici

```php
// ✅ CORRETTO
$event = Event::factory()->upcoming()->online()->create();

// ❌ EVITARE
$event = Event::factory()->create([
    'start_date' => now()->addDays(10),
    'event_attendance_mode' => 'OnlineEventAttendanceMode',
]);
```

### 2. Combina Factory per Relazioni

```php
// ✅ CORRETTO
$event = Event::factory()->create();
EventUser::factory()->forEvent($event)->count(50)->create();

// ❌ EVITARE - Creazione manuale relazioni
```

### 3. Override Solo Quando Necessario

```php
// ✅ CORRETTO - Override solo campi specifici
$event = Event::factory()->create([
    'title' => 'Special Event',
]);

// ❌ EVITARE - Override di troppi campi
$event = Event::factory()->create([
    'title' => '...',
    'description' => '...',
    'location' => '...',
    // ... troppi override
]);
```

---

## Testing

### Feature Test Esempio

```php
<?php

namespace Tests\Feature\Meetup;

use Tests\TestCase;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;

class EventRegistrationTest extends TestCase
{
    /** @test */
    public function user_can_register_to_upcoming_event(): void
    {
        $event = Event::factory()->upcoming()->create();
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->post(route('events.register', $event));
        
        $response->assertRedirect();
        
        $this->assertDatabaseHas('event_user', [
            'event_id' => $event->id,
            'user_id' => $user->id,
        ]);
    }
}
```

---

## Collegamenti

- [Event Model](../app/Models/Event.php)
- [EventUser Model](../app/Models/EventUser.php)
- [EventSponsor Model](../app/Models/EventSponsor.php)
- [EventPerformer Model](../app/Models/EventPerformer.php)
- [Laravel Factory Documentation](https://laravel.com/docs/11.x/eloquent-factories)

*
