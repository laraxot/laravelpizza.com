# Requisiti per i Service Provider che estendono XotBaseServiceProvider

## Data: 31 Marzo 2025

## Problema Identificato
I service provider che estendono `XotBaseServiceProvider` devono definire obbligatoriamente alcune proprietà per funzionare correttamente, in particolare:

- `$name`: Nome del modulo (deve essere non vuoto)
- `$module_dir`: Directory del modulo
- `$module_ns`: Namespace del modulo

## Errore Comune
L'errore più frequente è l'assenza della proprietà `$name` nei service provider che estendono `XotBaseServiceProvider`, che porta all'eccezione:

```
name is empty on [Modules\NomeModulo\Providers\RouteServiceProvider]
```

## Struttura Corretta
Ogni service provider che estende `XotBaseServiceProvider` deve definire questa struttura:

```php
<?php

namespace Modules\NomeModulo\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class RouteServiceProvider extends XotBaseServiceProvider
{
    // Obbligatorio: nome del modulo (deve corrispondere al nome della cartella del modulo)
    public string $name = 'NomeModulo'; 
    
    // Obbligatorio: directory corrente del provider
    protected string $module_dir = __DIR__;
    
    // Obbligatorio: namespace corrente
    protected string $module_ns = __NAMESPACE__;
    
    // Altri metodi e proprietà...
}
```

## Impatto sul Sistema
La mancata dichiarazione della proprietà `$name` provoca:

- Errori di esecuzione con eccezioni che interrompono l'avvio dell'applicazione
- Problemi nella registrazione delle traduzioni, viste e configurazioni
- Potenziali problemi di memoria e timeout dovuti alla gestione errata dei service provider

## Implementazione Corretta
La proprietà `$name` deve:

1. Essere dichiarata come `public string`
2. Contenere esattamente il nome del modulo (sensibile alle maiuscole)
3. Corrispondere al nome della directory del modulo in `/Modules`

## Verifiche Automatiche
Il sistema ora include controlli di validazione nei metodi `register()` e `boot()` di `XotBaseServiceProvider` che garantiscono che queste proprietà siano correttamente definite.
