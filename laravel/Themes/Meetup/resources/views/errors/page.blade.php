{{--
    Pagina di errore del tema (403, 404, 419, 429) dentro il layout pubblico: menu, lingua e footer
    restano disponibili, così chi arriva da un link rotto trova subito la strada.
    Inclusa da laravel/resources/views/errors/{codice}.blade.php con ['code' => ...].
    500 e 503 usano invece errors/fallback.blade.php, che non tocca database né sessione.
--}}
@php
    $code = (string) ($code ?? 404);
    $title = __('pub_theme::errors.'.$code.'.title');
    $message = __('pub_theme::errors.'.$code.'.message');
    $localize = static fn (string $path): string => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::localizeUrl($path);
@endphp

<x-layouts.app :title="$title" :description="$message">
    <section class="relative flex min-h-[70vh] items-center justify-center overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-red-900 px-4 py-20">
        <div class="pointer-events-none absolute inset-0" aria-hidden="true">
            <div class="absolute -top-32 left-1/4 h-72 w-72 rounded-full bg-red-500/10 blur-3xl"></div>
            <div class="absolute -bottom-32 right-1/4 h-72 w-72 rounded-full bg-orange-500/10 blur-3xl"></div>
        </div>

        <div class="relative z-10 mx-auto max-w-xl text-center">
            <p class="text-8xl font-black tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-red-400 to-orange-300 sm:text-9xl" aria-hidden="true">{{ $code }}</p>
            <h1 class="mt-4 text-3xl font-extrabold text-white sm:text-4xl">
                <span class="sr-only">{{ __('pub_theme::errors.label') }} {{ $code }}: </span>{{ $title }}
            </h1>
            <p class="mt-4 text-lg text-slate-300">{{ $message }}</p>

            <div class="mt-10 flex flex-col items-center justify-center gap-3 sm:flex-row">
                @if($code === '419')
                    <a href="{{ url()->current() }}" class="inline-flex items-center justify-center rounded-xl bg-red-600 px-6 py-3 font-bold text-white shadow-lg shadow-red-900/30 transition hover:bg-red-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-900">{{ __('pub_theme::errors.actions.reload') }}</a>
                @else
                    <a href="{{ $localize('/events') }}" class="inline-flex items-center justify-center rounded-xl bg-red-600 px-6 py-3 font-bold text-white shadow-lg shadow-red-900/30 transition hover:bg-red-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-900">{{ __('pub_theme::errors.actions.events') }}</a>
                @endif
                <a href="{{ $localize('/') }}" class="inline-flex items-center justify-center rounded-xl border border-white/20 bg-white/5 px-6 py-3 font-semibold text-white transition hover:bg-white/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/50">{{ __('pub_theme::errors.actions.home') }}</a>
                @if($code === '403' && ! auth()->check())
                    <a href="{{ $localize('/auth/login') }}" class="inline-flex items-center justify-center rounded-xl border border-white/20 bg-white/5 px-6 py-3 font-semibold text-white transition hover:bg-white/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/50">{{ __('pub_theme::errors.actions.login') }}</a>
                @endif
            </div>
        </div>
    </section>
</x-layouts.app>
