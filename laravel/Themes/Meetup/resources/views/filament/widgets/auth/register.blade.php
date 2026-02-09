<x-filament-widgets::widget>
    <form wire:submit="submit" class="space-y-6">

        {{ $this->form }}

        <fieldset class="space-y-3 pt-2" aria-label="{{ __('gdpr::register.consents.title') }}">
            <legend class="sr-only">{{ __('gdpr::register.consents.title') }}</legend>

            <label
                class="flex items-start gap-3 cursor-pointer group"
                for="privacy_accepted"
            >
                <input
                    type="checkbox"
                    id="privacy_accepted"
                    wire:model="privacy_accepted"
                    class="mt-0.5 h-5 w-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700"
                    required
                    aria-required="true"
                >
                <span class="text-sm text-gray-700 dark:text-gray-300 leading-snug">
                    {!! __('gdpr::register.consents.privacy_checkbox_html', [
                        'privacy_url' => \LaravelLocalization::localizeUrl('/privacy'),
                        'data_url' => \LaravelLocalization::localizeUrl('/privacy'),
                    ]) !!}
                    <span class="text-red-500" aria-hidden="true">*</span>
                </span>
            </label>

            @error('privacy_accepted')
                <p class="text-sm text-red-600 dark:text-red-400 ml-8" role="alert">{{ $message }}</p>
            @enderror

            <label
                class="flex items-start gap-3 cursor-pointer group"
                for="terms_accepted"
            >
                <input
                    type="checkbox"
                    id="terms_accepted"
                    wire:model="terms_accepted"
                    class="mt-0.5 h-5 w-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700"
                    required
                    aria-required="true"
                >
                <span class="text-sm text-gray-700 dark:text-gray-300 leading-snug">
                    {!! __('gdpr::register.consents.terms_checkbox_html', [
                        'terms_url' => \LaravelLocalization::localizeUrl('/terms'),
                    ]) !!}
                    <span class="text-red-500" aria-hidden="true">*</span>
                </span>
            </label>

            @error('terms_accepted')
                <p class="text-sm text-red-600 dark:text-red-400 ml-8" role="alert">{{ $message }}</p>
            @enderror

            <label
                class="flex items-start gap-3 cursor-pointer group opacity-80"
                for="marketing_consent"
            >
                <input
                    type="checkbox"
                    id="marketing_consent"
                    wire:model="marketing_consent"
                    class="mt-0.5 h-5 w-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700"
                >
                <span class="text-sm text-gray-600 dark:text-gray-400 leading-snug">
                    {{ __('gdpr::register.consents.marketing_label') }}
                </span>
            </label>
        </fieldset>

        <button
            type="submit"
            wire:loading.attr="disabled"
            class="w-full flex justify-center items-center gap-2 py-3.5 px-6 rounded-lg text-base font-semibold text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200 min-h-[48px]"
        >
            <svg wire:loading wire:target="submit" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span wire:loading.remove wire:target="submit">{{ __('gdpr::register.register.submit') }}</span>
            <span wire:loading wire:target="submit">{{ __('gdpr::register.register.submitting') }}</span>
        </button>

    </form>
</x-filament-widgets::widget>
