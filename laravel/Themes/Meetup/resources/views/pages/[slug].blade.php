<?php
declare(strict_types=1);
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;
use Modules\Cms\Models\Page;
use Modules\Tenant\Services\TenantService;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

/** @var array */
// $middleware=TenantService::config('middleware');
// $base_middleware=Arr::get($middleware,'base',[]);

$base_middleware = [];

name('pages.view');
/*
if(isset($slug)){
    $middleware=Page::getMiddlewareBySlug($slug);
    middleware($middleware);
}
*/
middleware(PageSlugMiddleware::class);

new class extends Component
{
    public string $slug;
};

?>

@php
// Check if slug is a locale - redirect to home with that locale
$locales = array_keys(config('laravellocalization.supportedLocales', ['it' => []]));
if (in_array($slug, $locales, true)) {
    // This is a locale, redirect to home page with this locale
    // Actually, just render the home page instead
    $slug = 'home';
}

// Check if this is an auth route and redirect to the appropriate auth page
$authRoutes = ['login', 'register', 'password', 'verify'];
if (in_array($slug, $authRoutes)) {
    $authPage = 'auth.' . $slug;
    echo view($authPage);
    return;
}

// Check if this is an event detail page (/events/{slug})
$eventSlug = request()->route('slug');
if (!empty($eventSlug) && is_string($eventSlug)) {
    $event = \Modules\Meetup\Models\Event::where('slug', $eventSlug)->first();
    if ($event) {
        echo view('pub_theme::components.blocks.events.detail', ['event' => $event]);
        return;
    }
}
@endphp

<x-layouts.app>
    @volt('pages.view')
    <div>
        <x-page side="content" :slug="$slug" />
    </div>
    @endvolt
</x-layouts.app>
