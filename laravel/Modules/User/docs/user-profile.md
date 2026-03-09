# User vs Profile: Guida Completa alla Progettazione

## Sommario
1. [Introduzione](#introduzione)
2. [Analisi del Codice Attuale](#analisi-del-codice-attuale)
3. [Best Practice Raccolte](#best-practice-raccolte)
4. [Casi d'Uso con Percentuali](#casi-duso-con-percentuali)
5. [Raccomandazioni per LaravelPizza](#raccomandazioni-per-laravelpizza)
6. [Schema Decisionale](#schema-decisionale)

---

## Introduzione

La separazione tra **User** (tabella per autenticazione) e **Profile** (tabella per dati aggiuntivi) è un pattern comune nei sistemi software. Tuttavia, la decisione di quando usare entrambi vs solo User dipende da molti fattori.

---

## Analisi del Codice Attuale

### Struttura Attuale LaravelPizza

```
User (connection: user)
├── id (UUID)
├── name
├── first_name
├── last_name  
├── email
├── password
├── lang
├── type (customer_user)
├── state (active)
├── profile_photo_path
├── is_active
├── is_otp
├── password_expires_at
├── email_verified_at
├── timestamps
└── SoftDeletes

Profile (connection: user)
├── id (bigint autoincrement)
├── uuid (char 36 unique, per Android/Postgres/API)
├── user_id (UUID)
├── first_name
├── last_name
├── fiscal_code
├── phone
├── email
├── notes
├── timestamps
└── SoftDeletes
```

### Relazione Attuale
```php
// In User model
public function profile(): HasOne
{
    return $this->hasOne(Profile::class);
}
```

---

## Best Practice Raccolte

### Vantaggi di TENERE i dati nella tabella User (Single Table)

| Vantaggio | Descrizione |
|-----------|-------------|
| **Semplicità queries** | Un solo join per ottenere tutti i dati utente |
| **Unified authentication** | Email, password, token in un'unica tabella |
| **Performance** | Meno join = query più veloci |
| **Atomicità** | Transazioni atomiche senza problemi di consistenza |
| **Cache semplificata** | Cache dell'utente senza relazioni |

### Vantaggi di SEPARARE Profile

| Vantaggio | Descrizione |
|-----------|-------------|
| **Separazione responsabilità** | Dati auth vs dati applicativi separati |
| **Modularità** | Profile può essere esteso da moduli diversi |
| **sicurezza** | Profile può avere permessi diversi da User |
| **Performance** | Query auth più leggere (meno campi) |
| **Vertical Partitioning** | Dati rari separati dai dati frequenti |
| **Multi-tenancy** | Profile può essere in connection diversa |

### Quando USARE Profile Separato

1. **Dati specifici del dominio**
   - Meetup: fiscal_code, phone, notes
   - E-commerce: indirizzi, preferenze shipping
   - Social: bio, avatar, social links

2. **Dati che cambiano frequentemente**
   - Statistiche utente
   - Preferenze UI
   - Activity logs

3. **Dati sensibili separati**
   - Informazioni mediche
   - Dati finanziari
   - Documenti ID

4. **Multi-tenant scenarios**
   - Profile in database tenant-specifico
   - User in database condiviso

### Quando USARE SOLO User

1. **Applicazioni semplici**
   - Solo autenticazione base
   - Pochi campi utente (< 20)

2. **Performance critiche**
   - High traffic
   - Cache semplificata

3. **Prototipi rapidi**
   - MVP
   - Proof of concept

---

## Casi d'Uso con Percentuali

### Caso 1: Community Platform (es. LaravelPizza)
```
User: 60% dei dati necessari
- id, email, password, name, lang, type, state
- Timestamps, remember_token

Profile: 40% dei dati necessari  
- first_name, last_name (duplicati per historic reasons)
- fiscal_code, phone, notes
- Dati specifici meetup
```

**Raccomandazione**: ✅ Separare ha senso perché:
- Meetup module ha dati specifici
- Profile in connection separata (meetup)
- Possibile evoluzione futura

**Percentuale di utilizzo**: 70% User, 30% Profile

---

### Caso 2: E-commerce Basic
```
User: 90% dei dati necessari
- name, email, phone, address, preferred_payment

Profile: 10% (forse mai usato)
```

**Raccomandazione**: ❌ Non separare - basta User

**Percentuale di utilizzo**: 95% User, 5% Profile

---

### Caso 3: SaaS Multi-tenant
```
User (shared db): 
- id, email, password, tenant_id
- Dati minimi per autenticazione

Profile (tenant db):
- Tutti i dati business
- Dati sensibili
```

**Raccomandazione**: ✅ Separare è quasi obbligatorio

**Percentuale di utilizzo**: 20% User, 80% Profile

---

### Caso 4: Social Network
```
User: 30% dei dati
- id, email, password, username

Profile: 70% dei dati
- bio, avatar, cover_image
- social_links (many)
- follower/following counts
- privacy_settings
- notification_preferences
```

**Raccomandazione**: ✅ Separare ha senso

**Percentuale di utilizzo**: 30% User, 70% Profile

---

## Schema Decisionale

```
START
  │
  ├─> L'applicazione richiede dati utente specifici del dominio?
  │     │
  │     ├─> NO → Usa solo User
  │     │
  │     └─> SI → I dati sono tanti (> 15 campi extra)?
  │           │
  │           ├─> NO → Usa solo User (o JSON column)
  │           │
  │           └─> SI → I dati sono in connection/database diversa?
  │                 │
  │                 ├─> NO → Considera se ne vale la pena
  │                 │
  │                 └─> SI → ✓ USA PROFILE SEPARATO
  │
  ├─> Hai requisiti di sicurezza separati?
  │     │
  │     └─> SI → ✓ USA PROFILE SEPARATO
  │
  ├─> Multi-tenant application?
  │     │
  │     └─> SI → ✓ USA PROFILE SEPARATO
  │
  └─> Performance critiche + dati minimali?
        │
        └─> SI → Usa solo User
```

---

## Raccomandazioni per LaravelPizza

### Attuale (CORRETTO)

| Aspetto | Decisione | Percentuale |
|---------|----------|-------------|
| User | Connection 'user' | 70% access |
| Profile | Connection 'meetup' | 30% access |

### Problemi Identificati

1. **Duplicazione dati**: `first_name` e `last_name` sono in ENTRAMBE le tabelle
2. **N+1 Query**: `$user->profile` può causare query extra
3. **Confusione**: Quando usare `$user->name` vs `$user->profile->first_name`

### Soluzioni Raccomandate

#### Opzione A: Consolidamento (Consigliata per semplicità)

```
User (tutto in una tabella):
├── id, email, password
├── first_name, last_name  ← SPOSTATI DA PROFILE
├── lang, type, state
├── fiscal_code, phone     ← CAMPI SPECIFICI MEETUP
├── profile_photo_path
└── timestamps + soft_deletes

Profile: SOLO per estensioni future
```

**Pro**: Semplice, meno query, meno confusione
**Contro**: Profile diventa ridondante

#### Opzione B: Separation Chiara (Mantenere attuale)

```
User: Solo dati autenticazione
├── id (UUID)
├── email
├── password (hash)
├── name (display name)
├── lang
├── type
├── state
├── remember_token
├── timestamps
└── soft_deletes

Profile: Tutti i dati applicativi
├── user_id (FK)
├── first_name
├── last_name
├── fiscal_code
├── phone
├── notes
└── timestamps
```

**Pro**: Chiara separazione responsabilità
**Contro**: Più complesso, potenziali N+1

### Regole Pratiche

1. **Per dati auth** (login, email, password, token) → **User**
2. **Per dati visualizzazione** (name, avatar) → **User** (cache-friendly)
3. **Per dati business specifici** (fiscal_code, phone, notes) → **Profile**
4. **Per dati che possono essere NULL per molti utenti** → **Profile** (evita spazio sprecato)

---

## Quick Reference

| Scenario | Usa | Note |
|----------|-----|------|
| LaravelPizza attuale | User + Profile | Profile in meetup DB |
| MVP semplice | Solo User | Tutto in una tabella |
| SaaS multi-tenant | User + Profile | Profile per tenant |
| Social network | User + Profile | Profile ricco |
| Blog personale | Solo User | Pochi campi |

---

## Conclusione

Per **LaravelPizza** la separazione attuale ha senso perché:
- ✅ Profile è in connection separata (meetup)
- ✅ Meetup module ha dati specifici
- ✅ Possibile estensione futura (altri moduli)

**Tuttavia**: Evitare duplicazione `first_name`/`last_name` e usare regola chiara:
- `$user->name` per display
- `$user->profile->first_name` solo quando necessario

---

*Documento generato per LaravelPizza - Analisi User vs Profile Pattern*
*Data: [DATE]*
