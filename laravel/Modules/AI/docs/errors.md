# Errori Comuni e Soluzioni

## Errore: Undefined array key "class" in LaravelModulesServiceProvider

### Descrizione dell'Errore
Questo errore si verifica quando Laravel Modules non riesce a trovare la configurazione corretta per l'attivatore dei moduli. L'errore specifico si verifica nel file `LaravelModulesServiceProvider.php` alla riga 92, quando tenta di accedere alla chiave 'class' nella configurazione dell'attivatore.

### Causa
L'errore si verifica perché:
1. La configurazione dell'attivatore non è definita correttamente nel file `config/modules.php`
2. La chiave 'class' manca nella configurazione dell'attivatore specificato

### Soluzione

1. Verifica che il file `config/modules.php` esista e contenga la configurazione corretta:

```php
return [
    'activator' => 'file', // o 'database'
    
    'activators' => [
        'file' => [
            'class' => \Nwidart\Modules\Activators\FileActivator::class,
            'statuses-file' => base_path('modules_statuses.json'),
            'cache-key' => 'activator.installed',
            'cache-lifetime' => 604800,
        ],
        'database' => [
            'class' => \Nwidart\Modules\Activators\DatabaseActivator::class,
            'statuses-table' => 'module_statuses',
            'cache-key' => 'activator.installed',
            'cache-lifetime' => 604800,
        ],
    ],
];
```

2. Se stai usando l'attivatore database, assicurati di:
   - Aver eseguito le migrazioni necessarie
   - Aver configurato correttamente il database
   - Aver specificato 'database' come attivatore nella configurazione

3. Se stai usando l'attivatore file, assicurati che:
   - Il file `modules_statuses.json` esista nella root del progetto
   - Il file abbia i permessi di scrittura corretti
   - La configurazione punti al percorso corretto del file

### Verifica della Soluzione

Dopo aver applicato le correzioni, puoi verificare che tutto funzioni correttamente eseguendo:

```bash
php artisan module:list
```

Se l'errore persiste, prova a:
1. Cancellare la cache della configurazione:
```bash
php artisan config:clear
```

2. Ricompilare la cache della configurazione:
```bash
php artisan config:cache
```

## Errore: Non conformità PSR-4 Autoloading Standard

### Descrizione dell'Errore
Questo errore si verifica quando le classi nei moduli non seguono lo standard PSR-4 per l'autoloading. L'errore tipico è:
```
Class Modules\ModuleName\Database\Seeders\ModuleNameDatabaseSeeder located in ./Modules/ModuleName/database/Seeders/ModuleNameDatabaseSeeder.php does not comply with psr-4 autoloading standard (rule: Modules\ => ./Modules). Skipping.
```

### Causa
L'errore si verifica perché:
1. Le cartelle nei moduli non seguono la convenzione di naming PSR-4 (case-sensitive)
2. La struttura delle directory non corrisponde al namespace dichiarato
3. I file sono in posizioni non standard rispetto al namespace

### Soluzione

1. Correggi la struttura delle directory per seguire PSR-4:
   - `database/Seeders` → `database/seeders`
   - `database/Factories` → `database/factories`
   - `http/Livewire` → `Http/Livewire`
   - `tests/Feature` → `Tests/Feature`

2. Aggiorna il `composer.json` del modulo per riflettere la struttura corretta:

```json
{
    "autoload": {
        "psr-4": {
            "Modules\\ModuleName\\": "app/",
            "Modules\\ModuleName\\Database\\Factories\\": "database/factories/",
            "Modules\\ModuleName\\Database\\Seeders\\": "database/seeders/"
        }
    }
}
```

3. Esegui i seguenti comandi per aggiornare l'autoloader:
```bash
composer dump-autoload
php artisan optimize:clear
```

### Verifica della Soluzione

Dopo aver applicato le correzioni, verifica che non ci siano più errori di autoloading eseguendo:
```bash
composer dump-autoload
php artisan config:clear
```

### Note Aggiuntive
- Questo errore è comune durante la migrazione da versioni precedenti di Laravel Modules
- Assicurati che tutti i moduli seguano la stessa convenzione di naming
- Usa `composer.json` per definire correttamente i namespace e i percorsi
- Mantieni la coerenza tra la struttura delle directory e i namespace

### Note Aggiuntive
- Questo errore è comune durante la migrazione da versioni precedenti di Laravel Modules
- Assicurati di avere la versione corretta di `nwidart/laravel-modules` nel tuo `composer.json`
- Se stai usando un attivatore personalizzato, verifica che la classe sia correttamente definita e implementi l'interfaccia `ActivatorInterface` 
