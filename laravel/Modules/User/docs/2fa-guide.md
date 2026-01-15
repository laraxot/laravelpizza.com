# 🔐 TWO-FACTOR AUTHENTICATION (2FA) - GUIDA IMPLEMENTAZIONE

**Versione**: 1.0  
**Status**: 🚧 60% Implementato  
**Data**: 2025-10-01  

---

## 🎯 OVERVIEW

Implementazione completa del sistema di autenticazione a due fattori (2FA) per FixCity utilizzando TOTP (Time-based One-Time Password) con supporto per recovery codes.

---

## 🏗️ ARCHITETTURA

### Componenti Principali

```
User 2FA System
├── TOTP Generator (Google Authenticator compatible)
├── QR Code Generator
├── Recovery Codes (10 codes monouso)
├── Backup Methods (Email, SMS)
└── Policy Management (per tenant/team)
```

### Flow Autenticazione

```
1. Login → Email + Password
2. 2FA Check → Se abilitato
3. TOTP Input → 6 digit code
4. Validation → Verifica code
5. Access Granted → Session attiva
```

---

## 📦 DIPENDENZE

### Composer Packages

```bash
composer require pragmarx/google2fa-laravel
composer require bacon/bacon-qr-code
composer require spatie/laravel-backup
```

### Configuration

```php
// config/google2fa.php
return [
    'enabled' => env('2FA_ENABLED', true),
    'window' => 4, // Time window for code validation
    'qrcode_inline' => true,
];
```

---

## 💾 DATABASE SCHEMA

### Migration: Add 2FA Fields to Users

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {
        $this->tableUpdate(
            'users',
            function (Blueprint $table): void {
                if (! $this->hasColumn('two_factor_secret')) {
                    $table->text('two_factor_secret')->nullable();
                }
                if (! $this->hasColumn('two_factor_recovery_codes')) {
                    $table->text('two_factor_recovery_codes')->nullable();
                }
                if (! $this->hasColumn('two_factor_confirmed_at')) {
                    $table->timestamp('two_factor_confirmed_at')->nullable();
                }
                if (! $this->hasColumn('two_factor_enabled')) {
                    $table->boolean('two_factor_enabled')->default(false);
                }
            }
        );
    }
};
```

---

## 🔧 IMPLEMENTAZIONE

### 1. User Model

```php
<?php

declare(strict_types=1);

namespace Modules\User\Models;

use PragmaRX\Google2FA\Google2FA;

class User extends BaseUser
{
    protected $fillable = [
        // ... existing fields
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
        'two_factor_enabled',
    ];

    protected $casts = [
        'two_factor_confirmed_at' => 'datetime',
        'two_factor_enabled' => 'boolean',
    ];

    protected $hidden = [
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * Check if 2FA is enabled for user
     */
    public function hasTwoFactorEnabled(): bool
    {
        return $this->two_factor_enabled 
            && ! is_null($this->two_factor_secret)
            && ! is_null($this->two_factor_confirmed_at);
    }

    /**
     * Get recovery codes as array
     */
    public function getRecoveryCodes(): array
    {
        return json_decode(decrypt($this->two_factor_recovery_codes), true) ?? [];
    }

    /**
     * Set recovery codes
     */
    public function setRecoveryCodes(array $codes): void
    {
        $this->two_factor_recovery_codes = encrypt(json_encode($codes));
        $this->save();
    }

    /**
     * Use a recovery code
     */
    public function useRecoveryCode(string $code): bool
    {
        $codes = $this->getRecoveryCodes();
        
        if (($key = array_search($code, $codes)) !== false) {
            unset($codes[$key]);
            $this->setRecoveryCodes(array_values($codes));
            return true;
        }
        
        return false;
    }
}
```

### 2. TwoFactorService

```php
<?php

declare(strict_types=1);

namespace Modules\User\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Modules\User\Models\User;

class TwoFactorService
{
    protected Google2FA $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    /**
     * Enable 2FA for user
     */
    public function enable(User $user): array
    {
        $secret = $this->google2fa->generateSecretKey();
        
        $user->update([
            'two_factor_secret' => encrypt($secret),
            'two_factor_enabled' => false, // Will be enabled after confirmation
        ]);

        $recoveryCodes = $this->generateRecoveryCodes();
        $user->setRecoveryCodes($recoveryCodes);

        return [
            'secret' => $secret,
            'qr_code' => $this->generateQrCode($user, $secret),
            'recovery_codes' => $recoveryCodes,
        ];
    }

    /**
     * Confirm 2FA setup
     */
    public function confirm(User $user, string $code): bool
    {
        if ($this->verify($user, $code)) {
            $user->update([
                'two_factor_enabled' => true,
                'two_factor_confirmed_at' => now(),
            ]);
            return true;
        }
        
        return false;
    }

    /**
     * Disable 2FA for user
     */
    public function disable(User $user): void
    {
        $user->update([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
            'two_factor_enabled' => false,
        ]);
    }

    /**
     * Verify TOTP code
     */
    public function verify(User $user, string $code): bool
    {
        $secret = decrypt($user->two_factor_secret);
        
        return $this->google2fa->verifyKey($secret, $code);
    }

    /**
     * Verify recovery code
     */
    public function verifyRecoveryCode(User $user, string $code): bool
    {
        return $user->useRecoveryCode($code);
    }

    /**
     * Generate QR code
     */
    protected function generateQrCode(User $user, string $secret): string
    {
        $qrCodeUrl = $this->google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        
        return $writer->writeString($qrCodeUrl);
    }

    /**
     * Generate recovery codes
     */
    protected function generateRecoveryCodes(): array
    {
        return Collection::times(10, function () {
            return Str::random(10) . '-' . Str::random(10);
        })->all();
    }

    /**
     * Regenerate recovery codes
     */
    public function regenerateRecoveryCodes(User $user): array
    {
        $codes = $this->generateRecoveryCodes();
        $user->setRecoveryCodes($codes);
        
        return $codes;
    }
}
```

### 3. Filament Resource Page

```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Modules\User\Services\TwoFactorService;

class TwoFactorAuthentication extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static string $view = 'user::filament.pages.two-factor-authentication';
    protected static ?string $navigationGroup = 'Security';

    public ?array $data = [];
    public ?string $qrCode = null;
    public ?array $recoveryCodes = null;
    public bool $enabled = false;

    public function mount(): void
    {
        $user = auth()->user();
        $this->enabled = $user->hasTwoFactorEnabled();
        
        $this->form->fill([
            'enabled' => $this->enabled,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Toggle::make('enabled')
                    ->label('Enable Two-Factor Authentication')
                    ->disabled(),
            ])
            ->statePath('data');
    }

    public function enable(): void
    {
        $service = app(TwoFactorService::class);
        $user = auth()->user();

        $result = $service->enable($user);

        $this->qrCode = $result['qr_code'];
        $this->recoveryCodes = $result['recovery_codes'];

        Notification::make()
            ->title('2FA Setup Started')
            ->body('Scan the QR code with your authenticator app.')
            ->success()
            ->send();
    }

    public function confirm(string $code): void
    {
        $service = app(TwoFactorService::class);
        $user = auth()->user();

        if ($service->confirm($user, $code)) {
            $this->enabled = true;
            $this->qrCode = null;

            Notification::make()
                ->title('2FA Enabled')
                ->body('Two-factor authentication has been enabled successfully.')
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Invalid Code')
                ->body('The code you entered is invalid. Please try again.')
                ->danger()
                ->send();
        }
    }

    public function disable(): void
    {
        $service = app(TwoFactorService::class);
        $user = auth()->user();

        $service->disable($user);
        $this->enabled = false;

        Notification::make()
            ->title('2FA Disabled')
            ->body('Two-factor authentication has been disabled.')
            ->warning()
            ->send();
    }

    public function regenerateRecoveryCodes(): void
    {
        $service = app(TwoFactorService::class);
        $user = auth()->user();

        $this->recoveryCodes = $service->regenerateRecoveryCodes($user);

        Notification::make()
            ->title('Recovery Codes Regenerated')
            ->body('New recovery codes have been generated.')
            ->success()
            ->send();
    }
}
```

### 4. Blade View

```blade
<x-filament-panels::page>
    <div class="space-y-6">
        @if($enabled)
            <x-filament::section>
                <x-slot name="heading">
                    Two-Factor Authentication Enabled
                </x-slot>

                <div class="space-y-4">
                    <p class="text-sm text-gray-600">
                        Your account is protected with two-factor authentication.
                    </p>

                    <div class="flex gap-4">
                        <x-filament::button
                            color="danger"
                            wire:click="disable"
                        >
                            Disable 2FA
                        </x-filament::button>

                        <x-filament::button
                            color="gray"
                            wire:click="regenerateRecoveryCodes"
                        >
                            Regenerate Recovery Codes
                        </x-filament::button>
                    </div>
                </div>
            </x-filament::section>
        @else
            <x-filament::section>
                <x-slot name="heading">
                    Enable Two-Factor Authentication
                </x-slot>

                <div class="space-y-4">
                    <p class="text-sm text-gray-600">
                        Add an extra layer of security to your account.
                    </p>

                    @if(!$qrCode)
                        <x-filament::button
                            wire:click="enable"
                        >
                            Enable 2FA
                        </x-filament::button>
                    @else
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-lg font-medium">Scan QR Code</h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    Scan this QR code with your authenticator app (Google Authenticator, Authy, etc.)
                                </p>
                                <div class="mt-4">
                                    {!! $qrCode !!}
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium">Recovery Codes</h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    Save these recovery codes in a safe place. You can use them to access your account if you lose your device.
                                </p>
                                <div class="mt-4 p-4 bg-gray-100 rounded-lg font-mono text-sm">
                                    @foreach($recoveryCodes as $code)
                                        <div>{{ $code }}</div>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium">Confirm Setup</h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    Enter the 6-digit code from your authenticator app to confirm setup.
                                </p>
                                <div class="mt-4">
                                    <x-filament::input.wrapper>
                                        <x-filament::input
                                            type="text"
                                            wire:model="confirmCode"
                                            placeholder="000000"
                                            maxlength="6"
                                        />
                                    </x-filament::input.wrapper>
                                    
                                    <x-filament::button
                                        class="mt-2"
                                        wire:click="confirm($wire.confirmCode)"
                                    >
                                        Confirm and Enable
                                    </x-filament::button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </x-filament::section>
        @endif

        @if($enabled && $recoveryCodes)
            <x-filament::section>
                <x-slot name="heading">
                    New Recovery Codes
                </x-slot>

                <div class="space-y-4">
                    <p class="text-sm text-gray-600">
                        Your new recovery codes. Save them in a safe place.
                    </p>
                    <div class="p-4 bg-gray-100 rounded-lg font-mono text-sm">
                        @foreach($recoveryCodes as $code)
                            <div>{{ $code }}</div>
                        @endforeach
                    </div>
                </div>
            </x-filament::section>
        @endif
    </div>
</x-filament-panels::page>
```

---

## 🔐 MIDDLEWARE

### TwoFactorMiddleware

```php
<?php

declare(strict_types=1);

namespace Modules\User\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->hasTwoFactorEnabled() && ! session('2fa_verified')) {
            return redirect()->route('2fa.verify');
        }

        return $next($request);
    }
}
```

### Register Middleware

```php
// app/Http/Kernel.php
protected $middlewareGroups = [
    'web' => [
        // ... other middleware
        \Modules\User\Http\Middleware\TwoFactorMiddleware::class,
    ],
];
```

---

## 🎨 POLICY MANAGEMENT

### Per Tenant/Team

```php
<?php

declare(strict_types=1);

namespace Modules\User\Policies;

use Modules\User\Models\User;
use Modules\Tenant\Models\Tenant;

class TwoFactorPolicy
{
    /**
     * Check if 2FA is required for tenant
     */
    public function required(User $user, Tenant $tenant): bool
    {
        return $tenant->settings['2fa_required'] ?? false;
    }

    /**
     * Check if user can disable 2FA
     */
    public function disable(User $user): bool
    {
        $tenant = $user->tenant;
        
        // Cannot disable if required by tenant
        if ($tenant && $this->required($user, $tenant)) {
            return false;
        }
        
        return true;
    }
}
```

---

## ✅ TESTING

### Feature Test

```php
<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature;

use Tests\TestCase;
use Modules\User\Models\User;
use Modules\User\Services\TwoFactorService;

class TwoFactorTest extends TestCase
{
    public function test_user_can_enable_2fa(): void
    {
        $user = User::factory()->create();
        $service = app(TwoFactorService::class);

        $result = $service->enable($user);

        $this->assertArrayHasKey('secret', $result);
        $this->assertArrayHasKey('qr_code', $result);
        $this->assertArrayHasKey('recovery_codes', $result);
        $this->assertCount(10, $result['recovery_codes']);
    }

    public function test_user_can_confirm_2fa_with_valid_code(): void
    {
        $user = User::factory()->create();
        $service = app(TwoFactorService::class);

        $result = $service->enable($user);
        $google2fa = new \PragmaRX\Google2FA\Google2FA();
        $validCode = $google2fa->getCurrentOtp($result['secret']);

        $confirmed = $service->confirm($user, $validCode);

        $this->assertTrue($confirmed);
        $this->assertTrue($user->fresh()->hasTwoFactorEnabled());
    }

    public function test_user_can_use_recovery_code(): void
    {
        $user = User::factory()->create();
        $service = app(TwoFactorService::class);

        $result = $service->enable($user);
        $recoveryCode = $result['recovery_codes'][0];

        $verified = $service->verifyRecoveryCode($user, $recoveryCode);

        $this->assertTrue($verified);
        $this->assertCount(9, $user->fresh()->getRecoveryCodes());
    }
}
```

---

## 📱 MOBILE APP SUPPORT

### Deep Link for QR Code

```php
// Generate deep link for mobile apps
public function getMobileDeepLink(User $user, string $secret): string
{
    return sprintf(
        'otpauth://totp/%s:%s?secret=%s&issuer=%s',
        urlencode(config('app.name')),
        urlencode($user->email),
        $secret,
        urlencode(config('app.name'))
    );
}
```

---

## 🔔 NOTIFICATIONS

### 2FA Enabled Notification

```php
<?php

declare(strict_types=1);

namespace Modules\User\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TwoFactorEnabledNotification extends Notification
{
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Two-Factor Authentication Enabled')
            ->line('Two-factor authentication has been enabled on your account.')
            ->line('If you did not enable this, please contact support immediately.')
            ->action('View Account Security', url('/admin/profile/security'));
    }
}
```

---

## 📊 BEST PRACTICES

### Security
✅ **Encrypt secrets**: Always encrypt 2FA secrets in database  
✅ **Rate limiting**: Limit verification attempts  
✅ **Recovery codes**: Provide backup access method  
✅ **Audit logging**: Log all 2FA events  

### UX
✅ **Clear instructions**: Guide users through setup  
✅ **QR code + manual**: Provide both options  
✅ **Recovery codes**: Emphasize importance  
✅ **Testing**: Allow code testing before enabling  

---

**Last Updated**: 2025-10-01  
**Status**: 60% Implemented  
**Next Steps**: Complete UI, add SMS backup, implement policy enforcement  
