---
title: "Login Page - Design Comuni Italiani Alignment"
type: concept
confidence: high
created: 2026-04-20
updated: 2026-04-20
tags: [login, auth, design-comuni, bootstrap-italia, ui, ux, filament]
sources:
  - https://italia.github.io/design-comuni-pagine-statiche/servizi/index.html
  - laravel/Modules/User/app/Filament/Widgets/Auth/LoginWidget.php
  - laravel/Themes/Sixteen/resources/views/pages/auth/login.blade.php
related:
  - ../../../../docs/wiki/concepts/ui-consistency.md
  - ./widget-filament-pattern.md
---

# Login Page - Design Comuni Italiani Alignment

## The Rule

**Login page MUST follow the Italian Municipalities Design System (Bootstrap Italia) for consistent, accessible public administration UX.**

---

## Architecture Pattern: Template as Wrapper

The login page uses a **separation of concerns** pattern where:

| Layer | Role | Analogy |
|-------|------|---------|
| **Template** (Page) | Presentation wrapper, layout, styling | **Vestito** (clothes) |
| **Widget** | Form logic, validation, submission | **Corpo** (body/form) |

```
URL: http://127.0.0.1:8000/it/auth/login
│
├── Page (Folio Route)
│   └── Themes/Sixteen/resources/views/pages/auth/login.blade.php
│       ├── Header section (title, description)
│       ├── Main content area
│       │   └── @livewire(LoginWidget::class)
│       └── Sidebar (support information)
│
└── Widget (Filament/Livewire)
    └── Modules/User/app/Filament/Widgets/Auth/LoginWidget.php
        └── getFormSchema() → email, password, remember
```

---

## File Structure

### Theme Layer (Presentation)

```
laravel/Themes/Sixteen/
└── resources/views/
    ├── pages/auth/login.blade.php           # Page wrapper
    └── filament/widgets/auth/login.blade.php # Widget view override (optional)
```

### Module Layer (Logic)

```
laravel/Modules/User/
├── app/Filament/Widgets/Auth/LoginWidget.php  # Widget class
└── resources/views/
    └── filament/widgets/auth/login.blade.php  # Default widget view
```

---

## Design Specifications

### Color Palette (Bootstrap Italia)

| Element | Color | Hex |
|---------|-------|-----|
| Primary | Italian Blue | #0066CC |
| Secondary | Gray | #5C6F82 |
| Background | Light Gray | #F5F5F5 |
| Card | White | #FFFFFF |
| Text | Dark | #333333 |
| Error | Red | #D9364F |
| Success | Green | #00CF86 |

### Typography

- **Headings**: Titillium Web (Bootstrap Italia default)
- **Body**: Lora or system fonts
- **Base size**: 16px
- **Login title**: 1.75rem (h3 equivalent)

### Layout

**Desktop (lg:grid-cols-3):**
```
┌─────────────────────────────────────────────────┐
│                                                 │
│              [FIXCITY LOGO]                     │
│                                                 │
│         ┌───────────────────┐ ┌─────────────┐  │
│         │                   │ │  Supporto   │  │
│         │  ACCEDI AL        │ │  accesso    │  │
│         │  PORTALE          │ │             │  │
│         │                   │ │  • Usa      │  │
│         │  [Email     ]     │ │    email    │  │
│         │  [Password  ]     │ │  • Recupero │  │
│         │                   │ │    password │  │
│         │  ☐ Ricordami      │ │  • Contatta │  │
│         │                   │ │    ufficio  │  │
│         │  [  ACCEDI   ]    │ │             │  │
│         │                   │ └─────────────┘  │
│         │  Password         │                  │
│         │  dimenticata?      │                  │
│         └───────────────────┘                  │
│                                                 │
│     Non hai un account? Crea il tuo account    │
│                                                 │
└─────────────────────────────────────────────────┘
```

**Mobile:**
- Single column, stacked layout
- Full-width form card
- Sidebar content below form or hidden

---

## Widget Implementation

```php
<?php

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Auth;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * LoginWidget - Form logic for authentication.
 * 
 * Rules:
 * - Extends XotBaseWidget (never Field directly)
 * - NO ->label(), ->placeholder(), ->helperText()
 * - Translations via LangServiceProvider
 */
class LoginWidget extends XotBaseWidget
{
    protected string $view = 'user::filament.widgets.auth.login';

    public function getFormSchema(): array
    {
        return [
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->autofocus(),
            
            'password' => TextInput::make('password')
                ->password()
                ->revealable()
                ->required(),
            
            'remember' => Checkbox::make('remember'),
        ];
    }

    public function login(): void
    {
        $data = $this->form->getState();
        
        if (Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ], $data['remember'] ?? false)) {
            session()->regenerate();
            redirect()->intended('/');
        }
        
        $this->addError('data.email', __('auth.failed'));
    }

    public function save(): void
    {
        $this->login();
    }
}
```

---

## Template (Page) Implementation

```blade
<x-layouts.app>
    <x-slot name="title">
        {{ __('Accedi ai servizi') }}
    </x-slot>

    <section class="min-h-screen bg-slate-50 py-10 sm:py-14">
        <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <header class="mb-8">
                <p class="text-sm font-semibold tracking-wide text-primary-700 uppercase">
                    {{ __('Area personale') }}
                </p>
                <h1 class="mt-1 text-3xl font-bold text-slate-900">
                    {{ __('Accedi ai servizi online') }}
                </h1>
                <p class="mt-2 max-w-2xl text-sm text-slate-600">
                    {{ __('Inserisci le tue credenziali per continuare...') }}
                </p>
            </header>

            <div class="grid gap-6 lg:grid-cols-3">
                <!-- Main: Login Form Widget -->
                <div class="lg:col-span-2">
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                        @livewire(\Modules\User\Filament\Widgets\Auth\LoginWidget::class)
                    </div>
                </div>

                <!-- Sidebar: Support Info -->
                <aside class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="text-base font-semibold text-slate-900">
                        {{ __('Supporto accesso') }}
                    </h2>
                    <ul class="mt-4 space-y-3 text-sm text-slate-600">
                        <li>{{ __('Usa l\'indirizzo email con cui hai creato l\'account.') }}</li>
                        <li>{{ __('Se non ricordi la password, usa il recupero credenziali.') }}</li>
                        <li>{{ __('Per assistenza contatta l\'ufficio competente.') }}</li>
                    </ul>
                </aside>
            </div>

            <!-- Registration CTA -->
            @if (Route::has('register'))
                <div class="mt-8 rounded-xl border border-primary-200 bg-primary-50 p-4 text-sm text-primary-900">
                    {{ __('Non hai ancora un account?') }}
                    <a href="{{ route('register') }}" class="ml-1 font-semibold underline">
                        {{ __('Crea il tuo account') }}
                    </a>
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
```

---

## Translation Structure

```php
// laravel/Modules/User/lang/it/login_widget.php
return [
    'form' => [
        'email' => [
            'label' => 'Indirizzo email',
            'placeholder' => 'nome@esempio.it',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Inserisci la password',
        ],
        'remember' => [
            'label' => 'Ricordami su questo dispositivo',
        ],
    ],
    'actions' => [
        'login' => 'Accedi',
        'logging_in' => 'Accesso in corso...',
    ],
    'links' => [
        'forgot_password' => 'Password dimenticata?',
        'create_account' => 'Crea il tuo account',
    ],
];
```

---

## Accessibility Checklist

- [ ] Form has `aria-labelledby` pointing to title
- [ ] All inputs have associated `<label>` elements
- [ ] Error messages use `aria-describedby` linkage
- [ ] Focus indicators visible (2px solid outline)
- [ ] Color contrast ≥ 4.5:1 for all text
- [ ] Touch targets minimum 44px height
- [ ] Keyboard navigation fully functional
- [ ] Screen reader announcements for errors

---

## Mobile Considerations

- **Card width**: 100% on mobile (padding: 1rem)
- **Card width**: 400px max on desktop (centered)
- **Touch targets**: min 44px height for inputs and buttons
- **Font size**: 16px minimum (prevents iOS zoom on focus)
- **Layout**: Single column on mobile, sidebar below or accordion

---

## Verification Commands

```bash
# Check LoginWidget extends correct base
grep -n "extends XotBaseWidget" laravel/Modules/User/app/Filament/Widgets/Auth/LoginWidget.php

# Check page includes widget
grep -n "LoginWidget::class" laravel/Themes/Sixteen/resources/views/pages/auth/login.blade.php

# Check translations exist
test -f laravel/Modules/User/lang/it/login_widget.php && echo "IT translations exist"

# Check route exists
php artisan route:list | grep "auth/login"
```

---

## References

- **Design Comuni**: https://italia.github.io/design-comuni-pagine-statiche/
- **Bootstrap Italia**: https://italia.github.io/bootstrap-italia/
- **Widget Base**: `laravel/Modules/Xot/app/Filament/Widgets/XotBaseWidget.php`
- **Filament v5 Forms**: https://filamentphp.com/docs/5.x/forms

---

**Last Updated**: 2026-04-20  
**Rule Owner**: User Module + Sixteen Theme Design System
