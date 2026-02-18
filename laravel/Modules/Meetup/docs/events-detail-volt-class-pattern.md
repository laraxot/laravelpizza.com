# Events Detail Component - Volt Class Pattern

## 🎯 Principio: Public Properties nel Volt Component

Il componente `events/detail.blade.php` utilizza il pattern Volt Class con **public properties** per l'accesso diretto ai dati nel template.

## ✅ Pattern Corretto: Public Properties

### Proprietà della Classe Volt

```php
new class extends Component {
    // Props in input (da CMS)
    public ?Event $event = null;
    public ?Event $item = null;
    public string $container0 = '';
    public string $slug0 = '';

    // Public properties per il template (popolate in mount())
    public string $title = 'Event Title';
    public string $slug = '';
    public string $status = 'upcoming';
    public string $statusLabel = 'Upcoming';
    public ?string $description = null;
    public string $date = '';
    public string $time = '';
    public string $location = 'Location TBA';
    public int $attendeesCurrent = 0;
    public int $attendeesMax = 100;
    public ?string $coverImage = null;
    public int $availableSpots = 100;
    public string $eventsUrl = '';
    public string $badgeClass = 'bg-green-600';

    public function mount(): void
    {
        // 1. Risolvi il modello: event ?? item ?? query by slug0
        $eventModel = $this->event ?? $this->item;

        if ($eventModel === null && $this->slug0 !== '') {
            $eventModel = Event::where('slug', $this->slug0)->first();
        }

        // 2. Popola le public properties dal modello
        if ($eventModel instanceof Event) {
            $startDate = $eventModel->start_date ?? Carbon::now();
            $endDate = $eventModel->end_date ?? $startDate;

            $this->title = $eventModel->title;
            $this->slug = $eventModel->slug;
            $this->description = $eventModel->description;
            $this->date = $startDate->format('l, F j, Y');
            $this->time = $startDate->format('g:i A').' - '.$endDate->format('g:i A');
            $this->location = $eventModel->location ?? 'Location TBA';
            $this->attendeesCurrent = $eventModel->attendees_count ?? 0;
            $this->attendeesMax = $eventModel->max_attendees ?? 100;
            $this->coverImage = $eventModel->cover_image;
            $this->availableSpots = ($eventModel->max_attendees ?? 100) - ($eventModel->attendees_count ?? 0);

            $this->status = $startDate->isFuture() ? 'upcoming' : 'past';
            $this->statusLabel = $this->status === 'upcoming' ? 'Upcoming' : 'Past Event';
            $this->badgeClass = $this->status === 'upcoming' ? 'bg-green-600' : 'bg-slate-500';
        }

        $this->eventsUrl = LaravelLocalization::localizeUrl('/events');
    }
};
```

### Accesso nel Template

```blade
<!-- Usa $this->propertyName direttamente -->
<h1>{{ $this->title }}</h1>
<span class="{{ $this->badgeClass }}">{{ $this->statusLabel }}</span>
<p>{{ $this->location }}</p>

@if($this->status === 'upcoming')
    <button>Book Now</button>
@endif
```

## ⚠️ REGOLA: Unica Fonte di Verità = Event Model

**NON creare array o computed come `eventData`** - usa direttamente le public properties!

```blade
<!-- ❌ SBAGLIATO - Non usare array -->
{{ $this->eventData['title'] }}

<!-- ✅ CORRETTO - Usa public property -->
{{ $this->title }}
```

## 🔗 Riferimenti

- [Volt Components Usage](../Themes/Meetup/docs/volt-components-usage.md)
- [Container0 Slug0 Pattern](../Themes/Meetup/docs/container0-slug0-agnostic-pattern.md)
- [CMS Block System](../Cms/docs/content-blocks-system.md)
