# GDPR Module Documentation

## Overview
The GDPR module provides comprehensive General Data Protection Regulation compliance tools for the Laraxot system. It helps organizations meet GDPR requirements through automated data management, consent tracking, and privacy protection features.

## Key Features
- **Data Consent Management**: User consent tracking and management
- **Right to Access**: Automated data access request handling
- **Right to Erasure**: Secure data deletion and anonymization
- **Data Portability**: Export user data in standard formats
- **Privacy Dashboard**: User privacy control panel
- **Audit Logging**: Comprehensive data processing activity logs

## Architecture
The module follows the Laraxot architecture principles:
- Extends Xot base classes
- Uses Filament for admin interface
- Implements proper service providers
- Follows DRY/KISS principles

## Core Components

### Models
- `Consent` - User consent records and preferences
- `DataRequest` - Data access and deletion requests
- `PrivacyPolicy` - Privacy policy versions and tracking
- `DataProcessingLog` - Data processing activity logs

### Resources
- `ConsentResource` - Consent management interface
- `DataRequestResource` - Data request management
- `PrivacyPolicyResource` - Privacy policy management
- `GdprDashboard` - GDPR compliance dashboard

### Services
- `GdprService` - Core GDPR compliance operations
- `ConsentManager` - Consent tracking and management
- `DataExporter` - Data export functionality
- `DataEraser` - Secure data deletion and anonymization
- `PrivacyManager` - Privacy policy and compliance management

## Implementation Guide

### Consent Management
```php
// Track user consent
$consentManager = app(ConsentManager::class);

// Record consent for data processing
$consentManager->recordConsent($user, 'data_processing', true);

// Check if user has given consent
if ($consentManager->hasConsent($user, 'marketing_emails')) {
    // Send marketing email
}

// Withdraw consent
$consentManager->withdrawConsent($user, 'data_processing');
```

### Data Access Requests
```php
// Handle data access request
$gdprService = app(GdprService::class);

// Create data access request
$dataRequest = $gdprService->createDataAccessRequest($user, 'data_export');

// Process the request
$exportData = $gdprService->processDataAccessRequest($dataRequest);

// Export data in JSON format
return response()->json($exportData);
```

### Data Erasure
```php
// Handle right to erasure request
$gdprService = app(GdprService::class);

// Anonymize user data
$gdprService->anonymizeUserData($user);

// Delete user account
$gdprService->deleteUserAccount($user);
```

## Consent Types
1. **Data Processing**: Consent for general data processing
2. **Marketing Communications**: Consent for marketing emails and communications
3. **Analytics**: Consent for analytics and tracking
4. **Third-party Sharing**: Consent for sharing data with third parties
5. **Cookie Usage**: Consent for cookie usage

## Privacy Features

### Data Minimization
- **Selective Data Collection**: Only collect necessary data
- **Data Retention Policies**: Automatic deletion of old data
- **Purpose Limitation**: Clear data usage purposes

### User Controls
- **Privacy Dashboard**: Centralized privacy controls
- **Consent Preferences**: Manage consent preferences
- **Data Export**: Export personal data
- **Account Deletion**: Request account deletion

### Compliance Tools
- **Privacy Policy Management**: Versioned privacy policies
- **Data Processing Records**: Track all data processing activities
- **Breach Notification**: Automated breach notification system
- **Compliance Reporting**: GDPR compliance status reports

## Data Protection Measures
1. **Encryption**: Data encryption at rest and in transit
2. **Access Controls**: Role-based access to personal data
3. **Audit Trails**: Comprehensive logging of data access
4. **Anonymization**: Secure data anonymization techniques
5. **Pseudonymization**: Replace identifying information with pseudonyms

## Best Practices
1. **Regular Audits**: Conduct regular GDPR compliance audits
2. **Staff Training**: Train staff on GDPR requirements
3. **Privacy by Design**: Implement privacy features from the start
4. **Data Protection Impact Assessments**: Assess high-risk processing activities
5. **Breach Response Plan**: Have a plan for data breaches

## Related Modules
- [User Module](../User/docs/README.md) - User authentication and management
- [Activity Module](../Activity/docs/index.md) - Activity logging
- [Notify Module](../Notify/docs/index.md) - Notification system
- [Xot Module](../Xot/docs/index.md) - Core base classes

## Database Testing Configuration

**CRITICAL: .env.testing Configuration Rules**

The `.env.testing` file must be a **COPY CARBON** of `.env` with **ONLY "_test"** added to database names.

❌ **NEVER invent new environment variables like**:
```bash
NOTIFY_DB_DATABASE=laravelpizza_data_test  # WRONG!
GDPR_DB_DATABASE=laravelpizza_data_test    # WRONG!
```

✅ **CORRECT approach**:
```bash
# If .env has:
DB_DATABASE=laravelpizza_data

# Then .env.testing has:
DB_DATABASE=laravelpizza_data_test  # Only add "_test"!
```

See [Database Testing Configuration](./database-testing-configuration.md) for complete details.

## Testing Guidelines

### CRITICAL: NEVER Force Database Connections in Tests

**❌ WRONG PATTERN** (NEVER DO THIS):
```php
// This is COMPLETELY WRONG - it destroys the dynamic configuration system
config(['database.connections.notify' => config('database.connections.mysql')]);
config(['database.connections.geo' => config('database.connections.mysql')]);
config(['database.connections.media' => config('database.connections.mysql')]);
// ... etc for all modules
```

**Why it's wrong:**
1. Destroys the dynamic configuration managed by `TenantServiceProvider`
2. Ignores environment-specific configurations (.env.testing)
3. Violates Laraxot architecture principles
4. Breaks module isolation and multi-database support

**✅ CORRECT PATTERN:**
```php
// Just use Pest's HTTP helpers - let TenantServiceProvider manage connections
it('renders the registration page', function () {
    get('/en/auth/register')
        ->assertStatus(200)
        ->assertSee('Create Your FREE Account');
});

it('allows user registration', function () {
    post('/en/auth/register', [
        'first_name' => 'John',
        'email' => 'john@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'privacy_accepted' => '1',
        'terms_accepted' => '1',
    ])
        ->assertStatus(302);
});
```

**Key Points:**
- Use Pest's `get()` and `post()` helpers directly
- Never call `config()` to modify database connections in tests
- Database connections are managed automatically by TenantServiceProvider
- Test database names are configured in `.env.testing` (suffixed with `_test`)
- All modules use `php artisan migrate` for test setup - no per-module migrations

**Environment Configuration (.env.testing):**
- `.env.testing` is a COPY of `.env` with ONLY `_test` suffix added to database names
- DO NOT invent new database variables (NOTIFY_DB, GEO_DB, etc.) - they don't exist in .env
- Only databases defined in .env get `_test` suffix (e.g., `DB_DATABASE` → `DB_DATABASE_test`)
- Module connections (notify, geo, media, etc.) are created automatically by TenantServiceProvider

### CRITICAL: TestCase setUp() MUST NOT Duplicate Database Configuration

**❌ WRONG PATTERN** (NEVER DO THIS in TestCase setUp()):
```php
protected function setUp(): void
{
    parent::setUp();

    // ❌ COMPLETAMENTE SBAGLIATO!
    // CreatesApplication::createApplication() lo fa già!
    config(['database.connections.notify' => config('database.connections.mysql')]);
    config(['database.connections.geo' => config('database.connections.mysql')]);
    config(['database.connections.media' => config('database.connections.mysql')]);
    // ... ecc per tutti i moduli

    // ❌ Anche questo è ridondante!
    \Illuminate\Support\Facades\DB::purge('notify');
    \Illuminate\Support\Facades\DB::purge('mysql');

    if (! self::$migrated) {
        $this->artisan('migrate:fresh', ['--force' => true]);
        $this->artisan('module:migrate', ['--force' => true]);
        self::$migrated = true;
    }
}
```

**✅ CORRECT PATTERN** (TestCase setUp() clean and simple):
```php
protected function setUp(): void
{
    parent::setUp();

    config(['xra.pub_theme' => 'Meetup']);
    config(['xra.main_module' => 'User']);

    \Modules\Xot\Datas\XotData::make()->update([
        'pub_theme' => 'Meetup',
        'main_module' => 'User',
    ]);

    if (! self::$migrated) {
        $this->artisan('migrate:fresh', ['--force' => true]);
        $this->artisan('module:migrate', ['--force' => true]);
        self::$migrated = true;
    }
}
```

**Why this is critical:**
1. `CreatesApplication` trait already configures ALL module connections automatically
2. Duplicating causes conflicts and initialization problems
3. Can cause errors like "Call to a member function connection() on null"
4. Violates DRY principle

**What CreatesApplication does automatically:**
```php
// In Modules/Xot/tests/CreatesApplication.php
$moduleConnections = [
    'user', 'notify', 'geo', 'media', 'job', 'xot',
    'activity', 'cms', 'gdpr', 'lang', 'meetup', 'seo', 'tenant',
];

foreach ($moduleConnections as $connection) {
    $app['config']->set("database.connections.{$connection}", $defaultConfig);
}
```

All module connections are automatically mapped to the test MySQL connection defined in `.env.testing`.

## Recent Fixes
- [RegisterWidget Fix (2026-02-13)](./register-widget-fix-2026-02-13.md) - Fixed registration form rendering and two-column layout
- [Register Page UI/UX Improvements (2026-02-13)](../Themes/Meetup/docs/register-page-improvements.md) - Complete overhaul with enhanced UI/UX, WCAG 2.2 AAA, SEO, and clickbait marketing

## Translation & Localization
- [Multi-Language Translation Guidelines](./multi-language-translation-guidelines.md) - Comprehensive guide for implementing and maintaining multi-language translations

## Marketing & Conversion
- [Clickbait Marketing Best Practices](../Themes/Meetup/docs/clickbait-marketing-best-practices.md) - Ethical clickbait techniques for conversion optimization

## Troubleshooting
Common issues and solutions:
- Consent tracking inconsistencies
- Data export format issues
- Account deletion complications
- Privacy policy version management
- Hardcoded strings in multilingual sites
- Translation key inconsistencies
