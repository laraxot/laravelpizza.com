# Autenticazione a Due Fattori (2FA) - <nome progetto>

## Introduzione

L'implementazione dell'autenticazione a due fattori rappresenta un elemento critico per la sicurezza del portale <nome progetto>, considerando la natura sensibile dei dati sanitari gestiti e le normative GDPR applicabili.

## Stato Attuale

**Completamento**: In Corso (85% del modulo Registrazione e Autenticazione)

### 🚧 In Sviluppo
- Sistema TOTP (Time-based One-Time Password)
- Backup codes generazione
- SMS OTP integration
- Recovery mechanism

### 📋 Pianificato  
- Biometric authentication (mobile)
- Hardware token support
- Risk-based authentication

## Requisiti di Sicurezza

### Compliance Requirements
- **GDPR Article 32**: Sicurezza del trattamento
- **ISO 27001**: Controlli di accesso
- **AgID Guidelines**: Standard autenticazione PA
- **Medical Device Regulation**: Per dati sanitari

### Threat Model
1. **Password compromesse**: Mitigazione tramite secondo fattore
2. **Session hijacking**: Mitigazione con re-auth per azioni sensibili
3. **Phishing attacks**: Mitigazione con app-based TOTP
4. **Social engineering**: Mitigazione con backup codes sicuri

## Architettura 2FA

### Metodi di Autenticazione Supportati

#### 1. TOTP (Time-based One-Time Password)
```php
class TOTPService
{
    private Google2FA $google2fa;
    
    public function enableTOTP(User $user): array
    {
        $secret = $this->google2fa->generateSecretKey();
        
        $user->update([
            'two_factor_secret' => encrypt($secret),
            'two_factor_recovery_codes' => $this->generateRecoveryCodes(),
            'two_factor_enabled' => false, // Attivato dopo prima verifica
        ]);
        
        return [
            'secret' => $secret,
            'qr_code' => $this->generateQRCode($user, $secret),
            'recovery_codes' => $user->two_factor_recovery_codes,
        ];
    }
    
    public function verifyTOTP(User $user, string $code): bool
    {
        $secret = decrypt($user->two_factor_secret);
        
        $valid = $this->google2fa->verifyKey($secret, $code);
        
        if ($valid && !$user->two_factor_enabled) {
            $user->update(['two_factor_enabled' => true]);
            
            SecurityAudit::log('2fa_enabled', $user);
            $user->notify(new TwoFactorEnabledNotification());
        }
        
        return $valid;
    }
}
```

#### 2. SMS OTP
```php
class SMSOTPService  
{
    public function sendSMSOTP(User $user): string
    {
        $code = $this->generateNumericCode();
        
        Cache::put(
            "sms_otp_{$user->id}",
            $code,
            now()->addMinutes(5)
        );
        
        SMS::send($user->phone, "Il tuo codice <nome progetto>: {$code}. Valido per 5 minuti.");
        
        SecurityAudit::log('sms_otp_sent', $user, ['phone_last4' => substr($user->phone, -4)]);
        
        return $code;
    }
    
    public function verifySMSOTP(User $user, string $code): bool
    {
        $storedCode = Cache::get("sms_otp_{$user->id}");
        
        if (!$storedCode || $storedCode !== $code) {
            SecurityAudit::log('sms_otp_failed', $user);
            return false;
        }
        
        Cache::forget("sms_otp_{$user->id}");
        SecurityAudit::log('sms_otp_verified', $user);
        
        return true;
    }
}
```

#### 3. Recovery Codes
```php
class RecoveryCodeService
{
    public function generateRecoveryCodes(): array
    {
        return collect(range(1, 8))
            ->map(fn() => Str::random(10))
            ->map(fn($code) => strtoupper($code))
            ->toArray();
    }
    
    public function useRecoveryCode(User $user, string $code): bool
    {
        $codes = $user->two_factor_recovery_codes;
        
        if (!in_array($code, $codes)) {
            return false;
        }
        
        // Rimuovi il codice usato
        $remainingCodes = array_diff($codes, [$code]);
        $user->update(['two_factor_recovery_codes' => array_values($remainingCodes)]);
        
        SecurityAudit::log('recovery_code_used', $user, [
            'remaining_codes' => count($remainingCodes)
        ]);
        
        // Notifica se rimangono pochi codici
        if (count($remainingCodes) <= 2) {
            $user->notify(new LowRecoveryCodesNotification($remainingCodes));
        }
        
        return true;
    }
}
```

## User Experience Implementation

### Setup Wizard
```php
class TwoFactorSetupWizard extends Widget
{
    public $currentStep = 1;
    public $totpSecret;
    public $qrCode;
    public $verificationCode;
    public $recoveryCodes;
    
    protected function getFormSchema(): array
    {
        return [
            Wizard::make([
                Wizard\Step::make('Method Selection')
                    ->schema([
                        Radio::make('method')
                            ->options([
                                'totp' => 'App Autenticazione (Consigliato)',
                                'sms' => 'SMS',
                            ])
                            ->descriptions([
                                'totp' => 'Usa Google Authenticator o simili',
                                'sms' => 'Ricevi codici via SMS',
                            ]),
                    ]),
                
                Wizard\Step::make('Setup')
                    ->schema([
                        ViewField::make('qr_code')
                            ->view('filament.forms.qr-code-field')
                            ->visible(fn (Get $get) => $get('method') === 'totp'),
                        
                        Placeholder::make('phone_verification')
                            ->content('Invieremo un codice al numero: ' . auth()->user()->phone)
                            ->visible(fn (Get $get) => $get('method') === 'sms'),
                    ]),
                
                Wizard\Step::make('Verification')
                    ->schema([
                        TextInput::make('verification_code')
                            ->label('Codice di Verifica')
                            ->required()
                            ->length(6),
                    ]),
                
                Wizard\Step::make('Recovery Codes')
                    ->schema([
                        ViewField::make('recovery_codes')
                            ->view('filament.forms.recovery-codes-field'),
                    ]),
            ]),
        ];
    }
}
```

### Login Flow con 2FA
```php
class TwoFactorLoginController extends Controller
{
    public function challenge(Request $request)
    {
        $user = $request->session()->get('two_factor.user');
        
        if (!$user || !$user->two_factor_enabled) {
            return redirect()->route('login');
        }
        
        return view('auth.two-factor-challenge', [
            'user' => $user,
            'methods' => $this->getAvailableMethods($user),
        ]);
    }
    
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'method' => 'required|in:totp,sms,recovery',
        ]);
        
        $user = $request->session()->get('two_factor.user');
        $verified = false;
        
        switch ($request->method) {
            case 'totp':
                $verified = app(TOTPService::class)->verifyTOTP($user, $request->code);
                break;
            case 'sms':
                $verified = app(SMSOTPService::class)->verifySMSOTP($user, $request->code);
                break;
            case 'recovery':
                $verified = app(RecoveryCodeService::class)->useRecoveryCode($user, $request->code);
                break;
        }
        
        if (!$verified) {
            return back()->withErrors(['code' => 'Codice non valido.']);
        }
        
        $request->session()->forget('two_factor.user');
        Auth::login($user, $request->session()->get('two_factor.remember'));
        
        return redirect()->intended(route('patient.dashboard'));
    }
}
```

## Risk-Based Authentication

### Context Analysis
```php
class AuthenticationRiskAnalyzer
{
    public function assessRisk(Request $request, User $user): string
    {
        $riskFactors = [
            'new_device' => $this->isNewDevice($request, $user),
            'unusual_location' => $this->isUnusualLocation($request, $user),
            'unusual_time' => $this->isUnusualTime($request, $user),
            'multiple_failed_attempts' => $this->hasRecentFailedAttempts($user),
            'account_changes' => $this->hasRecentAccountChanges($user),
        ];
        
        $riskScore = array_sum($riskFactors);
        
        return match(true) {
            $riskScore >= 3 => 'high',
            $riskScore >= 1 => 'medium',
            default => 'low'
        };
    }
    
    public function requireAdditionalAuth(string $riskLevel, User $user): bool
    {
        return match($riskLevel) {
            'high' => true,
            'medium' => $user->two_factor_enabled,
            'low' => false,
        };
    }
}
```

### Adaptive Authentication
```php
class AdaptiveAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        if (!$user) {
            return $next($request);
        }
        
        $riskLevel = app(AuthenticationRiskAnalyzer::class)->assessRisk($request, $user);
        
        // Force 2FA per azioni sensibili su high risk
        if ($riskLevel === 'high' && $this->isSensitiveAction($request)) {
            if (!$request->session()->has('verified_2fa_at') || 
                now()->diffInMinutes($request->session()->get('verified_2fa_at')) > 10) {
                
                return redirect()->route('auth.two-factor.challenge');
            }
        }
        
        return $next($request);
    }
}
```

## Mobile Implementation

### Biometric Authentication (Future)
```javascript
// React Native / PWA implementation
class BiometricAuth {
    static async isSupported() {
        return await LocalAuthentication.hasHardwareAsync() &&
               await LocalAuthentication.isEnrolledAsync();
    }
    
    static async authenticate() {
        const result = await LocalAuthentication.authenticateAsync({
            promptMessage: 'Verifica la tua identità',
            fallbackLabel: 'Usa PIN',
            cancelLabel: 'Annulla',
        });
        
        return result.success;
    }
}
```

### Push Notifications per Approval
```php
class PushApprovalService
{
    public function sendApprovalRequest(User $user, array $context): string
    {
        $approvalId = Str::uuid();
        
        Cache::put(
            "push_approval_{$approvalId}",
            ['user_id' => $user->id, 'context' => $context],
            now()->addMinutes(5)
        );
        
        $user->notify(new LoginApprovalNotification($approvalId, $context));
        
        return $approvalId;
    }
    
    public function handleApprovalResponse(string $approvalId, bool $approved): bool
    {
        $data = Cache::get("push_approval_{$approvalId}");
        
        if (!$data) {
            return false;
        }
        
        if ($approved) {
            Cache::put(
                "approved_login_{$data['user_id']}",
                true,
                now()->addMinutes(5)
            );
        }
        
        Cache::forget("push_approval_{$approvalId}");
        
        return true;
    }
}
```

## Security Features

### Rate Limiting
```php
class TwoFactorRateLimiter
{
    public function tooManyAttempts(User $user): bool
    {
        $key = "2fa_attempts_{$user->id}";
        $attempts = Cache::get($key, 0);
        
        return $attempts >= 5;
    }
    
    public function hit(User $user): void
    {
        $key = "2fa_attempts_{$user->id}";
        $attempts = Cache::get($key, 0) + 1;
        
        Cache::put($key, $attempts, now()->addHour());
        
        if ($attempts >= 5) {
            SecurityAudit::log('2fa_rate_limited', $user);
            $user->notify(new TwoFactorAccountLockedNotification());
        }
    }
}
```

### Secure Storage
```php
class TwoFactorEncryption
{
    public function encryptSecret(string $secret): string
    {
        return encrypt($secret, false);
    }
    
    public function decryptSecret(string $encryptedSecret): string
    {
        return decrypt($encryptedSecret);
    }
    
    public function rotateSecret(User $user): string
    {
        $newSecret = app(Google2FA::class)->generateSecretKey();
        
        // Grace period per transizione
        $user->update([
            'two_factor_secret_old' => $user->two_factor_secret,
            'two_factor_secret' => encrypt($newSecret),
            'two_factor_rotation_at' => now(),
        ]);
        
        return $newSecret;
    }
}
```

## Testing Strategy

### Unit Tests
```php
class TwoFactorTest extends TestCase
{
    public function test_totp_generation_and_verification()
    {
        $user = User::factory()->create();
        $service = new TOTPService();
        
        $setup = $service->enableTOTP($user);
        
        $this->assertNotNull($setup['secret']);
        $this->assertNotNull($setup['qr_code']);
        $this->assertCount(8, $setup['recovery_codes']);
        
        // Test verification
        $code = app(Google2FA::class)->getCurrentOtp(decrypt($user->fresh()->two_factor_secret));
        $this->assertTrue($service->verifyTOTP($user, $code));
    }
    
    public function test_sms_otp_flow()
    {
        $user = User::factory()->create(['phone' => '+1234567890']);
        $service = new SMSOTPService();
        
        $code = $service->sendSMSOTP($user);
        
        $this->assertTrue($service->verifySMSOTP($user, $code));
        $this->assertFalse($service->verifySMSOTP($user, $code)); // Should fail second time
    }
}
```

### Integration Tests
```php
class TwoFactorIntegrationTest extends TestCase
{
    public function test_login_flow_with_2fa()
    {
        $user = User::factory()->create([
            'two_factor_enabled' => true,
            'two_factor_secret' => encrypt('TESTSECRET'),
        ]);
        
        // Login con password
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        
        $response->assertRedirect('/auth/two-factor');
        
        // Verifica 2FA
        $code = app(Google2FA::class)->getCurrentOtp('TESTSECRET');
        $response = $this->post('/auth/two-factor', [
            'code' => $code,
            'method' => 'totp',
        ]);
        
        $response->assertRedirect('/patient/dashboard');
        $this->assertAuthenticated();
    }
}
```

## Performance Considerations

### Caching Strategy
- TOTP secrets: Encrypted in database
- SMS codes: Redis cache con TTL
- Recovery codes: Database con encryption
- Rate limiting: Redis con sliding window

### Database Optimization
```sql
-- Indici per performance
CREATE INDEX idx_users_2fa_enabled ON users(two_factor_enabled);
CREATE INDEX idx_security_logs_user_event ON security_logs(user_id, event_type, created_at);
```

## Timeline Implementazione

### Fase 1: Core 2FA (Gennaio 2025)
- [x] TOTP implementation
- [x] SMS OTP service
- [x] Recovery codes
- [ ] UI/UX testing

### Fase 2: Enhanced Security (Febbraio 2025)
- [ ] Risk-based authentication
- [ ] Rate limiting avanzato
- [ ] Push approvals
- [ ] Documentation utente

### Fase 3: Advanced Features (Marzo 2025)
- [ ] Biometric authentication
- [ ] Hardware token support
- [ ] Admin management tools
- [ ] Compliance audit

## Success Metrics

### Security KPIs
- **2FA Adoption Rate**: > 60% utenti attivi
- **Failed Authentication Rate**: < 0.1%
- **Security Incident Reduction**: > 80%
- **User Support Tickets**: < 2% per 2FA

### Performance KPIs
- **TOTP Verification Time**: < 200ms
- **SMS Delivery Time**: < 30s
- **Setup Completion Rate**: > 85%
- **User Satisfaction**: > 4.0/5

## Collegamenti e Backlink

### Documentazione Correlata
- [Torna alla Roadmap Frontoffice](../roadmap_frontoffice.md)
- [Stato Avanzamento 2025](../stato_avanzamento_lavori_2025_06_05.md)
- [Registrazione e Autenticazione](./04-registrazione-autenticazione.md)
- [Security Audit](./32-security-audit.md)
- [Area Personale Paziente](./33-area-personale-paziente.md)

### Risorse Tecniche
- [Security Standards](../standards/security_standards.md)
- [GDPR Compliance](../standards/gdpr_compliance.md)
- [Mobile Guidelines](../standards/mobile.md)

---

*Documento creato: 2 Gennaio 2025*  
*Responsabile: Security Team & Backend*  
*Stato: In Corso (85%)*  
*Prossimo aggiornamento: 15 Gennaio 2025* 
