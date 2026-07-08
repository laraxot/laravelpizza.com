# Esempi di Autenticazione - Tema Zero

## Panoramica

Questo documento fornisce esempi pratici di come utilizzare le pagine di autenticazione del tema Zero, inclusi casi d'uso comuni e personalizzazioni.

## Pagina di Login

### Utilizzo Base

La pagina di login è accessibile tramite il routing Folio automatico:

```bash
# URL della pagina di login
/auth/login
```

### Personalizzazione del Design

#### 1. Cambio Colori

```css
/* resources/css/app.css */
:root {
    --login-primary: #8b5cf6;     /* Viola */
    --login-primary-hover: #7c3aed;
    --login-background: #f8fafc;
    --login-text: #1e293b;
    --login-border: #e2e8f0;
}

/* Applicazione delle variabili */
.login-button {
    background-color: var(--login-primary);
}

.login-button:hover {
    background-color: var(--login-primary-hover);
}
```

#### 2. Logo Personalizzato

```blade
<!-- Sostituire l'icona predefinita con il logo aziendale -->
<div class="mx-auto h-12 w-12 mb-4">
    <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" class="h-full w-full object-contain">
</div>
```

#### 3. Messaggi Personalizzati

```blade
<!-- Personalizzare i messaggi di errore -->
@error('email') 
    <p class="mt-2 text-sm text-red-600">
        <strong>Attenzione:</strong> {{ $message }}
    </p> 
@enderror
```

### Integrazione con Middleware

#### 1. Redirect dopo Login

```php
// app/Http/Middleware/RedirectIfAuthenticated.php
public function handle($request, Closure $next, ...$guards)
{
    $guards = empty($guards) ? [null] : $guards;

    foreach ($guards as $guard) {
        if (Auth::guard($guard)->check()) {
            // Reindirizza alla dashboard personalizzata
            return redirect('/dashboard');
        }
    }

    return $next($request);
}
```

#### 2. Rate Limiting Personalizzato

```php
// Personalizzare il rate limiting nella pagina di login
$throttleKey = 'login:'.request()->ip();

if (RateLimiter::tooManyAttempts($throttleKey, 3)) { // Ridotto a 3 tentativi
    $seconds = RateLimiter::availableIn($throttleKey);
    throw ValidationException::withMessages([
        'email' => __('Troppi tentativi. Riprova tra :seconds secondi.', ['seconds' => $seconds])
    ]);
}
```

## Pagina di Registrazione

### Implementazione Base

```blade
@volt('auth.register')
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Auth\Events\Registered;
    use App\Models\User;
    use function Livewire\Volt\{state, rules};

    state([
        'name' => '',
        'email' => '',
        'password' => '',
        'password_confirmation' => '',
        'terms' => false,
    ]);

    rules([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'terms' => ['accepted'],
    ]);

    $register = function() {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    };
@endvolt

<x-layouts.main>
    <x-slot name="title">
        {{ __('Registrazione') }} - {{ config('app.name') }}
    </x-slot>
    
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    {{ __('Crea il tuo account') }}
                </h2>
            </div>

            <form wire:submit="register" class="mt-8 space-y-6">
                @csrf
                
                <!-- Nome -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        {{ __('Nome completo') }}
                    </label>
                    <input 
                        id="name" 
                        wire:model="name" 
                        type="text" 
                        required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    >
                    @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        {{ __('Email') }}
                    </label>
                    <input 
                        id="email" 
                        wire:model="email" 
                        type="email" 
                        required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    >
                    @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        {{ __('Password') }}
                    </label>
                    <input 
                        id="password" 
                        wire:model="password" 
                        type="password" 
                        required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    >
                    @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Conferma Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                        {{ __('Conferma Password') }}
                    </label>
                    <input 
                        id="password_confirmation" 
                        wire:model="password_confirmation" 
                        type="password" 
                        required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>

                <!-- Termini e Condizioni -->
                <div class="flex items-center">
                    <input 
                        id="terms" 
                        wire:model="terms" 
                        type="checkbox"
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                    >
                    <label for="terms" class="ml-2 block text-sm text-gray-900">
                        {{ __('Accetto i') }} 
                        <a href="{{ route('terms') }}" class="text-blue-600 hover:text-blue-500">
                            {{ __('Termini di Servizio') }}
                        </a>
                        {{ __('e la') }}
                        <a href="{{ route('privacy') }}" class="text-blue-600 hover:text-blue-500">
                            {{ __('Privacy Policy') }}
                        </a>
                    </label>
                </div>
                @error('terms') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror

                <!-- Submit Button -->
                <div>
                    <button 
                        type="submit" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        {{ __('Registrati') }}
                    </button>
                </div>
            </form>

            <!-- Login Link -->
            <div class="text-center">
                <p class="text-sm text-gray-600">
                    {{ __('Hai già un account?') }}
                    <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        {{ __('Accedi') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-layouts.main>
```

## Reset Password

### Pagina di Richiesta Reset

```blade
@volt('auth.password.request')
    use Illuminate\Support\Facades\Password;
    use function Livewire\Volt\{state, rules};

    state(['email' => '']);

    rules(['email' => ['required', 'email']]);

    $sendResetLink = function() {
        $this->validate();

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('status', __($status));
            $this->email = '';
        } else {
            $this->addError('email', __($status));
        }
    };
@endvolt

<x-layouts.main>
    <x-slot name="title">
        {{ __('Reset Password') }} - {{ config('app.name') }}
    </x-slot>
    
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    {{ __('Reset Password') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Inserisci la tua email per ricevere il link di reset') }}
                </p>
            </div>

            @if (session('status'))
                <div class="bg-green-50 border border-green-200 rounded-md p-4">
                    <p class="text-sm text-green-800">{{ session('status') }}</p>
                </div>
            @endif

            <form wire:submit="sendResetLink" class="mt-8 space-y-6">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        {{ __('Email') }}
                    </label>
                    <input 
                        id="email" 
                        wire:model="email" 
                        type="email" 
                        required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    >
                    @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <button 
                        type="submit" 
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        {{ __('Invia Link di Reset') }}
                    </button>
                </div>
            </form>

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-500">
                    {{ __('Torna al login') }}
                </a>
            </div>
        </div>
    </div>
</x-layouts.main>
```

## Verifica Email

### Pagina di Verifica

```blade
@volt('auth.verify')
    use Illuminate\Support\Facades\Auth;
    use function Livewire\Volt\{state, mount};

    state(['resent' => false]);

    mount(function() {
        if (Auth::user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }
    });

    $resend = function() {
        Auth::user()->sendEmailVerificationNotification();
        $this->resent = true;
    };
@endvolt

<x-layouts.main>
    <x-slot name="title">
        {{ __('Verifica Email') }} - {{ config('app.name') }}
    </x-slot>
    
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    {{ __('Verifica la tua email') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Abbiamo inviato un link di verifica a') }} {{ Auth::user()->email }}
                </p>
            </div>

            @if ($resent)
                <div class="bg-green-50 border border-green-200 rounded-md p-4">
                    <p class="text-sm text-green-800">
                        {{ __('Un nuovo link di verifica è stato inviato.') }}
                    </p>
                </div>
            @endif

            <div class="space-y-4">
                <button 
                    wire:click="resend"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    {{ __('Invia di nuovo') }}
                </button>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button 
                        type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        {{ __('Logout') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.main>
```

## Personalizzazioni Avanzate

### 1. Social Login

```blade
<!-- Aggiungere bottoni per social login -->
<div class="mt-6">
    <div class="relative">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-white text-gray-500">{{ __('oppure') }}</span>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-2 gap-3">
        <a href="{{ route('socialite.redirect', 'google') }}" 
           class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
            <svg class="w-5 h-5" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            <span class="ml-2">{{ __('Google') }}</span>
        </a>

        <a href="{{ route('socialite.redirect', 'github') }}" 
           class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z" clip-rule="evenodd" />
            </svg>
            <span class="ml-2">{{ __('GitHub') }}</span>
        </a>
    </div>
</div>
```

### 2. Two-Factor Authentication

```blade
<!-- Aggiungere campo per 2FA -->
<div>
    <label for="code" class="block text-sm font-medium text-gray-700">
        {{ __('Codice di Verifica') }}
    </label>
    <input 
        id="code" 
        wire:model="code" 
        type="text" 
        required
        maxlength="6"
        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-center text-lg tracking-widest"
        placeholder="000000"
    >
    @error('code') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
</div>
```

## Testing

### Test di Usabilità

```php
// tests/Feature/Auth/LoginTest.php
public function test_user_can_login_with_valid_credentials()
{
    $user = User::factory()->create();

    $response = $this->post('/auth/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertRedirect('/dashboard');
    $this->assertAuthenticated();
}

public function test_user_cannot_login_with_invalid_credentials()
{
    $response = $this->post('/auth/login', [
        'email' => 'invalid@email.com',
        'password' => 'wrongpassword',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
}
```

### Test di Accessibilità

```php
// tests/Feature/Auth/AccessibilityTest.php
public function test_login_page_is_accessible()
{
    $response = $this->get('/auth/login');

    $response->assertStatus(200);
    $response->assertSee('id="email"');
    $response->assertSee('id="password"');
    $response->assertSee('for="email"');
    $response->assertSee('for="password"');
}
```

## Best Practices

### 1. Sicurezza
- Utilizzare HTTPS in produzione
- Implementare rate limiting
- Validare tutti gli input
- Utilizzare password hashing sicuro

### 2. UX
- Fornire feedback immediato
- Mostrare progressi di caricamento
- Gestire errori in modo user-friendly
- Mantenere coerenza visiva

### 3. Performance
- Ottimizzare le query del database
- Utilizzare caching appropriato
- Minimizzare le richieste HTTP
- Compressare gli asset

## Riferimenti

- [Laravel Authentication](https://laravel.com/docs/authentication)
- [Laravel Folio](https://laravel.com/docs/folio)
- [Livewire Volt](https://livewire.laravel.com/docs/volt)
- [WCAG Guidelines](https://www.w3.org/WAI/WCAG21/quickref/) 