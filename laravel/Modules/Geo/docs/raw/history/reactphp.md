# Gestione Processi ReactPHP

## Descrizione
Il modulo ReactPHP permette di gestire processi asincroni e server in background.

## Caratteristiche
- Server asincroni
- WebSocket
- Processi in background
- Event loop

## Configurazione
```php
require __DIR__ . '/../../../vendor/autoload.php';

use App\Console\Kernel;
use Dotenv\Dotenv;
use React\EventLoop\Factory;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;

Dotenv::create(__DIR__ . '/../../../')->load();

$app = require_once __DIR__ . '/../../../bootstrap/app.php';

/** @var Kernel $kernel */
$kernel = $app->make(Kernel::class);
$loop   = Factory::create();

$loop->addPeriodicTimer(10, function () use ($kernel) {
    $kernel->handle(
        new ArrayInput([
            'command'  => 'task:clean',
            'force' => true,
        ]),
        new ConsoleOutput
    );
});

$loop->run();
```

## Note
- Verificare la compatibilità con la versione di PHP
- Monitorare l'uso delle risorse
- Implementare gestione errori appropriata
- Considerare l'uso di supervisor per processi lunghi 