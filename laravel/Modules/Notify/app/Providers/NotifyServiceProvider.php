<?php

declare(strict_types=1);

namespace Modules\Notify\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Modules\Notify\Providers\Concerns\MergesNotifyConfigFromEnv;
use Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction;
use Modules\Xot\Providers\XotBaseServiceProvider;
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
        // if (! app()->environment('production')) {
        $mail = app(ResolveTenantConfigValueAction::class)->execute('mail');
        Assert::isArray($mail);
        $fallback_to = Arr::get($mail, 'fallback_to', null);
        if (is_string($fallback_to)) {
            Mail::alwaysTo($fallback_to);
        }

        // }
    }
}
