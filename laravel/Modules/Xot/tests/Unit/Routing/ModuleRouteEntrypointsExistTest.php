<?php

declare(strict_types=1);

use Modules\Xot\Providers\XotBaseRouteServiceProvider;

use function Safe\glob;

/*
 * `XotBaseRouteServiceProvider` carica `routes/web.php` e `routes/api.php` per percorso, a partire da `$module_dir`:
 * un file mancante e' un errore fatale al boot di tutta l'applicazione. Devono esistere in tutti i moduli, anche con il
 * solo `<?php`. Si controllano due insiemi: i file del modulo (la regola) e quelli che il provider carica davvero,
 * perche' un provider che non ridefinisce `$module_dir` eredita la cartella di Xot e carica le route di Xot.
 */
it('has routes/web.php and routes/api.php in every module that uses XotBaseRouteServiceProvider', function (): void {
    $laravelPath = dirname(__DIR__, 5);
    $checked = 0;
    $missing = [];

    foreach (glob($laravelPath.'/Modules/*/app/Providers/RouteServiceProvider.php') as $provider) {
<<<<<<< .merge_file_x2d3nT
        if (! is_string($provider)) {
            $missing[] = 'non-string glob entry';

            continue;
        }

=======
>>>>>>> .merge_file_9UFmVC
        $module = dirname($provider, 3);
        $class = 'Modules\\'.basename($module).'\\Providers\\RouteServiceProvider';

        if (! class_exists($class)) {
            $missing[] = 'class not found: '.$class;

            continue;
        }

        if (! is_subclass_of($class, XotBaseRouteServiceProvider::class)) {
            continue;
        }

        $checked++;
<<<<<<< .merge_file_x2d3nT
        $moduleDir = (new ReflectionClass($class))->getDefaultProperties()['module_dir'] ?? null;

        if (! is_string($moduleDir)) {
            $missing[] = 'module_dir is not a string: '.$class;

            continue;
        }

        $loadedModule = dirname($moduleDir, 2);
=======
        $loadedModule = dirname((string) (new ReflectionClass($class))->getDefaultProperties()['module_dir'], 2);
>>>>>>> .merge_file_9UFmVC

        foreach (['web', 'api'] as $file) {
            foreach (array_unique([$module, $loadedModule]) as $root) {
                if (! is_file($root.'/routes/'.$file.'.php')) {
                    $missing[] = basename($root).'/routes/'.$file.'.php';
                }
            }
        }
    }

    expect($checked)->toBeGreaterThan(0)
        ->and($missing)->toBe([]);
});
