<?php

declare(strict_types=1);

namespace Modules\User\Providers;

use Illuminate\Support\Facades\Event;
use SocialiteProviders\Manager\ServiceProvider as BaseSocialiteServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;

class SocialiteServiceProvider extends BaseSocialiteServiceProvider
{
<<<<<<< HEAD
||||||| 6161e129d
class SocialiteServiceProvider extends BaseSocialiteServiceProvider {}
=======
    /**
     * Bootstrap the provider services.
     */
    public function boot(): void
    {
        parent::boot();

        Event::listen(function (SocialiteWasCalled $event): void {
            $providerClass = 'SocialiteProviders\\Microsoft\\Provider';
            if (class_exists($providerClass)) {
                $event->extendSocialite('microsoft', $providerClass);
            }
        });
    }
>>>>>>> feature/ralph-loop-implementation
}
