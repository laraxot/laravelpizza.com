# Volt Components nel Tema Meetup

## Introduzione

Il tema Meetup utilizza Laravel Folio per il routing e Livewire Volt per i componenti interattivi. Questo documento descrive come utilizzare correttamente i componenti Volt nel contesto del CMS-driven pages.

## Pattern: Volt Class + @php Helper

### ❌ SBAGLIATO: Troppe public properties

```php
// ❌ NO! Troppe proprietà da gestire
public string $title = '';
public string $status = '';
// ... decine di proprietà
```

### ✅ CORRETTO: Volt Class semplice + @php block

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
?>

@php
// Variabili helper per il template
$event = $this->event;
$eventsUrl = LaravelLocalization::localizeUrl('/events');

if ($event instanceof Event) {
    $startDate = $event->start_date ?? Carbon::now();
    $title = $event->title;
    $status = $startDate->isFuture() ? 'upcoming' : 'past';
    // ... altre variabili
}
@endphp

{{-- Template usa le variabili helper --}}
<h1>{{ $title }}</h1>
```

## Struttura File

```
Themes/Meetup/resources/views/pages/
├── [container0]/
│   ├── index.blade.php
│   └── [slug0]/
│       └── index.blade.php
└── ...

Themes/Meetup/resources/views/components/blocks/
└── events/
    └── detail.blade.php
```

## Attivazione da JSON pagina

```json
"data": {
    "view": "pub_theme::components.blocks.events.detail",
    "livewire": "events.detail"
}
```

Se `livewire` è presente, `page-content.blade.php` usa `@livewire`.

## ⚠️ Regola critica: non togliere il template

Quando refactori un componente Volt in un file `.blade.php`, **non rimuovere mai il template Blade** (il “vestito” sotto la classe PHP). La classe definisce stato e `mount()`; il markup sotto è ciò che l’utente vede. Classe senza template = pagina vuota.

## Vantaggi del Pattern

1. **Semplicità**: Classe Volt minima
2. **Pulizia**: @php block tiene logica separata dal template
3. **Manutenibilità**: Unica fonte di verità = modello

## Riferimenti

- [Laravel Folio](https://laravel.com/docs/12.x/folio)
- [Livewire Volt](https://livewire.laravel.com/docs/4.x/volt)
- [Container0 Pattern](./container0-slug0-agnostic-pattern.md)
