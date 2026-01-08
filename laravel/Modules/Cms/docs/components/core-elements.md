# Elementi Core UI

## Introduzione

Gli elementi core sono i componenti fondamentali dell'interfaccia utente del modulo CMS. Questi componenti sono progettati per essere altamente riutilizzabili, accessibili e conformi alle best practice di UI/UX.

## Button

### Utilizzo Base
```php
use Modules\Cms\View\Components\Button;

<x-cms::button>
    Clicca Qui
</x-cms::button>
```

### Varianti
- **Primario**: Azioni principali
- **Secondario**: Azioni secondarie
- **Outline**: Stile bordo
- **Text**: Solo testo

### Proprietà
- `variant`: string - Tipo di bottone (primary, secondary, outline, text)
- `size`: string - Dimensione (sm, md, lg)
- `disabled`: boolean - Stato disabilitato
- `loading`: boolean - Stato di caricamento

## Icon Button

### Utilizzo Base
```php
<x-cms::icon-button icon="user">
    Profilo
</x-cms::icon-button>
```

### Proprietà
- `icon`: string - Nome dell'icona
- `position`: string - Posizione dell'icona (left, right)
- `size`: string - Dimensione (sm, md, lg)

## Rating Bar

### Utilizzo Base
```php
<x-cms::rating-bar
    :value="4"
    :max="5"
/>
```

### Proprietà
- `value`: int - Valore corrente
- `max`: int - Valore massimo
- `readonly`: boolean - Modalità sola lettura
- `size`: string - Dimensione (sm, md, lg)

## Switch

### Utilizzo Base
```php
<x-cms::switch
    wire:model="active"
    label="Stato"
/>
```

### Proprietà
- `label`: string - Etichetta del toggle
- `value`: boolean - Valore corrente
- `disabled`: boolean - Stato disabilitato

## Best Practices

### Accessibilità
1. Utilizzare sempre attributi ARIA appropriati
2. Mantenere il contrasto del colore secondo WCAG
3. Supportare la navigazione da tastiera
4. Fornire feedback visivi e tattili

### Performance
1. Lazy loading per componenti pesanti
2. Ottimizzazione delle transizioni
3. Minimizzare il reflow del DOM
4. Utilizzare cache quando appropriato

### Responsive Design
1. Design mobile-first
2. Breakpoint standard
3. Touch-friendly su dispositivi mobili
4. Layout fluidi

## Personalizzazione

### Tema
```php
// config/cms.php
return [
    'theme' => [
        'button' => [
            'primary' => [
                'bg' => 'bg-primary-600',
                'text' => 'text-white',
                'hover' => 'hover:bg-primary-700',
            ],
        ],
    ],
];
```

### Estensione
```php
// Esempio di estensione di un componente
class CustomButton extends Button
{
    public function render()
    {
        return view('components.custom-button');
    }
}
```

## Testing

### Unit Test
```php
use Tests\TestCase;

class ButtonTest extends TestCase
{
    /** @test */
    public function it_renders_correctly()
    {
        $view = $this->blade(
            '<x-cms::button>Test</x-cms::button>'
        );

        $view->assertSee('Test');
    }
}
```

## Integrazione con Filament

### Form Fields
```php
use Filament\Forms\Components\Actions\Action;

Action::make('submit')
    ->label('Invia')
    ->button()
    ->color('primary')
```

### Table Actions
```php
use Filament\Tables\Actions\Action;

Action::make('edit')
    ->label('Modifica')
    ->icon('heroicon-o-pencil')
    ->button()
```

## Troubleshooting

### Problemi Comuni
1. Stili non applicati correttamente
   - Verificare la configurazione di Tailwind
   - Controllare i conflitti di classe
   
2. Eventi non triggrati
   - Verificare la corretta installazione di Livewire
   - Controllare gli eventi JavaScript

3. Rendering non corretto
   - Pulire la cache delle view
   - Verificare i conflitti di nome 
