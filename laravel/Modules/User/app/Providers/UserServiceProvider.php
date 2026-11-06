<?php

declare(strict_types=1);
/**
 * ----.
 */

namespace Modules\User\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password;
use Modules\Notify\Emails\SpatieEmail;
use Modules\User\Actions\Auth\BuildApiLoginLimitAction;
use Modules\User\Actions\Auth\BuildPasswordResetUrlAction;
use Modules\User\Actions\Auth\EnsureResetPasswordMailTemplateAction;
use Modules\User\Actions\Auth\ResolveNotifiableEmailAction;
use Modules\User\Datas\PasswordData;
use Modules\User\Models\BaseUser;
use Modules\User\Models\Policies\UserPolicy;
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
        $this->registerLivewireAuthWidgets();
        $this->registerApiLoginRateLimiter();
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
        // Vendor contract: toMailUsing callback receives mixed $notifiable.
        ResetPassword::toMailUsing(function (mixed $notifiable, string $token): SpatieEmail {
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
            // Il template `reset-password` non e' seminato: SpatieEmail lo creerebbe con il testo di registrazione (DCP-285, D-05).
            app(EnsureResetPasswordMailTemplateAction::class)->execute();
            $email = new SpatieEmail($notifiable, EnsureResetPasswordMailTemplateAction::SLUG);
            $email->mergeData([
                'token' => $token,
                // Radice da `app.url`, non dall'header Host della richiesta (SEC-007).
                'reset_password_url' => app(BuildPasswordResetUrlAction::class)->execute($token),
            ]);

            $emailAddress = app(ResolveNotifiableEmailAction::class)->execute($notifiable);

            if ($emailAddress === null) {
                // Un reset password senza destinatario non arriva a nessuno: va registrato per trovare il modello senza email.
                Log::error('SpatieEmail: Destinatario email non trovato', [
                    'notifiable_class' => $notifiable::class,
                    'notifiable_id' => $notifiable->id ?? 'unknown',
                ]);

                return $email;
            }

            $email->to($emailAddress);

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
        // Vendor contract: toMailUsing callback receives mixed $notifiable.
        VerifyEmail::toMailUsing(function (mixed $notifiable, string $url): SpatieEmail {
            Assert::isInstanceOf($notifiable, Model::class);
            $email = new SpatieEmail($notifiable, 'verify-email');
            $email->mergeData([
                'verification_url' => $url,
            ]);

            $emailAddress = app(ResolveNotifiableEmailAction::class)->execute($notifiable);

            if ($emailAddress !== null) {
                $email->to($emailAddress);
            }

            return $email;
        });
    }

    /**
     * Accesso a Pulse solo al super-admin (SEC-010). Il percorso si cambia con `PULSE_PATH` (config/pulse.php): una `Config::set`
     * a runtime arriva dopo la registrazione della route e non ha effetto. La gate predefinita del pacchetto ammette tutti in
     * ambiente `local`, ospiti compresi, e viene definita in `boot()` di Pulse: si ridefinisce a fine avvio, dopo tutti i provider.
     */
    public function registerPulse(): void
    {
        $this->app->booted(static function (): void {
            Gate::define('viewPulse', static fn (?UserContract $user = null): bool => $user instanceof UserContract && $user->hasRole('super-admin'));
        });
    }

    public function registerPasswordRules(): void
    {
        Password::defaults(function (): Password {
            $pwd = PasswordData::make();

            return $pwd->getPasswordRule();
        });
    }

    /**
     * Limiter nominato `user-login` per `POST /api/user/login` (D-08, DCP-282): soglie e messaggio in {@see BuildApiLoginLimitAction}.
     */
    protected function registerApiLoginRateLimiter(): void
    {
        RateLimiter::for('user-login', static fn (Request $request): Limit => app(BuildApiLoginLimitAction::class)->execute($request));
    }

    /**
     * Registra i widget Livewire auth per le viste Blade/Folio.
     * In Livewire v4, i componenti si auto-scoprono dal namespace Livewire.
     * Se necessario registrare manualmente, usare Livewire::component(name, class).
     * I widget qui sono usati via @livewire(Class::class) nelle view, che funziona con auto-discovery.
     */
    protected function registerLivewireAuthWidgets(): void
    {
        // Livewire v4 auto-discovers components from configured namespaces
        // Manual registration with Livewire::component() would be needed only for non-standard paths
        // The widgets (LoginWidget, RegisterWidget, etc.) are auto-discovered
    }

    /**
     * Register policies (excluding OAuth ones which are handled by PassportServiceProvider).
     */
    protected function registerPolicies(): void
    {
        // OAuth policies are handled by PassportServiceProvider.
        // La scoperta automatica trova UserPolicy solo per Modules\User\Models\User: la classe di autenticazione reale
        // (es. Modules\Fixcity\Models\User) non ne aveva nessuna e Filament, senza policy, consente tutto. Gate::policy
        // vale anche per le sottoclassi (DCP-285, D-06).
        Gate::policy(BaseUser::class, UserPolicy::class);
    }
}
