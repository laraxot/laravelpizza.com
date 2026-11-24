<?php

declare(strict_types=1);

use Livewire\Volt\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

name('pages.view');
middleware(PageSlugMiddleware::class);

new class extends Component
{
    public string $slug;
};

?>

@php
use Illuminate\Support\Str;

$locales = array_keys(config('laravellocalization.supportedLocales', ['it' => []]));
if (in_array($slug, $locales, true)) {
    LaravelLocalization::setLocale($slug);
    app()->setLocale($slug);
    $slug = 'home';
}

$authRoutes = ['login', 'register', 'password', 'verify'];
if (in_array($slug, $authRoutes, true)) {
    $authPage = 'auth.'.$slug;
    echo view($authPage);
    return;
}

$renderProfilePage = null;
if (isset($slug) && Str::startsWith($slug, 'profile/')) {
    $profileUuid = Str::after($slug, 'profile/');
    $profileUser = \Modules\User\Models\User::where('id', $profileUuid)->first();
    
    if ($profileUser) {
        $renderProfilePage = $profileUser;
    }
}
@endphp

@if($renderProfilePage)
    <x-layouts.app>
        <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-red-900 py-12 px-4">
            <div class="max-w-4xl mx-auto">
                <div class="bg-slate-800/80 backdrop-blur-xl rounded-2xl p-8 border border-slate-700/50">
                    <div class="flex items-center gap-6 mb-8">
                        @if($renderProfilePage->profile_photo_url)
                            <img src="{{ $renderProfilePage->profile_photo_url }}" alt="{{ $renderProfilePage->name }}" class="w-24 h-24 rounded-full object-cover border-4 border-red-500/50">
                        @else
                            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-red-500 to-orange-500 flex items-center justify-center text-4xl font-bold text-white">
                                {{ strtoupper(substr($renderProfilePage->name ?? 'U', 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h1 class="text-3xl font-bold text-white">{{ $renderProfilePage->name }}</h1>
                            <p class="text-slate-400">{{ $renderProfilePage->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-layouts.app>
@else
    <x-layouts.app>
        @volt('pages.view')
            <div>
                <x-page side="content" :slug="$slug" />
            </div>
        @endvolt
    </x-layouts.app>
@endif
