<?php

declare(strict_types=1);

/*
 * Ogni modulo serve i propri file pubblici da laravel/Modules/<Modulo>/public attraverso il symlink
 * public_html/assets/<modulo> -> ../../laravel/Modules/<Modulo>/public (tracciato da git).
 * public_html/assets/.gitignore elenca "<modulo>/": ignora solo una cartella reale con quel nome, cioe' le copie
 * generate al posto del link, che cosi' non finiscono mai nel repository.
 */
test('every module publishes its public folder through a relative symlink in public_html/assets', function (): void {
    $laravel = dirname(__DIR__, 5);
    $assets = dirname($laravel).'/public_html/assets';
    $ignored = array_map('trim', file($assets.'/.gitignore') ?: []);
    // Solo i moduli veri (con module.json): Modules/docs e' documentazione.
    $modules = array_map('dirname', glob($laravel.'/Modules/*/module.json') ?: []);

    expect($modules)->not->toBeEmpty();

    foreach ($modules as $modulePath) {
        $module = basename($modulePath);
        $lower = strtolower($module);
        $link = $assets.'/'.$lower;

        expect(is_dir($modulePath.'/public'))->toBeTrue("Modules/{$module}/public deve esistere")
            ->and(is_link($link))->toBeTrue("public_html/assets/{$lower} deve essere un symlink")
            ->and(readlink($link))->toBe('../../laravel/Modules/'.$module.'/public')
            ->and($ignored)->toContain($lower.'/');
    }
});
