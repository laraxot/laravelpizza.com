<?php

declare(strict_types=1);

namespace Modules\User\Actions\Auth;

use Illuminate\Support\Facades\Config;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\QueueableAction\QueueableAction;

/**
 * Where login and registration land when no page asked for the login: the localized personal area.
 *
 * Not `route('dashboard')`: in the front office `/{lang}/dashboard` answers 404, because the theme Folio page
 * `[container0]` is mounted before the User module. `/{lang}/area-personale` is resolved by the theme
 * (`ResolveContainer0IndexAction`): it sends a signed-in user to the case list.
 */
final class GetPostLoginUrlAction
{
    use QueueableAction;

    public function execute(): string
    {
        // Livewire submits to `/livewire-*`, where the locale middleware may not run: keep the locale explicit.
        $locale = trim(app()->getLocale(), '/');
        if (! in_array($locale, LaravelLocalization::getSupportedLanguagesKeys(), true)) {
            $locale = Config::string('app.locale', 'it');
        }

        return LaravelLocalization::localizeURL('/area-personale', $locale);
    }
}
