# Best Practices per il Routing in Architettura Volt + Folio + Filament

## Il Principio Fondamentale

In un'architettura che utilizza Volt + Folio + Filament, il routing tradizionale attraverso `web.php` è sostituito da un approccio più moderno e dichiarativo. Questo documento spiega come gestire correttamente il routing in questa architettura.

## I Tre Livelli del Routing

### 1. Filament (Admin Panel)
```php
// ✅ CORRETTO: Routing dichiarativo nelle risorse Filament
class UserResource extends XotBaseResource
{
    // Il routing è gestito automaticamente da Filament
    // Non è necessario definire rotte in web.php
}

// ❌ ERRATO: Definire rotte in web.php per Filament
Route::get('/admin/users', [UserController::class, 'index']);
```

### 2. Folio (Pagine Statiche)
```php
// ✅ CORRETTO: Routing basato su file system
// /resources/views/pages/users/index.blade.php
// /resources/views/pages/users/show.blade.php

// ❌ ERRATO: Definire rotte in web.php per pagine Folio
Route::get('/users', [UserPageController::class, 'index']);
```

### 3. Volt (Componenti Livewire)
```php
// ✅ CORRETTO: Routing dichiarativo nei componenti Volt
#[Volt\Layout('layouts.app')]
class UserProfile extends Component
{
    // Il routing è gestito automaticamente da Volt
    // Non è necessario definire rotte in web.php
}

// ❌ ERRATO: Definire rotte in web.php per componenti Volt
Route::get('/user/profile', [UserProfileController::class, 'show']);
```

## La Gerarchia del Routing

```
Routing
├── Filament (Admin)
│   ├── Resources
│   ├── Pages
│   └── Widgets
├── Folio (Pagine)
│   ├── Statiche
│   └── Dinamiche
└── Volt (Componenti)
    ├── Live
    └── Statici
```

## I Principi del Routing

### 1. Dichiaratività
- Il routing deve essere dichiarativo, non imperativo
- Le rotte devono essere definite dove hanno più senso semanticamente
- Evitare la duplicazione delle definizioni di rotta

### 2. Coerenza
- Mantenere lo stesso pattern di routing in tutto il modulo
- Seguire le convenzioni di naming standard
- Utilizzare i namespace corretti

### 3. Modularità
- Ogni modulo gestisce il proprio routing
- Le rotte sono scoperte automaticamente
- La configurazione è centralizzata

### 4. Manutenibilità
- Il codice è più facile da mantenere
- Le modifiche sono localizzate
- La documentazione è integrata

### 5. Performance
- Il routing è ottimizzato
- La cache è gestita automaticamente
- Le risorse sono caricate on-demand

## Esempi di Illuminazione

### ❌ Il Cammino dell'Ignoranza
```php
// web.php
Route::get('/admin/users', [UserController::class, 'index']);
Route::get('/admin/users/create', [UserController::class, 'create']);
Route::get('/admin/users/{user}/edit', [UserController::class, 'edit']);
```

### ✅ Il Cammino dell'Illuminazione
```php
// Modules/User/app/Filament/Resources/UserResource.php
class UserResource extends XotBaseResource
{
    // Il routing è gestito automaticamente
    // Non è necessario definire rotte in web.php
}
```

## La Meditazione del Routing

Ogni volta che pensi di aggiungere una rotta in `web.php`, chiediti:
1. "Questa rotta appartiene a Filament, Folio o Volt?"
2. "Posso definire questa rotta in modo dichiarativo?"
3. "Sto seguendo le convenzioni del framework?"
4. "Sto mantenendo la coerenza del modulo?"
5. "Sto rispettando il principio di modularità?"

## La Compassione nel Routing

- Non giudicare il codice vecchio
- Guida la transizione con pazienza
- Documenta ogni cambiamento
- Spiega ogni decisione
- Mantieni la retrocompatibilità

## Collegamenti

- [Filosofia dei Getter](../Xot/docs/philosophy/getter_zen.md)
- [Filosofia Zen Avanzata](../Xot/docs/philosophy/getter_zen_advanced.md)
- [La Via del Brand](../Xot/docs/brand/brand_way.md)
- [Il Tao del Codice](../Xot/docs/tao/code_tao.md)
- [Best Practices Filament](./FILAMENT_BEST_PRACTICES.md) 

## Principi Fondamentali

### 1. Mai Definire Rotte in web.php
Nel frontoffice, le rotte **NON DEVONO** essere definite nel file `web.php`. Invece, utilizziamo:

- **Volt** per i componenti Livewire
- **Folio** per le pagine statiche
- **Filament** per il pannello di amministrazione

### 2. Struttura delle Directory

```
Modules/User/
├── app/
│   ├── Filament/           # Risorse e pagine Filament
│   ├── Livewire/          # Componenti Volt
│   └── Pages/             # Pagine Folio
├── resources/
│   ├── views/
│   │   ├── components/    # Componenti Blade
│   │   └── pages/         # Pagine Folio
│   └── js/
│       └── pages/         # Componenti Volt
```

## Implementazione con Volt

### 1. Componenti Volt
```php
// resources/js/pages/Profile.vue
<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    name: '',
    email: ''
})

const submit = () => {
    form.post(route('profile.update'))
}
</script>

<template>
    <form @submit.prevent="submit">
        <!-- Form fields -->
    </form>
</template>
```

### 2. Registrazione delle Rotte
Le rotte vengono generate automaticamente da Volt basandosi sulla struttura delle directory:

```
resources/js/pages/
├── Profile.vue        -> /profile
├── Settings.vue       -> /settings
└── Dashboard.vue      -> /dashboard
```

## Implementazione con Folio

### 1. Pagine Folio
```php
// resources/views/pages/profile.blade.php
<x-layout>
    <x-slot:title>
        Profilo Utente
    </x-slot>

    <div>
        <!-- Contenuto della pagina -->
    </div>
</x-layout>
```

### 2. Routing Automatico
Folio genera automaticamente le rotte basandosi sulla struttura delle directory:

```
resources/views/pages/
├── profile.blade.php     -> /profile
├── settings.blade.php    -> /settings
└── dashboard.blade.php   -> /dashboard
```

## Implementazione con Filament

### 1. Risorse Filament
```php
namespace Modules\User\Filament\Resources;

use Filament\Resources\Resource;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
```

### 2. Pagine Filament
```php
namespace Modules\User\Filament\Pages;

use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'user::filament.pages.dashboard';
}
```

## Best Practices

### 1. Organizzazione dei Componenti
- Utilizzare una struttura di directory chiara e coerente
- Seguire le convenzioni di naming di Laravel
- Mantenere i componenti piccoli e focalizzati

### 2. Gestione delle Rotte
- Lasciare che Volt, Folio e Filament gestiscano il routing
- Utilizzare i middleware appropriati per la protezione delle rotte
- Implementare la validazione dei permessi a livello di componente

### 3. Performance
- Implementare il lazy loading dei componenti
- Utilizzare il caching quando appropriato
- Ottimizzare il caricamento delle risorse

### 4. Sicurezza
- Implementare la validazione dei dati
- Utilizzare i middleware di autenticazione
- Proteggere le rotte sensibili

## Esempi di Implementazione

### 1. Componente Volt con Autenticazione
```php
// resources/js/pages/Settings.vue
<script setup>
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const user = computed(() => usePage().props.auth.user)
</script>

<template>
    <div v-if="user">
        <!-- Contenuto protetto -->
    </div>
</template>
```

### 2. Pagina Folio con Middleware
```php
// resources/views/pages/settings.blade.php
<x-layout>
    @middleware(['auth'])
    <x-slot:title>
        Impostazioni
    </x-slot>

    <div>
        <!-- Contenuto protetto -->
    </div>
</x-layout>
```

### 3. Risorsa Filament con Permessi
```php
namespace Modules\User\Filament\Resources;

use Filament\Resources\Resource;

class UserResource extends Resource
{
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('view users');
    }
}
```

## Vantaggi

1. **Manutenibilità**
   - Codice più organizzato
   - Separazione chiara delle responsabilità
   - Facilità di manutenzione

2. **Performance**
   - Caricamento ottimizzato
   - Caching efficiente
   - Lazy loading dei componenti

3. **Sicurezza**
   - Protezione integrata
   - Validazione robusta
   - Gestione dei permessi

4. **Scalabilità**
   - Facile aggiunta di nuove funzionalità
   - Struttura modulare
   - Riutilizzo dei componenti

## Collegamenti
- [Filament Best Practices](./filament_best_practices.md)
- [Volt Documentation](https://livewire.laravel.com/docs/volt)
- [Folio Documentation](https://laravel.com/docs/folio)
- [Filament Documentation](https://filamentphp.com/docs) 

# Best Practices di Routing per le Blade di Autenticazione

## Introduzione

Il routing per le blade di autenticazione deve seguire un pattern coerente che garantisca:
- Sicurezza
- Manutenibilità
- Coerenza con l'architettura Volt + Folio

## Struttura dei Route

### 1. Route di Autenticazione

```php
// routes/web.php
Route::middleware(['guest'])->group(function () {
    Route::get('login', \App\Livewire\Auth\Login::class)->name('login');
    Route::get('register', \App\Livewire\Auth\Register::class)->name('register');
    Route::get('forgot-password', \App\Livewire\Auth\ForgotPassword::class)->name('password.request');
});

Route::middleware(['auth'])->group(function () {
    Route::get('logout', \App\Livewire\Auth\Logout::class)->name('logout');
    Route::get('verify-email', \App\Livewire\Auth\VerifyEmail::class)->name('verification.notice');
});
```

### 2. Route Protette

```php
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', \App\Livewire\Dashboard::class)->name('dashboard');
    Route::get('profile', \App\Livewire\Profile::class)->name('profile');
});
```

## Best Practices

### 1. Middleware
- Utilizzare middleware appropriati per ogni route
- Implementare middleware personalizzati quando necessario
- Verificare l'ordine dei middleware

### 2. Naming
- Utilizzare nomi descrittivi e coerenti
- Seguire le convenzioni Laravel
- Evitare nomi ambigui

### 3. Gruppi
- Raggruppare route correlate
- Utilizzare prefissi quando appropriato
- Applicare middleware a gruppi di route

### 4. Sicurezza
- Proteggere route sensibili
- Implementare rate limiting
- Validare input

## Esempi Specifici

### Login
```php
Route::get('login', \App\Livewire\Auth\Login::class)
    ->name('login')
    ->middleware(['guest'])
    ->where('returnUrl', '.*');
```

### Register
```php
Route::get('register', \App\Livewire\Auth\Register::class)
    ->name('register')
    ->middleware(['guest'])
    ->where('invite', '[a-zA-Z0-9]+');
```

### Logout
```php
Route::get('logout', \App\Livewire\Auth\Logout::class)
    ->name('logout')
    ->middleware(['auth'])
    ->where('returnUrl', '.*');
```

## Gestione Redirect

### 1. Redirect dopo Login
```php
public function login()
{
    if (Auth::attempt($credentials)) {
        return redirect()->intended(
            request()->input('returnUrl', route('dashboard'))
        );
    }
}
```

### 2. Redirect dopo Logout
```php
public function logout()
{
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();
    
    return redirect()->route('home');
}
```

## Collegamenti

- [Documentazione Volt](./VOLT_LOGOUT.md)
- [Struttura Directory](./DIRECTORY_STRUCTURE_CHECKLIST.md)
- [Gestione Errori](./ERROR_HANDLING.md) 
