<?php

/**
 * ----.
 */

declare(strict_types=1);

namespace Modules\User\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Modules\Notify\Emails\SpatieEmail;
use Modules\User\Datas\PasswordData;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Providers\XotBaseServiceProvider;
use Webmozart\Assert\Assert;

class UserServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'User';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    #[\Override]
    public function boot(): void
    {
        parent::boot();
        // $this->registerEventListener();
        $this->registerPasswordRules();
        $this->registerPulse();
        $this->registerMailsNotification();
        $this->registerPolicies();
    }

    #[\Override]
    public function register(): void
    {
        parent::register();
        // $this->registerTeamModelBindings();
    }

    public function registerMailsNotification(): void
    {
        $app_name = config('app.name');
        if (! is_string($app_name)) {
            $app_name = '';
        }

        ResetPassword::toMailUsing(function ($notifiable, string $token): SpatieEmail {
            /*
             * return (new MailMessage)
             * ->template('user::notifications.email')
             * ->subject(__('user::reset_password.password_reset_subject'))
             * ->line(__('user::reset_password.password_cause_of_email'))
             * ->action(__('user::reset_password.reset_password'), url(route('password.reset', $token, false)))
             * ->line(__('user::reset_password.password_if_not_requested'))
             * ->line(__('user::reset_password.thank_you_for_using_app'))
             * ->salutation(__('user::reset_password.regards'));
             */
            Assert::isInstanceOf($notifiable, Model::class);
            $email = new SpatieEmail($notifiable, 'reset-password');
            $email->mergeData([
                'token' => $token,
                'reset_password_url' => url(route('password.reset', ['token' => $token], false)),
            ]);

            // ✅ FIX CRITICO: Imposta il destinatario dell'email con metodo Laravel standard
            if (method_exists($notifiable, 'getEmailForPasswordReset')) {
                $emailAddress = $notifiable->getEmailForPasswordReset();
                if (is_string($emailAddress) || is_array($emailAddress) || is_object($emailAddress)) {
                    $email->to($emailAddress);
                }
            } elseif (isset($notifiable->email)) {
                $emailAddress = $notifiable->email;
                if (is_string($emailAddress) || is_array($emailAddress) || is_object($emailAddress)) {
                    $email->to($emailAddress);
                }
            } else {
                // Fallback per debug
                Log::error('SpatieEmail: Destinatario email non trovato', [
                    'notifiable_class' => $notifiable::class,
                    'notifiable_id' => $notifiable->id ?? 'unknown',
                ]);
            }

            return $email;
        });

        /*
         * $salutation = __('user::verify_email.salutation', ['app_name' => $app_name]);
         * VerifyEmail::toMailUsing(function (object $notifiable, string $url) use ($salutation): MailMessage {
         * return (new MailMessage)
         * ->template('user::notifications.email')
         * ->subject(__('user::verify_email.subject'))
         * ->greeting(__('user::verify_email.greeting'))
         * ->line(__('user::verify_email.line1'))
         * ->action(__('user::verify_email.action'), $url)
         * ->line(__('user::verify_email.line2'))
         * ->salutation($salutation);
         * });
         */
        VerifyEmail::toMailUsing(function ($notifiable, string $url): SpatieEmail {
            Assert::isInstanceOf($notifiable, Model::class);
            $email = new SpatieEmail($notifiable, 'verify-email');
            $email->mergeData([
                'verification_url' => $url,
            ]);
            if (method_exists($notifiable, 'getEmailForPasswordReset')) {
                $emailAddress = $notifiable->getEmailForPasswordReset();
                if (is_string($emailAddress) || is_array($emailAddress) || is_object($emailAddress)) {
                    $email->to($emailAddress);
                }
            } elseif (isset($notifiable->email)) {
                $emailAddress = $notifiable->email;
                if (is_string($emailAddress) || is_array($emailAddress) || is_object($emailAddress)) {
                    $email->to($emailAddress);
                }
            }

            return $email;
        });
    }

    public function registerPulse(): void
    {
        Config::set('pulse.path', 'pulse/admin');
        Gate::define('viewPulse', fn (UserContract $user): bool => $user->hasRole('super-admin'));
    }

    public function registerPasswordRules(): void
    {
        Password::defaults(function (): Password {
            $pwd = PasswordData::make();

            return $pwd->getPasswordRule();
        });
    }

    /**
     * Register policies (excluding OAuth ones which are handled by PassportServiceProvider).
     */
    protected function registerPolicies(): void
    {
        // OAuth policies are handled by PassportServiceProvider
        // Register other policies here if needed
    }
}
