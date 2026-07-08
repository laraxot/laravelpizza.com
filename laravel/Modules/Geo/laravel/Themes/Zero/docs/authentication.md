# Autenticazione - Tema Zero

## Panoramica

Il tema Zero fornisce un sistema completo di autenticazione seguendo le convenzioni del progetto e le best practices di UX/UI. Le pagine di autenticazione sono progettate per essere accessibili, sicure e user-friendly.

## Struttura delle Pagine

### Routing Folio

Il tema Zero utilizza Laravel Folio per il routing automatico delle pagine di autenticazione:

```
resources/views/pages/auth/
├── login.blade.php      # /auth/login
├── register.blade.php   # /auth/register
├── logout.blade.php     # /auth/logout
├── password/
│   ├── reset.blade.php  # /auth/password/reset
│   └── [token].blade.php # /auth/password/[token]
└── verify.blade.php     # /auth/verify
```

### Convenzioni di Naming

- **File**: lowercase con underscore (`login.blade.php`)
- **Route**: automatica basata sulla struttura cartelle
- **Componenti**: namespace basato sulla struttura

## Pagina di Login

### Caratteristiche

- **Design Centrato**: Layout centrato per focus sull'azione
- **Validazione Real-time**: Feedback immediato sugli errori
- **Remember Me**: Opzione per mantenere la sessione
- **Password Reset**: Link per recupero password
- **Registrazione**: Link per nuovi utenti
- **Accessibilità**: Supporto completo per screen reader

### Implementazione

Il tema Zero utilizza l'architettura **"vestito"** dove:
- **Logica**: Centralizzata nel modulo User tramite LoginWidget
- **Stile**: Personalizzato nel tema Zero tramite vista dedicata
- **Separazione**: Chiara separazione tra logica di business e presentazione

```blade
{{-- Pagina di login (laravel/Themes/Zero/resources/views/pages/auth/login.blade.php) --}}
<x-layouts.main>
    <x-slot name="title">
        {{ __('Accedi') }} - {{ config('app.name', 'Laravel') }}
    </x-slot>
    
    <x-slot name="description">
        {{ __('Accedi al tuo account per accedere alle funzionalità riservate.') }}
    </x-slot>
    
    <!-- Login Container -->
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo and Header -->
            <div class="text-center">
                <div class="mx-auto h-12 w-12 bg-blue-600 rounded-lg flex items-center justify-center mb-4">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                
                <h1 class="text-3xl font-extrabold text-gray-900 mb-2">
                    {{ __('Accedi al tuo account') }}
                </h1>
                
                <p class="text-sm text-gray-600">
                    {{ __('Inserisci le tue credenziali per accedere') }}
                </p>
            </div>

            <!-- Login Widget Container -->
            <div id="login-widget" class="bg-white rounded-lg shadow-lg border border-gray-200 p-8">
                @livewire(\Modules\User\Filament\Widgets\Auth\LoginWidget::class)
            </div>

            <!-- Registration Link -->
            <div class="text-center">
                <p class="text-sm text-gray-600">
                    {{ __('Non hai un account?') }}
                    <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        {{ __('Registrati ora') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-layouts.main>
```

### Vista del Widget

```blade
{{-- Vista del widget (laravel/Themes/Zero/resources/views/filament/widgets/auth/login.blade.php) --}}
<x-filament-widgets::widget>
    <div class="space-y-6">
        {{-- Header del form --}}
        <div class="text-center">
            <h2 class="text-xl font-semibold text-gray-900">
                {{ __('Accedi al tuo account') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                {{ __('Inserisci le tue credenziali per accedere') }}
            </p>
        </div>

        {{-- Form renderizzato dal widget --}}
        <form wire:submit="login" class="space-y-4">
            {{ $this->form }}

            {{-- Remember Me & Forgot Password --}}
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input 
                        id="remember" 
                        wire:model="data.remember" 
                        type="checkbox"
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition-colors"
                    >
                    <label for="remember" class="ml-2 block text-sm text-gray-900">
                        {{ __('Ricordami') }}
                    </label>
                </div>

                <div class="text-sm">
                    <a href="{{ route('password.request') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        {{ __('Password dimenticata?') }}
                    </a>
                </div>
            </div>

            {{-- Submit Button --}}
            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm hover:shadow-md">
                    {{ __('Accedi') }}
                </button>
            </div>
        </form>

        {{-- Social Login --}}
        <div class="grid grid-cols-2 gap-3">
            <button type="button" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    {{-- Google SVG --}}
                </svg>
                <span class="ml-2">{{ __('Google') }}</span>
            </button>

            <button type="button" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    {{-- GitHub SVG --}}
                </svg>
                <span class="ml-2">{{ __('GitHub') }}</span>
            </button>
        </div>
    </div>
</x-filament-widgets::widget>
```

## Principi UX Applicati

### 1. Legge di Fitts
- **Pulsanti grandi**: Il pulsante di login è ampio e facilmente cliccabile
- **Posizionamento**: Elementi importanti in posizioni facilmente raggiungibili
- **Distanza**: Adeguata spaziatura tra elementi interattivi

### 2. Legge di Hick
- **Opzioni limitate**: Solo i campi essenziali (email, password)
- **Scelte semplici**: Remember me come opzione secondaria
- **Focus**: Un'azione principale (login) ben evidenziata

### 3. Contrasto e Leggibilità
- **Contrasto elevato**: Testo scuro su sfondo chiaro
- **Font leggibile**: Utilizzo di font system per massima compatibilità
- **Dimensioni adeguate**: Testo e input di dimensioni confortevoli

### 4. Feedback Utente
- **Validazione real-time**: Errori mostrati immediatamente
- **Stati visivi**: Hover, focus e active states
- **Messaggi chiari**: Errori specifici e comprensibili

## Accessibilità

### Attributi ARIA
```html
<input 
    id="email" 
    wire:model="email" 
    type="email" 
    required
    autocomplete="email"
    aria-describedby="email-error"
    aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
>
```

### Navigazione da Tastiera
- **Tab order**: Ordine logico di navigazione
- **Focus visible**: Indicatori di focus chiari
- **Escape**: Possibilità di annullare l'operazione

### Screen Reader
- **Labels**: Etichette associate agli input
- **Errori**: Messaggi di errore annunciati
- **Stati**: Cambi di stato comunicati

## Sicurezza

### CSRF Protection
```blade
@csrf
```

### Validazione
```php
rules([
    'email' => ['required', 'email'],
    'password' => ['required', 'min:8'],
]);
```

### Rate Limiting
```php
// Implementare rate limiting per prevenire brute force
RateLimiter::attempt(
    'login:'.$this->email,
    $maxAttempts = 5,
    function() {
        // Login logic
    }
);
```

## Responsive Design

### Breakpoint Strategy
```css
/* Mobile First */
.login-container {
    @apply px-4 py-8;
}

/* Tablet */
@media (min-width: 768px) {
    .login-container {
        @apply px-6 py-12;
    }
}

/* Desktop */
@media (min-width: 1024px) {
    .login-container {
        @apply px-8 py-16;
    }
}
```

### Touch Optimization
- **Target size**: Minimo 44px per elementi touch
- **Spacing**: Adeguata spaziatura per evitare tap accidentali
- **Feedback**: Feedback visivo per interazioni touch

## Personalizzazione

### Temi di Colore
```css
:root {
    --login-primary: #3b82f6;
    --login-primary-hover: #2563eb;
    --login-background: #f9fafb;
    --login-text: #1f2937;
    --login-border: #d1d5db;
}
```

### Dark Mode
```css
[data-theme="dark"] {
    --login-background: #1f2937;
    --login-text: #f9fafb;
    --login-border: #374151;
}
```

## Testing

### Test di Usabilità
- **Task completion**: Tempo per completare il login
- **Error rate**: Frequenza di errori di input
- **User satisfaction**: Feedback degli utenti

### Test di Accessibilità
- **WCAG 2.1 AA**: Conformità agli standard
- **Screen reader**: Test con NVDA/JAWS
- **Keyboard navigation**: Navigazione completa da tastiera

## Best Practices

### 1. Performance
- **Lazy loading**: Caricamento ottimizzato
- **Minimal JavaScript**: JavaScript essenziale
- **Optimized assets**: CSS e JS compressi

### 2. SEO
- **Meta tags**: Titolo e descrizione appropriati
- **Structured data**: Schema markup per login
- **Canonical URL**: URL canonico per la pagina

### 3. Analytics
- **Conversion tracking**: Monitoraggio tassi di conversione
- **Error tracking**: Monitoraggio errori di login
- **User behavior**: Analisi comportamento utenti

## Riferimenti

- [Documentazione Laravel Authentication](https://laravel.com/docs/authentication)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [Laws of UX](https://lawsofux.com/)
- [Material Design Guidelines](https://material.io/design) 