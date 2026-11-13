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
 *
 * Each tenant can choose its own landing page with `xra.post_login_path` (e.g. LaravelPizza uses `/events/my`,
 * because it has no `area-personale` page); without it the default stays `/area-personale`.
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

<<<<<<< .merge_file_CkeLBf
        $path = config('xra.post_login_path');
        $path = is_string($path) && $path !== '' ? '/'.ltrim($path, '/') : '/area-personale';

        return LaravelLocalization::localizeURL($path, $locale);
=======
        // Pagina d'arrivo configurabile per sito (`auth.post_login_path` nella config del tenant):
        // `/area-personale` esiste solo nel tema Sixteen; su Predict dava 404 dopo ogni accesso.
        $path = Config::string('auth.post_login_path', '/area-personale');

        return LaravelLocalization::localizeURL('/'.ltrim($path, '/'), $locale);
>>>>>>> .merge_file_hy7JT8
    }
}
