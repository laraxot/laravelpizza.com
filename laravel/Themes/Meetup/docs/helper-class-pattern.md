# Pattern Helper Class per Componenti Blade

## Quando Usare Helper Class invece di Volt

### Caso d'uso: Componenti inclusi via `@include()`

Quando un componente Blade viene incluso tramite `@include()` (non montato come Livewire), non può essere un Volt Component completo. In questo caso si usa una **Helper Class**.

## Struttura Helper Class

```php
<?php
declare(strict_types=1);

// Nel file Blade, prima del markup

class EventDetailHelper
{
    public function __construct(
        public ?Event $event = null,
        public mixed $item = null,
        public ?string $container0 = null,
        public ?string $slug0 = null,
    ) {}
    
    public function getEventModel(): ?Event
    {
        $model = $this->event ?? $this->item;
        if ($model === null && !empty($this->slug0)) {
            $model = Event::where('slug', $this->slug0)->first();
        }
        return $model instanceof Event ? $model : null;
    }
    
    public function getEventData(): array
    {
        // Logica di preparazione dati
    }
}

// Inizializzazione
$helper = new EventDetailHelper(
    event: $event instanceof Event ? $event : null,
    item: $item,
    container0: $container0,
    slug0: $slug0,
);

// Uso nelle view
$eventData = $helper->getEventData();
?>
```

## Vantaggi

1. **Organizzazione**: Logica separata dal markup
2. **Testabilità**: La classe può essere testata isolatamente
3. **Reusability**: Stessa logica in contesti diversi
4. **Type Safety**: Proprietà tipizzate

## Pattern Volt Class vs Helper Class

| Scenario | Pattern | Motivazione |
|----------|---------|-------------|
| Pagina Folio completa | Volt Class | Reattività, stato, metodi |
| Componente incluso via `@include()` | Helper Class | No stato Livewire, solo logica |
| Blocco riutilizzabile | Volt Class | Componente indipendente |
| Partial con logica | Helper Class | Compatibilità con `@include()` |

## Aggiungere Interattività

Per componenti con Helper Class che hanno bisogno di interattività:

```blade
<div x-data="{ showModal: false }">
    <button @click="showModal = true">Open</button>
    
    <div x-show="showModal" x-cloak>
        <!-- Modal content -->
    </div>
</div>
```

Per azioni server (booking, etc.):
- Usare `fetch()` API verso endpoint dedicati
- Creare controller API nel tema
- Registrare route nel ThemeServiceProvider

## Esempio Completo

Vedi: `Themes/Meetup/resources/views/components/blocks/events/detail.blade.php`

## Collegamenti

- [Volt Class Pattern](./volt-class-pattern.md)
- [Folio Routing](./folio_routing_system.md)
