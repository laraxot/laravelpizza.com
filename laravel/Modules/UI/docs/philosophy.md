---
qmd: "ui philosophy md"
module: UI
topic: PHILOSOPHY
canonical: ./PHILOSOPHY.md
status: living-document
updated: "2026-09-06"
maintenance: Marco Sottana
---

# UI Module Philosophy

A design system is not a collection of components. It is a covenant about how an interface thinks.

This document captures the philosophical and technical foundations of the UI module. It is not a tutorial; it is the reasoning behind the constraints.

---

## Religione: The Non-Negotiable Dogmas

### 1. UI is Vocabulary, Not Clothing

The UI module defines **what exists** in the interface. The theme defines **how it appears**.

**The distinction is not academic.**

A component born in UI is portable: it can migrate to another project in the ecosystem. A component born in a theme is poisoned: it carries style assumptions that other projects do not share.

**The boundary is reusability, not convenience of the moment.**

Example: A `GroupColumn` Filament component is generic (UI). A button styled as "FixCity primary blue" is specific (Theme). Never extract the second into the first.

---

### 2. Unidirectional Dependency

The arrow points one direction:

```
Xot ← UI ← User, Activity, Notify, Tenant, Employee, Sixteen, Ptv, Seo, Geo
```

- **UI never depends on domain modules.** Not on `User`, not on `Tenant`, not on business logic.
- **Domain modules may depend on UI.** They import `GroupColumn`, `IconStateColumn`, custom form fields.
- **A component that knows what a Card is: that is UI.** A component that knows what a `Patient` Card is: that is `Ptv`, not UI.

If you write a component that performs a business operation (checks a user role, loads a patient, validates a tenant), it does not belong in UI.

---

### 3. Extract Only After Measuring Duplication

**Never extract in anticipation. Never assume reusability.**

The pattern is proven by repetition:

```bash
grep -rl "getTableColumns" laravel/Modules/*/app
```

Count the matches. If fewer than 2, leave it inline. If 3+, extract. The measurement prevents premature abstraction and the maintenance burden it carries.

**The trap is subtle.** A `Section` extracted without a default heading becomes a different component than the version it replaced. The heading disappears. No error. No log. Just silent failure.

---

### 4. Accessibility is the Highest Contribution

The UI module is published to a public administration portal in Italy. It has **legal obligations** under the Digital Accessibility Act (Legge 4/2004).

If accessibility lives in the components, it scales across every page and module that consumes them. If it lives in each page, it does not get built.

**Accessibility is not an afterthought.** It is the first filter for every component:

- WCAG 2.1 Level AA minimum
- ARIA attributes for screen readers
- Keyboard navigation (Tab, Enter, Escape, Arrow keys)
- Color contrast ratios ≥ 4.5:1
- Semantic HTML (button, link, form, heading hierarchy)
- Focus visible states

---

### 5. Type Safety is Non-Negotiable

**No string magic values.** No `if ($layout === 'list')`.

All state and selection use Enums:

```php
// ✅ CORRECT
if ($layout === TableLayoutEnum::LIST) { }

// ❌ WRONG
if ($layout === 'list') { }
```

Enums eliminate typos. They add IDE autocomplete. They document intent.

---

## Filosofia: The Founding Ideas

### Component Philosophy: Composition Over Inheritance

UI follows the principle of **composition by default, inheritance as a last resort.**

- **Blade components** are functions: they accept slots and props, they render a view.
- **Filament custom fields** extend `Filament\Forms\Components\Field`: single inheritance, no deep hierarchies.
- **Widgets** are self-contained pieces: they own their data, their state, their styling.

Every component answers: "Can this component exist independently?" If the answer is no, it is not a component—it is a fragment. Move it to a helper function or a trait.

---

### Styling Philosophy: Tailwind First, Custom CSS Last

**Tailwind CSS v4 is the law.** 90% of styling is Tailwind utilities. 10% is custom CSS for animations, complex effects, or theme-specific behavior.

**Never inline styles.** Never `style="color: red"`. Styles belong in Tailwind classes, which are compiled, tree-shaken, and responsive.

```blade
<!-- ✅ CORRECT -->
<div class="bg-blue-600 p-4 rounded-lg shadow-md text-white dark:bg-blue-900">
  <p class="text-lg font-semibold">Title</p>
</div>

<!-- ❌ WRONG -->
<div style="background-color: #2563eb; padding: 16px; border-radius: 8px;">
  <p style="font-size: 18px; font-weight: 600;">Title</p>
</div>
```

Why? Inline styles are not compiled. They are not responsive. They cannot be tree-shaken. They pollute markup.

---

### Localization Philosophy: Everything in Lang Files

**Zero hardcoded strings.** Not in PHP classes, not in Blade templates.

Every label, every button text, every heading belongs in translation files:

```php
// lang/it/widgets.php
return [
    'calendar' => [
        'heading' => 'Calendario',
        'no_events' => 'Nessun evento',
    ],
];

// lang/en/widgets.php
return [
    'calendar' => [
        'heading' => 'Calendar',
        'no_events' => 'No events',
    ],
];
```

Why? It enables true multilingua without recompilation. It creates a single source of truth. It scales.

---

### Filament Integration Philosophy: Composition, Not Reimplementation

**Never reimplement Filament components.** Never create a `CustomTextInput` that duplicates what `Filament\Forms\Components\TextInput` already does.

Instead:

1. **Extend when you add behavior.** `class SpecializedTextInput extends TextInput` adds validation, transforms data, or changes rendering.
2. **Compose when you combine components.** Use `ComponentContainer` or field groups to assemble complex forms.
3. **Create helpers when you simplify setup.** Macros like `Form::addressField()` reduce boilerplate without reimplementation.

---

### Testing Philosophy: Behavior, Not Implementation

Tests verify the contract, not the internals.

```php
// ✅ CORRECT: Test behavior
test('icon column renders status icon', function () {
    $component = Livewire::test(IconStateColumn::class, ['record' => $record])
        ->assertSee('ui-check'); // Observable outcome
});

// ❌ WRONG: Test implementation
test('icon column calls getIconName method', function () {
    $mock = Mockery::mock(...);
    $mock->shouldReceive('getIconName')->once();
    // Brittle; breaks on refactor
});
```

---

## Politica: The Rules and Constraints

### File Organization

```
Modules/UI/
├── app/
│   ├── Actions/                 # Queueable business logic
│   ├── Datas/                   # Spatie Data objects
│   ├── Enums/                   # Type-safe enumerations
│   ├── Filament/
│   │   ├── Actions/             # Filament actions
│   │   ├── Blocks/              # Page builder blocks
│   │   ├── Components/          # Custom field components
│   │   ├── Forms/Components/    # Form field wrappers
│   │   ├── Pages/               # Filament pages
│   │   ├── Resources/           # Filament resources
│   │   ├── Tables/Columns/      # Table column types
│   │   ├── Traits/              # Shared behavior
│   │   └── Widgets/             # Dashboard widgets
│   ├── Http/
│   │   ├── Controllers/         # HTTP controllers
│   │   ├── Livewire/            # Livewire components
│   │   └── Middleware/          # HTTP middleware
│   ├── Models/                  # Eloquent models (rare in UI)
│   ├── Services/                # Deprecated; use Actions instead
│   ├── Traits/                  # Shared component logic
│   ├── View/Components/         # Blade components
│   └── Providers/               # Service providers
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── docs/                        # This documentation
├── lang/                        # Translation files
│   ├── en/
│   └── it/
├── resources/
│   ├── css/
│   ├── svg/                     # SVG icons (ui- prefix)
│   └── views/
│       ├── components/          # Blade component views
│       ├── filament/            # Filament views
│       └── livewire/            # Livewire views
├── routes/
├── tests/
│   ├── Feature/
│   └── Unit/
├── README.md
└── CHANGELOG.md
```

(`architecture.md`, `testing.md`, `GETTING_STARTED.md` and `PHILOSOPHY.md` were moved from the module root into `docs/root-md-files/` and `docs/` proper; they are inside the collapsed `docs/` entry above.)

├── architecture.md
└── CHANGELOG.md
```

---

### Blade Component Naming

All Blade components use the prefix `x-ui::ui.`:

```blade
<!-- ✅ CORRECT -->
<x-ui::ui.button label="Submit" color="primary" />
<x-ui::ui.card>...</x-ui::ui.card>
<x-ui::ui.modal open="true">...</x-ui::ui.modal>

<!-- ❌ WRONG: No prefix (collides with other packages) -->
<x-button label="Submit" />
<x-card>...</x-card>
```

The prefix prevents namespace collisions with Filament native components and third-party packages.

---

### Filament Component Registration

All Filament custom components extend native Filament classes:

```php
// ✅ CORRECT
namespace Modules\UI\Filament\Forms\Components;

use Filament\Forms\Components\Field;

final class AddressField extends Field
{
    protected string $view = 'ui::filament.forms.components.address';
}

// Registration via macro
Form::macro('addressField', fn() => AddressField::make('address'));

// Usage
$form->addressField()
    ->label('Address')
    ->required();

// ❌ WRONG: Custom class without inheritance
class AddressField
{
    public function render() { ... }
}
```

---

### Icon System

All icons live in `resources/svg/` and use the `ui-` prefix:

```
resources/svg/
├── login.svg
├── user.svg
├── settings.svg
├── trash.svg
└── ...
```

Icons are auto-registered by `UIServiceProvider`:

```php
// In Blade
@svg('ui-login', 'w-6 h-6 text-blue-500')

// In Filament forms
TextInput::make('email')->prefixIcon('ui-login')

// In Filament tables
TextColumn::make('name')->icon('ui-user')
```

SVG files should:

- Use `viewBox="0 0 24 24"` for consistency
- Use `stroke="currentColor"` to inherit color from context
- Include `aria-hidden="true"` for accessibility
- Be optimized (remove unnecessary attributes)

---

### Translation File Structure

Every module that contributes UI strings maintains translation files:

```
lang/
├── en/
│   ├── widgets.php
│   ├── forms.php
│   ├── tables.php
│   ├── blocks.php
│   └── messages.php
└── it/
    ├── widgets.php
    ├── forms.php
    ├── tables.php
    ├── blocks.php
    └── messages.php
```

Keys are hierarchical and descriptive:

```php
// lang/it/widgets.php
return [
    'calendar' => [
        'heading' => 'Calendario',
        'no_events' => 'Nessun evento trovato',
        'button.add' => 'Aggiungi evento',
    ],
    'stats_overview' => [
        'heading' => 'Panoramica Statistiche',
        'total_users' => 'Utenti totali',
    ],
];
```

---

### Enum Naming

Enum keys use `TitleCase`:

```php
enum TableLayoutEnum: string
{
    case LIST = 'list';
    case GRID = 'grid';
    case COMPACT = 'compact';
}

enum FieldTypeEnum: string
{
    case TEXT = 'text';
    case NUMBER = 'number';
    case SELECT = 'select';
    case DATE = 'date';
}
```

---

### PHPStan Compliance

All code must pass `PHPStan Level 10`:

```bash
./vendor/bin/phpstan analyse Modules/UI --memory-limit=-1
```

Verified: 2026-09-02, `[OK] No errors`.

---

## Scopo: Purpose and Scope

### Why UI Exists

UI is the shared vocabulary of the interface. It is the place where a block of markup or a set of fields stops being copied and becomes a word that all modules pronounce the same way.

**Measurement (2026-09-02):**

- 9 modules import UI (40 files)
- Most reused export: `Filament\Tables\Columns\GroupColumn` (29 files)
- Outgoing dependencies: 73 files to `Xot`, 1 file to `User`
- Incoming dependencies: correct (unidirectional arrow)
- Blade components: 243 components, 1 invoked from outside (correct isolation)

### What Belongs in UI

1. **Reusable form fields.** `AddressField`, `InlineDatePicker`, `OpeningHoursField`, `IconPicker`.
2. **Custom table columns.** `IconColumn`, `IconStateColumn`, `GroupColumn`, `SelectStateColumn`.
3. **Blade components.** Logo, Navbar, Sidebar, page layouts, blocks.
4. **Icons.** SVG system with automatic registration.
5. **Widgets.** Dashboard widgets, charts, stats.
6. **Traits and actions.** Shared component logic, data transformation.

### What Does NOT Belong in UI

1. **Theme and styling specifics.** Move to `Themes/`. (FixCity is blue? That is a theme choice.)
2. **Business logic.** `if ($user->isAdmin)` does not belong in a component.
3. **Domain models.** `App/Models/Patient`, `App/Models/Card`. These belong in their domain modules.
4. **Domain-specific form fields.** A field that knows what a `Patient` is: that is `Ptv`, not `UI`.
5. **Filament base classes.** These live in `Xot`, not `UI`.

---

## Zen: The Essence

The UI module is an exercise in **elegant constraint.**

### What Makes a Component Reusable

1. **It has no assumption about domain.** A `Card` component has no idea what a patient is.
2. **It has complete accessibility built in.** Not added later. Not optional. Wired from first line.
3. **It documents its contract.** PHPDoc blocks list all properties, return types, and examples.
4. **It is tested through its public API.** Tests verify behavior, not internals.
5. **It is extracted only after proven duplication.** Not in anticipation. Not for convenience.

### What Makes a Codebase Maintainable

1. **Clear boundaries.** Every file, every class, every function has one reason to change.
2. **Explicit dependencies.** Type hints, interfaces, and constructor injection make relationships clear.
3. **Honest naming.** `getGroupedUsers()` means grouped. `formatAsJson()` means JSON. No secrets.
4. **Minimal coupling.** A change in `Notify` should not require a change in `UI`.
5. **Comprehensive documentation.** Code is read more often than it is written.

---

## Librerie da Installare

These packages are required and already installed:

| Library | Version | Purpose |
|---|---|---|
| PHP | `^8.3` | Language runtime |
| Laravel | `^13.0` | Framework |
| Filament | `^5.0` | Admin UI framework |
| Tailwind CSS | `^4` | Utility-first CSS |
| Blade Icons | `^1.x` | SVG icon system |
| Livewire | `^3.x` | Real-time components |
| Pest | `^3.x` | Testing framework |
| PHPStan | `^max` | Static analysis |

No additional packages are recommended without explicit justification.

---

## Future Implementazioni

### Dark Mode (In Progress)

- [ ] Complete Tailwind dark mode configuration (`@media (prefers-color-scheme: dark)`)
- [ ] Test all components in both light and dark modes
- [ ] Update widget styles for dark mode
- [ ] Document color semantic tokens (not hex values)

### Animation System

- [ ] CSS animation library for page transitions
- [ ] Respect `prefers-reduced-motion` media query
- [ ] Microinteractions: loading states, success confirmations, error feedback
- [ ] Performance audit: use CSS animations, never JavaScript for UI transitions

### Accessibility Enhancements

- [ ] Complete WCAG 2.1 Level AAA audit
- [ ] Screen reader testing with NVDA and JAWS
- [ ] Keyboard navigation testing (Tab, Enter, Escape, Arrow keys)
- [ ] Form error messaging with ARIA live regions

### Chart Components

- [ ] Custom chart wrapper with data labels
- [ ] Ensure legends are keyboard accessible
- [ ] Tooltip accessibility
- [ ] Alternative text for charts (data table fallback)

### Documentation

- [ ] Visual component storybook (Blade component browser)
- [ ] Live examples with interactive toggles
- [ ] Copy-to-clipboard code snippets

---

## Competitors & Inspirations

### shadcn/ui

**Approach:** Component composition. Copy-paste components, no npm package.

**Inspiration:** Radical honesty about component ownership. No black-box library; every component is yours to modify.

**What we learn:** Composition patterns, documentation clarity, component testing strategies.

### Filament

**Approach:** Native Laravel admin UI. Extensions through inheritance and macros.

**Why we integrate:** Filament is the admin standard in Laravel. UI extends, never reimplements.

**What we learn:** Service provider patterns, form and table field architecture, widget structure.

### DaisyUI

**Approach:** Component classes built on Tailwind. Theme system via CSS variables.

**Inspiration:** Semantic naming, theme flexibility, accessibility defaults.

**What we learn:** Component layer on top of utilities, naming conventions, dark mode patterns.

### Mantine

**Approach:** React component library with comprehensive documentation.

**Inspiration:** Component API design, hooks patterns, accessibility documentation.

**What we learn:** API design principles (what methods are on a component?), testing strategies, documentation structure.

### Material Design

**Approach:** Design system with strict rules, comprehensive documentation.

**Inspiration:** Color semantic tokens, spacing scale, type system.

**What we learn:** Design system rigor, accessibility defaults, semantic color usage.

---

## Best Practices

### Component Development

1. **Start with the public API.** What will a developer call on this component? Design the method signatures before the internals.

2. **Document all properties with PHPDoc.** Every public property, every method parameter, every return type.

```php
/**
 * Form address field with autocomplete integration.
 *
 * @property string $name Field name
 * @property string|null $label Display label
 * @property bool $required Whether field is required
 * @property string|null $helperText Helper text below field
 *
 * @method self required(bool $condition = true) Mark as required
 * @method self disabled(bool $condition = true) Disable field
 */
final class AddressField extends Field
{
}
```

3. **Test through the public API, not internals.** Verify behavior, not implementation details.

4. **Provide sensible defaults.** A component should work out of the box for 80% of use cases.

5. **Use factory functions for test data.** Never `let` in setup. Always factory:

```php
// ✅ CORRECT
$user = User::factory()->create();
$user2 = User::factory()->admin()->create();

// ❌ WRONG
$users = [];
beforeEach(function () {
    global $users;
    $users[] = User::create([...]);
});
```

---

### Accessibility Guidelines

1. **Semantic HTML first.** Use `<button>` for buttons, not `<div>` with role="button".

2. **ARIA attributes for complex widgets.** `aria-label`, `aria-describedby`, `aria-live` for dynamic content.

3. **Keyboard navigation.** Every interactive element must be reachable by Tab. All functionality must be accessible without a mouse.

4. **Color contrast.** Foreground/background must meet WCAG AA (4.5:1 for text).

5. **Focus visible.** `:focus-visible` styles must be clear and distinctive.

6. **Alternative text.** All images must have alt text. SVG icons must have `aria-hidden="true"` or a label.

```blade
<!-- ✅ CORRECT -->
<button class="px-4 py-2 bg-blue-600 text-white rounded focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400"
        aria-label="Submit form">
    {{ __('ui.forms.submit') }}
</button>

<!-- ❌ WRONG: No accessible focus, hardcoded text -->
<div onclick="handleSubmit()" style="cursor: pointer;">
    Submit
</div>
```

---

### Testing Guidelines

1. **Feature tests for component integration.** Does the form field work in a Filament resource?

2. **Unit tests for complex logic.** Does `GetAllIconsAction` correctly list all SVG files?

3. **Browser tests for interactions.** Does the modal open when the button is clicked?

```php
// Feature test: Component in context
test('address field renders in form', function () {
    $component = Livewire::test(CreateUserForm::class)
        ->assertSeeComponent(AddressField::class);
});

// Unit test: Business logic
test('get all icons returns correct prefix', function () {
    $icons = app(GetAllIconsAction::class)->execute();
    expect(array_keys($icons))
        ->toContain('ui');
});
```

---

### Documentation Guidelines

Every component must have:

1. **A purpose statement.** One sentence: what does this solve?

2. **Basic usage example.** Copy-paste code that works immediately.

3. **All properties and methods.** What can a developer do with this?

4. **Accessibility notes.** What did we do to make this accessible?

5. **Known limitations.** What can this NOT do?

```markdown
## AddressField

An address input field with Google Autocomplete integration.

### Usage

```php
AddressField::make('address')
    ->label('Address')
    ->required()
    ->placeholder('Enter address...')
```
```

---

## Bad Practices

### 1. Hardcoded Labels in Classes

```php
// ❌ WRONG
class CalendarWidget extends Widget
{
    protected static ?string $heading = 'Calendar'; // Hardcoded
}

// ✅ CORRECT
class CalendarWidget extends Widget
{
    protected static ?string $heading = null;
    // Loaded from lang/it/widgets.php: 'calendar.heading' => 'Calendario'
}
```

Why? Hardcoding prevents multilingua and centralizes text into a single source of truth.

---

### 2. Inline Styles in Templates

```blade
<!-- ❌ WRONG -->
<div style="color: red; font-size: 16px; margin: 8px;">
    Error message
</div>

<!-- ✅ CORRECT -->
<div class="text-red-600 text-base m-2">
    Error message
</div>
```

Why? Inline styles are not compiled, not tree-shaken, not responsive.

---

### 3. String Magic Values Instead of Enums

```php
// ❌ WRONG
if ($layout === 'list') {
    // Prone to typos: 'list', 'lst', 'List'?
}

// ✅ CORRECT
if ($layout === TableLayoutEnum::LIST) {
    // IDE autocomplete, compile-time checking, no typos
}
```

---

### 4. Duplicating Filament Native Components

```php
// ❌ WRONG: Reimplements TextInput
class CustomTextInput extends Component
{
    public function render() {
        // Duplicate Filament logic
    }
}

// ✅ CORRECT: Extends and specializes
class EmailInput extends \Filament\Forms\Components\TextInput
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->email()
            ->prefixIcon('ui-login');
    }
}
```

---

### 5. Mixing Logic and Presentation

```blade
<!-- ❌ WRONG: Logic in template -->
<div>
    @foreach ($users as $user)
        @if ($user->role === 'admin' && $user->is_active)
            <span>{{ strtoupper($user->name) }}</span>
        @endif
    @endforeach
</div>

<!-- ✅ CORRECT: Logic in PHP, template renders -->
<!-- Controller prepares $adminUsers -->
<div>
    @foreach ($adminUsers as $user)
        <span>{{ $user->name }}</span>
    @endforeach
</div>
```

---

### 6. ChartJS Without Data Labels

```php
// ❌ WRONG: Chart unreadable
ChartWidget::make([
    'datasets' => [
        [
            'label' => 'Revenue',
            'data' => [100, 200, 150],
            // Numbers visible only on hover
        ],
    ],
]);

// ✅ CORRECT: Labels visible for clarity
ChartWidget::make([
    'options' => [
        'plugins' => [
            'datalabels' => [
                'display' => true,
                'color' => '#000',
                'font' => ['weight' => 'bold'],
            ],
        ],
    ],
]);
```

---

### 7. Extracting Before Measuring Duplication

```php
// ❌ WRONG: Extracted after one use
class UserCardComponent extends Component { ... }
// Used only in UserProfile.php

// ✅ CORRECT: Extracted after 3+ uses
// grep -rl "user.*card" laravel/Modules/*/app shows 4 files
// Now extract: UserCardComponent
```

---

## False Friends: Gotchas and Traps

### Tailwind v3 vs v4

**Change:** Opacity syntax.

```tailwind
/* Tailwind v3 */
bg-blue-500/50 /* Unsupported in v4 */

/* Tailwind v4 */
bg-blue-500/50 /* Works; slash syntax is standard */
```

**Change:** `corePlugins` configuration.

```javascript
// Tailwind v3
module.exports = {
    corePlugins: {
        preflight: false, // Disables base styles
    },
};

// Tailwind v4
// corePlugins not supported; use @layer directives instead
@layer base {
    /* Custom base styles here */
}
```

---

### Dark Mode Configuration

**Trap:** Dark mode looks configured but doesn't work.

```css
/* ❌ WRONG: Assumes user system preference */
@media (prefers-color-scheme: dark) {
    /* Styles */
}

/* ✅ CORRECT: Class-based dark mode, manual toggle */
:root.dark {
    /* Styles */
}
```

The app must support manual dark mode toggle (not just system preference).

---

### Component Extraction Timing

**Trap:** Extract a component early to avoid repetition, then discover the use cases diverge.

```php
// ❌ WRONG: Extracted too early
class FormField extends Component
{
    public function render()
    {
        // Generic, but missing features some callers need
    }
}

// Later, 3 different variations exist
class EmailField extends FormField { ... }
class PhoneField extends FormField { ... }
class AddressField extends FormField { ... }

// ✅ CORRECT: Measure first
// grep -rl "form.*field" → 0 matches
// Leave inline for now
// 6 months later: grep -rl "form.*field" → 4 matches
// NOW extract with confidence
```

---

### Form Validation: Client vs Server

**Trap:** Assume client-side validation is enough.

```javascript
// ❌ WRONG: Only client validation
<input type="email" required>
// User can send raw HTTP request and bypass

// ✅ CORRECT: Server validation is law
// Client validation: UX improvement
// Server validation: security requirement
```

All form data must be validated on the server, always. Client validation is UX enhancement only.

---

### Icon Prefix Collisions

**Trap:** Custom icons shadow Filament native icons.

```blade
<!-- ❌ WRONG: No prefix -->
@svg('login') <!-- Ambiguous: which module? -->

<!-- ✅ CORRECT: Prefixed -->
@svg('ui-login') <!-- Clear: UI module -->
@svg('filament-login') <!-- Clear: Filament -->
```

---

### Widget Test Bootstrap

**Trap:** Widgets require full Laravel container to render.

```php
// ❌ WRONG: Widget test fails with BindingResolutionException
test('widget renders', function () {
    $widget = new CalendarWidget();
    $widget->render(); // View factory not available
});

// ✅ CORRECT: Use Livewire test harness
test('widget renders', function () {
    Livewire::test(CalendarWidget::class)
        ->assertSeeComponent(CalendarWidget::class);
});
```

---

### Blade Component Slot Defaults

**Trap:** Slot defaults in component view work in isolation but fail in production.

```php
// Component.php
// ❌ WRONG: No default provided in PHP
class Card extends Component { }

// component-view.blade.php
<!-- ❌ WRONG: Slot default in template is hidden -->
<div class="card">
    {{ $slot ?? 'Default Title' }}
</div>
```

Always provide defaults in the PHP class, not the view.

```php
// ✅ CORRECT
class Card extends Component
{
    public function __construct(
        public string $title = 'Untitled Card',
    ) {}
}
```

---

## Come Usarlo: Using UI Components

### In Blade Templates

```blade
<!-- Import UI namespace -->
<x-ui::ui.button
    label="Submit"
    color="primary"
    size="lg"
/>

<!-- With slots -->
<x-ui::ui.card>
    <x-slot name="header">
        <h2>{{ __('ui.forms.title') }}</h2>
    </x-slot>

    <p>Card content here</p>

    <x-slot name="footer">
        <x-ui::ui.button label="Close" wire:click="close" />
    </x-slot>
</x-ui::ui.card>

<!-- With conditional classes -->
<div class="p-4 @if ($isDanger) bg-red-100 @else bg-gray-100 @endif">
    Message
</div>
```

---

### In Filament Resources

```php
// Form fields
use Modules\UI\Filament\Forms\Components\AddressField;
use Modules\UI\Filament\Forms\Components\IconPicker;

Forms\Section::make('Contact')
    ->schema([
        AddressField::make('address')
            ->required(),
        IconPicker::make('icon')
            ->label(__('ui.forms.icon')),
    ])

// Table columns
use Modules\UI\Filament\Tables\Columns\GroupColumn;
use Modules\UI\Filament\Tables\Columns\IconStateColumn;

Tables\Columns\TextColumn::make('name')
    ->sortable()
    ->searchable(),

GroupColumn::make('tags')
    ->label(__('ui.tables.tags')),

IconStateColumn::make('status')
    ->label(__('ui.tables.status'))
```

---

### In Livewire Components

```php
namespace App\Livewire;

use Livewire\Component;
use Modules\UI\Actions\GetAllIconsAction;

class IconSelector extends Component
{
    public array $icons = [];

    public function mount()
    {
        $this->icons = app(GetAllIconsAction::class)->execute();
    }

    public function render()
    {
        return view('livewire.icon-selector');
    }
}
```

---

### Icon Usage

```blade
<!-- In Blade templates -->
@svg('ui-login', 'w-6 h-6 text-blue-500')
@svg('ui-check', ['class' => 'w-4 h-4', 'aria-hidden' => 'true'])

<!-- In Filament forms -->
TextInput::make('email')
    ->prefixIcon('ui-login')
    ->suffixIcon('ui-google')

<!-- In Filament tables -->
TextColumn::make('status')
    ->icon('ui-check')
    ->color('success')

<!-- In Filament actions -->
Action::make('login')
    ->icon('ui-login')
    ->url('/login')
```

---

## Come Installarlo: Installation and Setup

### Already Installed

The UI module is already part of the Laravel project structure:

```bash
laravel/Modules/UI/
```

No separate composer package installation is needed.

---

### Enable the Module

```bash
php artisan module:enable UI
```

---

### Publish Assets (if needed)

```bash
php artisan vendor:publish --provider="Modules\UI\Providers\UIServiceProvider"
```

---

### Register Blade Components (auto)

Blade components are auto-discovered via the service provider:

```php
// UIServiceProvider automatically registers x-ui:: components
// No manual registration needed
```

---

### Configure Tailwind (already done)

Tailwind configuration already includes UI module paths:

```javascript
// tailwind.config.js
content: [
    './laravel/Modules/UI/resources/views/**/*.blade.php',
    './laravel/Modules/*/resources/views/**/*.blade.php',
]
```

---

### Build CSS

```bash
npm run build
```

For development with watch:

```bash
npm run dev
```

---

### Test Installation

```bash
php artisan tinker
>>> app('blade-icons')->getRegisteredSets()
# Should show: ['ui' => [...], ...]

>>> @svg('ui-login')
# Should render login icon
```

---

## Coverage Analysis

### Test Status (2026-09-02)

```
Tests:    76 failed, 1 risky, 39 skipped, 42 passed (90 assertions)
Duration: 33.74s
```

### Failures Breakdown

**Widget Bootstrap Issues (76 failing tests)**

The majority of failures stem from widget test setup:

```
BindingResolutionException: Target [Illuminate\Contracts\View\Factory] is not instantiable
```

Widgets require full Laravel container to render. Unit tests fail because view factory is not bound. Solution: migrate to Livewire::test() harness.

---

### Passing Tests (42 tests)

Core functionality tests pass:

- Icon system tests
- Action tests (GetAllIconsAction)
- Data transformation tests
- Basic component tests

---

### Static Analysis

**PHPStan Level 10:** `[OK] No errors` (verified 2026-09-02)

---

### Coverage Gaps

- Widget integration tests: low coverage
- Form field validation: incomplete
- Accessibility testing: none (manual audit needed)
- Chart component testing: none

---

### Recommended Coverage Improvements

1. **Convert widget unit tests to feature tests** using `Livewire::test()`.
2. **Add form field validation tests** for each custom field type.
3. **Add accessibility audit suite** using `axe-core` or similar.
4. **Add snapshot tests** for Blade component rendering.

---

## References and Links

### Core Documentation

- [README.md](./README.md) — Module overview
- [architecture.md](./architecture.md) — System architecture
- [architecture.md](./architecture.md) — System architecture
- [architecture.md](./architecture.md) — System architecture
- [architecture.md](./architecture.md) — System architecture
- [architecture.md](./architecture.md) — System architecture
- [patterns.md](./patterns.md) — Design patterns and workflows
- [icon-system.md](icons/icon-system.md) — Icon system details

### Best Practices

- [best-practices-1.md](./best-practices-1.md) — Development best practices
- [naming-conventions-1.md](./naming-conventions-1.md) — Naming rules
- [module-icons-design-system.md](./module-icons-design-system.md) — Icon design system

### Related Modules

- [Xot](../Xot/docs/) — Base classes and utilities
- [Themes/](../Themes/) — Styling and theming
- [User](../User/docs/) — User authentication and profiles

---

## Versioning and Maintenance

| Version | Date | Notes |
|---|---|---|
| 1.0 | 2026-09-06 | Philosophy document created |

**Next Review:** 2026-12-06

**Maintainer:** Marco Sottana

---

## Questions and Feedback

This philosophy is a living document. It will evolve as the system matures.

For questions, clarifications, or philosophical debates, consult the related documentation files or propose changes through the standard review process.

Remember: **A design system is not a collection of components. It is a covenant about how an interface thinks.**
