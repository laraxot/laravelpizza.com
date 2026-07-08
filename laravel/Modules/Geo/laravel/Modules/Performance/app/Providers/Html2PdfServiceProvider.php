<?php

declare(strict_types=1);

namespace Modules\Performance\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;
use Spipu\Html2Pdf\Html2Pdf;

class Html2PdfServiceProvider extends XotBaseServiceProvider
{
    /**
     * The module namespace.
     */
    protected string $moduleName = 'Performance';

    public function register(): void
    {
        parent::register();

        $this->app->singleton('html2pdf', fn () => new Html2Pdf('P', 'A4', 'it', true, 'UTF-8', [0, 0, 0, 0]));
    }

    public function boot(): void
    {
        parent::boot();
    }
}
