# Events Detail Component - Volt Class Pattern

## 🎯 Principio: Il modello Event è l'unica fonte di verità

Il componente `events/detail.blade.php` utilizza il pattern Volt Class dove il **modello Event è l'unica fonte di verità**.

## ✅ Pattern: Accesso Diretto al Modello

### Volt Class

```php
new class extends Component {
    public ?Event $event = null;
    public ?Event $item = null;
    public string $container0 = '';
    public string $slug0 = '';

    public function mount(): void
    {
        if ($this->event === null && $this->item === null && $this->slug0 !== '') {
            $this->event = Event::where('slug', $this->slug0)->first();
        } elseif ($this->item !== null) {
            $this->event = $this->item;
        }
    }
}; 

$eventsUrl = LaravelLocalization::localizeUrl('/events');
?>
```

### Template Blade - Accesso Diretto

```blade
{{-- Accesso diretto alle proprietà del modello --}}
<h1>{{ $this->event?->title ?? 'Event Title' }}</h1>
<p>{{ $this->event?->location ?? 'Location TBA' }}</p>

{{-- Accesso con metodi del modello --}}
<span class="{{ ($this->event?->start_date?->isFuture() ?? true) ? 'bg-green-600' : 'bg-slate-500' }}">
    {{ ($this->event?->start_date?->isFuture() ?? true) ? 'Upcoming' : 'Past Event' }}
</span>

{{-- Variabili helper --}}
<a href="{{ $eventsUrl }}">Back to Events</a>
```

## ⚠️ REGOLA: Unica Fonte di Verità = Event Model

Non creare computed come `eventData` - usa direttamente le proprietà del modello con `$this->event?->property`!

## 🔗 Riferimenti

- [Volt Components Usage](../Themes/Meetup/docs/volt-components-usage.md)
- [CMS Block System](../Cms/docs/content-blocks-system.md)
