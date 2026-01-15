# Struttura del Logout Blade nel Theme One

## Posizione Corretta
Il file `logout.blade.php` deve essere posizionato in:
```
laravel/Themes/One/resources/views/pages/auth/logout.blade.php
```

## Struttura del File

### 1. Direttiva Volt
```blade
@volt
class LogoutPage
{
    public function mount()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        
        return redirect()->route('home');
    }
}
@endvolt
```

### 2. Layout e Contenuto
```blade
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

## Spiegazione

1. **Direttiva Volt**
   - La direttiva `@volt` è necessaria per utilizzare Volt in una pagina Folio
   - La classe `LogoutPage` gestisce la logica di logout
   - Il metodo `mount()` viene eseguito automaticamente al caricamento della pagina

2. **Layout**
   - Utilizza il componente `<x-layout>` del tema
   - Definisce un titolo personalizzato
   - Implementa un design responsive e moderno

3. **Contenuto**
   - Messaggio di conferma del logout
   - Pulsante per tornare alla home
   - Reindirizzamento automatico dopo 3 secondi

4. **Sicurezza**
   - Logout dell'utente
   - Invalidazione della sessione
   - Rigenerazione del token CSRF

## Best Practices

1. **Gestione degli Errori**
   ```php
   try {
       auth()->logout();
       session()->invalidate();
       session()->regenerateToken();
   } catch (\Exception $e) {
       Log::error('Errore durante il logout: ' . $e->getMessage());
       session()->flash('error', __('Si è verificato un errore durante il logout'));
   }
   ```

2. **Eventi**
   ```php
   Event::dispatch('auth.logout.attempting', [auth()->user()]);
   // ... logout logic ...
   Event::dispatch('auth.logout.successful');
   ```

3. **Logging**
   ```php
   Log::info('Utente disconnesso', [
       'user_id' => auth()->id(),
       'timestamp' => now()
   ]);
   ```

## Collegamenti

- [Documentazione Volt](./VOLT_LOGOUT.md)
- [Best Practices Routing](./ROUTING_BEST_PRACTICES.md)
- [Struttura Directory](./DIRECTORY_STRUCTURE_CHECKLIST.md) 