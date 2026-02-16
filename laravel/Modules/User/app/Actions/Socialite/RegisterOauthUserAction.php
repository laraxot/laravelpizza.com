<?php

/**
 * @see https://github.com/DutchCodingCompany/filament-socialite
 */

declare(strict_types=1);

namespace Modules\User\Actions\Socialite;

use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use Modules\User\Events\Registered;
use Modules\User\Models\SocialiteUser;
use Spatie\QueueableAction\QueueableAction;
use Illuminate\Database\DatabaseManager;
use Illuminate\Contracts\Events\Dispatcher;

class RegisterOauthUserAction
{
    use QueueableAction;

    public function __construct(
        private readonly DatabaseManager $dbManager,
        private readonly Dispatcher $eventDispatcher,
    ) {}

    public function execute(string $provider, SocialiteUserContract $oauthUser): SocialiteUser
    {
        $socialiteUser = $this->dbManager->transaction(static function () use ($provider, $oauthUser) {
            // Create a user
            $user = app(CreateUserAction::class)->execute(
                provider: $provider,
                oauthUser: $oauthUser,
            );

            // Create a new socialite user instance
            return app(CreateSocialiteUserAction::class)->execute(
                provider: $provider,
                oauthUser: $oauthUser,
                user: $user,
            );
        });
        // Dispatch the registered event
        $this->eventDispatcher->dispatch(new Registered($socialiteUser));

        // Login the user
        // return app(LoginUserAction::class)->execute($socialiteUser);
        return $socialiteUser;
    }
}
