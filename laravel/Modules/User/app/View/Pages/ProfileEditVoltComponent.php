<?php

declare(strict_types=1);

namespace Modules\User\View\Pages;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Modules\User\Models\User;
use Modules\Xot\Contracts\UserContract;
use Webmozart\Assert\Assert;
use Webmozart\Assert\InvalidArgumentException;

final class ProfileEditVoltComponent extends Component
{
    /**
     * Current user's first name.
     */
    #[Validate('required|string|max:100')]
    public string $first_name = '';

    /**
     * Current user's last name.
     */
    #[Validate('required|string|max:100')]
    public string $last_name = '';

    /**
     * Current user's email address.
     */
    #[Validate('required|email|max:255')]
    public string $email = '';

    /**
     * User ID (locked to prevent tampering).
     */
    #[Locked]
    public string $user_id = '';

    /**
     * Current password for verification.
     */
    #[Validate('required|current_password')]
    public string $current_password = '';

    /**
     * New password for password updates.
     */
    #[Validate('required|min:8|confirmed')]
    public string $password = '';

    /**
     * Password confirmation.
     */
    public string $password_confirmation = '';

    /**
     * Password for account deletion confirmation.
     */
    #[Validate('required|current_password')]
    public string $delete_password = '';

    /**
     * Mount the component and initialize user data with type safety.
     */
    public function mount(): void
    {
        try {
            $user = Auth::user();
            Assert::notNull($user, 'User must be authenticated');
            if (! $user instanceof UserContract) {
                throw new InvalidArgumentException('User must implement UserContract');
            }

            // Type-safe property initialization
            $this->first_name = (string) ($user->first_name ?? '');
            $this->last_name = (string) ($user->last_name ?? '');
            $this->email = (string) ($user->email ?? '');
            $this->user_id = (string) ($user->id ?? '');

            Assert::stringNotEmpty($this->first_name, 'User first name cannot be empty');
            Assert::stringNotEmpty($this->last_name, 'User last name cannot be empty');
            Assert::stringNotEmpty($this->email, 'User email cannot be empty');
            Assert::stringNotEmpty($this->user_id, 'User ID cannot be empty');

            // Validate email format
            Assert::true(filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false, 'User email must be valid');
        } catch (InvalidArgumentException $e) {
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
     * @throws ValidationException
     */
    public function updateProfile(): void
    {
        try {
            /** @var array{first_name: string, last_name: string, email: string} $validated */
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
            if (! $user instanceof UserContract) {
                throw new InvalidArgumentException('User must implement UserContract');
            }
            Assert::same($this->user_id, (string) $user->id, 'User ID mismatch detected');

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

            // Reset email verification
            if ($emailChanged && $user->hasVerifiedEmail()) {
                $user->email_verified_at = null;
            }

            // Log before saving to capture original values
            Log::debug('Updating user profile', [
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
            /** @var array<string, mixed> $changes */
            $changes = $user->getChanges();

            Log::debug('Profile updated', [
                'user_id' => $user->id,
                'changes' => $changes,
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
            if ($emailChanged && $user->email_verified_at === null) {
                $user->sendEmailVerificationNotification();
            }
        } catch (ValidationException $e) {
            // Re-throw validation exceptions to display form errors
            Log::warning('Profile update validation failed', [
                'errors' => $e->errors(),
                'user_id' => $this->user_id,
                'email' => $this->email,
            ]);
            throw $e;
        } catch (InvalidArgumentException $e) {
            Log::error('Profile update assertion failed', [
                'error' => $e->getMessage(),
                'user_id' => $this->user_id,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'trace' => $e->getTraceAsString(),
            ]);

            session()->flash('error', 'Profile update failed: '.$e->getMessage());
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
            if (! $user instanceof UserContract) {
                throw new InvalidArgumentException('User must implement UserContract');
            }
            Assert::same($this->user_id, (string) $user->id, 'User ID mismatch detected');

            // Validate password strength and format
            Assert::stringNotEmpty($this->current_password, 'Current password cannot be empty');
            Assert::stringNotEmpty($this->password, 'New password cannot be empty');
            Assert::stringNotEmpty($this->password_confirmation, 'Password confirmation cannot be empty');
            Assert::same($this->password, $this->password_confirmation, 'Password confirmation does not match');
            Assert::greaterThanEq(strlen($this->password), 8, 'Password must be at least 8 characters long');

            // Not every user has a password hash (e.g. social login accounts): treat a
            // missing hash as "current password incorrect" instead of casting mixed/null.
            $currentPasswordHash = $user->password;
            if ($currentPasswordHash === null) {
                throw new InvalidArgumentException('Current password is incorrect');
            }

            // Verify current password
            Assert::true(Hash::check($this->current_password, $currentPasswordHash), 'Current password is incorrect');

            // Ensure new password is different from current
            Assert::false(
                Hash::check($this->password, $currentPasswordHash),
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
            Log::debug('User password updated successfully', [
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
        } catch (ValidationException $e) {
            // Re-throw validation exceptions to display form errors
            Log::warning('Password update validation failed', [
                'errors' => $e->errors(),
                'user_id' => $this->user_id,
            ]);
            throw $e;
        } catch (InvalidArgumentException $e) {
            Log::error('Password update assertion failed', [
                'error' => $e->getMessage(),
                'user_id' => $this->user_id,
                'trace' => $e->getTraceAsString(),
            ]);

            // Clear password fields for security
            $this->reset(['current_password', 'password', 'password_confirmation']);
            session()->flash('error', 'Password update failed: '.$e->getMessage());
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
     */
    public function deleteAccount(): RedirectResponse
    {
        try {
            $this->validate([
                'delete_password' => ['required', 'current_password'],
            ]);

            $user = Auth::user();
            Assert::notNull($user, 'User must be authenticated for account deletion');
            if (! $user instanceof UserContract) {
                throw new InvalidArgumentException('User must implement UserContract');
            }
            Assert::same($this->user_id, (string) $user->id, 'User ID mismatch detected');

            // Validate deletion password
            Assert::stringNotEmpty($this->delete_password, 'Password cannot be empty for account deletion');

            // Not every user has a password hash (e.g. social login accounts): treat a
            // missing hash as "password incorrect" instead of casting mixed/null.
            $currentPasswordHash = $user->password;
            if ($currentPasswordHash === null) {
                throw new InvalidArgumentException('Password is incorrect for account deletion');
            }
            Assert::true(
                Hash::check($this->delete_password, $currentPasswordHash),
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
            Log::debug('User account deletion initiated', $userData);

            // Logout user before deletion
            Auth::logout();

            // Invalidate session
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            // Delete the user account
            $deleted = $user->delete();
            Assert::true($deleted, 'Failed to delete user account');

            // Log successful deletion
            Log::debug('User account deleted successfully', $userData);

            // Redirect to home with success message
            return Redirect::to('/')->with('status', 'Your account has been deleted successfully.');
        } catch (ValidationException $e) {
            // Re-throw validation exceptions to display form errors
            Log::warning('Account deletion validation failed', [
                'errors' => $e->errors(),
                'user_id' => $this->user_id,
            ]);
            throw $e;
        } catch (InvalidArgumentException $e) {
            Log::error('Account deletion assertion failed', [
                'error' => $e->getMessage(),
                'user_id' => $this->user_id,
                'trace' => $e->getTraceAsString(),
            ]);

            // Clear password field for security
            $this->reset('delete_password');
            session()->flash('error', 'Account deletion failed: '.$e->getMessage());

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
     */
    public function clearPasswords(): void
    {
        $this->reset(['current_password', 'password', 'password_confirmation', 'delete_password']);
    }
}
