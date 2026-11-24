{{--
    Scheda delle pagine di autenticazione secondarie (password dimenticata, nuova password, conferma password,
    verifica email): stesso aspetto della pagina di accesso, dentro il layout pubblico con menu e footer.
    Uso: <x-ui.auth-card :title="..." :subtitle="..."> ...form... </x-ui.auth-card>
--}}
@props(['title', 'subtitle' => null])

<section class="relative flex min-h-[calc(100vh-4rem)] items-center justify-center overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-red-900 px-4 py-12">
    <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
        <div class="absolute -top-40 -right-40 h-80 w-80 rounded-full bg-red-500/10 blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 h-80 w-80 rounded-full bg-orange-500/10 blur-3xl"></div>
    </div>

    <div class="relative z-10 mx-auto w-full max-w-md">
        <div class="rounded-2xl border border-slate-700/50 bg-slate-800/80 p-8 shadow-2xl backdrop-blur-xl sm:p-10">
            <div class="mb-8 text-center">
                <a href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::localizeUrl('/') }}" class="mb-6 inline-block rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500" aria-label="{{ __('pub_theme::navigation.home') }}">
                    <x-filament::icon icon="meetup-logo" class="h-14 w-14 text-red-500" aria-hidden="true" />
                </a>
                <h1 class="mb-2 text-2xl font-extrabold text-white sm:text-3xl">{{ $title }}</h1>
                @if($subtitle)
                    <p class="text-sm text-slate-300">{{ $subtitle }}</p>
                @endif
            </div>

            {{ $slot }}
        </div>
    </div>
</section>
