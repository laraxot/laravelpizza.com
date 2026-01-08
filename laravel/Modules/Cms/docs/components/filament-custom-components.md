# Componenti Custom in Filament V3

## Introduzione

Questa guida spiega come creare e integrare componenti personalizzati all'interno del pannello Filament V3 del modulo CMS, utilizzando Livewire e TailwindCSS.

## Setup Iniziale

### 1. Creazione del Tema Custom
```bash
php artisan make:filament-theme
```

### 2. Configurazione Vite
Aggiungere il percorso del tema in `vite.config.js`:
```js
export default defineConfig({
    plugins: [
        laravel({
            input: [
                // ... altri file
                'resources/css/filament/admin/theme.css',
            ],
        }),
    ],
});
```

### 3. Registrazione del Tema
Nel provider del pannello (`app/Providers/Filament/AdminPanelProvider.php`):
```php
use Filament\Panel;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->viteTheme('resources/css/filament/admin/theme.css')
            // ... altre configurazioni
    }
}
```

### 4. Configurazione Tailwind
File: `resources/css/filament/admin/tailwind.config.js`
```js
import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './app/Livewire/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './resources/views/livewire/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            // Estensioni del tema
        },
    },
}
```

## Creazione Componenti Custom

### 1. Componenti Livewire Base
```php
namespace App\Livewire;

use Livewire\Component;

class CustomCounter extends Component
{
    public int $count = 0;

    public function increment(): void
    {
        $this->count++;
    }

    public function render(): View
    {
        return view('livewire.custom-counter');
    }
}
```

### 2. Widget Personalizzati
```bash
php artisan make:filament-widget CustomWidget --livewire
```

```php
namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class CustomWidget extends Widget
{
    protected static string $view = 'filament.widgets.custom-widget';
    
    // Opzionale: Configurare il polling
    protected static ?string $pollingInterval = '10s';
    
    // Opzionale: Impostare la larghezza del widget
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';
}
```

### 3. View Components
```php
namespace App\View\Components;

use Illuminate\View\Component;

class CustomAlert extends Component
{
    public function __construct(
        public string $type = 'info',
        public ?string $title = null,
    ) {}

    public function render(): View
    {
        return view('components.custom-alert');
    }
}
```

## Integrazione con il Pannello

### 1. Registrazione Widget
In `AdminPanelProvider.php`:
```php
use App\Filament\Widgets\CustomWidget;

public function panel(Panel $panel): Panel
{
    return $panel
        ->widgets([
            CustomWidget::class,
        ]);
}
```

### 2. Pagine Custom
```php
namespace App\Filament\Pages;

use Filament\Pages\Page;

class CustomDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.custom-dashboard';
    
    protected function getHeaderWidgets(): array
    {
        return [
            CustomWidget::class,
        ];
    }
}
```

## Stili e TailwindCSS

### 1. File Theme Base
```css
/* resources/css/filament/admin/theme.css */
@import '../../../../vendor/filament/filament/resources/css/theme.css';

@config './tailwind.config.js';

/* Stili custom */
@layer components {
    .custom-widget {
        @apply p-4 bg-white rounded-lg shadow;
    }
}
```

### 2. Componenti Stilizzati
```blade
<div class="custom-widget">
    <h2 class="text-lg font-semibold text-gray-900">
        {{ $title }}
    </h2>
    <div class="mt-4">
        {{ $slot }}
    </div>
</div>
```

## Best Practices

### 1. Organizzazione del Codice
```
app/
  ├─ Filament/
  │   ├─ Pages/
  │   ├─ Resources/
  │   └─ Widgets/
  ├─ Livewire/
  │   └─ Components/
  └─ View/
      └─ Components/
```

### 2. Type Safety
```php
declare(strict_types=1);

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Contracts\View\View;

final class CustomWidget extends Widget
{
    protected static string $view = 'filament.widgets.custom-widget';
    
    public function render(): View
    {
        return view(static::$view, [
            'data' => $this->getData(),
        ]);
    }
    
    protected function getData(): array
    {
        return [
            // dati del widget
        ];
    }
}
```

### 3. Riutilizzabilità
```php
trait WithSortable
{
    public bool $sortable = true;
    
    protected function getSortableOptions(): array
    {
        return [
            'animation' => 150,
            'handle' => '.sort-handle',
        ];
    }
}
```

## Testing

### 1. Unit Test
```php
namespace Tests\Unit\Filament\Widgets;

use Tests\TestCase;
use App\Filament\Widgets\CustomWidget;

class CustomWidgetTest extends TestCase
{
    /** @test */
    public function it_renders_correctly(): void
    {
        $widget = new CustomWidget();
        
        $view = $widget->render();
        
        $this->assertStringContainsString('custom-widget', $view->render());
    }
}
```

### 2. Feature Test
```php
namespace Tests\Feature\Filament;

use Tests\TestCase;
use App\Filament\Pages\CustomDashboard;

class CustomDashboardTest extends TestCase
{
    /** @test */
    public function it_can_display_dashboard(): void
    {
        $this->get(CustomDashboard::getUrl())
            ->assertSuccessful()
            ->assertSeeLivewire(CustomWidget::class);
    }
}
```

### 3. Browser Test
```php
namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CustomWidgetTest extends DuskTestCase
{
    /** @test */
    public function it_can_interact_with_widget(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin')
                   ->waitForLivewire()
                   ->assertVisible('@custom-widget')
                   ->click('@widget-action')
                   ->assertSee('Action performed');
        });
    }
}
```

## Troubleshooting

### 1. Problemi di Stile
```bash
# Ricompilare gli assets
npm run build

# In modalità sviluppo
npm run dev
```

### 2. Cache View
```bash
php artisan view:clear
php artisan cache:clear
```

### 3. Livewire Debug
```php
// Abilitare il debug mode in .env
LIVEWIRE_DEV_MODE=true

// Utilizzare ray() per il debug
public function increment(): void
{
    ray()->showQueries();
    $this->count++;
}
```

## Risorse Utili

### Documentation
- [Filament Documentation](https://filamentphp.com/docs)
- [Livewire Documentation](https://livewire.laravel.com)
- [TailwindCSS Documentation](https://tailwindcss.com/docs)

### Community
- [Filament Discord](https://discord.gg/filamentphp)
- [GitHub Issues](https://github.com/filamentphp/filament/issues)
- [Laravel Forums](https://laracasts.com/discuss) 
