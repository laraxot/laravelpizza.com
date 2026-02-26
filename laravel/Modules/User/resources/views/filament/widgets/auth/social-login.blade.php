{{--
    SocialLoginWidget: pulsanti OAuth riutilizzabili (Google, Microsoft, GitHub).
    CRITICO: Livewire richiede SEMPRE un root tag HTML con contenuto.
    REGOLA: gli SVG NON sono hardcoded nelle blade ma usano componenti icon in Modules/UI/resources/svg
    I nomi degli icon seguono la convenzione: ui-brands.nomefile (es. ui-brands.google)
    Vedere: Modules/UI/docs/no-svg-hardcoded-in-blade.md
--}}
@php
    $hasGoogle = (bool) config('services.google.client_id');
    $hasMicrosoft = (bool) config('services.microsoft.client_id');
    $hasGithub = (bool) config('services.github.client_id');
    $hasAny = $hasGoogle || $hasMicrosoft || $hasGithub;
@endphp

<div class="social-login-widget">
    @if ($hasAny)
        <div class="social-login-buttons grid grid-cols-1 sm:grid-cols-3 gap-4">
            @if ($hasGoogle)
                <a href="{{ route('socialite.oauth.redirect', ['provider' => 'google']) }}"
                    class="flex items-center justify-center gap-3 py-2.5 px-4 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:border-gray-300 hover:shadow-sm transition-all duration-200 group focus:outline-none focus:ring-2 focus:ring-[#1E5A96]/30"
                >
                    <x-filament::icon icon="ui-google" class="w-5 h-5 flex-shrink-0" />
                    <span class="font-medium text-gray-700 group-hover:text-gray-900 transition-colors">
                        {{ __('user::auth.social.google') }}
                    </span>
                </a>
            @endif

            @if ($hasMicrosoft)
                <a href="{{ route('socialite.oauth.redirect', ['provider' => 'microsoft']) }}"
                    class="flex items-center justify-center gap-3 py-2.5 px-4 bg-[#00A4EF] border border-[#00A4EF] rounded-xl hover:bg-[#0088cc] hover:border-[#0088cc] hover:shadow-sm transition-all duration-200 group focus:outline-none focus:ring-2 focus:ring-[#00A4EF]/30"
                >
                    <x-filament::icon icon="ui-brands.microsoft" class="w-5 h-5 flex-shrink-0 text-white" />
                    <span class="font-medium text-white transition-colors">
                        {{ __('user::auth.social.microsoft') }}
                    </span>
                </a>
            @endif

            @if ($hasGithub)
                <a href="{{ route('socialite.oauth.redirect', ['provider' => 'github']) }}"
                    class="flex items-center justify-center gap-3 py-2.5 px-4 bg-[#24292F] border border-[#24292F] rounded-xl hover:bg-[#1c2126] hover:shadow-sm transition-all duration-200 group focus:outline-none focus:ring-2 focus:ring-gray-500/20"
                >
                    <x-filament::icon icon="ui-brands.github" class="w-5 h-5 flex-shrink-0 text-white" />
                    <span class="font-medium text-white transition-colors">
                        {{ __('user::auth.social.github') }}
                    </span>
                </a>
            @endif
        </div>
    @else
        <div class="hidden" aria-hidden="true"></div>
    @endif
</div>
