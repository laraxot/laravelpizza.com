# Pagine di Autenticazione

## Pagina di Logout con Folio e Volt

### Struttura
```php
// Themes/One/resources/views/pages/auth/logout.blade.php

<?php

use function Livewire\Volt\{state, mount};

state([
    'confirmingLogout' => false,
]);

$logout = function() {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
};

?>

<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="text-center">
            <h2 class="text-2xl font-bold mb-4">{{ __('Stai per essere disconnesso') }}</h2>
            <p class="text-gray-600 mb-6">{{ __('Sei sicuro di voler uscire?') }}</p>

            <div class="flex justify-center space-x-4">
                <button
                    wire:click="logout"
                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                >
                    {{ __('Esci') }}
                </button>

                <a
                    href="{{ url()->previous() }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                >
                    {{ __('Annulla') }}
                </a>
            </div>
        </div>
    </div>
</div>
```

### Caratteristiche
1. **Architettura**
   - Utilizzo di Folio per il routing delle pagine
   - Implementazione con Volt per la gestione dello stato
   - Componente Livewire reattivo

2. **Funzionalità**
   - Gestione dello stato con Volt
   - Logout sicuro con invalidazione della sessione
   - Redirect automatico dopo il logout
   - Opzione di annullamento con ritorno alla pagina precedente

3. **Sicurezza**
   - Invalidazione della sessione
   - Rigenerazione del token CSRF
   - Protezione contro attacchi CSRF
   - Gestione sicura del logout

4. **UX/UI**
   - Design responsive con Tailwind
   - Feedback visivo immediato
   - Doppia opzione (conferma/annulla)
   - Animazioni fluide

5. **Accessibilità**
   - Testi tradotti
   - Struttura semantica
   - Focus visibile
   - Supporto tastiera

### Best Practices
1. Utilizzare Volt per la gestione dello stato
2. Implementare feedback visivi per le azioni
3. Garantire la sicurezza del processo di logout
4. Fornire opzioni di annullamento
5. Mantenere la coerenza con il design system

### Note Tecniche
1. **Folio**
   - La pagina viene automaticamente mappata alla rotta `/logout`
   - Non è necessario definire rotte manualmente
   - Supporto nativo per i middleware

2. **Volt**
   - Gestione reattiva dello stato
   - Metodi e proprietà automaticamente disponibili
   - Integrazione nativa con Livewire

3. **Livewire**
   - Interazioni reattive senza refresh
   - Gestione automatica degli stati
   - Ottimizzazione delle performance

### Best Practices
1. Mantenere il design semplice e intuitivo
2. Fornire feedback chiari all'utente
3. Garantire la sicurezza del processo di logout
4. Assicurare la responsività su tutti i dispositivi
5. Utilizzare le traduzioni per il supporto multilingua
# Pagine di Autenticazione

## Pagina di Logout con Folio e Volt

### Struttura
```php
// Themes/One/resources/views/pages/auth/logout.blade.php

<?php

use function Livewire\Volt\{state, mount};

state([
    'confirmingLogout' => false,
]);

$logout = function() {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
};

?>

<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="text-center">
            <h2 class="text-2xl font-bold mb-4">{{ __('Stai per essere disconnesso') }}</h2>
            <p class="text-gray-600 mb-6">{{ __('Sei sicuro di voler uscire?') }}</p>

            <div class="flex justify-center space-x-4">
                <button
                    wire:click="logout"
                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                >
                    {{ __('Esci') }}
                </button>

                <a
                    href="{{ url()->previous() }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                >
                    {{ __('Annulla') }}
                </a>
            </div>
        </div>
    </div>
</div>
```

### Caratteristiche
1. **Architettura**
   - Utilizzo di Folio per il routing delle pagine
   - Implementazione con Volt per la gestione dello stato
   - Componente Livewire reattivo

2. **Funzionalità**
   - Gestione dello stato con Volt
   - Logout sicuro con invalidazione della sessione
   - Redirect automatico dopo il logout
   - Opzione di annullamento con ritorno alla pagina precedente

3. **Sicurezza**
   - Invalidazione della sessione
   - Rigenerazione del token CSRF
   - Protezione contro attacchi CSRF
   - Gestione sicura del logout

4. **UX/UI**
   - Design responsive con Tailwind
   - Feedback visivo immediato
   - Doppia opzione (conferma/annulla)
   - Animazioni fluide

5. **Accessibilità**
   - Testi tradotti
   - Struttura semantica
   - Focus visibile
   - Supporto tastiera

### Best Practices
1. Utilizzare Volt per la gestione dello stato
2. Implementare feedback visivi per le azioni
3. Garantire la sicurezza del processo di logout
4. Fornire opzioni di annullamento
5. Mantenere la coerenza con il design system

### Note Tecniche
1. **Folio**
   - La pagina viene automaticamente mappata alla rotta `/logout`
   - Non è necessario definire rotte manualmente
   - Supporto nativo per i middleware

2. **Volt**
   - Gestione reattiva dello stato
   - Metodi e proprietà automaticamente disponibili
   - Integrazione nativa con Livewire

3. **Livewire**
   - Interazioni reattive senza refresh
   - Gestione automatica degli stati
   - Ottimizzazione delle performance

### Best Practices
1. Mantenere il design semplice e intuitivo
2. Fornire feedback chiari all'utente
3. Garantire la sicurezza del processo di logout
4. Assicurare la responsività su tutti i dispositivi
5. Utilizzare le traduzioni per il supporto multilingua
