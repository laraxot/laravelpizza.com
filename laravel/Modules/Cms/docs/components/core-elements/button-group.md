# Button Group

I button group sono componenti essenziali per organizzare azioni correlate in modo efficiente. Questo componente, costruito con Tailwind CSS, supporta vari layout, dimensioni e stili, rendendolo perfetto per barre degli strumenti o controlli segmentati.

## Varianti Base

### Button Group Standard
```html
<div class="inline-flex rounded-md shadow-sm" role="group">
  <button type="button" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-l-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700">
    Profilo
  </button>
  <button type="button" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700">
    Impostazioni
  </button>
  <button type="button" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-r-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700">
    Messaggi
  </button>
</div>
```

## Dimensioni

Sono disponibili diverse dimensioni per adattarsi alle diverse esigenze di design:

- **Small**: Aggiungere classi `px-3 py-1.5 text-sm`
- **Default**: Utilizzare classi `px-4 py-2`
- **Large**: Applicare classi `px-5 py-2.5 text-lg`

## Varianti di Colore

### Primary
```html
<div class="inline-flex rounded-md shadow-sm" role="group">
  <button type="button" class="px-4 py-2 text-sm font-medium text-white bg-blue-700 border border-blue-800 rounded-l-lg hover:bg-blue-800 focus:z-10 focus:ring-2 focus:ring-blue-700">
    Azione 1
  </button>
  <!-- ... altri bottoni ... -->
</div>
```

### Secondary, Success, Danger
Sostituire le classi di colore appropriatamente:
- Secondary: `bg-gray-500 hover:bg-gray-600`
- Success: `bg-green-600 hover:bg-green-700`
- Danger: `bg-red-600 hover:bg-red-700`

## Button Group con Icone

Per aggiungere icone ai button group:

```html
<div class="inline-flex rounded-md shadow-sm" role="group">
  <button type="button" class="inline-flex items-center px-4 py-2">
    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
      <!-- ... path dell'icona ... -->
    </svg>
    Testo
  </button>
</div>
```

## Button Group a Livello di Blocco

Per creare un button group che occupa l'intera larghezza del contenitore:

```html
<div class="flex w-full rounded-md shadow-sm" role="group">
  <!-- ... bottoni ... -->
</div>
```

## Button Group Arrotondati (Pill)

Per ottenere un effetto "pill":

```html
<div class="inline-flex rounded-full shadow-sm" role="group">
  <button type="button" class="rounded-l-full">
    <!-- ... contenuto ... -->
  </button>
  <button type="button" class="rounded-r-full">
    <!-- ... contenuto ... -->
  </button>
</div>
```

## Best Practices

1. **Accessibilità**:
   - Utilizzare sempre l'attributo `role="group"`
   - Aggiungere `aria-label` per descrivere il gruppo
   - Mantenere un contrasto adeguato tra testo e sfondo

2. **Responsive Design**:
   - Considerare l'utilizzo di `flex-wrap` per schermi piccoli
   - Adattare le dimensioni dei padding per diverse viewport
   - Utilizzare classi responsive di Tailwind (es. `sm:`, `md:`, `lg:`)

3. **Interattività**:
   - Fornire feedback visivo chiaro sugli stati hover/focus
   - Mantenere la consistenza negli stati attivi
   - Utilizzare transizioni smooth per i cambiamenti di stato

## Esempi di Implementazione

### Form Actions
```html
<div class="inline-flex rounded-md shadow-sm" role="group">
  <button type="submit" class="px-4 py-2 text-white bg-green-600 rounded-l-lg">
    Salva
  </button>
  <button type="button" class="px-4 py-2 text-white bg-red-600 rounded-r-lg">
    Annulla
  </button>
</div>
```

### Navigation Tabs
```html
<div class="inline-flex rounded-md shadow-sm" role="group">
  <button type="button" class="px-4 py-2 bg-white border-b-2 border-blue-700">
    Tab 1
  </button>
  <button type="button" class="px-4 py-2 bg-white border-b-2 border-transparent hover:border-blue-700">
    Tab 2
  </button>
</div>
```

## Integrazione con Filament

Per utilizzare i button group in Filament Forms:

```php
use Filament\Forms\Components\Actions\ActionGroup;

ActionGroup::make([
    Action::make('save')
        ->label('Salva')
        ->color('success')
        ->action(fn () => $this->save()),
    Action::make('delete')
        ->label('Elimina')
        ->color('danger')
        ->action(fn () => $this->delete()),
])
```

## Note sulla Performance

- Utilizzare `@apply` in CSS per riutilizzare stili comuni
- Considerare l'uso di `purge-css` per rimuovere stili non utilizzati
- Implementare lazy loading per icone SVG grandi o complesse

## Compatibilità Browser

Il componente è testato e funzionante su:
- Chrome 80+
- Firefox 75+
- Safari 13+
- Edge 80+

## Implementazione in il progetto

### Filament Action Group
Per implementare un gruppo di azioni in Filament, utilizzare la classe `ActionGroup`:

```php
use Modules\Job\Filament\Columns\ActionGroup;

class ActionGroup extends ActionsActionGroup
{
    use InteractsWithRecord;

    public const ICON_BUTTON_VIEW = 'job::components.action-group';
    protected string $view = 'job::components.action-group';

    public function getActions(): array
    {
        return [];
    }
}
```

### Button Group con Radio
Per creare un gruppo di bottoni toggle-style:

```blade
<div class="btn-group btn-group-toggle">
    <x-filament-forms::field-wrapper.label class="btn btn-danger">
        <input type="radio" wire:model="value" name="options" value="-1" />
        <span>-</span>
    </x-filament-forms::field-wrapper.label>
    <x-filament-forms::field-wrapper.label class="btn btn-secondary">
        <input type="radio" wire:model="value" name="options" value="0" />
        <span>&nbsp;</span>
    </x-filament-forms::field-wrapper.label>
    <x-filament-forms::field-wrapper.label class="btn btn-primary">
        <input type="radio" wire:model="value" name="options" value="1" />
        <span>+</span>
    </x-filament-forms::field-wrapper.label>
</div>
```

### Icon Button Group
Per bottoni con icone, utilizzare il componente `icon-button`:

```blade
<x-job::icon-button 
    :attributes="\Filament\Support\prepare_inherited_attributes($attributes)" 
    :dark-mode="config('tables.dark_mode')"
>
    {{ $slot }}
</x-job::icon-button>
```

### Allineamento dei Button Group

Per gestire l'allineamento dei button group, utilizzare le classi Tailwind appropriate:

```blade
<div class="flex items-center mt-3">
    <!-- Allineamento a sinistra -->
    <button :class="{ 'bg-zinc-200' : alignment == 'left' }" 
            class="p-2 rounded-l-md border border-zinc-200 text-zinc-600">
        <x-heroicon-o-bars-3-bottom-left class="w-5 h-5" />
    </button>
    
    <!-- Allineamento al centro -->
    <button :class="{ 'bg-zinc-200' : alignment == 'center' }" 
            class="p-2 border border-r-0 border-l-0 border-zinc-200 text-zinc-600">
        <x-heroicon-o-bars-3 class="w-5 h-5" />
    </button>
    
    <!-- Allineamento a destra -->
    <button :class="{ 'bg-zinc-200' : alignment == 'right' }" 
            class="p-2 rounded-r-md border border-zinc-200 text-zinc-600">
        <x-heroicon-o-bars-3-bottom-right class="w-5 h-5" />
    </button>
</div>
```

### Stili Avanzati

Per migliorare l'aspetto visivo dei button group, è possibile utilizzare questi stili CSS:

```css
.filament-button {
    transition: all 0.2s ease-in-out;
}

.filament-button:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.filament-button:active {
    transform: translateY(0);
}
```

### Social Login Buttons

Per implementare un gruppo di bottoni per il social login:

```blade
<div class="grid @if (count($providers) > 1) grid-cols-2 @endif gap-4">
    @foreach ($providers as $key => $provider)
        <x-filament::button 
            class="mt-3" 
            color="gray" 
            :icon="$provider['icon'] ?? null" 
            tag="a" 
            :href="route('socialite.oauth.redirect', $key)"
        >
            {{ $provider['label'] }}
        </x-filament::button>
    @endforeach
</div>
``` 