<?php

declare(strict_types=1);

namespace Modules\User\Actions\Login;

use DateTimeInterface;
use Laravel\Pulse\Facades\Pulse;

<<<<<<< HEAD
=======
/**
 * @see docs/contracts/record-login-pulse-action.md
 * @contract docs/contracts/record-login-pulse-action.md
 */
>>>>>>> laraxot/dev
class RecordLoginPulseAction
{
    public function execute(DateTimeInterface $loginAt): void
    {
        Pulse::record(
            type: 'user_login',
            key: 'all',
            timestamp: $loginAt,
        )
            ->count()
            ->onlyBuckets();
    }
}
