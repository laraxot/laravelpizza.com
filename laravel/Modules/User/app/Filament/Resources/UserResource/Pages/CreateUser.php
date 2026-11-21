<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\Pages;

use Modules\User\Filament\Resources\UserResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateUser extends XotBaseCreateRecord
{
    protected static string $resource = UserResource::class;

    /**
     * A password set here by an admin is provisional: `is_otp = true` makes
     * `PasswordExpiryMiddleware` force a change on the new user's first login
     * (same mechanism `SendOtpByUserAction` uses for OTP mail).
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (filled($data['password'] ?? null)) {
            $data['is_otp'] = true;
        }

        if (blank($data['name'] ?? null) && filled($data['email'] ?? null)) {
            $data['name'] = $data['email'];
        }

        return $data;
    }
}
