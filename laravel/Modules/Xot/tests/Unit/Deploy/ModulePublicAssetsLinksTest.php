<?php

declare(strict_types=1);

use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file;
use function Safe\file_get_contents;
use function Safe\glob;

uses(TestCase::class);

/*
 * Regola: public_html/assets/<modulo in minuscolo> e' un symlink a ../../laravel/Modules/<Modulo>/public (lo crea deploy.sh).
 * Il contenuto appartiene al repository del modulo, quindi il repository radice non versiona il link: ogni modulo con una
 * cartella `public` deve avere la sua voce `<modulo>/` in public_html/assets/.gitignore.
 */
it('lists every module public folder in public_html/assets/.gitignore', function (): void {
    $gitignore = base_path('../public_html/assets/.gitignore');
    Assert::assertFileExists($gitignore);
    // Safe\file() e Safe\glob() dichiarano `array` generico: si tengono le sole stringhe, come in JobFilamentSchemaCoverageTest.
    $entries = array_map(trim(...), array_filter(file($gitignore), is_string(...)));

    foreach (array_filter(glob(base_path('Modules/*/public'), GLOB_ONLYDIR), is_string(...)) as $publicDir) {
        $module = mb_strtolower(basename(dirname($publicDir)));
        Assert::assertContains($module.'/', $entries, "Manca '{$module}/' in public_html/assets/.gitignore");
    }
});

it('creates the module asset links in deploy.sh instead of copying', function (): void {
    $deploy = file_get_contents(base_path('../deploy.sh'));
    // Contano i soli comandi: un commento che spiega «niente npm run copy» non e' una copia.
    $commands = implode("\n", array_filter(
        array_map(trim(...), explode("\n", $deploy)),
        static fn (string $line): bool => $line !== '' && ! str_starts_with($line, '#'),
    ));

    Assert::assertStringContainsString('for module_public in Modules/*/public; do', $commands);
    Assert::assertStringContainsString('"../../laravel/Modules/$module/public"', $commands);
    Assert::assertStringNotContainsString('npm run copy', $commands);
});

it('builds the Geo assets inside the module', function (): void {
    $vite = file_get_contents(base_path('Modules/Geo/vite.config.js'));

    // L'output resta in Modules/Geo/public: vale sia la forma letterale sia resolve(__dirname, 'public').
    Assert::assertMatchesRegularExpression(
        '/outDir:\s*(?:\'\.\/public\'|resolve\(__dirname,\s*\'public\'\))/',
        $vite,
    );
    Assert::assertFileExists(base_path('Modules/Geo/public/manifest.json'));
});
