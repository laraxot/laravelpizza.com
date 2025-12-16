<?php

declare(strict_types=1);

namespace Modules\User\Actions\Otp;

use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Modules\User\Datas\PasswordData;
use Modules\User\Notifications\Auth\Otp;
use Modules\Xot\Contracts\UserContract;
use Spatie\QueueableAction\QueueableAction;

/**
 * SendOtpByUserAction.
 *
 * Handles the creation and dispatch of a One-Time Password (OTP) for secure user authentication.
 */
class SendOtpByUserAction
{
    use QueueableAction;

    private PasswordData $passwordData;

    public function __construct()
    {
        // Initialize PasswordData instance, relying on dependency injection if required.
        $this->passwordData = PasswordData::make();
    }

    /**
     * Execute the action: Generate and send an OTP to the specified user.
     *
     * @param UserContract $user user to receive the OTP
     */
    public function execute(UserContract $user): void
    {
        $temporaryPassword = $this->generateTemporaryPassword();
        $expirationTime = $this->calculateOtpExpiration();

        $this->updateUserWithOtp($user, $temporaryPassword, $expirationTime);
        $this->dispatchOtpNotification($user, $temporaryPassword);
        $this->displaySuccessNotification();
    }

    /**
     * Generate a secure temporary password for OTP.
     *
     * @return string generated temporary password
     */
    private function generateTemporaryPassword(): string
    {
        return Str::random(12);
    }

    /**
     * Calculate OTP expiration time using the configuration provided in PasswordData.
     *
     * @return Carbon OTP expiration timestamp
     */
    private function calculateOtpExpiration(): Carbon
    {
        return Carbon::now()->addMinutes($this->passwordData->otp_expiration_minutes);
    }

    /**
     * Update user's password with a hashed temporary OTP and set expiration properties.
     *
     * @param UserContract $user              user to update
     * @param string       $temporaryPassword generated temporary password
     * @param Carbon       $expirationTime    expiration time for the OTP
     */
    private function updateUserWithOtp(UserContract $user, string $temporaryPassword, Carbon $expirationTime): void
    {
        $user->update([
            'password' => Hash::make($temporaryPassword),
            'is_otp' => true,
            'password_expires_at' => $expirationTime,
        ]);
    }

    /**
     * Send OTP notification to user's email.
     *
     * @param UserContract $user              user to notify
     * @param string       $temporaryPassword temporary password to include in notification
     */
    private function dispatchOtpNotification(UserContract $user, string $temporaryPassword): void
    {
        Notification::route('mail', $user->email)->notify(new Otp($user, $temporaryPassword));
    }

    /**
     * Display a Filament success notification upon OTP dispatch.
     */
    private function displaySuccessNotification(): void
    {
        FilamentNotification::make()
            ->title(__('user::otp.actions.send_otp_success'))
            ->success()
            ->send();
    }
}
