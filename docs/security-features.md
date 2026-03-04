# Laravel Pizza Security Features & Best Practices

## Security Overview

The Laravel Pizza project implements comprehensive security measures across all layers of the application, following industry best practices and Laravel security guidelines. This document outlines the security features, configurations, and best practices implemented throughout the modular architecture.

## Authentication & Authorization

### Laravel Fortify Integration
The project uses Laravel Fortify for robust authentication handling:

```php
// config/fortify.php
<?php

use Laravel\Fortify\Features;

return [
    'guard' => 'web',

    'passwords' => 'users',

    'username' => 'email',

    'email' => 'email',

    'home' => '/dashboard',

    'features' => [
        Features::registration(),
        Features::resetPasswords(),
        Features::emailVerification(),
        Features::updateProfileInformation(),
        Features::updatePasswords(),
        Features::twoFactorAuthentication([
            'confirm' => true,
            'confirmPassword' => true,
        ]),
    ],
];
```

### Two-Factor Authentication
- Implemented using Google Authenticator standards
- Backup codes for recovery
- Rate limiting for TFA attempts
- Secure session management

### Role-Based Access Control (RBAC)
```php
// Example policy implementation
namespace Modules\User\Policies;

use Modules\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('moderator');
    }

    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->hasRole('admin');
    }

    public function delete(User $user, User $model): bool
    {
        return $user->hasRole('admin') && $user->id !== $model->id;
    }
}
```

## Input Validation & Sanitization

### Form Request Validation
```php
// Example: StoreUserRequest
namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/'],
            'phone' => ['nullable', 'string', 'regex:/^[\+]?[1-9][\d]{0,15}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.regex' => 'Password must contain at least one uppercase, one lowercase, and one number.',
        ];
    }
}
```

### Data Sanitization
```php
// Using Laravel's built-in sanitization
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

// Input sanitization in Actions
class CreateUserAction
{
    public function execute(array $data): User
    {
        $data['name'] = strip_tags($data['name']);
        $data['email'] = strtolower(trim($data['email']));
        $data['password'] = Hash::make($data['password']);

        return User::create($data);
    }
}
```

## Module-Specific Security

### User Module Security
- Password strength validation (minimum 8 characters, mixed case, numbers)
- Account lockout after failed attempts
- Email verification requirements
- Session management with secure cookies

### Cms Module Security
- Content security policies for user-generated content
- XSS protection for page content
- File upload validation and sanitization
- Access control for content management

### Media Module Security
- File type validation (whitelist approach)
- File size limits
- Virus scanning integration
- Secure file storage with access controls

### Geo Module Security
- API key management for geocoding services
- Rate limiting for external API calls
- Input validation for location data
- Privacy controls for location sharing

## Security Headers & Configuration

### HTTP Security Headers
```php
// app/Http/Middleware/SecurityHeaders.php
<?php

namespace App\Http\Middleware;

use Closure;

class SecurityHeaders
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Content Security Policy
        $response->headers->set('Content-Security-Policy',
            "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; " .
            "style-src 'self' 'unsafe-inline'; img-src 'self' data: https:; " .
            "font-src 'self' data:; connect-src 'self' https://api.example.com;"
        );

        // X-Frame-Options
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // X-Content-Type-Options
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // X-XSS-Protection
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer-Policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        return $response;
    }
}
```

### CORS Configuration
```php
// config/cors.php
<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        env('FRONTEND_URL', 'http://localhost:3000'),
        'https://yourdomain.com',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];
```

## Database Security

### Query Protection
- Parameterized queries to prevent SQL injection
- Eloquent ORM usage for safe database operations
- Input validation before database operations
- Proper indexing to prevent query vulnerabilities

### Data Encryption
```php
// Example: Encrypting sensitive data
namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Model
{
    protected $fillable = [
        'name', 'email', 'password', 'encrypted_ssn'
    ];

    protected $hidden = [
        'password', 'remember_token', 'encrypted_ssn'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'encrypted_ssn' => 'encrypted', // Laravel's built-in encryption
    ];
}
```

## File Upload Security

### Secure File Handling
```php
// Example: Secure file upload in Media module
namespace Modules\Media\Actions;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SecureFileUploadAction
{
    private array $allowedMimes = [
        'image/jpeg', 'image/png', 'image/gif', 'image/webp',
        'application/pdf', 'text/plain'
    ];

    private array $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'txt'];

    private int $maxFileSize = 10485760; // 10MB

    public function execute(UploadedFile $file, string $directory = 'uploads'): string
    {
        // Validate file type
        if (!$this->validateFileType($file)) {
            throw new \InvalidArgumentException('Invalid file type');
        }

        // Validate file size
        if ($file->getSize() > $this->maxFileSize) {
            throw new \InvalidArgumentException('File too large');
        }

        // Generate secure filename
        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();

        // Store file
        $path = $file->storeAs($directory, $filename, 'public');

        return $path;
    }

    private function validateFileType(UploadedFile $file): bool
    {
        return in_array($file->getMimeType(), $this->allowedMimes) &&
               in_array(strtolower($file->getClientOriginalExtension()), $this->allowedExtensions);
    }
}
```

## API Security

### Sanctum API Tokens
```php
// config/sanctum.php
<?php

return [
    'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
        '%s%s',
        'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1',
        env('APP_URL') ? ','.parse_url(env('APP_URL'), PHP_URL_HOST) : ''
    ))),

    'guard' => ['web'],

    'expiration' => null, // Set to null for no expiration or specify minutes

    'token_prefix' => env('SANCTUM_TOKEN_PREFIX', ''),

    'middleware' => [
        'verify_csrf_token' => App\Http\Middleware\VerifyCsrfToken::class,
        'encrypt_cookies' => App\Http\Middleware\EncryptCookies::class,
    ],
];
```

### Rate Limiting
```php
// Rate limiting in routes or middleware
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

// Custom rate limiter
RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by(
        $request->user()?->id ?: $request->ip()
    );
});
```

## Session Security

### Secure Session Configuration
```php
// config/session.php
<?php

return [
    'driver' => env('SESSION_DRIVER', 'redis'),

    'lifetime' => env('SESSION_LIFETIME', 120),

    'expire_on_close' => false,

    'encrypt' => true,

    'files' => storage_path('framework/sessions'),

    'connection' => env('SESSION_CONNECTION'),

    'table' => 'sessions',

    'store' => env('SESSION_STORE'),

    'lottery' => [2, 100],

    'cookie' => env('SESSION_COOKIE', 'laravel_session'),

    'path' => '/',

    'domain' => env('SESSION_DOMAIN'),

    'secure' => env('SESSION_SECURE_COOKIE'),

    'http_only' => true,

    'same_site' => 'lax', // or 'strict' for higher security
];
```

## CSRF Protection

### CSRF Middleware Configuration
```php
// app/Http/Middleware/VerifyCsrfToken.php
<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     */
    protected $except = [
        // External webhook URLs
        'api/webhook/*',
        'payment/callback/*',
        // APIs that use token authentication
        'api/*',
    ];
}
```

## GDPR & Privacy Compliance

### Data Protection Features
- User data privacy controls
- Right to data portability
- Right to be forgotten implementation
- Consent management system
- Audit logging for data access

### GDPR Implementation
```php
// Example GDPR compliance action
namespace Modules\User\Actions;

use Modules\User\Models\User;
use Illuminate\Support\Facades\Storage;

class ExportUserDataAction
{
    public function execute(User $user): string
    {
        $data = [
            'user' => $user->toArray(),
            'profile' => $user->profile?->toArray(),
            'preferences' => $user->preferences?->toArray(),
            'activity_log' => $user->activityLog->toArray(),
        ];

        $filename = 'user-data-export-' . $user->id . '-' . now()->format('Y-m-d') . '.json';
        $path = 'gdpr-exports/' . $filename;

        Storage::put($path, json_encode($data, JSON_PRETTY_PRINT));

        return Storage::url($path);
    }
}
```

## Security Monitoring & Logging

### Security Event Logging
```php
// Example security logging
namespace Modules\User\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class LogFailedLoginAttempt
{
    public function handle(Failed $event)
    {
        Log::warning('Failed login attempt', [
            'email' => $event->credentials['email'] ?? null,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toISOString(),
        ]);
    }
}
```

### Security Alerts
- Failed authentication attempts
- Suspicious file uploads
- SQL injection attempts
- XSS attack attempts
- Rate limit violations

## Environment Security

### Environment Variable Protection
- Never commit sensitive data to version control
- Use .env.example for documentation
- Implement environment variable validation
- Rotate keys regularly

### Environment-Specific Security
```php
// config/localhost/app.php - Development security config
<?php

switch (config('app.env')) {
    case 'local':
        $debug = true;
        $secureHeaders = false;
        break;

    case 'production':
        $debug = false;
        $secureHeaders = true;
        break;

    default:
        $debug = false;
        $secureHeaders = true;
}

return [
    'debug' => $debug,
    'secure_headers' => $secureHeaders,
];
```

## Security Testing

### Security Testing Checklist
- [ ] Input validation testing
- [ ] Authentication bypass attempts
- [ ] Authorization failures
- [ ] SQL injection attempts
- [ ] XSS testing
- [ ] CSRF testing
- [ ] File upload vulnerabilities
- [ ] Session hijacking attempts
- [ ] Rate limiting bypasses

### Security Testing Tools
- **Laravel Security Checker**: Check for vulnerable dependencies
- **PHP Security Audit**: Static analysis for security issues
- **OWASP ZAP**: Web application security scanner
- **SQLMap**: SQL injection testing

## Incident Response

### Security Incident Procedures
1. **Detection**: Monitor logs and alerts for security events
2. **Containment**: Isolate affected systems immediately
3. **Investigation**: Analyze the incident scope and cause
4. **Eradication**: Remove the security threat
5. **Recovery**: Restore normal operations securely
6. **Lessons Learned**: Document and improve security measures

### Emergency Contacts
- System administrators
- Security team
- Legal team (for data breaches)
- External security consultants

This comprehensive security framework ensures that the Laravel Pizza application maintains high security standards across all modules and components while remaining maintainable and scalable.
