# Blade di Autenticazione

## Introduzione

Le blade di autenticazione sono componenti essenziali per la gestione degli utenti nel frontoffice. Questa documentazione descrive la struttura e l'implementazione delle blade di autenticazione nel tema.

## Struttura

```
resources/views/pages/auth/
├── login.blade.php
├── register.blade.php
├── forgot-password.blade.php
├── reset-password.blade.php
└── verify-email.blade.php
```

## Componenti

### Login

Il componente di login gestisce l'autenticazione degli utenti esistenti.

```php
// login.blade.php
<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button class="ml-3">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
```

### Registrazione

Il componente di registrazione gestisce la creazione di nuovi account utente.

```php
// register.blade.php
<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="ml-4">
                        {{ __('auth.register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
```

## Best Practices

1. **Sicurezza**
   - Utilizzare sempre CSRF token
   - Implementare rate limiting
   - Validare tutti gli input
   - Utilizzare password hashing

2. **UX**
   - Fornire feedback chiari sugli errori
   - Implementare validazione lato client
   - Mantenere la coerenza del design
   - Supportare l'accessibilità

3. **Performance**
   - Minimizzare le richieste HTTP
   - Ottimizzare le immagini
   - Implementare lazy loading
   - Utilizzare CDN per gli asset

## Troubleshooting

### Problemi Comuni

1. **Errori di Validazione**
   - Verificare le regole di validazione
   - Controllare i messaggi di errore
   - Assicurarsi che i campi siano correttamente validati

2. **Problemi di Stile**
   - Verificare la configurazione di Tailwind
   - Controllare l'ordine degli import CSS
   - Assicurarsi che i componenti siano correttamente stilizzati

## Risorse Utili

- [Documentazione Laravel Authentication](https://laravel.com/docs/authentication)
- [Documentazione Tailwind CSS](https://tailwindcss.com/docs)
- [Best Practices per la Sicurezza](https://laravel.com/docs/security) 
