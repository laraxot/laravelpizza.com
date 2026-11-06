<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Socialite;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ViewErrorBag;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Psr\Log\AbstractLogger;

use function Pest\Laravel\get;

uses(TestCase::class);

/*
 * Accedi con Google senza credenziali (DCP-271).
 *
 * Senza GOOGLE_CLIENT_ID/SECRET/REDIRECT_URI il pulsante mandava il cittadino a una pagina di errore di Google
 * («Missing required parameter: client_id»). Ora il clic torna a /{lang}/auth/login con un errore nostro:
 * in debug con la guida (cosa manca, dove creare le chiavi, dove impostarle), altrimenti gentile e senza dettagli.
 */

/** Legge l'errore «email» che RedirectToLoginAction ha messo in sessione. */
final class NotConfiguredErrorProbe
{
    public static function message(): string
    {
        $bag = session('errors');
        Assert::assertInstanceOf(ViewErrorBag::class, $bag);
        $message = $bag->getBag('default')->first('email');
        Assert::assertIsString($message);

        return $message;
    }
}

/** Registro di prova al posto del canale di log: in test LOG_LEVEL=error scarterebbe i warning. */
final class NotConfiguredRecordingLogger extends AbstractLogger
{
    /** @var list<array{string, string}> */
    private array $records = [];

    public function log(mixed $level, string|\Stringable $message, array $context = []): void
    {
        $this->records[] = [is_string($level) ? $level : '', (string) $message];
    }

    /**
     * @return list<string> livelli dei messaggi che contengono $needle
     */
    public function levelsOf(string $needle): array
    {
        $levels = [];
        foreach ($this->records as [$level, $message]) {
            if (str_contains($message, $needle)) {
                $levels[] = $level;
            }
        }

        return $levels;
    }
}

dataset('oauth_not_configured_locales', ['it', 'en', 'de', 'es']);

beforeEach(function (): void {
    config([
        'app.debug' => true,
        'services.google' => ['client_id' => null, 'client_secret' => null, 'redirect' => null],
    ]);
});

test('without credentials the entry point never reaches Google and returns to the login of the same language', function (string $lang): void {
    $response = get('/'.$lang.'/auth/login/google');

    $response->assertRedirect('/'.$lang.'/auth/login');
    $response->assertSessionHasErrors('email');
    Assert::assertStringNotContainsString('accounts.google.com', (string) $response->headers->get('Location'));
})->with('oauth_not_configured_locales');

test('in debug the error says what is missing, where to create the keys and where to set them, in every language', function (): void {
    $messages = [];
    foreach (['it', 'en', 'de', 'es'] as $lang) {
        get('/'.$lang.'/auth/login/google');
        $messages[$lang] = NotConfiguredErrorProbe::message();

        expect($messages[$lang])
            ->toContain('GOOGLE_CLIENT_ID')
            ->toContain('GOOGLE_CLIENT_SECRET')
            ->toContain('GOOGLE_REDIRECT_URI')
            ->toContain('console.developers.google.com/auth/clients')
            ->toContain('/auth/login/google/callback')
            ->toContain('socialite-provider-settings-page')
            ->toContain('.env')
            ->toContain('config:clear');
    }

    expect(array_unique($messages))->toHaveCount(4);
});

test('without debug the error is friendly and leaks no infrastructure detail', function (string $lang): void {
    config(['app.debug' => false]);

    get('/'.$lang.'/auth/login/google')->assertRedirect('/'.$lang.'/auth/login');

    expect(NotConfiguredErrorProbe::message())
        ->not->toBeEmpty()
        ->not->toContain('GOOGLE_')
        ->not->toContain('.env')
        ->not->toContain('console.')
        ->not->toContain('artisan');
})->with('oauth_not_configured_locales');

test('a placeholder counts as missing and only what is missing is listed', function (): void {
    config(['services.google' => [
        'client_id' => 'google-client-id.apps.googleusercontent.com',
        'client_secret' => 'a-real-looking-secret',
        'redirect' => 'your-microsoft-redirect-uri.com/auth/callback',
    ]]);

    get('/it/auth/login/google')->assertRedirect('/it/auth/login');

    expect(NotConfiguredErrorProbe::message())
        ->toContain('GOOGLE_CLIENT_ID')
        ->toContain('GOOGLE_REDIRECT_URI')
        ->not->toContain('GOOGLE_CLIENT_SECRET');
});

test('a LAN address is not accepted by Google, so the guide proposes localhost', function (): void {
    get('http://192.168.1.40:8000/it/auth/login/google')->assertRedirect('/it/auth/login');

    expect(NotConfiguredErrorProbe::message())
        ->toContain('http://localhost:8000/it/auth/login/google/callback')
        ->not->toContain('192.168.1.40:8000/it/auth/login/google/callback');
});

test('on a host Google accepts the guide gives the exact callback of that host and no SSH tunnel hint', function (string $origin): void {
    get($origin.'/it/auth/login/google');

    expect(NotConfiguredErrorProbe::message())
        ->toContain($origin.'/it/auth/login/google/callback')
        ->not->toContain('SSH');
})->with([
    'public https host' => 'https://example.org',
    'localhost with a port' => 'http://localhost:8000',
]);

test('the missing configuration is logged once as a warning, not as an error with a stack trace', function (): void {
    $logger = new NotConfiguredRecordingLogger;
    Log::swap($logger);

    get('/it/auth/login/google');

    expect($logger->levelsOf('GOOGLE_CLIENT_ID'))->toBe(['warning']);
});

test('a complete configuration still goes to Google', function (): void {
    config(['services.google' => [
        'client_id' => 'test-client',
        'client_secret' => 'test-secret',
        'redirect' => 'http://localhost/it/auth/login/google/callback',
    ]]);

    get('/it/auth/login/google')->assertRedirectContains('accounts.google.com/o/oauth2/auth');
});
