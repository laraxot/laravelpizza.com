<?php

use function Laravel\Folio\name;
use Livewire\Volt\Component;
use Livewire\Attributes\Validate;

name('password.confirm');

new class extends Component
{
    #[Validate('required|current_password')]
    public $password = '';

    public function confirm()
    {
        $this->validate();

        session()->put('auth.password_confirmed_at', time());

        return redirect()->intended('/');
    }
};

?>

<<<<<<< .merge_file_7wmiB1
<x-layouts.app :title="__('pub_theme::auth.password.confirm.title')">
    <x-ui.auth-card :title="__('pub_theme::auth.password.confirm.title')" :subtitle="__('pub_theme::auth.password.confirm.subtitle')">
        @volt('meetup.auth.password.confirm')
            <form wire:submit="confirm" class="space-y-6" novalidate>
                <x-ui.auth-field :label="__('pub_theme::auth.password.confirm.password')" id="password" type="password" autocomplete="current-password" autofocus wire:model="password" />
                <div class="text-right text-sm">
                    <a href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::localizeUrl('/auth/password/reset') }}" class="font-semibold text-red-400 hover:text-red-300">{{ __('pub_theme::auth.password.confirm.forgot') }}</a>
                </div>
                <button type="submit" wire:loading.attr="disabled" class="flex w-full items-center justify-center rounded-xl bg-red-600 px-4 py-3 font-bold text-white shadow-lg shadow-red-900/30 transition hover:bg-red-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-800 disabled:opacity-60">
                    {{ __('pub_theme::auth.password.confirm.submit') }}
                </button>
            </form>
        @endvolt
    </x-ui.auth-card>
</x-layouts.app>
=======
<x-layouts.main>
    <div class="flex flex-col items-stretch justify-center w-screen min-h-screen py-10 sm:items-center">

        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <x-ui.link href="{{ route('home') }}">
                <x-ui.logo class="w-auto h-10 mx-auto text-gray-700 fill-current dark:text-gray-100" />
                <x-ui.logo class="w-auto h-10 mx-auto text-gray-700 fill-current dark:text-gray-100" />
            </x-ui.link>

            <h2 class="mt-5 text-2xl font-extrabold leading-9 text-center text-gray-800 dark:text-gray-200">
                {{ __('pub_theme::auth.password.confirm.title') }}
            </h2>
            <p class="text-sm leading-5 text-center text-gray-600 dark:text-gray-400 space-x-0.5">
                {{ __('pub_theme::auth.password.confirm.message') }}
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="px-10 py-0 sm:py-8 sm:shadow-sm sm:bg-white dark:sm:bg-gray-950/50 dark:border-gray-200/10 sm:border sm:rounded-lg border-gray-200/60">
                @volt('auth.password.confirm')
                <form wire:submit="confirm" class="space-y-6">
                    <x-ui.input :label="__('pub_theme::common.fields.password.label')" type="password" id="password" name="password" wire:model="password" />
                    <div class="flex items-center justify-end text-sm">
                        <x-ui.text-link href="{{ route('password.request') }}">{{ __('pub_theme::auth.password.forgot.label') }}</x-ui.text-link>
                    </div>
                    <x-ui.button type="primary" rounded="md" submit="true">{{ __('pub_theme::auth.password.confirm.label') }}</x-ui.button>
                </form>
                @endvolt
            </div>
        </div>
    </div>

</x-layouts.main>
>>>>>>> .merge_file_jHmfGm
