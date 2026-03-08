<?php

/**
 * Profile edit page using Folio and Volt.
 * Optimized for Laraxot architecture.
 */

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Modules\User\Models\User;
use Webmozart\Assert\Assert;

use function Livewire\Volt\layout;
use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

name('profile.edit');
layout('x-layouts.app');
middleware(['auth', 'verified']);

$component = new class extends Component {
    /** @var string */
    #[Validate('required|string|max:100')]
    public string $first_name = '';

    /** @var string */
    #[Validate('required|string|max:100')]
    public string $last_name = '';

    /** @var string */
    #[Validate('required|string|max:255')]
    public string $email = '';

    /** @var string */
    #[Locked]
    public string $user_id = '';

    /** @var string */
    public string $current_password = '';

    /** @var string */
    public string $password = '';

    /** @var string */
    public string $password_confirmation = '';

    public function mount(): void
    {
        try {
            /** @var User|null $user */
            $user = Auth::user();
            Assert::notNull($user, 'User must be authenticated');
            Assert::isInstanceOf($user, User::class);

            $this->first_name = (string) $user->first_name;
            $this->last_name = (string) $user->last_name;
            $this->email = (string) $user->email;
            $this->user_id = (string) $user->id;

        } catch (\Exception $e) {
            Log::error('Profile mount failed', ['error' => $e->getMessage()]);
            $this->redirectRoute('dashboard');
        }
    }

    public function updateProfile(): void
    {
        $validated = $this->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', Rule::unique('user.users', 'email')->ignore($this->user_id)],
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->update($validated);

        session()->flash('status', 'profile-updated');
    }

    public function updatePassword(): void
    {
        $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->update(['password' => Hash::make($this->password)]);

        $this->reset(['current_password', 'password', 'password_confirmation']);
        session()->flash('status', 'password-updated');
    }
};

?>

@volt('profile.edit')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Update Profile --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Profile Information') }}</h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __("Update your account's profile information and email address.") }}</p>
                        </header>

                        <form wire:submit="updateProfile" class="mt-6 space-y-6">
                            <div>
                                <x-filament::input.wrapper :label="__('First Name')" :error="$errors->first('first_name')">
                                    <x-filament::input type="text" wire:model="first_name" required />
                                </x-filament::input.wrapper>
                            </div>
                            <div>
                                <x-filament::input.wrapper :label="__('Last Name')" :error="$errors->first('last_name')">
                                    <x-filament::input type="text" wire:model="last_name" required />
                                </x-filament::input.wrapper>
                            </div>
                            <div>
                                <x-filament::input.wrapper :label="__('Email')" :error="$errors->first('email')">
                                    <x-filament::input type="email" wire:model="email" required />
                                </x-filament::input.wrapper>
                            </div>
                            <div class="flex items-center gap-4">
                                <x-filament::button type="submit">{{ __('Save') }}</x-filament::button>
                                @if (session('status') === 'profile-updated')
                                    <p class="text-sm text-green-600 dark:text-green-400">{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            {{-- Update Password --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Update Password') }}</h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
                        </header>

                        <form wire:submit="updatePassword" class="mt-6 space-y-6">
                            <div>
                                <x-filament::input.wrapper :label="__('Current Password')" :error="$errors->first('current_password')">
                                    <x-filament::input type="password" wire:model="current_password" required />
                                </x-filament::input.wrapper>
                            </div>
                            <div>
                                <x-filament::input.wrapper :label="__('New Password')" :error="$errors->first('password')">
                                    <x-filament::input type="password" wire:model="password" required />
                                </x-filament::input.wrapper>
                            </div>
                            <div>
                                <x-filament::input.wrapper :label="__('Confirm Password')" :error="$errors->first('password_confirmation')">
                                    <x-filament::input type="password" wire:model="password_confirmation" required />
                                </x-filament::input.wrapper>
                            </div>
                            <div class="flex items-center gap-4">
                                <x-filament::button type="submit">{{ __('Save') }}</x-filament::button>
                                @if (session('status') === 'password-updated')
                                    <p class="text-sm text-green-600 dark:text-green-400">{{ __('Updated.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endvolt
