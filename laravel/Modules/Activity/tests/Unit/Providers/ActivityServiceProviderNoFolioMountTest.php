<?php

declare(strict_types=1);

use function Safe\file_get_contents;

/**
 * Behaviour: ActivityServiceProvider must not call Folio::path (Cms owns mounts).
 * Existing: ActivityServiceProviderTest.php (name/extends only).
 * User: «aggiungere Folio::path in ActivityServiceProvider.php e' sbagliato».
 *
 * @see laravel/Modules/Activity/docs/bmad/stories/folio-routing-centralization.story.md
 */
test('activity service provider source does not mount Folio paths', function (): void {
    $path = dirname(__DIR__, 3).'/app/Providers/ActivityServiceProvider.php';
    expect(is_file($path))->toBeTrue();

    $contents = (string) file_get_contents($path);

    expect($contents)->not->toContain('use Laravel\\Folio\\Folio');
    expect($contents)->not->toContain('Folio::path(');
});
