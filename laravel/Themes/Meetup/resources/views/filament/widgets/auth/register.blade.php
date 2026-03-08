<x-filament-widgets::widget>
    <x-filament::section>
        <form wire:submit="submit" class="space-y-6">

            <!-- Personal Information Section -->
            <div class="space-y-5">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ __('gdpr::register.sections.user_info') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('gdpr::register.sections.user_info_description') }}
                    </p>
                </div>

                <!-- Name Fields Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('gdpr::register.fields.first_name.label') }}
                        </label>
                        <input
                            type="text"
                            id="first_name"
                            wire:model="first_name"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors"
                            placeholder="{{ __('gdpr::register.fields.first_name.placeholder') }}"
                            required
                        >
                        @error('first_name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('gdpr::register.fields.last_name.label') }}
                        </label>
                        <input
                            type="text"
                            id="last_name"
                            wire:model="last_name"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors"
                            placeholder="{{ __('gdpr::register.fields.last_name.placeholder') }}"
                            required
                        >
                        @error('last_name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Email Field -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('gdpr::register.fields.email.label') }}
                    </label>
                    <input
                        type="email"
                        id="email"
                        wire:model="email"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors"
                        placeholder="{{ __('gdpr::register.fields.email.placeholder') }}"
                        required
                    >
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('gdpr::register.fields.password.label') }}
                    </label>
                    <input
                        type="password"
                        id="password"
                        wire:model="password"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors"
                        placeholder="{{ __('gdpr::register.fields.password.placeholder') }}"
                        required
                    >
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation Field -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('gdpr::register.fields.password_confirmation.label') }}
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        wire:model="password_confirmation"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors"
                        placeholder="{{ __('gdpr::register.fields.password_confirmation.placeholder') }}"
                        required
                    >
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- GDPR Consent Section (Dynamic) -->
            <div class="space-y-5">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        {{ __('gdpr::register.sections.consents') }}
                    </h2>
                </div>

                <div class="space-y-4">
                    @foreach($this->getTreatments() as $treatment)
                        <div class="space-y-1">
                            <label
                                class="flex items-start gap-3 p-4 rounded-xl border-2 {{ $errors->has('consents.'.$treatment->id) ? 'border-red-500' : 'border-gray-200 dark:border-gray-700' }} hover:border-red-300 dark:hover:border-red-600 transition-all cursor-pointer group bg-gray-50 dark:bg-gray-900/50"
                                for="consent_{{ $treatment->id }}"
                            >
                                <div class="relative flex-shrink-0 mt-0.5">
                                    <input
                                        type="checkbox"
                                        id="consent_{{ $treatment->id }}"
                                        wire:model="consents.{{ $treatment->id }}"
                                        class="peer h-5 w-5 rounded border-gray-300 text-red-600 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700"
                                    >
                                    <svg class="absolute inset-0 h-5 w-5 text-red-600 opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div class="flex-1 space-y-1">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $treatment->name }}
                                        </span>
                                        @if($treatment->required)
                                            <span class="text-red-500" aria-label="required">*</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                                        {{ $treatment->description }}
                                    </p>
                                    @if($treatment->documentUrl)
                                        <a href="{{ $treatment->documentUrl }}" 
                                           target="_blank" 
                                           rel="noopener noreferrer"
                                           class="inline-flex items-center gap-1 text-xs text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 font-medium transition-colors">
                                            {{ __('Read full document') }}
                                        </a>
                                    @endif
                                </div>
                            </label>
                            @error('consents.'.$treatment->id)
                                <p class="text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Submit Section -->
            <div class="pt-4 space-y-4">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="w-full flex justify-center items-center gap-2 py-4 px-6 rounded-xl text-base font-bold text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 focus:outline-none focus:ring-4 focus:ring-red-500/50 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 min-h-[52px] shadow-lg"
                >
                    <span wire:loading.remove wire:target="submit">
                        {{ __('gdpr::register.register.submit') }}
                    </span>
                    <span wire:loading wire:target="submit">
                        {{ __('gdpr::register.register.submitting') }}
                    </span>
                </button>
            </div>

        </form>
    </x-filament::section>
</x-filament-widgets::widget>
