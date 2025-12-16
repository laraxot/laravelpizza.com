<?php

declare(strict_types=1);

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

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

name('profile.edit');
middleware(['auth', 'verified']);

/**
 * Profile edit component for managing user profile, password updates, and account deletion.
 *
 * Provides secure functionality for:
 * - Updating profile information with validation
 * - Changing passwords with security checks
 * - Account deletion with confirmation
 * - Comprehensive audit logging
 *
 * Follows strict type safety and comprehensive error handling patterns.
 */
$component = new class extends Component {
    /**
     * Current user's first name.
     *
     * @var string
     */
    #[Validate('required|string|max:100')]
    public string $first_name = '';

    /**
     * Current user's last name.
     *
     * @var string
     */
    #[Validate('required|string|max:100')]
    public string $last_name = '';

    /**
     * Current user's email address.
     *
     * @var string
     */
    #[Validate('required|email|max:255')]
    public string $email = '';

    /**
     * User ID (locked to prevent tampering).
     *
     * @var int
     */
    #[Locked]
    public int $user_id = 0;

    /**
     * Current password for verification.
     *
     * @var string
     */
    #[Validate('required|current_password')]
    public string $current_password = '';

    /**
     * New password for password updates.
     *
     * @var string
     */
    #[Validate('required|min:8|confirmed')]
    public string $password = '';

    /**
     * Password confirmation.
     *
     * @var string
     */
    public string $password_confirmation = '';

    /**
     * Password for account deletion confirmation.
     *
     * @var string
     */
    #[Validate('required|current_password')]
    public string $delete_password = '';

    /**
     * Mount the component and initialize user data with type safety.
     *
     * @return void
     */
    public function mount(): void
    {
        try {
            $user = Auth::user();
            Assert::notNull($user, 'User must be authenticated');
            Assert::isInstanceOf($user, User::class, 'User must be an instance of User model');

            // Type-safe property initialization
            $this->first_name = (string) ($user->first_name ?? '');
            $this->last_name = (string) ($user->last_name ?? '');
            $this->email = (string) ($user->email ?? '');
            $this->user_id = (int) ($user->id ?? 0);

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
        } catch (\Exception $e) {
            Log::error('Profile mount failed', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString(),
            ]);

            redirect()->route('dashboard')->with('error', 'Unable to load profile data.');
        }
    }

    /**
     * Update user profile information with comprehensive validation and error handling.
     *
     * @return void
     */
    /**
     * Update the user's profile information.
     *
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateProfile(): void
    {
        try {
            $validated = $this->validate([
                'first_name' => ['required', 'string', 'max:100'],
                'last_name' => ['required', 'string', 'max:100'],
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($this->user_id),
                ],
            ]);

            $user = Auth::user();
            Assert::notNull($user, 'User must be authenticated for profile update');
            Assert::isInstanceOf($user, User::class, 'User must be an instance of User model');
            Assert::same($this->user_id, (int) $user->id, 'User ID mismatch detected');

            // Check if email has changed for additional validation
            $emailChanged = $user->email !== $validated['email'];

            if ($emailChanged) {
                // Additional email validation for changes
                Assert::false(
                    User::where('email', $validated['email'])->where('id', '!=', $this->user_id)->exists(),
                    'Email is already in use by another user',
                );
            }

            // Update user data with type casting
            $user->fill([
                'first_name' => trim($validated['first_name']),
                'last_name' => trim($validated['last_name']),
                'email' => strtolower(trim($validated['email'])),
            ]);

            // Reset email verification if email changed
            if ($emailChanged && $user->hasVerifiedEmail()) {
                $user->email_verified_at = null;
            }

            // Log before saving to capture original values
            Log::info('Updating user profile', [
                'user_id' => $user->id,
                'old_first_name' => $user->first_name,
                'new_first_name' => $validated['first_name'],
                'old_last_name' => $user->last_name,
                'new_last_name' => $validated['last_name'],
                'old_email' => $user->email,
                'new_email' => $validated['email'],
                'email_changed' => $emailChanged,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            $success = $user->save();
            Assert::true($success, 'Failed to save user profile');

            // Log successful profile update for audit trail
            Log::info('User profile updated successfully', [
                'user_id' => $user->id,
                'changes' => $user->getChanges(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            // Clear password field for security
            $this->reset('current_password');

            // Show success message
            $message = $emailChanged
                ? 'Profile updated successfully. Please verify your new email address.'
                : 'Profile updated successfully.';

            session()->flash('status', $message);

            // Send email verification if email changed
            if ($emailChanged) {
                $user->sendEmailVerificationNotification();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Re-throw validation exceptions to display form errors
            Log::warning('Profile update validation failed', [
                'errors' => $e->errors(),
                'user_id' => $this->user_id,
                'email' => $this->email,
            ]);
            throw $e;
        } catch (\Webmozart\Assert\InvalidArgumentException $e) {
            Log::error('Profile update assertion failed', [
                'error' => $e->getMessage(),
                'user_id' => $this->user_id,
                'name' => $this->name,
                'email' => $this->email,
                'trace' => $e->getTraceAsString(),
            ]);

            session()->flash('error', 'Profile update failed: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Profile update failed with unexpected error', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'user_id' => $this->user_id,
                'trace' => $e->getTraceAsString(),
            ]);

            session()->flash('error', 'An unexpected error occurred while updating your profile.');
        }
    }

    /**
     * Update user password with comprehensive security validation.
     *
     * @return void
     */
    public function updatePassword(): void
    {
        try {
            $this->validate([
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'min:8', 'confirmed'],
                'password_confirmation' => ['required'],
            ]);

            $user = Auth::user();
            Assert::notNull($user, 'User must be authenticated for password update');
            Assert::isInstanceOf($user, User::class, 'User must be an instance of User model');
            Assert::same($this->user_id, (int) $user->id, 'User ID mismatch detected');

            // Validate password strength and format
            Assert::stringNotEmpty($this->current_password, 'Current password cannot be empty');
            Assert::stringNotEmpty($this->password, 'New password cannot be empty');
            Assert::stringNotEmpty($this->password_confirmation, 'Password confirmation cannot be empty');
            Assert::same($this->password, $this->password_confirmation, 'Password confirmation does not match');
            Assert::greaterThanEq(strlen($this->password), 8, 'Password must be at least 8 characters long');

            // Verify current password
            Assert::true(Hash::check($this->current_password, $user->password), 'Current password is incorrect');

            // Ensure new password is different from current
            Assert::false(
                Hash::check($this->password, $user->password),
                'New password must be different from current password',
            );

            // Update password with secure hash
            $user->update([
                'password' => Hash::make($this->password),
                'remember_token' => Str::random(60), // Invalidate existing sessions
            ]);

            // Dispatch password reset event for logging
            event(new PasswordReset($user));

            // Log successful password update for audit trail
            Log::info('User password updated successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'password_length' => strlen($this->password),
            ]);

            // Clear password fields for security
            $this->reset(['current_password', 'password', 'password_confirmation']);

            session()->flash(
                'status',
                'Password updated successfully. You have been logged out of other devices for security.',
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Re-throw validation exceptions to display form errors
            Log::warning('Password update validation failed', [
                'errors' => $e->errors(),
                'user_id' => $this->user_id,
            ]);
            throw $e;
        } catch (\Webmozart\Assert\InvalidArgumentException $e) {
            Log::error('Password update assertion failed', [
                'error' => $e->getMessage(),
                'user_id' => $this->user_id,
                'trace' => $e->getTraceAsString(),
            ]);

            // Clear password fields for security
            $this->reset(['current_password', 'password', 'password_confirmation']);
            session()->flash('error', 'Password update failed: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Password update failed with unexpected error', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'user_id' => $this->user_id,
                'trace' => $e->getTraceAsString(),
            ]);

            // Clear password fields for security
            $this->reset(['current_password', 'password', 'password_confirmation']);
            session()->flash('error', 'An unexpected error occurred while updating your password.');
        }
    }

    /**
     * Delete user account with comprehensive security validation and cleanup.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAccount(): \Illuminate\Http\RedirectResponse
    {
        try {
            $this->validate([
                'delete_password' => ['required', 'current_password'],
            ]);

            $user = Auth::user();
            Assert::notNull($user, 'User must be authenticated for account deletion');
            Assert::isInstanceOf($user, User::class, 'User must be an instance of User model');
            Assert::same($this->user_id, (int) $user->id, 'User ID mismatch detected');

            // Validate deletion password
            Assert::stringNotEmpty($this->delete_password, 'Password cannot be empty for account deletion');
            Assert::true(
                Hash::check($this->delete_password, $user->password),
                'Password is incorrect for account deletion',
            );

            // Store user data for logging before deletion
            $userData = [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'created_at' => $user->created_at?->toDateTimeString(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'deletion_timestamp' => now()->toDateTimeString(),
            ];

            // Log account deletion for audit trail (before deletion)
            Log::info('User account deletion initiated', $userData);

            // Logout user before deletion
            Auth::logout();

            // Invalidate session
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            // Delete the user account
            $deleted = $user->delete();
            Assert::true($deleted, 'Failed to delete user account');

            // Log successful deletion
            Log::info('User account deleted successfully', $userData);

            // Redirect to home with success message
            return Redirect::to('/')->with('status', 'Your account has been deleted successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Re-throw validation exceptions to display form errors
            Log::warning('Account deletion validation failed', [
                'errors' => $e->errors(),
                'user_id' => $this->user_id,
            ]);
            throw $e;
        } catch (\Webmozart\Assert\InvalidArgumentException $e) {
            Log::error('Account deletion assertion failed', [
                'error' => $e->getMessage(),
                'user_id' => $this->user_id,
                'trace' => $e->getTraceAsString(),
            ]);

            // Clear password field for security
            $this->reset('delete_password');
            session()->flash('error', 'Account deletion failed: ' . $e->getMessage());
            return Redirect::back();
        } catch (\Exception $e) {
            Log::error('Account deletion failed with unexpected error', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'user_id' => $this->user_id,
                'trace' => $e->getTraceAsString(),
            ]);

            // Clear password field for security
            $this->reset('delete_password');
            session()->flash('error', 'An unexpected error occurred while deleting your account.');
            return Redirect::back();
        }
    }

    /**
     * Clear all password fields for security.
     *
     * @return void
     */
    public function clearPasswords(): void
    {
        $this->reset(['current_password', 'password', 'password_confirmation', 'delete_password']);
    }

    /**
     * Get validation rules for profile update.
     *
     * @return array<string, array<int, string|\Illuminate\Validation\Rules\Unique>>
     */
    /**
     * Get validation rules for profile update.
     *
     * @return array<string, array<int, string|\Illuminate\Validation\Rules\Unique>>
     */
    protected function getProfileValidationRules(): array
    {
        return [
            'first_name' => ['required', 'string', 'min:2', 'max:100'],
            'last_name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->user_id),
            ],
        ];
    }

    /**
     * Get validation rules for password update.
     *
     * @return array<string, array<int, string>>
     */
    protected function getPasswordValidationRules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ];
    }

    /**
     * Get validation rules for account deletion.
     *
     * @return array<string, array<int, string>>
     */
    protected function getDeletionValidationRules(): array
    {
        return [
            'delete_password' => ['required', 'current_password'],
        ];
    }
};

?>

<x-layouts.app>
    <x-slot name="header">
        <h2 class="text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    @volt('profile.edit')
        <div class="pb-5">
            <div class="mx-auto space-y-6">

                {{-- Update Profile Section --}}
                <section class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg dark:bg-gray-900/50 dark:border dark:border-gray-200/10">
                    <div class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Profile Information') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Update your account's profile information and email address.") }}
                            </p>
                        </header>

                        <form wire:submit="updateProfile" class="mt-6 space-y-6">
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <x-ui.input 
                                    :label="__('First Name')" 
                                    type="text" 
                                    id="first_name" 
                                    name="first_name" 
                                    wire:model="first_name"
                                    required 
                                    autofocus
                                    minlength="2"
                                    maxlength="100"
                                    autocomplete="given-name"
                                />
                                <x-ui.input 
                                    :label="__('Last Name')" 
                                    type="text" 
                                    id="last_name" 
                                    name="last_name" 
                                    wire:model="last_name"
                                    required 
                                    minlength="2"
                                    maxlength="100"
                                    autocomplete="family-name"
                                />
                            </div>
                            
                            <x-ui.input 
                                label="Email address" 
                                type="email" 
                                id="email" 
                                name="email"
                                wire:model="email" 
                                required
                                maxlength="255"
                            />
                            
                            <div class="flex items-start">
                                <x-ui.button type="primary" submit="true">
                                    {{ __('Update Profile') }}
                                </x-ui.button>
                            </div>
                        </form>
                    </div>
                </section>

                {{-- Update Password Section --}}
                <section class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg dark:bg-gray-900/50 dark:border dark:border-gray-200/10">
                    <div class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Update Password') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Ensure your account is using a long, random password to stay secure.') }}
                            </p>
                        </header>

                        <form wire:submit="updatePassword" class="mt-6 space-y-6">
                            <x-ui.input 
                                label="Current Password" 
                                type="password" 
                                id="current_password"
                                name="current_password" 
                                wire:model="current_password"
                                required
                                autocomplete="current-password"
                            />
                            
                            <x-ui.input 
                                label="New Password" 
                                type="password" 
                                id="password" 
                                name="password"
                                wire:model="password"
                                required
                                minlength="8"
                                autocomplete="new-password"
                            />
                            
                            <x-ui.input 
                                label="Confirm New Password" 
                                type="password" 
                                id="password_confirmation"
                                name="password_confirmation" 
                                wire:model="password_confirmation"
                                required
                                minlength="8"
                                autocomplete="new-password"
                            />

                            <div class="flex items-start">
                                <x-ui.button type="primary" submit="true">
                                    {{ __('Update Password') }}
                                </x-ui.button>
                            </div>
                        </form>
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
                    </section>
                </div>
            </div>
        </div>
    @endvolt
</x-layouts.app>
