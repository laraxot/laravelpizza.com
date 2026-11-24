<?php

declare(strict_types=1);

namespace Modules\Notify\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Modules\Notify\Actions\Mail\Mailjet\CreateMailjetTransportAction;
use Modules\Notify\Providers\Concerns\MergesNotifyConfigFromEnv;
use Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction;
use Modules\Xot\Providers\XotBaseServiceProvider;
use Symfony\Component\Mailer\Bridge\Mailjet\Transport\MailjetTransportFactory;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Webmozart\Assert\Assert;

class NotifyServiceProvider extends XotBaseServiceProvider
{
    use MergesNotifyConfigFromEnv;

    public string $name = 'Notify';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    public function register(): void
    {
        parent::register();
        $this->mergeNotifyModuleConfigFromEnv();
    }

    public function boot(): void
    {
        parent::boot();
        $this->registerMailjetTransport();
        // if (! app()->environment('production')) {
        $mail = app(ResolveTenantConfigValueAction::class)->execute('mail');
        Assert::isArray($mail);
        $fallback_to = Arr::get($mail, 'fallback_to', null);
        if (is_string($fallback_to)) {
            Mail::alwaysTo($fallback_to);
        }

        // }
    }

    /**
     * Mailer `mailjet` (config/mail.php: 'mailjet' => ['transport' => 'mailjet']).
     * Chiavi da services.mailjet oppure dal mailer stesso (key, secret, sandbox, scheme).
     */
    private function registerMailjetTransport(): void
    {
        if (! class_exists(MailjetTransportFactory::class)) {
            return;
        }

        Mail::extend('mailjet', static function (array $config): TransportInterface {
            $pick = static function (string $name, mixed $default) use ($config): mixed {
                return $config[$name] ?? config('services.mailjet.'.$name, $default);
            };
            $key = $pick('key', '');
            $secret = $pick('secret', '');
            $scheme = $pick('scheme', 'api');

            return app(CreateMailjetTransportAction::class)->execute(
                key: \is_string($key) ? $key : '',
                secret: \is_string($secret) ? $secret : '',
                sandbox: filter_var($pick('sandbox', false), FILTER_VALIDATE_BOOLEAN),
                scheme: \is_string($scheme) ? $scheme : 'api',
            );
        });
    }
}
