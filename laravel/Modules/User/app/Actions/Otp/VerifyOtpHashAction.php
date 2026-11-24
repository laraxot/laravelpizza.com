<?php

declare(strict_types=1);

namespace Modules\User\Actions\Otp;

use Illuminate\Contracts\Hashing\Hasher;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/verify-otp-hash-action.md
 *
 * @contract docs/contracts/verify-otp-hash-action.md
 */
final class VerifyOtpHashAction
{
    use QueueableAction;

    public function __construct(
        private readonly Hasher $hasher,
    ) {}

    public function execute(string $value, string $hashedValue): bool
    {
        return $this->hasher->check($value, $hashedValue);
    }
}
