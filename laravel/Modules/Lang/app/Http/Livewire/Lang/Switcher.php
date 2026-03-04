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

class Switcher extends Component
{
    public string $lang;

    public array $langs;

    public string $url;

    public function mount(): void
    {
        $this->lang = app()->getLocale();
        $langs = LaravelLocalization::getSupportedLocales();
        unset($langs[$this->lang]);
        $this->url = Request::getRequestUri();
        $langs = Arr::map($langs, function (array $item, string $key) {
            // @phpstan-ignore staticMethod.notFound
            $url = LaravelLocalization::getLocalizedURL($key, $this->url, [], true);
            if ($url !== false) {
                // Verifichiamo che $url sia una stringa o lo convertiamo in modo sicuro
                if (! is_string($url)) {
                    // Se non è una stringa, utilizziamo una URL di fallback
                    $url = '/'.$key;
                } else {
                    $url = Str::of($url)->replace(url(''), '')->toString();
                }
            }
            $item['url'] = $url;

            return $item;
        });
        $this->langs = $langs;
    }

    // public function switchLang(string $lang): Application|RedirectResponse|Redirector
    // {
    //    $url = LaravelLocalization::getLocalizedURL($lang, $this->url);

    //   return redirect($url, 303);
    // }

    public function render(): View
    {
        $view = 'lang::livewire.lang.change';
        $viewParams = [
            'view' => $view,
        ];
        // if ([] === $this->teams) {
        //    $view = 'ui::livewire.empty';
        // }

        return view($view, $viewParams);
    }
}
