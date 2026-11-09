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
    @else
        <button
            type="button"
            wire:click="register"
            wire:loading.attr="disabled"
            class="block w-full rounded-lg bg-red-600 px-6 py-3.5 text-center font-bold text-white transition-all hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 disabled:opacity-50"
        >
            <span wire:loading.remove wire:target="register">
                {{ $isGuest ? __('meetup::event_registration.actions.login_to_register') : __('meetup::event_registration.actions.register') }}
            </span>
            <span wire:loading wire:target="register">{{ __('meetup::event_registration.actions.loading') }}</span>
        </button>
        <p class="text-center text-xs text-slate-500 dark:text-slate-400">
            {{ trans_choice('meetup::event_registration.state.spots_left', $availableSpots, ['count' => $availableSpots]) }}
        </p>
    @endif
</div>
