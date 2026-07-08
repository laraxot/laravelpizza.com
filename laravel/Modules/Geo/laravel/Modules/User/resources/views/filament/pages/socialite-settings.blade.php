{{--
    View: user::filament.pages.socialite-settings
    
    OAuth Provider Settings Page for Filament Admin.
    Allows administrators to configure Google, GitHub, Microsoft OAuth
    without editing .env files.
    
    Configuration is saved to: storage/app/private/socialite-config.php
    
    @see https://developers.google.com/identity/protocols/oauth2/web-server
    @see laravel/Modules/User/docs/wiki/concepts/socialite-admin-configuration.md
--}}

<x-filament-panels::page>
    <form wire:submit.prevent="save">
        {{ $this->form }}
        
        <div class="fi-ac gap-3 flex flex-wrap items-center justify-start">
            <x-filament::button type="submit" color="primary" icon="heroicon-m-check">
                {{ __('user::socialite.actions.save') }}
            </x-filament::button>
        </div>
    </form>
    
    {{-- Help Section --}}
    <div class="mt-8 p-4 bg-gray-50 rounded-lg border border-gray-200">
        <h3 class="text-sm font-semibold text-gray-900 mb-2">
            {{ __('user::socialite.help.title') }}
        </h3>
        
        <div class="prose prose-sm text-gray-600">
            <p>{{ __('user::socialite.help.description') }}</p>
            
            <h4 class="text-xs font-semibold uppercase tracking-wide text-gray-500 mt-4 mb-2">
                {{ __('user::socialite.help.google_title') }}
            </h4>
            <ol class="list-decimal list-inside space-y-1 text-sm">
                <li>{!! __('user::socialite.help.google_step1', ['url' => 'https://console.cloud.google.com/']) !!}</li>
                <li>{{ __('user::socialite.help.google_step2') }}</li>
                <li>{{ __('user::socialite.help.google_step3') }}</li>
                <li>{{ __('user::socialite.help.google_step4') }}</li>
            </ol>
            
            <div class="mt-4 p-3 bg-blue-50 rounded border border-blue-200">
                <p class="text-xs text-blue-800">
                    <strong>{{ __('user::socialite.help.redirect_url_note') }}:</strong>
                    {{ __('user::socialite.help.redirect_url_description') }}
                </p>
            </div>
        </div>
    </div>
    
    {{-- Security Notice --}}
    <div class="mt-4 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
        <div class="flex items-start gap-3">
            <x-heroicon-o-shield-check class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" />
            <div>
                <h4 class="text-sm font-semibold text-yellow-900">
                    {{ __('user::socialite.security.title') }}
                </h4>
                <p class="text-xs text-yellow-800 mt-1">
                    {{ __('user::socialite.security.description') }}
                </p>
            </div>
        </div>
    </div>
</x-filament-panels::page>
