# Events Detail Component - Volt Class Pattern

## 🎯 Principio: Il modello Event è l'unica fonte di verità

Il componente `events/detail.blade.php` utilizza il pattern Volt Class dove il **modello Event è l'unica fonte di verità**. Non si duplicano i dati in array o computed - si accede direttamente alle proprietà del modello.

## ✅ Pattern Corretto: Accesso Diretto al Modello

### Volt Class

```php
new class extends Component {
    // Props in input (da CMS/Livewire)
    public ?Event $event = null;
    public string $container0 = '';
    public string $slug0 = '';

    public function mount(): void
    {
        if ($this->event === null && $this->slug0 !== '') {
            $this->event = Event::where('slug', $this->slug0)->first();
        }
    }

    #[Computed]
    public function eventsUrl(): string
    {
        return LaravelLocalization::localizeUrl('/events');
    }
};
```

### Accesso nel Template

```blade
{{-- Accesso diretto alle proprietà del modello --}}
<h1>{{ $this->event?->title }}</h1>
<p>{{ $this->event?->description }}</p>
<p>{{ $this->event?->location }}</p>

{{-- Accesso con metodi --}}
<span class="{{ $this->event?->start_date?->isFuture() ? 'bg-green-600' : 'bg-slate-500' }}">
    {{ $this->event?->start_date?->isFuture() ? 'Upcoming' : 'Past Event' }}
</span>

{{-- Computed properties --}}
<a href="{{ $this->eventsUrl }}">Back to Events</a>
```

## ⚠️ REGOLA: Unica Fonte di Verità = Event Model

**NON creare computed come `eventData`** - usa direttamente le proprietà del modello!

```blade
<!-- ❌ SBAGLIATO -->
{{ $this->eventData['title'] }}

<!-- ✅ CORRETTO -->
{{ $this->event?->title }}
```

## 🔗 Riferimenti

- [Volt Components Usage](../Themes/Meetup/docs/volt-components-usage.md)
- [Container0 Slug0 Pattern](../Themes/Meetup/docs/container0-slug0-agnostic-pattern.md)
- [CMS Block System](../Cms/docs/content-blocks-system.md)
