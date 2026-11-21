---
title: "OAuth Architecture - User Module"
type: concept
tags: [oauth, architecture]
created: 2026-07-14
updated: 2026-07-14
qmd: "oauth-architecture oauth architecture - user module"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./github.md"
---

# OAuth Architecture - User Module

> **Last Updated**: 2026-03-18  
> **Status**: ✅ Consolidated - Single Client Model

---

## 📋 Overview

Il modulo User implementa OAuth 2.0 tramite **Laravel Passport** con un'architettura personalizzata che estende i modelli base di Passport per aggiungere:

- **Authorization** (Spatie Permission)
- **Role-based access control** per client
- **Factory pattern** per testing
- **Connection multi-tenant** (database `user`)

---

## 🏗️ Architecture

### Model Structure

```
Modules/User/app/Models/
├── OauthClient.php              ✅ PRIMARY - Client wrapper con Authorizable
├── OauthToken.php               ✅ Token model
├── OauthAuthCode.php            ✅ Auth code model
├── OauthRefreshToken.php        ✅ Refresh token model
├── OauthDeviceCode.php          ✅ Device code model
└── OauthPersonalAccessClient.php ✅ Personal access client
```

### ❌ REMOVED: Passport/Client.php

**Fino al 2026-03-18** esisteva `Modules/User/Models/Passport/Client.php` come wrapper aggiuntivo.

**Problemi**:
- ❌ Violazione DRY (due modelli per lo stesso concetto)
- ❌ Violazione KISS (complessità non necessaria)
- ❌ Confusione: quale modello usare?
- ❌ Solo 2 riferimenti nei test vs 80+ per `OauthClient`

**Soluzione applicata**:
- ✅ Eliminato `Passport/Client.php`
- ✅ Aggiornati i 2 test per usare `OauthClient`
- ✅ Tutta la codebase usa **solo** `OauthClient`

---

## 🎯 OauthClient Model

### Implementation

```php
<?php

namespace Modules\User\Models;

use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Laravel\Passport\Client as PassportClient;
use Modules\User\Database\Factories\OauthClientFactory;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Spatie\Permission\Traits\HasRoles;

final class OauthClient extends PassportClient implements AuthorizableContract
{
    use Authorizable;
    use HasFactory;
    use HasRoles;

    protected $connection = 'user';
    public $guard_name = 'api';

    public function user(): BelongsTo
    {
        $userClass = XotData::make()->getUserClass();
        return $this->belongsTo($userClass, 'user_id');
    }

    // ... Authorizable methods (can, cant, cannot, canAny)
}
```

### Features

| Feature | Description |
|---------|-------------|
| **Authorizable** | Integration con Laravel authorization |
| **HasRoles** | Spatie Permission per ruoli client |
| **Factory** | `OauthClientFactory` per testing |
| **Connection** | Database `user` dedicato |
| **Guard** | `api` guard per Spatie Permission |
| **User Relation** | Relazione al user owner |

### Usage

```php
use Modules\User\Models\OauthClient;

// Create client
$client = OauthClient::create([
    'name' => 'API Client',
    'redirect' => 'https://example.com/callback',
    'personal_access_client' => false,
    'password_client' => false,
    'revoked' => false,
]);

// Check permissions
if ($client->can('access-api')) {
    // Authorized
}

// Assign roles
$client->assignRole('api-client');

// Get owner
$user = $client->user;
```

---

## 🔧 Configuration

### Passport Setup

Il modello è configurato in `config/user.php`:

```php
'passport' => [
    'client_model' => Modules\User\Models\OauthClient::class,
],
```

### ServiceProvider

In `PassportServiceProvider`:

```php
use Laravel\Passport\Passport;
use Modules\User\Models\OauthClient;

Passport::useClientModel(OauthClient::class);
Passport::useTokenModel(OauthToken::class);
Passport::useAuthCodeModel(OauthAuthCode::class);
// ... etc
```

---

## 🧪 Testing

### Factory Usage

```php
use Modules\User\Database\Factories\OauthClientFactory;

$client = OauthClientFactory::new()->create([
    'name' => 'Test Client',
]);
```

### Test Example

```php
test('client can have permissions', function () {
    $client = OauthClient::factory()->create();
    
    $client->givePermissionTo('access-api');
    
    expect($client->can('access-api'))->toBeTrue();
});
```

---

## 📊 Models Overview

| Model | Purpose | Connection |
|-------|---------|------------|
| `OauthClient` | OAuth 2.0 client | `user` |
| `OauthToken` | Access token | `user` |
| `OauthAuthCode` | Authorization code | `user` |
| `OauthRefreshToken` | Refresh token | `user` |
| `OauthDeviceCode` | Device code | `user` |
| `OauthPersonalAccessClient` | Personal access config | `user` |

---

## 🔗 Related Documentation

- [Laravel Passport Docs](https://laravel.com/docs/passport)
- [Spatie Permission](https://spatie.be/docs/laravel-permission)
- [User Module Architecture](../architecture.md)
- [OAuth Actions](../actions/oauth-actions.md)

---

## 📝 Changelog

### 2026-03-18 - DRY Cleanup

- ❌ **REMOVED**: `Models/Passport/Client.php` (duplicate model)
- ✅ **UPDATED**: Test files per usare `OauthClient`
- ✅ **CLEANED**: Eliminata cartella `Models/Passport/`

**Motivazione**: Violazione DRY + KISS - due modelli per lo stesso concetto creavano confusione e duplicazione.

**Impact**:
- 80+ file usano `OauthClient`
- 2 file test aggiornati
- Zero breaking changes ( Passport/Client era usato solo internamente ai test)
