# 🎨 THEMES SYSTEM - IL VESTITO DI LARAXOT

## 📋 INDICE
1. [Filosofia Themes](#-filosofia-themes)
2. [Architettura Theme](#-architettura-theme)
3. **Tema Zero: Il Template Perfetto**
4. [Customizzazione Avanzata](#-customizzazione-avanzata)
5. [Asset Management](#-asset-management)
6. [Future Enhancements](#-future-enhancements)

---

## 🧠 FILOSOFIA THEMES (The Theme Philosophy)

### **Principio Fondamentale: Il Tema è un "Vestito", non la "Pelle"**
I temi in Laraxot seguono una filosofia radicale:
- **I temi forniscono SOLO presentazione visiva**
- **La logica business rimane SEMPRE nei moduli**
- **Nessuna dipendenza business nei temi**
- **Zero accoppiamento tra UI e business logic**

### **Separazione Sacra: Presentation vs Business**
```php
// ❌ ERESIA: Logica business nel tema
// themes/zero/app/Services/SurveyService.php  // MAI!

// ✅ FEDE: Solo presentazione nel tema
// themes/zero/resources/views/components/survey-card.blade.php
<div class="bg-white rounded-lg shadow-md p-6">
    <h3>{{ $survey->title }}</h3>
    <p>{{ $survey->description }}</p>
    <!-- SOLO presentazione, nessuna logica -->
</div>
```

---

## 🏗️ ARCHITETTURA THEME (Theme Architecture)

### **1. Structure Sacra: Zero Dependencies**
```
Themes/
├── Zero/                           # Tema principale
│   ├── theme.json                 # Configurazione tema
│   ├── resources/                 # SOLO assets e views
│   │   ├── views/                 # Blade templates
│   │   ├── css/                   # Stili Tailwind
│   │   ├── js/                    # JavaScript vanilla
│   │   └── img/                   # Immagini e icone
│   ├── public/                    # Assets pubblici
│   ├── lang/                      # Traduzioni tema
│   └── package.json               # Dipendenze frontend
```

### **2. Theme Configuration: Centralizzata e Type-Safe**
```json
// themes/Zero/theme.json
{
    "name": "Zero",
    "type": "pub",
    "description": "Zero Theme - Minimalismo Elegante",
    "version": "1.0.0",
    "active": true,
    "order": 0,
    "dependencies": {
        "laravel": "^12.0",
        "filament": "^4.0",
        "tailwindcss": "^3.0"
    },
    "features": {
        "dark_mode": true,
        "rtl_support": true,
        "responsive": true,
        "accessibility": true
    },
    "assets": {
        "css": ["resources/css/app.css"],
        "js": ["resources/js/app.js"],
        "images": ["resources/img/"]
    }
}
```

### **3. Theme Provider: Il Ponte con Laravel**
```php
<?php

declare(strict_types=1);

namespace Themes\Zero\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

/**
 * ZeroThemeProvider: Collega il tema a Laravel
 * 
 * Fornisce:
 * - Registrazione componenti Blade
 * - Configurazione view paths
 * - Asset publishing
 * - Helper functions tema-specifiche
 */
class ZeroThemeProvider extends ServiceProvider
{
    public function register(): void
    {
        // Merge configurazione tema
        $this->mergeConfigFrom(
            $this->themePath('config/theme.php'),
            'theme'
        );
    }

    public function boot(): void
    {
        // Registrazione view paths
        $this->loadViewsFrom($this->themePath('resources/views'), 'zero');
        
        // Registrazione componenti Blade
        $this->registerBladeComponents();
        
        // Publishing assets
        $this->publishes([
            $this->themePath('resources/css') => public_path('css/zero'),
            $this->themePath('resources/js') => public_path('js/zero'),
            $this->themePath('resources/img') => public_path('img/zero'),
        ], ['zero-assets']);

        // Registrazione direttive Blade
        $this->registerBladeDirectives();
    }

    private function registerBladeComponents(): void
    {
        // Componenti UI base
        Blade::component('zero::card', Card::class);
        Blade::component('zero::button', Button::class);
        Blade::component('zero::modal', Modal::class);
        Blade::component('zero::form', Form::class);
        
        // Componenti business (SOLO presentazione)
        Blade::component('zero::survey-card', SurveyCard::class);
        Blade::component('zero::question-chart', QuestionChart::class);
        Blade::component('zero::customer-profile', CustomerProfile::class);
    }

    private function registerBladeDirectives(): void
    {
        // Direttive helper per tema
        Blade::directive('themeAsset', function ($asset) {
            return "<?php echo theme_asset({$asset}); ?>";
        });

        Blade::directive('themeStyle', function ($style) {
            return "<?php echo theme_style({$style}); ?>";
        });
    }

    private function themePath(string $path): string
    {
        return __DIR__ . '/../../' . $path;
    }
}
```

---

## 🎯 TEMA ZERO: IL TEMPLATE PERFETTO

### **1. Component System: Riutilizzabilità Massima**
```php
<?php

declare(strict_types=1);

namespace Themes\Zero\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

/**
 * Card: Componente card riutilizzabile
 * 
 * Fornisce:
 * - Layout card consistente
 * - Varianti styling (primary, secondary, etc.)
 * - Responsive design
 * - Accessibility features
 */
class Card extends Component
{
    public string $variant;
    public bool $shadow;
    public bool $bordered;
    public string $padding;

    public function __construct(
        string $variant = 'default',
        bool $shadow = true,
        bool $bordered = false,
        string $padding = 'normal'
    ) {
        $this->variant = $variant;
        $this->shadow = $shadow;
        $this->bordered = $bordered;
        $this->padding = $padding;
    }

    public function render(): View
    {
        return view('zero::components.card');
    }

    /**
     * Classi CSS calcolate dinamicamente
     */
    public function cardClasses(): string
    {
        $classes = [
            'bg-white',
            'rounded-lg',
        ];

        // Variant styling
        $classes[] = match($this->variant) {
            'primary' => 'border-2 border-blue-500',
            'secondary' => 'border-2 border-gray-300',
            'success' => 'border-2 border-green-500',
            'danger' => 'border-2 border-red-500',
            default => 'border border-gray-200',
        };

        // Shadow
        if ($this->shadow) {
            $classes[] = 'shadow-md';
        }

        // Padding
        $classes[] = match($this->padding) {
            'tight' => 'p-4',
            'normal' => 'p-6',
            'loose' => 'p-8',
            default => 'p-6',
        };

        return implode(' ', $classes);
    }
}
```

### **2. Business Components: Solo Presentazione**
```php
<?php

declare(strict_types=1);

namespace Themes\Zero\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Modules\healthcare_app\Models\SurveyPdf;

/**
 * SurveyCard: Visualizzazione survey card
 * 
 * NOTA: Solo presentazione, nessuna logica business
 * La logica sta nei moduli healthcare_app
 */
class SurveyCard extends Component
{
    public SurveyPdf $survey;
    public bool $showStats;
    public bool $showActions;

    public function __construct(
        SurveyPdf $survey,
        bool $showStats = true,
        bool $showActions = true
    ) {
        $this->survey = $survey;
        $this->showStats = $showStats;
        $this->showActions = $showActions;
    }

    public function render(): View
    {
        return view('zero::components.survey-card');
    }

    /**
     * Badge di status con styling appropriato
     */
    public function statusBadge(): array
    {
        return match($this->survey->status->value) {
            'active' => [
                'class' => 'bg-green-100 text-green-800',
                'text' => 'Attivo',
            ],
            'draft' => [
                'class' => 'bg-gray-100 text-gray-800',
                'text' => 'Bozza',
            ],
            'expired' => [
                'class' => 'bg-red-100 text-red-800',
                'text' => 'Scaduto',
            ],
            default => [
                'class' => 'bg-gray-100 text-gray-800',
                'text' => $this->survey->status->value,
            ],
        };
    }

    /**
     * Formattazione data leggibile
     */
    public function formattedDate(): string
    {
        return $this->survey->created_at->format('d/m/Y H:i');
    }

    /**
     * Completion rate con styling
     */
    public function completionRateClass(): string
    {
        $rate = $this->survey->getCompletionRate();
        
        return match(true) {
            $rate >= 80 => 'text-green-600',
            $rate >= 60 => 'text-yellow-600',
            default => 'text-red-600',
        };
    }
}
```

### **3. Blade Template: Separazione Totale**
```blade
{{!-- themes/Zero/resources/views/components/survey-card.blade.php --}}
<div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
    <!-- Header -->
    <div class="flex justify-between items-start mb-4">
        <div>
            <h3 class="text-lg font-semibold text-gray-900">
                {{ $survey->title }}
            </h3>
            <p class="text-sm text-gray-600 mt-1">
                {{ $survey->description }}
            </p>
        </div>
        
        <!-- Status Badge -->
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->statusBadge()['class'] }}">
            {{ $this->statusBadge()['text'] }}
        </span>
    </div>

    <!-- Statistics (se richieste) -->
    @if($showStats)
        <div class="grid grid-cols-3 gap-4 mb-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-gray-900">
                    {{ $survey->contacts()->count() }}
                </div>
                <div class="text-xs text-gray-500">Contatti</div>
            </div>
            
            <div class="text-center">
                <div class="text-2xl font-bold {{ $this->completionRateClass() }}">
                    {{ $survey->getCompletionRate() }}%
                </div>
                <div class="text-xs text-gray-500">Completamento</div>
            </div>
            
            <div class="text-center">
                <div class="text-2xl font-bold text-gray-900">
                    {{ $survey->questionCharts()->count() }}
                </div>
                <div class="text-xs text-gray-500">Chart</div>
            </div>
        </div>
    @endif

    <!-- Actions (se richieste) -->
    @if($showActions)
        <div class="flex justify-end space-x-2">
            <a href="{{ route('filament.healthcare_app::admin.resources.survey-pdfs.view', ['record' => $survey->id]) }}" 
               class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Visualizza
            </a>
            
            <a href="{{ route('filament.healthcare_app::admin.resources.survey-pdfs.edit', ['record' => $survey->id]) }}" 
               class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Modifica
            </a>
        </div>
    @endif

    <!-- Footer -->
    <div class="mt-4 pt-4 border-t border-gray-200">
        <div class="flex justify-between items-center text-xs text-gray-500">
            <span>Cliente: {{ $survey->customer->name }}</span>
            <span>Creato: {{ $this->formattedDate() }}</span>
        </div>
    </div>
</div>
```

---

## 🎨 CUSTOMIZZAZIONE AVANZATA (Advanced Customization)

### **1. Theme Configuration System**
```php
<?php

declare(strict_types=1);

namespace Themes\Zero\Services;

/**
 * ThemeConfiguration: Gestione configurazioni tema
 */
class ThemeConfiguration
{
    private array $config;

    public function __construct()
    {
        $this->config = $this->loadThemeConfig();
    }

    public function getColor(string $name): string
    {
        return $this->config['colors'][$name] ?? '#000000';
    }

    public function getSpacing(string $size): string
    {
        return $this->config['spacing'][$size] ?? '1rem';
    }

    public function getTypography(string $type): array
    {
        return $this->config['typography'][$type] ?? [];
    }

    public function getBreakpoint(string $name): string
    {
        return $this->config['breakpoints'][$name] ?? '1024px';
    }

    private function loadThemeConfig(): array
    {
        return [
            'colors' => [
                'primary' => '#3B82F6',
                'secondary' => '#6B7280',
                'success' => '#10B981',
                'danger' => '#EF4444',
                'warning' => '#F59E0B',
                'info' => '#06B6D4',
            ],
            'spacing' => [
                'xs' => '0.25rem',
                'sm' => '0.5rem',
                'md' => '1rem',
                'lg' => '1.5rem',
                'xl' => '2rem',
            ],
            'typography' => [
                'heading' => [
                    'font-family' => 'Inter, sans-serif',
                    'font-weight' => '700',
                    'line-height' => '1.2',
                ],
                'body' => [
                    'font-family' => 'Inter, sans-serif',
                    'font-weight' => '400',
                    'line-height' => '1.5',
                ],
            ],
            'breakpoints' => [
                'sm' => '640px',
                'md' => '768px',
                'lg' => '1024px',
                'xl' => '1280px',
                '2xl' => '1536px',
            ],
        ];
    }
}
```

### **2. Dynamic CSS Generation**
```php
<?php

declare(strict_types=1);

namespace Themes\Zero\Services;

/**
 * CssGenerator: Generazione CSS dinamica
 */
class CssGenerator
{
    private ThemeConfiguration $config;

    public function __construct(ThemeConfiguration $config)
    {
        $this->config = $config;
    }

    public function generateCustomProperties(): string
    {
        $css = ':root {' . PHP_EOL;

        // Colors
        foreach ($this->config->getAllColors() as $name => $value) {
            $css .= "  --color-{$name}: {$value};" . PHP_EOL;
        }

        // Spacing
        foreach ($this->config->getAllSpacing() as $name => $value) {
            $css .= "  --spacing-{$name}: {$value};" . PHP_EOL;
        }

        // Typography
        foreach ($this->config->getAllTypography() as $type => $props) {
            foreach ($props as $prop => $value) {
                $css .= "  --font-{$type}-{$prop}: {$value};" . PHP_EOL;
            }
        }

        $css .= '}' . PHP_EOL;

        return $css;
    }

    public function generateUtilityClasses(): string
    {
        return '
        /* Custom Utility Classes */
        .bg-primary { background-color: var(--color-primary); }
        .bg-secondary { background-color: var(--color-secondary); }
        .text-primary { color: var(--color-primary); }
        .text-secondary { color: var(--color-secondary); }
        
        /* Custom Spacing */
        .p-theme { padding: var(--spacing-md); }
        .m-theme { margin: var(--spacing-md); }
        
        /* Custom Typography */
        .font-theme-heading { 
            font-family: var(--font-heading-font-family);
            font-weight: var(--font-heading-font-weight);
            line-height: var(--font-heading-line-height);
        }
        ';
    }
}
```

### **3. Theme Variants System**
```php
<?php

declare(strict_types=1);

namespace Themes\Zero\Enums;

/**
 * ThemeVariant: Varianti tema disponibili
 */
enum ThemeVariant: string
{
    case DEFAULT = 'default';
    case DARK = 'dark';
    case HIGH_CONTRAST = 'high-contrast';
    case RTL = 'rtl';
    case COMPACT = 'compact';

    public function getLabel(): string
    {
        return match($this) {
            self::DEFAULT => 'Default',
            self::DARK => 'Dark Mode',
            self::HIGH_CONTRAST => 'High Contrast',
            self::RTL => 'Right-to-Left',
            self::COMPACT => 'Compact',
        };
    }

    public function getCssClass(): string
    {
        return match($this) {
            self::DEFAULT => '',
            self::DARK => 'dark-theme',
            self::HIGH_CONTRAST => 'high-contrast-theme',
            self::RTL => 'rtl-theme',
            self::COMPACT => 'compact-theme',
        };
    }

    public function getCustomProperties(): array
    {
        return match($this) {
            self::DARK => [
                '--bg-primary' => '#1F2937',
                '--text-primary' => '#F9FAFB',
                '--border-color' => '#374151',
            ],
            self::HIGH_CONTRAST => [
                '--bg-primary' => '#FFFFFF',
                '--text-primary' => '#000000',
                '--border-color' => '#000000',
            ],
            default => [],
        };
    }
}
```

---

## 📦 ASSET MANAGEMENT (Asset Management)

### **1. Vite Configuration: Build System Moderno**
```javascript
// themes/Zero/vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    
    resolve: {
        alias: {
            '@': '/resources/js',
            '@css': '/resources/css',
            '@img': '/resources/img',
        },
    },
    
    build: {
        outDir: 'public/build/zero',
        emptyOutDir: true,
        manifest: true,
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['alpinejs', '@headlessui/vue'],
                    charts: ['chart.js', 'apexcharts'],
                },
            },
        },
    },
    
    css: {
        postcss: {
            plugins: [
                require('tailwindcss'),
                require('autoprefixer'),
            ],
        },
    },
});
```

### **2. Tailwind Configuration: Design System**
```javascript
// themes/Zero/tailwind.config.js
import themeConfig from './config/theme.json';

export default {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './resources/js/**/*.vue',
        '../../Modules/*/resources/views/**/*.blade.php',
    ],
    
    theme: {
        extend: {
            colors: {
                primary: themeConfig.colors.primary,
                secondary: themeConfig.colors.secondary,
                // ... altri colori
            },
            
            fontFamily: {
                sans: ['Inter', 'system-ui', 'sans-serif'],
                mono: ['JetBrains Mono', 'monospace'],
            },
            
            spacing: {
                '18': '4.5rem',
                '88': '22rem',
                '128': '32rem',
            },
            
            animation: {
                'fade-in': 'fadeIn 0.5s ease-in-out',
                'slide-up': 'slideUp 0.3s ease-out',
                'bounce-light': 'bounceLight 1s infinite',
            },
            
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { transform: 'translateY(10px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
                bounceLight: {
                    '0%, 100%': { transform: 'translateY(-5%)' },
                    '50%': { transform: 'translateY(0)' },
                },
            },
        },
    },
    
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
        
        // Plugin custom per componenti
        function({ addComponents, theme }) {
            addComponents({
                '.btn': {
                    padding: `${theme('spacing.2')} ${theme('spacing.4')}`,
                    borderRadius: theme('borderRadius.md'),
                    fontWeight: theme('fontWeight.medium'),
                    transition: 'all 0.2s ease-in-out',
                    
                    '&:hover': {
                        transform: 'translateY(-1px)',
                        boxShadow: theme('boxShadow.md'),
                    },
                },
                
                '.card': {
                    backgroundColor: theme('colors.white'),
                    borderRadius: theme('borderRadius.lg'),
                    padding: theme('spacing.6'),
                    boxShadow: theme('boxShadow.sm'),
                    
                    '&:hover': {
                        boxShadow: theme('boxShadow.md'),
                    },
                },
            });
        },
    ],
};
```

### **3. JavaScript Architecture: Componenti Modulari**
```javascript
// themes/Zero/resources/js/app.js
import './components';
import './charts';
import './forms';
import './notifications';

// Core functionality
import Alpine from 'alpinejs';
window.Alpine = Alpine;

// Theme utilities
window.theme = {
    current: 'default',
    setVariant(variant) {
        document.documentElement.className = variant.getCssClass();
        this.current = variant.value;
        localStorage.setItem('theme-variant', variant.value);
    },
    
    getVariant() {
        return localStorage.getItem('theme-variant') || 'default';
    },
    
    toggleDarkMode() {
        const isDark = document.documentElement.classList.contains('dark');
        if (isDark) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme-dark', 'false');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme-dark', 'true');
        }
    },
};

// Initialize theme
document.addEventListener('alpine:init', () => {
    const savedVariant = theme.getVariant();
    if (savedVariant !== 'default') {
        theme.setVariant(ThemeVariant.from(savedVariant));
    }
    
    if (localStorage.getItem('theme-dark') === 'true') {
        document.documentElement.classList.add('dark');
    }
});

Alpine.start();
```

### **4. Component System: Riutilizzabilità Frontend**
```javascript
// themes/Zero/resources/js/components/modal.js
export class Modal {
    constructor(element) {
        this.element = element;
        this.isOpen = false;
        this.init();
    }
    
    init() {
        // Event listeners
        this.element.addEventListener('click', (e) => {
            if (e.target.dataset.action === 'open') {
                this.open();
            } else if (e.target.dataset.action === 'close') {
                this.close();
            }
        });
        
        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen) {
                this.close();
            }
        });
    }
    
    open() {
        this.isOpen = true;
        this.element.classList.add('modal-open');
        this.element.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        
        // Focus management
        const focusableElements = this.element.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );
        if (focusableElements.length > 0) {
            focusableElements[0].focus();
        }
    }
    
    close() {
        this.isOpen = false;
        this.element.classList.remove('modal-open');
        this.element.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }
}

// Auto-initialization
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-component="modal"]').forEach(element => {
        new Modal(element);
    });
});
```

---

## 🚀 FUTURE ENHANCEMENTS (Future Enhancements)

### **1. Theme Builder Interface**
```php
<?php

declare(strict_types=1);

namespace Themes\Zero\Services;

/**
 * ThemeBuilder: Interfaccia per customizzazione tema live
 */
class ThemeBuilder
{
    public function generateThemePreview(array $customizations): array
    {
        return [
            'css' => $this->generateCustomCss($customizations),
            'preview' => $this->generatePreviewHtml($customizations),
            'config' => $this->generateThemeConfig($customizations),
        ];
    }
    
    public function exportTheme(array $customizations): string
    {
        $themeData = [
            'name' => $customizations['name'],
            'version' => '1.0.0',
            'customizations' => $customizations,
            'assets' => $this->compileAssets($customizations),
        ];
        
        return json_encode($themeData, JSON_PRETTY_PRINT);
    }
    
    public function importTheme(string $themeJson): bool
    {
        $themeData = json_decode($themeJson, true);
        
        if (!$this->validateThemeData($themeData)) {
            throw new InvalidArgumentException('Invalid theme data');
        }
        
        return $this->applyCustomizations($themeData['customizations']);
    }
}
```

### **2. Component Library System**
```php
<?php

declare(strict_types=1);

namespace Themes\Zero\Services;

/**
 * ComponentLibrary: Gestione library componenti
 */
class ComponentLibrary
{
    private array $components = [];
    
    public function registerComponent(string $name, array $config): void
    {
        $this->components[$name] = $config;
    }
    
    public function getComponent(string $name): ?array
    {
        return $this->components[$name] ?? null;
    }
    
    public function generateComponentDocumentation(): array
    {
        $docs = [];
        
        foreach ($this->components as $name => $config) {
            $docs[$name] = [
                'name' => $name,
                'description' => $config['description'],
                'props' => $config['props'] ?? [],
                'slots' => $config['slots'] ?? [],
                'examples' => $config['examples'] ?? [],
                'category' => $config['category'] ?? 'general',
            ];
        }
        
        return $docs;
    }
}
```

### **3. Advanced Animation System**
```javascript
// themes/Zero/resources/js/animations/gsap-integration.js
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

export class AnimationController {
    constructor() {
        this.animations = new Map();
        this.init();
    }
    
    init() {
        this.setupScrollAnimations();
        this.setupHoverAnimations();
        this.setupPageTransitions();
    }
    
    setupScrollAnimations() {
        // Fade in animations on scroll
        gsap.utils.toArray('.fade-in-up').forEach(element => {
            gsap.fromTo(element, 
                {
                    y: 50,
                    opacity: 0,
                },
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    scrollTrigger: {
                        trigger: element,
                        start: 'top 80%',
                        end: 'bottom 20%',
                        toggleActions: 'play none none reverse',
                    },
                }
            );
        });
    }
    
    setupHoverAnimations() {
        // Button hover effects
        document.querySelectorAll('.btn-animate').forEach(button => {
            button.addEventListener('mouseenter', () => {
                gsap.to(button, {
                    scale: 1.05,
                    duration: 0.2,
                    ease: 'power2.out',
                });
            });
            
            button.addEventListener('mouseleave', () => {
                gsap.to(button, {
                    scale: 1,
                    duration: 0.2,
                    ease: 'power2.out',
                });
            });
        });
    }
    
    setupPageTransitions() {
        // Smooth page transitions
        document.querySelectorAll('a[href]').forEach(link => {
            link.addEventListener('click', (e) => {
                if (link.hostname === window.location.hostname) {
                    e.preventDefault();
                    this.transitionToPage(link.href);
                }
            });
        });
    }
    
    transitionToPage(url) {
        gsap.to('body', {
            opacity: 0,
            duration: 0.3,
            onComplete: () => {
                window.location.href = url;
            },
        });
    }
}
```

---

## 📊 THEME MONITORING

### **1. Performance Monitoring**
```php
<?php

declare(strict_types=1);

namespace Themes\Zero\Services;

/**
 * ThemePerformance: Monitoraggio performance tema
 */
class ThemePerformance
{
    public function trackAssetLoading(): array
    {
        return [
            'css_load_time' => $this->measureCssLoadTime(),
            'js_load_time' => $this->measureJsLoadTime(),
            'image_load_time' => $this->measureImageLoadTime(),
            'total_load_time' => $this->measureTotalLoadTime(),
        ];
    }
    
    public function trackComponentUsage(): array
    {
        // Traccia quali componenti sono più usati
        return [
            'most_used_components' => $this->getMostUsedComponents(),
            'least_used_components' => $this->getLeastUsedComponents(),
            'component_render_times' => $this->getComponentRenderTimes(),
        ];
    }
    
    public function generatePerformanceReport(): array
    {
        return [
            'asset_performance' => $this->trackAssetLoading(),
            'component_usage' => $this->trackComponentUsage(),
            'browser_compatibility' => $this->checkBrowserCompatibility(),
            'accessibility_score' => $this->calculateAccessibilityScore(),
        ];
    }
}
```

---

## 🏆 CONCLUSIONE: THEMES è IL VESTITO

Il sistema themes di Laraxot segue una filosofia radicale:
- **Separazione Totale**: Presentazione vs Business
- **Zero Dependencies**: I temi non dipendono dalla logica
- **Massima Flessibilità**: Customizzazione senza limiti
- **Performance First**: Asset ottimizzati e monitoring
- **Accessibility First**: Design accessibile by design

**In Laraxot, i temi vestono il business, non lo definiscono.**

---

*Documentazione Themes System v1.0*
*Creato: 2025-11-17*
*Autore: AI Assistant con analisi approfondita*