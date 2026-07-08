# 4. Critical Architecture Rules

### Translation Management - AUTOMATIC ONLY!
**CRITICAL RULE: NEVER use ->label(), ->placeholder(), ->helperText() manually!**

The Laraxot framework handles all translations automatically via:
- `LangServiceProvider` - Automatically configures all Filament components
- `AutoLabelAction` - Generates translation keys automatically

**Translation Key Pattern:**
```
{module}::{widget}.fields.{field}.{type}
```
Examples:
- `gdpr::register.fields.first_name.label`
- `gdpr::register.fields.first_name.placeholder`
- `gdpr::register.fields.first_name.helper_text`

**Translation File Structure:**
```php
// Modules/ModuleName/lang/{locale}/{widget}.php
return [
    'navigation' => [
        'label' => 'Label',
        'plural_label' => 'Labels',
        'group' => 'ModuleName',
        'icon' => 'heroicon-o-icon',
        'sort' => 10,
    ],
    'fields' => [
        'field_name' => [
            'label' => 'Field Label',
            'placeholder' => 'Placeholder text',
            'helper_text' => 'Helper text description',
        ],
    ],
    'actions' => [...],
    'validation' => [...],
    'messages' => [...],
];
```

**⚠️ CRITICAL: NEVER replace structured translations with flat keys!**

❌ WRONG - Flat keys only:
```php
return [
    'name' => 'Nome',
    'description' => 'Descrizione',
    'title' => 'Titolo',
    // ... hundreds of flat keys
];
```

✅ CORRECT - Full structure:
```php
return [
    'navigation' => [...],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome identificativo',
        ],
    ],
    // ... full structure
];
```

**🔴 HOW TO DETECT THE PROBLEM:**

Look for these warning signs in translation files:
- Comment: `// Chiavi di base - da completare`
- Missing `navigation` array at top level
- Missing `fields` as multidimensional array
- Only single-level flat keys at top level

**TO FIX:** Rewrite the file with the complete structure template above.

**🔴 CRITICAL: NEVER LEAVE MANDATORY NODES EMPTY!**

The following top-level keys MUST NEVER be empty or missing:
- `navigation` → MUST contain label, plural_label, group, icon, sort
- `label` → MUST contain a value (e.g., 'User', 'Profile')
- `plural_label` → MUST contain a value (e.g., 'Users', 'Profiles')
- `fields` → MUST contain field definitions (not empty array)
- `actions` → MUST contain action definitions (not empty array)

**PROHIBITED:**
```php
// ❌ WRONG - Empty nodes
'navigation' => []           // EMPTY!
'label' => ''                // EMPTY!
'plural_label' => ''         // EMPTY!
'fields' => []               // EMPTY!
'actions' => []              // EMPTY!
```

**REQUIRED:**
```php
// ✅ CORRECT - All nodes filled
'navigation' => [
    'label' => 'User',
    'plural_label' => 'Users',
    'group' => 'Management',
    'icon' => 'heroicon-o-user',
    'sort' => 1,
],
'label' => 'User',
'plural_label' => 'Users',
'fields' => [
    'name' => ['label' => 'Name'],
],
'actions' => [
    'create' => ['label' => 'Create'],
],
```

**VIOLATION EXAMPLES (NEVER DO THIS):**
```php
// ❌ WRONG - Manual label()
TextInput::make('name')->label('Name')

// ❌ WRONG - Manual placeholder()
TextInput::make('email')->placeholder('Enter email')

// ❌ WRONG - Manual helperText()
TextInput::make('password')->helperText('Choose a strong password')

// ❌ WRONG - Manual __() translation
TextInput::make('name')->__('module::field.label')
```

**CORRECT PATTERN:**
```php
// ✅ CORRECT - No manual methods
TextInput::make('name')
TextInput::make('email')
TextInput::make('password')
```

The `LangServiceProvider` automatically:
1. Detects the component class from the backtrace
2. Generates the correct translation key
3. Applies the label, placeholder, and helper_text from translation files
4. Falls back to field name if translation is missing

**IMPORTANT: This applies to BOTH Filament Resources AND Livewire Components using Filament Forms!**

When using Filament Form components in Livewire/Volt:
```php
// ✅ CORRECT - Let LangServiceProvider handle translations automatically
TextInput::make('email')->required()

// ❌ WRONG - Manual label/placeholder overrides automatic system
TextInput::make('email')->label(__('Email'))->placeholder(__('Enter email'))
```

**Translation File Naming:**
- For a component `Modules\User\Http\Livewire\Auth\Register`, create:
  - `Modules/User/lang/it/register.php`
  - `Modules/User/lang/en/register.php`

The key generated will be `user::register.fields.email.label`.

### Theme Translations - pub_theme Namespace (CRITICAL!)

**Theme translations use `pub_theme::` namespace and MUST follow this pattern:**

```blade
{{-- ALWAYS use .label suffix --}}
{{ __('pub_theme::event.back_to_events.label') }}
{{ __('pub_theme::event.date.label') }}
{{ __('pub_theme::event.about_this_event.label') }}
```

**Translation File Structure (Themes):**
```php
// Themes/Meetup/lang/{locale}/event.php
return [
    'navigation' => [...],
    'back_to_events' => [
        'label' => 'Back to Events',
    ],
    'date' => [
        'label' => 'Date',
    ],
    'about_this_event' => [
        'label' => 'About this event',
    ],
    // ...
];
```

**NEVER use flat keys:**
```php
// ❌ WRONG
'back_to_events' => 'Back to Events',

// ✅ CORRECT
'back_to_events' => [
    'label' => 'Back to Events',
],
```

### Frontend (Frontoffice) - NO Controllers! NO Routes!
**ALWAYS use:**
- ✅ **Laravel Folio** (file-based routing) - automatico da file in `resources/views/pages/`
- ✅ **CMS-Driven Pages** (JSON files in `config/local/laravelpizza/database/content/pages/`)
- ✅ **Volt in Folio** per componenti dinamici

**NEVER use:**
- ❌ **Controllers** - Non esistono nel frontoffice!
- ❌ **Route::** in web.php - Le pagine sono gestite da Folio/JSON
- ❌ **Route::** in api.php - Solo API endpoints, non pagine web
- ❌ **Named routes con route()** - Folio genera URL automaticamente

**Come funziona Folio:**
- Pagina in `resources/views/pages/about.blade.php` → URL `/about`
- Pagina in `resources/views/pages/[slug].blade.php` → URL `/{slug}`
- CMS page in `config/local/.../pages/home.json` → renderizzata dal componente

**Per i link nel frontend:**
```blade
{{-- CORRETTO - Folio genera automaticamente --}}
<a href="{{ url('/dashboard') }}">
<a href="{{ LaravelLocalization::localizeUrl('/events') }}">

{{-- SBAGLIATO - Non usare route() nel frontoffice! --}}
<a href="{{ route('dashboard') }}">  {{-- NO! --}}
```

### URL Localization in Alpine.js Components (CRITICAL!)

When using Alpine.js to render dynamic content (e.g., event lists), ALWAYS use the pre-computed localized URL from the data:

```blade
{{-- WRONG - Missing locale prefix --}}
<a :href="'/events/' + event.slug">  {{-- Results in /events/slug! --}}

{{-- CORRECT - Use pre-computed URL from model --}}
<a :href="event.url">  {{-- event.url already contains /it/events/slug --}}
```

The `toBlockArray()` method in models should generate localized URLs:
```php
// In Event model
'url' => LaravelLocalization::localizeUrl('/events/'.$this->slug),
```

### Backend (Admin) - Filament Only
- All admin resources extend XotBase classes
- NO raw Filament extensions

### XotBaseListRecords - CRITICAL RULE

When creating List pages that extend XotBaseListRecords:

**✅ REQUIRED: Implement getTableColumns()**
```php
class ListEvents extends XotBaseListRecords
{
    protected static string $resource = EventResource::class;

    // ✅ REQUIRED - Must be public with #[Override]
    #[Override]
    public function getTableColumns(): array
    {
        return [
            'title' => TextColumn::make('title')->searchable(),
            // ... more columns
        ];
    }
}
```

**❌ WRONG - Missing getTableColumns()**
```php
class ListEvents extends XotBaseListRecords
{
    // ❌ WRONG - Will fail without getTableColumns()
}
```

**Other common methods:**
- `getTableFilters()` - Use #[Override] attribute (must be public)
- `getHeaderActions()` - Use #[Override] attribute (must be public)
- `getHeaderWidgets()` - Add stats/chart widgets
- `getDefaultTableSortColumn()` - Default sort column
- `getDefaultTableSortDirection()` - Default sort direction (asc/desc)

### ⚠️ CRITICAL RULE: Always Use Filament Widgets, NOT Livewire Pure!

For ANY dynamic component that needs server interaction (forms, dropdowns, modals, etc.):
- **✅ ALWAYS use Filament Widgets** in `Modules/ModuleName/app/Filament/Widgets/`
- **❌ NEVER use pure Livewire components** (except for Volt in Folio pages)

### Registration Validation Rules
When implementing user registration:
- ALWAYS validate email uniqueness BEFORE hitting the database
- Use Laravel Validator with `unique:table,column` rule
- Throw `ValidationException` with clear error messages
- Example:
```php
if ($userModel->on('user')->where('email', $email)->exists()) {
    throw ValidationException::withMessages([
        'email' => [__('validation.unique', ['attribute' => 'email'])],
    ]);
}
```

**When you need interactivity:**
- Create a **Filament Widget** (extends XotBaseWidget)
- NOT a Livewire component

**Example - User Dropdown:**
- ✅ CORRECT: `Modules/Meetup/app/Filament/Widgets/UserDropdownWidget.php`
- ❌ WRONG: `Modules/Meetup/app/Http/Livewire/UserDropdown.php`

**For Alpine.js only interactivity (no server calls):**
- Plain Blade + Alpine.js is OK for UI-only interactions
- But for anything needing data/auth, use Filament Widget

### Module Structure
```
Modules/{ModuleName}/
├── app/
│   ├── Actions/       # Spatie QueueableAction (NO constructor DI!)
│   ├── Datas/         # Spatie Data DTOs
│   ├── Filament/      # Admin resources (extend XotBase)
│   ├── Models/        # Eloquent models (extend BaseModel)
│   └── Services/      # (AVOID - use Actions instead)
├── database/migrations/
├── docs/
├── tests/
└── composer.json
```

**⚠️ IMPORTANT: Actions - NO constructor DI!**
```php
// ❌ WRONG - Don't use constructor DI
public function __construct(
    private readonly SomeAction $someAction,
) {}

// ✅ CORRECT - Use app() to resolve actions
app(SomeAction::class)->execute($data);

// ❌ WRONG - Don't call custom methods
app(CreateClientAction::class)->createPersonalAccessClient();

// ✅ CORRECT - Always call execute() directly
app(CreateClientAction::class)->execute($data);
```

### Service Provider Pattern (MINIMAL!)
```php
// CORRECT - Minimal
class MeetupServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Meetup';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
}
```

### Many-to-Many Relationships
**ALWAYS use `belongsToManyX()`** (NOT `belongsToMany()`)
```php
// CORRECT
$this->belongsToManyX(EventPerformer::class);

// WRONG
$this->belongsToMany(EventPerformer::class);
```

### Localization URLs
```php
// CORRECT
LaravelLocalization::localizeUrl('/path')
LaravelLocalization::getLocalizedURL($locale, null, [], true)

// WRONG
url('/en/path')
```

---

