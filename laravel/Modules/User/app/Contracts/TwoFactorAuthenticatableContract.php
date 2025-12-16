<?php

declare(strict_types=1);

namespace Modules\User\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * Modules\User\Contracts\TwoFactorAuthenticatableContract.
 *
 * @phpstan-require-extends Model
 *
 * @mixin \Eloquent
 */
interface TwoFactorAuthenticatableContract
{
    /**
     * Determine if two-factor authentication has been enabled.
     */
    public function hasEnabledTwoFactorAuthentication(): bool;

    public function hasConfirmedTwoFactorAuthentication(): bool;

    /**
     * Get the user's two factor authentication recovery codes.
     */
    public function recoveryCodes(): array;

    /**
     * Replace the given recovery code with a new one in the user's stored codes.
     */
    public function replaceRecoveryCode(string $code): void;

    /**
     * Get the QR code SVG of the user's two factor authentication QR code URL.
     */
    public function twoFactorQrCodeSvg(): string;

    /**
     * Get the two factor authentication QR code URL.
     */
    public function twoFactorQrCodeUrl(): string;
}
