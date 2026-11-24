<?php

declare(strict_types=1);

namespace Modules\User\Actions\Otp;

use Illuminate\Contracts\Hashing\Hasher;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/otp-hash-needs-rehash-action.md
 *
 * @contract docs/contracts/otp-hash-needs-rehash-action.md
 */
final class OtpHashNeedsRehashAction
{
    use QueueableAction;

    public function __construct(
        private readonly Hasher $hasher,
    ) {}

    public function execute(string $hashedValue): bool
    {
        return $this->hasher->needsRehash($hashedValue);
    }
}
