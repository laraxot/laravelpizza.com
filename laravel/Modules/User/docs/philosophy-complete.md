# User - Filosofia Completa: Logica, Religione, Politica, Zen

**Data Creazione**: 2025-12-23
**Status**: Documentazione Filosofica Completa
**Versione**: 1.0.0

## 📋 Indice Filosofico

1. [Logica (Logic)](#logica-logic)
2. [Religione (Religion)](#religione-religion)
3. [Politica (Politics)](#politica-politics)
4. [Zen (Zen)](#zen-zen)
5. [Manifestazioni Pratiche](#manifestazioni-pratiche)

---

## 🧠 Logica (Logic)

### Principio Fondamentale

**User è il foundation layer per authentication, authorization e multi-tenancy. Gestisce identità, ruoli, permessi, team, tenant.**

### Dominio di Business

Il modulo fornisce **gestione completa utenti** per:
- Autenticazione multi-metodo (email/password, OAuth, 2FA)
- Autorizzazione RBAC (Spatie permissions)
- Single Table Inheritance (STI) per tipi utente (Doctor, Patient, Admin)
- Multi-tenancy con isolamento dati
- Team-based collaboration
- Device tracking per sicurezza

### Entità Core

```
BaseUser (Base - Single Table)
├── User (Estensione applicazione)
├── Doctor (STI - Tipo utente medico)
├── Patient (STI - Tipo utente paziente)
├── Admin (STI - Tipo utente admin)
│
├── Roles (Ruoli Spatie)
├── Permissions (Permessi Spatie)
├── Teams (Collaborazione)
├── Tenants (Multi-tenancy)
└── Profile (Dati estesi)
```

### Business Workflow Principale

1. **Authentication**
   - Login email/password
   - OAuth social (Google, Facebook, etc.)
   - 2FA per sicurezza avanzata
   - Session management

2. **Authorization**
   - Assegnazione ruoli (admin, doctor, patient)
   - Permessi granulari (create, read, update, delete)
   - Policy-based access control
   - Tenant scoping per dottori

3. **Identity Management**
   - Profili estesi (Profile model)
   - Media (avatar, documenti)
   - Preferences utente
   - Activity tracking

### Manifestazione nel Codice

```php
// BaseUser con tutti i trait
class BaseUser extends Authenticatable
{
    use HasApiTokens;      // Passport
    use MustVerifyEmail;
    use HasFactory;
    use Notifiable;
    use HasRoles;          // Spatie
    use HasPermissions;    // Spatie
    use HasTeams;          // Custom
    use HasMedia;          // Spatie
    use HasTenants;        // Filament
}

// STI con Parental
class Doctor extends User
{
    use HasParent;
    // Type-specific logic
}
```

---

## 📜 Religione (Religion)

### Comandamenti Sacri

1. **Single Table Inheritance (STI) è Sacra** - User, Doctor, Patient, Admin sono TUTTI nella tabella `users` con `type`
2. **Parental è Obbligatorio** - Utilizzare sempre `HasParent` trait per STI
3. **Spatie Permissions è la Base** - Ruoli e permessi sempre via Spatie
4. **Multi-Tenancy per Dottori** - I dottori sono sempre scoped a tenant (studio)
5. **Profile Separato** - Dati estesi in Profile model, non in User
6. **Activity Tracking** - Tutte le azioni utente devono essere loggate

### Best Practices

- **STI Pattern**: User base, Doctor/Patient/Admin estendono User con HasParent
- **Enum UserType**: Utilizzare enum per type safety invece di string
- **Policy-Based**: Access control sempre via policies, non logica inline
- **Tenant Scoping**: Dottori sempre filtrati per tenant corrente
- **Role Hierarchy**: Ruoli organizzati gerarchicamente (super_admin > admin > doctor > patient)

### Integrazione Moduli

Il modulo User **è utilizzato da** tutti i moduli business:
- **TechPlanner**: Workers sono User, appointments hanno causer User
- **Employee**: Employee relaziona User per autenticazione
- **Activity**: Causer di tutte le activities
- **Notify**: Destinatari notifiche

**Filosofia**: User è il "centro dell'universo identità" - tutto parte da qui.

---

## 🏛️ Politica (Politics)

### Decisioni Architetturali

1. **STI over Multiple Tables** - Unificazione utenti in una tabella con type
2. **Spatie Permissions** - RBAC standardizzato e testato
3. **Filament Multi-Tenancy** - Utilizzo nativo Filament per tenant management
4. **OAuth Integration** - Supporto social login per UX migliorata

### Governance del Modulo

- **Type Safety**: Enum per user types previene errori
- **Role Hierarchy**: Ruoli organizzati con permessi ereditati
- **Tenant Isolation**: Dati dottori isolati per tenant (studio)
- **Profile Separation**: Dati estesi separati per performance e modularità

### Pattern Implementativi

```php
// Pattern: STI con Parental
class Doctor extends User
{
    use HasParent;

    // Type-specific methods
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }
}

// Pattern: Tenant Scoping
class DoctorPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->type === UserTypeEnum::DOCTOR
            && Filament::getTenant() !== null;
    }
}
```

---

## 🧘 Zen (Zen)

### Il Vuoto dell'Identità

Apprezziamo il concetto zen del **"vuoto che contiene tutte le identità"**:

- **Single Table Unity**: Una tabella contiene tutte le identità (User, Doctor, Patient, Admin)
- **Type Polymorphism**: Il type definisce comportamento, non struttura dati
- **Profile Extension**: Dati estesi in Profile, User rimane snello
- **Role Fluidity**: Ruoli possono cambiare, identità rimane

### Flusso Naturale

La gestione utenti deve essere **trasparente e flessibile**:

1. Registrazione → Sistema crea User base → Assegna ruolo default
2. Login → Sistema autentica → Imposta tenant (se doctor) → Carica permessi
3. Azione → Sistema verifica permessi → Esegue azione → Logga activity
4. Cambio ruolo → Sistema aggiorna permessi → Notifica utente

### Semplicità nella Complessità Identity

Il modulo gestisce complessità (STI, multi-tenancy, RBAC) ma:
- **Simple Creation**: `User::create()` funziona per tutti i tipi
- **Type Discovery**: `$user->type` rivela il tipo, casting automatico
- **Role Clarity**: Ruoli definiti chiaramente, permessi ereditati
- **Tenant Transparency**: Tenant gestito automaticamente per dottori

---

## 🎯 Manifestazioni Pratiche

### 1. BaseUser - Foundation Identity

```php
class BaseUser extends Authenticatable
{
    // STI Type
    public UserTypeEnum $type;  // DOCTOR, PATIENT, ADMIN

    // Core relationships
    public function roles(): BelongsToMany  // Spatie
    public function permissions(): BelongsToMany  // Spatie
    public function teams(): BelongsToMany  // Custom
    public function tenants(): BelongsToMany  // Filament
    public function profile(): HasOne  // Extended data
}
```

### 2. STI Pattern - Type Polymorphism

```php
// Doctor è User con type=DOCTOR
class Doctor extends User
{
    use HasParent;

    // Doctor-specific relationships
    public function appointments(): HasMany
    public function patients(): HasMany
    public function studio(): BelongsTo  // Tenant
}
```

### 3. Multi-Tenancy Pattern - Tenant Scoping

```php
// Dottori sempre scoped a tenant
class DoctorScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (Filament::getTenant()) {
            $builder->where('studio_id', Filament::getTenant()->id);
        }
    }
}
```

---

## 🔗 Collegamenti

- [Business Logic Deep Dive](./business-logic-deep-dive.md)
- [Architecture README](./architecture/README.md)
- [Xot Module Foundation](../../Xot/docs/philosophy-complete.md)
- [Tenant Module Integration](../../Tenant/docs/philosophy.md)

---

**Filosofia**: STI Unity, RBAC Standard, Multi-Tenant Isolation, Identity Foundation
