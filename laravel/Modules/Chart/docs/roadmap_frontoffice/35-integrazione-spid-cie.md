# Integrazione SPID/CIE - <nome progetto>

## Introduzione

L'integrazione con il Sistema Pubblico di Identità Digitale (SPID) e la Carta d'Identità Elettronica (CIE) rappresenta un requisito strategico per <nome progetto>, consentendo l'accesso semplificato e sicuro ai servizi per cittadini e operatori sanitari, in linea con le direttive di digitalizzazione della PA.

## Stato Attuale

**Completamento**: Pianificato (fase futura dell'85% del modulo Registrazione e Autenticazione)

### 📋 Pianificato
- SPID identity provider integration
- CIE authentication flow
- Attribute mapping e user provisioning
- SAML 2.0 implementation

### 🎯 Obiettivi
- Compliance con linee guida AgID
- Semplificazione onboarding utenti
- Riduzione friction di registrazione
- Integrazione dati anagrafica

## Framework Normativo

### Riferimenti Normativi
- **AgID Guidelines**: Linee guida SPID versione 3.0
- **CAD**: Codice dell'Amministrazione Digitale
- **GDPR**: Trattamento dati personali
- **Decreto Semplificazioni**: Art. 24 e 64

### Livelli SPID Supportati
1. **SPID L1**: Username e password
2. **SPID L2**: Username, password e OTP/SMS ✅ (Target)
3. **SPID L3**: Supporto smart card/token (futuro)

## Architettura Tecnica

### SAML 2.0 Implementation
```php
class SPIDAuthenticationProvider
{
    private SAMLAuth $samlAuth;
    private AttributeMapper $attributeMapper;
    
    public function initiateSPIDLogin(string $idp = null): RedirectResponse
    {
        $settings = $this->getSAMLSettings($idp);
        $auth = new SAMLAuth($settings);
        
        // Log authentication attempt
        SecurityAudit::log('spid_auth_initiated', null, [
            'idp' => $idp,
            'ip' => request()->ip(),
        ]);
        
        return redirect($auth->login());
    }
    
    public function handleSPIDCallback(Request $request): array
    {
        $auth = new SAMLAuth($this->getSAMLSettings());
        $auth->processResponse();
        
        if (!$auth->isAuthenticated()) {
            throw new SPIDAuthenticationException($auth->getLastErrorReason());
        }
        
        $attributes = $auth->getAttributes();
        $userData = $this->attributeMapper->mapSPIDAttributes($attributes);
        
        // Log successful authentication
        SecurityAudit::log('spid_auth_success', null, [
            'spid_code' => $attributes['spidCode'][0] ?? null,
            'fiscal_code' => $attributes['fiscalNumber'][0] ?? null,
        ]);
        
        return $userData;
    }
}
```

### Attribute Mapping
```php
class SPIDAttributeMapper
{
    private array $attributeMapping = [
        // Attributi obbligatori SPID
        'spidCode' => 'spid_code',
        'name' => 'first_name',
        'familyName' => 'last_name',
        'fiscalNumber' => 'fiscal_code',
        
        // Attributi opzionali
        'email' => 'email',
        'mobilePhone' => 'phone',
        'dateOfBirth' => 'date_of_birth',
        'placeOfBirth' => 'place_of_birth',
        'gender' => 'gender',
        'address' => 'address',
        'digitalAddress' => 'pec',
    ];
    
    public function mapSPIDAttributes(array $spidAttributes): array
    {
        $userData = [];
        
        foreach ($this->attributeMapping as $spidAttr => $localAttr) {
            if (isset($spidAttributes[$spidAttr][0])) {
                $userData[$localAttr] = $this->sanitizeAttribute(
                    $spidAttr,
                    $spidAttributes[$spidAttr][0]
                );
            }
        }
        
        // Validazione dati obbligatori
        $this->validateRequiredAttributes($userData);
        
        return $userData;
    }
    
    private function sanitizeAttribute(string $attribute, string $value): string
    {
        return match($attribute) {
            'fiscalNumber' => strtoupper(trim($value)),
            'email' => strtolower(trim($value)),
            'mobilePhone' => $this->formatPhoneNumber($value),
            'dateOfBirth' => $this->formatDate($value),
            default => trim($value)
        };
    }
}
```

### CIE Integration
```php
class CIEAuthenticationProvider
{
    public function initiateCIELogin(): RedirectResponse
    {
        $cieUrl = config('cie.base_url') . '/authorize?' . http_build_query([
            'client_id' => config('cie.client_id'),
            'response_type' => 'code',
            'scope' => 'openid profile',
            'redirect_uri' => route('auth.cie.callback'),
            'state' => Str::random(32),
        ]);
        
        session(['cie_state' => $state]);
        
        SecurityAudit::log('cie_auth_initiated', null, [
            'ip' => request()->ip(),
        ]);
        
        return redirect($cieUrl);
    }
    
    public function handleCIECallback(Request $request): array
    {
        $this->validateState($request->state);
        
        $tokenResponse = Http::post(config('cie.base_url') . '/token', [
            'grant_type' => 'authorization_code',
            'code' => $request->code,
            'redirect_uri' => route('auth.cie.callback'),
            'client_id' => config('cie.client_id'),
            'client_secret' => config('cie.client_secret'),
        ]);
        
        $tokenData = $tokenResponse->json();
        $userInfo = $this->getCIEUserInfo($tokenData['access_token']);
        
        SecurityAudit::log('cie_auth_success', null, [
            'fiscal_code' => $userInfo['fiscal_code'] ?? null,
        ]);
        
        return $userInfo;
    }
}
```

## User Provisioning

### Automatic Registration
```php
class SPIDUserProvisioning
{
    public function provisionUser(array $spidData): User
    {
        // Cerca utente esistente per codice fiscale
        $existingUser = User::where('fiscal_code', $spidData['fiscal_code'])->first();
        
        if ($existingUser) {
            // Aggiorna dati se necessario
            $this->updateUserFromSPID($existingUser, $spidData);
            return $existingUser;
        }
        
        // Crea nuovo utente
        $user = User::create([
            'first_name' => $spidData['first_name'],
            'last_name' => $spidData['last_name'],
            'fiscal_code' => $spidData['fiscal_code'],
            'email' => $spidData['email'] ?? null,
            'phone' => $spidData['phone'] ?? null,
            'date_of_birth' => $spidData['date_of_birth'] ?? null,
            'place_of_birth' => $spidData['place_of_birth'] ?? null,
            'gender' => $spidData['gender'] ?? null,
            'address' => $spidData['address'] ?? null,
            'email_verified_at' => now(), // SPID garantisce verifica
            'spid_code' => $spidData['spid_code'],
            'auth_method' => 'spid',
        ]);
        
        // Crea profilo paziente di default se applicabile
        if ($this->shouldCreatePatientProfile($user)) {
            $this->createPatientProfile($user);
        }
        
        // Notifica registrazione
        $user->notify(new SPIDRegistrationCompleteNotification());
        
        SecurityAudit::log('spid_user_provisioned', $user);
        
        return $user;
    }
}
```

### Profile Synchronization
```php
class SPIDProfileSynchronizer
{
    public function syncProfile(User $user, array $spidData): bool
    {
        $changes = [];
        
        foreach (['first_name', 'last_name', 'email', 'phone'] as $field) {
            if (isset($spidData[$field]) && $user->$field !== $spidData[$field]) {
                $changes[$field] = [
                    'old' => $user->$field,
                    'new' => $spidData[$field],
                ];
                $user->$field = $spidData[$field];
            }
        }
        
        if (!empty($changes)) {
            $user->save();
            
            SecurityAudit::log('spid_profile_sync', $user, ['changes' => $changes]);
            $user->notify(new ProfileSyncedNotification($changes));
            
            return true;
        }
        
        return false;
    }
}
```

## Identity Provider Management

### Supported IDPs
```php
class SPIDIdentityProviders
{
    private array $providers = [
        'aruba' => [
            'name' => 'Aruba ID',
            'entity_id' => 'https://loginspid.aruba.it',
            'sso_url' => 'https://loginspid.aruba.it/ServiceLoginWelcome',
            'logo' => 'aruba-logo.png',
            'active' => true,
        ],
        'infocert' => [
            'name' => 'Infocert ID',
            'entity_id' => 'https://identity.infocert.it',
            'sso_url' => 'https://identity.infocert.it/spid/samlsso',
            'logo' => 'infocert-logo.png',
            'active' => true,
        ],
        'poste' => [
            'name' => 'Poste ID',
            'entity_id' => 'https://posteid.poste.it',
            'sso_url' => 'https://posteid.poste.it/jod-fs/ssoservicepost',
            'logo' => 'poste-logo.png',
            'active' => true,
        ],
        'tim' => [
            'name' => 'TIM ID',
            'entity_id' => 'https://login.id.tim.it/affwebservices/public/saml2sso',
            'sso_url' => 'https://login.id.tim.it/affwebservices/public/saml2sso',
            'logo' => 'tim-logo.png',
            'active' => true,
        ],
    ];
    
    public function getActiveProviders(): array
    {
        return array_filter($this->providers, fn($provider) => $provider['active']);
    }
    
    public function getProviderConfig(string $providerId): array
    {
        if (!isset($this->providers[$providerId])) {
            throw new InvalidArgumentException("Provider {$providerId} not found");
        }
        
        return $this->providers[$providerId];
    }
}
```

## Frontend Implementation

### Login Page Integration
```blade
{{-- auth/login.blade.php --}}
<div class="authentication-methods">
    <div class="traditional-auth">
        <h3>{{ __('auth.traditional_login') }}</h3>
        {{-- Form login tradizionale --}}
    </div>
    
    <div class="divider">
        <span>{{ __('auth.or') }}</span>
    </div>
    
    <div class="digital-identity">
        <h3>{{ __('auth.digital_identity') }}</h3>
        
        <div class="spid-section">
            <h4>{{ __('auth.spid.title') }}</h4>
            <p class="spid-description">{{ __('auth.spid.description') }}</p>
            
            <div class="idp-grid">
                @foreach($spidProviders as $providerId => $provider)
                    <a href="{{ route('auth.spid.login', $providerId) }}" 
                       class="idp-button">
                        <img src="{{ asset('images/spid/' . $provider['logo']) }}" 
                             alt="{{ $provider['name'] }}">
                        <span>{{ $provider['name'] }}</span>
                    </a>
                @endforeach
            </div>
            
            <div class="spid-info">
                <a href="https://www.spid.gov.it/come-attivare-spid/" 
                   target="_blank">{{ __('auth.spid.how_to_get') }}</a>
            </div>
        </div>
        
        <div class="cie-section">
            <h4>{{ __('auth.cie.title') }}</h4>
            <p class="cie-description">{{ __('auth.cie.description') }}</p>
            
            <a href="{{ route('auth.cie.login') }}" class="cie-button">
                <img src="{{ asset('images/cie-logo.png') }}" alt="CIE">
                <span>{{ __('auth.cie.login_with_cie') }}</span>
            </a>
        </div>
    </div>
</div>
```

### Error Handling
```php
class SPIDErrorHandler
{
    public function handleSPIDError(\Exception $exception): Response
    {
        $errorCode = $this->mapErrorCode($exception);
        
        SecurityAudit::log('spid_auth_error', null, [
            'error_code' => $errorCode,
            'error_message' => $exception->getMessage(),
            'ip' => request()->ip(),
        ]);
        
        return match($errorCode) {
            'auth_failed' => redirect()->route('login')
                ->withErrors(['spid' => __('auth.spid.errors.auth_failed')]),
            'attribute_missing' => redirect()->route('login')
                ->withErrors(['spid' => __('auth.spid.errors.attribute_missing')]),
            'idp_error' => redirect()->route('login')
                ->withErrors(['spid' => __('auth.spid.errors.idp_error')]),
            default => redirect()->route('login')
                ->withErrors(['spid' => __('auth.spid.errors.generic')]),
        };
    }
}
```

## Security Considerations

### SAML Security
```php
class SAMLSecurityValidator
{
    public function validateSAMLResponse(string $samlResponse): bool
    {
        $response = new SAMLResponse($samlResponse);
        
        // Validazioni obbligatorie
        $validations = [
            'signature_valid' => $response->isSignatureValid(),
            'not_expired' => !$response->isExpired(),
            'audience_valid' => $response->getAudience() === config('spid.entity_id'),
            'issuer_trusted' => $this->isTrustedIssuer($response->getIssuer()),
        ];
        
        $isValid = !in_array(false, $validations, true);
        
        SecurityAudit::log('saml_validation', null, [
            'validations' => $validations,
            'is_valid' => $isValid,
            'issuer' => $response->getIssuer(),
        ]);
        
        return $isValid;
    }
}
```

### Anti-Replay Protection
```php
class SAMLReplayProtection
{
    public function isReplay(string $inResponseTo): bool
    {
        $key = "saml_request_{$inResponseTo}";
        
        if (Cache::has($key)) {
            SecurityAudit::log('saml_replay_attempt', null, ['request_id' => $inResponseTo]);
            return true;
        }
        
        // Mark as used for 1 hour
        Cache::put($key, true, now()->addHour());
        
        return false;
    }
}
```

## Configuration Management

### Environment Configuration
```php
// config/spid.php
return [
    'entity_id' => env('SPID_ENTITY_ID', 'https://<nome progetto>.it/spid'),
    'assertion_consumer_service' => env('SPID_ACS_URL', 'https://<nome progetto>.it/auth/spid/acs'),
    'single_logout_service' => env('SPID_SLS_URL', 'https://<nome progetto>.it/auth/spid/sls'),
    
    'certificate' => [
        'x509cert' => env('SPID_X509_CERT'),
        'private_key' => env('SPID_PRIVATE_KEY'),
    ],
    
    'contact' => [
        'technical' => [
            'name' => env('SPID_TECH_CONTACT_NAME'),
            'email' => env('SPID_TECH_CONTACT_EMAIL'),
        ],
        'billing' => [
            'name' => env('SPID_BILLING_CONTACT_NAME'),
            'email' => env('SPID_BILLING_CONTACT_EMAIL'),
        ],
    ],
    
    'organization' => [
        'name' => env('SPID_ORG_NAME', '<nome progetto>'),
        'display_name' => env('SPID_ORG_DISPLAY_NAME', '<nome progetto> - Portale Salute Orale'),
        'url' => env('SPID_ORG_URL', 'https://<nome progetto>.it'),
    ],
];
```

## Testing Strategy

### Unit Tests
```php
class SPIDIntegrationTest extends TestCase
{
    public function test_spid_attribute_mapping()
    {
        $mapper = new SPIDAttributeMapper();
        
        $spidAttributes = [
            'spidCode' => ['SPID123456789'],
            'name' => ['Mario'],
            'familyName' => ['Rossi'],
            'fiscalNumber' => ['RSSMRA80A01H501X'],
            'email' => ['mario.rossi@example.com'],
        ];
        
        $userData = $mapper->mapSPIDAttributes($spidAttributes);
        
        $this->assertEquals('Mario', $userData['first_name']);
        $this->assertEquals('Rossi', $userData['last_name']);
        $this->assertEquals('RSSMRA80A01H501X', $userData['fiscal_code']);
        $this->assertEquals('mario.rossi@example.com', $userData['email']);
    }
    
    public function test_user_provisioning()
    {
        $provisioning = new SPIDUserProvisioning();
        
        $spidData = [
            'first_name' => 'Maria',
            'last_name' => 'Bianchi',
            'fiscal_code' => 'BNCMRA85M01H501Y',
            'email' => 'maria.bianchi@example.com',
            'spid_code' => 'SPID987654321',
        ];
        
        $user = $provisioning->provisionUser($spidData);
        
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Maria', $user->first_name);
        $this->assertEquals('spid', $user->auth_method);
        $this->assertNotNull($user->email_verified_at);
    }
}
```

### Integration Testing
```php
class SPIDAuthenticationFlowTest extends TestCase
{
    public function test_full_spid_authentication_flow()
    {
        // Mock SAML response
        $samlResponse = $this->createMockSAMLResponse();
        
        // Initiate SPID login
        $response = $this->get('/auth/spid/login/aruba');
        $response->assertRedirect();
        
        // Simulate IDP callback
        $response = $this->post('/auth/spid/acs', [
            'SAMLResponse' => base64_encode($samlResponse),
        ]);
        
        $response->assertRedirect('/patient/dashboard');
        $this->assertAuthenticated();
        
        // Verify user was created/updated
        $user = User::where('fiscal_code', 'RSSMRA80A01H501X')->first();
        $this->assertNotNull($user);
        $this->assertEquals('spid', $user->auth_method);
    }
}
```

## Compliance e Audit

### AgID Compliance Checklist
- [ ] Metadata conforme alle specifiche tecniche SPID
- [ ] Supporto per tutti gli attributi obbligatori
- [ ] Implementazione corretta del protocollo SAML 2.0
- [ ] Gestione sicura dei certificati X.509
- [ ] Log di audit per tutte le operazioni
- [ ] Gestione errori conforme alle specifiche

### Audit Trail
```php
class SPIDAuditLogger
{
    public function logSPIDEvent(string $event, ?User $user, array $context = []): void
    {
        SPIDAuditLog::create([
            'event_type' => $event,
            'user_id' => $user?->id,
            'fiscal_code' => $context['fiscal_code'] ?? $user?->fiscal_code,
            'spid_code' => $context['spid_code'] ?? null,
            'idp' => $context['idp'] ?? null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'context' => $context,
            'created_at' => now(),
        ]);
    }
}
```

## Timeline Implementazione

### Fase 1: SPID Base (Marzo 2025)
- [ ] SAML 2.0 implementation
- [ ] Basic attribute mapping
- [ ] User provisioning
- [ ] Testing con IdP di test

### Fase 2: Production Ready (Aprile 2025)
- [ ] Metadata pubblicazione
- [ ] Security hardening
- [ ] Error handling completo
- [ ] Documentation utente

### Fase 3: CIE Integration (Maggio 2025)
- [ ] CIE authentication flow
- [ ] Mobile optimization
- [ ] Advanced features
- [ ] Monitoring e analytics

## Success Metrics

### Adoption KPIs
- **SPID Registration Rate**: > 40% nuovi utenti
- **Authentication Success Rate**: > 95%
- **User Satisfaction**: > 4.2/5
- **Support Tickets Reduction**: > 30%

### Technical KPIs
- **Authentication Time**: < 10 secondi
- **System Availability**: > 99.9%
- **Error Rate**: < 1%
- **Security Incidents**: 0

## Collegamenti e Backlink

### Documentazione Correlata
- [Torna alla Roadmap Frontoffice](../roadmap_frontoffice.md)
- [Stato Avanzamento 2025](../stato_avanzamento_lavori_2025_06_05.md)
- [Registrazione e Autenticazione](./04-registrazione-autenticazione.md)
- [Autenticazione a Due Fattori](./34-autenticazione-due-fattori.md)
- [Security Audit](./32-security-audit.md)

### Risorse Tecniche
- [AgID SPID Guidelines](https://docs.italia.it/italia/spid/)
- [SAML 2.0 Specifications](https://docs.oasis-open.org/security/saml/)
- [CIE Documentation](https://www.cartaidentita.interno.gov.it/)

---

*Documento creato: 2 Gennaio 2025*  
*Responsabile: Security Team & Backend*  
*Stato: Pianificato*  
*Prossimo aggiornamento: 15 Marzo 2025* 
