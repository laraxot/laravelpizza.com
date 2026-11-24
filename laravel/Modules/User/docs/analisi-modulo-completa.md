# Analisi Completa del Modulo User

## Filosofia e Religione del Modulo

User incarna la filosofia della **sovranità digitale dell'identità**. Il suo dogma centrale è che "l'identità non è solo un username, ma un complesso ecosistema di ruoli, permessi, team e tenant". La sua religione è il **principio del minimo privilegio**: ogni utente deve avere esattamente i permessi necessari per svolgere il proprio ruolo, né più né meno.

Il suo "zen" risiede nella sicurezza invisibile: quando funziona bene, gli utenti non si accorgono nemmeno della complessità sottostante. È la porta blindata del sistema che tutti attraversano senza pensare.

## Scopo e Perchè

**Scopo primario**: Gestire l'intero ciclo di vita dell'identità digitale degli utenti, dall'autenticazione (come entri) all'autorizzazione (cosa puoi fare), passando per la gestione di team, tenant, dispositivi e audit trail.

**Perchè esiste**: Senza User, il sistema non saprebbe chi sta usando cosa, e ogni modulo dovrebbe reinventare la ruota dell'autenticazione. È la risposta alla domanda fondamentale "In un sistema multi-tenant, come garantiamo che Marco dell'azienda A non veda mai i dati di Giovanni dell'azienda B?".

## Politica del Modulo

User pratica una politica di **sicurezza paranoica ma trasparente**:

- **Difesa in profondità**: Autenticazione, autorizzazione, audit logging, MFA, blocco account - tutto è stratificato
- **Trasparenza operativa**: Gli utenti devono capire cosa stanno autorizzando (perchè il Gdpr module esiste)
- **Flessibilità tecnica**: Supporta credentials, OAuth, SSO, social login - perchè "non c'è un solo modo di essere utenti"
- **Isolamento ferreo**: I tenant non si parlano mai direttamente tramite User, sempre via Tenant module
- **Profilazione rispettosa**: Raccoglie dati solo per scopi dichiarati e necessari

## Librerie da Installare / Dipendenze Attuali

**Dipendenze attuali** (da composer.json del modulo):
- `laravel/passport` - OAuth2 server
- `laravel/socialite` - Social login (Google, Facebook, etc.)
- `spatie/laravel-permission` - Gestione ruoli e permessi

**Raccomandazioni per migliorare**:
- `spatie/laravel-authentication-log` - Per logging tentativi di accesso (già menzionato nelle docs)
- `bensampo/laravel-email-validator` - Validazione email più rigorosa del default
- `spatie/laravel-2fa` - Per 2FA avanzato con QR codes e backup codes
- `clarkeash/laravel-passport-social-grant` - Per login social via Passport
- `web-token/jwt-framework` - Per JWT custom claims se necessari
- `darkaonline/l5-swagger` - Per documentare API auth in OpenAPI
- `owen-it/laravel-auditing` (alternativa a Activity) - Se serve auditing più granulare del modello
- `spatie/laravel-model-states` - Per gestire stati utente (active, banned, suspended, etc.)

## Future Implementazioni / Roadmap

1. **🔐 Zero-Knowledge Authentication**: Per compliance estrema (utente autentica senza che il server veda la password)
2. **🛡️ Hardware Key Support**: WebAuthn/FIDO2 per autenticazione con chiavi fisiche (YubiKey, etc.)
3. **🤖 ML-based Anomaly Detection**: Detectare login sospetti basati su pattern
4. **🌐 Decentralized Identity (DID)**: Supporto per identità self-sovereign (blockchain-based)
5. **📱 Passwordless Authentication**: Magic links, SMS OTP, biometric
6. **🔄 Session Management avanzato**: Multiple device sessions, forced logout, session hijack detection
7. **🆔 KYC Integration**: Verifica identità per compliance finanziaria/legale
8. **👥 Advanced Team Hierarchies**: Team annidati con ereditarietà di permessi
9. **🔍 User Behavior Analytics**: Tracciare pattern di utilizzo per individuare account compromessi
10. **🌍 Multi-Identity Linking**: Un utente fisico con multiple identità digitali (lavoro, personale, etc.)

## Cosa Fare per Renderlo Perfetto

### Miglioramenti Immediati:
1. **Audit log completo**: Ogni accesso, modifica permesso, cambio ruolo deve essere loggato
2. **Forzare password policies**: Complessità, scadenza, history (no ultime 5)
3. **Account lockout intelligente**: Dopo N tentativi falliti, con sblocco progressivo
4. **Email verification obbligatoria**: Prima dell'attivazione
5. **GDPR Compliance built-in**: Right to be forgotten, data export automatici

### Miglioramenti Medio-termine:
1. **Multi-Factor Authentication avanzato**: TOTP, SMS, backup codes, hardware keys
2. **Risk-based Authentication**: Più fattori per login sospetti (nuovo device, IP, geografia)
3. **Session management dashboard**: Utente vede e revoca le sue sessioni attive
4. **Passwordless flows**: Magic link + biometric
5. **Soccialite providers configurabili**: UI admin per abilitare/disabilitare provider

### Miglioramenti Lungo-termine:
1. **Identity Provider (IdP) nativo**: User diventa un IdP completo
2. **Delegated administration**: Admin locali con scope limitato
3. **User provisioning via SCIM**: Per integrazione enterprise
4. **Privacy-enhancing technologies**: Zero-knowledge proofs, homomorphic encryption per dati sensibili

## Consigli, Dubbi, Perplessità

**Consigli**:
- Non re-inventare l'autenticazione - User module è già complesso abbastanza
- Testare sempre con account "malevoli" durante lo sviluppo (SQL injection, XSS nei campi user)
- Aggiornare Passport regolarmente - vulnerabilità OAuth2 sono frequenti
- Loggare tutto ma loggare bene (no log di password, anche hashed)
- Documentare sempre le policy di password/complexity (per utenti e admin)

**Dubbi**:
- Quanto è importante avere 2FA di default? Alcuni utenti lo trovano fastidioso
- Bcrypt, Argon2i o Argon2id per le password? Argon2id è il vincitore moderno
- JWT vs session-based per le API? Dipende dall'ecosistema
- Come bilanciare self-service (utente cambia email da solo) e sicurezza (verifica sempre)?
- Quando forzare logout di tutte le sessioni dopo cambio password?

**Perplessità comuni**:
- "Perchè Passport e non Sanctum?" - Passport per OAuth2 completo, Sanctum per SPA/API semplici. Dipende dai requisiti
- "Posso usare JWT custom?" - Sì ma perchè? Passport è standard e testato
- "Perchè Spatie Permission e non Policies Laravel?" - Per RBAC granulare con team. Policies per authorization puntuale

## Competitors e Ispirazioni

**Soluzioni simili nell'ecosistema**:
- **Laravel Sanctum** - Più semplice, meno feature ma perfetto per SPA
- **Spatie Laravel Permission** - Il cuore del nostro RBAC
- **Laravel Breeze** - Starter kit autenticazione
- **Laravel Jetstream** - Più opinionated, con team, 2FA, profile photos
- **Filament Shield** - Per gestione permessi in Filament
- **Bouncer** (alternative a Spatie Permission) - Più performante per dataset enormi
- **Laravel Spark** (defunto) - Era una reference per SaaS auth

**Sistemi esterni di ispirazione**:
- **Auth0** - Per architettura di identità moderna, MFA, anomaly detection
- **Okta** - Per enterprise SSO, provisioning, lifecycle management
- **Keycloak** - Open source IAM completo
- **AWS Cognito** - Managed service con scale automatico
- **Firebase Auth** - Per developer experience e mobile
- **Microsoft Entra ID** - Per enterprise integration
- **WordPress User System** - Sorprendentemente completo, ispirazione per semplicità

## Best Practices vs Bad Practices

### Best Practices:
1. ✅ **Hashing forte**: Argon2id con parametri aggiornati
2. ✅ **2FA opzionale ma raccomandato**: Non obbligatorio (UX), ma spinto
3. ✅ **Session regeneration** dopo login (prevent session fixation)
4. ✅ **CSRF protection** su tutti i form (Laravel lo fa di default)
5. ✅ **Rate limiting** su login/register/reset password
6. ✅ **Email verification** prima di attivare account
7. ✅ **Password reset** via token monouso con scadenza (1h max)
8. ✅ **Remember me** con token hashati, non plain
9. ✅ **Audit log** di tutte le azioni sensibili
10. ✅ **No password in logs** - mai, mai, mai

### Bad Practices:
1. ❌ **Mai salvare password in plain text** - ovvio ma succede
2. ❌ **Mai loggare password o token** - neanche hashed
3. ❌ **Mai usare MD5/SHA1** per password
4. ❌ **Mai inviare password via email** - solo reset link
5. ❌ **Mai permettere username enumeration** (login error deve essere generico)
6. ❌ **Mai mettere dati sensibili in JWT** - JWT è decodificabile
7. ❌ **Mai skippare email verification** per "semplicità"
8. ❌ **Mai hardcodare ruoli** - sempre configurabili
9. ❌ **Mai fidarsi del client** - validare sempre server-side
10. ❌ **Mai usare Remember Me token perpetui** - rigenera

## False Friends (traduzioni fuorvianti)

- **"User" ≠ "Utente finale"**: Include admin, operatori, API clients, etc.
- **"Profile" ≠ "Profilo Facebook"**: È un'estensione del modello User, non un social profile
- **"Team" ≠ "Gruppo"**: In Laraxot ha scope specifici su tenant, non è solo raggruppamento
- **"Tenant" ≠ "Customer"**: Tenant è l'isolamento dati, Customer è l'entità business (in TechPlanner)
- **"Permission" ≠ "Feature flag"**: Permission = autorizzazione granulare, Feature flag = on/off di funzionalità
- **"Role" ≠ "Job title"**: Ruolo = insieme di permessi, Job title = etichetta HR
- **"Authentication" ≠ "Authorization"**: Auth = chi sei, Authz = cosa puoi fare
- **"Lockout" ≠ "Ban"**: Lockout = temporaneo per sicurezza, Ban = decisione amministrativa

## Come Usare il Modulo

### Autenticazione Base:
```php
use Illuminate\Support\Facades\Auth;

if (Auth::attempt(['email' => $email, 'password' => $password])) {
    // Auth success
}

if (Auth::check()) {
    $user = Auth::user();
}
```

### Lavorare con Ruoli e Permessi:
```php
use Modules\User\Models\User;

$user = User::find(1);

// Assegnare ruolo
$user->assignRole('admin');
$user->givePermissionTo('edit-articles');

// Verificare
if ($user->hasRole('admin')) { ... }
if ($user->can('edit-articles')) { ... }

// Verificare in Blade
@role('admin')
    <a href="/admin">Admin Panel</a>
@endrole
```

### Multi-Tenant:
```php
// Il modello User ha automaticamente tenant_id se in contesto multi-tenant
$currentTenant = app('currentTenant');
$users = User::where('tenant_id', $currentTenant->id)->get();
```

### Team Management:
```php
$team = Team::create(['name' => 'Engineering']);
$team->users()->attach($user);
```

### 2FA (se abilitato):
```php
// L'utente configura in /user/profile
// Login richiede poi 2FA code dopo password
```

## Come Installarlo

User è già parte di Laraxot. Per installarlo in un nuovo progetto:

1. **Prerequisiti**: Xot module già installato
2. **Composer dependencies**:
   ```bash
   composer require laravel/passport
   composer require laravel/socialite
   composer require spatie/laravel-permission
   ```
3. **Migrazioni e setup**:
   ```bash
   php artisan migrate
   php artisan passport:install
   php artisan db:seed --class="Modules\User\Database\Seeders\RoleSeeder"
   ```
4. **Configurazione**:
   - Aggiungere in `config/auth.php` il guard per User module
   - Configurare `services.php` per Socialite providers
   - Setup email configuration per verifiche/reset
5. **Verifica**:
   ```bash
   php -d memory_limit=-1 ./vendor/bin/phpstan analyse Modules/User --level=max
   ```

## Architettura Dettagliata

### Modelli Principali:
```
User/
├── app/Models/
│   ├── User.php                    # Modello principale
│   ├── BaseUser.php                # Per STI (Single Table Inheritance)
│   ├── Profile.php                 # Profilo esteso
│   ├── Team.php                    # Team management
│   ├── Tenant.php                  # Multi-tenant
│   ├── AuthenticationLog.php       # Log accessi
│   └── Device.php                  # Dispositivi dell'utente
```

### Traits:
- `HasTeams` - Per gestione team (richiede HasRoles)
- `HasTenants` - Per multi-tenancy Filament
- `HasAuthenticationLogTrait` - Per logging tentativi accesso

### Resources Filament:
- `UserResource` - CRUD utenti
- `RoleResource` - CRUD ruoli
- `PermissionResource` - CRUD permessi
- `TeamResource` - CRUD team

### Regole Critiche:
1. **Mai `table_names` modificabili in `config/permission.php`** - pivot singolari (model_has_role)
2. **No Log calls** in Actions/Models/Services - Laravel gestisce
3. **Profiles migration owner = WorkOrder**, non User
4. **Mai mettere User e Tenant in dipendenza circolare**
5. **Mai estendere Filament Resource diretto** - sempre XotBaseResource

## Pattern di Comunicazione

User è il "buttafuori del club" - sta all'ingresso e filtra chi passa:
- **Riceve** richieste da tutti i moduli (chi sei? cosa puoi fare?)
- **Fornisce** middleware, gates, policies a tutti i moduli
- **Non dipende da** business logic (non sa cosa fa TechPlanner)
- **È dipeso da** Xot (sempre) e Tenant (per multi-tenancy)

È un **servizio di infrastruttura pura** - non contiene business logic, solo gestione identità/permessi.