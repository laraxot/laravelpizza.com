<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * LoginWidget: Widget di login conforme alle regole Windsurf/Xot.
 * - Estende XotBaseWidget
 * - Usa solo componenti Filament importati
 * - Validazione e sicurezza integrate
 * - Facilmente estendibile (2FA, captcha, login social).
 */
class LoginWidget extends XotBaseWidget
{
    /**
     * @return array<string, Field>
     */
    #[\Override]
    public function getFormSchema(): array
    {
        return [
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->autofocus(),
            'password' => TextInput::make('password')
                ->password()
                ->required(),
            'remember' => Checkbox::make('remember'),
        ];
    }

    public function login(): void
    {
        // try {
        /** @var array<string, mixed> $data */
        $data = $this->form->getState();

        $credentials = [
            'email' => is_string($data['email'] ?? null) ? $data['email'] : '',
            'password' => is_string($data['password'] ?? null) ? $data['password'] : '',
        ];

        $remember = isset($data['remember']) && true === $data['remember'];

        if (Auth::attempt($credentials, $remember)) {
            session()->regenerate();
            redirect()->intended('/');
        }

        $userClass = XotData::make()->getUserClass();
        $user = $userClass::where('email', $credentials['email'])->first();

        $this->addError('data.email', __('auth.failed'));
        // } catch (ValidationException $e) {
        // dddx([
        //    'credentials' => $credentials,
        //    'remember' => $remember,
        //    'e' => $e,
        // ]);
        // La validazione Filament gestisce automaticamente gli errori
        // throw $e;
        // }
    }
}
