---
qmd: "ui patterns md"
title: UI Module — Architettura e Patterns
module: UI
type: patterns
status: approved
tags: [architecture, patterns, decisions, anti-patterns, blade, filament, components]
updated: "2026-07-28"
related:
  - ./README.md
<<<<<<< HEAD
<<<<<<< .merge_file_GZmyIV
<<<<<<< HEAD
  - ./index.md
=======
  - ./INDEX.md

- ./index.md
>>>>>>> laraxot/dev
=======
  - ./INDEX.md

- ./index.md
=======
  - ./index.md
=======
<<<<<<< HEAD
  - ./INDEX.md

- ./index.md
=======
  - ./index.md
>>>>>>> laraxot/dev
>>>>>>> .merge_file_jiu3dL
>>>>>>> laraxot/dev
  - ./TROUBLESHOOTING.md
---

# UI — Decisioni Architetturali e Patterns

> **Scopo**: Raccogliere decisioni architetturali, workflow core, e anti-pattern da evitare nel modulo UI.

## 🎯 Decisioni Architetturali Fondamentali

### 1. Blade Components con Prefisso x-ui::ui.

**Decisione**: Tutti i Blade components devono usare il prefisso `x-ui::ui.` per distinguerli da componenti Filament e package third-party.

**Motivo**:
- Evita collisioni di naming con Filament native components
- Rende evidente l'origine del componente (UI module)
- Facilita namespace organization e discovery

**Implementazione**:

```blade
<!-- ✅ CORRETTO: Prefisso x-ui::ui. -->
<x-ui::ui.button :label="'Submit'" color="primary" />
<x-ui::ui.card>
  <x-slot name="header">Titolo</x-slot>
  Contenuto...
</x-ui::ui.card>

<!-- ❌ SBAGLIATO: Nessun prefisso (collisione) -->
<x-button label="Submit" />
```

**Validazione**:
- Grep per `<x-` (non `<x-ui::ui.`) nel codebase
- Verificare registrazione in `ServiceProvider`
- Screenshot UI per visual confirmation

### 2. Filament Integration: No Hardcoded Labels

**Decisione**: Tutti i labels di navigazione, form, e UI vengono caricati da translation files, mai hardcoded in classi.

**Motivo**:
- Consente multilingua automatico (IT/EN)
- Centralizza labels (single source of truth)
- Facilita refactoring globale

**Implementazione**:

```php
// ✅ CORRETTO: Labels da translation
namespace Modules\UI\Filament\Widgets;

class StatsOverviewWidget extends Widget {
    protected static ?string $heading = null; // Loads from lang file
    // lang/it/widgets.php:
    // 'stats_overview' => ['heading' => 'Panoramica Statistiche']
}

// ❌ SBAGLIATO: Hardcoded
class StatsOverviewWidget extends Widget {
    protected static ?string $heading = 'Panoramica Statistiche';
}
```

**Validazione**:
- Verifica file traduzione IT/EN completezza
- Test UI switching language (hard refresh browser)
- PHPStan compliance

### 3. TableLayoutEnum per Type-Safe Layout Toggle

**Decisione**: Utilizzo di Enum per state management del layout (LIST vs GRID) invece di string magic values.

**Motivo**:
- Type safety a compile-time
- Autocomplete IDE
- Evita typo-related bugs

**Implementazione**:

```php
// ✅ CORRETTO: Enum type-safe
use Modules\UI\Enums\TableLayoutEnum;

class ToggleTableLayoutAction extends Action {
    public function execute(TableLayoutEnum $layout): void {
        if ($layout === TableLayoutEnum::LIST) {
            // Render as list
        } else if ($layout === TableLayoutEnum::GRID) {
            // Render as grid
        }
    }
}

// ❌ SBAGLIATO: String magic values
public function execute(string $layout): void {
    if ($layout === 'list') { } // Prone to typos
}
```

**Validazione**:
- PHPStan verifica type hints
- Test enum switching behavior
- Screenshot sia LIST che GRID layout

### 4. Asset Management: Tailwind Compilation Required

**Decisione**: Tutti gli stili CSS compilati via Tailwind, no inline styles in Blade templates.

**Motivo**:
- Ottimizzazione file size (tree-shaking)
- Consistency across UI
- Separazione concerns (style vs markup)

**Implementazione**:

```blade
<!-- ✅ CORRETTO: Tailwind utilities -->
<div class="bg-blue-600 p-4 rounded-lg shadow-md text-white">
  <p class="text-lg font-semibold">Titolo</p>
</div>

<!-- ❌ SBAGLIATO: Inline styles -->
<div style="background-color: #2563eb; padding: 16px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); color: white;">
  <p style="font-size: 18px; font-weight: 600;">Titolo</p>
</div>
```

**Validazione**:
- Audit resources/css/ per custom rules
- Verifica npm run build prima di deploy
- Lighthouse performance score

### 5. Custom Form Fields: Filament Integration Pattern

**Decisione**: Custom form field components (AddressField, FileUpload, etc.) estendono Filament\Forms\Components\Field e registrati via plugin auto-discovery.

**Motivo**:
- Reusability across Filament resources
- Coesistenza con native Filament fields
- Lazy loading via module service provider

**Implementazione**:

```php
// ✅ CORRETTO: Estensione Filament field
namespace Modules\UI\Filament\Fields;

use Filament\Forms\Components\Field;

class AddressField extends Field {
    protected string $view = 'ui::filament.fields.address';
    
    public function getDefaultName(): ?string {
        return 'address_field';
    }
}

// Registration via UIServiceProvider
class UIServiceProvider extends ServiceProvider {
    public function boot() {
        Form::macro('addressField', function() {
            return AddressField::make('address');
        });
    }
}

// ❌ SBAGLIATO: Custom class senza ereditarietà
class AddressField {
    // Non compatible con Filament form schema
}
```

**Validazione**:
- Testa campo in Filament resource form
- Verificare validation integration
- PHPStan Level 10 compliance

---

## 🔄 Workflow Core Patterns

### Component Registration Workflow

1. **Crea Blade component** in `resources/views/components/`
2. **Registra** in `ServiceProvider` (auto-discover via namespace)
3. **Documenta** parametri con PHPDoc
4. **Testa** in isolation (Pest test o feature test)
5. **Aggiungi** file traduzione se labels hardcoded
6. **Deploy** con Tailwind build

### Filament Widget Integration Workflow

1. **Estendi** `Filament\Widgets\Widget` o `Filament\Widgets\ChartWidget`
2. **Implementa** `getDefaultName()` per auto-naming
3. **Usa translation** per labels (no hardcode)
4. **Registra** nel admin panel config
5. **Test** rendering con Pest
6. **Performance audit** per heavy rendering (ChartJS, etc.)

### Styling Cascade Pattern

1. **Base styles** in `resources/css/components/`
2. **Tailwind utilities** in templates (90% coverage)
3. **Custom CSS** only per complex animations/effects
4. **Responsive breakpoints** via Tailwind classes (`md:`, `lg:`, etc.)
5. **Theme overrides** in `themes/` folder

---

## ❌ Anti-Patterns: Cosa NON Fare

### 1. Hardcoded Navigation/Form Labels

```php
// ❌ SBAGLIATO
class CalendarWidget extends Widget {
    protected static ?string $heading = 'Calendar';
    protected static ?string $navigationLabel = 'Events';
}

// ✅ CORRETTO: Leggi da translation
class CalendarWidget extends Widget {
    protected static ?string $heading = null;
    // lang/it/widgets.php:
    // 'calendar' => ['heading' => 'Calendario', ...]
}
```

**Motivo**: Hardcoding impedisce multilingua; translation system consente IT/EN switching.

### 2. Inline Styles in Blade Templates

```blade
<!-- ❌ SBAGLIATO -->
<div style="color: red; font-size: 16px; margin: 8px;">
  Errore
</div>

<!-- ✅ CORRETTO -->
<div class="text-red-600 text-base m-2">
  Errore
</div>
```

**Motivo**: Inline styles non compilati, non tree-shaked, non responsive.

### 3. String Magic Values Instead of Enums

```php
// ❌ SBAGLIATO
if ($request->layout === 'list') { }

// ✅ CORRETTO
if ($request->layout === TableLayoutEnum::LIST) { }
```

**Motivo**: Enums eliminano typo risk, aggiungono IDE autocomplete.

### 4. Duplicating Filament Native Components

```php
// ❌ SBAGLIATO: Reimplementa TextInput
class CustomTextInput extends Component {
    // Duplicate logica Filament
}

// ✅ CORRETTO: Estendi oppure usa composition
class SpecializedTextInput extends \Filament\Forms\Components\TextInput {
    // Override solo comportamento specifico
}
```

**Motivo**: Duplicazione causa maintenance burden; inheritance/composition è preferito.

### 5. Mixing Concerns: Component Logic in Views

```blade
<!-- ❌ SBAGLIATO: Logica nel template -->
<div>
  @foreach ($users as $user)
    @if ($user->role === 'admin')
      <span>{{ strtoupper($user->name) }}</span>
    @endif
  @endforeach
</div>

<!-- ✅ CORRETTO: Logica in PHP class -->
<!-- Controller/Service prepara $adminUsers -->
<div>
  @foreach ($adminUsers as $user)
    <span>{{ $user->name }}</span>
  @endforeach
</div>
```

**Motivo**: Separation of concerns; testablità; reusability.

### 6. ChartJS Without Data Label Plugin

```php
// ❌ SBAGLIATO: Chart senza labels
ChartWidget::make([
    'datasets' => [
        [
            'label' => 'Revenue',
            'data' => [100, 200, 150],
        ],
    ],
]);

// ✅ CORRETTO: Con data labels per clarity
ChartWidget::make([
    'options' => [
        'plugins' => [
            'datalabels' => [
                'display' => true,
                'color' => '#000',
            ],
        ],
    ],
]);
```

**Motivo**: Data labels migliorano chart readability; accessibilità.

---

## ✅ Checklist Implementazione

Quando aggiungi feature nuova a UI:

- [ ] Component segue naming convention x-ui::ui.*
- [ ] File traduzione `lang/it/` + `lang/en/` creati
- [ ] Navigation labels da translation (no hardcode)
- [ ] Nessun inline style; solo Tailwind utilities
- [ ] Enum usato per state/type management (se applicabile)
- [ ] PHPStan Level 10 passa
- [ ] Pest test aggiunto (feature test minimo)
- [ ] README.md aggiornato per nuova feature
- [ ] Nessuna circular dependency su components
- [ ] Tailwind build tested locally (`npm run build`)

---

## 📖 Riferimenti Correlati

- [README](./README.md) — Overview modulo
<<<<<<< .merge_file_GZmyIV
- [INDEX](./INDEX.md) — Documentazione index completo

=======
<<<<<<< HEAD
=======
- [INDEX](./INDEX.md) — Documentazione index completo

>>>>>>> laraxot/dev
>>>>>>> .merge_file_jiu3dL
- [INDEX](./index.md) — Documentazione index completo

- [INDEX](./index.md) — Documentazione index completo

- [TROUBLESHOOTING](troubleshooting.md) — Errori comuni e soluzioni
- [architecture/component-registration](./architecture/component-registration.md) — Registrazione dettagliata
- [standards/ui-standards](./standards/ui-standards.md) — UI component standards
