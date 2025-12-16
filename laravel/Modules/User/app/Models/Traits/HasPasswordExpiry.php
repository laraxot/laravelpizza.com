<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Modules\User\Datas\PasswordData;

trait HasPasswordExpiry
{
    /**
     * Summary of bootHasPasswordExpiry.
     */
    public static function bootHasPasswordExpiry(): void
    {
        // if (! app(HasColumnAction::class)->execute(auth()->user(), 'password_expires_at')) {
        //    dddx('a');
        // }
        $pwd = PasswordData::make();
        static::creating(function ($model) use ($pwd): void {
            if (filled($model->password)) {
                $model->password_expires_at = now()->addDays($pwd->expires_in);
            }
        });

        static::updating(function ($model) use ($pwd): void {
            if ($model->isDirty('password') && filled($model->password)) {
                $model->password_expires_at = now()->addDays($pwd->expires_in);
            }
        });
    }
}
