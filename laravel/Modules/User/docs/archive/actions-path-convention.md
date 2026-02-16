# Convenzione dei Percorsi per le Actions

## Regola Fondamentale
, tutte le Actions devono essere collocate nella directory `app/Actions/` del modulo, seguendo la struttura PSR-4 per l'autoloading.

## Esempi di Percorsi Corretti vs Errati

### ✅ Percorsi Corretti
```
laravel/Modules/User/app/Actions/User/DeleteUserAction.php
laravel/Modules/User/app/Actions/Auth/LoginAction.php
laravel/Modules/User/app/Actions/Profile/UpdateProfileAction.php
```

### ❌ Percorsi Errati
```
laravel/Modules/User/Actions/User/DeleteUserAction.php
laravel/Modules/User/Actions/DeleteUserAction.php
```

## Namespace Corretti
Le Actions devono utilizzare il namespace corretto che riflette la struttura delle directory:

```php
// ✅ CORRETTO
namespace Modules\User\Actions\User;

// ❌ ERRATO
namespace Modules\User\App\Actions\User;
```

## Motivazione
Questa convenzione garantisce:
1. Coerenza con la struttura PSR-4 definita nel composer.json
2. Compatibilità con l'autoloading di Composer
3. Rispetto delle convenzioni per i moduli
4. Facilità di manutenzione e navigazione del codice

## Script di Correzione
Se trovi Actions nella directory errata, puoi utilizzare questo script per correggerle:

```bash
#!/bin/bash
MODULE_NAME="User"  # Sostituisci con il nome del modulo

# Verifica se esistono Actions nella posizione errata
if [ -d "Modules/$MODULE_NAME/Actions" ]; then
    # Crea la directory corretta se non esiste
    mkdir -p "Modules/$MODULE_NAME/app/Actions"
    
    # Sposta i file
    mv "Modules/$MODULE_NAME/Actions"/* "Modules/$MODULE_NAME/app/Actions/"
    
    # Rimuovi la directory vuota
    rmdir "Modules/$MODULE_NAME/Actions"
    
    echo "Actions spostate correttamente nella directory app/Actions/"
else
    echo "Nessuna Action trovata nella posizione errata"
fi
```

## Collegamenti
- [Convenzioni Path nei Moduli Laravel](./PATH_CONVENTIONS.md)
- [Checklist per la Struttura delle Directory](./DIRECTORY_STRUCTURE_CHECKLIST.md)
- [Analisi Errore: Gestione Percorsi](../../../docs/error_analysis/path_management.md)
