<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Volt;

use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Livewire\Volt\Component;
use Modules\User\Models\User;
use Webmozart\Assert\Assert;

/**
 * Summary of VerifyComponent.
 *
 * @see https://github.com/thedevdojo/genesis/blob/main/stubs/class/resources/views/pages/auth/verify.blade.php
 */
class VerifyComponent extends Component
{
    public function resend(): void
    {
        Assert::notNull($user = auth()->guard('web')->user());
        /** @var User $user */
        $user = $user;

        if ($user->hasVerifiedEmail()) {
            redirect('/');
        }

        $user->sendEmailVerificationNotification();

        // Cast to MustVerifyEmail for the Verified event
        if ($user instanceof MustVerifyEmail) {
            event(new Verified($user));
        }

        $this->dispatch('resent');
        session()->flash('resent');
    }
}
