<div class="space-y-3">
    @if ($message)
        <div
            role="{{ $messageType === 'error' ? 'alert' : 'status' }}"
            @class([
                'rounded-lg px-4 py-3 text-sm font-medium',
                'bg-emerald-50 text-emerald-800 dark:bg-emerald-500/10 dark:text-emerald-200' => $messageType === 'success',
                'bg-red-50 text-red-800 dark:bg-red-500/10 dark:text-red-200' => $messageType === 'error',
            ])
        >
            {{ $message }}
        </div>
    @endif

    @if ($isRegistered)
        <p class="text-sm font-semibold text-emerald-700 dark:text-emerald-300">
            {{ __('meetup::event_registration.state.registered') }}
        </p>
        <button
            type="button"
            wire:click="unregister"
            wire:loading.attr="disabled"
            class="block w-full rounded-lg border border-slate-300 px-6 py-3 text-center font-semibold text-slate-700 transition-colors hover:bg-slate-100 focus:outline-none focus:ring-4 focus:ring-slate-300 disabled:opacity-50 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-700"
        >
            <span wire:loading.remove wire:target="unregister">{{ __('meetup::event_registration.actions.unregister') }}</span>
            <span wire:loading wire:target="unregister">{{ __('meetup::event_registration.actions.loading') }}</span>
        </button>
    @elseif ($isFull)
        <p class="rounded-lg bg-amber-50 px-4 py-3 text-sm font-medium text-amber-800 dark:bg-amber-500/10 dark:text-amber-200">
            {{ __('meetup::event_registration.state.full') }}
        </p>
    @elseif ($isGuest)
        {{-- FR-9: il visitatore si iscrive qui con email e password, senza passare da una pagina di registrazione. --}}
        <form wire:submit="signUp" class="space-y-3" novalidate>
            <p class="text-sm text-slate-600 dark:text-slate-300">{{ __('meetup::event_registration.signup.intro') }}</p>

            @foreach (['email' => ['email', 'email'], 'password' => ['password', 'current-password']] as $field => [$type, $autocomplete])
                <div>
                    <label for="event-signup-{{ $field }}" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">
                        {{ __('meetup::event_registration.signup.'.$field) }}
                    </label>
                    <input
                        wire:model="{{ $field }}"
                        id="event-signup-{{ $field }}"
                        type="{{ $type }}"
                        autocomplete="{{ $autocomplete }}"
                        required
                        @error($field) aria-invalid="true" aria-describedby="event-signup-{{ $field }}-error" @enderror
                        @class([
                            'block w-full rounded-lg border bg-white px-3 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-red-500/50 dark:bg-slate-900 dark:text-white',
                            'border-red-500' => $errors->has($field),
                            'border-slate-300 dark:border-slate-600' => ! $errors->has($field),
                        ])
                    />
                    @error($field)
                        <p id="event-signup-{{ $field }}-error" class="mt-1 text-sm text-red-700 dark:text-red-300">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach

            <div>
                <label class="flex items-start gap-2 text-sm text-slate-600 dark:text-slate-300">
                    <input
                        wire:model="consentsAccepted"
                        type="checkbox"
                        class="mt-0.5 h-4 w-4 rounded border-slate-300 text-red-600 focus:ring-red-500"
                        @error('consentsAccepted') aria-invalid="true" aria-describedby="event-signup-consents-error" @enderror
                    />
                    <span>
                        {!! __('meetup::event_registration.signup.consents', [
                            'privacy' => '<a href="'.e($privacyUrl).'" class="font-semibold text-red-700 underline dark:text-red-300" target="_blank">'.e(__('meetup::event_registration.signup.privacy')).'</a>',
                            'terms' => '<a href="'.e($termsUrl).'" class="font-semibold text-red-700 underline dark:text-red-300" target="_blank">'.e(__('meetup::event_registration.signup.terms')).'</a>',
                        ]) !!}
                    </span>
                </label>
                @error('consentsAccepted')
                    <p id="event-signup-consents-error" class="mt-1 text-sm text-red-700 dark:text-red-300">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="block w-full rounded-lg bg-red-600 px-6 py-3.5 text-center font-bold text-white transition-all hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 disabled:opacity-50"
            >
                <span wire:loading.remove wire:target="signUp">{{ __('meetup::event_registration.actions.register') }}</span>
                <span wire:loading wire:target="signUp">{{ __('meetup::event_registration.actions.loading') }}</span>
            </button>
            <p class="text-center text-xs text-slate-500 dark:text-slate-400">
                {{ trans_choice('meetup::event_registration.state.spots_left', $availableSpots, ['count' => $availableSpots]) }}
            </p>
            <p class="text-center text-sm text-slate-600 dark:text-slate-300">
                {{ __('meetup::event_registration.signup.have_account') }}
                <a href="{{ $loginUrl }}" wire:click.prevent="register" class="font-semibold text-red-700 underline dark:text-red-300">{{ __('meetup::event_registration.signup.login') }}</a>
            </p>
        </form>
    @else
        <button
            type="button"
            wire:click="register"
            wire:loading.attr="disabled"
            class="block w-full rounded-lg bg-red-600 px-6 py-3.5 text-center font-bold text-white transition-all hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 disabled:opacity-50"
        >
            <span wire:loading.remove wire:target="register">{{ __('meetup::event_registration.actions.register') }}</span>
            <span wire:loading wire:target="register">{{ __('meetup::event_registration.actions.loading') }}</span>
        </button>
        <p class="text-center text-xs text-slate-500 dark:text-slate-400">
            {{ trans_choice('meetup::event_registration.state.spots_left', $availableSpots, ['count' => $availableSpots]) }}
        </p>
    @endif
</div>
