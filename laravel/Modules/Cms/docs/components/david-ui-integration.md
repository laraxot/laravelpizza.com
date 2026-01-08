# Integrazione David UI

## Introduzione

David UI è una libreria di componenti Tailwind CSS che è stata integrata nel modulo CMS di il progetto. Questa documentazione descrive come utilizzare al meglio i componenti David UI all'interno del nostro sistema.

## Setup e Configurazione

### Installazione
```bash
npm install @david-ui/react @david-ui/tailwind
```

### Configurazione Tailwind
```js
// tailwind.config.js
module.exports = {
    content: [
        './resources/**/*.blade.php',
        './Modules/**/Resources/views/**/*.blade.php',
        './node_modules/@david-ui/**/*.js',
    ],
    theme: {
        extend: {
            // estensioni del tema
        },
    },
    plugins: [
        require('@david-ui/tailwind'),
    ],
}
```

## Wrapper Components

Per mantenere la coerenza e facilitare gli aggiornamenti futuri, abbiamo creato wrapper per i componenti David UI.

### Button Wrapper
```php
namespace Modules\Cms\View\Components;

class Button extends Component
{
    public function __construct(
        public string $variant = 'primary',
        public string $size = 'md',
        public bool $disabled = false,
        public bool $loading = false,
    ) {}

    public function render(): View
    {
        return view('cms::components.button', [
            'variant' => $this->variant,
            'size' => $this->size,
            'disabled' => $this->disabled,
            'loading' => $this->loading,
        ]);
    }
}
```

### Alert Wrapper
```php
namespace Modules\Cms\View\Components;

class Alert extends Component
{
    public function __construct(
        public string $type = 'info',
        public bool $dismissible = false,
        public ?string $icon = null,
        public ?int $timeout = null,
    ) {}

    public function render(): View
    {
        return view('cms::components.alert');
    }
}
```

## Estensioni Custom

Abbiamo esteso alcuni componenti David UI per aggiungere funzionalità specifiche per il progetto.

### Custom Card
```php
namespace Modules\Cms\View\Components;

class Card extends Component
{
    public function __construct(
        public bool $collapsible = false,
        public bool $bordered = true,
        public ?string $headerClass = null,
        public ?string $bodyClass = null,
    ) {}

    public function render(): View
    {
        return view('cms::components.card');
    }

    public function shouldRenderHeader(): bool
    {
        return $this->header || $this->collapsible;
    }
}
```

## Integrazione con Filament

### Resource Cards
```php
use Filament\Resources\Resource;
use Modules\Cms\View\Components\Card;

class UserResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->collapsible()
                    ->schema([
                        // form fields
                    ]),
            ]);
    }
}
```

### Table Actions
```php
use Filament\Tables\Actions\Action;
use Modules\Cms\View\Components\Button;

public static function table(Table $table): Table
{
    return $table
        ->actions([
            Action::make('edit')
                ->button()
                ->color('primary')
                ->icon('heroicon-o-pencil'),
        ]);
}
```

## Best Practices

### 1. Naming Conventions
```php
// Componenti
Components/
  ├─ Button/
  │   ├─ Button.php
  │   └─ button.blade.php
  └─ Alert/
      ├─ Alert.php
      └─ alert.blade.php
```

### 2. Type Safety
```php
declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\View\View;
use Illuminate\View\Component;

final class Button extends Component
{
    public function __construct(
        public readonly string $variant,
        public readonly string $size,
    ) {}
}
```

### 3. Validation
```php
protected function validateProps(): void
{
    if (!in_array($this->variant, ['primary', 'secondary', 'outline', 'text'])) {
        throw new InvalidArgumentException(
            "Invalid variant [{$this->variant}]. Available variants are: primary, secondary, outline, text"
        );
    }
}
```

## Testing

### Unit Tests
```php
namespace Tests\Unit\Components;

use Tests\TestCase;
use Modules\Cms\View\Components\Button;

class ButtonTest extends TestCase
{
    /** @test */
    public function it_renders_with_correct_variant(): void
    {
        $button = new Button('primary', 'md');
        
        $view = $button->render();
        
        $this->assertStringContainsString('bg-primary-600', $view->render());
    }
}
```

### Feature Tests
```php
/** @test */
public function it_handles_click_events(): void
{
    Livewire::test(ButtonComponent::class)
        ->call('click')
        ->assertEmitted('button::clicked');
}
```

## Troubleshooting

### Problemi Comuni

1. **Stili non applicati**
   ```bash
   # Ricompilare gli assets
   npm run dev
   
   # Pulire la cache
   php artisan view:clear
   php artisan cache:clear
   ```

2. **Conflitti JavaScript**
   ```js
   // Assicurarsi che Alpine.js sia caricato prima
   import Alpine from 'alpinejs';
   window.Alpine = Alpine;
   Alpine.start();
   
   // Poi inizializzare David UI
   import { initDavidUI } from '@david-ui/core';
   initDavidUI();
   ```

3. **Problemi di Performance**
   ```php
   // Utilizzare lazy loading per componenti pesanti
   <div wire:init="loadComponent">
       @if($isLoaded)
           <x-cms::heavy-component />
       @endif
   </div>
   ```

## Migrazione e Aggiornamenti

### Da v1 a v2
```diff
- <x-david-button>
+ <x-cms::button>
    Click Me
- </x-david-button>
+ </x-cms::button>

- <x-david-alert type="success">
+ <x-cms::alert
+     type="success"
+     :timeout="5000"
+ >
    Success!
- </x-david-alert>
+ </x-cms::alert>
```

## Risorse Utili

### Documentation
- [David UI Documentation](https://www.creative-tim.com/david-ui/docs/)
- [Tailwind CSS](https://tailwindcss.com/docs)
- [Alpine.js](https://alpinejs.dev/docs)

### Community
- [Discord Server](https://discord.gg/davidui)
- [GitHub Issues](https://github.com/creative-tim/david-ui/issues)
- [Stack Overflow](https://stackoverflow.com/questions/tagged/david-ui) 
