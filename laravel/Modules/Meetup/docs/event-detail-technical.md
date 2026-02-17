# Event Detail Page - Technical Requirements

## Analisi Comparativa

Pagina di riferimento: https://laravelpizza.com/events/1
Pagina locale: http://127.0.0.1:8000/it/events/laravel-11-release-pizza-party

## Dati Evento di Riferimento

```json
{
  "title": "Laravel 11 Release Pizza Party",
  "slug": "laravel-11-release-pizza-party",
  "status": "upcoming",
  "date": "2025-12-15",
  "start_time": "18:00",
  "end_time": "21:00",
  "location": {
    "name": "Tech Hub Downtown",
    "address": "123 Main St",
    "coordinates": null
  },
  "description": "Celebrate the release of Laravel 11 with fellow developers! We'll discuss new features, share experiences, and enjoy delicious pizza together. Perfect for both beginners and experienced Laravel developers.",
  "max_attendees": 30,
  "current_attendees": 5,
  "attendees": [
    {"name": "Taylor Otwell", "avatar": "..."},
    "..."
  ],
  "images": 6
}
```

## Schema Database Necessario

### Migration Aggiornata per events

```php
// Aggiungere a Modules/Meetup/database/migrations/xxxx_create_events_table.php

$table->text('description')->nullable()->after('title');
$table->string('location_name')->nullable()->after('description');
$table->string('location_address')->nullable()->after('location_name');
$table->decimal('location_lat', 10, 8)->nullable()->after('location_address');
$table->decimal('location_lng', 11, 8)->nullable()->after('location_lat');
$table->integer('max_attendees')->default(100)->after('location_lng');
$table->time('start_time')->nullable()->after('date');
$table->time('end_time')->nullable()->after('start_time');
```

### Relazioni Necessarie

```php
// In Modules/Meetup/Models/Event.php

/**
 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<User>
 */
public function attendees(): BelongsToMany
{
    return $this->belongsToManyX(User::class, 'event_attendee')
        ->withTimestamps()
        ->withPivot('status', 'registered_at');
}

/**
 * @return \Illuminate\Database\Eloquent\Relations\HasMany<EventImage>
 */
public function images(): HasMany
{
    return $this->hasMany(EventImage::class);
}
```

## Componenti Filament/Blade Necessari

### 1. EventDetail Component

```php
// Themes/Meetup/resources/views/components/blocks/events/detail.blade.php

@props(['event', 'showMap' => true, 'showAttendees' => true])

<div class="event-detail">
    <!-- Hero con immagine -->
    <!-- Badge stato (upcoming/past) -->
    <!-- Info data/ora -->
    <!-- Sezione About -->
    <!-- Sezione Location + Mappa -->
    <!-- Sidebar con CTA -->
    <!-- Sezione Attendees -->
</div>
```

### 2. EventRegistration Action

```php
// Modules/Meetup/Filament/Actions/EventRegistrationAction.php

class EventRegistrationAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->label('meetup::event.actions.register.label')
            ->color('primary')
            ->requiresConfirmation()
            ->action(fn (Event $event) => $this->registerUser($event));
    }
}
```

## API/Actions Necessarie

### GetEventDetailAction

```php
class GetEventDetailAction
{
    use QueueableAction;
    
    public function execute(string $slug): EventData
    {
        $event = Event::where('slug', $slug)
            ->with(['attendees', 'images'])
            ->firstOrFail();
            
        return EventData::fromModel($event);
    }
}
```

## Sezioni Pagina

1. **Hero Section**
   - Immagine principale evento
   - Titolo H1
   - Badge stato

2. **Info Bar**
   - Data formattata ("Tuesday, February 17, 2026")
   - Orario ("9:11 PM - 9:11 PM")
   - Location
   - Spots disponibili

3. **About Section**
   - Descrizione completa
   - Lista features/topics

4. **Location Section**
   - Indirizzo formattato
   - Mappa interattiva (Google Maps/OpenStreetMap)

5. **Attendees Section**
   - Contatore ("5 / 30")
   - Lista avatar partecipanti
   - Nomi visibili

6. **CTA Sidebar**
   - Pulsante "Book Your Spot"
   - Info capienza
   - Countdown (opzionale)

## Collegamenti

- [Event Architecture](events-dynamic-architecture.md)
- [Folio Pages](folio-pages-json-only-rule.md)
- [Tema Meetup Docs](../../Themes/Meetup/docs/event-detail-parity.md)
