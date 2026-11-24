<?php

declare(strict_types=1);

use function Safe\file_get_contents;

it('uses the Xot canonical entrypoint for duplicate empty module route files', function (): void {
    $laravelPath = dirname(__DIR__, 5);
    $routeFiles = [
        'Modules/Job/routes/web.php',
        'Modules/Lang/routes/api.php',
        'Modules/Lang/routes/web.php',
        'Modules/Media/routes/api.php',
        'Modules/Media/routes/web.php',
        'Modules/Rating/routes/api.php',
        'Modules/Rating/routes/web.php',
        'Modules/UI/routes/api.php',
        'Modules/UI/routes/web.php',
    ];

    foreach ($routeFiles as $routeFile) {
        $contents = file_get_contents($laravelPath.'/'.$routeFile);

        expect($contents)
            ->toContain("require base_path('Modules/Xot/routes/empty.php');");
    }

    expect(file_get_contents($laravelPath.'/Modules/Xot/routes/empty.php'))
        ->toContain('return [];');
});
