# Implementazione del Logout con Volt

## Il Problema

L'errore `Route [logout] not defined` si verifica perché stiamo cercando di utilizzare una rotta tradizionale in un'architettura Volt + Folio + Filament. Invece di definire la rotta in `web.php`, implementeremo il logout usando Volt.

## La Soluzione

### 1. Creare il Componente Volt per il Logout

```php
// resources/js/pages/Logout.vue
<script setup>
import { useForm } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'

const form = useForm({})

const logout = () => {
    form.post('/logout', {
        onSuccess: () => {
            router.visit('/')
        }
    })
}
</script>

<template>
    <button 
        @click="logout" 
        class="flex items-center w-full p-2 space-x-2 text-red-500 rounded hover:text-red-600 hover:bg-white"
    >
        <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1012.728 0l-1.09-1.09a6 6 0 11-8.484 0l-1.09 1.09z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 12v2.5m0 0V16m0-3.5h2.5m-2.5 0H9" />
        </svg>
        <span>{{ __('Logout') }}</span>
    </button>
</template>
```

### 2. Modificare il Template del Menu

```php
// Themes/TwentyOne/resources/views/layouts/headernav/about.blade.php
@auth
    <li>
        <x-volt.logout />
    </li>
@endauth
```

### 3. Registrare il Componente Volt

```php
// resources/js/app.js
import { createApp } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'

createInertiaApp({
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el)
    },
})
```

### 4. Configurare il Controller di Autenticazione

```php
// Modules/User/app/Http/Controllers/Auth/LogoutController.php
namespace Modules\User\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home');
    }
}
```

### 5. Registrare la Rotta nel Service Provider

```php
// Modules/User/app/Providers/UserServiceProvider.php
use Modules\User\Http\Controllers\Auth\LogoutController;

public function boot()
{
    $this->app['router']->post('/logout', LogoutController::class)
        ->name('logout')
        ->middleware('web');
}
```

## Vantaggi di questa Implementazione

1. **Coerenza con l'Architettura**
   - Segue il pattern Volt + Folio + Filament
   - Non richiede rotte in `web.php`
   - Mantiene la separazione delle responsabilità

2. **Sicurezza**
   - Gestisce correttamente la sessione
   - Rigenera il token CSRF
   - Implementa il logout in modo sicuro

3. **UX Migliorata**
   - Feedback visivo immediato
   - Reindirizzamento automatico
   - Gestione degli errori

4. **Manutenibilità**
   - Codice organizzato e modulare
   - Facile da testare
   - Facile da estendere

## Best Practices

### 1. Gestione degli Stati
```php
const form = useForm({})

const logout = () => {
    form.post('/logout', {
        onStart: () => {
            // Mostra loader
        },
        onSuccess: () => {
            // Reindirizza
            router.visit('/')
        },
        onError: (errors) => {
            // Gestisci errori
            console.error(errors)
        },
        onFinish: () => {
            // Nascondi loader
        }
    })
}
```

### 2. Styling Consistente
```vue
<template>
    <button 
        @click="logout" 
        class="flex items-center w-full p-2 space-x-2 text-red-500 rounded hover:text-red-600 hover:bg-white"
        :disabled="form.processing"
    >
        <svg class="size-6" ... />
        <span>{{ __('Logout') }}</span>
        <span v-if="form.processing" class="ml-2">
            <svg class="animate-spin size-4" ... />
        </span>
    </button>
</template>
```

### 3. Gestione delle Traduzioni
```php
// lang/it/user.php
return [
    'logout' => 'Logout',
    'logging_out' => 'Disconnessione in corso...',
    'logout_success' => 'Disconnesso con successo',
];
```

## Test

### 1. Test del Componente
```php
// tests/Feature/LogoutTest.php
public function test_user_can_logout()
{
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)
        ->post('/logout');
        
    $response->assertRedirect('/');
    $this->assertGuest();
}
```

### 2. Test del Controller
```php
// tests/Unit/LogoutControllerTest.php
public function test_logout_clears_session()
{
    $user = User::factory()->create();
    $this->actingAs($user);
    
    $this->post('/logout');
    
    $this->assertGuest();
    $this->assertSessionMissing('auth');
}
```

## Collegamenti

- [Documentazione Volt](https://livewire.laravel.com/docs/volt)
- [Best Practices Filament](./FILAMENT_BEST_PRACTICES.md)
- [Routing Best Practices](./ROUTING_BEST_PRACTICES.md) 
