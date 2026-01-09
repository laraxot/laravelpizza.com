<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Password;
// use Filament\Forms\Components\TextInput as FormsTextInput;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * @property Schema $form
 */
class ForgotPasswordWidget extends XotBaseWidget
{
    protected string $view = 'user::widgets.auth.forgot-password-widget';

    /**
     * Get the form schema for this widget.
     *
     * @return array<string, Component>
     */
    #[\Override]
    public function getFormSchema(): array
    {
        return [
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),
        ];
    }

    public function sendResetLink(): void
    {
        $data = $this->form->getState();

        $status = Password::sendResetLink(['email' => $data['email']]);

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('status', __($status));
        } else {
            $this->addError('email', __($status));
        }
    }
}
