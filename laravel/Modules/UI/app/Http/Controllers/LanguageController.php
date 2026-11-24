<?php

declare(strict_types=1);

namespace Modules\UI\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;

class LanguageController extends Controller
{
    /**
     * Cambia la lingua dell'applicazione.
     */
    public function switch(string $locale): RedirectResponse
    {
        // Usa configurazione per ottenere le lingue supportate
        $supportedLocales = Config::array('app.supported_locales', ['en', 'it']);

        if (! in_array($locale, $supportedLocales, strict: true)) {
            $locale = Config::string('app.locale', 'en');
        }

        session()->put('locale', $locale);
        app()->setLocale($locale);

        return redirect()->back();
    }
}
