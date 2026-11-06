<?php

declare(strict_types=1);

namespace Modules\User\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as AuthUser;
use Webmozart\Assert\Assert;

/**
 * Relazione user() null-safe per wrapper Passport Token.
 *
 * Passport accede a $this->client->provider senza null-safe; ide-helper risolve
 * user() su istanze senza client loaded.
 */
trait ResolvesPassportTokenUserRelation
{
    /**
     * @return BelongsTo<AuthUser, $this>
     */
    public function user(): BelongsTo
    {
        $clientProvider = $this->client?->provider;
        $provider = is_string($clientProvider) && $clientProvider !== ''
            ? $clientProvider
            : $this->resolveDefaultApiGuardProvider();

        $modelClassRaw = config('auth.providers.'.$provider.'.model');
        Assert::stringNotEmpty($modelClassRaw, 'auth.providers.'.$provider.'.model must be configured');
        Assert::classExists($modelClassRaw);
        Assert::isAOf($modelClassRaw, AuthUser::class);

        /** @var class-string<AuthUser> $modelClass */
        $modelClass = $modelClassRaw;

        /** @var AuthUser $prototype */
        $prototype = new $modelClass;

        return $this->belongsTo(
            $modelClass,
            'user_id',
            $prototype->getAuthIdentifierName(),
        );
    }

    private function resolveDefaultApiGuardProvider(): string
    {
        $provider = config('auth.guards.api.provider');
        Assert::stringNotEmpty($provider, 'auth.guards.api.provider must be configured');

        return $provider;
    }
}
