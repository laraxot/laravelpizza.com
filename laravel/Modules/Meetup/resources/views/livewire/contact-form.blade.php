<div>
    @if ($sent)
        <div role="status" class="rounded-xl bg-emerald-50 px-6 py-5 text-emerald-800 dark:bg-emerald-500/10 dark:text-emerald-200">
            <p class="font-semibold">{{ __('meetup::contact_form.sent.title') }}</p>
            <p class="mt-1 text-sm">{{ __('meetup::contact_form.sent.body') }}</p>
        </div>
    @else
        <form wire:submit="submit" class="space-y-5" novalidate>
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="contact-name" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">{{ __('meetup::contact_form.fields.name') }} <span class="text-red-600">*</span></label>
                    <input id="contact-name" type="text" wire:model="name" autocomplete="name" required
                           class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-red-500 focus:ring-2 focus:ring-red-500 dark:border-slate-600 dark:bg-slate-900 dark:text-white">
                    @error('name') <p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="contact-email" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">{{ __('meetup::contact_form.fields.email') }} <span class="text-red-600">*</span></label>
                    <input id="contact-email" type="email" wire:model="email" autocomplete="email" required
                           class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-red-500 focus:ring-2 focus:ring-red-500 dark:border-slate-600 dark:bg-slate-900 dark:text-white">
                    @error('email') <p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p> @enderror
                </div>
            </div>
            <div>
                <label for="contact-message" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">{{ __('meetup::contact_form.fields.message') }} <span class="text-red-600">*</span></label>
                <textarea id="contact-message" wire:model="message" rows="6" required
                          class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-red-500 focus:ring-2 focus:ring-red-500 dark:border-slate-600 dark:bg-slate-900 dark:text-white"></textarea>
                @error('message') <p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p> @enderror
            </div>
            {{-- Campo esca per i bot: nascosto alle persone e ai lettori di schermo --}}
            <div class="hidden" aria-hidden="true">
                <label for="contact-website">Website</label>
                <input id="contact-website" type="text" wire:model="website" tabindex="-1" autocomplete="off">
            </div>
            <div>
                <label class="flex items-start gap-3 text-sm text-slate-700 dark:text-slate-200">
                    <input type="checkbox" wire:model="privacy_accepted" class="mt-1 rounded border-slate-300 text-red-600 focus:ring-red-500">
                    <span>{!! __('meetup::contact_form.privacy_html', ['url' => e($privacyUrl)]) !!}</span>
                </label>
                @error('privacy_accepted') <p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p> @enderror
            </div>
            <button type="submit" wire:loading.attr="disabled"
                    class="w-full rounded-lg bg-red-600 px-6 py-3 font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 disabled:opacity-50 sm:w-auto">
                <span wire:loading.remove wire:target="submit">{{ __('meetup::contact_form.submit') }}</span>
                <span wire:loading wire:target="submit">{{ __('meetup::event_registration.actions.loading') }}</span>
            </button>
        </form>
    @endif
</div>
