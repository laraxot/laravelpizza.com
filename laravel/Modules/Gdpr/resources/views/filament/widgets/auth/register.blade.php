{{--
  Vista di riserva del RegisterWidget: si usa quando il tema non ha `filament/widgets/auth/register.blade.php`.
  Un <form> vero: Invio da tastiera invia, i lettori di schermo lo annunciano come modulo.
  Etichette = `gdpr::register.fields.*.label`, le stesse di RegisterWidget::validationAttributes(): campo e messaggio d'errore dicono la stessa parola.
  Contratto condiviso con le viste dei temi: Modules/Gdpr/docs/register-widget-copy-ownership.md
--}}
<form wire:submit="submit" class="space-y-4" novalidate>
    {{-- Nome --}}
    <div>
        <label for="first_name" class="block text-sm font-medium text-white mb-1">
            {{ __('gdpr::register.fields.first_name.label') }}
        </label>
        <input
            wire:model="first_name"
            type="text"
            id="first_name"
            name="first_name"
            required
            minlength="2"
            maxlength="255"
            autocomplete="given-name"
            class="w-full px-4 py-3 bg-slate-800/50 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all"
            aria-describedby="first_name_error"
        >
        @error('first_name')
            <p id="first_name_error" class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="last_name" class="block text-sm font-medium text-white mb-1">
            {{ __('gdpr::register.fields.last_name.label') }}
        </label>
        <input
            wire:model="last_name"
            type="text"
            id="last_name"
            name="last_name"
            required
            minlength="2"
            maxlength="255"
            autocomplete="family-name"
            class="w-full px-4 py-3 bg-slate-800/50 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all"
            aria-describedby="last_name_error"
        >
        @error('last_name')
            <p id="last_name_error" class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Email --}}
    <div>
        <label for="email" class="block text-sm font-medium text-white mb-1">
            {{ __('gdpr::register.fields.email.label') }}
        </label>
        <input
            wire:model="email"
            type="email"
            id="email"
            name="email"
            required
            maxlength="255"
            autocomplete="email"
            class="w-full px-4 py-3 bg-slate-800/50 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all"
            aria-describedby="email_error"
        >
        @error('email')
            <p id="email_error" class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Password --}}
    <div>
        <label for="password" class="block text-sm font-medium text-white mb-1">
            {{ __('gdpr::register.fields.password.label') }}
        </label>
        <div class="relative">
            <input
                wire:model="password"
                type="{{ $show_password ? 'text' : 'password' }}"
                id="password"
                name="password"
                required
                autocomplete="new-password"
                class="w-full px-4 py-3 bg-slate-800/50 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all pr-12"
                aria-describedby="password_error"
            >
            <button
                wire:click="togglePassword"
                type="button"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white transition-colors"
                aria-label="{{ $show_password ? __('gdpr::register.form.hide_password') : __('gdpr::register.form.show_password') }}"
            >
                @if($show_password)
                    <x-filament::icon icon="heroicon-o-eye-slash" class="w-5 h-5" />
                @else
                    <x-filament::icon icon="heroicon-o-eye" class="w-5 h-5" />
                @endif
            </button>
        </div>
        @error('password')
            <p id="password_error" class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Confirm Password --}}
    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-white mb-1">
            {{ __('gdpr::register.fields.password_confirmation.label') }}
        </label>
        <input
            wire:model="password_confirmation"
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            required
            autocomplete="new-password"
            class="w-full px-4 py-3 bg-slate-800/50 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all"
            aria-describedby="password_confirmation_error"
        >
        @error('password_confirmation')
            <p id="password_confirmation_error" class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Consensi GDPR --}}
    <div class="space-y-3 pt-2 border-t border-slate-700/50">
        <div class="flex items-start gap-3">
            <input
                wire:model="privacy_accepted"
                type="checkbox"
                id="privacy_accepted"
                name="privacy_accepted"
                required
                class="mt-1 w-4 h-4 text-red-600 border-slate-600 rounded bg-slate-800 focus:ring-red-500 focus:ring-2"
            >
            <label for="privacy_accepted" class="text-sm text-slate-300">
                {{ __('gdpr::register.consents.privacy_policy_label') }}
                <a href="{{ url('/'.app()->getLocale().'/privacy') }}" target="_blank" rel="noopener" class="underline text-white">{{ __('gdpr::register.consents.privacy_policy_link') }}<span class="sr-only"> ({{ __('gdpr::register.consents.opens_new_tab') }})</span></a>
            </label>
        </div>
        @error('privacy_accepted')
            <p class="text-sm text-red-400">{{ $message }}</p>
        @enderror

        <div class="flex items-start gap-3">
            <input
                wire:model="terms_accepted"
                type="checkbox"
                id="terms_accepted"
                name="terms_accepted"
                required
                class="mt-1 w-4 h-4 text-red-600 border-slate-600 rounded bg-slate-800 focus:ring-red-500 focus:ring-2"
            >
            <label for="terms_accepted" class="text-sm text-slate-300">
                {{ __('gdpr::register.consents.terms_label') }}
                <a href="{{ url('/'.app()->getLocale().'/terms') }}" target="_blank" rel="noopener" class="underline text-white">{{ __('gdpr::register.consents.terms_link') }}<span class="sr-only"> ({{ __('gdpr::register.consents.opens_new_tab') }})</span></a>
            </label>
        </div>
        @error('terms_accepted')
            <p class="text-sm text-red-400">{{ $message }}</p>
        @enderror

        <div class="flex items-start gap-3">
            <input
                wire:model="marketing_consent"
                type="checkbox"
                id="marketing_consent"
                name="marketing_consent"
                class="mt-1 w-4 h-4 text-red-600 border-slate-600 rounded bg-slate-800 focus:ring-red-500 focus:ring-2"
            >
            <label for="marketing_consent" class="text-sm text-slate-300">
                {{ __('gdpr::register.consents.marketing_label') }}
            </label>
        </div>
    </div>

    {{-- Submit --}}
    <div class="pt-4">
        <button
            wire:loading.attr="disabled"
            type="submit"
            class="w-full py-3 px-6 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-slate-900 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
        >
            {{ __('gdpr::register.form.submit') }}
        </button>
    </div>

    {{-- Error bag --}}
    @if ($errors->any())
        <div class="p-4 bg-red-900/30 border border-red-600/50 rounded-lg" role="alert">
            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="text-sm text-red-300">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</form>
