# Genesis Starter Kit - Analysis & Patterns

**Date**: 29 Novembre 2024
**Source**: [github.com/thedevdojo/genesis](https://github.com/thedevdojo/genesis)
**Tech Stack**: TALL (TailwindCSS + Alpine.js + Laravel + Livewire) + Folio + Volt

---

## 📦 Cos'è Genesis?

**Genesis** è uno starter kit Laravel ufficiale by DevDojo che fornisce un boilerplate completo per applicazioni TALL stack con Folio + Volt.

### Installation

```bash
laravel new my-app --using=devdojo/genesis
composer run dev  # or npm run dev
```

---

## 🗂️ File Structure

```
genesis/
├── app/                                # Application logic
├── resources/
│   ├── views/
│   │   ├── pages/                      # 🎯 FOLIO ROUTES (file-based)
│   │   │   ├── index.blade.php         # / (homepage)
│   │   │   ├── about.blade.php         # /about
│   │   │   ├── learn.blade.php         # /learn
│   │   │   ├── auth/
│   │   │   │   ├── login.blade.php     # /auth/login
│   │   │   │   ├── register.blade.php  # /auth/register
│   │   │   │   ├── password/
│   │   │   │   │   ├── reset.blade.php
│   │   │   │   │   └── email.blade.php
│   │   │   │   └── verify-email.blade.php
│   │   │   ├── dashboard.blade.php     # /dashboard (protected)
│   │   │   └── profile.blade.php       # /profile (edit)
│   │   │
│   │   └── components/
│   │       ├── layouts/                # Layout templates
│   │       │   ├── main.blade.php      # Base HTML structure
│   │       │   ├── app.blade.php       # Authenticated pages
│   │       │   └── marketing.blade.php # Public pages
│   │       │
│   │       └── ui/                     # Reusable UI components
│   │           ├── button.blade.php
│   │           ├── input.blade.php
│   │           ├── checkbox.blade.php
│   │           ├── modal.blade.php
│   │           ├── app/                # App-specific components
│   │           │   ├── header.blade.php
│   │           │   └── breadcrumbs.blade.php
│   │           └── marketing/          # Marketing components
│   │               └── header.blade.php
│   │
│   └── css/
│       └── app.css                     # TailwindCSS
│
├── tests/Feature/                      # Tests matching pages
├── config/, database/, routes/, storage/
└── composer.json
```

---

## 🎯 11 Routes Created (Folio Auto-routing)

| File | Route | Middleware | Purpose |
|------|-------|-----------|---------|
| `pages/index.blade.php` | `/` | `redirect-to-dashboard` | Homepage (redirects if auth) |
| `pages/about.blade.php` | `/about` | - | About page |
| `pages/learn.blade.php` | `/learn` | - | Learn page (shows README) |
| `pages/auth/login.blade.php` | `/auth/login` | `guest` | Login form |
| `pages/auth/register.blade.php` | `/auth/register` | `guest` | Registration form |
| `pages/auth/password/email.blade.php` | `/auth/password/email` | `guest` | Password reset request |
| `pages/auth/password/reset.blade.php` | `/auth/password/reset` | `guest` | Password reset form |
| `pages/auth/verify-email.blade.php` | `/auth/verify-email` | `auth` | Email verification |
| `pages/dashboard.blade.php` | `/dashboard` | `auth, verified` | User dashboard |
| `pages/profile.blade.php` | `/profile` | `auth, verified` | Profile editor |

**Total**: 11 routes, 0 lines of `Route::get()` needed! ✨

---

## 🏗️ Layout Architecture

### 3-Tier Layout System

#### 1. `main.blade.php` (Base)

Core HTML structure:

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>
    {{ $slot }}
    @livewireScripts
</body>
</html>
```

#### 2. `app.blade.php` (Authenticated)

For logged-in users:

```blade
<x-layouts.main>
    <div class="min-h-screen bg-gray-100">
        <x-ui.app.header />

        <main>
            {{ $slot }}
        </main>
    </div>
</x-layouts.main>
```

#### 3. `marketing.blade.php` (Public)

For public pages:

```blade
<x-layouts.main>
    <div class="min-h-screen bg-white">
        <x-ui.marketing.header />

        <main>
            {{ $slot }}
        </main>

        <x-ui.marketing.footer />
    </div>
</x-layouts.main>
```

### Usage in Pages

```blade
<!-- Public page -->
<x-layouts.marketing>
    <h1>About Us</h1>
</x-layouts.marketing>

<!-- Authenticated page -->
<x-layouts.app>
    <h1>Dashboard</h1>
</x-layouts.app>
```

---

## 🔐 Authentication Pattern

### Login Page Example

**File**: `pages/auth/login.blade.php`

```blade
<?php
use function Livewire\Volt\{state, rules};

state(['email' => '', 'password' => '', 'remember' => false]);

rules([
    'email' => 'required|email',
    'password' => 'required',
]);

$login = function () {
    $this->validate();

    if (!Auth::attempt($this->only(['email', 'password']), $this->remember)) {
        $this->addError('email', 'The provided credentials do not match our records.');
        return;
    }

    session()->regenerate();
    $this->redirect('/dashboard', navigate: true);
};
?>

<x-layouts.marketing>
    @volt('auth.login')
        <div class="max-w-md mx-auto">
            <h1 class="text-2xl font-bold mb-6">Log in</h1>

            <form wire:submit="login">
                <!-- Email -->
                <div class="mb-4">
                    <x-ui.input
                        wire:model="email"
                        type="email"
                        label="Email"
                        required
                    />
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-ui.input
                        wire:model="password"
                        type="password"
                        label="Password"
                        required
                    />
                </div>

                <!-- Remember Me -->
                <div class="mb-6">
                    <x-ui.checkbox wire:model="remember" label="Remember me" />
                </div>

                <!-- Submit -->
                <x-ui.button type="submit" class="w-full">
                    Log in
                </x-ui.button>
            </form>

            <!-- Links -->
            <div class="mt-4 text-center">
                <a href="/auth/password/email" class="text-sm text-blue-600">Forgot password?</a>
                <span class="mx-2">·</span>
                <a href="/auth/register" class="text-sm text-blue-600">Sign up</a>
            </div>
        </div>
    @endvolt
</x-layouts.marketing>
```

### Middleware in Volt

```blade
<?php
use function Livewire\Volt\{middleware};

// Protect page - only authenticated + verified users
middleware(['auth', 'verified']);
?>

@volt('dashboard')
    <!-- Dashboard content -->
@endvolt
```

---

## 🧩 Reusable UI Components

### Button Component

**File**: `components/ui/button.blade.php`

```blade
@props([
    'type' => 'button',
    'variant' => 'primary', // primary, secondary, danger
])

@php
$classes = match($variant) {
    'primary' => 'bg-blue-600 hover:bg-blue-700 text-white',
    'secondary' => 'bg-gray-600 hover:bg-gray-700 text-white',
    'danger' => 'bg-red-600 hover:bg-red-700 text-white',
    default => 'bg-blue-600 hover:bg-blue-700 text-white',
};
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => "px-4 py-2 rounded-lg font-semibold transition-colors $classes"]) }}
>
    {{ $slot }}
</button>
```

**Usage**:
```blade
<x-ui.button>Save</x-ui.button>
<x-ui.button variant="danger">Delete</x-ui.button>
<x-ui.button type="submit" wire:click="save">Submit</x-ui.button>
```

### Input Component

**File**: `components/ui/input.blade.php`

```blade
@props([
    'label' => null,
    'error' => null,
])

<div>
    @if($label)
        <label class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
        </label>
    @endif

    <input
        {{ $attributes->merge(['class' => 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent']) }}
    >

    @if($error)
        <p class="mt-1 text-sm text-red-600">{{ $error }}</p>
    @endif
</div>
```

---

## 📋 Profile Page Pattern

**File**: `pages/profile.blade.php`

Three sections: Update Profile, Change Password, Delete Account

```blade
<?php
use function Livewire\Volt\{middleware, state, rules};

middleware(['auth', 'verified']);

// Section 1: Update Profile
state(['name' => auth()->user()->name, 'email' => auth()->user()->email]);

$updateProfile = function () {
    $this->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
    ]);

    auth()->user()->update($this->only(['name', 'email']));

    session()->flash('profile-updated', 'Profile updated successfully.');
};

// Section 2: Update Password
state(['current_password' => '', 'new_password' => '', 'confirm_password' => '']);

$updatePassword = function () {
    $this->validate([
        'current_password' => 'required|current_password',
        'new_password' => 'required|min:8|confirmed',
    ]);

    auth()->user()->update(['password' => Hash::make($this->new_password)]);

    $this->reset(['current_password', 'new_password', 'confirm_password']);
};

// Section 3: Delete Account
$deleteAccount = function () {
    Auth::logout();
    auth()->user()->delete();
    $this->redirect('/', navigate: true);
};
?>

<x-layouts.app>
    @volt('profile-editor')
        <div class="max-w-4xl mx-auto py-12 px-4">
            <!-- Section 1: Update Profile -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-bold mb-4">Profile Information</h2>

                <form wire:submit="updateProfile">
                    <x-ui.input wire:model="name" label="Name" class="mb-4" />
                    <x-ui.input wire:model="email" type="email" label="Email" class="mb-4" />
                    <x-ui.button type="submit">Update Profile</x-ui.button>
                </form>

                @if(session('profile-updated'))
                    <p class="mt-4 text-green-600">{{ session('profile-updated') }}</p>
                @endif
            </div>

            <!-- Section 2: Update Password -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-bold mb-4">Change Password</h2>

                <form wire:submit="updatePassword">
                    <x-ui.input wire:model="current_password" type="password" label="Current Password" class="mb-4" />
                    <x-ui.input wire:model="new_password" type="password" label="New Password" class="mb-4" />
                    <x-ui.input wire:model="confirm_password" type="password" label="Confirm Password" class="mb-4" />
                    <x-ui.button type="submit">Update Password</x-ui.button>
                </form>
            </div>

            <!-- Section 3: Delete Account -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4 text-red-600">Delete Account</h2>
                <p class="mb-4">Once you delete your account, there is no going back.</p>

                <x-ui.button variant="danger" wire:click="deleteAccount" wire:confirm="Are you sure?">
                    Delete Account
                </x-ui.button>
            </div>
        </div>
    @endvolt
</x-layouts.app>
```

---

## 🧪 Testing Pattern

Tests match page structure:

**File**: `tests/Feature/ProfileTest.php`

```php
use function Pest\Laravel\{actingAs, get};

it('can view profile page', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get('/profile')
        ->assertOk()
        ->assertSee('Profile Information');
});

it('can update profile', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->livewire('profile-editor')
        ->set('name', 'New Name')
        ->call('updateProfile')
        ->assertHasNoErrors();

    expect($user->fresh()->name)->toBe('New Name');
});
```

---

## 🎯 Key Patterns for Laravel Pizza

### 1. Dual-Layout System (Similar to Genesis)

Genesis uses:
- `marketing.blade.php` for public pages
- `app.blade.php` for authenticated pages

**Laravel Pizza should use**:
- `delivery.blade.php` for delivery theme (light, public)
- `community.blade.php` for community theme (dark, members)

**Implementation**:

```blade
<!-- resources/views/components/layouts/delivery.blade.php -->
<x-layouts.main>
    <div class="min-h-screen bg-white text-gray-900">
        <x-ui.delivery.header />
        <main>{{ $slot }}</main>
        <x-ui.delivery.footer />
    </div>
</x-layouts.main>

<!-- resources/views/components/layouts/community.blade.php -->
<x-layouts.main>
    <div class="min-h-screen bg-slate-900 text-white">
        <x-ui.community.header />
        <main>{{ $slot }}</main>
        <x-ui.community.footer />
    </div>
</x-layouts.main>
```

**Usage**:
```blade
<!-- Public delivery page -->
<x-layouts.delivery>
    <h1>Menu Pizze</h1>
</x-layouts.delivery>

<!-- Community member page -->
<x-layouts.community>
    <h1>Dashboard</h1>
</x-layouts.community>
```

---

### 2. UI Component Library

Genesis has `components/ui/`. Laravel Pizza should have:

```
components/
├── ui/
│   ├── button.blade.php
│   ├── input.blade.php
│   ├── card.blade.php
│   ├── modal.blade.php
│   ├── delivery/               # Delivery-specific components
│   │   ├── header.blade.php
│   │   ├── footer.blade.php
│   │   └── pizza-card.blade.php
│   └── community/              # Community-specific components
│       ├── header.blade.php
│       ├── footer.blade.php
│       └── event-card.blade.php
```

---

### 3. Auth Flow (Copy from Genesis)

Genesis auth pattern is **perfect** for Laravel Pizza:

```
pages/auth/
├── login.blade.php         # /auth/login
├── register.blade.php      # /auth/register
├── password/
│   ├── email.blade.php     # /auth/password/email
│   └── reset.blade.php     # /auth/password/reset
└── verify-email.blade.php  # /auth/verify-email
```

**All use Volt functional API, no controllers!**

---

### 4. Profile Editor Pattern

Genesis multi-section profile page is great reference for:
- `/dashboard/profile` in Laravel Pizza
- Multiple forms on same page
- Section-based organization
- Inline validation

---

## ✅ Checklist: Apply Genesis Patterns to Laravel Pizza

- [ ] Create 3 layouts: `main.blade.php`, `delivery.blade.php`, `community.blade.php`
- [ ] Create UI component library in `components/ui/`
- [ ] Implement auth pages using Genesis pattern (`auth/*.blade.php`)
- [ ] Create profile editor with sections (profile, password, deletion)
- [ ] Add dashboard with stats (similar to Genesis dashboard)
- [ ] Use Volt functional API everywhere (like Genesis)
- [ ] Setup testing pattern matching pages
- [ ] Apply `redirect-to-dashboard` middleware pattern

---

## 🔗 Resources

- **GitHub**: [github.com/thedevdojo/genesis](https://github.com/thedevdojo/genesis)
- **Installation**: `laravel new app --using=devdojo/genesis`
- **Stack**: TALL + Folio + Volt
- **Tests**: Pest PHP

---

**Conclusion**: Genesis is a **perfect reference** for Laravel Pizza architecture. It demonstrates production-ready patterns for Folio + Volt + multi-layout system.

🍕 Use Genesis patterns as blueprint for Laravel Pizza delivery + community dual-purpose platform!
