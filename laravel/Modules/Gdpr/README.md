# GDPR Module

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![Filament 5.x](https://img.shields.io/badge/Filament-5.x-blue.svg)](https://filamentphp.com/)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![PHP 8.3+](https://img.shields.io/badge/PHP-8.3+-blue.svg)](https://php.net)
[![Consent Types 14](https://img.shields.io/badge/Consent%20Types-14-purple.svg)](#enum)

> **Compliance GDPR strutturata**: gestione consensi, trattamenti dati, eventi di audit, profili privacy. UUID su tutte le tabelle, crittografia IP/payload, soft deletes per diritto all'oblio.

---

## Cosa fa

Il modulo GDPR gestisce il ciclo di vita della privacy utente: definisce i trattamenti dati (base giuridica, documenti), raccoglie i consensi (obbligatori e facoltativi), traccia ogni evento con IP e payload crittografati, e fornisce il trait `HasGdpr` per aggiungere il consenso a qualsiasi modello Eloquent.

```php
// Trait HasGdpr su qualsiasi modello
$user->giveConsent($treatment, ConsentType::PRIVACY_POLICY);
$user->hasGivenConsent($treatment); // true
$user->getMissingRequiredConsents(); // Collection vuota
$user->revokeConsent($treatment);

// Ogni azione genera un Event crittografato
// Event: { ip: encrypted, payload: encrypted, action: 'consent_given' }

// 14 tipi di consenso tipizzati
ConsentType::PRIVACY_POLICY;     // Obbligatorio
ConsentType::MARKETING_EMAIL;    // Facoltativo
ConsentType::PROFILING;          // Facoltativo
ConsentType::AUTOMATED_DECISION_MAKING; // Facoltativo
```

---

## Architettura

```
Utente/Modello (qualsiasi con HasGdpr trait)
    |
    +-- giveConsent() / revokeConsent()
    |     |
    |     v
    |   Consent (UUID, morphs user, treatment_id, accepted_at)
    |     |
    |     v
    |   Event (UUID, IP encrypted, payload encrypted, action)
    |
    +-- Treatment (base giuridica, documento, versione, peso)
    |
    +-- ConsentType Enum (14 tipi: required + optional)
    |
    v
  GdprData DTO (branding, cookie banner, configurazione tenant)
```

---

## Modelli (4)

| Modello | Funzione |
|---------|----------|
| **Treatment** | Trattamento dati con base giuridica, documento, versione, peso ordinamento |
| **Consent** | Consenso utente: UUID, relazione polimorfa, treatment_id, accepted_at |
| **Event** | Evento audit: IP crittografato, payload crittografato, azione, timestamps |
| **Profile** | Profilo privacy esteso da User module |

Tutti i modelli usano UUID come chiave primaria e soft deletes.

---

## ConsentType Enum (14 tipi)

```php
// Consensi obbligatori
ConsentType::PRIVACY_POLICY
ConsentType::TERMS_AND_CONDITIONS
ConsentType::AGE_VERIFICATION

// Consensi facoltativi
ConsentType::MARKETING_EMAIL
ConsentType::MARKETING_SMS
ConsentType::MARKETING_PHONE
ConsentType::COOKIES
ConsentType::ANALYTICS
ConsentType::PERSONALIZATION
ConsentType::THIRD_PARTY_SHARING
ConsentType::DATA_TRANSFER
ConsentType::RESEARCH
ConsentType::PROFILING
ConsentType::AUTOMATED_DECISION_MAKING
```

Ogni tipo implementa `HasColor`, `HasIcon`, `HasLabel` con traduzioni automatiche.

---

## Trait HasGdpr

```php
use Modules\Gdpr\Models\Traits\HasGdpr;

class User extends BaseModel
{
    use HasGdpr;
}

// API disponibile
$user->consents();                    // morphMany Consent
$user->activeConsents();              // Solo attivi
$user->treatments();                  // hasManyThrough
$user->hasGivenConsent($treatment);   // bool (con cache)
$user->giveConsent($treatment, $type); // Crea Consent + Event
$user->revokeConsent($treatment);     // Revoca + Event
$user->getMissingRequiredConsents();  // Collection
$user->hasAllRequiredConsents();      // bool
```

---

## Filament Integration

| Resource | Funzione |
|----------|----------|
| **ConsentResource** | CRUD consensi utente |
| **TreatmentResource** | Gestione trattamenti dati |
| **EventResource** | Audit trail eventi GDPR |
| **ProfileResource** | Profili privacy |

| Cluster | Funzione |
|---------|----------|
| **Profile** | Raggruppa Consent + Profile in un'unica sezione |

| Pagina | Funzione |
|--------|----------|
| **Dashboard** | Overview stato compliance |
| **EditProfile** | Editing profilo privacy |

---

## Sicurezza

| Feature | Implementazione |
|---------|-----------------|
| **Crittografia IP** | `$casts['ip'] = 'encrypted'` su Event |
| **Crittografia payload** | `$casts['payload'] = 'encrypted'` su Event |
| **UUID** | Tutte le tabelle usano UUID, non auto-increment |
| **Soft deletes** | Diritto all'oblio con `deleted_at` |
| **User tracking** | `created_by`, `updated_by`, `deleted_by` |
| **Policy-based auth** | GdprBasePolicy con super_admin bypass |
| **Cache consensi** | TTL giornaliero per check rapidi |

---

## Configurazione

```php
// config/config.php
'cookie_consent_lifetime' => 365,        // giorni
'retention_policies' => '5-10 years',    // conservazione dati
'dpo_contact' => 'dpo@example.com',      // Data Protection Officer
'security_measures' => [
    'encryption', 'access_control', 'logging'
],

// config/consent.php
'treatments' => [
    ['name' => 'Privacy Policy', 'required' => true, 'weight' => 0],
    ['name' => 'Marketing',      'required' => false, 'weight' => 1],
],
```

---

## Cookie Consent

Il `GdprServiceProvider` registra condizionalmente il `CookieConsentMiddleware` basandosi sulla configurazione `GdprData` del tenant. Il banner cookie si attiva automaticamente sulle rotte web.

---

## Integrazione con altri moduli

```
Gdpr ──> User     (HasGdpr trait su User, profili privacy)
Gdpr ──> Tenant   (configurazione per tenant, GdprData DTO)
Gdpr ──> Activity (audit trail eventi consenso)
Gdpr ──> Lang     (traduzioni ConsentType IT/EN/DE)
Gdpr ──> Notify   (notifiche cambio consenso)
```

---

## Quick Start

```bash
php artisan module:enable Gdpr
php artisan migrate

# Il trait HasGdpr e gia disponibile su User
# I trattamenti si configurano da Filament
```

---

## Metriche

| Metrica | Valore |
|---------|--------|
| **Modelli** | 4 |
| **Filament Resources** | 4 |
| **Filament Cluster** | 1 (Profile) |
| **Pagine standalone** | 2 |
| **Policy** | 5 |
| **Enum** | 1 (14 tipi consenso) |
| **Trait** | 1 (HasGdpr) |
| **DTO** | 1 (GdprData) |
| **Tabelle DB** | 3 (treatment, consent, event) |
| **PHPStan Level** | 10 |

---

## Documentazione

| Guida | Link |
|-------|------|
| **Indice** | [docs/00-index.md](docs/00-index.md) |
| **Architettura** | [docs/architecture.md](docs/architecture.md) |
| **Compliance Roadmap** | [docs/gdpr-compliance-roadmap.md](docs/gdpr-compliance-roadmap.md) |
| **Sicurezza** | [docs/security.md](docs/security.md) |
| **Cookie Consent** | [docs/cookie-consent.md](docs/cookie-consent.md) |

---

**Module Type**: Privacy & Compliance
**Architecture**: UUID tables, encrypted events, HasGdpr trait, ConsentType enum
**Quality**: PHPStan Level 10

*Compliance GDPR by design: consensi tipizzati, eventi crittografati, trait riutilizzabile su qualsiasi modello.*
