{{--
    View: user::filament.widgets.auth.login
    Enhanced UX/UI with modern 2026 design trends
    Features: Social login buttons, micro-interactions, accessibility, mobile-first
--}}
<div class="filament-widget-login space-y-6">
    {{-- Social Login Buttons - inline to avoid Livewire nesting issues --}}
    @php
        $hasGoogle = (bool) config('services.google.client_id');
        $hasMicrosoft = (bool) config('services.microsoft.client_id');
        $hasGithub = (bool) config('services.github.client_id');
        $hasAnySocial = $hasGoogle || $hasMicrosoft || $hasGithub;
    @endphp
    
    @if ($hasAnySocial)
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
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
    @endif

    @if ($hasAnySocial)
    <!-- Divider: mostra solo se ci sono pulsanti social sopra -->
    <div class="relative py-2">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-gray-200"></div>
        </div>
        <div class="relative flex justify-center text-sm font-medium leading-6">
            <span class="bg-white px-4 text-gray-400 font-normal italic">
                {{ __('user::auth.login.or_continue_with') }}
            </span>
        </div>
    </div>
    @endif

    <!-- Login Form -->
    <form wire:submit.prevent="save" class="space-y-5">
        <div class="filament-form-container">
            {{ $this->form }}
        </div>

        @if (Route::has('password.request'))
            <div class="flex justify-end">
                <a href="{{ route('password.request') }}" class="text-sm font-medium transition-colors duration-200" style="color: #1E5A96;">
                    {{ __('user::auth.login.forgot_password') }}
                </a>
            </div>
        @endif

        <!-- Submit Button - Colori espliciti per visibilità (WCAG AA) -->
        <button 
            type="submit" 
            wire:loading.attr="disabled"
            class="w-full py-3 px-4 rounded-xl font-semibold text-white disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 ease-in-out shadow-sm hover:shadow-md transform hover:scale-[1.01] active:scale-[0.99] flex justify-center items-center gap-2 group focus:outline-none focus:ring-4 focus:ring-[#1E5A96]/30"
            style="background: linear-gradient(135deg, #1E5A96 0%, #2D8659 100%);"
            onmouseover="this.style.background='linear-gradient(135deg, #174a7a 0%, #246b48 100%)'"
            onmouseout="this.style.background='linear-gradient(135deg, #1E5A96 0%, #2D8659 100%)'"
        >
            <span wire:loading wire:target="save" class="flex items-center gap-2 italic">
                <x-filament::icon icon="heroicon-o-arrow-path" class="animate-spin h-5 w-5" aria-hidden="true" />
                {{ __('user::auth.login.logging_in') }}
            </span>
            
            <div wire:loading.remove wire:target="save" class="flex items-center gap-2">
                <span>{{ __('user::auth.login.submit') }}</span>
                <x-filament::icon icon="heroicon-o-arrow-right" class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" />
            </div>
        </button>
    </form>

    <!-- Register CTA -->
    @if (Route::has('register'))
        <div class="text-center pt-4">
            <p class="text-sm text-gray-500">
                {{ __('user::auth.login.no_account') }}
                <a href="{{ route('register') }}" class="font-semibold transition-colors duration-200 ml-1" style="color: #1E5A96;">
                    {{ __('user::auth.login.create_account') }}
                </a>
            </p>
        </div>
    @endif
</div>
