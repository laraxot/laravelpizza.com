# Events Detail Component - Volt Class Pattern

## Core Principle: Unica fonte di verità = Event

Il componente `events/detail.blade.php` è un **Volt component**. La logica deve seguire questi principi:

1. **Unica fonte di verità**: Il modello `Event` è l'unica fonte di verità. Non creare variabili ridondanti per proprietà che sono già presenti nel modello.
2. **Proprietà Essential**: Le proprietà pubbliche devono essere limitate a quelle necessarie per lo stato o iniettate dall'esterno (`$event`, `$item`, `$container0`, `$slug0`).
3. **Mount Logic**: In `mount()`, risolvi l'istanza dell'evento partendo da `$event ?? $item ?? $slug0`.
4. **No Flat Properties**: Evita di mappare ogni campo del modello su una proprietà pubblica del componente (es. `$this->title = $event->title`). Usa direttamente `$this->event->title` nella vista.
5. **Metodi Helper**: Usa metodi pubblici per logica di formattazione o calcolo (es. `getDate()`, `isUpcoming()`).

---

## Esempio Corretto

```php
new class extends Component {
    public ?Event $event = null;
    public string $container0 = '';
    public string $slug0 = '';

    public function mount(): void
    {
        if ($this->event === null && !empty($this->slug0)) {
            $this->event = Event::where('slug', $this->slug0)->first();
        }
    }
};
```

## Vista (Blade)

Nella vista, accedi ai dati tramite l'oggetto modello:

```blade
<h1>{{ $this->event->title }}</h1>
<p>{{ $this->getDate() }}</p>
```

---

## ⚠️ Regole Inviolabili

- **NO declare(strict_types=1)**: Mai nei file `.blade.php`.
- **Volt in Pages e Blocks**: Le pagine Folio e i blocchi del CMS devono usare Volt quando è necessaria logica o reattività.
- **KISS & DRY**: Non duplicare dati che risiedono già nel database/modello.

## Riferimenti

- [Volt Components Usage](volt-components-usage.md)
- [Folio Routing System](folio_routing_system.md)
