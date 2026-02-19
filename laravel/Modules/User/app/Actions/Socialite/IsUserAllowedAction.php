<?php

/**
 * @see https://github.com/DutchCodingCompany/filament-socialite
 */

declare(strict_types=1);

namespace Modules\User\Actions\Socialite;

use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class IsUserAllowedAction
{
    use QueueableAction;

    public function __construct(
        private readonly Assert $assert,
        private readonly Str $stringHelper,
    ) {
    }

    /**
     * Execute the action.
     */
    public function execute(SocialiteUserContract $user): bool
    {
        $domains = app(GetDomainAllowListAction::class)->execute();

        // When no domains are specified, all users are allowed
        if (\count($domains) < 1) {
            return true;
        }

        $this->assert->notNull($user->getEmail(), '['.__FILE__.']['.__LINE__.']');
        // Get the domain of the email for the specified user
        $emailDomain = $this->stringHelper->of($user->getEmail())
            ->afterLast('@')
            ->lower()
            ->__toString();

        // See if everything after @ is in the domains array
        return \in_array($emailDomain, $domains, false);
    }
}
