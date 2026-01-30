# Implementazione Corretta di logout.blade.php

## Collegamenti correlati
- [Documentazione centrale](../../../docs/README.md)
- [Collegamenti documentazione](../../../docs/collegamenti-documentazione.md)
- [README modulo User](./README.md)
- [Convenzioni Path](./PATH_CONVENTIONS.md)
- [Struttura moduli](../../../docs/architecture/modules-structure.md)
- [Logout Page Fix](./LOGOUT_PAGE_FIX.md)

## Posizione Corretta
Il file `logout.blade.php` deve essere posizionato in:
```
laravel/Themes/One/resources/views/pages/auth/logout.blade.php
```

## Implementazione Raccomandata

### Struttura del File
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
                <a href="{{ route('home', ['locale' => app()->getLocale()]) }}"
                   class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Torna alla Home') }}
                </a>
            </div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            window.location.href = "{{ route('home', ['locale' => app()->getLocale()]) }}";
        }, 3000);
    </script>
</x-layout>
```

## Best Practices

1. **Approccio Semplice**: Utilizzare una pagina Folio statica con un blocco `@php` per eseguire il logout, senza componenti Livewire o Volt.

2. **Sicurezza della Sessione**: Sempre invalidare e rigenerare la sessione dopo il logout per prevenire attacchi di session fixation.

3. **Feedback Utente**: Fornire un messaggio chiaro che conferma l'avvenuto logout.

4. **Reindirizzamento Automatico**: Includere un reindirizzamento automatico alla home page dopo un breve ritardo.

5. **Localizzazione degli URL**: Includere sempre il prefisso della lingua corrente nei link:
   ```php
   route('home', ['locale' => app()->getLocale()])
   ```

6. **Componenti Filament**: Utilizzare i componenti Blade nativi di Filament per i pulsanti e altri elementi UI:
   ```blade
   <x-filament::button tag="a" href="{{ route('home', ['locale' => app()->getLocale()]) }}">
       {{ __('Torna alla Home') }}
   </x-filament::button>
   ```

7. **Traduzioni**: Utilizzare la funzione `__()` per tutte le stringhe visualizzate all'utente.

## Errori Comuni da Evitare

1. **Mix di Paradigmi**: Non mescolare Volt, Livewire e Blade statico nella stessa pagina.

2. **URL senza Localizzazione**: Non generare URL senza il prefisso della lingua corrente.

3. **Componenti UI Personalizzati**: Non utilizzare componenti UI personalizzati quando sono disponibili componenti Filament nativi.

4. **Reindirizzamento Immediato**: Non reindirizzare immediatamente senza fornire feedback all'utente.

## Note Tecniche

- Il file `logout.blade.php` è una pagina Folio e non richiede configurazioni aggiuntive in `routes/web.php`.
- La pagina è accessibile all'URL `/{locale}/auth/logout`.
- Per maggiori informazioni sulla gestione dell'autenticazione, consultare la documentazione Laravel ufficiale.
