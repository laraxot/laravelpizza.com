<?php

declare(strict_types=1);

namespace Modules\User\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Modules\User\Enums\FetchUserApiTokenExitCode;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Webmozart\Assert\Assert;

class FetchUserApiTokenCommand extends Command
{
    protected $signature = 'passport:fetch-user-token
                            {email : The email of the user to impersonate}';

    protected $description = 'Fetches an OAuth Token to be able to test APIs';

    public function handle(): int
    {
        if (app()->isProduction()) {
            $this->error('The command cannot be used in PRODUCTION environments');

            return FetchUserApiTokenExitCode::InvalidEnvironment->value;
        }
        Assert::string($email = $this->argument('email'));
        $userEmail = trim($email);
        if (empty($userEmail)) {
            Assert::string($userEmail = $this->ask('Please enter the email of the user to impersonate'));
            $userEmail = trim($userEmail);
        }

        // query diretta (non getUserByEmail, che lancia eccezione): serve il ramo "User not found" con exit code dedicato
        $user = XotData::make()->getUserClass()::query()->where('email', $userEmail)->first();

        // instanceof e non `=== null`: query() fa perdere a PHPStan l'intersezione Model&UserContract,
        // e createToken() e' dichiarato su UserContract.
        if (! $user instanceof UserContract) {
            $this->error('User not found!');

            return FetchUserApiTokenExitCode::UserNotFound->value;
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
