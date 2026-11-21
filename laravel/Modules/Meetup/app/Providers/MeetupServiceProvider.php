<?php

declare(strict_types=1);

namespace Modules\Meetup\Providers;

use Modules\Meetup\Actions\Seo\ListEventSitemapPathsAction;
use Modules\Seo\Contracts\SitemapPathsContract;
use Modules\Xot\Providers\XotBaseServiceProvider;
use Override;

/**
 * Meetup ServiceProvider - Laraxot Compliant.
 *
 * Follows Laraxot Philosophy:
 * - Logic: Mathematical precision in type safety
 * - Politics: Respects XotBaseServiceProvider hierarchy
 * - Religion: Extends XotBaseServiceProvider, not ServiceProvider
 * - Philosophy: DRY + KISS principles
 * - Zen: Simple, effective implementation
 */
class MeetupServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Meetup';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    #[Override]
    public function register(): void
    {
        parent::register();

        // Pagine degli eventi nella sitemap del modulo Seo (che non conosce i modelli degli altri moduli).
        $this->app->tag([ListEventSitemapPathsAction::class], SitemapPathsContract::TAG);
    }
}
