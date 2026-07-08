# Layouts e Temi UI

## Layout System

### Grid System
```blade
{{-- Grid base a 12 colonne --}}
<x-ui::grid cols="12">
    <x-ui::col span="4">Sidebar</x-ui::col>
    <x-ui::col span="8">Content</x-ui::col>
</x-ui::grid>

{{-- Grid responsive --}}
<x-ui::grid cols="1" sm="2" md="3" lg="4">
    <x-ui::col>Item 1</x-ui::col>
    <x-ui::col>Item 2</x-ui::col>
</x-ui::grid>

{{-- Grid con gap --}}
<x-ui::grid cols="3" gap="4">
    <x-ui::col>Card 1</x-ui::col>
    <x-ui::col>Card 2</x-ui::col>
</x-ui::grid>
```

### Container
```blade
{{-- Container standard --}}
<x-ui::container>
    <x-ui::content>
        <!-- Contenuto principale -->
    </x-ui::content>
</x-ui::container>

{{-- Container fluid --}}
<x-ui::container fluid>
    <!-- Contenuto full-width -->
</x-ui::container>

{{-- Container con padding personalizzato --}}
<x-ui::container class="px-4 py-8">
    <!-- Contenuto con padding -->
</x-ui::container>
```

### Layouts Predefiniti

#### AdminLayout
```php
use Modules\UI\Layouts\AdminLayout;

class Dashboard extends Component
{
    protected static string $layout = AdminLayout::class;
    
    protected function getLayoutData(): array
    {
        return [
            'title' => 'Dashboard',
            'breadcrumbs' => [
                'Home' => route('home'),
                'Dashboard' => null
            ],
            'menu' => [
                [
                    'label' => 'Portafoglio',
                    'icon' => 'heroicon-o-briefcase',
                    'items' => [
                        [
                            'label' => 'Polizze',
                            'route' => 'polizze.index'
                        ]
                    ]
                ]
            ]
        ];
    }
}
```

#### PrintLayout 
```php
use Modules\UI\Layouts\PrintLayout;

class StampaPratica extends Component
{
    protected static string $layout = PrintLayout::class;
    
    protected function getLayoutData(): array
    {
        return [
            'title' => 'Pratica #123',
            'orientation' => 'portrait',
            'pageSize' => 'a4',
            'margins' => [
                'top' => 20,
                'right' => 15,
                'bottom' => 20,
                'left' => 15
            ],
            'header' => view('header'),
            'footer' => view('footer')
        ];
    }
}
```

## Sistema dei Temi

### Configurazione
```php
// config/ui.php
return [
    'theme' => [
        // Colori principali
        'colors' => [
            'primary' => [
                50 => '#f0fdf4',
                100 => '#dcfce7',
                500 => '#22c55e',
                700 => '#15803d',
                900 => '#14532d',
            ],
            'secondary' => [
                500 => '#3b82f6',
            ],
            'success' => '#22c55e',
            'warning' => '#f59e0b',
            'danger' => '#ef4444',
        ],
        
        // Tipografia
        'typography' => [
            'fonts' => [
                'base' => 'Inter var',
                'mono' => 'JetBrains Mono',
            ],
            'sizes' => [
                'base' => '1rem',
                'lg' => '1.125rem',
                'xl' => '1.25rem',
            ],
        ],
        
        // Spaziature
        'spacing' => [
            'base' => '1rem',
            'lg' => '1.5rem',
            'xl' => '2rem',
        ],
        
        // Bordi
        'border' => [
            'radius' => '0.375rem',
            'width' => '1px',
        ],
        
        // Ombre
        'shadows' => [
            'sm' => '0 1px 2px 0 rgb(0 0 0 / 0.05)',
            'md' => '0 4px 6px -1px rgb(0 0 0 / 0.1)',
            'lg' => '0 10px 15px -3px rgb(0 0 0 / 0.1)',
        ],
    ],
];
```

### Personalizzazione Tema

#### Override CSS
```css
/* resources/css/theme.css */
:root {
    --color-primary-500: #22c55e;
    --font-family-base: 'Inter var';
    --spacing-base: 1rem;
}

.dark {
    --color-primary-500: #4ade80;
}
```

#### Estensione Tailwind
```js
// tailwind.config.js
module.exports = {
    theme: {
        extend: {
            colors: {
                primary: {
                    50: 'var(--color-primary-50)',
                    500: 'var(--color-primary-500)',
                    900: 'var(--color-primary-900)',
                },
            },
            fontFamily: {
                sans: ['var(--font-family-base)'],
                mono: ['var(--font-family-mono)'],
            },
            spacing: {
                base: 'var(--spacing-base)',
            },
        },
    },
};
```

### Dark Mode
```php
// Attivazione dark mode
AdminLayout::make()
    ->darkMode(true)
    ->darkModeToggle(true);

// Stili condizionali
<div class="bg-white dark:bg-gray-800">
    <h1 class="text-gray-900 dark:text-white">
        Titolo
    </h1>
</div>
```

### Responsive Design
```blade
{{-- Breakpoints standard --}}
<div class="hidden sm:block md:hidden lg:block">
    <!-- Visibile su small e large, nascosto su medium -->
</div>

{{-- Layout responsive --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
    <!-- Grid responsive -->
</div>

{{-- Tipografia responsive --}}
<h1 class="text-xl md:text-2xl lg:text-3xl">
    <!-- Titolo responsive -->
</h1>
```

### Best Practices

1. **Consistenza**
   - Utilizzare le variabili del tema
   - Mantenere una palette colori coerente
   - Seguire le scale tipografiche

2. **Accessibilità**
   - Garantire contrasto sufficiente
   - Supportare dark mode
   - Testare con screen reader

3. **Performance**
   - Ottimizzare assets
   - Utilizzare lazy loading
   - Minimizzare CSS

4. **Manutenibilità**
   - Documentare personalizzazioni
   - Seguire convenzioni di naming
   - Centralizzare configurazioni 