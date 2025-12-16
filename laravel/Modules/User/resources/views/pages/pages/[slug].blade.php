<?php

declare(strict_types=1);


use Illuminate\Support\Arr;
use Illuminate\View\View;
use Modules\Cms\Models\Page;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Laravel\Folio\render;
use function Laravel\Folio\withTrashed;

withTrashed();
name('page_slug.view');
//middleware(['auth', 'verified']);

render(function (View $view, string $slug) {
    $locale = app()->getLocale();
    $page = Page::firstWhere(['slug' => $slug]);

    /*
     * if (!$page) {
     * abort(404);
     * // Prova a cercare la pagina nella lingua predefinita
     * $page = Page::firstWhere(['slug' => $slug, 'locale' => config('app.fallback_locale', 'en')]);
     * }
     */
    return $view->with('page', $page);
});

?>
<x-layouts.marketing>

    <div
        x-data="{loggedIn:true}"
        class="max-w-[calc(100%-30px)] sm:max-w-[calc(100%-80px)] lg:max-w-[996px] mx-auto pb-12 font-roboto"
        >
        @if($page)
            <div class="py-10">
                <h1 class="text-[2rem] mb-4 font-roboto font-semibold text-neutral-5">
                    {{ $page->title }}
                </h1>
            </div>

            {{-- {{ dddx([
                $_theme->showPageSidebarContent($page->title),
                $_theme->showPageContent($page->title),
                $page->sidebar_blocks,
                $page->content_blocks
                ]) }} --}}
            {{-- {{ dddx($page->content_blocks) }} --}}
            @if(!empty($page->sidebar_blocks))
                <div class="grid grid-cols-1 lg:grid-cols-[21.25rem,1fr] gap-4">
                    <div class="space-y-6">
                        {{ $_theme->showPageSidebarContent($page->slug) }}
                    </div>

                    {{ $_theme->showPageContent($page->slug) }}
                </div>

            @else
                {{-- what is the css to make the whole block unsplit? --}}
                <div>
                    {{ $_theme->showPageContent($page->slug) }}
                </div>
            @endif
        @else
            <div class="flex flex-col items-center justify-center py-8 space-y-4">
                <div>
                    <img class="max-w-lg" src="https://error404.fun/img/full-preview/1x/3.png" alt="">
                </div>
                <div class="space-y-2 text-center">
                    <h2 class="text-2xl font-bold md:text-4xl lg:text-6xl">Whooops!</h2>
                    <p class="text-gray-400">{{ __('pub_theme::404.no_article') }}</p>
                </div>
            </div>
        @endif
    </div>
</x-layouts.marketing>
