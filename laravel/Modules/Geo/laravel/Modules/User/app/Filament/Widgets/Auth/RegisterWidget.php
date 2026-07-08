<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Notifications\Notification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Activity\Support\ActivityLogSchema;
use Modules\User\Filament\Widgets\Auth\Schemas\UserForm;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Widgets\XotBaseSchemaWidget;
use Webmozart\Assert\Assert;

/**
 * Register FO — schema SSoT in `Schemas\UserForm::getRegisterFormSchema()`.
 *
 * Religione R1 (form-fields-self-validate): NIENTE `validateForm()`, NIENTE
 *  `Hash::make`, NIENTE `SafeStringCast` qui dentro. Il form ha già
 *  `->dehydrateStateUsing(Hash::make)` sul campo `password`, quindi
 *  `$this->form->getState()` ritorna la password GIÀ hashata.
 *
 * Religione R3 (no wrapper Action): `$user = $userClass::create($data + defaults)`
 *  direttamente. Non creare `RegisterFoUserAction` per wrapping un create().
 *
 * Widget è il direttore d'orchestra sottile: lifecycle (mount, submit),
 *  side effects (activity log opzionale, email verify, Auth::login, redirect).
 *
 * NOTA GDPR: per conformità Garante Italiano, usare `Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget`
 *  (con `privacy_accepted`/`terms_accepted`/`marketing_consent`). Questo widget
 *  è un fallback non-GDPR (es. dev locale senza modulo Gdpr attivo).
 */
class RegisterWidget extends XotBaseSchemaWidget
{
    protected static ?int $sort = 2;

    protected static ?string $maxHeight = '600px';

    protected static function formClass(): string
    {
        return UserForm::class;
    }

    protected static function schemaMethod(): string
    {
        return 'getRegisterFormSchema';
    }

    public static function canView(): bool
    {
        return ! Auth::check();
    }

    /**
     * Compat: il template tema usa `wire:submit="save"`.
     */
    public function save(): void
    {
        $this->submit();
    }

    public function submit(): void
    {
        /** @var array<string, mixed> $data */
        $data = $this->form->getState();

        $userClass = XotData::make()->getUserClass();

        $user = DB::transaction(function () use ($data, $userClass): Authenticatable {
            $firstName = is_string($data['first_name'] ?? null) ? trim($data['first_name']) : '';
            $lastName = is_string($data['last_name'] ?? null) ? trim($data['last_name']) : '';
            $name = trim($firstName.' '.$lastName);
            $email = is_string($data['email'] ?? null) ? trim($data['email']) : '';

            $user = $userClass::create(array_merge($data, [
                'name' => '' !== $name ? $name : $email,
                'email_verified_at' => null,
            ]));

            if (ActivityLogSchema::isWritable()) {
                activity()
                    ->causedBy($user)
                    ->performedOn($user)
                    ->withProperties([
                        'ip_address' => request()->ip(),
                        'user_agent' => request()->userAgent(),
                    ])
                    ->log('User registered via RegisterWidget');
            }

            Assert::isInstanceOf($user, Authenticatable::class);

            return $user;
        });

        $this->handleSuccessfulRegistration($user);
    }

    protected function handleSuccessfulRegistration(Authenticatable $user): void
    {
        if (config('auth.must_verify_email') && $user instanceof MustVerifyEmail) {
            $user->sendEmailVerificationNotification();
        }

        Auth::login($user);

        Notification::make()
            ->title(__('user::auth.register.success.text'))
            ->success()
            ->send();

        $redirectUrl = \Illuminate\Support\Facades\Route::has('dashboard')
            ? route('dashboard')
            : url('/'.app()->getLocale());

        $this->redirect($redirectUrl);
    }
}
