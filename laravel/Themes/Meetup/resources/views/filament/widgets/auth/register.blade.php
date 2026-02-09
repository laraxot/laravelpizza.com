<x-filament-widgets::widget>
    <form wire:submit="submit" class="space-y-8">
        
        <!-- Personal Information Section -->
        <div class="space-y-6">
            <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    {{ __('gdpr::register.sections.user_info') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('gdpr::register.sections.user_info_description') }}
                </p>
            </div>
            
            {{ $this->form }}
        </div>

        <!-- GDPR Consent Section -->
        <div class="space-y-6">
            <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    {{ __('gdpr::register.sections.required_consents') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('gdpr::register.sections.required_consents_description') }}
                </p>
            </div>

            <fieldset class="space-y-4" aria-label="{{ __('gdpr::register.consents.title') }}">
                <legend class="sr-only">{{ __('gdpr::register.consents.title') }}</legend>

                <!-- Privacy Policy Consent -->
                <label
                    class="flex items-start gap-4 p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-primary-300 dark:hover:border-primary-600 transition-all cursor-pointer group bg-gray-50 dark:bg-gray-900/50"
                    for="privacy_accepted"
                >
                    <div class="relative flex-shrink-0 mt-0.5">
                        <input
                            type="checkbox"
                            id="privacy_accepted"
                            wire:model="privacy_accepted"
                            class="peer h-5 w-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700"
                            required
                            aria-required="true"
                        >
                        <svg class="absolute inset-0 h-5 w-5 text-primary-600 opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="flex-1 space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ __('gdpr::register.consents.privacy_policy_label') }}
                            </span>
                            <span class="text-red-500" aria-label="required">*</span>
                        </div>
                        <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                            {{ __('gdpr::register.consents.privacy_policy_hint') }}
                        </p>
                        <a href="{{ \LaravelLocalization::localizeUrl('/privacy') }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="inline-flex items-center gap-1 text-xs text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 rounded">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            {{ __('gdpr::register.actions.read_privacy_policy') }}
                        </a>
                    </div>
                </label>

                @error('privacy_accepted')
                    <p class="ml-9 text-sm text-red-600 dark:text-red-400 flex items-center gap-1" role="alert">
                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror

                <!-- Terms & Conditions Consent -->
                <label
                    class="flex items-start gap-4 p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-primary-300 dark:hover:border-primary-600 transition-all cursor-pointer group bg-gray-50 dark:bg-gray-900/50"
                    for="terms_accepted"
                >
                    <div class="relative flex-shrink-0 mt-0.5">
                        <input
                            type="checkbox"
                            id="terms_accepted"
                            wire:model="terms_accepted"
                            class="peer h-5 w-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700"
                            required
                            aria-required="true"
                        >
                        <svg class="absolute inset-0 h-5 w-5 text-primary-600 opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="flex-1 space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ __('gdpr::register.consents.terms_label') }}
                            </span>
                            <span class="text-red-500" aria-label="required">*</span>
                        </div>
                        <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                            {{ __('gdpr::register.consents.terms_hint') }}
                        </p>
                        <a href="{{ \LaravelLocalization::localizeUrl('/terms') }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="inline-flex items-center gap-1 text-xs text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 rounded">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            {{ __('gdpr::register.actions.read_terms') }}
                        </a>
                    </div>
                </label>

                @error('terms_accepted')
                    <p class="ml-9 text-sm text-red-600 dark:text-red-400 flex items-center gap-1" role="alert">
                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </fieldset>
        </div>

        <!-- Optional Consent Section -->
        <div class="space-y-6">
            <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                    {{ __('gdpr::register.sections.optional_consents') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('gdpr::register.sections.optional_consents_description') }}
                </p>
            </div>

            <label
                class="flex items-start gap-4 p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-primary-300 dark:hover:border-primary-600 transition-all cursor-pointer group bg-gray-50 dark:bg-gray-900/50 opacity-80"
                for="marketing_consent"
            >
                <div class="relative flex-shrink-0 mt-0.5">
                    <input
                        type="checkbox"
                        id="marketing_consent"
                        wire:model="marketing_consent"
                        class="peer h-5 w-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700"
                    >
                    <svg class="absolute inset-0 h-5 w-5 text-primary-600 opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="flex-1 space-y-1">
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">
                        {{ __('gdpr::register.consents.marketing_label') }}
                    </span>
                    <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                        {{ __('gdpr::register.consents.marketing_hint') }}
                    </p>
                </div>
            </label>
        </div>

        <!-- Submit Section -->
        <div class="pt-6 space-y-4">
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="w-full flex justify-center items-center gap-2 py-4 px-6 rounded-xl text-base font-bold text-white bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-500/50 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 min-h-[52px] shadow-lg hover:shadow-xl transform hover:scale-[1.02] active:scale-[0.98]"
            >
                <svg wire:loading wire:target="submit" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove wire:target="submit" class="flex items-center gap-2">
                    {{ __('gdpr::register.register.submit') }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </span>
                <span wire:loading wire:target="submit">{{ __('gdpr::register.register.submitting') }}</span>
            </button>

            <!-- Login Link -->
            <p class="text-center text-sm text-gray-600 dark:text-gray-400">
                {{ __('gdpr::register.already_registered') }}
                <a href="{{ route('login') }}" 
                   class="font-semibold text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 rounded px-1">
                    {{ __('gdpr::register.login') }}
                </a>
            </p>
        </div>

    </form>
</x-filament-widgets::widget>
