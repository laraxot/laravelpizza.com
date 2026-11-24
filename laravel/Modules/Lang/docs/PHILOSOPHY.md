---
tags: [documentation]
created: 2026-09-26
qmd: "PHILOSOPHY"
issues: []
discussions: []
title: "Lang Module Philosophy"
module: "Lang"
type: "philosophy"
version: "1.0"
updated: "2026-09-06"
status: "stable"
---

# Lang Module: A Philosophy of Localization

> **The Essence**: Italiano in UI, English in code. Structured keys, zero hardcoded labels in Filament, unified translations across 20 modular subsystems.

---

## RELIGIONE (i18n Dogmas)

The Lang module enshrines five immutable principles:

### 1. The PHP File Hierarchy is Sacred

Translations live in **native PHP arrays**, not databases, not JSON. Why?

- **Immutability by revision control**: Changes to translations are Git-tracked, audited, versioned.
- **Structure scales**: Nested keys allow context — `patient.profile.name.label` is unambiguous across modules.
- **Performance**: No database round-trips. Artisan can validate file syntax before deploy.
- **Simplicity**: A translator receives `/lang/en/patient.php`, edits values, returns it. No UI needed.

**Dogma**: Each module owns its `/lang/{locale}/` directory. Central sync ensures no island translations.

### 2. Three Sacred Languages

- **it**: Italian. The default, the homeland, the lingua franca of the UI.
- **en**: English. The lingua of code comments, error logs, developer docs, fallback.
- **de**: German. The proof that the system scales beyond 2 languages.

Exactly three. No more. No less. Locales are not a kitchen sink.

### 3. Fallback Chain is Law

```
User requests 'de' → German file found? YES → return German
User requests 'de' → German file found? NO → fallback to 'en' → English file found? YES → return English
User requests 'de' → German file found? NO → English file found? NO → return KEY (last resort)
```

**Dogma**: Never return untranslated keys to users in production. Either translate completely or fallback gracefully.

### 4. Filament Labels Resolve Automatically

The **LangServiceProvider** intercepts component `make('field_name')` and resolves:

```
TextInput::make('email')
  → looks for: it/user::field.email.label
  → looks for: it/user::field.email (shorthand fallback)
  → looks for: it/field.email.label (global)
  → returns: TextInput with label auto-set
```

No `->label('Email')` cluttering component definitions. **Write once, translate once.**

### 5. Missing Keys Are Recorded, Not Ignored

When a key is requested but not found, the **TranslatorAdapter** catches it, logs it to the database via **RecordMissingTranslationAction**, and proceeds with fallback. This creates a living audit trail of what remains untranslated.

---

## FILOSOFIA (Why Lang Exists)

### The Problem Lang Solves

In a 20-module Laravel platform:

- **FixCity**: admin, geo, survey, communication, analytics, reports, settings — each with their own UI.
- **Without Lang**: Each module hardcodes labels in Blade/Filament. Translators receive Blade files. Nightmarish.
- **With Lang**: Each module contributes `/lang/it/module.php`. Translators work with PHP arrays. Sync ensures consistency.

### Why Not Native Laravel Localization?

Laravel's default localization (`resources/lang/`) is:

- **Centralized to the core app**, not module-aware.
- **Weak on structure**: `trans('messages.welcome')` doesn't scale to 500+ keys per module.
- **Silent on fallback**: Returns the key if missing, cluttering UI.
- **Not Filament-integrated**: Filament components require explicit labels.

**Lang improves by**:

1. **Module ownership**: Each module manages its translations. No central bottleneck.
2. **Hierarchical keys**: `patient.profile.name.label` is self-documenting.
3. **Audited missing keys**: Missing translations are tracked and reported.
4. **Filament hooks**: Labels auto-resolve from files, not hardcoded.
5. **File sync**: Keeps all languages in sync structurally, even if translation lags.

### The Architecture Insight

Lang is a **facade over Laravel's translator**, not a replacement. It:

- Extends `Illuminate\Translation\Translator` via **TranslatorAdapter**.
- Respects Laravel's fallback chain but adds **database audit trail**.
- Works alongside **Spatie Translatable** for model-level multi-language attributes.

Two layers:

| Layer | Tool | Use Case |
|-------|------|----------|
| **UI/System Strings** | Lang (PHP files) | "Save", "Delete", validation messages, page titles |
| **Model Attributes** | Spatie Translatable + HasTranslations | Survey title (translatable in DB), product description, patient notes |

---

## POLITICA (Supported Languages & RTL Handling)

### Configured Locales

```php
'available_locales' => ['it', 'en', 'de'],
'default_locale' => 'it',
'fallback_locale' => 'en',
```

### Language Metadata

| Locale | Name | Native | Direction | Status |
|--------|------|--------|-----------|--------|
| `it` | Italiano | Italiano | LTR | Default, complete |
| `en` | English | English | LTR | Fallback, complete |
| `de` | Deutsch | Deutsch | LTR | Complete |

### RTL Support (Future)

The architecture **prepares for RTL** (e.g., Arabic, Hebrew):

- **No hardcoded `dir="ltr"`** in UI. Direction resolves from config.
- **Flag component** (`app/View/Components/Flag.php`) is locale-aware.
- **Config structure** allows per-locale metadata (not yet enabled).

**Current state**: LTR only. RTL requires:

1. Additional locales in config: `ar`, `he`.
2. Direction metadata per locale.
3. CSS alignment flips (Tailwind handles this).
4. Testing with native speakers.

---

## SCOPO (Purpose in FixCity)

The Lang module exists to serve a **20+ module healthcare platform** where:

- **Users in Italy, Germany, Austria** expect Italian, English, German UI.
- **Admin screens** (Filament) need consistent, professional labeling across all modules.
- **API responses** return localized validation messages, notifications, errors.
- **Reports, surveys, patient communications** are fully translatable.
- **Changelog, audit logs** stay in English for developer access.

**Specific FixCity responsibilities**:

1. **Quaeris integration**: Survey titles, chart labels, question translations.
2. **CMS integration**: Page content, menu titles, rich text descriptions.
3. **Email/Notification templates**: Multi-language messages, dynamic placeholders.
4. **Form validation**: 50+ validation rules, each translated to 3 languages.
5. **Admin UI**: 200+ Filament fields auto-labeled from translation files.

---

## ZEN (The Essence)

```
Italiano in UI. English in code.
```

This is the whole philosophy compressed:

- **End-user sees Italian**. Everything in the UI is Italian-first.
- **Developers write English**. Comments, variable names, docstrings, keys are in English.
- **Translators work once per release**. They receive PHP files, edit values, submit.
- **Scale is automatic**. Add a field, add a key, run sync, field is available in all 3 languages.

The system trusts that:

1. **Structure beats configuration**. A well-named key (`patient.profile.email.label`) is clearer than a dropdown menu.
2. **Files beat databases**. Translations are code, not user data. Git tracks them.
3. **Consistency beats flexibility**. All modules follow the same naming convention. Developers know where to look.

---

## LIBRERIE DA INSTALLARE (Dependencies)

### Required

1. **spatie/laravel-translatable** (v6.8+)
   - Model-level multi-language attribute storage.
   - Used by `HasStrictTranslations` trait.
   - Stores JSON in database columns: `title` becomes `{"it": "...", "en": "..."}`.

2. **spatie/laravel-queueable-action** (v3.0+)
   - Queues long-running translation operations.
   - Used by `SyncTranslationsAction`, `PublishTranslationAction`.
   - Decouples translation sync from HTTP request cycle.

### Optional (Future)

1. **google/cloud-translate** (v1.15+)
   - Auto-translation via Google Translate API.
   - Config flag: `auto_translate.enabled = false` (not yet enabled).
   - When enabled: `SyncTranslationsAction` auto-fills missing target languages.

2. **locale/helper** (custom)
   - Language detection from Accept-Language header, User-Agent, geolocation.
   - **Not yet bundled**. Future middleware: `SetLocaleFromRequest`.

3. **phpstan/phpstan** (v1.10+, dev-only)
   - Validates type coverage on Translation model.
   - Config: `paramTypeCoverage` level 100% for Lang module (current: 85%).

### Bundled (in packages/ folder)

1. **lara-zeus/spatie-translatable**
   - Filament integration for Spatie Translatable.
   - Provides form component: `TranslationEditor`.
   - Lives in `Modules/Lang/packages/lara-zeus/spatie-translatable/`.

---

## FUTURE IMPLEMENTAZIONI (Planned Features)

Based on config structure, these are roadmapped:

### 1. Auto-Translation Service

```php
'auto_translate' => [
    'enabled' => false,
    'provider' => 'google',
    'api_key' => null,
    'fallback_chain' => [
        'it' => ['en', 'de'],
        'de' => ['en', 'it'],
        'en' => ['it', 'de'],
    ],
    'quality_check' => true,
],
```

When enabled:

- New keys in Italian auto-translate to EN/DE via Google Translate API.
- Quality check runs: word count must stay within ±30% of source.
- Flagged for human review if quality suspect.

**Timeline**: Q4 2026 (pending API budget approval).

### 2. Advanced Missing Key Detection

Current: Keys are logged when requested but not found.

Planned:

- Artisan command: `php artisan lang:audit --module=Quaeris --threshold=90`
- Report: "Module Quaeris has 87% translation coverage. Missing: 15 keys in German."
- Dashboard widget in Filament showing coverage per module per language.

**Timeline**: Q3 2026.

### 3. Translation Memory / Glossary

Store a glossary of recurring terms (`patient_id`, `appointment`, `status`):

```php
$glossary = [
    'patient_id' => [
        'it' => 'ID Paziente',
        'en' => 'Patient ID',
        'de' => 'Patienten-ID',
    ],
];
```

Translator consults glossary before translating new strings. Ensures `patient_id` is always translated the same way, never as `paziente_numero` or `patient_numero`.

**Timeline**: Q2 2027.

### 4. RTL Support (Arabic, Hebrew, Farsi)

- Add locales `ar`, `he`, `fa` to config.
- Metadata: `'direction' => 'rtl'`.
- UI flips via Tailwind's `dir="rtl"` attribute.
- Validation messages adapt (e.g., date format).

**Timeline**: 2027 (pending business requirement).

### 5. Multi-Workspace Translations

Per-workspace language overrides:

```php
Workspace::find(1)->setSetting('language', 'de');
// This workspace sees all translations in German, ignoring user locale.
```

**Timeline**: Pending organization/multi-tenancy feature (roadmap TBD).

---

## COMPETITORS & INSPIRATIONS

### Spatie Translatable

**What it does**: Model-level multi-language attributes stored as JSON columns.

**Overlap**: None. Lang handles *UI strings*; Spatie handles *model data*.

**Lesson learned**: Separation of concerns is elegant. Don't conflate string translations with content translations.

### Laravel's Native Localization (`resources/lang/`)

**What it does**: File-based translations, centralized in the app, simple and proven.

**Why Lang extends it**: 

- Laravel localization is monolithic. Lang is modular (each module owns `/lang/`).
- Laravel doesn't audit missing keys. Lang does (via database logging).
- Laravel requires explicit Filament labels. Lang auto-resolves them.

**Lesson learned**: Don't replace, extend. `TranslatorAdapter` inherits from Laravel's `Translator`.

### Gettext (`.po` / `.pot` files)

**What it does**: Standard translation format, supported by professional translation tools.

**Why Lang doesn't use it**:

- Gettext is verbose. A single translated string generates multiple lines in `.po`.
- Gettext is compiled (`.mo` files). Requires build step.
- PHP arrays are simpler, faster, and version-control-friendly.

**Lesson learned**: Simplicity over standards. PHP arrays are good enough and understood by all Laravel developers.

### i18next (JavaScript)

**What it does**: Client-side i18n for single-page apps, JSON-based, with namespaces and nesting.

**How Lang differs**:

- i18next is **client-heavy**. Translations are bundled with JS.
- Lang is **server-heavy**. Translator resolves on the server, sends rendered HTML.
- i18next is **JSON-native**. Lang is **PHP-native**.

**Lesson learned**: Server-side translation is simpler for server-rendered apps (Laravel Blade + Filament). Avoids exposing translation keys to users.

---

## BEST PRACTICES

### 1. Namespace by Module

Each module owns its namespace:

```php
// Modules/Patient/lang/it/patient.php
return [
    'profile' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci nome',
            'help' => 'Nome completo del paziente',
        ],
    ],
];
```

Access: `__('patient::patient.profile.name.label')`.

**Why**: Avoids collisions. `patient.php` in module Patient is unambiguous.

### 2. Expand Keys for UI Components

Every Filament/Livewire component needs 3 keys: label, placeholder, help text.

```php
'field' => [
    '{field_name}' => [
        'label' => '...',
        'placeholder' => '...',
        'help' => '...',
    ],
],
```

The **AutoLabelAction** in Filament reads these automatically:

```php
TextInput::make('name')
  // Filament resolves: it/patient::field.name.label, placeholder, help
  // Result: TextInput is fully localized
```

### 3. Sync Before Deploy

Run before each release:

```bash
php artisan lang:sync --module=Patient --source=it --target=en,de
```

This ensures:

- All keys in Italian exist in English/German (even if empty).
- No orphaned keys.
- Consistent structure across languages.

### 4. Test Translations

Write tests for untranslated keys:

```php
test('patient module has all keys in german', function () {
    $de = include base_path('Modules/Patient/lang/de/patient.php');
    $it = include base_path('Modules/Patient/lang/it/patient.php');
    
    expect(count($de))->toBe(count($it));
});
```

Prevents silent partial translations.

### 5. Use Validation Messages from Files

Never hardcode validation messages:

```php
// WRONG
->rule('required', __('Obbligatorio'))

// RIGHT
->rule('required') // Resolves from lang/it/validation.php
```

Validation rules are language-agnostic. Let the translator handle the message.

### 6. Pluralization via trans_choice()

For counts:

```php
// lang/it/messages.php
return [
    'messages' => '{0} Nessun messaggio|{1} Un messaggio|[2,*] :count messaggi',
];

// In Blade
{{ trans_choice('messages.messages', $count) }}
// Output (count=0): "Nessun messaggio"
// Output (count=1): "Un messaggio"
// Output (count=5): "5 messaggi"
```

**Why**: Pluralization rules vary by language. English: `{1} item` vs `{2,*} items`. Italian: `{0} elementi|{1} elemento|[2,*] elementi`. Store the rule, not hardcoded conditions.

### 7. Comment Keys for Translators

```php
// File: lang/it/patient.php
return [
    'profile' => [
        'name' => [
            // Translator note: This is the patient's full legal name.
            // Max 100 chars. Used on ID card, reports.
            'label' => 'Nome Completo',
        ],
    ],
];
```

**Why**: Translators need context. A comment in the source file saves back-and-forth emails.

### 8. Lazy-Load Large Translation Files

For modules with 500+ keys:

```php
// Instead of loading all 500 keys:
$all = trans('patient');

// Load a subset:
$profile = trans('patient.profile');
```

Config enables `'lazy_loading' => true`. Only requested groups are loaded.

---

## BAD PRACTICES (Anti-Patterns)

### 1. Hardcoded Labels in Blade

```blade
<!-- WRONG -->
<label>{{ 'Email' }}</label>

<!-- RIGHT -->
<label>{{ __('patient::field.email.label') }}</label>
```

Hardcoded strings are invisible to translators. They slip into production untranslated.

### 2. Translation Keys That Change

```php
// WRONG: Key changes per release
'label_' . date('Y') => 'Label for Year ' . date('Y')

// RIGHT: Key is stable
'annual_label' => 'Annual Report Label'
```

Changing keys breaks existing translations. Keys are contracts.

### 3. Storing Translations in Database for System UI

```php
// WRONG
Translation::create([
    'key' => 'welcome_message',
    'locale' => 'it',
    'value' => 'Benvenuto',
]);

// RIGHT: Store in lang/it/messages.php
return [
    'welcome_message' => 'Benvenuto',
];
```

Database translations should be for **user-generated content** (posts, surveys), not **system UI** (buttons, labels). System UI is code.

### 4. Missing Fallback

```php
// WRONG: No fallback
$text = trans('patient.profile.title', [], 'de', false);
// Returns key if missing: "patient.profile.title" (visible to user, ugly)

// RIGHT: With fallback
$text = trans('patient.profile.title', [], 'de', true);
// Returns key if missing, then tries fallback 'en'
```

Always enable fallback. Users shouldn't see keys.

### 5. Mixing Languages in a Single File

```php
// WRONG
return [
    'name' => 'Nome',  // Italian
    'email' => 'Email',  // English (oops)
    'address' => 'Indirizzo',  // Italian
];

// RIGHT: One language per file
// lang/it/patient.php returns Italian
// lang/en/patient.php returns English
```

One language per file. Easy to spot inconsistencies.

### 6. Using Keys as Display Text

```blade
<!-- WRONG -->
{{ __('patient.profile.email.label') }} <!-- Outputs: "patient.profile.email.label" if missing -->

<!-- RIGHT: Always verify key exists -->
{{ __('patient.profile.email.label') ?? 'Email' }}
```

The `??` fallback is a safety net. Prevents ugly key-dumps in UI.

### 7. Not Syncing Before Translating

```bash
# WRONG: Translate without knowing what keys exist
translator$ nano lang/en/patient.php
translator$ (edits 10 keys, misses 5 new keys added yesterday)

# RIGHT: Sync first
admin$ php artisan lang:sync --module=Patient --source=en --target=de
translator$ nano lang/de/patient.php
translator$ (all keys are present, can't miss any)
```

Sync ensures translator works on a complete, consistent set.

---

## FALSE FRIENDS (Easy Mistakes)

### 1. Locale vs Language

| Term | Meaning | Example |
|------|---------|---------|
| **Locale** | Language + regional variant | `it_IT`, `en_US`, `de_AT` |
| **Language** | Just the language code | `it`, `en`, `de` |

**Lang uses**: Language codes only (`it`, `en`, `de`). No regional variants.

**Mistake**: Calling `setLocale()` with `it_IT` when code expects `it`.

**Fix**: In Lang, always use 2-letter codes.

### 2. Translation vs Localization

| Term | Meaning |
|------|---------|
| **Translation** | Converting text from one language to another |
| **Localization (L10n)** | Adapting UI, date/time format, currency, RTL, etc. for a region |

**Lang does**: Both. It translates strings AND provides hooks for locale-specific formatting (date/time, currency).

**Mistake**: Thinking Lang only handles text translation. It also handles cultural adaptation (via config).

### 3. Pluralization vs Plurals

| Term | Meaning |
|------|---------|
| **Pluralization rule** | Logic: how many forms? (English: 2; Polish: 4) |
| **Plural form** | The actual string (e.g., "1 item" vs "2 items") |

**Lang uses**: CLDR (Common Locale Data Repository) pluralization rules. English has 2 forms; Italian also has 2 forms; German has 2 forms.

**Mistake**: Thinking English plural logic works everywhere. Polish has: zero, one, few, many, other (5 forms).

**Fix**: Don't hardcode plural logic. Use `trans_choice()` and let Laravel handle CLDR rules.

### 4. Timezone vs Language

| Concept | Handled By |
|---------|------------|
| **Timezone** (e.g., UTC, CET, PST) | Laravel config, middleware, User model |
| **Language/Locale** (e.g., it, en) | Lang module |

**Mistake**: Setting timezone in the locale config. They're orthogonal.

```php
// WRONG
'timezone' => 'Europe/Rome',  // In lang.php config

// RIGHT
// lang.php handles languages
// app.php handles timezone
'timezone' => 'Europe/Rome',  // In config/app.php
```

### 5. Translation Files vs Translation Models

| Type | Storage | Use Case |
|------|---------|----------|
| **Translation files** (`lang/it/patient.php`) | Filesystem, versioned | System UI: buttons, labels, validation messages |
| **Translation models** (`Translation` Eloquent model) | Database, user-managed | User content: posts, surveys, reports (via Spatie Translatable) |

**Mistake**: Using the `Translation` model for UI strings.

**Fix**: UI strings live in files. Content lives in the database.

---

## COME USARLO (Usage Guide)

### A. Basic Translation in Blade

```blade
<!-- Get a translation -->
<p>{{ __('patient::messages.welcome') }}</p>

<!-- With parameters -->
<p>{{ __('patient::messages.greeting', ['name' => $patient->name]) }}</p>

<!-- Fallback if key missing -->
<p>{{ __('patient::messages.welcome') ?? 'Welcome' }}</p>
```

### B. Translation in Controller / Action

```php
namespace Modules\Patient\Http\Controllers;

class PatientController
{
    public function show(Patient $patient)
    {
        $title = __('patient::patient.profile.title');
        
        return view('patient.show', [
            'title' => $title,
            'patient' => $patient,
        ]);
    }
}
```

### C. Filament Auto-Label (No Hardcoding)

```php
namespace Modules\Patient\Filament\Resources\PatientResource;

use Filament\Forms;

class PatientForm
{
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name'),
                  // Automatically resolves it/patient::field.name.label
                  // No ->label('Nome') needed
                
                Forms\Components\TextInput::make('email'),
                  // Automatically resolves it/patient::field.email.label
                
                Forms\Components\Textarea::make('notes'),
                  // Automatically resolves it/patient::field.notes.label
            ]);
    }
}
```

### D. Using with Spatie Translatable (Model Attributes)

```php
namespace Modules\Survey\Models;

use Spatie\Translatable\HasTranslations;

class Survey extends BaseModel
{
    use HasTranslations;
    
    public array $translatable = ['title', 'description'];
}

// Usage
$survey = Survey::find(1);
$survey->setTranslation('title', 'it', 'Questionario Soddisfazione');
$survey->setTranslation('title', 'en', 'Satisfaction Survey');
$survey->setTranslation('title', 'de', 'Zufriedenheitsumfrage');
$survey->save();

// Retrieve
echo $survey->getTranslation('title', 'de');  // 'Zufriedenheitsumfrage'
```

### E. Syncing Translations Across Modules

```bash
# Sync Patient module: ensure all keys exist in EN and DE (source is IT)
php artisan lang:sync --module=Patient --source=it --target=en,de

# Sync all modules at once
php artisan lang:sync

# Sync with specific target language
php artisan lang:sync --module=Quaeris --target=de
```

### F. Validating Translation Completeness

```bash
# Check Patient module: all keys translated?
php artisan lang:validate --module=Patient

# Check all modules
php artisan lang:validate --all

# Report coverage percentage
php artisan lang:coverage
```

### G. Recording Missing Translations Manually

```php
use Modules\Lang\Actions\Translation\RecordMissingTranslationAction;

app(RecordMissingTranslationAction::class)->execute(
    key: 'patient::patient.profile.age.label',
    locale: 'it',
);
// This logs the missing key to the database for later translation.
```

### H. Fallback Chain in Action

```php
// User is set to German (de)
// But German file doesn't have the key

// Step 1: Look in de/patient.php
$result = trans('patient::patient.profile.title', [], 'de');
// Not found

// Step 2: Fallback to en/patient.php
// Found! Return English version.

// Step 3 (never reached): Return key
```

---

## COME INSTALLARLO (Installation Guide)

### Prerequisites

- Laravel 13+
- PHP 8.3+
- Filament 5 (optional, for admin UI)

### Step 1: Enable the Module

```bash
cd laravel
php artisan module:enable Lang
```

### Step 2: Run Migrations

```bash
php artisan migrate
```

Creates tables:

- `translations` — Record of all translation keys/values
- `translation_files` — File sync metadata
- `language_lines` — Missing key audit trail (optional)

### Step 3: Publish Config (Optional)

```bash
php artisan vendor:publish --provider="Modules\Lang\Providers\LangServiceProvider" --tag="config"
```

Copies config to `config/lang.php` (or edit `Modules/Lang/config/lang.php` directly).

### Step 4: Create Language Files

```bash
# Create structure
mkdir -p Modules/YourModule/lang/{it,en,de}

# Create base file in Italian
cat > Modules/YourModule/lang/it/yourmodule.php << 'EOF'
<?php

declare(strict_types=1);

return [
    'profile' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci nome',
        ],
    ],
];
EOF
```

### Step 5: Sync to Other Languages

```bash
php artisan lang:sync --module=YourModule --source=it --target=en,de
```

Creates `Modules/YourModule/lang/en/yourmodule.php` and `de/yourmodule.php` with same keys (values empty, ready to translate).

### Step 6: Register in Service Provider (If Not Auto-Discovered)

```php
// Modules/YourModule/Providers/YourModuleServiceProvider.php

public function boot()
{
    $this->loadTranslationsFrom(
        base_path('Modules/YourModule/lang'),
        'yourmodule'
    );
}
```

### Step 7: Use in Blade

```blade
<label>{{ __('yourmodule::profile.name.label') }}</label>
<input placeholder="{{ __('yourmodule::profile.name.placeholder') }}" />
```

### Step 8: Filament Auto-Label (If Using Filament)

```php
// No extra setup needed
Forms\Components\TextInput::make('name')
  // Automatically looks for it/yourmodule::field.name.label, etc.
```

### Step 9: Test

```bash
# Check completeness
php artisan lang:validate --module=YourModule

# View coverage
php artisan lang:coverage
```

### Optional: Configure Auto-Translation (Q4 2026)

```php
// config/lang.php
'auto_translate' => [
    'enabled' => true,
    'provider' => 'google',
    'api_key' => env('GOOGLE_TRANSLATE_API_KEY'),
],

// .env
GOOGLE_TRANSLATE_API_KEY=your_api_key_here
```

Then run:

```bash
php artisan lang:auto-translate --module=YourModule
```

---

## COVERAGE ANALYSIS

### Current State

| Metric | Value | Status |
|--------|-------|--------|
| **Modules with Lang** | 20+ | Green |
| **Languages Supported** | 3 (IT/EN/DE) | Green |
| **Translation Completeness** | ~95% (IT), 85% (EN), 80% (DE) | Yellow |
| **Auto-Label Coverage** | 95% of Filament fields | Green |
| **Missing Key Audit** | Active (database logged) | Green |
| **Test Coverage** | 75% (unit + feature) | Yellow |
| **PHPStan Level** | 10 | Green |
| **Type Strictness** | 85% type coverage | Yellow |

### Bottlenecks

1. **German Translation Lag**
   - German translations often fall back to English.
   - Cause: Limited German speakers on team.
   - Fix: Hire translator for ongoing localization.

2. **Missing Keys in Edge Cases**
   - New Filament components sometimes lack label keys.
   - Cause: Developers forget to add keys before launching.
   - Fix: Pre-commit hook checks for missing keys.

3. **Spatie Translatable Type Safety**
   - `HasTranslations` returns `mixed`. PHPStan complains.
   - Cause: Spatie's return types are loose.
   - Fix: Use `HasStrictTranslations` trait (narrows return types).

### Future Metrics (2026-2027)

| Goal | Target | Timeline |
|------|--------|----------|
| Auto-translation API integrated | 100% new keys auto-translated | Q4 2026 |
| Translation memory | 99% consistency (glossary) | Q2 2027 |
| RTL support | 2+ RTL languages | 2027 |
| Type coverage | 100% | Q3 2026 |
| Test coverage | 95% | Q3 2026 |

---

## Summary: The Lang Philosophy Compressed

| Principle | Implementation |
|-----------|-----------------|
| **Dogma: Files are Law** | All translations live in `/lang/{locale}/` PHP arrays, versioned in Git. |
| **Dogma: Three Languages** | IT (default), EN (fallback), DE (proof of scale). No more, no less. |
| **Dogma: Auto-Label Filament** | Components resolve labels automatically. Zero hardcoded labels. |
| **Dogma: Audit Missing Keys** | Missing translations are logged to database, creating a living audit trail. |
| **Dogma: Modular Ownership** | Each module owns its `/lang/` directory. No central bottleneck. |
| **Pattern: Expand Keys** | Every field needs label, placeholder, help. `field.{name}.{type}` structure. |
| **Pattern: Sync Before Deploy** | Run `lang:sync` before each release. Ensures all languages have same structure. |
| **Anti-Pattern: Hardcoded Strings** | Never embed text in Blade/PHP. Always use translation keys. |
| **Anti-Pattern: Mixed Languages** | One language per file. Easy to spot errors. |
| **Tool: Spatie Translatable** | For model attributes (user-generated content), not system UI. |
| **Tool: Fallback Chain** | IT → EN → Key. Ensures users never see untranslated keys. |
| **Tool: File Sync** | `SyncTranslationsAction` keeps all languages in sync structurally. |

---

**Last Updated**: 2026-09-06  
**Module Status**: Stable, production-ready  
**Next Review**: Q4 2026 (post auto-translation release)
