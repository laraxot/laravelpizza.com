<?php

declare(strict_types=1);

namespace Modules\User\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * Modules\User\Contracts\TeamInvitationContract.
 *
 * @phpstan-require-extends Model
 *
 * @mixin \Eloquent
 */
interface TeamInvitationContract
{
    public function delete(): void;
}
