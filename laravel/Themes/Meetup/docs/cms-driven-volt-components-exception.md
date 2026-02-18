# Eccezione per Volt Inline nei Componenti CMS-Driven

## Regola Critica: Filament Widgets vs Volt Inline

Come regola generale, nel progetto LaravelPizza **non usiamo Livewire direttamente** - **usiamo solo Filament Widgets** per interattività server-side. Tuttavia, esiste un'importante eccezione a questa regola.

## Eccezione: Volt Inline nei Componenti CMS-Driven

**Volt inline è permesso quando attivato dai file JSON usando la chiave `livewire` nel sistema CMS-driven.**

### Pattern Completamente Approvato

La regola completa è:

1. **Per interattività server-side (form, azioni, ecc.)** → USARE SEMPRE Filament Widgets estendendo `XotBaseWidget`
2. **Per componenti UI semplici attivati dal sistema CMS (quando il file JSON contiene la chiave `livewire`)** → è permesso Volt inline con la sintassi class anonima
3. **Per organizzazione codice logica statica** → usare Helper Class PHP

### Come Funziona il Sistema CMS-Driven

Il sistema CMS tramite il componente `BlockData` riconosce la chiave `livewire` nei file JSON e attiva il rendering con `@livewire` invece di `@include`.

**Esempio di funzionamento:**

Quando un file JSON contiene:
```json
{
    "view": "meetup::blocks.events.detail",
    "livewire": "volt::blocks.events.detail"
}
```

Il sistema CMS attiva il componente Volt tramite:
```blade
@if($useLivewire) 
    @livewire($merged['livewire'], $merged) 
@else 
    @include($block->view, $merged) 
@endif
```

### Esempio di Componente Volt Inline Approvato

File: `laravel/Themes/Meetup/resources/views/livewire/blocks/events/detail.blade.php`

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Volt\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Meetup\Models\Event;

new class extends Component {
    public ?string $container0 = null;
    public ?string $slug0 = null;
    public $event = null;
    public $item = null;
    public $eventModel = null;

    public function mount(): void
    {
        $model = $this->event ?? $this->item;
        if ($model === null && $this->slug0 !== null && $this->slug0 !== '') {
            $model = Event::where('slug', $this->slug0)->first();
        }
        $this->eventModel = $model;
    }

    #[Computed]
    public function eventData(): array
    {
        // Logica di formattazione dati
    }
    
    #[Computed]
    public function eventsUrl(): string
    {
        return LaravelLocalization::localizeUrl('/events');
    }

    #[Computed]
    public function badgeClass(): string
    {
        return $this->eventData['status'] === 'upcoming' ? 'bg-green-600' : 'bg-slate-500';
    }
}; ?>
```

### Quando Usare Ciascun Approccio

- **Filament Widgets** → Quando hai bisogno di interattività server-side come form, dropdown interattivi, modali, azioni
- **Volt Inline (con chiave `livewire`)** → Quando hai componenti UI semplici che devono essere attivati dal sistema CMS
- **Helper Class PHP** → Quando hai solo logica statica da organizzare senza interattività

### Sicurezza e Best Practice

Questo approccio è sicuro perché:
- Il componente Volt è attivato solo quando specificato nel file JSON tramite la chiave `livewire`
- Il sistema CMS controlla rigorosamente quando attivare il componente
- La logica è contenuta in un contesto specifico del sistema CMS
- Non c'è uso diretto di componenti Livewire senza il layer di sicurezza del sistema CMS

### Riferimenti

- `Modules/Cms/docs/data/blockdata.md` - Documentazione del sistema CMS
- `Themes/Meetup/docs/filament-widgets-not-livewire-critical-rule.md` - Regola generale
- `Modules/Meetup/docs/filament-widgets-not-livewire-critical-rule.md` - Regola generale per il modulo