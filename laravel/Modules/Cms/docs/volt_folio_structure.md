# Volt con Folio: Struttura Corretta

## Regola Fondamentale

, quando si utilizzano componenti Volt con Folio, è fondamentale seguire queste regole di struttura:

## Posizionamento Corretto della Direttiva @volt

1. **La direttiva `@volt` deve essere SEMPRE la prima cosa nel file**:

```blade
@volt
<?php
// Codice PHP di Volt
?>
@endvolt

<x-layouts.app>
    <!-- Contenuto HTML -->
</x-layouts.app>
```

## Errori Comuni da Evitare

### 1. Non posizionare `@volt` all'interno del markup HTML:

```blade
<!-- ❌ ERRATO -->
<x-layouts.app>
    @volt
    <?php
    // Codice PHP di Volt
    ?>
    @endvolt
</x-layouts.app>
```

### 2. Non utilizzare tag PHP aperti e chiusi multipli:

```blade
<!-- ❌ ERRATO -->
@volt
<?php
// Codice PHP
?>
<?php
// Altro codice PHP
?>
@endvolt
```

### 3. Non mescolare logica Volt e HTML:

```blade
<!-- ❌ ERRATO -->
@volt
<?php
// Prima parte del codice
?>
<div>Contenuto HTML</div>
<?php
// Seconda parte del codice
?>
@endvolt
```

## Layout da Utilizzare

Utilizzare sempre i layout corretti:
- ✅ `<x-layouts.app>` - Layout principale dell'applicazione
- ✅ `<x-layouts.guest>` - Layout per pagine guest (login, registrazione, etc.)

Non utilizzare layout che non esistono:
- ❌ `<x-layouts.main>` - Obsoleto, utilizzare `<x-layouts.app>`
- ❌ `<x-filament::layouts.card>` - Non esiste, utilizzare `<x-filament::card>`

## Messaggio di Errore Comune

Se ricevi l'errore:

> `The [@volt] directive is required when using Volt anonymous components in Folio pages`

Significa che:
1. Manca completamente la direttiva `@volt` all'inizio del file, o
2. La direttiva `@volt` è posizionata in modo errato (non all'inizio del file)

## Esempio Completo Corretto

```blade
@volt
<?php
// Importazioni
use function Livewire\Volt\{state, mount, computed};
use Illuminate\Contracts\View\View;

// Definizione dello stato
state([
    'email' => '',
    'password' => '',
]);

// Metodi
function login(): void {
    // Implementazione login
}
?>
@endvolt

<x-layouts.guest>
    <div class="max-w-md mx-auto">
        <h2 class="text-2xl font-bold mb-4">Login</h2>
        
        <form wire:submit="login">
            <div class="mb-4">
                <label for="email">Email</label>
                <input type="email" id="email" wire:model="email" />
            </div>
            
            <div class="mb-4">
                <label for="password">Password</label>
                <input type="password" id="password" wire:model="password" />
            </div>
            
            <button type="submit">Login</button>
        </form>
    </div>
</x-layouts.guest>
```

## Documentazione Correlata

- [Folio ](./FOLIO_OVERVIEW.md)
- [Volt Best Practices](./VOLT_BEST_PRACTICES.md)
- [Autenticazione con Volt e Folio](../../User/docs/VOLT_FOLIO_AUTH_IMPLEMENTATION.md)
- [Layout Components](../components/LAYOUTS.md)
