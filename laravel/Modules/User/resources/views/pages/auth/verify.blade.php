<?php

declare(strict_types=1);
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Livewire\Volt\Component;
use Modules\User\Actions\Auth\ResendEmailVerificationAction;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

middleware(['auth', 'throttle:6,1']);
name('verification.notice');

new class extends Component {
    public function resend()
    {
        $user = auth()->user();
        abort_unless($user instanceof MustVerifyEmail, 403);

        if (! app(ResendEmailVerificationAction::class)->execute($user)) {
            return redirect('/');
        }

        $this->dispatch('resent');
        session()->flash('resent');
    }
};

?>

<x-layouts.main>

    <div class="flex flex-col items-stretch justify-center w-screen min-h-screen py-10 sm:items-center">

        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <x-ui.link href="{{ route('home') }}">
                <x-ui.logo class="w-auto h-10 mx-auto text-gray-700 fill-current dark:text-gray-100" />
            </x-ui.link>

            <h2 class="mt-6 text-2xl font-extrabold leading-9 text-center text-gray-700 dark:text-gray-200">
                {{ __('user::auth_pages.sections.verify.title') }}
            </h2>

            <div class="mt-2 text-sm leading-5 text-center text-gray-600 dark:text-gray-400 space-x-0.5">
                <span>{{ __('user::auth_pages.common.or.label') }}</span>
                <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-gray-500 underline cursor-pointer dark:text-gray-400 dark:hover:text-gray-300 hover:text-gray-800">
                    {{ __('user::auth_pages.verify.sign_out.label') }}
                </button>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">

            @volt('auth.verify')
            <div class="px-10 py-0 sm:py-8 sm:shadow-sm sm:bg-white dark:sm:bg-gray-950/50 dark:border-gray-200/10 sm:border sm:rounded-lg border-gray-200/60">
                @if (session('resent'))
                <div class="flex items-center px-4 py-3 mb-6 text-sm text-white bg-green-500 rounded shadow" role="alert">
                    <svg class="w-4 h-4 mr-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>

                    <p>{{ __('user::auth_pages.verify.resent.message') }}</p>
                </div>
                @endif

                <div class="text-sm leading-6 text-gray-700 dark:text-gray-400">
                    <p>{{ __('user::auth_pages.verify.check_email.description') }} {{ __('user::auth_pages.verify.not_received.message') }} <a wire:click="resend" class="text-gray-700 underline transition duration-150 ease-in-out cursor-pointer dark:text-gray-300 hover:text-gray-600 focus:outline-none focus:underline">{{ __('user::auth_pages.verify.request_another.label') }}</a>.</p>
                </div>
            </div>
            @endvolt

        </div>
    </div>

</x-layouts.main>
