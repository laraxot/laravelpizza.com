<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Socialite;

use Illuminate\Support\Facades\Route;
use Modules\User\Actions\Socialite\ProcessCallbackAction;
use Modules\User\Actions\Socialite\ProcessCallbackSession;
use Modules\User\Tests\TestCase;

use function Pest\Laravel\get;
use function Pest\Laravel\withSession;
use function Safe\file_get_contents;

uses(TestCase::class);

/*
 * DCP-360: il ritorno da Google e' una pagina Folio+Volt (`pages/auth/login/[provider]/callback.blade.php`), non un controller con una
 * rotta scritta a mano. La logica sta in `ProcessCallbackAction`; la pagina e' solo l'ingresso (`mount()` + redirect).
 * Il comportamento (consenso negato, lingua d'ingresso, 404 su lingua o provider inventati) lo prova OauthLocalizedLoginFlowTest.
 */

test('the callback is a Folio page, not a controller route', function (): void {
    $page = base_path('Themes/Sixteen/resources/views/pages/auth/login/[provider]/callback.blade.php');

    // nessun controller di callback: la rotta e' la pagina Folio (DCP-360), non un adattatore che la rimette in vita
    expect(is_file(base_path('Modules/User/app/Http/Controllers/Socialite/ProcessCallbackController.php')))->toBeFalse()
        ->and(Route::getRoutes()->getByName('oauth.callback'))->toBeNull()
        ->and(is_file($page))->toBeTrue()
        ->and((string) file_get_contents($page))->toContain("@volt('auth.login.oauth-callback')")
        ->and((string) file_get_contents($page))->toContain('new class extends Component')
        ->and(class_exists(ProcessCallbackAction::class))->toBeTrue();
});

test('the callback name still resolves to the localized URL', function (string $lang): void {
    app()->setLocale($lang);

    expect(route('oauth.callback', ['provider' => 'google']))->toContain('/'.$lang.'/auth/login/google/callback');
})->with(['it', 'en', 'de', 'es']);

test('the callback page answers with a real redirect, not an empty 200', function (): void {
    config(['services.google' => ['client_id' => 'test-client', 'client_secret' => 'test-secret', 'redirect' => 'http://localhost/it/auth/login/google/callback']]);

    // senza `code` Google non e' tornato: il cittadino rientra nel login, con status 302 (mai una pagina vuota con 200)
    get('/it/auth/login/google/callback')->assertStatus(302)->assertRedirect('/it/auth/login');
});

test('the entry language is read and consumed by the Action', function (): void {
    config(['services.google' => ['client_id' => 'test-client', 'client_secret' => 'test-secret', 'redirect' => 'http://localhost/it/auth/login/google/callback']]);

    withSession([ProcessCallbackSession::KEY => 'en'])
        ->get('/it/auth/login/google/callback?error=access_denied')
        ->assertRedirect('/en/auth/login');

    expect(session()->has(ProcessCallbackSession::KEY))->toBeFalse();
});
