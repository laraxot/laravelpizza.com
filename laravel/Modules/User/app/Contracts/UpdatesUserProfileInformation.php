<?php

declare(strict_types=1);

namespace Modules\User\Contracts;

use Modules\Xot\Contracts\UserContract;

/**
 * ---.
 */
interface UpdatesUserProfileInformation
{
    /**
     * @param  array<string, mixed>  $input
     */
    public function update(UserContract $userContract, array $input): void;
}
