# XotBaseWizardWidget Architecture - Zen Philosophy

**Date:** 2026-05-05
**Type:** architecture-decision
**Sources:** XotBaseWizardWidget.php, Wizard.php (Filament), HasWizard traits
**Confidence:** verified
**Tags:** xotbase, wizard, architecture, zen, theme-boundary
**Related:** why-xotbaseresourceform-superior.md, ticketform-pattern-reference.md

## The Zen Philosophy: "Same Wizard, Different Dresses"

### Core Concept

```
┌─────────────────────────────────────────────────────┐
│           FILAMENT WIZARD (core)              │
│     vendor/filament/schemas/src/Components/     │
│     Wizard.php + wizard.blade.php              │
└─────────────────────────────────────────────────────┘
           │                                    │
           ▼                                    ▼
┌──────────────────────┐          ┌──────────────────────┐
│  Theme: Sixteen   │          │  Theme: Sixteen   │
│  pub_theme::       │          │  pub_theme::       │
│  components.wizard │          │  filament.wizard  │
│  (frontoffice)     │          │  (admin panel)    │
└──────────────────────┘          └──────────────────────┘
           │                                    │
           ▼                                    ▼
http://127.0.0.1:8000/it/tests/segnalazione-crea
           (citizen frontoffice)              http://127.0.0.1:8000/fixcity/admin/tickets/create
                                            (admin panel)

SAME Wizard component, DIFFERENT "dresses" (CSS/Blade in theme)
```

### What This Means

1. **Module owns logic** (`CreateTicketWizardWidget`, `TicketForm`)
   - Business rules
   - Schema definition
   - Wizard steps
   - NO CSS/JS/CSS-in-Blade

2. **Theme owns presentation** (`pub_theme::components.wizard`)
   - CSS styling
   - Blade template overrides (if needed)
   - Visual parity with Design Comuni
   - `npm run build && npm run copy`

3. **Filament owns core** (`Wizard.php`, `wizard.blade.php`)
   - Alpine.js state management
   - Step navigation logic
   - Query string persistence
   - Skippable behavior

## Why NOT Reinvent the Wheel

### Existing Filament Traits to Use

```php
// ✅ CORRECT - Use existing Filament traits
use Filament\Actions\Concerns\HasWizard;        // For Actions
use Filament\Resources\Pages\Concerns\HasWizard; // For Pages (CreateRecord, EditRecord)
```

**XotBaseWizardWidget** extends these concepts for **Widgets** (Livewire components that aren't full Pages).

### What XotBaseWizardWidget Provides

```php
abstract class XotBaseWizardWidget extends XotBaseWidget {
    // ✅ Already has:
    // - makeWizard() - wraps Wizard::make() with our defaults
    // - getWizardSteps() - abstract, implemented by child
    // - initWizardState() - handles ?step= query
    // - configureWizardNextAction() - hook for "Avanti" button
    // - normalizeWizardFormState() - handles array key conversion
    
    // ❌ DO NOT reimplement these - they already exist!
}
```

## The "Dress" (Vestito) Pattern

### Frontoffice (Citizen Wizard)

```php
// CreateTicketWizardWidget.php (module - logic only)
class CreateTicketWizardWidget extends XotBaseWizardWidget {
    protected function makeWizard(array $steps): Wizard {
        $wizard = Wizard::make($steps)
            ->startOnStep(...)
            ->skippable(...)
            ->columnSpanFull();
        
        // KEY DECISION: Use theme "dress" for frontoffice
        if (! inAdmin()) {
            $wizard = $wizard->view('pub_theme::components.wizard');
        }
        
        return $wizard;
    }
}
```

### Admin (Panel Wizard)

```php
// TicketResource.php (module - standard Filament)
// Uses Filament's default Wizard rendering in admin panel
// No custom view needed - uses vendor/filament wizard.blade.php directly
```

## Safe Functions ARE Fundamental

### Why Safe Exists

```php
// ✅ CORRECT - Safe functions prevent runtime errors
use function Safe\file_put_contents;  // Handles permission errors
use function Safe\json_encode;        // Handles JSON errors
use function Safe\preg_match;         // Handles regex errors
```

**These are NOT optional** - they provide error handling that vanilla PHP lacks.

### Where Safe is Used (Correctly)

```php
// Modules/Xot/Actions/Cast/SafeStringCastAction.php
// Used in TicketForm.php for translation casting:
TextEntry::make('review_type')
    ->state(static fn (Get $get): string => 
        SafeStringCastAction::cast($get('type_id')))
```

## Correct Architecture Hierarchy

```
Filament\Schemas\Components\Wizard (vendor)
    ↑
XotBaseWizardWidget (Modules/Xot - our base)
    ↑
CreateTicketWizardWidget (Modules/Fixcity - concrete widget)
```

**Each layer adds value:**
- **Filament**: Core wizard functionality
- **XotBase**: Laraxot-specific defaults (LangServiceProvider, query string rules)
- **CreateTicketWizard**: Business logic (Ticket creation, redirect after success)

## Visual Parity Checklist

### Frontoffice (`/it/tests/segnalazione-crea`)

- [ ] Stepper visible with step names (not just "1/3")
- [ ] "Avanti" button (green, Design Comuni style)
- [ ] Checkbox label: "Ho letto e compreso l'informativa sulla privacy"
- [ ] Font: Titillium Web (via CSS theme)
- [ ] No inline `<style>` in module Blade
- [ ] CSS in `laravel/Themes/Sixteen/resources/css/app.css`
- [ ] Run `npm run build && npm run copy` after CSS changes

### Admin (`/fixcity/admin/tickets/create`)

- [ ] Standard Filament wizard rendering
- [ ] No theme overrides needed (uses vendor Blade directly)
- [ ] Same `TicketForm::getWizardSteps()` logic
- [ ] Different visual presentation (admin panel vs frontoffice)

## Quality Gates (MANDATORY After Every Change)

### 1. PHPStan (Level 5)

```bash
cd laravel
php vendor/bin/phpstan analyse Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php --level=5
```

### 2. PHPMD (.phar version)

```bash
php /home/zorin/.local/bin/phpmd.phar laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php text cleancode
```

### 3. PHP Insights

```bash
cd laravel
php vendor/bin/phpinsights analyse --no-interaction
```

### 4. Pint (Formatting)

```bash
cd laravel
php vendor/bin/pint Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php --format=agent
```

### 5. Pest Tests

```bash
cd laravel
php artisan test --compact --filter=CreateTicketWizard
```

### 6. Puppeteer Visual Check

```bash
# Check frontoffice wizard
node puppeteer-script.js http://127.0.0.1:8000/it/tests/segnalazione-crea
```

### 7. Playwright Visual Check

```bash
# Check admin wizard
npx playwright test --grep "admin tickets create"
```

## Rules Summary

1. ✅ **Safe functions are MANDATORY** - never remove them
2. ✅ **Use existing Filament traits** - don't reinvent HasWizard
3. ✅ **Module = logic, Theme = presentation**
4. ✅ **Same Wizard, different "dresses"** (themes)
5. ✅ **Run ALL quality gates after EVERY change**
6. ✅ **No `->label()` or `->tooltip()` in modules** (LangServiceProvider owns them)
7. ✅ **Document in module/theme `docs/wiki/`** after implementation
8. ✅ **Ingest into QMD** (when Node version allows)

## Files to Study

- `laravel/Modules/Xot/app/Filament/Widgets/XotBaseWizardWidget.php` ✅ (base widget)
- `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` ✅ (concrete widget)
- `laravel/Modules/Fixcity/app/Filament/Resources/TicketResource/Schemas/TicketForm.php` ✅ (form schema)
- `vendor/filament/schemas/src/Components/Wizard.php` ✅ (Filament core)
- `vendor/filament/schemas/resources/views/components/wizard.blade.php` ✅ (Filament Blade)

## Documentation Contract

After understanding and implementing:
1. Update `laravel/Modules/Xot/docs/wiki/concepts/xotbase-wizard-architecture.md`
2. Update `laravel/Modules/Fixcity/docs/wiki/concepts/wizard-zen-philosophy.md`
3. Update `laravel/Themes/Sixteen/docs/wiki/concepts/theme-dress-pattern.md`
4. Update all `docs/wiki/index.md` with new entries
5. Update `docs/wiki/log.md` with 2026-05-05 entry
6. Run QMD ingest when Node version is fixed
