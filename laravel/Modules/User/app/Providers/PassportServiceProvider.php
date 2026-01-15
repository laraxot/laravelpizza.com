<?php

declare(strict_types=1);

namespace Modules\User\Providers;

use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Modules\User\Models\OauthAuthCode;
use Modules\User\Models\OauthClient;
use Modules\User\Models\OauthDeviceCode;
use Modules\User\Models\OauthRefreshToken;
use Modules\User\Models\OauthToken;
use Webmozart\Assert\Assert;

/**
 * Passport Service Provider.
 *
 * Configura Laravel Passport per l'autenticazione OAuth2.
 * Utilizza la configurazione centralizzata da config/user/passport.php.
 */
class PassportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/passport.php',
            'user.passport'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->configureRoutes();
        $this->configureTokenExpiration();
        $this->configureModels();
        $this->configurePasswordGrant();
        $this->configureScopes();
        $this->registerPolicies();
    }

    /**
     * Configura le rotte Passport.
     */
    protected function configureRoutes(): void
    {
        if (! config('user.passport.register_routes', true)) {
            return;
        }

        if (method_exists(Passport::class, 'routes')) {
            Passport::routes();
        }
    }

    /**
     * Configura le scadenze dei token.
     */
    protected function configureTokenExpiration(): void
    {
        $tokens = config('user.passport.tokens', []);
        Assert::isArray($tokens);

        Passport::tokensExpireIn(
            CarbonInterval::days((int) ($tokens['access_token'] ?? 15))
        );

        Passport::refreshTokensExpireIn(
            CarbonInterval::days((int) ($tokens['refresh_token'] ?? 30))
        );

        Passport::personalAccessTokensExpireIn(
            CarbonInterval::months((int) ($tokens['personal_access_token'] ?? 6))
        );
    }

    /**
     * Configura i modelli personalizzati.
     */
    protected function configureModels(): void
    {
        $models = config('user.passport.models', []);
        Assert::isArray($models);

        $tokenModel = $models['token'] ?? OauthToken::class;
        Assert::stringNotEmpty($tokenModel);
        $refreshTokenModel = $models['refresh_token'] ?? OauthRefreshToken::class;
        Assert::stringNotEmpty($refreshTokenModel);
        $authCodeModel = $models['auth_code'] ?? OauthAuthCode::class;
        Assert::stringNotEmpty($authCodeModel);

        $clientModel = config('user.passport.client_model', OauthClient::class);
        Assert::stringNotEmpty($clientModel);

        /* @var class-string<\Laravel\Passport\Token> $tokenModel */
        Passport::useTokenModel($tokenModel);
        /* @var class-string<\Laravel\Passport\RefreshToken> $refreshTokenModel */
        Passport::useRefreshTokenModel($refreshTokenModel);
        /* @var class-string<\Laravel\Passport\AuthCode> $authCodeModel */
        Passport::useAuthCodeModel($authCodeModel);
        /* @var class-string<\Laravel\Passport\Client> $clientModel */
        Passport::useClientModel($clientModel);

        // @phpstan-ignore-next-line - method_exists check kept for backward compatibility with older Passport versions
        if (method_exists(Passport::class, 'useDeviceCodeModel')) {
            $deviceCodeModel = $models['device_code'] ?? OauthDeviceCode::class;
            Assert::stringNotEmpty($deviceCodeModel);
            /* @var class-string<\Laravel\Passport\DeviceCode> $deviceCodeModel */
            Passport::useDeviceCodeModel($deviceCodeModel);
        }
    }

    /**
     * Configura il password grant.
     */
    protected function configurePasswordGrant(): void
    {
        if (config('user.passport.enable_password_grant', true)) {
            Passport::enablePasswordGrant();
        }
    }

    /**
     * Configura gli scope OAuth2.
     */
    protected function configureScopes(): void
    {
        $scopes = config('user.passport.scopes', []);
        Assert::isArray($scopes);

        foreach ($scopes as $key => $value) {
            Assert::stringNotEmpty($key);
            Assert::stringNotEmpty($value);
        }

        if (! empty($scopes)) {
            // PHPStan: dopo i controlli Assert, l'array è garantito essere array<string, string>
            /** @var array<string, string> $typedScopes */
            $typedScopes = $scopes;
            Passport::tokensCan($typedScopes);
        }
    }

    /**
     * Register policies for OAuth resources.
     */
    protected function registerPolicies(): void
    {
        // Gate::policy(OauthClient::class, OauthClientPolicy::class);
    }
}
