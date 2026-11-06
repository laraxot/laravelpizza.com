<?php

declare(strict_types=1);

use Modules\User\Actions\Socialite\GetMissingProviderSettingsAction;
use Modules\User\Actions\Socialite\GetProviderRedirectUriAction;
use Modules\User\Actions\Socialite\IsProviderConfiguredAction;
use Modules\User\Actions\Socialite\ValidateProviderAction;
use Modules\User\Exceptions\ProviderNotConfigured;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;

uses(TestCase::class);

/*
 * DCP-271: «configurato» non vuol dire che la chiave `services.<provider>` esiste (config/services.php la dichiara sempre,
 * con env() = null), ma che client_id, client_secret e redirect hanno un valore vero.
 */
describe('Socialite provider settings', function (): void {
    it('lists every environment variable when the provider has no values', function (): void {
        config(['services.google' => ['client_id' => null, 'client_secret' => null, 'redirect' => null]]);

        Assert::assertSame(
            ['GOOGLE_CLIENT_ID', 'GOOGLE_CLIENT_SECRET', 'GOOGLE_REDIRECT_URI'],
            app(GetMissingProviderSettingsAction::class)->execute('google'),
        );
    });

    it('treats blanks and known placeholders as missing', function (string $value): void {
        config(['services.google' => ['client_id' => $value, 'client_secret' => 'a-secret', 'redirect' => 'https://example.org/it/auth/login/google/callback']]);

        Assert::assertSame(['GOOGLE_CLIENT_ID'], app(GetMissingProviderSettingsAction::class)->execute('google'));
    })->with([
        'empty' => '',
        'blank' => '   ',
        'google sample' => 'google-client-id.apps.googleusercontent.com',
        'services.php sample' => 'your-microsoft-redirect-uri.com/auth/callback',
        'upper case sample' => 'YOUR_CLIENT_ID',
        'changeme' => 'changeme',
    ]);

    it('lists nothing for a complete configuration', function (): void {
        config(['services.google' => ['client_id' => 'abc.apps.googleusercontent.com', 'client_secret' => 'GOCSPX-abc', 'redirect' => 'https://example.org/it/auth/login/google/callback']]);

        Assert::assertSame([], app(GetMissingProviderSettingsAction::class)->execute('google'));
    });

    it('names the variables after the provider', function (): void {
        config(['services.github' => ['client_id' => null, 'client_secret' => null, 'redirect' => null]]);

        Assert::assertSame(
            ['GITHUB_CLIENT_ID', 'GITHUB_CLIENT_SECRET', 'GITHUB_REDIRECT_URI'],
            app(GetMissingProviderSettingsAction::class)->execute('github'),
        );
    });

    it('lists every variable for a provider without any services entry', function (): void {
        Assert::assertCount(3, app(GetMissingProviderSettingsAction::class)->execute('pest-missing-socialite-provider'));
    });

    it('is configured only when nothing is missing', function (): void {
        config(['services.google' => ['client_id' => 'id']]);
        Assert::assertFalse(app(IsProviderConfiguredAction::class)->execute('google'));

        config(['services.google' => ['client_id' => 'id', 'client_secret' => 'secret', 'redirect' => 'https://example.org/it/auth/login/google/callback']]);
        Assert::assertTrue(app(IsProviderConfiguredAction::class)->execute('google'));
    });

    it('refuses a provider with missing settings and carries the variable names', function (): void {
        config(['services.google' => ['client_id' => 'id', 'client_secret' => null, 'redirect' => null]]);

        try {
            app(ValidateProviderAction::class)->execute('google');
            Assert::fail('Expected ProviderNotConfigured was not thrown');
        } catch (ProviderNotConfigured $exception) {
            Assert::assertSame('google', $exception->provider);
            Assert::assertSame(['GOOGLE_CLIENT_SECRET', 'GOOGLE_REDIRECT_URI'], $exception->missing);
        }
    });

    it('gives the single callback URI to register, in the default language', function (): void {
        config(['app.locale' => 'it']);

        Assert::assertStringEndsWith('/it/auth/login/google/callback', app(GetProviderRedirectUriAction::class)->execute('google'));
        Assert::assertStringEndsWith('/it/auth/login/github/callback', app(GetProviderRedirectUriAction::class)->execute('github'));
    });

    it('keeps the back office settings page on the shared callback URI, not on the positional route that threw', function (): void {
        // route('oauth.callback', 'google') lancia UrlGenerationException dal 2026-10-20 (la rotta vuole {lang} e {provider}).
        $source = file_get_contents(dirname(__DIR__, 4).'/app/Filament/Pages/SocialiteProviderSettingsPage.php');

        Assert::assertDoesNotMatchRegularExpression("~route\\(\\s*'oauth\\.callback'\\s*,\\s*'~", $source);
        Assert::assertStringContainsString('GetProviderRedirectUriAction', $source);
    });
});
