# Header Navigation - Sistema di Autenticazione

## Panoramica

Il sistema di autenticazione nella header navigation del tema Two è implementato tramite un componente Blade riutilizzabile che mostra automaticamente:
- **Ospiti (guest)**: Pulsante di login
- **Utenti autenticati**: Menu dropdown con profilo, dashboard e logout

## Struttura

### Componente Auth Button

**File**: `Modules/User/resources/views/components/ui/app/auth-button.blade.php`

```blade
@auth
    {{-- Utente autenticato: mostra dropdown con opzioni --}}
    <div class="it-header-slim-right-zone">
        <div class="nav-item dropdown">
            <button ...>
                <span>{{ $user->name }}</span>
            </button>
            <div class="dropdown-menu">
                <a href="{{ route('profile') }}">Profilo</a>
                @can('access-admin')
                    <a href="{{ route('filament.pages.dashboard') }}">Dashboard</a>
                @endcan
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Esci</button>
                </form>
            </div>
        </div>
    </div>
@else
    {{-- Ospite: mostra pulsante login --}}
    <a href="{{ route('login') }}" ...>
        {{ __('user::auth.auth_button.personal_area') }}
    </a>
@endauth
```

### Integrazione nella Header

**File**: `Themes/Two/resources/views/components/sections/header_bi5.blade.php`

```blade
@include('user::components.ui.app.auth-button')
```

## Route

- **Login**: `route('login')` → `/it/auth/login` (Folio)
- **Logout**: `route('logout')` → POST `/logout`
- **Profile**: `route('profile')` → `/it/profile`

## Traduzioni

**File**: `Modules/User/lang/it/auth.php`

```php
'auth_button' => [
    'login' => 'Accedi',
    'logout' => 'Esci',
    'profile' => 'Il mio profilo',
    'dashboard' => 'Dashboard',
    'personal_area' => 'Accedi all\'area personale',
],
```

## Flusso

1. L'utente visita la homepage
2. La header include `user::components.ui.app.auth-button`
3. Il componente verifica `auth()->user()`
4. Se autenticato → mostra dropdown con profilo
5. Se ospite → mostra pulsante "Accedi all'area personale"

## Note

- Il componente usa la route 'login' che è configurata in `web_tall.php` (Folio)
- La condizione `register_pub_theme` in `config/xot.php` determina se usare Folio o redirect admin
- WCAG: Il pulsante ha `data-element="personal-area-login"` per analytics
