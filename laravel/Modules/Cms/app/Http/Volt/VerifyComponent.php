<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Volt;

use Livewire\Volt\Component;
use Webmozart\Assert\Assert;
use Illuminate\Auth\Events\Verified;
use Modules\Xot\Contracts\UserContract;
use Illuminate\Contracts\Auth\MustVerifyEmail;

/**
 * Summary of VerifyComponent.
 *
 * @see https://github.com/thedevdojo/genesis/blob/main/stubs/class/resources/views/pages/auth/verify.blade.php
 */
class VerifyComponent extends Component
{
    public function resend(): void
    {
        /*
         * if (auth()->user()->hasVerifiedEmail()) {
         * return redirect()->intended(route('dashboard'));
         * }
         *
         * auth()->user()->sendEmailVerificationNotification();
         *
         * return back()->with('status', 'verification-link-sent');
         */
<<<<<<< HEAD
<<<<<<< HEAD
        Assert::notNull($user = auth()->guard('web')->user());
        /** @var UserContract $user */
        $user = $user;
=======
        Assert::notNull($user = auth()->user());
>>>>>>> 76ce10d (.)
=======
        Assert::notNull($user = auth()->guard('web')->user());
        /** @var \App\Models\User $user */
        $user = $user;
>>>>>>> 46d657c (.)
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
