# Events Detail Component - Volt Class Pattern

## 🎯 Principio: Il modello Event è l'unica fonte di verità

Il componente `events/detail.blade.php` utilizza il pattern Volt Class dove il **modello Event è l'unica fonte di verità**.

## ✅ Pattern: Volt Class + @php Helper

### Volt Class (semplice)

```php
new class extends Component {
    public ?Event $event = null;
    public string $container0 = '';
    public string $slug0 = '';

    public function mount(): void
    {
        if ($this->event === null && $this->slug0 !== '') {
            $this->event = Event::where('slug', $this->slug0)->first();
        }
    }
};
```

### @php Block (variabili helper)

```php
@php
$event = $this->event;
$eventsUrl = LaravelLocalization::localizeUrl('/events');

if ($event instanceof Event) {
    $startDate = $event->start_date ?? Carbon::now();
    $endDate = $event->end_date ?? $startDate;
    $dateFormatted = $startDate->format('l, F j, Y');
    $title = $event->title;
    $description = $event->description;
    // ... altre variabili
} else {
    $title = 'Event Title';
    // ... valori default
}
@endphp
```

### Template Blade

```blade
<h1>{{ $title }}</h1>
<p>{{ $location }}</p>
<span class="{{ $badgeClass }}">{{ $statusLabel }}</span>
```

## ⚠️ REGOLA: Unica Fonte di Verità = Event Model

Non creare computed come `eventData` - usa le variabili helper nel @php block!

## 🔗 Riferimenti

- [Volt Components Usage](../Themes/Meetup/docs/volt-components-usage.md)
- [CMS Block System](../Cms/docs/content-blocks-system.md)
