<?php

declare(strict_types=1);

namespace Modules\User\Actions\Otp;

use Illuminate\Support\Facades\Hash;

class Hasher
{
    public function make(string $value): string
    {
        return Hash::make($value);
    }

    public function check(string $value, string $hashedValue): bool
    {
        return Hash::check($value, $hashedValue);
    }

    public function needsRehash(string $hashedValue): bool
    {
        return Hash::needsRehash($hashedValue);
    }
}
