---
module: User
concept: Two-Factor Authentication
last_updated: 2026-04-15
---

# Two-Factor Authentication (2FA)

The User module implements a robust 2FA system based on TOTP (Time-based One-Time Password), compatible with apps like Google Authenticator and Authy.

## 1. Core Architecture

The system uses the following packages:
- `pragmarx/google2fa-laravel`: Core logic for secret generation and verification.
- `bacon/bacon-qr-code`: Generating QR codes for easy setup.

## 2. Implementation Flow

1. **Enable**: User requests to enable 2FA. The system generates a secret key and 10 recovery codes.
2. **Scan**: User scans the provided QR code with their authenticator app.
3. **Verify**: User enters the 6-digit TOTP code to confirm the connection.
4. **Recovery**: If the device is lost, the user can use one of the one-time-use recovery codes.

## 3. Mandatory Model Fields

The `users` table includes these encrypted fields:
- `two_factor_secret`: The encrypted secret key.
- `two_factor_recovery_codes`: Encrypted JSON array of recovery codes.
- `two_factor_confirmed_at`: Timestamp of successful verification.
- `two_factor_enabled`: Boolean flag.

## 4. Usage in Actions

Use the `TwoFactorService` to manage the lifecycle:

```php
$service = app(TwoFactorService::class);
$service->enable($user); // Generates secret and codes
$service->confirm($user, $code); // Finalizes setup
```

## 5. Policies & Enforcement

2FA can be enforced at the **Tenant** or **Team** level. If required, the `TwoFactorMiddleware` will redirect unverified users to the setup/verification page before allowing access to the application.

---
**Related Pages:**
- [[User Module Architecture]]
- [[Roles and Permissions]]
- [[Security Best Practices]]
