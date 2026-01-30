# Errore VoltDirectiveMissingException in Folio

## Il Problema
L'errore si verifica quando si cerca di utilizzare un componente Volt in una pagina Folio senza la direttiva `@volt`. L'errore specifico è:

```
Livewire\Volt\Exceptions\VoltDirectiveMissingException
The [@volt] directive is required when using Volt anonymous components in Folio pages.
```

## Perché Succede
1. Folio e Volt hanno approcci diversi per la gestione dei componenti
2. Folio utilizza un sistema di routing basato sui file
3. Volt richiede una dichiarazione esplicita per i componenti anonimi

## Soluzioni Possibili

### 1. Utilizzare la Direttiva @volt
```blade
@volt
<div>
    <!-- Contenuto del componente -->
</div>
@endvolt
```

### 2. Utilizzare un Form Standard (Soluzione Consigliata)
```blade
<form action="{{ route('logout') }}" method="post">
    @csrf
    <button type="submit">Logout</button>
</form>
```

### 3. Creare un Componente Volt Dedicato
```php
// resources/views/components/logout-form.blade.php
@volt('logout-form')
<div>
    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit">Logout</button>
    </form>
</div>
@endvolt
```

## Best Practices
1. Per pagine semplici come il logout, preferire form standard
2. Utilizzare Volt solo quando necessario (interattività complessa)
3. Mantenere la separazione tra Folio e Volt
4. Documentare chiaramente l'approccio scelto

## Collegamenti
- [Documentazione Volt](https://livewire.laravel.com/docs/volt)
- [Documentazione Folio](https://laravel.com/docs/folio)
- [Best Practices Routing](./ROUTING_BEST_PRACTICES.md) 
