<?php

declare(strict_types=1);

use App\Application;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;
use function Safe\mkdir;
use function Safe\realpath;

/**
 * Guardia di regressione: il document root del progetto e' `public_html/`, non `laravel/public/`.
 *
 * Non e' una preferenza di deploy: `public_html/index.php` e' l'unico front controller servito,
 * e fa `require LARAVEL_DIR.'/bootstrap/app.php'` risalendo di un livello. `laravel/public/`
 * esiste solo come residuo dello scheletro Laravel: scriverci dentro (build Vite, storage:link,
 * asset di un tema) produce file che nessuna richiesta HTTP potra' mai raggiungere — un guasto
 * silenzioso, senza errori e senza log.
 *
 * L'override vive in {@see App\Application::publicPath()} ed e' cablato in `bootstrap/app.php`.
 * Questi test coprono i due modi in cui la regola puo' rompersi: il ritorno del metodo, e il
 * cablaggio che lo rende effettivo.
 *
 * @see docs/wiki/rules/public-path-is-public-html.md
 */
it('risolve publicPath sotto public_html e mai sotto laravel/public', function (): void {
    $root = sys_get_temp_dir().'/publicpath-'.uniqid('', true);
    $basePath = $root.'/laravel';

    mkdir($basePath.'/public', 0o777, true);
    mkdir($root.'/public_html/build', 0o777, true);

    $app = new Application($basePath);

    $resolved = $app->publicPath('build');

    Assert::assertSame(realpath($root.'/public_html/build'), $resolved);
    Assert::assertStringNotContainsString(
        DIRECTORY_SEPARATOR.'laravel'.DIRECTORY_SEPARATOR.'public',
        $resolved,
        'publicPath() e\' tornato dentro laravel/public: il document root e\' public_html.',
    );
});

it('mantiene public_html anche per un percorso non ancora esistente', function (): void {
    $root = sys_get_temp_dir().'/publicpath-'.uniqid('', true);
    $basePath = $root.'/laravel';

    mkdir($basePath.'/public', 0o777, true);
    mkdir($root.'/public_html', 0o777, true);

    // Caso reale: `php artisan storage:link` o una build Vite creano il segmento dopo.
    $resolved = (new Application($basePath))->publicPath('storage');

    Assert::assertSame(realpath($root.'/public_html').'/storage', $resolved);
});

it('cabla App\\Application in bootstrap/app.php', function (): void {
    // Senza questo require l'override esiste ma non e' mai attivo: il framework
    // userebbe Illuminate\Foundation\Application e public_path() tornerebbe laravel/public.
    // Path da __DIR__ e non da base_path(): i test qui sopra istanziano Application su una
    // temp dir e quella diventa l'istanza del container, spostando base_path() sotto /tmp.
    $bootstrap = file_get_contents(dirname(__DIR__, 5).'/bootstrap/app.php');

    Assert::assertStringContainsString('use App\Application;', $bootstrap);

    // Il file tiene l'import del framework commentato come promemoria: conta la riga attiva.
    Assert::assertDoesNotMatchRegularExpression(
        '/^\s*use Illuminate\\\\Foundation\\\\Application;/m',
        $bootstrap,
        'bootstrap/app.php deve istanziare App\\Application, non quella del framework.',
    );
});

it('serve le richieste da public_html/index.php', function (): void {
    $frontController = dirname(__DIR__, 6).'/public_html/index.php';

    Assert::assertFileExists($frontController);
    Assert::assertStringContainsString(
        "LARAVEL_DIR.'/bootstrap/app.php'",
        file_get_contents($frontController),
    );
});
