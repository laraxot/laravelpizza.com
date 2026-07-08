https://fly.io/laravel-bytes/console-applications-with-laravel-zero/

# Comandi Console in Moduli Laraxot

## Namespace Corretto per i Comandi Console

Nei moduli Laraxot, i comandi console **devono** utilizzare il seguente pattern di namespace:

```php
namespace Modules\NomeModulo\Console\Commands;
```

Anche se i file sono fisicamente collocati nella directory `app/Console/Commands` del modulo, il namespace **NON** deve includere il segmento `app`.

### ✅ CORRETTO
```php
namespace Modules\Xot\Console\Commands;
```

### ❌ ERRATO
```php
namespace Modules\Xot\app\Console\Commands;
```

## Esempio di Comando Console

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DatabaseSchemaExportCommand extends Command
{
    /**
     * Il nome e la firma del comando console.
     *
     * @var string
     */
    protected $signature = 'xot:schema-export {connection? : Nome della connessione database} {--output=docs/db_schema.json : Percorso file di output}';

    /**
     * La descrizione del comando console.
     *
     * @var string
     */
    protected $description = 'Esporta lo schema del database in un file JSON completo';

    /**
     * Esegui il comando console.
     */
    public function handle(): int
    {
        // Implementazione
        
        return 0;
    }
}
```

## Risorse Utili
- [Laravel Artisan Console Documentation](https://laravel.com/docs/10.x/artisan)
- [Console Applications with Laravel Zero](https://fly.io/laravel-bytes/console-applications-with-laravel-zero/)
