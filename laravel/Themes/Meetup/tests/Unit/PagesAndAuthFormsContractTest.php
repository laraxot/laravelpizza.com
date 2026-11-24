<?php

declare(strict_types=1);

use function Safe\file_get_contents;

/*
 * ADR in docs/adr/: le pagine Folio pubbliche generiche rendono i JSON del CMS con <x-page> (mai un resolver del tema),
 * e i form di login/registrazione sono widget Filament dei moduli. Test sul sorgente, senza app.
 */
function meetupPage(string $relative): string
{
    return file_get_contents(dirname(__DIR__, 2).'/resources/views/pages/'.$relative);
}

test('generic public pages render CMS JSON through x-page', function (string $page): void {
    expect(meetupPage($page))
        ->toContain('<x-page')
        ->not->toContain('content-resolver');
})->with([
    'index.blade.php',
    '[slug].blade.php',
    '[container0]/index.blade.php',
    '[container0]/[slug0]/index.blade.php',
]);

test('login and register forms are module Filament widgets', function (): void {
    expect(meetupPage('auth/login.blade.php'))->toContain('Modules\User\Filament\Widgets\Auth\LoginWidget')
        ->and(meetupPage('auth/register.blade.php'))->toContain('Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget');
});
