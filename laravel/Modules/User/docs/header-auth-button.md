---
title: "Header Auth Button - User Module"
type: concept
tags: [header, auth, button]
created: 2026-07-14
updated: 2026-07-14
qmd: "header-auth-button header auth button - user module"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
---

# Header Auth Button - User Module

## Overview

Il bottone di autenticazione nell'header deve essere dinamico:
- **Guest**: Mostra bottone "Accedi" che porta alla pagina login
- **Authenticated**: Mostra dropdown con profilo/logout

## Posizione

```
Modules/User/resources/views/components/ui/app/
└── auth-button.blade.php
```

## Struttura Componente

```blade
@php
    $user = auth()->user();
@endphp

@auth
    <div class="it-header-slim-right-zone">
        <div class="nav-item dropdown">
            <button type="button" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="rounded-icon" aria-hidden="true">
                    <svg class="icon icon-primary">
                        <use xlink:href="{{ asset('assets/bootstrap-italia/dist/svg/sprites.svg#it-user') }}"></use>
                    </svg>
                </span>
                <span class="d-none d-lg-block">{{ $user->name ?? $user->email }}</span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <div class="link-list-wrapper">
                    <ul class="link-list">
                        <li>
                            <a class="dropdown-item list-item" href="{{ route('profile') }}">
                                <span>{{ __('user::auth.profile') }}</span>
                            </a>
                        </li>
                        @can('access-admin')
                        <li>
                            <a class="dropdown-item list-item" href="{{ route('filament.pages.dashboard') }}">
                                <span>{{ __('user::auth.dashboard') }}</span>
                            </a>
                        </li>
                        @endcan
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item list-item">
                                    <span>{{ __('user::auth.logout') }}</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@else
    <a class="btn btn-primary btn-icon btn-full" href="{{ route('login') }}" data-element="personal-area-login">
        <span class="rounded-icon" aria-hidden="true">
            <svg class="icon icon-primary">
                <use xlink:href="{{ asset('assets/bootstrap-italia/dist/svg/sprites.svg#it-user') }}"></use>
            </svg>
        </span>
        <span class="d-none d-lg-block">{{ __('user::auth.login') }}</span>
    </a>
@endauth
```

## Traduzioni

Aggiungere in `Modules/User/lang/en/auth.php`:

```php
'auth_button' => [
    'login' => 'Accedi',
    'logout' => 'Esci',
    'profile' => 'Il mio profilo',
    'dashboard' => 'Dashboard',
    'personal_area' => 'Accedi all\'area personale',
],
```

## Integrazione Theme

Includere nel template header:

```blade
@include('user::components.ui.app.auth-button')
```

## Convenzioni

| Aspetto | Regola |
|---------|--------|
| Posizione | `Modules/User/resources/views/components/ui/app/` |
| Naming | `auth-button.blade.php` |
| Traduzioni | `user::auth.auth_button.*` |
| Route login | `route('login')` |
| Route logout | `route('logout')` |
| Route profile | `route('profile')` |

## Riferimenti

- [header-auth-button.md](../../Themes/Two/docs/header-auth-button.md)
- [header-components.md](./header-components.md)
