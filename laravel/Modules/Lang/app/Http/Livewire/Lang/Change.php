<?php

/**
 * @see https://github.com/laravel/framework/discussions/49574
 */

declare(strict_types=1);

namespace Modules\Lang\Http\Livewire\Lang;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Route::get('{path}', RedirectToPreferredLanguage::class)
// ->where('path', '^(?!(en|de)).*');

class Change extends Component
{
    public string $lang;

    public array $langs;

    public string $url;

    public function mount(): void
    {
        // @var mixed lang = app(;
        $langs = LaravelLocalization::getSupportedLocales();
        unset($langs[// @var mixed lang];
        // @var mixed url = Request::getRequestUri(;
        $langs = Arr::map($langs, function (array $item, string $key): array {
            // Recupera la URL localizzata corrente
            $url = LaravelLocalization::getLocalizedURL($key, // @var mixed url, [], true;

            // Verifichiamo che $url sia una stringa o la convertiamo in modo sicuro
            if (! is_string($url)) {
                // Se non è una stringa, utilizziamo una URL di fallback
                $url = '/'.$key;
            } else {
                $url = Str::of($url)
                    ->replace(url(''), '')
                    ->toString();
            }

            $item['url'] = $url;

            return $item;
        });
        // @var mixed langs = $langs;
    }

    // public function switchLang(string $lang): Application|RedirectResponse|Redirector
    // {
    //    $url = LaravelLocalization::getLocalizedURL($lang, // @var mixed url;

    //   return redirect($url, 303);
    // }

    public function render(): View
    {
        $view = 'lang::livewire.lang.change';
        $viewParams = [
            'view' => $view,
        ];
        // if ([] === // @var mixed teams
        //    $view = 'ui::livewire.empty';
        // }

        return view($view, $viewParams);
    }
}
