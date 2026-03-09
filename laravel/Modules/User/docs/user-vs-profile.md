# User vs Profile Models: Guida Completa

## Panoramica

Questo documento analizza quando usare il modello **User** rispetto al modello **Profile** nel progetto LaravelPizza, basandosi su best practice di settore e architettura specifica del progetto.

---

## 1. Principi Fondamentali

### 1.1 Single Responsibility Principle

```
┌─────────────────────────────────────────────────────────────────┐
│                         USER MODEL                               │
├─────────────────────────────────────────────────────────────────┤
│ Responsabilità: AUTENTICAZIONE e AUTORIZZAZIONE               │
│                                                                 │
│ ✓ email, password, token                                      │
│ ✓ ruoli e permessi (Spatie)                                    │
│ ✓ stato (is_active, type, state)                              │
│ ✓ timestamp (created_at, updated_at, deleted_at)               │
│ ✓ lingua preferita (lang)                                       │
│                                                                 │
│ ✗ NON: dati profilo pubblico, preferenze, avatar              │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│                       PROFILE MODEL                              │
├─────────────────────────────────────────────────────────────────┤
│ Responsabilità: DATI DI PROFILO PUBBLICO                      │
│                                                                 │
│ ✓ first_name, last_name, full_name                            │
│ ✓ avatar, bio, social links                                     │
│ ✓ preferenze, impostazioni UI                                  │
│ ✓ dati demografici (città, nazione, età)                      │
│ ✓ dati specifici del tenant/module                              │
│                                                                 │
│ ✗ NON: credenziali, password, token                           │
└─────────────────────────────────────────────────────────────────┘
```

### 1.2 Separazione dei Dati

| Aspetto | User | Profile |
|---------|------|---------|
| **Autenticazione** | ✅ Sì | ❌ No |
| **Autorizzazione** | ✅ Sì | ❌ No |
| **Dati pubblici** | ❌ No | ✅ Sì |
| **Dati privati** | ✅ Sì | ⚠️ Parziale |
| **Performance auth** | ✅ Critico | Non rilevante |
| **Cache** | ✅ Frequente | Raro |

---

## 2. Casi d'Uso - Decision Matrix

### 2.1 Quando usare SOLO User (90% dei casi)

**Regola**: Se i dati sono necessari per l'autenticazione o l'autorizzazione, **NON** devono essere nel Profile.

```
✅ USA SOLO USER PER:
├── Credenziali (email, password, token)
├── Stato account (is_active, banned, verified)
├── Ruoli e permessi (admin, moderator, user)
├── Tipo account (customer_user, admin, vendor)
├── Lingua preferita (lang)
├── Login tracking (last_login_at)
└── timestamps base (created_at, updated_at)
```

**Esempi pratici:**
```php
// ✅ CORRETTO - Dati di autenticazione nel User
class User extends BaseUser
{
    protected $fillable = [
        'email',
        'password',
        'is_active',
        'type',
        'state',
        'lang',           // lingua preferita
        'email_verified_at',
    ];
}

// ❌ SBAGLIATO - Dati profilo nel User
class User extends BaseUser
{
    protected $fillable = [
        'email',
        'password',
        'avatar',         // NO! È dato di profilo
        'bio',            // NO! È dato di profilo
        'phone',          // NO! È dato di profilo
        'address',        // NO! È dato di profilo
    ];
}
```

### 2.2 Quando usare User + Profile (10% dei casi)

**Regola**: I dati che NON sono necessari per l'autenticazione e che possono variare indipendentemente dal tipo di utente vanno nel Profile.

```
✅ USA USER + PROFILE PER:
├── Dati pubblici (avatar, nome visualizzato, bio)
├── Preferenze utente (tema, notifiche, privacy)
├── Dati demografici (città, paese, fuso orario)
├── Informazioni di contatto estese (phone, social)
├── Dati tenant-specific (team, organizzazione)
├── Storico modifiche (audit trail profilo)
└── Dati opzionali (non richiesti per login)
```

**Esempi pratici:**
```php
// ✅ CORRETTO - Dati profilo nel Profile
class Profile extends BaseProfile
{
    protected $fillable = [
        'user_id',
        'avatar',         // ✅ Dato pubblico
        'bio',            // ✅ Descrizione pubblica
        'phone',          // ✅ Contatto opzionale
        'city',           // ✅ Localizzazione
        'birth_date',    // ✅ Dato demografico
        'timezone',       // ✅ Preferenza
    ];
}
```

---

## 3. Analisi nel Contesto LaravelPizza

### 3.1 Architettura Attuale

```
┌──────────────────────────────────────────────────────────────────┐
│                        LARAVELPIZZA                              │
├──────────────────────────────────────────────────────────────────┤
│                                                                   │
│  ┌─────────────────┐         ┌─────────────────┐              │
│  │      USER       │         │    PROFILE       │              │
│  │   (auth DB)    │  1:1    │   (meetup DB)   │              │
│  ├─────────────────┤         ├─────────────────┤              │
│  │ id (UUID)      │◄────────│ id (UUID)      │              │
│  │ email          │         │ user_id (FK)    │              │
│  │ password       │         │ avatar          │              │
│  │ first_name     │         │ bio             │              │
│  │ last_name      │         │ phone           │              │
│  │ is_active     │         │ city            │              │
│  │ type          │         │ country         │              │
│  │ state         │         │ preferences     │              │
│  │ lang          │         │ extra (JSON)    │              │
│  └─────────────────┘         └─────────────────┘              │
│                                                                   │
│  ⚠️ PROBLEMA: Duplicazione first_name/last_name                │
│                                                                   │
└──────────────────────────────────────────────────────────────────┘
```

### 3.2 Problemi Identificati

**Problema 1: Duplicazione dati**
```
User table:    first_name, last_name
Profile table: first_name, last_name, full_name

❌ Se l'utente aggiorna il nome:
   - Devo aggiornare entrambe le tabelle
   - Rischio inconsistenza
   - Più query
```

**Problema 2: Confusione sulle responsabilità**
```
CURRENT STATE:
├── User: contains first_name, last_name (also in Profile)
├── Profile: contains first_name, last_name (also in User)
└── Confusion: quale usare per auth? quale per display?
```

### 3.3 Soluzione Raccomandata

**Opzione A: Consolidare in User (Simple) - CONSIGLIATA PER LARAVELPIZZA**

Per un progetto community come LaravelPizza dove:
- Gli utenti sono principalmente "attendees" agli eventi
- Non servono profili multipli
- L'avatar è l'unico dato profilo essenziale

```php
// ✅ CONSIGLIATO: User con dati essenziali + Profile minimal
User (user connection):
├── id, email, password (auth)
├── first_name, last_name (display)
├── type, state, is_active (status)
└── lang (preferenza)

Profile (meetup connection):
├── id, user_id (relation)
├── avatar (opzionale)
├── bio (opzionale)
└── extra (JSON per estensioni)
```

**Percentuali di utilizzo stimete:**
- **User-only**: 80% delle operazioni (login, check permessi, display name)
- **Profile + User**: 15% delle operazioni (avatar, preferenze)
- **Solo Profile**: 5% (dati opzionali mai necessari all auth)

---

## 4. Best Practice di Implementazione

### 4.1 Regole Golden

```
┌─────────────────────────────────────────────────────────────────┐
│                    REGOLE GOLDEN                                │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│ 1. ✅ User per TUTTO ciò che serve per:                         │
│    ├── Login/logout                                             │
│    ├── Verifica account                                         │
│    ├── Controllo ruoli/permessi                                 │
│    ├── Display name in header                                   │
│                                                                  │
│ 2. ✅ Profile per TUTTO ciò che è:                              │
│    ├── Pubblico (visibile ad altri utenti)                     │
│    ├── Opzionale (non richiesto per registrarsi)               │
│    ├── Estensibile (può cambiare nel tempo)                    │
│    └── Tenant-specific (dati dell'organizzazione)                │
│                                                                  │
│ 3. ❌ MAI mettere nel Profile:                                  │
│    ├── Password o hash                                          │
│    ├── Token API                                                │
│    ├── Ruoli/permessi (usa Spatie sul User)                     │
│    └── Dati sensibili per autenticazione                         │
│                                                                  │
│ 4. ❌ MAI mettere nel User (usa Profile):                      │
│    ├── Avatar (file binario, меняется часто)                   │
│    ├── Bio/descrizione                                          │
│    ├── Preferenze UI                                            │
│    └── Dati che potrebbero non esistere                         │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

### 4.2 Accesso ai Dati

```php
// ✅ CORRETTO: Accesso ai dati utente
class UserController
{
    public function showProfile(User $user)
    {
        // Dati autenticazione (User)
        $email = $user->email;
        $isActive = $user->is_active;
        $type = $user->type;
        
        // Dati profilo (Profile)
        $avatar = $user->profile->avatar;
        $bio = $user->profile->bio;
        
        // Display name - fallback a User se Profile non esiste
        $displayName = $user->profile->full_name 
            ?? $user->first_name 
            ?? $user->email;
    }
}

// ❌ SBAGLIATO: Accedere a dati profilo senza controllare
class UserController
{
    public function showProfile(User $user)
    {
        // Questo può fallire se Profile non esiste!
        $avatar = $user->profile->avatar; // ⚠️ Potrebbe essere null
        
        // ✅ CORRETTO: Usare optional() o exists check
        $avatar = optional($user->profile)->avatar;
    }
}
```

---

## 5. Performance Considerations

### 5.1 Query Optimization

```
┌─────────────────────────────────────────────────────────────────┐
│                    PERFORMANCE MATRIX                           │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│ Operation              │ User Only │ User+Profile │ Winner      │
│───────────────────────┼────────────┼──────────────┼────────────│
│ Login check            │     1      │       2      │ User Only  │
│ Permission check       │     1      │       2      │ User Only  │
│ Display user info      │     1      │       2      │ User Only  │
│ Show avatar            │     -      │       1      │ Profile    │
│ Update preferences     │     -      │       1      │ Profile    │
│ Export user data GDPR │     1      │       2      │ User Only  │
│                                                                   │
│ RECOMMENDATION:                                                    │
│ - Carica Profile solo quando necessario                          │
│ - Usa eager loading: User::with('profile')->find($id)          │
│ - Cache avatar separatamente                                     │
│                                                                   │
└─────────────────────────────────────────────────────────────────┘
```

### 5.2 Eager Loading Pattern

```php
// ✅ CORRETTO: Eager loading per evitare N+1
$users = User::with('profile')->where('is_active', true)->get();

// ✅ CORRETTO: Lazy loading solo quando serve
$avatar = $user->profile?->avatar;

// ❌ SBAGLIATO: Query in loop
foreach ($users as $user) {
    echo $user->profile->avatar; // N+1 query!
}
```

---

## 6. Migration Strategy

### 6.1 Aggiungere Campo: Decision Tree

```
┌─────────────────────────────────────────────────────────────────┐
│                 ADDING NEW FIELD DECISION TREE                 │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│ "Devo aggiungere un nuovo campo utente"                         │
│                          │                                      │
│          ┌───────────────┴───────────────┐                      │
│          ▼                               ▼                      │
│   È per autenticazione?          È per profilo pubblico?        │
│   (login, permessi, stato)      (visibile ad altri)          │
│          │                               │                      │
│     ┌────┴────┐                  ┌────┴────┐                  │
│     ▼         ▼                  ▼         ▼                  │
│    YES       NO                 YES        NO                 │
│     │         │                   │          │                 │
│     ▼         ▼                   ▼          ▼                 │
│  ┌─────┐  ┌─────┐            ┌─────┐   ┌─────────────┐        │
│  │USER │  │PROFILE│           │PROFILE│  │USER (solo   │        │
│  │     │  │      │           │       │  │se richiesto │        │
│  │     │  │      │           │       │  │per display) │        │
│  └─────┘  └─────┘           └─────┘   └─────────────┘        │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

### 6.2 Esempi Pratici

```php
// ✅ CASO 1: Nuovo campo per autenticazione → User
// Esempio: campo per Two-Factor Authentication
$this->addColumn('users', 'two_factor_enabled', 'boolean');

// ✅ CASO 2: Nuovo campo profilo pubblico → Profile  
// Esempio: campo per bio o descrizione
$this->addColumn('profiles', 'bio', 'text');

// ✅ CASO 3: Campo che può essere NULL per alcuni utenti → Profile
// Esempio: data di nascita (non obbligatoria)
$this->addColumn('profiles', 'birth_date', 'date');

// ✅ CASO 4: Campo necessario per display fallback → User + Profile
// Esempio: display_name
$this->addColumn('users', 'display_name', 'string'); // fallback
$this->addColumn('profiles', 'display_name', 'string'); // override
```

---

## 7. Anti-Patterns da Evitare

### 7.1 Anti-Pattern Comuni

```
┌─────────────────────────────────────────────────────────────────┐
│                    ANTI-PATTERNS                                │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│ ❌ ANTI-PATTERN 1: Profile con dati di auth                    │
│    Profile: { password_hash, reset_token, ... }                │
│    → MAI fare! Violazione single responsibility                 │
│                                                                  │
│ ❌ ANTI-PATTERN 2: User con 50+ campi profilo                 │
│    User: { first_name, last_name, phone, address, bio,        │
│           avatar, twitter, linkedin, birthday, company, ... }   │
│    → Troppo grande! Usa Profile per dati estesi                 │
│                                                                  │
│ ❌ ANTI-PATTERN 3: Duplicazione non necessaria                 │
│    User: { first_name } + Profile: { first_name }               │
│    → Confuso! Scegli UNA fonte (consigliato: User)            │
│                                                                  │
│ ❌ ANTI-PATTERN 4: Profile senza User                            │
│    Profile esiste ma User no                                    │
│    → Non ha senso! Profile richiede User                        │
│                                                                  │
│ ❌ ANTI-PATTERN 5: JOIN su ogni query                          │
│    $user = User::with('profile')->first() per ogni operazione │
│    → Overhead! Carica profile solo quando serve                 │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

### 7.2 Codice Sbagliato vs Corretto

```php
// ❌ SBAGLIATO: Profile con dati di auth
class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'password_reset_token',    // ❌ NO! Dato sensibile
        'password_reset_expires',  // ❌ NO!
    ];
}

// ✅ CORRETTO: Profile solo per dati pubblici
class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'avatar',                  // ✅ Dato pubblico
        'bio',                    // ✅ Dato pubblico
        'phone',                  // ✅ Dato di contatto
    ];
}

// ❌ SBAGLIATO: User con troppi campi
class User extends Authenticatable
{
    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'avatar',                 // ❌ NO! Dovrebbe essere in Profile
        'bio',                    // ❌ NO!
        'phone',                  // ❌ NO!
        'address',                // ❌ NO!
        'company',                // ❌ NO!
        'job_title',              // ❌ NO!
    ];
}

// ✅ CORRETTO: User minimal, Profile esteso
class User extends Authenticatable
{
    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'type',
        'state',
        'is_active',
        'lang',
    ];
}
```

---

## 8. Checklist per Sviluppatori

### Prima di aggiungere un nuovo campo:

- [ ] **È per autenticazione?** → User
- [ ] **È per autorizzazione (ruoli/permessi)?** → User  
- [ ] **È necessario per il login?** → User
- [ ] **È visibile pubblicamente ad altri utenti?** → Profile
- [ ] **È opzionale (utente può non averlo)?** → Profile
- [ ] **Potrebbe cambiare indipendentemente dall'account?** → Profile
- [ ] **È un dato sensibile (password, token)?** → MAI in Profile

---

## 9. Riferimenti

- [Django Best Practices: User vs Profile](https://stackoverflow.com/questions/29573138/django-extending-user-model-vs-creating-user-profile-model)
- [Stack Overflow: Separation of User and Profile](https://stackoverflow.com/questions/3395853/why-is-separation-of-user-and-profile-data-considered-good)
- [Supabase: User Profiles Best Practices](https://forem.com/jais_mukesh/should-you-extend-supabase-auth-with-user-profiles-2hon)
- [DEV.to: Multi-Role User Design](https://dev.to/kolardev/designing-a-user-model-for-multiple-roles-without-losing-your-mind-4boh)

---

## 10. Summary

| Scenario | Scelta | Percentuale |
|----------|--------|-------------|
| Dati login/auth | **Solo User** | 70% |
| Dati visualizzazione | **User + Profile** | 20% |
| Dati opzionali/estesi | **Solo Profile** | 10% |

**Regola finale**: 
> "Quando hai dubbi, chiediti: 'Questo dato serve per fare login o per visualizzare il profilo?' 
> - Login/permessi → **User**
> - Visualizzazione → **Profile**"

---

*Documento generato per LaravelPizza - Progetto Community Laravel*
