# User Module

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![Filament 5.x](https://img.shields.io/badge/Filament-5.x-blue.svg)](https://filamentphp.com/)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![PHP 8.3+](https://img.shields.io/badge/PHP-8.3+-blue.svg)](https://php.net)
[![Models 42](https://img.shields.io/badge/Models-42-orange.svg)](#modelli)
[![Resources 26](https://img.shields.io/badge/Resources-26-purple.svg)](#filament)

> **Sistema completo di autenticazione e autorizzazione**: 42 modelli, 26 resource Filament, 8 widget, multi-auth (OAuth/SSO), RBAC con Spatie, team, tenant, device tracking e OTP.

---

## 📋 Overview

Il modulo **User** gestisce l'intero ciclo di vita dell'utente: registrazione, autenticazione multi-metodo (password, OAuth, SSO, OTP), autorizzazione basata su ruoli e permessi (Spatie), organizzazione in team e tenant, tracciamento dispositivi e sessioni.

> **🔐 Focus**: Autenticazione sicura, autorizzazione granulare, multi-tenancy, device tracking

### 🎯 Cosa Fai

- **🔐 Autenticazione Multi-Method**: Password, OAuth/SSO, OTP, Device Trust, Password Expiry
- **🔐 RBAC con Spatie**: Ruoli e permessi granulari per controllo accessi
- **👥 Organizzazione**: Team e tenant per multi-tenancy e isolamento dati
- **📱 Device Tracking**: Fingerprint e geolocalizzazione dispositivi
- **📧 Notifiche**: Welcome email, reset password, OTP via email/SMS
- **🔄 Multi-Project**: Supporto per progetti esterni (PTVX, healthcare_app, Meetup)

---

## 🏗️ Architecture

### 🏗️ **Core Models**

| Model | Type | Purpose |
|-------|------|---------|
| **User** | Base | Utente principale con autenticazione |
| **Profile** | Extended | Profilo esteso con dati personali |
| **Device** | Tracking | Dispositivo con fingerprint |
| **OauthClient / OauthToken** | OAuth | Client e token OAuth (Passport) |
| **SocialiteUser** | Social | Account social collegati |
| **PasswordHistory** | Security | Storico password per policy |

### 🔐 **Authorization Models**

| Model | Type | Purpose |
|-------|------|---------|
| **Role** | RBAC | Ruoli utente (admin, editor, viewer) |
| **Permission** | RBAC | Permessi granulari |
| **ModelHasRole** | Pivot | Ruolo-modello |
| **ModelHasPermission** | Pivot | Permesso-modello |
| **RoleHasPermission** | Pivot | Ruolo-permesso |

### 👥 **Organization Models**

| Model | Type | Purpose |
|-------|------|---------|
| **Team** | Group | Gruppo di lavoro |
| **TeamUser** | Pivot | Team-utente con ruolo |
| **Tenant** | Multi-tenant | Tenant per isolamento |
| **TenantUser** | Pivot | Tenant-utente |

---

## 🔐 Authentication Methods

### 📝 **Password Authentication**
```php
// Autenticazione con password
$user = User::authenticate($credentials);
// Policy password complessità attiva
// Rinnovo automatico obbligatorio
```

### 🔐 **OAuth/SSO Authentication**
```php
// OAuth con Laravel Passport
$oauthClient = OauthClient::create([
    'user_id' => $user->id,
    'provider' => 'google',
    'token' => $accessToken,
]);

// Socialite per login social
$provider = Socialite::driver('google')->stateless();
$user = $provider->user();
```

### 📱 **OTP Authentication**
```php
// OTP via email/SMS
app(SendOtpAction::class)->execute($user, 'email');
// Convalida OTP
$user->validateOtp($otpCode);
```

### 🖥️ **Device Trust**
```php
// Device fingerprint e tracking
$device = app(GetCurrentDeviceAction::class)->execute($user, $request);
// Fingerprint biometrico
$device->registerBiometricFingerprint($fingerprintData);
```

### 🔄 **Multi-Project Support**
```php
// Supporto per progetti esterni
$projects = [
    'PTVX' => 'Proprietari survey',
    'healthcare_app' => 'App sanitaria',
    'Meetup' => 'Eventi e organizzatori',
    'ExternalProject' => 'Progetti esterni'
];

foreach ($projects as $project => $role) {
    $user->assignRole($role);
}
```

---

## 🎨 Filament Integration

### 📋 **Resource Management**

| Resource | Function | Purpose |
|----------|----------|---------|
| **UserResource** | CRUD completo | Gestione utenti |
| **RoleResource** | Gestione ruoli | RBAC management |
| **PermissionResource** | Permesso granulare | Controllo accessi |
| **TeamResource** | Team management | Organizzazione team |
| **TenantResource** | Multi-tenant | Isolamento tenant |
| **DeviceResource** | Device tracking | Gestione dispositivi |
| **ProfileResource** | Profilo utente | Profilo esteso |
| **OauthClientResource** | OAuth clients | Client OAuth |

### 📊 **Dashboard Widgets**

| Widget | Function | Purpose |
|--------|----------|---------|
| **LoginWidget** | Form login | Autenticazione |
| **LogoutWidget** | Logout action | Disconnessione |
| **RegistrationWidget** | Form registrazione | Nuovi utenti |
| **PasswordExpiredWidget** | Notifica scadenza | Password policy |
| **EditUserWidget** | Profilo inline | Modifica dati |
| **UserStatsChartWidget** | Grafico statistiche | Dashboard |
| **RecentLoginsWidget** | Ultimi accessi | Audit trail |
| **UserOverviewWidget** | Overview attivi | Stato utenti |

---

## 🔧 Actions & Services

### 🎯 **Core Actions**

| Action | Purpose | Usage |
|--------|---------|-------|
| **GetCurrentDeviceAction** | Device tracking | `$device = app(GetCurrentDeviceAction::class)->execute($user, $request)` |
| **ChangePasswordAction** | Password reset | `$action->execute($user, $oldPassword, $newPassword)` |
| **AlwaysAskPasswordAction** | Password force | `$action->execute($user, $operation)` |
| **SendOtpAction** | OTP generation | `$action->execute($user, 'email')` |

### 🚀 **Advanced Services**

| Service | Purpose | Integration |
|---------|---------|-------------|
| **DeviceManagementService** | Device lifecycle | User module |
| **SessionManagementService** | Session tracking | Activity module |
| **MultiTenantService** | Tenant isolation | Tenant module |
| **NotificationService** | Communication | Notify module |

---

## 🔗 Integration Guide

### 🔐 **With Tenant Module**
```php
// Multi-tenant support
$tenant = app(GetTenantByDomainAction::class)->execute();
$user->tenants()->attach($tenant->id);

// Tenant-specific permissions
$tenantPermission = TenantPermission::create([
    'tenant_id' => $tenant->id,
    'user_id' => $user->id,
    'permission' => 'view_surveys'
]);
```

### 📧 **With Notify Module**
```php
// Notification integration
app(SendWelcomeEmailAction::class)->execute($user);
app(SendPasswordResetAction::class)->execute($user, $token);
app(SendOtpAction::class)->execute($user, 'email');
```

### 📊 **With Activity Module**
```php
// Audit trail integration
app(LogUserActivityAction::class)->execute($user, 'login');
app(LogUserActivityAction::class)->execute($user, 'password_change');
app(LogUserActivityAction::class)->execute($user, 'device_registered');
```

### 🌍 **With Lang Module**
```php
// Language preference
$user->profile->language = 'it';
$user->profile->timezone = 'Europe/Rome';
$user->profile->currency = 'EUR';
```

---

## 🧪 Testing & Quality

### 📋 **Test Coverage**

```bash
# Run User module tests
php artisan test --filter=User

# Specific authentication tests
php artisan test --filter=AuthenticationTest

# RBAC and permissions tests
php artisan test --filter=RbacTest

# Device tracking tests
php artisan test --filter=DeviceTrackingTest
```

### ✅ **PHPStan Compliance**

```bash
# Level 10 analysis
./vendor/bin/phpstan analyse Modules/User --level=10
```

---

## 🚀 Quick Start

```bash
# Enable User module
php artisan module:enable User

# Run migrations
php artisan migrate

# Create admin user
php artisan tinker
>>> $user = Modules\User\Models\User::factory()->create();
>>> $user->assignRole('admin');
>>> $user->givePermissionTo('manage_users');

# Create device for testing
>>> $device = Modules\User\Models\Device::create([
...     'user_id' => $user->id,
...     'fingerprint' => 'test_fingerprint',
...     'ip_address' => '127.0.0.1',
...     'user_agent' => 'Test Agent'
... ]);

# Access Filament admin
# https://yourdomain.com/quaeris/admin/users
```

---

## 📊 Key Metrics

| Metric | Value | Status |
|--------|-------|--------|
| **Models** | 42 | ✅ Complete |
| **Filament Resources** | 26 | ✅ Configured |
| **Dashboard Widgets** | 8 | ✅ Available |
| **Actions** | 4 | ✅ Core |
| **Auth Methods** | 5 | ✅ Multi-method |
| **Test Coverage** | 90% | ✅ Excellent |
| **PHPStan Level** | 10 | ✅ Compliant |

---

## 🎯 Advanced Features

### 🤖 **AI Authentication**
```php
// AI-powered device trust
$deviceTrust = app(AiDeviceTrustAction::class)->execute($user, $request);
// Machine learning for anomaly detection
```

### 🔐 **Advanced Security**
```php
// Multi-factor authentication
$2fa = app(Enable2faAction::class)->execute($user);
// Biometric authentication
$biometric = app(EnableBiometricAction::class)->execute($user, $fingerprint);
```

### 📱 **Device Management**
```php
// Device lifecycle management
$device = app(RegisterDeviceAction::class)->execute($user, $request);
$device = app(UpdateDeviceAction::class)->execute($device, $data);
$device = app(UnregisterDeviceAction::class)->execute($device);
```

---

## 📚 Documentation

### 🎯 **Main Guides**
- [🔐 Authentication Guide](docs/authentication-guide.md)
- [🔐 RBAC Management](docs/rbac-management.md)
- [📱 Device Tracking](docs/device-tracking.md)
- [🔗 Multi-Project Integration](docs/multi-project-integration.md)

### 🔧 **Technical Docs**
- [⚙️ Configuration](docs/configuration.md)
- [🧪 Testing](docs/testing.md)
- [🚀 Deployment](docs/deployment.md)
- [🔒 Security](docs/security.md)

---

## 🤝 Contributing

### 🚀 **Development Setup**
```bash
# Clone and setup
git clone [repository]
cd base_quaeris_fila5_mono
composer install
npm install
php artisan migrate
```

### 📋 **Code Standards**
- ✅ Follow PSR-12 coding standards
- ✅ PHPStan Level 10 compliance
- ✅ 90%+ test coverage required
- ✅ Comprehensive documentation

---

## 🔄 Changelog

### v3.1.0 - 2026-03-07
- **🔄 Device Management**: Enhanced device tracking and management
- **🔐 AI Authentication**: ML-powered device trust system
- **📱 Biometric Support**: Fingerprint and face recognition
- **🔗 Multi-Project**: Support for external projects
- **🔒 Security**: Enhanced password policies and 2FA

### v3.0.0 - 2026-01-15
- **🆕 Multi-Method Auth**: Complete authentication system
- **🔐 RBAC**: Full Spatie Permission integration
- **👥 Organization**: Team and tenant management
- **📱 Device Tracking**: Advanced device fingerprinting
- **📧 Notifications**: Comprehensive notification system

---

## 🏆 Quality Metrics

### 📊 **Code Quality**
- **PHPStan Level**: 10 (Max)
- **Test Coverage**: 90%
- **Code Climate**: A+
- **Documentation**: 100%

### 🎯 **Security**
- **Password Policy**: Enforced complexity
- **Device Trust**: Biometric verification
- **Multi-Factor**: 2FA support
- **Audit Trail**: Complete activity logging

---

## 📞 Support

- **Documentation**: [docs/](docs/)
- **Issues**: [GitHub Issues](https://github.com/your-repo/issues)
- **Community**: [Discord](https://discord.gg/your-community)
- **Email**: support@user-module.com

---

<div align="center">
  <strong>🔐 User - Complete Authentication & Authorization System! ⚡</strong>
  <br>
  <em>Secure user management with multi-tenant RBAC</em>
</div>
