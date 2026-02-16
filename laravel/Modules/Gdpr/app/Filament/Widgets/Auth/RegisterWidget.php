<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Widgets\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Modules\Gdpr\Actions\Consent\CollectGdprConsentsAction;
use Modules\Gdpr\Actions\Registration\HandleSuccessfulRegistrationAction;
use Modules\Gdpr\Actions\SaveGdprConsentsAction;
use Modules\Gdpr\Actions\Validation\ValidateGdprConsentAction;
use Modules\Gdpr\Actions\Validation\ValidateUserDataAction;
use Modules\User\Actions\Activity\LogRegistrationAction;
use Modules\User\Actions\User\CreateUserAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * GDPR-Compliant Registration Widget.
 *
 * Flat form design following modern signup UX best practices.
 * GDPR consents are Livewire public properties so the Blade view
 * can render custom HTML with clickable links to privacy/terms pages.
 */
class RegisterWidget extends XotBaseWidget
{
    #[Validate('accepted', message: '')]
    public bool $privacy_accepted = false;

    #[Validate('accepted', message: '')]
    public bool $terms_accepted = false;

    public bool $marketing_consent = false;

    // Form fields for custom Blade view
    #[Validate('required|string|min:2|max:255')]
    public string $first_name = '';

    #[Validate('required|string|min:2|max:255')]
    public string $last_name = '';

    #[Validate('required|email|max:255|unique:user.users,email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    #[Validate('required|string|same:password')]
    public string $password_confirmation = '';

    public bool $show_password = false;

    public static function canView(): bool
    {
        return ! Auth::check();
    }

    protected function getView(): string
    {
        return 'filament.widgets.auth.register';
    }

    public function getFormSchema(): array
    {
        // Not used - custom Blade view handles form rendering
        return [];
    }

    public function submit(): void
    {
        // Validate form data using Livewire attributes
        $this->validate();

        // Validate GDPR consents
        app(ValidateGdprConsentAction::class)->execute(
            $this->privacy_accepted,
            $this->terms_accepted
        );

        // Prepare form data
        $formData = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
        ];

        $validatedData = app(ValidateUserDataAction::class)->execute($formData);
        $this->logRegistrationAttempt($formData);

        $user = DB::connection('user')->transaction(function () use ($validatedData) {
            $user = app(CreateUserAction::class)->execute($validatedData);
            app(SaveGdprConsentsAction::class)->execute($user, app(CollectGdprConsentsAction::class)->execute($this->privacy_accepted, $this->terms_accepted, $this->marketing_consent));
            app(LogRegistrationAction::class)->execute($user, [
                'gdpr_consents' => app(CollectGdprConsentsAction::class)->execute($this->privacy_accepted, $this->terms_accepted, $this->marketing_consent),
            ]);

            return $user;
        });

        app(HandleSuccessfulRegistrationAction::class)->execute($user, $this);
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
