---
qmd: "ui troubleshooting md"
title: UI Module — Troubleshooting Guide
module: UI
type: troubleshooting
status: approved
tags: [troubleshooting, errors, solutions, blade, filament, components]
updated: "2026-07-28"
related:
  - ./README.md
  - ./PATTERNS.md
  - ./index.md
---

# UI — Troubleshooting Guide

> Errori comuni, cause radice, e soluzioni nel modulo UI.

## 📋 Indice Problemi

1. [Blade Components](#blade-components)
2. [Filament Widgets & Forms](#filament-widgets--forms)
3. [TableLayoutEnum](#tablelayoutenum)
4. [Charts & Visualization](#charts--visualization)
5. [Asset & Styling](#asset--styling)
6. [Testing](#testing)

---

## Blade Components

### Errore: "View [x-ui::ui.component-name] not found"

**Sintomi**:
- Component utilizza `x-ui::ui.component-name`
- Laravel ritorna: "View not found"
- Admin dashboard non carica

**Cause Comuni**:
1. Component view manca in `resources/views/components/`
2. Namespace registration sbagliato
3. Cache stale

**Soluzione**:

```bash
# 1. Verifica file view esiste
ls laravel/Modules/UI/resources/views/components/

# 2. Verifica registrazione in ServiceProvider
# app/Providers/ViewServiceProvider.php
\Illuminate\Support\Facades\Blade::componentNamespace(
    'Modules\\UI\\View\\Components',
    'ui'
);

# 3. Crea component se manca
# laravel/Modules/UI/resources/views/components/my-component.blade.php
<div {{ $attributes }}>
    {{ $slot }}
</div>

# 4. Clear cache
php artisan view:clear
php artisan config:clear

# 5. Test nel tinker
php artisan tinker --execute="
view('ui::components.my-component');
"
```

**Prevenzione**:
- Testa component rendering dopo creation
- Audit ServiceProvider registration
- Monitor view cache

---

### Errore: "Unknown slot: header"

**Sintomi**:
```
LogicException: Unknown slot "header"
```

Template usa slot che non è definito nel componente.

**Cause Comuni**:
1. Component non dichiara slot
2. Typo nel nome slot
3. Versione Blade incompatibile

**Soluzione**:

```blade
<!-- ✅ CORRETTO: Dichiara slot -->
<!-- resources/views/components/card.blade.php -->
<div class="card">
  <div class="card-header">
    {{ $header ?? 'Default Header' }}
  </div>
  <div class="card-body">
    {{ $slot }}
  </div>
  @if (isset($footer))
  <div class="card-footer">
    {{ $footer }}
  </div>
  @endif
</div>

<!-- Utilizzo -->
<x-ui::ui.card>
  <x-slot name="header">
    Titolo Card
  </x-slot>
  Contenuto...
  <x-slot name="footer">
    Footer text
  </x-slot>
</x-ui::ui.card>

<!-- ❌ SBAGLIATO: Slot non dichiarato -->
<!-- resources/views/components/card.blade.php -->
<div class="card">
  {{ $slot }}
</div>
```

**Prevenzione**:
- Documenta slot in PHPDoc
- Test component con Pest
- Verifica Blade version

---

### Errore: "Component properties not accessible in view"

**Sintomi**:
- Componente riceve `@prop` ma view non accede
- Variable undefined nel template

**Cause Comuni**:
1. Manca `@props()` dichiarazione
2. Typo nel nome property
3. Type casting non matching

**Soluzione**:

```blade
<!-- ✅ CORRETTO: Dichiara @props -->
<!-- resources/views/components/button.blade.php -->
@props([
    'label' => 'Click me',
    'color' => 'primary',
    'size' => 'md',
    'disabled' => false,
])

<button class="btn btn-{{ $color }} btn-{{ $size }}" 
    @if ($disabled) disabled @endif>
  {{ $label }}
</button>

<!-- ❌ SBAGLIATO: Manca @props -->
<!-- resources/views/components/button.blade.php -->
<button class="btn">
  {{ $label }} <!-- Undefined variable -->
</button>
```

**Prevenzione**:
- Usa strict types in component class
- PHPDoc su tutti i @props
- Test component in isolation

---

## Filament Widgets & Forms

### Errore: "Widget not rendering in dashboard"

**Sintomi**:
- Widget estende `Filament\Widgets\Widget`
- Admin dashboard non mostra widget
- No error in log

**Cause Comuni**:
1. Widget non registrato nel admin panel config
2. `getDefaultName()` ritorna null
3. Cache stale

**Soluzione**:

```php
// 1. Verifica registrazione nel panel
// app/Providers/Filament/AdminPanelProvider.php
public function panel(Panel $panel): Panel {
    return $panel
        ->widgets([
            \Modules\UI\Filament\Widgets\StatsOverviewWidget::class,
            \Modules\UI\Filament\Widgets\CalendarWidget::class,
        ]);
}

// 2. Implementa getDefaultName()
class StatsOverviewWidget extends Widget {
    protected static ?string $heading = null; // Load from translation
    
    public function getDefaultName(): ?string {
        return 'stats_overview'; // Unique identifier
    }
}

// 3. Clear cache
php artisan config:clear
php artisan cache:clear
php artisan filament:cache-components

// 4. Test rendering
php artisan tinker --execute="
use Filament\Facades\Filament;
\$widgets = Filament::getPanel('admin')->getWidgets();
dd(\$widgets);
"
```

**Prevenzione**:
- Registrazione esplicita nel AdminPanelProvider
- Test widget isolation in feature test
- Monitor dashboard load time

---

### Errore: "Form field validation failing silently"

**Sintomi**:
- Form submit non funziona
- No validation error message
- Network request success 200

**Cause Comuni**:
1. Custom field manca implementazione validation
2. Field type non matching database
3. Authorization policy blocking update

**Soluzione**:

```php
// ✅ CORRETTO: Completo validation
class StudioCardSelectorField extends Field {
    protected string $view = 'ui::filament.fields.studio-card-selector';
    
    public function configure(): void {
        parent::configure();
        
        $this->required() // Default validation
             ->rules([
                 'required',
                 'integer',
                 'exists:studio,id', // FK validation
             ]);
    }
    
    public function dehydrate(): mixed {
        $value = parent::dehydrate();
        
        // Custom validation
        if (!Studio::find($value)) {
            $this->addError('Studio not found');
        }
        
        return $value;
    }
}

// 2. Verifica policy authorization
// Modules/UI/Policies/WidgetPolicy.php
class WidgetPolicy {
    public function update(User $user, Model $model): bool {
        return $user->is_admin || $user->id === $model->created_by;
    }
}

// 3. Debug form submission
// Browser DevTools Network → Form POST → Response (verify errors)

// 4. Check Laravel log
tail -f storage/logs/laravel.log
```

**Prevenzione**:
- Implementare validation su custom fields
- Test form submission in feature test
- Monitor browser console per errors

---

## TableLayoutEnum

### Errore: "Call to undefined method on TableLayoutEnum"

**Sintomi**:
```
TypeError: Call to undefined method TableLayoutEnum::fromString()
```

**Cause Comuni**:
1. Enum method doesn't exist (typo)
2. Enum non è di tipo BackedEnum
3. Versione PHP < 8.1

**Soluzione**:

```php
// ✅ CORRETTO: BackedEnum for value handling
namespace Modules\UI\Enums;

enum TableLayoutEnum: string {
    case LIST = 'list';
    case GRID = 'grid';
    
    // Helper methods
    public static function fromString(string $value): ?self {
        return self::tryFrom($value);
    }
    
    public function label(): string {
        return match($this) {
            self::LIST => 'List View',
            self::GRID => 'Grid View',
        };
    }
}

// Utilizzo
$layout = TableLayoutEnum::LIST;
$layoutString = $layout->value; // 'list'
$parsed = TableLayoutEnum::tryFrom('list'); // LIST

// ❌ SBAGLIATO: Metodo inesistente
$layout = TableLayoutEnum::fromString('list'); // Not a real method on basic Enum
```

**Prevenzione**:
- Testa enum methods in unit test
- PHPStan verifica enum usage
- Documentation per helper methods

---

### Errore: "Cannot persist TableLayoutEnum to session"

**Sintomi**:
```
Exception: Cannot serialize TableLayoutEnum
```

**Cause Comuni**:
1. Session serialization non supporta Enum
2. Storing enum directly in session
3. Cache key inconsistency

**Soluzione**:

```php
// ✅ CORRETTO: Store enum value, not instance
class ToggleTableLayoutAction extends Action {
    public function execute(Request $request): void {
        // Store value, not enum instance
        $layout = TableLayoutEnum::LIST->value; // 'list'
        $request->session()->put('table_layout', $layout);
        
        // Retrieve e convert back
        $storedValue = $request->session()->get('table_layout', 'list');
        $layout = TableLayoutEnum::tryFrom($storedValue);
    }
}

// ❌ SBAGLIATO: Storing enum instance
$request->session()->put('table_layout', TableLayoutEnum::LIST); // Serialization fail
```

**Prevenzione**:
- Always store enum value, not instance
- Test session persistence
- Use typed properties with casting

---

## Charts & Visualization

### Errore: "ChartJS data labels not displaying"

**Sintomi**:
- Chart renders ma data labels mancano
- ChartJS plugin non loaded
- Console warning: "Plugin not found"

**Cause Comuni**:
1. Plugin datalabels non installato
2. Plugin option configuration sbagliato
3. Chart data format incompatibile

**Soluzione**:

```bash
# 1. Installa plugin
npm install chartjs-plugin-datalabels
npm run build

# 2. Registra plugin in Filament config
# app/Providers/ChartServiceProvider.php
use ChartJs\ChartJs;
use Modules\UI\Plugins\DataLabelsPlugin;

public function boot() {
    ChartJs::addPlugin(new DataLabelsPlugin());
}

# 3. Configura nel chart widget
```

```php
// ✅ CORRETTO: Plugin options
class RevenueChartWidget extends ChartWidget {
    protected function getData(): array {
        return [
            'labels' => ['Jan', 'Feb', 'Mar'],
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => [100, 200, 150],
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                ],
            ],
        ];
    }
    
    protected function getOptions(): array {
        return [
            'plugins' => [
                'datalabels' => [
                    'display' => true,
                    'color' => '#000',
                    'font' => [
                        'weight' => 'bold',
                    ],
                    'formatter' => 'function(value) { return value.toFixed(0); }',
                ],
                'legend' => [
                    'display' => true,
                ],
            ],
        ];
    }
}
```

**Prevenzione**:
- Test chart rendering in browser
- Verify data format matches ChartJS spec
- Monitor console for plugin errors

---

### Errore: "Chart timeout on shared hosting"

**Sintomi**:
- Chart rendering slow (>3s)
- Shared hosting CPU limit exceeded
- Client-side timeout

**Causa Comunemente**:
1. Large dataset (1000+ points)
2. Unnecessary animation
3. Memory pressure

**Soluzione**:

```php
// ✅ CORRETTO: Optimized for shared hosting
protected function getData(): array {
    // Limit data points
    $data = $this->getChartData()->take(100); // Max 100 points
    
    return [
        'labels' => $data->pluck('label'),
        'datasets' => [
            [
                'label' => 'Trend',
                'data' => $data->pluck('value'),
                'tension' => 0, // Disable curve animation
                'borderWidth' => 1,
            ],
        ],
    ];
}

protected function getOptions(): array {
    return [
        'animation' => [
            'duration' => 0, // Disable animation
        ],
        'plugins' => [
            'datalabels' => [
                'display' => false, // Disable labels on shared hosting
            ],
        ],
        'maintainAspectRatio' => true,
        'responsive' => true,
    ];
}
```

**Prevenzione**:
- Profila chart performance locally
- Test on shared hosting environment
- Monitor response time in production

---

## Asset & Styling

### Errore: "Tailwind classes not compiling"

**Sintomi**:
- Classes written (`class="bg-blue-600"`) but not rendered
- CSS file not updated after `npm run build`
- Browser shows unstyled component

**Cause Comuni**:
1. `npm run build` not executed
2. Tailwind config not scanning UI module paths
3. CSS import not in main stylesheet

**Soluzione**:

```bash
# 1. Esegui Tailwind build
npm run build

# 2. Verifica tailwind.config.js scans UI module
# tailwind.config.js
module.exports = {
  content: [
    './laravel/Modules/UI/resources/views/**/*.blade.php',
    './laravel/Modules/UI/app/**/*.php',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

# 3. Verifica CSS imported in app layout
# resources/views/layout.blade.php
<link rel="stylesheet" href="{{ asset('css/app.css') }}">

# 4. Clear browser cache (Cmd+Shift+R)

# 5. Rebuild e verify
npm run build
```

**Prevenzione**:
- Run build on every Blade change during development
- Use `npm run dev` for hot reload
- Verify in production build pipeline

---

### Errore: "Inline styles persist despite Tailwind rules"

**Sintomi**:
- Tailwind class aplicato ma inline style wins (specificity)
- Component styling inconsistent

**Causa Comunemente**:
1. Inline style has higher specificity than Tailwind
2. `!important` used incorrectly

**Soluzione**:

```blade
<!-- ❌ SBAGLIATO: Inline style wins -->
<div class="text-gray-600" style="color: red;">
  Text
</div>

<!-- ✅ CORRETTO: Use Tailwind only -->
<div class="text-red-600">
  Text
</div>

<!-- If must override, use !important (rare) -->
<div class="text-red-600 !bg-white">
  Text
</div>
```

**Prevenzione**:
- Audit codebase for inline styles: `rg 'style="'`
- Enforce Tailwind-only rule in code review
- Use Tailwind utilities for all styling

---

## Testing

### Errore: "Component not rendering in Pest test"

**Sintomi**:
```
AssertionError: Component x-ui::ui.button did not render
```

**Cause Comuni**:
1. Component view not registered in test environment
2. Factory or seeder incomplete
3. Test service provider config missing

**Soluzione**:

```php
// ✅ CORRETTO: Feature test with component
use function Pest\Livewire\livewire;

it('renders button component', function () {
    $response = $this->get('/page-with-button');
    $response->assertSee('button'); // Check in HTML
    $response->assertComponentMissing('ui::ui.button-not-exists');
});

// Test component in isolation
it('renders card component with slot', function () {
    $view = view('ui::components.card', [
        'header' => 'Test Header',
    ])->render();
    
    expect($view)
        ->toContain('Test Header')
        ->toContain('card'); // Check for classes
});

// ❌ SBAGLIATO: Component not available in test
// Manca component registration in TestCase
```

**Prevenzione**:
- Run `php artisan test` before commit
- Test component rendering in isolation
- Monitor test coverage for UI components

---

### Errore: "Form field not validating in test"

**Sintomi**:
```
AssertionError: Validation passed but should fail
```

**Cause Comuni**:
1. Validation rules not defined in test context
2. Request factory incomplete
3. Authorization bypass

**Soluzione**:

```php
// ✅ CORRETTO: Complete form validation test
it('validates studio selector required', function () {
    $form = \Modules\UI\Filament\Forms\MyForm::make()
        ->schema([
            StudioCardSelectorField::make('studio_id')
                ->required(),
        ]);
    
    $data = ['studio_id' => null];
    $errors = $form->validate(); // Get validation errors
    
    expect($errors)->toHaveKey('studio_id');
});

// Test form submission
it('fails on invalid studio', function () {
    $this->post('/api/form-submit', [
        'studio_id' => 99999, // Non-existent
    ])->assertInvalid('studio_id');
});

// ❌ SBAGLIATO: Manca validation setup
$form->validate($data); // No rules defined
```

**Prevenzione**:
- Testa validazione rules in isolation
- Use factory to create valid related data
- Monitor test output for validation errors

---

## 📞 Quando Escalare

Se il troubleshooting non risolve:

1. **Check Laravel log**:
   ```bash
   tail -f storage/logs/laravel.log | grep -i ui
   ```

2. **PHPStan full scan**:
   ```bash
   ./vendor/bin/phpstan analyse Modules/UI --level=max
   ```

3. **Browser DevTools**:
   - Network tab: Verify API responses
   - Console: Check JavaScript errors
   - Elements: Inspect rendered HTML

4. **Database sanity**:
   ```sql
   SELECT COUNT(*) FROM studio;
   SHOW COLUMNS FROM studio;
   ```

5. **Consulta documentation**:
   - [INDEX](./index.md) — Complete file listing
   - [PATTERNS](patterns.md) — Architectural decisions
   - [architecture/component-registration](./architecture/component-registration.md) — Component setup

---

## 📖 Riferimenti Correlati

- [README](./README.md) — Overview modulo
- [PATTERNS](patterns.md) — Decisioni architetturali
- [INDEX](./index.md) — Indice documentazione completo
- [standards/ui-standards](./standards/ui-standards.md) — Component standards
