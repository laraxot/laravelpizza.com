<?php

declare(strict_types=1);

namespace Modules\Gdpr\Providers;

use Modules\Xot\Providers\XotBaseEventServiceProvider;
use Override;

class EventServiceProvider extends XotBaseEventServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [];

    /**
     * Indicates if events should be discovered.
     *
     * @var bool
     */
    protected static $shouldDiscoverEvents = true;

    /**
     * Configure the proper event listeners for email verification.
     */
    #[Override]
    protected function configureEmailVerification(): void {}
}
