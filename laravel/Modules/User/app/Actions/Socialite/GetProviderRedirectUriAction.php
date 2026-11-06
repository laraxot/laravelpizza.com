<?php

declare(strict_types=1);

namespace Modules\User\Actions\Socialite;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\QueueableAction\QueueableAction;

/**
 * L'unico URI di callback da registrare presso il provider (DCP-269): quello nella lingua predefinita, non nella
 * lingua della pagina. La guida «provider non configurato» e la pagina del back office leggono da qui.
 */
class GetProviderRedirectUriAction
{
    use QueueableAction;

    public function execute(string $provider): string
    {
        // I nomi Folio si risolvono nella lingua corrente (provider Cms): per avere quella predefinita la si imposta per un attimo.
        $current = app()->getLocale();
        app()->setLocale((string) LaravelLocalization::getDefaultLocale());

        try {
            return route('oauth.callback', ['provider' => $provider]);
        } finally {
            app()->setLocale($current);
        }
    }
}
