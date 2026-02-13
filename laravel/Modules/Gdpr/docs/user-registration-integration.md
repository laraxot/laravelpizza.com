# Integrazione con Registrazione Utenti (User Module)

## Panoramica

Il modulo Gdpr è integrato con il modulo User per la gestione completa dei consensi GDPR durante la registrazione utenti. Questa integrazione segue un pattern event-driven che garantisce separation of concerns e compliance GDPR completa.

## Architettura dell'Integrazione

```
┌─────────────────────────────────────────────────────────────┐
│                    REGISTERWIDGET                              │
│             (Modules/User/Filament/Widgets/Auth/)              │
│                                                              │
│  1. Raccoglie dati utente (nome, email, password)              │
│  2. Raccoglie consensi GDPR (checkbox)                       │
│  3. Valida consensi obbligatori                              │
│  4. Crea utente nel database                                  │
│  5. Dispaccia evento UserRegistered                         │
└─────────────────────┬───────────────────────────────────────┘
                      │
                      ▼
┌─────────────────────────────────────────────────────────────┐
│                EVENTO UserRegistered                         │
│            (Modules/User/Events/UserRegistered.php)           │
│                                                              │
│  Properties:                                                   │
│  - public User $user                                          │
│  - public array $formData (inclusi consensi GDPR)           │
│  - public string $ipAddress                                   │
│  - public string $userAgent                                   │
│                                                              │
│  Method:                                                      │
│  - public function getGdprConsents(): array                  │
└─────────────────────┬───────────────────────────────────────┘
                      │
                      ▼
┌─────────────────────────────────────────────────────────────┐
│            EVENT SERVICE PROVIDER                             │
│     (Modules/User/Providers/EventServiceProvider.php)            │
│                                                              │
│  protected $listen = [                                         │
│      UserRegistered::class => [                              │
│          GdprRegistrationListener::class,                   │
│      ],                                                        │
│  ];                                                          │
└─────────────────────┬───────────────────────────────────────┘
                      │
                      ▼
┌─────────────────────────────────────────────────────────────┐
│            GDPRREGISTRATIONLISTENER                          │
│          (Modules/Gdpr/Listeners/GdprRegistrationListener.php) │
│                                                              │
│  public function handle(UserRegistered $event): void         │
│  1. Estrae consensi: $event->getGdprConsents()              │
│  2. Mappa form field names → ConsentType enum values         │
│  3. Per ogni consenso accettato:                              │
│     - $user->giveConsent($consentType, $metadata)           │
│     - Salva record nella tabella 'consents'                  │
│  4. Log dell'operazione                                      │
└─────────────────────┬───────────────────────────────────────┘
                      │
                      ▼
┌──────────────────────────────────────────────┐   ┌─────────────────────────────────────┐
│        USER MODEL (HasGdpr Trait)          │   │      CONSENT MODEL                  │
│  (Modules/User/Models/User.php)              │   │ (Modules/Gdpr/Models/Consent.php)  │
│                                           │   │                                      │
│  use Modules\Gdpr\Models\Traits\HasGdpr;   │   │  id: UUID                           │
│  use HasGdpr;                             │   │  user_id: string (morphMany)      │
│                                           │   │  user_type: string (morphMany)    │
│  // Metodi forniti dal trait:            │   │  type: string (ConsentType)       │
│  // giveConsent()                        │   │  accepted_at: Carbon               │
│  // hasGivenConsent()                     │   │  revoked_at: Carbon?              │
│  // revokeConsent()                      │   │  metadata: JSON                    │
│  // consents()                           │   │  ip_address: string                 │
│  // activeConsents()                    │   │  user_agent: string                │
│                                           │   │  ...                              │
└──────────────────────────────────────────────┘   └─────────────────────────────────┘
```

## Mapping Form Fields → ConsentType

### Tabella di Mapping

Il RegisterWidget usa questi field names nel form:

| Field nel Form | ConsentType Enum | Required | Metodo HasGdpr | Descrizione |
|----------------|------------------|----------|----------------|-------------|
| `privacy_policy_accepted` | `PRIVACY_POLICY` | ✅ Sì | `giveConsent('privacy_policy')` | Accettazione privacy policy |
| `terms_accepted` | `TERMS_AND_CONDITIONS` | ✅ Sì | `giveConsent('terms_and_conditions')` | Accettazione termini e condizioni |
| `data_processing_accepted` | `PERSONALIZATION` | ✅ Sì | `giveConsent('personalization')` | Consenso trattamento dati personali |
| `marketing_consent` | `MARKETING_EMAIL` | ❌ No | `giveConsent('marketing_email')` | Consenso comunicazioni marketing |
| `profiling_consent` | `PROFILING` | ❌ No | `giveConsent('profiling')` | Consenso profilazione |
| `analytics_consent` | `ANALYTICS` | ❌ No | `giveConsent('analytics')` | Consenso analisi |
| `third_party_consent` | `THIRD_PARTY_SHARING` | ❌ No | `giveConsent('third_party_sharing')` | Condivisione con terze parti |

### Mapping nel Listener

```php
// GdprRegistrationListener.php
private const CONSENT_MAPPING = [
    'privacy_policy_accepted' => ConsentType::PRIVACY_POLICY->value,
    'terms_accepted' => ConsentType::TERMS_AND_CONDITIONS->value,
    'data_processing_accepted' => ConsentType::PERSONALIZATION->value,
    'marketing_consent' => ConsentType::MARKETING_EMAIL->value,
    'profiling_consent' => ConsentType::PROFILING->value,
    'analytics_consent' => ConsentType::ANALYTICS->value,
    'third_party_consent' => ConsentType::THIRD_PARTY_SHARING->value,
];
```

## Flusso di Dati Completo

### 1. Utente compila il form di registrazione

```php
// RegisterWidget.php
public function submit(): void
{
    $formData = $this->form->getState();
    
    // $formData contiene:
    [
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => 'mario.rossi@example.com',
        'password' => '********',
        'password_confirmation' => '********',
        'privacy_policy_accepted' => true,
        'terms_accepted' => true,
        'data_processing_accepted' => true,
        'marketing_consent' => false,
        'profiling_consent' => false,
        'analytics_consent' => false,
        'third_party_consent' => false,
    ]
    
    // Valida consensi obbligatori
    $this->validateGDPRConsent($formData);
    
    // Crea l'utente
    $user = User::create($validatedData);
    
    // Dispaccia l'evento
    UserRegistered::dispatch(
        user: $user,
        formData: $formData,
        ipAddress: request()->ip(),
        userAgent: request()->userAgent(),
    );
}
```

### 2. Evento UserRegistered viene dispacciato

```php
// UserRegistered.php
namespace Modules\User\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Models\User;

class UserRegistered
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public User $user,
        public array $formData,
        public string $ipAddress,
        public string $userAgent,
    ) {}

    public function getGdprConsents(): array
    {
        return [
            'privacy_policy_accepted' => (bool) ($this->formData['privacy_policy_accepted'] ?? false),
            'terms_accepted' => (bool) ($this->formData['terms_accepted'] ?? false),
            'data_processing_accepted' => (bool) ($this->formData['data_processing_accepted'] ?? false),
            'marketing_consent' => (bool) ($this->formData['marketing_consent'] ?? false),
            'profiling_consent' => (bool) ($this->formData['profiling_consent'] ?? false),
            'analytics_consent' => (bool) ($this->formData['analytics_consent'] ?? false),
            'third_party_consent' => (bool) ($this->formData['third_party_consent'] ?? false),
        ];
    }
}
```

### 3. GdprRegistrationListener riceve l'evento

```php
// GdprRegistrationListener.php
namespace Modules\Gdpr\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Gdpr\app\Enums\ConsentType;
use Modules\User\Events\UserRegistered;
use Illuminate\Support\Facades\Log;

class GdprRegistrationListener implements ShouldQueue
{
    private const CONSENT_MAPPING = [
        'privacy_policy_accepted' => ConsentType::PRIVACY_POLICY->value,
        'terms_accepted' => ConsentType::TERMS_AND_CONDITIONS->value,
        'data_processing_accepted' => ConsentType::PERSONALIZATION->value,
        'marketing_consent' => ConsentType::MARKETING_EMAIL->value,
        'profiling_consent' => ConsentType::PROFILING->value,
        'analytics_consent' => ConsentType::ANALYTICS->value,
        'third_party_consent' => ConsentType::THIRD_PARTY_SHARING->value,
    ];

    public function handle(UserRegistered $event): void
    {
        $gdprConsents = $event->getGdprConsents();
        $user = $event->user;
        
        foreach ($gdprConsents as $field => $accepted) {
            if ($accepted && isset(self::CONSENT_MAPPING[$field])) {
                $this->saveConsent($user, self::CONSENT_MAPPING[$field], $event);
            }
        }
        
        Log::info('GDPR consents saved for user', [
            'user_id' => $user->id,
            'consents' => array_keys(array_filter($gdprConsents)),
        ]);
    }

    private function saveConsent($user, string $consentType, UserRegistered $event): void
    {
        $metadata = [
            'registration_source' => 'register_widget',
            'ip_address' => $event->ipAddress,
            'user_agent' => $event->userAgent,
            'registered_at' => now()->toIso8601String(),
        ];
        
        $user->giveConsent($consentType, $metadata);
    }
}
```

### 4. Trait HasGdpr salva il consenso nel database

```php
// HasGdpr.php (Modules/Gdpr/Models/Traits/HasGdpr.php)
namespace Modules\Gdpr\Models\Traits;

use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\app\Enums\ConsentType;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasGdpr
{
    public function consents(): MorphMany
    {
        return $this->morphMany(Consent::class, 'user');
    }

    public function activeConsents(): MorphMany
    {
        return $this->consents()->whereNull('revoked_at');
    }

    public function giveConsent(ConsentType|string $type, array $metadata = []): Consent
    {
        $type = $type instanceof ConsentType ? $type->value : $type;
        
        /** @var Consent $consent */
        $consent = $this->consents()->create([
            'type' => $type,
            'metadata' => $metadata,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'accepted_at' => now(),
        ]);
        
        $this->clearConsentCache($type);
        
        return $consent;
    }

    public function hasGivenConsent(ConsentType|string $type): bool
    {
        $type = $type instanceof ConsentType ? $type->value : $type;
        
        return $this->activeConsents()
            ->where('type', $type)
            ->exists();
    }

    public function revokeConsent(ConsentType|string $type): void
    {
        $type = $type instanceof ConsentType ? $type->value : $type;
        
        $this->activeConsents()
            ->where('type', $type)
            ->update(['revoked_at' => now()]);
        
        $this->clearConsentCache($type);
    }

    private function clearConsentCache(string $type): void
    {
        cache()->forget("consents_{$this->id}_{$type}");
    }
}
```

### 5. Record salvato nella tabella `consents`

```sql
INSERT INTO consents (
    id,
    user_id,
    user_type,
    type,
    metadata,
    ip_address,
    user_agent,
    accepted_at,
    revoked_at,
    created_at,
    updated_at
) VALUES (
    '550e8400-e29b-41d4-a716-446655440000',
    '550e8400-e29b-41d4-a716-446655440000',
    'Modules\User\Models\User',
    'privacy_policy',
    '{"registration_source":"register_widget","ip_address":"192.168.1.1","user_agent":"Mozilla/5.0...","registered_at":"2026-02-09T10:30:00.000000Z"}',
    '192.168.1.1',
    'Mozilla/5.0...',
    '2026-02-09 10:30:00',
    NULL,
    '2026-02-09 10:30:00',
    '2026-02-09 10:30:00'
);
```

## Configurazione EventServiceProvider

Il modulo User deve registrare il listener per l'evento UserRegistered:

```php
// EventServiceProvider.php
namespace Modules\User\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Gdpr\Listeners\GdprRegistrationListener;
use Modules\User\Events\UserRegistered;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserRegistered::class => [
            GdprRegistrationListener::class,
        ],
    ];

    public function boot(): void
    {
        parent::boot();
    }
}
```

## Verifica dell'Integrazione

### 1. Test Registrazione

```bash
# Registra un nuovo utente con tutti i consensi
curl -X POST http://127.0.0.1:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "first_name": "Mario",
    "last_name": "Rossi",
    "email": "mario.rossi@example.com",
    "password": "SecurePassword123!",
    "password_confirmation": "SecurePassword123!",
    "privacy_policy_accepted": true,
    "terms_accepted": true,
    "data_processing_accepted": true,
    "marketing_consent": false,
    "profiling_consent": false,
    "analytics_consent": false,
    "third_party_consent": false
  }'
```

### 2. Verifica Database

```sql
-- Controlla i consensi salvati
SELECT * FROM consents 
WHERE user_id = 'user-uuid' 
ORDER BY created_at;

-- Output atteso:
-- id | user_id | user_type | type | accepted_at | revoked_at
-- ... | ... | ... | privacy_policy | 2026-02-09 10:30:00 | NULL
-- ... | ... | ... | terms_and_conditions | 2026-02-09 10:30:00 | NULL
-- ... | ... | ... | personalization | 2026-02-09 10:30:00 | NULL
```

### 3. Verifica nel Codice

```php
// Verifica i consensi nel codice
$user = User::find('user-uuid');

// Verifica consenso specifico
$hasPrivacyConsent = $user->hasGivenConsent(ConsentType::PRIVACY_POLICY); // true
$hasMarketingConsent = $user->hasGivenConsent(ConsentType::MARKETING_EMAIL); // false

// Ottieni tutti i consensi attivi
$allConsents = $user->activeConsents()->pluck('type')->toArray();
// ['privacy_policy', 'terms_and_conditions', 'personalization']

// Ottieni dettagli completi
$consents = $user->consents()->with('user')->get();
foreach ($consents as $consent) {
    echo $consent->type . ': ' . $consent->accepted_at . "\n";
}
```

### 4. Verifica Log

```bash
# Controlla i log per conferma
tail -f storage/logs/laravel.log | grep "GDPR consents saved"

# Output atteso:
# [2026-02-09 10:30:00] local.INFO: GDPR consents saved for user {"user_id":"550e8400-e29b-41d4-a716-446655440000","consents":["privacy_policy_accepted","terms_accepted","data_processing_accepted"]}
```

## Vantaggi dell'Integrazione

### 1. Separazione delle Responsabilità
- **Modulo User**: gestisce registrazione, UI, validazione dati
- **Modulo Gdpr**: gestisce consensi, compliance, audit trail

### 2. Architettura Pulita
- **Event-driven**: UserRegistered → GdprRegistrationListener
- **Trait-based**: HasGdpr trait riutilizzabile
- **Queue-ready**: ShouldQueue per processing asincrono

### 3. Estensibilità Facile
- **Aggiungere nuovi consensi**: Aggiungere a ConsentType enum
- **Modificare logica salvataggio**: Modificare solo GdprRegistrationListener
- **Aggiungere nuovi listener**: Aggiungere a EventServiceProvider

### 4. Compliance GDPR Completa
- **Timestamp**: Ogni consenso ha accepted_at e revoked_at
- **Audit trail**: IP address e user agent registrati
- **Metadata flessibile**: Possibilità di aggiungere informazioni
- **Revoca supportata**: Metodo revokeConsent() disponibile

## Prossimi Miglioramenti

### 1. Consenso Email Specifico
```php
// Aggiungere campo nel RegisterWidget
'email_consent' => Checkbox::make('email_consent')
    ->label('Acconsento a ricevere comunicazioni via email')
    ->required(false),

// Aggiungere mapping in GdprRegistrationListener
'email_consent' => ConsentType::EMAIL_COMMUNICATIONS->value,
```

### 2. Dashboard Privacy per Utenti
```php
// Creare endpoint per gestione privacy
Route::middleware(['auth'])->group(function () {
    Route::get('/account/privacy', [PrivacyController::class, 'index']);
    Route::post('/account/privacy/revoke/{type}', [PrivacyController::class, 'revoke']);
    Route::get('/account/privacy/export', [PrivacyController::class, 'export']);
});
```

### 3. Notifiche Privacy
```php
// Aggiungere listener per notifiche
class ConsentRevokedNotificationListener
{
    public function handle(ConsentRevoked $event): void
    {
        $event->user->notify(new ConsentRevokedNotification($event->consentType));
    }
}
```

### 4. Export Dati Personali (Diritto alla Portabilità)
```php
// Creare action per export dati
class ExportUserDataAction
{
    public function execute(User $user): array
    {
        return [
            'personal_data' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'created_at' => $user->created_at,
            ],
            'consents' => $user->consents->toArray(),
            'activities' => $user->activities->toArray(),
        ];
    }
}
```

## Testing

### Unit Tests
```php
test('user can give consent', function () {
    $user = User::factory()->create();
    
    $consent = $user->giveConsent(ConsentType::PRIVACY_POLICY, [
        'source' => 'test',
    ]);
    
    expect($user->hasGivenConsent(ConsentType::PRIVACY_POLICY))->toBeTrue();
    expect($consent->type)->toBe('privacy_policy');
});

test('user can revoke consent', function () {
    $user = User::factory()->create();
    $user->giveConsent(ConsentType::MARKETING_EMAIL);
    
    $user->revokeConsent(ConsentType::MARKETING_EMAIL);
    
    expect($user->hasGivenConsent(ConsentType::MARKETING_EMAIL))->toBeFalse();
});
```

### Feature Tests
```php
test('user registration saves gdpr consents', function () {
    Event::fake();
    
    $response = $this->post('/register', [
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => 'mario.rossi@example.com',
        'password' => 'SecurePassword123!',
        'password_confirmation' => 'SecurePassword123!',
        'privacy_policy_accepted' => true,
        'terms_accepted' => true,
        'data_processing_accepted' => true,
    ]);
    
    $response->assertRedirect('/dashboard');
    
    Event::assertDispatched(UserRegistered::class);
    
    $user = User::where('email', 'mario.rossi@example.com')->first();
    expect($user->hasGivenConsent(ConsentType::PRIVACY_POLICY))->toBeTrue();
});
```

## Collegamenti

### Documentazione Intera
- [README Modulo Gdpr](./README.md)
- [Consent Management System](./consents.md)
- [GDPR Compliance Guide](./gdpr-compliance.md)
- [Testing Guidelines](./testing-guidelines.md)

### Documentazione Moduli Correlati
- [User Module - GDPR Compliance](../../User/docs/gdpr-compliance-complete.md)
- [User Module - Events](../../User/docs/events.md)
- [Xot Module - Traits](../../Xot/docs/traits.md)

---

**Document Version**: 1.0.0  

**Responsible**: GDPR Compliance Team  
**Approved by**: Legal Department