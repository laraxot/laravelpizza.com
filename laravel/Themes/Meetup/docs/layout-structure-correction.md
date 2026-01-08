# CORREZIONE - Struttura Layout Corretta

## ❌ Errore Fatto

Ho creato una struttura sbagliata con "smart delegation" che non rispetta le convenzioni Laraxot.

### Struttura Sbagliata Implementata
```
layouts/app.blade.php → delega a sidebar o public (SBAGLIATO!)
layouts/public.blade.php → layout con nav/footer
layouts/app/sidebar.blade.php → dashboard
```

## ✅ Struttura Corretta Laraxot

### Layout Types
1. **`layouts.app`** - Layout pubblico COMPLETO
   - Include: `<x-navigation>`, `<x-footer>`
   - Per: Homepage, Events, About, ecc.
   - Utenti: Guest e Authenticated

2. **`layouts.main`** - Layout MINIMALE
   - Include: Solo `<x-metatags>` e `<body>`
   - Senza: Navigation, Footer
   - Per: Landing pages, pagine speciali

3. **`layouts.guest`** - Layout AUTENTICAZIONE
   - Include: Solo form container, minimal branding
   - Per: Login, Register, Forgot Password, Reset Password
   - Utenti: Solo Guest

4. **`layouts.app.sidebar`** - Layout DASHBOARD
   - Include: Sidebar navigation, user menu
   - Per: Dashboard, Admin, User settings
   - Utenti: Solo Authenticated

## Mapping Corretto

| Page Type | Layout | Navigation | Footer | Auth Required |
|-----------|--------|------------|--------|---------------|
| Homepage | `app` | ✅ | ✅ | No |
| Events | `app` | ✅ | ✅ | No |
| About | `app` | ✅ | ✅ | No |
| Contact | `app` | ✅ | ✅ | No |
| Login | `guest` | ❌ | ❌ | No (guest only) |
| Register | `guest` | ❌ | ❌ | No (guest only) |
| Reset Password | `guest` | ❌ | ❌ | No (guest only) |
| Dashboard | `app.sidebar` | ✅ (sidebar) | ❌ | Yes |
| Profile | `app.sidebar` | ✅ (sidebar) | ❌ | Yes |
| Settings | `app.sidebar` | ✅ (sidebar) | ❌ | Yes |
| Landing Special | `main` | ❌ | ❌ | No |

## Implementazione Corretta

### File: `resources/views/components/layouts/app.blade.php`
Layout pubblico completo con nav e footer:
```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <x-metatags>
        {{-- Additional head content --}}
    </x-metatags>
    <body class="font-sans antialiased bg-slate-900 text-white">
        <x-navigation />

        <main id="main-content">
            {{ $slot }}
        </main>

        <x-footer />

        @livewireScripts
    </body>
</html>
```

### File: `resources/views/components/layouts/main.blade.php`
Layout minimale senza decorazioni:
```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-metatags />
    <body class="font-sans antialiased">
        {{ $slot }}
        @livewireScripts
    </body>
</html>
```

### File: `resources/views/components/layouts/guest.blade.php`
Layout per autenticazione:
```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-metatags />
    <body class="font-sans antialiased bg-slate-900">
        <div class="min-h-screen flex items-center justify-center">
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </div>
        @livewireScripts
    </body>
</html>
```

### File: `resources/views/components/layouts/app/sidebar.blade.php`
Layout dashboard (già esistente, corretto)

## Folio Pages Usage

### Pagine Pubbliche
```blade
<x-layouts.app>
    @volt('home')
        <x-page side="content" slug="home" />
    @endvolt
</x-layouts.app>
```

### Pagine Autenticazione
```blade
<x-layouts.guest>
    @volt('login')
        <x-auth-form />
    @endvolt
</x-layouts.guest>
```

### Pagine Dashboard
```blade
<x-layouts.app.sidebar>
    @volt('dashboard')
        <x-dashboard-content />
    @endvolt
</x-layouts.app.sidebar>
```

## Azioni Necessarie

1. ✅ Documentare struttura corretta
2. ⏳ Rinominare `layouts.public` → eliminare (non serve)
3. ⏳ Creare/aggiornare `layouts.app` (con nav/footer)
4. ⏳ Creare `layouts.main` (minimale)
5. ⏳ Creare `layouts.guest` (auth)
6. ⏳ Verificare `layouts.app.sidebar` (dashboard)
7. ⏳ Verificare tutte pagine laravelpizza.com
8. ⏳ Implementare pagine mancanti
