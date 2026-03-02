# Translation Architecture - Filament Navigation Best Practices

> **Generated**: [DATE]
> **Philosophy**: Direct Translation vs Translation Keys
> **Scope**: All Modules Translations

---

## 🔥 The Internal Debate: Translation Key vs Direct Translation

### The Problem Discovered

Found 2 files with incorrect navigation translation pattern:
- `Modules/Employee/lang/it/time_entries.php`
- `Modules/Notify/lang/it/test_smtp.php`

Both had translation **keys** instead of **actual translations**:

```php
// ❌ WRONG - Translation key instead of actual translation
'navigation' => [
    'group' => 'time entries.navigation',  // Key, not translation!
],
```

### The Debate Positions

#### Position A - "The Lazy Copier"
"Just copy the pattern from other files. If it's the key name, that's fine - Laravel will resolve it."

**Criticism**: Wrong! The `navigation` array expects direct translations, NOT translation keys.

#### Position B - "The Over-Engineer"
"Create a complex helper to auto-resolve keys to translations!"

**Criticism**: Over-complicated. The pattern is simple - just use direct translations.

#### Position C - "The Filament Best Practices" ✅ **WINNER**

"The `navigation` array in translation files expects **DIRECT translations**, not keys. This is Filament's convention across ALL modules."

**Why it wins**:
1. **Consistency**: All other 99% of translations use direct values
2. **Clarity**: Immediate understanding - no key resolution needed
3. **Filament Convention**: Official pattern from Filament documentation
4. **Maintainability**: Easier to read and modify

---

## 📋 Correct Translation Pattern

### Navigation Array Structure

```php
<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Display Label',           // ✅ Direct Italian translation
        'group' => 'Group Name',              // ✅ Direct Italian translation
        'icon' => 'heroicon-o-icon-name',     // ✅ Icon identifier (Heroicon or custom)
        'sort' => 50,                         // ✅ Sort order (integer)
        'description' => 'Optional description', // ✅ Optional description
    ],
    // ... other keys
];
```

### Real Examples from Codebase

#### ✅ Example 1: User Module - OAuth Client

```php
// Modules/User/lang/it/oauth_client.php
return [
    'navigation' => [
        'label' => 'OAuth Clients',           // ✅ Direct translation
        'group' => 'API',                     // ✅ Direct group name
        'icon' => 'heroicon-o-key',           // ✅ Heroicon
        'sort' => 89,
    ],
];
```

#### ✅ Example 2: Employee Module - Work Hour

```php
// Modules/Employee/lang/it/work_hour.php
return [
    'navigation' => [
        'label' => 'Ore di Lavoro',           // ✅ Italian translation
        'group' => 'Gestione Dipendenti',     // ✅ Italian group name
        'icon' => 'heroicon-o-clock',         // ✅ Heroicon
        'sort' => 50,
    ],
];
```

#### ✅ Example 3: Notify Module - Channel

```php
// Modules/Notify/lang/it/channel.php
return [
    'navigation' => [
        'label' => 'Canali di Notifica',      // ✅ Italian translation
        'group' => 'Sistema',                 // ✅ Italian group name
        'icon' => 'notify-channel-animated',  // ✅ Custom icon
        'sort' => 47,
        'description' => 'Gestione dei canali...', // ✅ Optional description
    ],
];
```

#### ✅ Example 4: Cms Module - Page (Advanced)

```php
// Modules/Cms/lang/it/page.php
return [
    'navigation' => [
        'name' => 'Pagine',                   // ✅ Name (alternative to label)
        'plural' => 'Pagine',                 // ✅ Plural form
        'label' => 'Pagine',                  // ✅ Label
        'group' => [
            'name' => 'Gestione Contenuti',   // ✅ Nested group structure
            'description' => 'Gestione delle pagine...',
        ],
        'icon' => 'heroicon-o-document',      // ✅ Heroicon
        'sort' => 5,
    ],
];
```

---

## ❌ Anti-Patterns to Avoid

### Anti-Pattern 1: Translation Keys Instead of Values

```php
// ❌ WRONG - These are KEYS, not TRANSLATIONS
'navigation' => [
    'group' => 'time entries.navigation',    // NO! This is a key
    'label' => 'test smtp.navigation',       // NO! This is a key
    'icon' => 'oauth client.navigation',     // NO! This is a key
],
```

### Anti-Pattern 2: English in Italian Translation Files

```php
// ❌ WRONG - Italian file should have Italian translations
// File: lang/it/resource.php
'navigation' => [
    'label' => 'OAuth Clients',  // ❌ Should be 'Client OAuth'
    'group' => 'API',            // ⚠️ OK if it's a proper noun/acronym
],
```

**Note**: Some terms like "API", "OAuth", "SMTP" are acceptable as-is since they're technical acronyms.

### Anti-Pattern 3: Missing Required Fields

```php
// ❌ INCOMPLETE - Missing label
'navigation' => [
    'group' => 'Sistema',
    // Missing 'label' - required field!
    'icon' => 'heroicon-o-cog',
],
```

---

## 🎯 Translation Philosophy

### Core Principles

1. **Direct Values**: `navigation` array uses DIRECT translations
2. **Translation Keys**: Use keys for `fields`, `actions`, `messages` arrays
3. **Consistency**: Follow established patterns from other modules
4. **Language Specific**: Italian files = Italian translations (except technical terms)

### When to Use Translation Keys

```php
return [
    // ✅ Direct values for navigation
    'navigation' => [
        'label' => 'Utenti',
        'group' => 'Gestione',
    ],

    // ✅ Keys for fields (resolved via __('user::fields.name.label'))
    'fields' => [
        'name' => [
            'label' => 'Nome',           // Key path: user::fields.name.label
            'placeholder' => 'Inserisci nome',
        ],
    ],

    // ✅ Keys for actions (resolved via __('user::actions.create'))
    'actions' => [
        'create' => 'Crea Utente',       // Key path: user::actions.create
        'edit' => 'Modifica Utente',
    ],
];
```

### Icon Naming Conventions

```php
// ✅ CORRECT Icon Formats

// 1. Heroicons (most common)
'icon' => 'heroicon-o-user',        // Outline style
'icon' => 'heroicon-s-user',        // Solid style
'icon' => 'heroicon-m-user',        // Mini style

// 2. Custom Icons (via Filament)
'icon' => 'notify-channel-animated',  // Custom registered icon

// 3. Font Awesome (if registered)
'icon' => 'fas-user',                 // Font Awesome Solid

// ❌ WRONG
'icon' => 'user.navigation',          // NO! This is a key
'icon' => 'icon-user',                // NO! Not a valid format
```

---

## 🔍 Debugging Translation Issues

### How to Identify `.navigation` Anti-Pattern

```bash
# Find files with .navigation in translation values
grep -rn "=> '.*\.navigation'" Modules/*/lang --include="*.php"

# Should return ZERO results for a healthy codebase
```

### How to Verify Correct Structure

```bash
# Check navigation structure in translation files
grep -A 5 "'navigation' =>" Modules/User/lang/it/oauth_client.php
```

Expected output:
```php
'navigation' => [
    'label' => 'OAuth Clients',      // ✅ Direct value
    'group' => 'API',                // ✅ Direct value
    'icon' => 'heroicon-o-key',      // ✅ Direct value
    'sort' => 89,
],
```

---

## 📊 Translation File Structure Best Practices

### Complete Structure Template

```php
<?php

declare(strict_types=1);

return [
    // 1. NAVIGATION (Direct values - required)
    'navigation' => [
        'label' => 'Resource Name',
        'group' => 'Group Name',
        'icon' => 'heroicon-o-icon',
        'sort' => 50,
        'description' => 'Optional description',
    ],

    // 2. RESOURCE (Direct values - optional)
    'resource' => [
        'label' => 'Singular Name',
        'plural_label' => 'Plural Name',
        'navigation_label' => 'Navigation Label',
        'description' => 'Resource description',
    ],

    // 3. FIELDS (Nested structure - translation keys)
    'fields' => [
        'field_name' => [
            'label' => 'Field Label',
            'placeholder' => 'Placeholder text',
            'help' => 'Help text',
            'tooltip' => 'Tooltip text',
            'description' => 'Description',
        ],
    ],

    // 4. ACTIONS (Nested structure - translation keys)
    'actions' => [
        'create' => 'Create Action',
        'edit' => 'Edit Action',
        'delete' => 'Delete Action',
    ],

    // 5. MESSAGES (Nested structure - translation keys)
    'messages' => [
        'created' => 'Created successfully',
        'updated' => 'Updated successfully',
        'deleted' => 'Deleted successfully',
    ],

    // 6. VALIDATION (Nested structure - translation keys)
    'validation' => [
        'required' => 'Field is required',
        'unique' => 'Value must be unique',
    ],
];
```

---

## ✅ Checklist for Translation Files

- [ ] `navigation.label` uses DIRECT translation (not a key)
- [ ] `navigation.group` uses DIRECT translation (not a key)
- [ ] `navigation.icon` uses valid icon identifier (heroicon or custom)
- [ ] `navigation.sort` is an integer
- [ ] Language-specific translations (IT file = Italian, EN file = English)
- [ ] Technical acronyms (API, OAuth, SMTP) left as-is
- [ ] Consistent with other modules in the same group
- [ ] No `.navigation` suffix in any values
- [ ] Icon follows naming convention (heroicon-o-*, heroicon-s-*, etc.)

---

## 🧪 Testing Translations

### Manual Verification

1. Access Filament resource in browser
2. Check navigation menu:
   - Label appears correctly
   - Group name is correct
   - Icon displays properly
   - Sort order is logical

### Automated Testing

```bash
# Run PHPStan to check translation file structure
./vendor/bin/phpstan analyse Modules/*/lang

# Run Pint to format translation files
./vendor/bin/pint Modules/*/lang
```

---

## 📚 Related Documentation

- [Filament Navigation Official Docs](https://filamentphp.com/docs/panels/navigation)
- [Laravel Localization](https://laravel.com/docs/localization)
- [Heroicons](https://heroicons.com/)

---

## 🎓 Key Takeaways

1. **`navigation` array = DIRECT translations**
2. **`fields`/`actions`/`messages` = Translation keys**
3. **Icons = Identifiers (heroicon-o-*, not keys)**
4. **Consistency across modules is critical**
5. **`.navigation` suffix = ALWAYS WRONG in values**

---

**Conclusion**: The `navigation` array in Filament translation files expects direct translations, NOT translation keys. This is a Filament convention followed across 99% of the codebase. The `.navigation` anti-pattern must be eliminated for consistency, clarity, and proper functionality.
