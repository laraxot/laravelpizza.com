# Switch

Il componente Switch è un'alternativa elegante ai checkbox tradizionali, ideale per attivare/disattivare funzionalità o impostazioni.

## Utilizzo Base

```blade
<x-filament::toggle
    wire:model="isActive"
    label="Stato"
/>
```

## Varianti

### Con Etichette On/Off
```blade
<x-filament::toggle
    wire:model="isActive"
    onIcon="heroicon-s-check"
    offIcon="heroicon-s-x"
    label="Stato"
/>
```

### Dimensioni
```blade
<!-- Small -->
<x-filament::toggle
    wire:model="isActive"
    size="sm"
/>

<!-- Medium (default) -->
<x-filament::toggle
    wire:model="isActive"
/>

<!-- Large -->
<x-filament::toggle
    wire:model="isActive"
    size="lg"
/>
```

### Colori Personalizzati
```blade
<x-filament::toggle
    wire:model="isActive"
    onColor="success"
    offColor="danger"
/>
```

## Props/Configurazione

| Prop | Tipo | Default | Descrizione |
|------|------|---------|-------------|
| `wire:model` | string | null | Binding Livewire |
| `label` | string | null | Etichetta dello switch |
| `size` | string | 'md' | Dimensione (sm, md, lg) |
| `onColor` | string | 'primary' | Colore stato attivo |
| `offColor` | string | 'gray' | Colore stato inattivo |
| `onIcon` | string | null | Icona stato attivo |
| `offIcon` | string | null | Icona stato inattivo |
| `disabled` | boolean | false | Stato disabilitato |

## Best Practices

1. **Accessibilità**
   - Fornire etichette descrittive
   - Implementare ARIA roles
   - Supportare navigazione da tastiera

2. **UX/UI**
   - Fornire feedback visivo immediato
   - Usare colori significativi
   - Mantenere consistenza nel design

3. **Implementazione**
   - Gestire stati di caricamento
   - Validare cambiamenti lato server
   - Implementare fallback appropriati

## Esempi

### Impostazioni Toggle
```blade
<div class="space-y-4">
    <x-filament::toggle
        wire:model="settings.notifications"
        label="Notifiche Push"
        helperText="Ricevi notifiche in tempo reale"
    />

    <x-filament::toggle
        wire:model="settings.darkMode"
        label="Modalità Scura"
        onIcon="heroicon-s-moon"
        offIcon="heroicon-s-sun"
    />

    <x-filament::toggle
        wire:model="settings.maintenance"
        label="Modalità Manutenzione"
        onColor="danger"
        helperText="Il sito sarà visibile solo agli amministratori"
    />
</div>
```

### Toggle con Loading State
```blade
<div
    wire:loading.class="opacity-50"
    wire:target="updateStatus"
>
    <x-filament::toggle
        wire:model="isActive"
        wire:loading.attr="disabled"
        label="Stato"
        helperText="Cambia lo stato dell'elemento"
    />
</div>
```

### Toggle Group
```blade
<div class="space-y-4">
    @foreach($permissions as $permission)
        <x-filament::toggle
            wire:model="selectedPermissions.{{ $permission->id }}"
            :label="$permission->name"
            :helper-text="$permission->description"
        />
    @endforeach
</div>
```

## Note sulla Performance

1. **Ottimizzazione Rendering**
   - Minimizzare re-render non necessari
   - Implementare debounce per cambiamenti frequenti
   - Utilizzare memo per valori computati

2. **Gestione Eventi**
   - Ottimizzare gestione eventi touch/mouse
   - Implementare throttling quando necessario
   - Gestire memory leaks

3. **Accessibilità e SEO**
   - Utilizzare markup semantico
   - Implementare keyboard navigation
   - Mantenere supporto per screen reader

4. **Animazioni**
   - Utilizzare CSS transforms
   - Implementare animazioni performanti
   - Considerare `prefers-reduced-motion`

## Integrazione con Form

### In Form Schema
```php
use Filament\Forms\Components\Toggle;

public static function form(Form $form): Form
{
    return $form->schema([
        Toggle::make('is_active')
            ->label('Stato')
            ->helperText('Attiva o disattiva l\'elemento')
            ->required(),
            
        Toggle::make('send_notifications')
            ->label('Notifiche')
            ->helperText('Invia notifiche email')
            ->default(true),
    ]);
}
```

### In Livewire Component
```php
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;

class SettingsManager extends Component implements HasForms
{
    use InteractsWithForms;

    public $settings = [
        'notifications' => true,
        'darkMode' => false,
    ];

    protected function getFormSchema(): array
    {
        return [
            Toggle::make('settings.notifications')
                ->label('Notifiche')
                ->reactive()
                ->afterStateUpdated(function ($state) {
                    $this->updateNotificationSettings($state);
                }),

            Toggle::make('settings.darkMode')
                ->label('Modalità Scura')
                ->reactive()
                ->afterStateUpdated(function ($state) {
                    $this->updateTheme($state);
                }),
        ];
    }
} 
