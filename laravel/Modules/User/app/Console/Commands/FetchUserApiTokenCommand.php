<?php

declare(strict_types=1);

namespace Modules\User\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Webmozart\Assert\Assert;

class FetchUserApiTokenCommand extends Command
{
    private const INVALID_ENV = 1;

    private const USER_NOT_FOUND = 2;

    protected $signature = 'passport:fetch-user-token
                            {email : The email of the user to impersonate}';

    protected $description = 'Fetches an OAuth Token to be able to test APIs';

    public function handle(): int
    {
        if (app()->isProduction()) {
            $this->error('The command cannot be used in PRODUCTION environments');

            return self::INVALID_ENV;
        }
        Assert::string($email = $this->argument('email'));
        $userEmail = trim($email);
        if (empty($userEmail)) {
            Assert::string($userEmail = $this->ask('Please enter the email of the user to impersonate'));
            $userEmail = trim($userEmail);
        }

        $user_class = XotData::make()->getUserClass();
        /** @var UserContract */
        $user = XotData::make()->getUserByEmail($userEmail);

        if (null === $user) {
            $this->error('User not found!');

            return self::USER_NOT_FOUND;
        }

        $oauthScopes = ['core-technicians'];

        $token = $user->createToken(
            name: sprintf('Debug Token [%s]', Carbon::now()->format('Y-m-d H:i:s')),
            scopes: $oauthScopes,
        );

        $this->info("Access token for `{$userEmail}`:");
        $this->comment($token->accessToken);
        $this->info('Scopes included: '.implode(', ', $oauthScopes));

        return self::SUCCESS;
    }
}
