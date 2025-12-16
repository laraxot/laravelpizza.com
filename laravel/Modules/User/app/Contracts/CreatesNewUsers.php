<?php

declare(strict_types=1);

namespace Modules\User\Contracts;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Contracts\UserContract;

/**
 * @phpstan-require-extends Model
 */
interface CreatesNewUsers
{
    /**
     * Create a newly registered user.
     */
    public function create(array $input): UserContract;
}
