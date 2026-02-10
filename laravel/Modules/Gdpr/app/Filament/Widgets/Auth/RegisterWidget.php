<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Widgets\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Modules\Gdpr\Actions\Registration\HandleRegistrationErrorAction;
use Modules\Gdpr\Actions\Registration\HandleSuccessfulRegistrationAction;
use Modules\Gdpr\Actions\Consent\CollectGdprConsentsAction;
use Modules\Gdpr\Actions\Validation\ValidateUserDataAction;
use Modules\Gdpr\Actions\Validation\ValidateGdprConsentAction;
use Modules\Gdpr\Actions\SaveGdprConsentsAction;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Treatment;
use Modules\User\Actions\Activity\LogRegistrationAction;
use Modules\User\Actions\User\CreateUserAction;
use Modules\User\Datas\PasswordData;
use Modules\User\Models\User;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * GDPR-Compliant Registration Widget.
 *
 * Flat form design following modern signup UX best practices.
 * GDPR consents are Livewire public properties so the Blade view
 * can render custom HTML with clickable links to privacy/terms pages.
 *
 * @package Modules\Gdpr\Filament\Widgets\Auth
 */
class RegisterWidget extends XotBaseWidget
{
    public string $first_name = '';

    public string $last_name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public bool $show_password = false;

    #[Validate('accepted', message: '')]
    public bool $privacy_accepted = false;

    #[Validate('accepted', message: '')]
    public bool $terms_accepted = false;

    public bool $marketing_consent = false;

    public static function canView(): bool
    {
        return ! Auth::check();
    }

    public function mount(): void
    {
        // Non usare form->fill() perché usiamo proprietà pubbliche dirette
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|min:2|max:255',
            'last_name' => 'required|string|min:2|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function submit(): void
    {
        try {
            $validatedData = $this->validate();

            app(ValidateGdprConsentAction::class)->execute(
                $this->privacy_accepted,
                $this->terms_accepted
            );

            $formData = app(ValidateUserDataAction::class)->execute($validatedData);
            $this->logRegistrationAttempt($formData);

            $user = DB::transaction(function () use ($formData) {
                $user = app(CreateUserAction::class)->execute($formData);
                app(SaveGdprConsentsAction::class)->execute($user, app(CollectGdprConsentsAction::class)->execute($this->privacy_accepted, $this->terms_accepted, $this->marketing_consent));
                app(LogRegistrationAction::class)->execute($user, [
                    'gdpr_consents' => app(CollectGdprConsentsAction::class)->execute($this->privacy_accepted, $this->terms_accepted, $this->marketing_consent),
                ]);

                return $user;
            });

            app(HandleSuccessfulRegistrationAction::class)->execute($user, $this);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            app(HandleRegistrationErrorAction::class)->execute($e, $this);
        }
    }







    protected function logRegistrationAttempt(array $formData): void
    {
        $email = app(SafeStringCastAction::class)->execute($formData['email']);

        Log::info('Registration attempt', [
            'email_hash' => hash('sha256', $email),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'gdpr_consents' => app(CollectGdprConsentsAction::class)->execute($this->privacy_accepted, $this->terms_accepted, $this->marketing_consent),
        ]);
    }
}