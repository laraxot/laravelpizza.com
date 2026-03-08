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

<<<<<<< HEAD
    /**
     * User ID (locked to prevent tampering).
     *
     * @var string
     */
||||||| 6161e129d
    /**
     * User ID (locked to prevent tampering).
     *
     * @var int
     */
=======
    /** @var string */
>>>>>>> feature/ralph-loop-implementation
    #[Locked]
    public string $user_id = '';

    /** @var string */
    #[Validate('required|current_password')]
    public string $current_password = '';

    /** @var string */
    #[Validate('required|min:8|confirmed')]
    public string $password = '';

    /** @var string */
    public string $password_confirmation = '';

    /** @var string */
    #[Validate('required|current_password')]
    public string $delete_password = '';

    public function mount(): void
    {
        try {
            /** @var User|null $user */
            $user = Auth::user();
            Assert::notNull($user, 'User must be authenticated');
            Assert::isInstanceOf($user, User::class);

<<<<<<< HEAD
            // Type-safe property initialization
            $this->first_name = (string) ($user->first_name ?? '');
            $this->last_name = (string) ($user->last_name ?? '');
            $this->email = (string) ($user->email ?? '');
            $this->user_id = (string) ($user->id ?? '');
||||||| 6161e129d
            // Type-safe property initialization
            $this->first_name = (string) ($user->first_name ?? '');
            $this->last_name = (string) ($user->last_name ?? '');
            $this->email = (string) ($user->email ?? '');
            $this->user_id = (int) ($user->id ?? 0);
=======
            $first_name = (string);
            $last_name = (string);
            $email = (string);
            $user_id = (string);
>>>>>>> feature/ralph-loop-implementation

<<<<<<< HEAD
            Assert::stringNotEmpty($this->first_name, 'User first name cannot be empty');
            Assert::stringNotEmpty($this->last_name, 'User last name cannot be empty');
            Assert::stringNotEmpty($this->email, 'User email cannot be empty');
            Assert::stringNotEmpty($this->user_id, 'User ID cannot be empty');

            // Validate email format
            Assert::true(filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false, 'User email must be valid');
        } catch (\Webmozart\Assert\InvalidArgumentException $e) {
            Log::error('Profile mount validation failed', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Redirect to login if user data is corrupted
            redirect()->route('login')->with('error', 'Invalid user session. Please log in again.');
||||||| 6161e129d
            Assert::stringNotEmpty($this->first_name, 'User first name cannot be empty');
            Assert::stringNotEmpty($this->last_name, 'User last name cannot be empty');
            Assert::stringNotEmpty($this->email, 'User email cannot be empty');
            Assert::greaterThan($this->user_id, 0, 'User ID must be positive');

            // Validate email format
            Assert::true(filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false, 'User email must be valid');
        } catch (\Webmozart\Assert\InvalidArgumentException $e) {
            Log::error('Profile mount validation failed', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Redirect to login if user data is corrupted
            redirect()->route('login')->with('error', 'Invalid user session. Please log in again.');
=======
>>>>>>> feature/ralph-loop-implementation
        } catch (\Exception $e) {
            Log::error('Profile mount failed', ['error' => $e->getMessage()]);
            redirect()->route('dashboard');
        }
    }

    public function updateProfile(): void
    {
        $validated = $this->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user_id)
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->update($validated);

        session()->flash('status', 'Profile updated successfully.');
    }

    public function updatePassword(): void
    {
        $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->update(['password' => Hash::make($password));

        $this->reset(['current_password', 'password', 'password_confirmation']);
        session()->flash('status', 'Password updated successfully.');
    }

    public function deleteAccount(): \Illuminate\Http\RedirectResponse
    {
        $this->validate(['delete_password' => ['required', 'current_password']]);

        /** @var User $user */
        $user = Auth::user();
        Auth::logout();
        $user->delete();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return Redirect::to('/');
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
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
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
                            </div>
                        </form>
<<<<<<< HEAD
                    </div>
                </section>

                {{-- Delete Account Section --}}
                <section class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg dark:bg-gray-900/50 dark:border dark:border-gray-200/10">
                    <div class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Delete Account') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                            </p>
                        </header>

                        <div class="flex items-start justify-start w-auto mt-6 text-left">
                            <x-ui.button 
                                type="danger" 
                                x-data
                                @click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                            >
                                {{ __('Delete Account') }}
                            </x-ui.button>
                        </div>

                        {{-- Delete Account Confirmation Modal --}}
                        {{-- Delete Account Confirmation Modal --}}
                        <x-ui.modal name="confirm-user-deletion" maxWidth="lg" :show="$errors->userDeletion->isNotEmpty()" focusable>
                            <form wire:submit="deleteAccount" class="p-6">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Are you sure you want to delete your account?') }}
                                </h2>
                                
                                <p class="mt-1 mb-6 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                                </p>

                                {{-- Input and Buttons commented out
                                <x-ui.input ... />
                                <div ...> ... </div>
                                --}}
                            </form>
                        </x-ui.modal>
||||||| 6161e129d
                    </div>
                </section>

                {{-- Delete Account Section --}}
                <section class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg dark:bg-gray-900/50 dark:border dark:border-gray-200/10">
                    <div class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Delete Account') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                            </p>
                        </header>

                        <div class="flex items-start justify-start w-auto mt-6 text-left">
                            <x-ui.button 
                                type="danger" 
                                x-data
                                @click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                            >
                                {{ __('Delete Account') }}
                            </x-ui.button>
                        </div>

                        {{-- Delete Account Confirmation Modal --}}
                        <x-ui.modal name="confirm-user-deletion" maxWidth="lg" :show="$errors->userDeletion->isNotEmpty()" focusable>
                            <form wire:submit="deleteAccount" class="p-6">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Are you sure you want to delete your account?') }}
                                </h2>
                                
                                <p class="mt-1 mb-6 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                                </p>

                                <x-ui.input 
                                    label="Password" 
                                    type="password" 
                                    id="delete_password"
                                    name="delete_password" 
                                    wire:model="delete_password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="{{ __('Enter your password to confirm deletion') }}"
                                />

                                <div class="flex justify-end mt-6 space-x-3">
                                    <x-ui.button type="secondary" x-on:click="$dispatch('close')">
                                        {{ __('Cancel') }}
                                    </x-ui.button>

                                    <x-ui.button type="danger" submit="true">
                                        {{ __('Delete Account') }}
                                    </x-ui.button>
                                </div>
                            </form>
                        </x-ui.modal>
=======
>>>>>>> feature/ralph-loop-implementation
                    </section>
                </div>
            </div>
        </div>
    </div>
@endvolt
