# Product Requirements Document (PRD)

## Metadata

| Campo | Valore |
|-------|--------|
| **Version** | 1.0.0 |
| **Status** | Approved |
| **Last Updated** | 2026-03-03 |
| **Owner** | Core Team |
| **Module** | User |
| **Repository** | laraxot/module_user_fila5 |

---

## 1. Panoramica del Prodotto

### Descrizione Breve
Il modulo User è il sistema centrale per la gestione dell'identità nell'ecosistema Laraxot. Gestisce autenticazione, autorizzazione, ruoli, team, tenant e integrazioni OAuth. È il modulo fondamentale su cui si basano tutti gli altri moduli per l'accesso e i permessi.

### Visione
Fornire un sistema di identity management completo, sicuro e flessibile per applicazioni Laravel/Filament multi-tenant, con supporto nativo per OAuth e autenticazione a più fattori.

### Target Users
- **Amministratori**: gestione utenti, ruoli, permessi
- **Utenti finali**: autenticazione, gestione profilo
- **Sviluppatori**: integrazione con altri moduli

---

## 2. Problema

### Problema Risolto
La gestione dell'autenticazione e autorizzazione in applicazioni Laravel/Filament richiede spesso integrazione manuale di multiple librerie. Questo modulo unifica:

1. **Autenticazione**: Login, logout, reset password, remember me
2. **Autorizzazione**: Ruoli e permessi tramite Spatie
3. **OAuth**: Integrazione con provider esterni (Microsoft, Google, GitHub)
4. **Multi-tenancy**: Identificazione e gestione contesto utente

### Pain Points Attuali
- Frammentazione delle soluzioni di autenticazione
- Difficoltà nell'integrazione OAuth
- Mancanza di standard per gestione ruoli
- Complessità nel supporto multi-tenant
- Assenza di 2FA nativo

### Job Stories

| Quando | Voglio | Per |
|--------|--------|-----|
| Amministratore | creare nuovi utenti | permettere accesso all'applicazione |
| Amministratore | assegnare ruoli agli utenti | controllare cosa possono fare |
| Utente finale | fare login con account Microsoft | non dover creare nuove credenziali |
| Utente finale | abilitare 2FA | aumentare la sicurezza del mio account |
| Sviluppatore | verificare se un utente ha un permesso | controllare l'accesso a funzionalità |
| Amministratore | gestire team di utenti | organizzare utenti per dipartimento |
| Sistema | identificare il tenant corrente | filtrare i dati per tenant |

---

## 3. Stakeholder

| Ruolo | Nome | Responsabilità |
|-------|------|----------------|
| Product Owner | Marco Sottana | Decisioni feature, priorità |
| Tech Lead | | Architettura, decisioni tecniche |
| Backend Developer | | Implementazione API, auth |
| Frontend Developer | | UI Filament, form |
| Security Expert | | Review sicurezza, 2FA |

---

## 4. Soluzione Proposta

### Approccio Architetturale
Il modulo User segue il pattern **Service-Based** con:
- **BaseUser**: Modello Eloquent base con trait per soft deletes, timestamps
- **UserService**: Logica di business per operazioni CRUD
- **AuthService**: Gestione autenticazione e sessioni
- **RoleService**: Gestione ruoli e permessi

### Funzionalità Core

#### 4.1 Autenticazione
- [x] Login con email/password
- [x] Logout
- [x] Reset password via email
- [x] Remember me
- [x] Session management
- [x] Protezione CSRF

#### 4.2 Autorizzazione (Spatie)
- [x] Ruoli (Role)
- [x] Permessi (Permission)
- [x] Direttive Blade (@can, @role)
- [x] Middleware (roles, permissions)
- [x] Model HasRoles trait

#### 4.3 OAuth (Laravel Passport + Socialite)
- [x] Microsoft Azure AD
- [x] Google
- [x] GitHub
- [x] Auth0 (configurabile)
- [x] Token API management

#### 4.4 Two-Factor Authentication
- [x] TOTP (Google Authenticator)
- [x] Backup codes
- [x] QR code setup

#### 4.5 Gestione Team
- [x] Creazione team
- [x] Inviti utenti
- [x] Ruoli a livello team
- [x] Scope team

#### 4.6 Gestione Tenant
- [x] Identificazione tenant da utente
- [x] Scope automatico query
- [x] Middleware tenant

### Flussi Utente

#### Flusso: Login Standard
```
1. Utente accede /login
2. In + password
3.serisce email Sistema valida credenziali
4. Sistema crea sessione
5. Redirect a dashboard
```

#### Flusso: Login OAuth Microsoft
```
1. Utente clicca "Accedi con Microsoft"
2. Redirect a Azure AD
3. Utente autorizza app
4. Callback con code
5. Sistema scambia code per token
6. Crea/aggiorna utente locale
7. Login completato
```

#### Flusso: Assegnazione Ruolo
```
1. Admin accede a User Management
2. Seleziona utente
3. Clicca "Assegna Ruolo"
4. Seleziona ruolo da dropdown
5. Sistema salva relazione
6. Notifica utente (opzionale)
```

---

## 5. Scope

### In Scope (Inclusi)
- [x] Autenticazione email/password
- [x] Reset password
- [x] Ruoli e permessi Spatie
- [x] OAuth Microsoft, Google, GitHub
- [x] Laravel Passport API tokens
- [x] Two-Factor Authentication
- [x] Gestione team
- [x] Gestione profilo utente
- [x] Import/Export utenti

### Out of Scope (Esclusi)
- [ ] LDAP/Active Directory integration
- [ ] SAML SSO
- [ ] Gestione billing
- [ ] Notifiche push

### Non-Goals
- Sistema di login sociale consumer (solo OAuth enterprise)
- Multi-factor con SMS (solo TOTP)
- Single Sign-On esterno

---

## 6. Metriche di Successo

### KPI Tecnici
| KPI | Target | Misura |
|-----|--------|--------|
| PHPStan Level | 10 (0 errori) | `./vendor/bin/phpstan analyse` |
| Test Coverage | >70% | `pest --coverage` |
| Response Time Login | <500ms | Laravel Debugbar |

### KPI Funzionali
| KPI | Target | Misura |
|-----|--------|--------|
| Uptime | 99.9% | Monitoring |
| Failed Login Attempts | <1% | Log analisi |
| 2FA Adoption | >50% entro Q2 | User stats |

### Metriche Qualitative
- Feedback utente su semplicità login
- Ticket supporto per auth issues

---

## 7. Timeline e Milestone

### Milestone
| Milestone | Data Prevista | Deliverable |
|-----------|---------------|--------------|
| M1: Core Auth | Settimana 1-2 | Login, logout, reset password |
| M2: OAuth | Settimana 3-4 | Microsoft, Google, GitHub |
| M3: Roles/Permissions | Settimana 5-6 | CRUD ruoli, middleware |
| M4: 2FA | Settimana 7 | TOTP setup, verifica |
| M5: Teams | Settimana 8 | Gestione team |
| M6: Testing | Settimana 9 | Test coverage >70% |
| M7: Launch | Settimana 10 | Release v1.0 |

### Stima Effort
- Sviluppo: 6-8 settimane
- Testing: 2 settimane
- Buffer: 2 settimane
- **Totale**: ~10 settimane

---

## 8. Dipendenze

### Dipendenze Esterne
| Pacchetto | Versione | Scopo |
|-----------|----------|-------|
| laravel/passport | * | API OAuth |
| spatie/laravel-permission | * | Ruoli e permessi |
| socialiteproviders/microsoft | ^4.8 | OAuth Microsoft |
| socialiteproviders/google | * | OAuth Google |
| socialiteproviders/github | * | OAuth GitHub |
| socialiteproviders/auth0 | * | OAuth Auth0 |
| jenssegers/agent | * | Device detection |
| flowframe/laravel-trend | * | Analytics |

### Dipendenze Interne
| Modulo | Relazione |
|--------|-----------|
| Xot | Dipende (classi base) |
| Tenant | Dipende (scope tenant) |
| UI | Dipende (componenti) |

### Conflitti Potenziali
- Con moduli che usano auth diversa
- Con altri sistemi di ruoli

---

## 9. Risk e Assunzioni

### Rischi
| Rischio | Probabilità | Impatto | Mitigazione |
|---------|-------------|---------|-------------|
| OAuth provider down | Bassa | Alto | Fallback a login standard |
| Token theft | Bassa | Alto | HTTPS only, expiry |
| 2FA lost | Media | Medio | Backup codes |
| Performance con molti ruoli | Media | Basso | Cache, ottimizzazione query |

### Assunzioni
- Utenti hanno accesso a email per reset
- Microsoft Graph API disponibile
- TLS/HTTPS configurato
- PHP 8.2+ disponibile

---

## 10. Domande Aperte

- [ ] Supporto LDAP/AD? (Q2 2026)
- [ ] Implementare SAML? 
- [ ] Notifiche push per login?
- [ ] Login con SPID/CIE?

---

## 11. Appendici

### Riferimenti Tecnici
- [Laravel Passport Docs](https://laravel.com/docs/passport)
- [Spatie Permissions](https://spatie.be/docs/laravel-permission)
- [Laravel Socialite](https://laravel.com/docs/socialite)
- [OAuth 2.0 Microsoft](https://docs.microsoft.com/en-us/azure/active-directory/develop/)

### Glossario
| Termine | Definizione |
|---------|-------------|
| OAuth | Protocollo per autorizzazione |
| 2FA | Autenticazione a due fattori |
| TOTP | Time-based One-Time Password |
| Tenant | Singola istanza nell'app multi-tenant |
| Role | Gruppo di permessi |
| Permission | Singolo permesso |

### Database Schema
```
users
├── id
├── name
├── email
├── password
├── tenant_id (nullable)
├── email_verified_at
├── two_factor_secret
├── two_factor_recovery_codes
└── timestamps

model_has_roles
├── role_id
├── model_type
└── model_id

model_has_permissions
├── permission_id
├── model_type
└── model_id
```

---

## 12. Specifiche Tecniche Dettagliate

### 12.1 API Endpoints

#### Authentication
| Method | Endpoint | Descrizione | Auth |
|--------|----------|-------------|------|
| POST | /api/auth/login | Login email/password | No |
| POST | /api/auth/logout | Logout | Yes (Token) |
| POST | /api/auth/refresh | Refresh token | Yes (Token) |
| POST | /api/auth/forgot-password | Reset password request | No |
| POST | /api/auth/reset-password | Reset password | No |
| POST | /api/auth/oauth/{provider} | Redirect OAuth | No |
| GET | /api/auth/oauth/{provider}/callback | OAuth callback | No |

#### User Management
| Method | Endpoint | Descrizione | Auth |
|--------|----------|-------------|------|
| GET | /api/users | Lista utenti | admin |
| POST | /api/users | Crea utente | admin |
| GET | /api/users/{id} | Dettaglio utente | admin |
| PUT | /api/users/{id} | Modifica utente | admin/user |
| DELETE | /api/users/{id} | Elimina utente | admin |
| GET | /api/users/me | Profilo corrente | user |

#### Roles & Permissions
| Method | Endpoint | Descrizione | Auth |
|--------|----------|-------------|------|
| GET | /api/roles | Lista ruoli | admin |
| POST | /api/roles | Crea ruolo | admin |
| PUT | /api/roles/{id} | Modifica ruolo | admin |
| DELETE | /api/roles/{id} | Elimina ruolo | admin |
| GET | /api/permissions | Lista permessi | admin |
| POST | /api/users/{id}/roles | Assegna ruolo | admin |
| DELETE | /api/users/{id}/roles/{role_id} | Rimuovi ruolo | admin |

#### Two-Factor Authentication
| Method | Endpoint | Descrizione | Auth |
|--------|----------|-------------|------|
| POST | /api/2fa/enable | Abilita 2FA | user |
| POST | /api/2fa/disable | Disabilita 2FA | user |
| POST | /api/2fa/verify | Verifica codice | user |
| POST | /api/2fa/backup-codes | Genera backup codes | user |

#### Teams
| Method | Endpoint | Descrizione | Auth |
|--------|----------|-------------|------|
| GET | /api/teams | Lista team | user |
| POST | /api/teams | Crea team | user |
| GET | /api/teams/{id} | Dettaglio team | team member |
| PUT | /api/teams/{id} | Modifica team | team admin |
| DELETE | /api/teams/{id} | Elimina team | team owner |
| POST | /api/teams/{id}/invite | Invita membro | team admin |
| DELETE | /api/teams/{id}/members/{user_id} | Rimuovi membro | team admin |

### 12.2 Specifiche di Sicurezza

#### Requisiti Password
- Minimo 8 caratteri
- Almeno una lettera maiuscola
- Almeno una lettera minuscola
- Almeno un numero
- Almeno un carattere speciale
- Max tentativi: 5 (lockout 15 minuti)

#### Session Management
- Durata sessione: 120 minuti (configurabile)
- Remember me: 30 giorni
- Timeout inactivity: 30 minuti
- Max sessioni simultanee: 3

#### Token OAuth
- Access token: 60 minuti
- Refresh token: 60 giorni
- Refresh automatico: abilitato

#### Protezioni
- Rate limiting: 10 richieste/minuto
- CSRF: Always enabled
- XSS Protection: Content Security Policy
- SQL Injection: Eloquent parameter binding

### 12.3 Performance Benchmarks

| Operazione | Target | Maximum |
|------------|--------|---------|
| Login | <200ms | 500ms |
| Logout | <50ms | 100ms |
| Get user | <100ms | 200ms |
| List users (paginated) | <500ms | 1s |
| Role check | <10ms | 50ms |
| OAuth redirect | <100ms | 300ms |

### 12.4 Testing Strategy

#### Unit Tests
- User model validation
- Password hashing/verification
- Role permission logic
- Token generation

#### Feature Tests
- Login flow
- Password reset flow
- OAuth flow (mock)
- Role assignment
- Team management

#### Browser Tests
- Login form submission
- 2FA setup flow
- Profile editing

#### Coverage Target
- User model: >90%
- Services: >80%
- Controllers: >70%
- Overall: >70%

### 12.5 Strategia Migrazione

#### Fase 1: Setup
1. Installare modulo User
2. Configurare Passport
3. Impostare provider OAuth

#### Fase 2: Migrazione Dati
1. Esportare utenti esistenti
2. Importare in nuovo schema
3. Verificare password hash

#### Fase 3: Switch
1. Aggiornare routes
2. Aggiornare middleware
3. Monitorare errori

#### Fase 4: Cleanup
1. Rimuovere vecchie tabelle
2. Rimuovere vecchie librerie
3. Documentare cambiamenti

### 12.6 Criteri di Accettazione

#### Autenticazione
- [ ] Utente può registrarsi con email/password
- [ ] Utente può fare login
- [ ] Utente può fare logout
- [ ] Utente può resettare password
- [ ] Sessione scade dopo inactivity
- [ ] Rate limiting funziona

#### OAuth
- [ ] Login Microsoft funziona
- [ ] Login Google funziona
- [ ] Login GitHub funziona
- [ ] Token viene refreshato automaticamente
- [ ] Logout revoca token

#### Autorizzazione
- [ ] Admin può creare ruoli
- [ ] Admin può assegnare ruoli
- [ ] @can directive funziona
- [ ] Middleware blocca accesso

#### 2FA
- [ ] Utente può abilitare 2FA
- [ ] QR code viene visualizzato
- [ ] Verifica TOTP funziona
- [ ] Backup codes funzionano

#### Team
- [ ] Utente può creare team
- [ ] Invito viene inviato
- [ ] Membro può essere rimosso
- [ ] Ruoli team funzionano

---

## 13. UI/UX Specifications

### 13.1 Pagine Filament

#### Login Page
- Email input con validazione
- Password input con toggle visibility
- "Remember me" checkbox
- "Forgot password" link
- Login button
- OAuth buttons (Microsoft, Google, GitHub)

#### Registration Page
- Name input
- Email input
- Password input con strength indicator
- Confirm password
- Terms checkbox
- Register button

#### Profile Page
- Avatar upload
- Name edit
- Email edit
- Password change
- 2FA enable/disable
- Connected accounts

#### User Management (Admin)
- Table con search, filter, sort
- Bulk actions
- Create/Edit modal
- Delete confirmation
- Role assignment inline

#### Role Management (Admin)
- Role list
- Permission matrix
- Create/Edit role
- Assign users to role

### 13.2 Comportamenti

#### Form Validation
- Real-time validation
- Error messages sotto campo
- Loading state durante submit

#### Feedback
- Success toast dopo operazione
- Error toast per fallimenti
- Loading spinner durante API call

#### Navigazione
- Breadcrumbs
- Back button
- Keyboard shortcuts

---

## 14. Monitoraggio e Alert

### 14.1 Metriche da Tracciare

| Metrica | Soglia Warning | Soglia Critical |
|---------|----------------|-----------------|
| Failed logins | >10/min | >50/min |
| Password resets | >20/min | >100/min |
| OAuth errors | >5/min | >20/min |
| 2FA failures | >5/min | >20/min |
| Session timeout | >100/min | >500/min |

### 14.2 Alert Channels

- Email: Admin team
- Slack: #security-alerts
- PagerDuty: Critical only

---

## 15. Compliance e Regolamentazioni

### 15.1 Mappatura Requisiti GDPR

| Requisito | Articolo GDPR | Implementazione |
|-----------|---------------|----------------|
| Minimizzazione dati | Art. 5(1)(c) | Solo dati necessari raccolti |
| Consenso | Art. 7 | Opt-in esplicito |
| Diritti interessato | Art. 15-22 | Export/delete automatici |
| Sicurezza | Art. 32 | Encryption, 2FA, audit log |
| Notifica violazioni | Art. 33 | Procedura incident response |
| Privacy by design | Art. 25 | Default privacy settings |

### 15.2 Audit Trail Requirements

#### Eventi da Tracciare
| Evento | Dati Registrati | Retention |
|--------|-----------------|-----------|
| Login success | user_id, timestamp, IP, device | 2 anni |
| Login failed | email, timestamp, IP, reason | 1 anno |
| Password change | user_id, timestamp, IP | 2 anni |
| 2FA enabled/disabled | user_id, timestamp, IP | 2 anni |
| Role assignment | user_id, role_id, assigned_by, timestamp | 3 anni |
| Permission change | user_id, permission, changed_by, timestamp | 3 anni |
| OAuth connection | user_id, provider, timestamp | 2 anni |
| Account deletion | user_id, deleted_by, timestamp, reason | 3 anni |

#### Accesso Audit Log
- Solo admin con ruolo 'audit_viewer'
- Export solo in formato CSV/PDF con firma digitale
- Retention minima 3 anni

### 15.3 Data Protection Measures

#### Crittografia
| Dato | Metodo | Chiave |
|------|--------|--------|
| Password | bcrypt cost 12 | N/A (salt automatico) |
| Token API | AES-256 | Laravel APP_KEY |
| 2FA secret | AES-256 | Vault dedicato |
| Recovery codes | bcrypt | N/A |
| Session | Encrypted cookie | Laravel session key |

#### Trasmissione
- TLS 1.3 obbligatorio
- HSTS con max-age 31536000
- Certificate pinning per OAuth

### 15.4 Consent Management

#### Categorie Consenso
| Categoria | Descrizione | Default |
|-----------|--------------|---------|
| essential | Funzionamento base | always_on |
| analytics | Statistiche utilizzo | off |
| marketing | Comunicazioni promozionali | off |
| third_party | Condivisione con terzi | off |

#### Lifecycle Consenso
```
1. First visit → Banner mostro categorie
2. User selects → Save preference in cookie + DB
3. Return visit → Load from DB, sync with cookie
4. Preference change → Update both cookie + DB, log event
5. Consent withdrawal → Same as 4, notify admin
```

---

## 16. Integrazioni Estese

### 16.1 OAuth Provider Comparison

#### Microsoft Azure AD
| Criterio | Valutazione | Note |
|----------|-------------|-------|
| Setup complexity | Medio | Richiede Azure portal |
| User attributes | Eccellente | full graph API |
| SSO support | Eccellente | Enterprise SSO |
| MFA support | Eccellente | Conditional Access |
| Pricing | Freemium | 50k MAU free |
| Compliance | SOC2, ISO27001 | Healthcare ready |

#### Google
| Criterio | Valutazione | Note |
|----------|-------------|-------|
| Setup complexity | Basso | Google Cloud Console |
| User attributes | Buono | Limited profile data |
| SSO support | Eccellente | Google Workspace |
| MFA support | Eccellente | 2FA built-in |
| Pricing | Freemium | Unlimited users |
| Compliance | SOC2, ISO27001 | |

#### GitHub
| Criterio | Valutazione | Note |
|----------|-------------|-------|
| Setup complexity | Basso | OAuth app settings |
| User attributes | Medio | Basic profile only |
| SSO support | No | Solo OAuth |
| MFA support | Yes | 2FA support |
| Pricing | Free | |
| Compliance | SOC2 | |

### 16.2 Integrazione HRIS (Human Resource Information System)

#### Scenari di Integrazione
```
HRIS → User Module
    │
    ├── Employee creation → Auto-provisioning account
    ├── Employee termination → Auto-disable account
    ├── Role change → Update permissions
    └── Department change → Update team membership
```

#### API HRIS
```php
// Webhook handler per HRIS events
class HrisWebhookController extends Controller
{
    public function handleEmployeeCreated(Request $request): Response
    {
        $employee = $request->validate([
            'employee_id' => 'required|string',
            'email' => 'required|email',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'department' => 'required|string',
            'role' => 'required|string',
            'start_date' => 'required|date',
        ]);
        
        $user = User::createFromHris($employee);
        
        return response()->json(['user_id' => $user->id]);
    }
    
    public function handleEmployeeTerminated(Request $request): Response
    {
        $employee = $request->validate([
            'employee_id' => 'required|string',
            'termination_date' => 'required|date',
            'reason' => 'required|string',
        ]);
        
        $user = User::findByEmployeeId($employee['employee_id']);
        $user->disableAccount($employee);
        
        return response()->json(['status' => 'success']);
    }
}
```

### 16.3 Integrazione SIEM (Security Information and Event Management)

#### Eventi da Inviare al SIEM
```php
// Log format per SIEM
[
    "timestamp" => "2026-03-03T10:30:00Z",
    "event_type" => "authentication.login",
    "severity" => "info",
    "user" => [
        "id" => 12345,
        "email" => "user@example.com",
        "employee_id" => "EMP001"
    ],
    "source" => [
        "ip" => "192.168.1.100",
        "user_agent" => "Mozilla/5.0...",
        "geo_location" => "IT,45.4642,9.1900"
    ],
    "outcome" => [
        "status" => "success",
        "reason" => null
    ],
    "context" => [
        "tenant_id" => 1,
        "auth_method" => "password",
        "mfa_used" => false
    ]
]
```

#### Integrazione con SIEM
- Supportato: Splunk, Elastic SIEM, Microsoft Sentinel, IBM QRadar
- Transport: syslog (UDP/TCP), HTTP webhook
- Buffer: 1000 eventi o 5 secondi

---

## 17. Capacity Planning e Scalabilità

### 17.1 Modelli di Carico

#### Utenti Concurrent
| Scenario | Utenti | Sessioni | Note |
|---------|--------|----------|------|
| Small | 100 | 50 | Piccolo ente |
| Medium | 1,000 | 500 | Ente medio |
| Large | 10,000 | 5,000 | Grande ente |
| Enterprise | 50,000 | 25,000 | Multi-tenant |

### 17.2 Risorse Necessarie

| Componente | Small | Medium | Large | Enterprise |
|------------|-------|--------|-------|------------|
| Web Server | 1x 2CPU | 2x 2CPU | 4x 4CPU | 8x 4CPU |
| Memory | 2GB | 4GB | 8GB | 16GB |
| Database | 1x Standard | 1x Standard | 2x Performance | 3x Performance |
| Redis | 1x Basic | 1x Standard | 2x Standard | 3x Performance |
| Load Balancer | Included | Included | Application LB | Application LB |

### 17.3 Auto-scaling Rules

```yaml
# Scaling triggers
scale_up:
  - metric: cpu_usage
    operator: ">"
    threshold: 70%
    duration: 5m
  
  - metric: request_latency_p99
    operator: ">"
    threshold: 500ms
    duration: 3m
  
  - metric: active_sessions
    operator: ">"
    threshold: 80%_capacity

scale_down:
  - metric: cpu_usage
    operator: "<"
    threshold: 30%
    duration: 15m
```

### 17.4 Database Optimization

#### Indici Necessari
```sql
-- Users table
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_tenant_id ON users(tenant_id);
CREATE INDEX idx_users_employee_id ON users(employee_id);
CREATE INDEX idx_users_status ON users(status);

-- Sessions table
CREATE INDEX idx_sessions_user_id ON sessions(user_id);
CREATE INDEX idx_sessions_expires ON sessions(expires_at);

-- Password reset tokens
CREATE INDEX idx_password_resets_email ON password_resets(email);
CREATE INDEX idx_password_resets_token ON password_resets(token);
```

#### Query Optimization
- User lookup: usa indici, cache result
- Role check: cache per 5 minuti
- Pagination: cursor-based per grandi dataset

---

## 18. Disaster Recovery e Business Continuity

### 18.1 RPO (Recovery Point Objective)

| Dato | RPO | Note |
|------|-----|------|
| User accounts | 0 | Critico |
| Password hashes | 0 | Critico |
| Sessions | 15 min | Cache |
| Audit logs | 1 ora | Compliance |
| OAuth tokens | 0 | Critico |
| Role assignments | 0 | Critico |

### 18.2 RTO (Recovery Time Objective)

| Componente | RTO | Priorità |
|------------|-----|----------|
| Authentication | 1 ora | P1 - Critico |
| User management | 4 ore | P2 - Alta |
| Password reset | 1 ora | P1 - Critico |
| Reporting | 24 ore | P3 - Media |

### 18.3 Backup Strategy

#### Frequenza Backup
| Tipo | Frequenza | Retention |
|------|-----------|-----------|
| Database full | Giornaliero | 30 giorni |
| Database incremental | Orario | 7 giorni |
| File storage | Giornaliero | 30 giorni |
| Config files | Ogni deploy | 90 giorni |
| Encryption keys | Settimanale | 1 anno |

#### Backup Verification
- Test restore mensile
- Verifica integrità con checksum
- Documentazione procedure

### 18.4 Failover Procedure

```
Incident Detectato
    ↓
Valutazione Severità (P1-P4)
    ↓
Notifica On-Call
    ↓
├─ P1/P2: Escalation immediata
└─ P3/P4: Business hours
    ↓
Isolamento problema
    ↓
├─ Fix disponibile? → Apply fix → Verify → Close
└─ Fix non disponibile? → Rollback/Failover → Monitor
    ↓
Post-Incident Review (entro 48h)
```

### 18.5 Rollback Strategy

| Scenario | Rollback Procedure | Tempo Stimato |
|----------|---------------------|---------------|
| Code deploy | git revert + deploy | 15 min |
| Config change | Restore from backup | 5 min |
| Database migration | Run down migration | 10 min |
| OAuth provider change | Switch provider | 30 min |

---

## 19. Incident Response

### 19.1 Severity Levels

| Level | Definizione | Esempio | Response Time |
|-------|-------------|---------|---------------|
| P1 - Critical | Servizio non funzionante | Login impossibile | 15 min |
| P2 - High | Funzionalità degradata | 2FA non funziona | 1 ora |
| P3 - Medium | Impatto limitato | Notifiche lente | 4 ore |
| P4 - Low | Nessun impatto | UI cosmetic issue | 24 ore |

### 19.2 Communication Plan

| Stakeholder | P1 | P2 | P3 | P4 |
|-------------|----|----|----|----|
| Internal team | Immediate | 1 ora | Daily | Weekly |
| Affected users | Within 1 ora | Within 4 ore | Next update | N/A |
| Management | Immediate | Daily summary | Weekly | N/A |

### 19.3 Post-Incident Activities

1. **Within 24 hours**: Initial timeline documented
2. **Within 48 hours**: Root cause analysis complete
3. **Within 1 week**: Prevention measures identified
4. **Within 2 weeks**: Prevention measures implemented

---

## 20. Acceptance Criteria Dettagliati

### 20.1 Autenticazione - Test Completi

#### Login Email/Password
- [ ] Utente può registrarsi con validazione email
- [ ] Utente può fare login con credenziali corrette
- [ ] Utente riceve errore con credenziali errate
- [ ] Account viene bloccato dopo 5 tentativi falliti
- [ ] Blocco si resetta dopo 15 minuti
- [ ] "Remember me" estende sessione a 30 giorni
- [ ] Sessione scade per inactivity dopo 30 minuti
- [ ] Logout invalida sessione corrente

#### Password Reset
- [ ] Utente può richiedere reset con email
- [ ] Email di reset arriva entro 5 minuti
- [ ] Link reset expires dopo 60 minuti
- [ ] Nuova password deve rispettare requisiti
- [ ] Vecchia password non può essere riutilizzata (ultime 5)
- [ ] Notifica all'utente se password cambiata

#### OAuth
- [ ] Redirect a provider corretto
- [ ] Autorizzazione richiede solo permessi necessari
- [ ] Callback processa token correttamente
- [ ] Utente viene creato/aggiornato con dati provider
- [ ] Token viene refreshato automaticamente
- [ ] Refresh token failure handling funziona

### 20.2 Autorizzazione - Test Completi

#### Roles
- [ ] Admin può creare ruolo con nome e permessi
- [ ] Admin può modificare ruolo esistente
- [ ] Admin può eliminare ruolo (con conferma)
- [ ] Ruolo eliminato rimuove da tutti gli utenti
- [ ] @can directive controlla accesso correttamente
- [ ] @role directive funziona per ruoli multipli
- [ ] Middleware nega accesso senza ruolo richiesto

#### Permissions
- [ ] Permessi possono essere creati/modificati/eliminati
- [ ] Permessi possono essere assegnati a ruoli
- [ ] Permessi possono essere assegnati direttamente a utenti
- [ ] Permessi ruolo + diretti si sommano
- [ ] Permission gate in Laravel funziona

### 20.3 Two-Factor Authentication - Test Completi

#### Setup
- [ ] Utente può iniziare setup 2FA
- [ ] QR code viene generato correttamente
- [ ] Utente può scansionare con app authenticator
- [ ] Codice TOTP viene verificato correttamente
- [ ] Backup codes vengono generati (10 codici)
- [ ] Backup codes sono univoci e validi

#### Uso
- [ ] Login richiede 2FA quando abilitato
- [ ] Codice TOTP accettato una volta sola
- [ ] Clock drift di ±30 secondi tollerato
- [ ] Backup code può essere usato una volta
- [ ] 2FA può essere disabilitato con password

### 20.4 Team Management - Test Completi

- [ ] Owner può creare team
- [ ] Owner può impostare altri membri come admin
- [ ] Membro può invitare altri utenti
- [ ] Invito scade dopo 7 giorni
- [ ] Membro può essere rimosso da admin
- [ ] Owner può abbandonare (trasferendo ownership)
- [ ] Team eliminato rimuove membership

### 20.5 Performance Test Suite

```php
// tests/Performance/AuthPerformanceTest.php

it('login responds within 200ms', function () {
    $this->stopTime();
    
    $response = $this->post('/login', [
        'email' => 'user@example.com',
        'password' => 'password',
    ]);
    
    $duration = $this->startTime();
    expect($duration)->toBeLessThan(200); // ms
});

it('handles 100 concurrent logins', function () {
    $attempts = 100;
    
    $this->markTestSkippedIfRedisNotAvailable();
    
    $futures = [];
    for ($i = 0; $i < $attempts; $i++) {
        $futures[] = $this->async->post('/login', [
            'email' => "user{$i}@example.com",
            'password' => 'password',
        ]);
    }
    
    $results = collect($futures)->map(fn($f) => $f->wait());
    
    expect($results->filter(fn($r) => $r->getStatusCode() === 200))
        ->toHaveCount($attempts);
});
```

---

## 21. Changelog

| Version | Data | Autore | Modifiche |
|---------|------|--------|------------|
| 1.0.0 | 2026-03-03 | | Initial PRD |
