<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Volt\Password;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

/**
 * @see https://github.com/thedevdojo/genesis/blob/main/stubs/class/resources/views/auth/password/reset.blade.php
 */
#[Layout('cms::layouts.auth')]
class ResetComponent extends Component
{
    #[Validate('required|email')]
    public ?string $email = null;

    /**
     * Summary of emailSentMessage.
     */
    public bool|string|array $emailSentMessage = false;

    public function sendResetPasswordLink(): void
    {
        // @var mixed validate(;

        $response = Password::broker()->sendResetLink(['email' => // @var mixed email];

        if (Password::RESET_LINK_SENT === $response) {
            $message = trans($response);
            if (is_array($message)) {
                // @var mixed emailSentMessage = implode(' ', $message;
            } else {
                // @var mixed emailSentMessage = is_string($message;
            }

            return;
        }

        // @var mixed addError('email', trans($response;
    }
}
