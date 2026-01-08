# Pattern di Autoload nei Moduli Laravel

## Il Pattern Corretto

Nei moduli Laravel con Nwidart, esiste un pattern specifico per l'autoload delle classi che deve essere rispettato per evitare errori di namespace.

### Struttura di Base

1. **Struttura fisica dei file**:
   ```
   Modules/
     ModuleName/
       app/
         Console/
           Commands/
             MyCommand.php
   ```

2. **Namespace corretto nei file**:
   ```php
   namespace Modules\ModuleName\Console\Commands;
   ```

3. **Configurazione corretta dell'autoload in composer.json**:
   ```json
   "autoload": {
     "psr-4": {
       "Modules\\ModuleName\\": ""
     }
   }
   ```

## Errore Comune

Un errore comune è impostare l'autoload in questo modo:

```json
"autoload": {
  "psr-4": {
    "Modules\\ModuleName\\": "app/"
  }
}
```

Questo crea una discrepanza tra:
- Il namespace logico: `Modules\ModuleName\Console\Commands`
- Dove l'autoloader cerca il file: `app/Console/Commands/MyCommand.php`

### Sintomo dell'Errore

Quando si verifica questo errore, il sistema cercherà la classe in un namespace errato:

```
Target class [Modules\ModuleName\App\Console\Commands\MyCommand] does not exist.
```

## Come Risolvere

### Soluzione 1: Correggere l'autoload in composer.json

```json
"autoload": {
  "psr-4": {
    "Modules\\ModuleName\\": ""
  }
}
```

### Soluzione 2: Adattare i namespace nei file

Se non è possibile modificare composer.json, adattare i namespace nei file:

```php
namespace Modules\ModuleName\App\Console\Commands;
```

## Best Practice

1. **Coerenza**: Mantieni coerenza tra tutti i moduli
2. **Documentazione**: Documenta chiaramente il pattern scelto
3. **Verifica**: Verifica sempre il funzionamento dopo modifiche all'autoload

## Collegamenti

- [Convenzioni di Namespace](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/docs/namespace_conventions.md)
- [Struttura Moduli](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/docs/module_structure.md)
