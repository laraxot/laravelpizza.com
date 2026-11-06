<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Socialite;

use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Pest\Laravel\get;
use function Pest\Laravel\withSession;
use function Safe\parse_url;

uses(TestCase::class);

/*
 * Accedi con Google sul front office (DCP-269).
 *
 * Il cittadino parte da /{lang}/auth/login e deve restare nella sua lingua per tutto il giro:
 *   pulsante -> /{lang}/auth/login/google -> Google -> /{lang}/auth/login/google/callback -> login.
 * L'ingresso (`oauth.redirect`) e' in Modules/User/routes/socialite.php sotto il prefisso `{lang}`; il ritorno e' la pagina
 * Folio+Volt `pages/auth/login/[provider]/callback.blade.php` (DCP-360). Una *vista* con redirect al livello superiore risponde
 * 200 vuoto e un abort() li' rompe route('login'): il redirect sta in mount() (OauthCallbackFolioPageTest).
 */

dataset('oauth_locales', [
    'it' => ['it', 'Login fallito, riprova.'],
    'en' => ['en', 'Sign-in failed, please try again.'],
    'de' => ['de', 'Anmeldung fehlgeschlagen, versuchen Sie es erneut.'],
    'es' => ['es', 'No se pudo iniciar sesión, inténtalo de nuevo.'],
]);

test('the login page links Google with the active language prefix', function (string $lang): void {
    // DCP-290: il pulsante compare solo con le tre chiavi GOOGLE_* (senza, la pagina non lo mostra: AuthGoogleButtonTest).
    config(['services.google' => ['client_id' => 'test-client', 'client_secret' => 'test-secret', 'redirect' => 'http://localhost/'.$lang.'/auth/login/google/callback']]);
    $html = get('/'.$lang.'/auth/login')->assertOk()->getContent();

    expect($html)
        ->toContain('/'.$lang.'/auth/login/google"')
        ->not->toMatch('~href="[^"]*://[^/"]+/auth/login/google"~');
})->with('oauth_locales');

test('the localized OAuth entry point sends the citizen to Google', function (string $lang): void {
    $callback = 'http://localhost/'.$lang.'/auth/login/google/callback';
    config(['services.google' => ['client_id' => 'test-client', 'client_secret' => 'test-secret', 'redirect' => $callback]]);

    $response = get('/'.$lang.'/auth/login/google');

    $response->assertRedirectContains('accounts.google.com/o/oauth2/auth');
    $location = $response->headers->get('Location');
    Assert::assertIsString($location);
    $parts = parse_url($location);
    $queryString = is_array($parts) && isset($parts['query']) && is_string($parts['query'])
        ? $parts['query']
        : '';
    /** @var array<string, string> $query */
    $query = [];
    parse_str($queryString, $query);
    expect($query['redirect_uri'] ?? null)->toBe($callback);
})->with('oauth_locales');

test('a refused Google consent returns to the login page of the same language', function (string $lang, string $message): void {
    // DCP-271: senza credenziali il callback risponde «provider non configurato»; un consenso negato presuppone un giro vero con Google.
    config(['services.google' => ['client_id' => 'test-client', 'client_secret' => 'test-secret', 'redirect' => 'http://localhost/it/auth/login/google/callback']]);

    $response = get('/'.$lang.'/auth/login/google/callback?error=access_denied');

    $response->assertRedirect('/'.$lang.'/auth/login');
    $response->assertSessionHasErrors(['email' => $message]);
})->with('oauth_locales');

test('the language of the page that started the flow survives the fixed Google callback', function (): void {
    // GOOGLE_REDIRECT_URI e' unico (/it/...): chi parte da /en/ rientra su /it/.../callback.
    config(['services.google' => ['client_id' => 'test-client', 'client_secret' => 'test-secret', 'redirect' => 'http://localhost/it/auth/login/google/callback']]);

    get('/en/auth/login/google')->assertRedirectContains('accounts.google.com');

    get('/it/auth/login/google/callback?error=access_denied')
        ->assertRedirect('/en/auth/login')
        ->assertSessionHasErrors(['email' => 'Sign-in failed, please try again.']);
});

test('invented languages and providers are a 404, not a server error', function (string $path): void {
    get($path)->assertNotFound();
})->with([
    'unknown provider' => '/it/auth/login/nonexistent',
    'unknown provider callback' => '/it/auth/login/nonexistent/callback',
    'unknown language' => '/xx/auth/login/google',
    'unknown language callback' => '/xx/auth/login/google/callback',
]);

test('the login page shows the social login error to the citizen', function (): void {
    $message = 'Sign-in failed, please try again.';
    $errors = (new ViewErrorBag)->put('default', new MessageBag(['email' => [$message]]));

    $html = withSession(['errors' => $errors])->get('/en/auth/login')->assertOk()->getContent();

    // Una sola volta, nel blocco del widget (non un secondo riquadro) e senza il titolo fisso «Invalid credentials».
    expect($html)
        ->toContain('class="auth-login-alert" role="alert"')
        ->and(substr_count((string) $html, $message))->toBe(1)
        ->and($html)->not->toContain('Invalid credentials');
});

test('the login page shows no error block when there is none', function (): void {
    get('/en/auth/login')->assertOk()->assertDontSee('auth-login-alert" role', false);
});

test('Folio named routes resolve, so no page aborts during the route-name scan', function (): void {
    // Folio esegue ogni pagina per leggere `name()`: un `abort()` al livello superiore di una vista
    // faceva lanciare 404 a route('login') in tutta l'applicazione.
    expect(route('login'))->toContain('/auth/login')
        ->and(route('register'))->toContain('/auth/register');
});

test('the Google callback is the redirect-only Folio page', function (): void {
    expect(route('oauth.callback', ['lang' => 'it', 'provider' => 'google']))
        ->toContain('/it/auth/login/google/callback');

    get('/it/auth/login/google/callback?error=access_denied')
        ->assertRedirect('/it/auth/login');
});
