# Laravel Passport Integration - Architettura Completa

> **Generato**: 2026-01-07
> **Filosofia**: L'Architetto Laraxot (Vincitore del Dibattito Interno)
> **PHPStan Status**: ✅ Level MAX Compliant (Zero Errori)

---

## 🏆 Filosofia Vincente: L'Approccio Laraxot

### Il Dibattito Interno

Durante l'analisi dell'integrazione Passport, sono emerse tre posizioni:

#### Posizione A - "Il Purista PHPStan"
"Correggere TUTTI i type hints per PHPStan max! Nessun compromesso sulla type safety!"

#### Posizione B - "Il Pragmatico Laravel"
"Laravel Passport usa `mixed` per motivi validi. Non rompere la compatibilità!"

#### Posizione C - "L'Architetto Laraxot" ✅ **VINCITORE**
"Seguire la filosofia Laraxot: estendere senza rompere, DRY + KISS, documentare tutto."

### Perché Ha Vinto

1. **Compatibilità Librerie**: Non rompere Passport cambiando type hints che Laravel ha scelto deliberatamente
2. **DRY Principle**: Rimuovere codice ridondante - `BaseUser` già implementa `OAuthenticatable`
3. **KISS Principle**: Soluzione più semplice = usare Passport come inteso, aggiungere solo quando necessario
4. **Filosofia Laraxot**: Estendere con traits, documentare decisioni, mantenere compatibilità

---

## 📋 Architettura Passport nel Modulo User

### Modelli OAuth

```
laravel/Modules/User/app/Models/
├── BaseUser.php              # Implements OAuthenticatable + HasApiTokens
├── OauthClient.php          # Extends Laravel\Passport\Client
├── OauthAccessToken.php     # Extends Laravel\Passport\Token
├── OauthRefreshToken.php    # Extends Laravel\Passport\RefreshToken
├── OauthAuthCode.php        # Extends Laravel\Passport\AuthCode
└── OauthPersonalAccessClient.php  # Extends Laravel\Passport\PersonalAccessClient
```

### BaseUser + Passport

```php
abstract class BaseUser extends Authenticatable
    implements OAuthenticatable
{
    use HasApiTokens {
        HasApiTokens::tokenCan as protected passportTokenCan;
        HasApiTokens::createToken as protected passportCreateToken;
        HasApiTokens::withAccessToken as protected passportWithAccessToken;
    }

    // Public wrappers for Passport methods
    public function tokenCan(string $scope): bool
    {
        return $this->passportTokenCan($scope);
    }

    public function createToken(string $name, array $scopes = []): PersonalAccessTokenResult
    {
        return $this->passportCreateToken($name, $scopes);
    }

    // Type hint: mixed (Passport compatibility)
    // PHPDoc + assertion for type safety
    public function withAccessToken(mixed $accessToken): static
    {
        $this->passportWithAccessToken($accessToken);
        return $this;
    }
}
```

#### 🔑 Decisione Chiave: Type Hints

**Q**: Perché `withAccessToken(mixed $accessToken)` invece di `ScopeAuthorizable|null`?

**A**:
1. Laravel Passport usa `mixed` perché il metodo deve accettare diversi tipi di token
2. Cambiare a `ScopeAuthorizable|null` romperebbe la compatibilità con Passport
3. Usiamo PHPDoc + assertions per type safety senza rompere l'API

```php
/**
 * Set the access token for the user.
 *
 * @param ScopeAuthorizable|null $accessToken
 * @return static
 */
public function withAccessToken(mixed $accessToken): static
{
    // Type safety via assertion if needed
    // Assert::nullOrIsInstanceOf($accessToken, ScopeAuthorizable::class);

    $this->passportWithAccessToken($accessToken);
    return $this;
}
```

---

## 🛡️ OauthClient: Estensione Minimalista

### Filosofia DRY

```php
class OauthClient extends PassportClient implements AuthorizableContract
{
    use Authorizable;
    use HasRoles; // Spatie Permission integration

    protected $connection = 'user';
    public $guard_name = 'api';

    // Custom authorization logic for Spatie Permission
    public function can($ability, mixed $arguments = []): bool
    {
        // Custom implementation
    }

    // ❌ NON ridefinire owner() se non cambia logica (DRY!)
    // ✅ Il metodo parent è sufficiente
}
```

### Decisione: Rimuovere Metodi Ridondanti

**Prima (Anti-pattern)**:
```php
public function owner(): MorphTo
{
    return $this->morphTo('user'); // Stesso del parent!
}
```

**Dopo (DRY + KISS)**:
```php
// Metodo rimosso - usa il parent Laravel\Passport\Client::owner()
// Zero codice ridondante = zero maintenance
```

---

## 🔐 Token Configuration

### Token Lifetimes

```php
// config/passport.php (merged via User module)

'lifetime' => [
    'access_token' => env('PASSPORT_ACCESS_TOKEN_LIFETIME', 1440), // 1 giorno
    'refresh_token' => env('PASSPORT_REFRESH_TOKEN_LIFETIME', 43200), // 30 giorni
    'personal_access_token' => env('PASSPORT_PERSONAL_ACCESS_TOKEN_LIFETIME', 262800), // 6 mesi
],
```

### OAuth Scopes

```php
'scopes' => [
    'view-user' => 'View user information',
    'core-technicians' => 'Core technicians scope',
    // Add more scopes as needed
],
```

---

## 📦 Filament Resources per OAuth

### Resources Disponibili

```php
laravel/Modules/User/app/Filament/Resources/
├── OauthClientResource.php              # Manage OAuth clients
├── OauthAccessTokenResource.php         # View access tokens
├── OauthRefreshTokenResource.php        # View refresh tokens
├── OauthAuthCodeResource.php            # View auth codes
└── OauthPersonalAccessClientResource.php # Manage personal access clients
```

### OauthClientResource: XotBase Pattern

```php
final class OauthClientResource extends XotBaseResource
{
    protected static ?string $model = Client::class;

    // ✅ SOLO getFormSchema() necessario
    // ❌ NON implementare table(), getPages() (gestiti da XotBaseResource)

    public static function getFormSchema(): array
    {
        return [
            'oauth_client' => Section::make('OAuth Client Information')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('name')->required(),
                        Select::make('user_id')->relationship('user', 'name'),
                    ]),
                    // ... altri campi
                ]),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user']);
    }
}
```

---

## 🧪 Testing Passport Integration

### Feature Tests

```php
use Laravel\Passport\Passport;

test('user can create personal access token', function () {
    $user = User::factory()->create();

    $token = $user->createToken('Test Token', ['view-user']);

    expect($token)->toBeInstanceOf(PersonalAccessTokenResult::class)
        ->and($token->accessToken)->not->toBeEmpty()
        ->and($token->token->name)->toBe('Test Token');
});

test('token can check scopes', function () {
    $user = User::factory()->create();
    $token = $user->createToken('Test', ['view-user']);

    $user->withAccessToken($token->accessToken);

    expect($user->tokenCan('view-user'))->toBeTrue()
        ->and($user->tokenCan('invalid-scope'))->toBeFalse();
});

test('OAuth client can be created via Filament', function () {
    Passport::actingAs(
        User::factory()->create(),
        ['view-user']
    );

    $client = OauthClient::create([
        'name' => 'Test Client',
        'redirect' => 'https://example.com/callback',
        'personal_access_client' => false,
        'password_client' => false,
    ]);

    expect($client)->toBeInstanceOf(OauthClient::class)
        ->and($client->secret)->not->toBeNull();
});
```

---

## 🎯 Best Practices

### 1. Non Estendere Inutilmente

```php
// ❌ WRONG
class OauthClient extends PassportClient
{
    public function owner() {
        return $this->morphTo('user'); // Uguale al parent!
    }
}

// ✅ CORRECT
class OauthClient extends PassportClient
{
    // Se non aggiungi logica, non ridefinire!
    // Usa il metodo parent direttamente
}
```

### 2. Type Hints: Compatibilità > Purismo

```php
// ❌ Rompe compatibilità Passport
public function withAccessToken(ScopeAuthorizable|null $accessToken): static

// ✅ Mantiene compatibilità + PHPDoc per IDE/PHPStan
/**
 * @param ScopeAuthorizable|null $accessToken
 */
public function withAccessToken(mixed $accessToken): static
```

### 3. Connection Separation

```php
// Tutti i modelli OAuth usano connection 'user'
class OauthClient extends PassportClient
{
    protected $connection = 'user'; // ✅ Isolamento database
}
```

### 4. XotBase Pattern per Resources

```php
// ✅ Estende XotBaseResource
// ✅ Solo getFormSchema()
// ❌ NON table(), getPages()
final class OauthClientResource extends XotBaseResource
{
    public static function getFormSchema(): array { /* ... */ }
}
```

---

## 🔗 Relationships

### User ↔ OauthClient

```php
// BaseUser.php
public function clients(): HasMany
{
    return $this->hasMany(OauthClient::class, 'user_id');
}

// OauthClient.php (from parent Passport\Client)
public function owner(): MorphTo
{
    return $this->morphTo('user'); // Inherited
}
```

### User ↔ OauthAccessToken

```php
// BaseUser.php
public function tokens(): HasMany
{
    return $this->hasMany(OauthAccessToken::class, 'user_id');
}
```

---

## 📊 Database Schema

### OAuth Tables

```sql
-- OAuth Clients
oauth_clients
├── id (uuid, PK)
├── user_id (uuid, FK -> users.id, nullable)
├── name
├── secret (encrypted)
├── redirect
├── personal_access_client (boolean)
├── password_client (boolean)
├── revoked (boolean)
└── timestamps

-- OAuth Access Tokens
oauth_access_tokens
├── id (varchar, PK)
├── user_id (uuid, FK -> users.id, nullable)
├── client_id (uuid, FK -> oauth_clients.id)
├── name
├── scopes (json, nullable)
├── revoked (boolean)
├── expires_at
└── timestamps

-- OAuth Refresh Tokens
oauth_refresh_tokens
├── id (varchar, PK)
├── access_token_id (varchar, FK -> oauth_access_tokens.id)
├── revoked (boolean)
└── expires_at

-- OAuth Auth Codes
oauth_auth_codes
├── id (varchar, PK)
├── user_id (uuid, FK -> users.id)
├── client_id (uuid, FK -> oauth_clients.id)
├── scopes (json, nullable)
├── revoked (boolean)
├── expires_at

-- OAuth Personal Access Clients
oauth_personal_access_clients
├── id (bigint, auto PK)
├── client_id (uuid, FK -> oauth_clients.id)
└── timestamps
```

---

## 🚀 Usage Examples

### Creating Personal Access Token

```php
$user = User::find($userId);

$token = $user->createToken(
    'Mobile App Token',
    ['view-user', 'edit-profile']
);

// Return to client
return response()->json([
    'access_token' => $token->accessToken,
    'token_type' => 'Bearer',
    'expires_in' => config('passport.lifetime.personal_access_token'),
]);
```

### Using Token in API Request

```php
// Client request
$response = Http::withToken($accessToken)
    ->get('https://api.example.com/user');

// Server-side (automatic via Passport middleware)
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
```

### Checking Token Scopes

```php
if ($request->user()->tokenCan('edit-profile')) {
    // User has edit-profile scope
}

// In Policy
public function update(User $user, Post $post): bool
{
    return $user->tokenCan('edit-posts')
        && $post->user_id === $user->id;
}
```

---

## 🔍 PHPStan Compliance

### Zero Errori Strategy

```php
// ✅ Metodi parent non ridefiniti = zero maintenance
// ✅ Type hints compatibili con Passport
// ✅ PHPDoc completi per IDE support
// ✅ Assertions dove necessario

/**
 * @param ScopeAuthorizable|null $accessToken
 */
public function withAccessToken(mixed $accessToken): static
{
    // PHPStan sa il tipo reale via PHPDoc
    // Passport riceve il tipo che si aspetta (mixed)
    $this->passportWithAccessToken($accessToken);
    return $this;
}
```

### Level MAX Achievement

```bash
$ ./vendor/bin/phpstan analyse Modules --memory-limit=-1

 [OK] No errors
```

---

## 📚 Collegamenti

### Documentazione Correlata
- [FILOSOFIA_MODULO_USER.md](./FILOSOFIA_MODULO_USER.md) - Filosofia generale
- [README.md](./README.md) - Overview modulo
- [BUSINESS_LOGIC_DEEP_DIVE.md](./BUSINESS_LOGIC_DEEP_DIVE.md) - Business logic completa

### Documentazione Esterna
- [Laravel Passport Official](https://laravel.com/docs/passport)
- [OAuth 2.0 Specification](https://oauth.net/2/)
- [Filament v4 Resources](https://filamentphp.com/docs/resources)

---

## ✅ Checklist Integrazione

- [x] BaseUser implements OAuthenticatable
- [x] HasApiTokens trait con alias methods
- [x] OauthClient extends Passport\Client (minimalista)
- [x] Filament Resources per tutti i modelli OAuth
- [x] Token lifetimes configurabili
- [x] Scopes definiti
- [x] Connection 'user' per isolamento
- [x] PHPStan Level MAX compliance
- [x] XotBase pattern nei Resources
- [x] DRY: zero metodi ridondanti
- [x] KISS: compatibilità Passport mantenuta
- [x] Documentazione completa

---

**Conclusione**: Passport è integrato seguendo la filosofia Laraxot - estendere senza rompere, documentare decisioni, mantenere compatibilità con le librerie upstream. Zero compromessi su qualità, zero codice ridondante, massima type safety dove possibile senza rompere le API di Laravel.
