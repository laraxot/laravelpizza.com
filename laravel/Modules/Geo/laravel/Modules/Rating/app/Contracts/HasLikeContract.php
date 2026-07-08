<?php

declare(strict_types=1);

namespace Modules\Rating\Contracts;

use Modules\Xot\Contracts\UserContract;

/**
 * This interface allows models to receive replies.
 */
interface HasLikeContract
{
    public function isLikedBy(?UserContract $user): bool;

    public function likedBy(?UserContract $user): void;

    public function dislikedBy(?UserContract $user): void;
}
