# User Module - SSO Providers Implementation

## Overview

Il modulo User include il supporto completo per Single Sign-On (SSO) tramite provider esterni. Questa documentazione descrive l'implementazione della tabella `sso_providers` e le relative funzionalità.

## Database Schema

### Tabella: `sso_providers`

**Migration**: `2025_10_15_153835_create_sso_providers_table.php`

```sql
CREATE TABLE sso_providers (
    id INTEGER PRIMARY KEY,
    name VARCHAR UNIQUE NOT NULL,
    display_name VARCHAR NOT NULL,
    type VARCHAR DEFAULT 'oauth',  -- oauth, saml, oidc
    entity_id VARCHAR UNIQUE,
    client_id VARCHAR,
    client_secret VARCHAR,
    redirect_url VARCHAR,
    metadata_url TEXT,
    scopes TEXT,
    settings JSON,
    domain_whitelist JSON,
    role_mapping JSON,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    updated_by VARCHAR,
    created_by VARCHAR
);
```

### Campi della Tabella

| Campo | Tipo | Descrizione |
|-------|------|-------------|
| `id` | INTEGER | Chiave primaria auto-incrementale |
| `name` | VARCHAR | Nome univoco del provider (slug) |
| `display_name` | VARCHAR | Nome visualizzato (es. "SPID", "CIE") |
| `type` | VARCHAR | Tipo di protocollo: `oauth`, `saml`, `oidc` |
| `entity_id` | VARCHAR | Entity ID per SAML (univoco) |
| `client_id` | VARCHAR | Client ID per OAuth/OIDC |
| `client_secret` | VARCHAR | Client Secret per OAuth/OIDC |
| `redirect_url` | VARCHAR | URL di callback dopo autenticazione |
| `metadata_url` | TEXT | URL dei metadati SAML |
| `scopes` | TEXT | Scope richiesti (OAuth/OIDC) |
| `settings` | JSON | Configurazioni aggiuntive specifiche del provider |
| `domain_whitelist` | JSON | Domini email autorizzati |
| `role_mapping` | JSON | Mappatura ruoli SSO → ruoli applicazione |
| `is_active` | BOOLEAN | Provider abilitato/disabilitato |

## Relazione con Users Table

### Foreign Key

La tabella `users` contiene i seguenti campi per l'integrazione SSO:

```sql
ALTER TABLE users ADD COLUMN sso_provider_id INTEGER;
ALTER TABLE users ADD COLUMN sso_identifier VARCHAR UNIQUE;
ALTER TABLE users ADD COLUMN sso_last_login TIMESTAMP;
ALTER TABLE users ADD CONSTRAINT fk_sso_provider
    FOREIGN KEY (sso_provider_id) REFERENCES sso_providers(id) ON DELETE SET NULL;
```

### Campi SSO in Users

| Campo | Descrizione |
|-------|-------------|
| `sso_provider_id` | FK verso `sso_providers.id` (nullable) |
| `sso_identifier` | ID utente nel sistema SSO (univoco) |
| `sso_last_login` | Timestamp ultimo accesso via SSO |

## Provider Supportati

### 1. OAuth 2.0 / OpenID Connect

**Esempi**: Google, Microsoft, GitHub

```json
{
  "type": "oauth",
  "client_id": "your-client-id",
  "client_secret": "your-client-secret",
  "scopes": "openid email profile",
  "redirect_url": "https://app.fixcity.it/auth/callback/google"
}
```

### 2. SAML 2.0

**Esempi**: SPID, CIE

```json
{
  "type": "saml",
  "entity_id": "https://app.fixcity.it",
  "metadata_url": "https://idp.provider.it/metadata.xml",
  "redirect_url": "https://app.fixcity.it/auth/callback/spid"
}
```

### 3. OpenID Connect

**Esempi**: Keycloak, Auth0

```json
{
  "type": "oidc",
  "client_id": "fixcity-app",
  "discovery_url": "https://auth.provider.it/.well-known/openid-configuration",
  "scopes": "openid email profile roles"
}
```

## Configurazione Provider

### Esempio: Configurazione SPID

```php
use Modules\User\Models\SsoProvider;

$spidProvider = SsoProvider::create([
    'name' => 'spid',
    'display_name' => 'SPID',
    'type' => 'saml',
    'entity_id' => 'https://app.fixcity.it',
    'metadata_url' => 'https://registry.spid.gov.it/metadata/idp/spid-idp-metadata.xml',
    'redirect_url' => route('auth.spid.callback'),
    'is_active' => true,
    'settings' => [
        'level' => 'SpidL2',
        'required_attributes' => ['fiscalNumber', 'name', 'familyName', 'email'],
    ],
    'domain_whitelist' => ['@pa.it', '@comune.*.it'],
    'role_mapping' => [
        'citizen' => 'user',
        'admin' => 'administrator'
    ]
]);
```

### Esempio: Configurazione Google OAuth

```php
$googleProvider = SsoProvider::create([
    'name' => 'google',
    'display_name' => 'Google',
    'type' => 'oauth',
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect_url' => route('auth.google.callback'),
    'scopes' => 'openid email profile',
    'is_active' => true,
    'domain_whitelist' => ['@gmail.com'],
]);
```

## Utilizzo nel Codice

### Recuperare Provider Attivi

```php
use Modules\User\Models\SsoProvider;

$activeProviders = SsoProvider::where('is_active', true)->get();
```

### Autenticare Utente via SSO

```php
use Modules\User\Models\User;
use Modules\User\Models\SsoProvider;

$provider = SsoProvider::where('name', 'spid')->firstOrFail();

$user = User::updateOrCreate([
    'sso_identifier' => $ssoUserId,
    'sso_provider_id' => $provider->id,
], [
    'email' => $ssoEmail,
    'name' => $ssoName,
    'email_verified_at' => now(),
    'sso_last_login' => now(),
]);
```

### Verificare Domain Whitelist

```php
public function isDomainAllowed(SsoProvider $provider, string $email): bool
{
    if (empty($provider->domain_whitelist)) {
        return true; // Nessun filtro
    }

    $domain = substr(strrchr($email, "@"), 1);

    foreach ($provider->domain_whitelist as $allowedDomain) {
        if (fnmatch($allowedDomain, "@" . $domain)) {
            return true;
        }
    }

    return false;
}
```

### Applicare Role Mapping

```php
public function mapSsoRole(SsoProvider $provider, string $ssoRole): string
{
    return $provider->role_mapping[$ssoRole] ?? 'user';
}
```

## Security Best Practices

### 1. **Protezione Client Secret**
- ❌ Non committare mai client_secret in git
- ✅ Usare variabili d'ambiente: `env('PROVIDER_CLIENT_SECRET')`
- ✅ Crittografare in database se necessario

### 2. **Validazione Domain Whitelist**
- Sempre validare email prima del login
- Usare pattern matching per sotto-domini
- Log tentativi da domini non autorizzati

### 3. **Audit Trail**
- Tracciare tutti i login SSO
- Registrare `sso_last_login`
- Monitorare provider disabilitati

### 4. **SAML Security**
- Validare firme XML
- Verificare certificate expiration
- Implementare assertion replay protection

## Testing

### Test Database

```bash
php artisan migrate --database=user
```

### Test Provider Creation

```php
use Modules\User\Models\SsoProvider;

test('can create SSO provider', function () {
    $provider = SsoProvider::factory()->create([
        'name' => 'test-provider',
        'type' => 'oauth',
    ]);

    expect($provider->name)->toBe('test-provider');
    expect($provider->is_active)->toBeTrue();
});
```

### Test User SSO Login

```php
test('can login user via SSO', function () {
    $provider = SsoProvider::factory()->create(['name' => 'spid']);

    $user = User::create([
        'email' => 'test@example.it',
        'sso_provider_id' => $provider->id,
        'sso_identifier' => 'SPID-123456',
    ]);

    expect($user->sso_provider_id)->toBe($provider->id);
    expect($user->sso_identifier)->toBe('SPID-123456');
});
```

## Migration History

| Data | Versione | Descrizione |
|------|----------|-------------|
| 2025-10-15 | 1.0.0 | Creazione iniziale tabella `sso_providers` |
| 2025-10-15 | 1.0.0 | Aggiunta foreign key in tabella `users` |

## Roadmap

- [ ] Factory per SsoProvider
- [ ] Seeder con provider comuni (Google, Microsoft)
- [ ] Filament Resource per gestione provider
- [ ] API endpoints per configurazione
- [ ] Dashboard SSO analytics
- [ ] Multi-factor authentication support

---

**Autore**: Claude Code
**Data**: 2025-10-15
**Versione**: 1.0.0
**Laravel**: 12.34.0
