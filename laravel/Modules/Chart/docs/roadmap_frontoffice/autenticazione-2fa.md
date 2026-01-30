# Autenticazione a Due Fattori (2FA) - In Sviluppo

## Stato Avanzamento
**Completamento**: 🚧 In corso (15% completato)

## Overview

Implementazione di autenticazione a due fattori per aumentare la sicurezza degli account, particolare focus su account provider e pazienti con dati sensibili.

## Implementazione Pianificata

### Step 1: TOTP (Time-based One-Time Password)
```yaml

# TOTP Implementation Plan
Library: PragmaRX/Google2FA per Laravel
QR Code Generation: Endroid/QrCode per setup
Backup Codes: 8 codici di recupero usa-e-getta
Grace Period: 30 giorni per abilitazione graduale
Recovery: SMS backup per utenti che perdono device
```

### Step 2: Integrazione UI/UX
```yaml

# User Experience Design
Setup Flow: Wizard guidato per prima configurazione
QR Code: Generazione e display per app authenticator
Backup Codes: Download sicuro codici di recupero
Verification: Input elegante per codici 6 cifre
Settings: Gestione 2FA da area personale
```

### Step 3: Metodi Supportati
```yaml

# Authentication Methods
Primary: TOTP via app (Google Authenticator, Authy)
Backup: SMS come fallback opzionale
Recovery: Codici di backup statici
Emergency: Reset manuale via supporto con verifica identità
```

## Architettura Tecnica

### Database Schema
```sql
-- Nuova tabella per 2FA settings
CREATE TABLE two_factor_settings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED UNIQUE,
    secret VARCHAR(255), -- TOTP secret (encrypted)
    backup_codes JSON, -- Array di codici backup (hashed)
    enabled_at TIMESTAMP NULL,
    recovery_codes_generated_at TIMESTAMP NULL,
    last_used_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Audit log per tentativi 2FA
CREATE TABLE two_factor_attempts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED,
    ip_address VARCHAR(45),
    success BOOLEAN,
    method ENUM('totp', 'backup_code', 'sms'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### Laravel Implementation (Planned)
```php
// 2FA Service Class
class TwoFactorAuthenticationService
{
    private Google2FA $google2fa;
    
    public function enableTwoFactor(User $user): array
    {
        // Genera secret TOTP
        $secret = $this->google2fa->generateSecretKey();
        
        // Genera QR code per setup
        $qrCode = $this->generateQRCode($user, $secret);
        
        // Genera backup codes
        $backupCodes = $this->generateBackupCodes();
        
        // Salva temporaneamente (non ancora attivo)
        $user->twoFactorSettings()->updateOrCreate([], [
            'secret' => encrypt($secret),
            'backup_codes' => encrypt($backupCodes),
            'enabled_at' => null // Non ancora confermato
        ]);
        
        return [
            'secret' => $secret,
            'qr_code' => $qrCode,
            'backup_codes' => $backupCodes
        ];
    }
    
    public function verifyAndEnable(User $user, string $code): bool
    {
        $settings = $user->twoFactorSettings;
        $secret = decrypt($settings->secret);
        
        if ($this->google2fa->verifyKey($secret, $code)) {
            $settings->update(['enabled_at' => now()]);
            return true;
        }
        
        return false;
    }
}
```

## User Experience Flow

### Setup Process
```yaml

# 2FA Activation Flow
1. User accede alle impostazioni di sicurezza
2. Clicca "Attiva autenticazione a due fattori"
3. Sistema genera QR code e secret
4. User scansiona QR con app authenticator
5. User inserisce codice di verifica per conferma
6. Sistema mostra backup codes per download
7. 2FA attivato e funzionante
```

### Login Flow con 2FA
```yaml

# Enhanced Login Process
1. User inserisce email/password normalmente
2. Se 2FA attivo, redirect a pagina codice
3. User inserisce codice TOTP (6 cifre)
4. Sistema verifica codice con grace period ±30s
5. Se valido, completa login
6. Se invalido, mostra opzioni recovery
```

### Recovery Options
```yaml

# Recovery Methods
Backup Codes: Input manuale codice di backup
SMS Fallback: Invio codice via SMS (se configurato)
Support Reset: Processo manuale con verifica identità
Account Recovery: Reset completo con documentazione
```

## Sicurezza e Compliance

### Security Measures
```yaml

# Enhanced Security
Rate Limiting: Max 5 tentativi 2FA per 15 minuti
Audit Logging: Tutti i tentativi loggati con IP
Secure Storage: Secret e backup codes encrypted
Time Sync: Grace period per differenze orario
Brute Force: Account temporaneamente bloccato dopo 10 tentativi

# Recovery Security
Backup Code Usage: Ogni codice utilizzabile una sola volta
SMS Security: Numero verificato durante setup
Support Verification: Processo rigoroso per reset manuale
```

### Compliance Considerations
- **GDPR**: Consenso esplicito per abilitazione 2FA
- **PCI DSS**: Enhanced security per transazioni
- **Healthcare Standards**: Protezione dati sanitari sensibili
- **Audit Requirements**: Log retention per compliance

## Timeline di Sviluppo

### Fase 1: Core Implementation (4 settimane)
```yaml
Week 1-2: 
  - Database schema e migrations
  - Backend service per TOTP generation/verification
  - Basic API endpoints

Week 3-4:
  - Frontend components per setup flow
  - QR code generation e display
  - Backup codes management
```

### Fase 2: UX Enhancement (2 settimane)
```yaml
Week 5-6:
  - Mobile-optimized interface
  - Enhanced error handling
  - User education e tutorials
  - SMS backup integration
```

### Fase 3: Testing & Deployment (2 settimane)
```yaml
Week 7-8:
  - Security testing e penetration test
  - Load testing per authentication flows
  - Gradual rollout con feature flags
  - Documentation e support training
```

## Testing Strategy

### Security Testing
```yaml

# Test Scenarios
TOTP Timing: Verifica grace period e sincronizzazione
Backup Codes: Utilizzo singolo e invalidazione
Rate Limiting: Protezione contro brute force
Recovery Flow: Processo completo di account recovery
Cross-device: Funzionamento su diversi dispositivi
```

### User Acceptance Testing
- **Setup Flow**: Test con utenti reali per usabilità
- **Error Scenarios**: Comportamento con errori comuni
- **Mobile Experience**: Test su diversi dispositivi mobili
- **Accessibility**: Compatibilità con screen readers

## Metriche di Successo

### Adoption Metrics (Target)
```yaml

# Expected KPIs
2FA Activation Rate: 40% entro 6 mesi
Setup Completion: 85% utenti completano setup
Daily Success Rate: 95% login 2FA riusciti
Support Tickets: <5% richiedono assistenza
User Satisfaction: 4.5/5 rating per UX
```

### Security Impact
- **Account Compromise**: Riduzione 95% account compromessi
- **Unauthorized Access**: Eliminazione accessi non autorizzati
- **Phishing Resistance**: Protezione contro attacchi phishing
- **Compliance Score**: Miglioramento rating sicurezza

## Rischi e Mitigazioni

### Technical Risks
```yaml

# Risk Management
User Lockout: Recovery procedures ben documentate
Device Loss: Backup codes e SMS recovery
Time Sync Issues: Grace period configurabile
Server Load: Caching per verification requests
Adoption Resistance: Gradual rollout e incentivi
```

### Mitigation Strategies
- **Education**: Tutorial e documentazione chiara
- **Support**: Team preparato per assistenza 2FA
- **Flexibility**: Multiple recovery options
- **Testing**: Extensive testing prima del rollout

## Future Enhancements

### Advanced Features (Post-MVP)
```yaml

# Future Roadmap
WebAuthn: Support per FIDO2/hardware keys
Push Notifications: App-based push authentication
Risk-based Auth: 2FA solo per login sospetti
SSO Integration: 2FA per enterprise customers
Biometric: Integrazione con biometric authentication
```

---

## Collegamenti

**📄 Documento Principale**: [Stato Avanzamento Lavori](../stato_avanzamento_lavori_2025_06_05.md)

**🔗 File Correlati**:
- [Registrazione e Autenticazione](./01_registrazione_autenticazione.md)
- [Login e Logout](./login_logout.md)
- [Sicurezza Avanzata](./sicurezza_avanzata.md)

