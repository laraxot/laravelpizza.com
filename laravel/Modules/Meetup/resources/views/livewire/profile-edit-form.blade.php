{{--
    Form "Modifica il profilo" (Modules\Meetup\Http\Livewire\ProfileEditForm).
    Tre schede indipendenti: dati, foto, password. Ogni scheda ha il suo pulsante e la sua conferma (role="status").
--}}
@php
    $input = 'block w-full rounded-xl border border-slate-600 bg-slate-900/60 px-4 py-3 text-white placeholder-slate-500 transition focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/40';
    $label = 'mb-1.5 block text-sm font-medium text-slate-200';
    $card = 'rounded-2xl border border-slate-700/60 bg-slate-800/70 p-6 shadow-xl sm:p-8';
    $primary = 'inline-flex items-center justify-center rounded-xl bg-red-600 px-6 py-3 font-bold text-white shadow-lg shadow-red-900/30 transition hover:bg-red-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-800 disabled:opacity-60';
    $secondary = 'inline-flex items-center justify-center rounded-xl border border-white/20 bg-white/5 px-5 py-3 font-semibold text-white transition hover:bg-white/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/50 disabled:opacity-60';
    $error = 'mt-2 text-sm text-red-400';
    $savedClass = 'flex items-center gap-2 text-sm font-medium text-green-300';
@endphp

<div class="space-y-8">
    {{-- Dati del profilo --}}
    <section class="{{ $card }}" aria-labelledby="profile-data-heading">
        <h2 id="profile-data-heading" class="text-xl font-bold text-white">{{ __('meetup::profile_edit.sections.data.title') }}</h2>
        <p class="mt-1 text-sm text-slate-300">{{ __('meetup::profile_edit.sections.data.description') }}</p>

        <form wire:submit="saveProfile" class="mt-6 space-y-5" novalidate>
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="profile-first-name" class="{{ $label }}">{{ __('meetup::profile_edit.fields.first_name') }}</label>
                    <input id="profile-first-name" type="text" wire:model="first_name" autocomplete="given-name" required class="{{ $input }}"
                           @error('first_name') aria-invalid="true" aria-describedby="profile-first-name-error" @enderror>
                    @error('first_name') <p id="profile-first-name-error" class="{{ $error }}">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="profile-last-name" class="{{ $label }}">{{ __('meetup::profile_edit.fields.last_name') }}</label>
                    <input id="profile-last-name" type="text" wire:model="last_name" autocomplete="family-name" required class="{{ $input }}"
                           @error('last_name') aria-invalid="true" aria-describedby="profile-last-name-error" @enderror>
                    @error('last_name') <p id="profile-last-name-error" class="{{ $error }}">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="profile-email" class="{{ $label }}">{{ __('meetup::profile_edit.fields.email') }}</label>
                <input id="profile-email" type="email" value="{{ $email }}" readonly aria-describedby="profile-email-help" class="{{ $input }} cursor-not-allowed opacity-70">
                <p id="profile-email-help" class="mt-2 text-sm text-slate-400">{{ __('meetup::profile_edit.help.email') }}</p>
            </div>

            <div>
                <label for="profile-bio" class="{{ $label }}">{{ __('meetup::profile_edit.fields.bio') }}</label>
                <textarea id="profile-bio" wire:model="bio" rows="4" maxlength="500" aria-describedby="profile-bio-help" class="{{ $input }}"
                          placeholder="{{ __('meetup::profile_edit.placeholders.bio') }}"></textarea>
                <p id="profile-bio-help" class="mt-2 text-sm text-slate-400">{{ __('meetup::profile_edit.help.bio') }}</p>
                @error('bio') <p class="{{ $error }}">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="profile-locale" class="{{ $label }}">{{ __('meetup::profile_edit.fields.locale') }}</label>
                <select id="profile-locale" wire:model="locale" aria-describedby="profile-locale-help" class="{{ $input }}">
                    @foreach($locales as $code => $native)
                        <option value="{{ $code }}" lang="{{ $code }}">{{ $native }}</option>
                    @endforeach
                </select>
                <p id="profile-locale-help" class="mt-2 text-sm text-slate-400">{{ __('meetup::profile_edit.help.locale') }}</p>
                @error('locale') <p class="{{ $error }}">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-wrap items-center gap-4">
                <button type="submit" wire:loading.attr="disabled" wire:target="saveProfile" class="{{ $primary }}">{{ __('meetup::profile_edit.actions.save_profile') }}</button>
                <a href="{{ $publicProfileUrl }}" class="text-sm font-semibold text-red-400 hover:text-red-300">{{ __('meetup::profile_edit.actions.view_public') }}</a>
                @if($saved === 'profile')
                    <p class="{{ $savedClass }}" role="status"><x-heroicon-o-check-circle class="h-5 w-5" aria-hidden="true" /> {{ __('meetup::profile_edit.saved.profile') }}</p>
                @endif
            </div>
        </form>
    </section>

    {{-- Foto --}}
    <section class="{{ $card }}" aria-labelledby="profile-photo-heading">
        <h2 id="profile-photo-heading" class="text-xl font-bold text-white">{{ __('meetup::profile_edit.sections.photo.title') }}</h2>
        <p class="mt-1 text-sm text-slate-300">{{ __('meetup::profile_edit.sections.photo.description') }}</p>

        <div class="mt-6 flex flex-col gap-6 sm:flex-row sm:items-center">
            <div class="h-24 w-24 shrink-0 overflow-hidden rounded-full border-2 border-slate-600">
                @if($photo && method_exists($photo, 'isPreviewable') && $photo->isPreviewable())
                    <img src="{{ $photo->temporaryUrl() }}" alt="{{ __('meetup::profile_edit.photo.preview_alt') }}" class="h-full w-full object-cover">
                @elseif($avatarUrl !== '')
                    <img src="{{ $avatarUrl }}" alt="{{ __('meetup::profile_edit.photo.current_alt') }}" class="h-full w-full object-cover">
                @else
                    <span class="flex h-full w-full items-center justify-center bg-gradient-to-br from-red-500 to-orange-500 text-2xl font-bold text-white" aria-hidden="true">{{ $initials !== '' ? $initials : '?' }}</span>
                @endif
            </div>

            <form wire:submit="savePhoto" class="flex-1 space-y-4" novalidate>
                <div>
                    <label for="profile-photo" class="{{ $label }}">{{ __('meetup::profile_edit.fields.photo') }}</label>
                    <input id="profile-photo" type="file" wire:model="photo" accept="image/jpeg,image/png,image/webp" aria-describedby="profile-photo-help"
                           class="block w-full text-sm text-slate-300 file:mr-4 file:rounded-lg file:border-0 file:bg-slate-700 file:px-4 file:py-2 file:font-semibold file:text-white hover:file:bg-slate-600">
                    <p id="profile-photo-help" class="mt-2 text-sm text-slate-400">{{ __('meetup::profile_edit.help.photo') }}</p>
                    <p wire:loading wire:target="photo" class="mt-2 text-sm text-slate-300">{{ __('meetup::profile_edit.photo.uploading') }}</p>
                    @error('photo') <p class="{{ $error }}">{{ $message }}</p> @enderror
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <button type="submit" wire:loading.attr="disabled" wire:target="photo,savePhoto" class="{{ $primary }}">{{ __('meetup::profile_edit.actions.save_photo') }}</button>
                    @if($avatarUrl !== '')
                        <button type="button" wire:click="removePhoto" wire:loading.attr="disabled" class="{{ $secondary }}">{{ __('meetup::profile_edit.actions.remove_photo') }}</button>
                    @endif
                    @if($saved === 'photo')
                        <p class="{{ $savedClass }}" role="status"><x-heroicon-o-check-circle class="h-5 w-5" aria-hidden="true" /> {{ __('meetup::profile_edit.saved.photo') }}</p>
                    @endif
                </div>
            </form>
        </div>
    </section>

    {{-- Password --}}
    <section class="{{ $card }}" aria-labelledby="profile-password-heading">
        <h2 id="profile-password-heading" class="text-xl font-bold text-white">{{ __('meetup::profile_edit.sections.password.title') }}</h2>
        <p class="mt-1 text-sm text-slate-300">{{ __('meetup::profile_edit.sections.password.description') }}</p>

        <form wire:submit="changePassword" class="mt-6 space-y-5" novalidate>
            <div>
                <label for="profile-current-password" class="{{ $label }}">{{ __('meetup::profile_edit.fields.current_password') }}</label>
                <input id="profile-current-password" type="password" wire:model="current_password" autocomplete="current-password" required class="{{ $input }}"
                       @error('current_password') aria-invalid="true" aria-describedby="profile-current-password-error" @enderror>
                @error('current_password') <p id="profile-current-password-error" class="{{ $error }}">{{ $message }}</p> @enderror
            </div>
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="profile-password" class="{{ $label }}">{{ __('meetup::profile_edit.fields.password') }}</label>
                    <input id="profile-password" type="password" wire:model="password" autocomplete="new-password" required class="{{ $input }}"
                           @error('password') aria-invalid="true" aria-describedby="profile-password-error" @enderror>
                    @error('password') <p id="profile-password-error" class="{{ $error }}">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="profile-password-confirmation" class="{{ $label }}">{{ __('meetup::profile_edit.fields.password_confirmation') }}</label>
                    <input id="profile-password-confirmation" type="password" wire:model="password_confirmation" autocomplete="new-password" required class="{{ $input }}">
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-4">
                <button type="submit" wire:loading.attr="disabled" wire:target="changePassword" class="{{ $primary }}">{{ __('meetup::profile_edit.actions.change_password') }}</button>
                @if($saved === 'password')
                    <p class="{{ $savedClass }}" role="status"><x-heroicon-o-check-circle class="h-5 w-5" aria-hidden="true" /> {{ __('meetup::profile_edit.saved.password') }}</p>
                @endif
            </div>
        </form>
    </section>

    {{-- Eliminazione dell'account (GDPR art. 17) --}}
    <section class="rounded-2xl border border-red-500/40 bg-red-950/30 p-6 shadow-xl sm:p-8" aria-labelledby="profile-delete-heading" x-data="{ open: @js($errors->hasAny(['delete_password', 'delete_confirmed', 'delete_reason'])) }">
        <h2 id="profile-delete-heading" class="text-xl font-bold text-white">{{ __('meetup::profile_edit.delete.title') }}</h2>
        <p class="mt-1 text-sm text-slate-300">{{ __('meetup::profile_edit.delete.description') }}</p>

        <button type="button" x-show="! open" x-on:click="open = true" class="{{ $secondary }} mt-6 border-red-500/50 text-red-200 hover:bg-red-500/10">
            {{ __('meetup::profile_edit.delete.open') }}
        </button>

        <form x-show="open" x-cloak wire:submit="deleteAccount" class="mt-6 space-y-5" novalidate>
            <div>
                <label for="profile-delete-reason" class="{{ $label }}">{{ __('meetup::profile_edit.delete.reason') }}</label>
                <textarea id="profile-delete-reason" wire:model="delete_reason" rows="2" maxlength="1000" class="{{ $input }}"></textarea>
            </div>
            <div>
                <label for="profile-delete-password" class="{{ $label }}">{{ __('meetup::profile_edit.fields.current_password') }}</label>
                <input id="profile-delete-password" type="password" wire:model="delete_password" autocomplete="current-password" required class="{{ $input }}"
                       @error('delete_password') aria-invalid="true" aria-describedby="profile-delete-password-error" @enderror>
                @error('delete_password') <p id="profile-delete-password-error" class="{{ $error }}">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="flex items-start gap-3 text-sm text-slate-200">
                    <input type="checkbox" wire:model="delete_confirmed" class="mt-1 rounded border-slate-500 text-red-600 focus:ring-red-500">
                    <span>{{ __('meetup::profile_edit.delete.confirm') }}</span>
                </label>
                @error('delete_confirmed') <p class="{{ $error }}">{{ $message }}</p> @enderror
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <button type="submit" wire:loading.attr="disabled" wire:target="deleteAccount" class="inline-flex items-center justify-center rounded-xl bg-red-700 px-6 py-3 font-bold text-white transition hover:bg-red-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-300 disabled:opacity-60">
                    {{ __('meetup::profile_edit.delete.submit') }}
                </button>
                <button type="button" x-on:click="open = false" class="{{ $secondary }}">{{ __('meetup::profile_edit.delete.cancel') }}</button>
            </div>
        </form>
    </section>
</div>
