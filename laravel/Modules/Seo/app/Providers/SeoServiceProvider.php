<?php

declare(strict_types=1);

namespace Modules\Seo\Providers;

use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Kernel as FoundationKernel;
use Modules\Seo\Adapters\MetatagFacadeAdapter;
use Modules\Seo\Adapters\MetatagState;
use Modules\Seo\Http\Middleware\RedirectToCanonicalPath;
use Modules\Xot\Providers\XotBaseServiceProvider;

class SeoServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Seo';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        parent::register();

        $this->app->singleton(MetatagState::class);
        $this->app->singleton(MetatagFacadeAdapter::class);
    }

    /**
     * Bootstrap the module services.
     */
    public function boot(): void
    {
        parent::boot();

        $this->registerCanonicalPathRedirect();
    }

    /**
     * 301 dalle copie di una pagina alla forma canonica (DCP-288, FO-6-20). Middleware globale, perche' deve agire prima della ricerca
     * della rotta; sul kernel e non sul router, come il modulo Gdpr (il kernel risincronizza il router a ogni richiesta).
     */
    protected function registerCanonicalPathRedirect(): void
    {
        $kernel = $this->app->make(HttpKernel::class);
        if ($kernel instanceof FoundationKernel) {
            $kernel->prependMiddleware(RedirectToCanonicalPath::class);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<string>
     */
    public function provides(): array
    {
        return [
            MetatagFacadeAdapter::class,
            MetatagState::class,
        ];
    }
}
