---
title: "Translation 5-Level Structure - NEVER Use Full Sentences as Keys"
type: concept
confidence: high
created: 2026-04-20
updated: 2026-04-20
tags: [translation, i18n, localization, user-module, laravel, filament]
sources:
related:
  - "./ai-harness-user-discipline.md"
  - "./baseuser-hierarchy.md"
  - "./code-redundancy-user.md"
  - "./context-mode-user-discipline.md"
  - "./context-overflow-prevention.md"
  - "./filament-langserviceprovider-governance.md"
  - "./filament-widget-linear-crud-model-create.md"
  - "./filament-widget-resource-form-delegation.md"
---

# Translation 5-Level Structure Rule

## The Golden Rule

**NEVER use full sentences or text content as translation keys. ALWAYS use the 5-level structure.**

---

## ❌ WRONG - NEVER DO THIS

```blade
<!-- In theme or module view -->
<p>{{ __('Usa l\'indirizzo email con cui hai creato l\'account.') }}</p>
<p>{{ __('Sign in to your account') }}</p>
<p>{{ __('Enter your credentials to continue') }}</p>

<!-- This is WRONG because: -->
<!-- 1. Full sentence as key -->
<!-- 2. Cannot be reused across themes -->
<!-- 3. Hard to maintain -->
<!-- 4. No structure -->
```

---

## ✅ CORRECT - 5-LEVEL STRUCTURE

### Structure Pattern

```
namespace::context.collection.element.type

Examples:
- user::auth.login.page.support_email.label
- user::auth.login.page.support_email.placeholder
- user::auth.login.page.support_email.help
- user::auth.login.form.email.label
- user::auth.login.form.submit.button
```

### The 5 Levels

| Level | Name | Description | Example |
|-------|------|-------------|---------|
| 1 | **Namespace** | Module name | `user::`, `geo::`, `fixcity::` |
| 2 | **Context** | Feature/section | `auth.`, `profile.`, `settings.` |
| 3 | **Collection** | Group/component | `login.`, `form.`, `page.`, `wizard.` |
| 4 | **Element** | Specific item | `email`, `password`, `submit`, `title` |
| 5 | **Type** | Content type | `label`, `placeholder`, `help`, `button`, `title` |

---

## Implementation Examples

### Blade Template (Theme)

```blade
<!-- Themes/Sixteen/resources/views/pages/auth/login.blade.php -->
<!-- WRONG: {{ __('Usa l\'indirizzo email...') }} -->

<!-- CORRECT: -->
<aside>
    <h2>{{ __('user::auth.login.page.support_title.label') }}</h2>
    <ul>
        <li>{{ __('user::auth.login.page.support_item_email.label') }}</li>
        <li>{{ __('user::auth.login.page.support_item_password.label') }}</li>
        <li>{{ __('user::auth.login.page.support_item_help.label') }}</li>
    </ul>
</aside>
```

### Translation File (Module)

```php
// laravel/Modules/User/lang/it/auth.php
return [
    'login' => [
        'page' => [
            'support_title' => [
                'label' => 'Supporto accesso',
            ],
            'support_item_email' => [
                'label' => 'Usa l\'indirizzo email con cui hai creato l\'account.',
            ],
            'support_item_password' => [
                'label' => 'Se non ricordi la password, usa il recupero credenziali.',
            ],
            'support_item_help' => [
                'label' => 'Per assistenza contatta l\'ufficio competente.',
            ],
        ],
        'form' => [
            'email' => [
                'label' => 'Indirizzo email',
                'placeholder' => 'nome@esempio.it',
                'help' => 'Inserisci l\'email usata in fase di registrazione',
            ],
            'password' => [
                'label' => 'Password',
                'placeholder' => '••••••••',
                'help' => 'Minimo 8 caratteri',
            ],
            'submit' => [
                'button' => 'Accedi',
                'loading' => 'Accesso in corso...',
            ],
        ],
    ],
];
```

### Filament Form (Widget)

```php
// Modules/User/Filament/Widgets/Auth/LoginWidget.php
public function getFormSchema(): array
{
    return [
        'email' => TextInput::make('email')
            // NO ->label() - translations via LangServiceProvider
            ->email()
            ->required(),
        
        'password' => TextInput::make('password')
            ->password()
            ->required(),
    ];
}

// Translation resolved automatically from:
// user::auth.login.form.email.label
// user::auth.login.form.email.placeholder
// user::auth.login.form.password.label
// user::auth.login.form.password.placeholder
```

---

## Directory Structure

```
laravel/Modules/User/
└── lang/
    ├── it/
    │   ├── auth.php          # Login, register, password reset
    │   ├── profile.php       # User profile
    │   ├── socialite.php     # OAuth/social login
    │   └── validation.php    # Custom validation messages
    └── en/
        ├── auth.php
        ├── profile.php
        ├── socialite.php
        └── validation.php
```

---

## Rules Summary

| Rule | Description |
|------|-------------|
| **Location** | ALL translations in `Modules/User/lang/`, NEVER in themes |
| **Structure** | MUST use 5-level: `namespace::context.collection.element.type` |
| **Keys** | NEVER use full sentences, use semantic identifiers |
| **Types** | MUST have at least: `label`, `placeholder`, `help` for form fields |
| **Filament** | NEVER use `->label()` - translations auto-resolved |

---

## Verification Commands

```bash
# Check for wrong translation patterns in themes (full sentences as keys)
grep -r "__\(['\"][A-Z]" laravel/Themes/ || echo "✅ No full-sentence keys found"

# Check for translations outside User module
grep -r "__\(" laravel/Themes/ | grep -v "user::" | head -20

# Check 5-level structure in User module
grep -r "user::auth\..*\..*\..*\." laravel/Modules/User/lang/

# Check no ->label() in Filament forms
grep -r "->label(" laravel/Modules/User/app/Filament/Widgets/ || echo "✅ No hardcoded labels"
```

---

## Migration Guide

### From Wrong Pattern to Correct

```php
// BEFORE (WRONG) - In theme file
{{ __('Usa l\'indirizzo email con cui hai creato l\'account.') }}

// AFTER (CORRECT) - In theme file
{{ __('user::auth.login.page.support_email.label') }}

// AFTER (CORRECT) - In User/lang/it/auth.php
return [
    'login' => [
        'page' => [
            'support_email' => [
                'label' => 'Usa l\'indirizzo email con cui hai creato l\'account.',
            ],
        ],
    ],
];
```

---

## Benefits

1. **DRY**: One translation source for all themes
2. **Maintainability**: Change text in one place
3. **Reusability**: Same keys across themes
4. **Consistency**: Structured naming convention
5. **Filament Integration**: Auto-translation resolution

---

## References

- **Laravel Localization**: https://laravel.com/docs/localization
- **Filament Translations**: https://filamentphp.com/docs/3.x/support/translations
- **LangServiceProvider**: `laravel/Modules/Xot/app/Providers/LangServiceProvider.php`

---

**Last Updated**: 2026-04-20  
**Rule Owner**: User Module Translation System

---

## Incident 2026-07-16: `/it/auth/login` HTTP 500

`Modules/User/lang/it/auth.php` and `en/auth.php` implement the 5th level as
`key/text/description/context/placeholder` records (per
[`bashscripts/ai/wiki/rules/translation-5-elements.md`](../../../../../../bashscripts/ai/wiki/rules/translation-5-elements.md),
label vs text split), which differs from the `label/placeholder/help/button`
shape shown as canonical in this doc. **The actually-deployed lang files use
the `text`/`context`/`description` shape** — this doc's examples above are
aspirational/out of sync with the real `auth.php`, not the other way round.

`login.blade.php` (`Modules/User/resources/views/filament/widgets/auth/login.blade.php`)
called 9 keys at only 4 segments (`user::auth.login.submit`, `.google`,
`.github`, `.microsoft`, `.or_continue_with`, `.forgot_password`, `.logging_in`,
`.no_account`, `.create_account`), each resolving to the full 5-field array
instead of a string, causing `htmlspecialchars(): Argument #1 ($string) must
be of type string, array given` on every request. Also found: `submit`,
`google`, `github`, `microsoft`, `or_continue_with` were still plain strings
in the lang file (not yet converted to the 5-field shape) — converted them
to match their siblings.

**Fix**: appended `.text` to all 9 call sites (matches the 5-elements rule's
label/text distinction — these are all buttons/links/messages, not static
titles). `en/auth.php`'s `login` key never had these keys at all (only a
`login.page.*` subtree with the other doc's `label` shape) — `/en/auth/login`
doesn't crash because a fully-missing key returns the literal key string
(still a string), but shows raw untranslated keys instead of real copy. Not
yet backfilled — tracked as follow-up, out of scope for the 500 fix.

**Two divergent docs describing the same convention is exactly the entropy
this repo keeps flagging** — reconcile `translation-5-elements.md` and this
file into one before writing a third.
