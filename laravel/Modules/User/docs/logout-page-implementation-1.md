# Implementazione della Pagina di Logout nel Tema One

## Struttura Corretta

Il file `logout.blade.php` deve essere implementato come una pagina Folio statica nel tema One, seguendo queste linee guida:

### 1. Posizione del File
```
Themes/One/resources/views/pages/auth/logout.blade.php
```

### 2. Implementazione Corretta
```blade
@php
    use Illuminate\Support\Facades\Auth;

    // Esegui il logout
    Auth::logout();

    // Invalida e rigenera la sessione
    session()->invalidate();
    session()->regenerateToken();
@endphp

<x-layout>
    <x-slot:title>
        {{ __('Logout') }}
    </x-slot>

    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow-lg">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    {{ __('Logout effettuato con successo') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Verrai reindirizzato alla home page tra pochi secondi...') }}
                </p>
            </div>

            <div class="mt-8">
                <a href="{{ route('home') }}"
                   class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Torna alla Home') }}
                </a>
            </div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            window.location.href = "{{ route('home') }}";
        }, 3000);
    </script>
</x-layout>
```

## Spiegazione Tecnica

### 1. Perché una Pagina Folio Statica?
- Non richiede componenti Volt/Livewire per una semplice operazione di logout
- Più performante e leggera
- Gestisce il logout immediatamente al caricamento della pagina
- Non richiede gestione di stati o eventi

### 2. Gestione della Sessione
- `Auth::logout()` - Termina la sessione dell'utente
- `session()->invalidate()` - Invalida la sessione corrente
- `session()->regenerateToken()` - Rigenera il token CSRF per sicurezza

### 3. Layout e UI
- Utilizza il layout standard del tema One (`<x-layout>`)
- Fornisce feedback visivo chiaro all'utente
- Include un reindirizzamento automatico dopo 3 secondi
- Offre un pulsante per tornare alla home immediatamente

## Best Practices

### 1. Sicurezza
- Invalida sempre la sessione dopo il logout
- Rigenera il token CSRF
- Non memorizzare dati sensibili nella sessione

### 2. UX
- Fornisci feedback visivo chiaro
- Implementa reindirizzamento automatico
- Offri un'alternativa manuale (pulsante)

### 3. Performance
- Mantieni la pagina leggera
- Evita componenti non necessari
- Usa il caching appropriato

## Note Importanti

1. **Non usare Volt/Livewire** per questa pagina
2. **Non definire rotte** in `web.php`
3. **Non usare controller** dedicati
4. **Mantieni la logica** semplice e diretta

## Collegamenti Correlati
- [Best Practices Folio](./ROUTING_BEST_PRACTICES.md)
- [Gestione Sessione](./SESSION_MANAGEMENT.md)
- [Tema One Documentation](../../Themes/One/docs/README.md)
