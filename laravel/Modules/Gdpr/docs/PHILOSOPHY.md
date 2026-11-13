---
title: "GDPR Module Philosophy"
description: "Core principles, architecture, and compliance philosophy of the FixCity GDPR module"
type: philosophy
domain: gdpr
tags: [gdpr, privacy, compliance, consent, philosophy]
created: 2026-09-06
updated: 2026-09-06
---

# GDPR Module Philosophy

> Privacy is not a checkbox. It is an infrastructure decision, a code pattern, and a cultural commitment. This module embodies that belief.

---

## Religione (Core Dogmas)

### Commandment 1: Consent is Sovereign

Every use of personal data must rest on explicit, documented consent. Not "we have a privacy policy" — actual proof that the data subject accepted the specific treatment at a specific moment.

- Consent is granular: each "treatment" (marketing, analytics, profiling) has its own consent.
- Consent is revocable: a user can withdraw it at any time.
- Consent is timestamped and audited: when, where (IP), what device (user agent), who approved.
- Consent is refused by default: opt-in, never opt-out.

### Commandment 2: Privacy by Design is Non-Negotiable

Privacy must be engineered into the system from day one. Not a post-hoc compliance layer.

- Collect only what you need.
- Encrypt sensitive metadata (IP, payload) at rest.
- Audit every access and modification.
- Separate data minimisation from data retention.
- Make deletion irreversible and complete.

### Commandment 3: The Audit Trail is Sacred

If a regulator (or a citizen) asks "prove you had their consent," you must produce that proof. This module builds that proof automatically.

- Every consent decision is an immutable Event.
- Event contains: timestamp, treatment, acceptance state, IP, user agent, payload.
- Events are encrypted to prevent casual inspection.
- Events survive soft deletes (consents can be withdrawn, events remain).

### Commandment 4: Data Subject Rights Must Be Code

GDPR Article 15–21 (access, rectification, erasure, restriction, portability, objection) are not legal abstractions. They are methods on models.

- Users can see every treatment they consented to.
- Users can request a portable copy of all data linked to them.
- Users can revoke consent with one click.
- Operators can purge historical records within retention windows.

### Commandment 5: Separation of Concerns

GDPR compliance logic lives here, in a dedicated, testable, upgradeable module. Not scattered across User, Auth, or other domains.

- Treatment (what data is used for).
- Consent (proof the subject allowed it).
- Event (audit trail).
- Profile (consent holder identity).

---

## Filosofia (Design & Architecture)

### Why a Separate Module?

Because privacy is a **cross-cutting concern** that touches every other module but belongs to no single one.

- User module handles identity.
- Activity module handles system events.
- Gdpr module handles the consent and compliance layer that governs how User and Activity data can be used.

This is **privacy by architecture**: force all access to personal data through consent checks, not as an afterthought.

### Privacy by Design in Practice

1. **Minimise at Source**
   - Only collect data that unlocks a feature.
   - The registration form asks for {name, email} because authentication needs it — not because we want a database.

2. **Encrypt Sensitive Metadata**
   - IP addresses are encrypted at rest (Consent.ip_address, Event.ip).
   - Event payloads are encrypted (Event.payload).
   - Prevents casual inspection by junior developers or leaked backups.

3. **Audit Immutability**
   - Events are append-only.
   - Consent can be withdrawn (logical delete), but the Event record remains.
   - "We had their consent on 2025-03-15" cannot be erased retroactively.

4. **Separation of Consent Logic from Feature Logic**
   - SaveGdprConsentsAction is independent of AuthController.
   - Email campaigns check Consent.where('type', 'marketing_email')->whereNotNull('accepted_at').
   - No magic; no implicit assumptions about what "consent" means.

### Relationship to FixCity

In FixCity (a public digital services platform):

- Users trust the system with location data (reports), contact info, device info.
- That trust is governed by transparent consent.
- If FixCity uses location data for analytics, the user must have accepted "analytics".
- If FixCity shares reports with municipal departments, the user must have accepted "data_transfer".
- If a user wants their data deleted, FixCity must delete it (with a retention window for audit).

This module makes that governance **testable** and **auditable**.

---

## Politica (GDPR Compliance Rules)

### Pillars of Gdpr Compliance (Simplified)

| Article | Rule | Implementation |
|---------|------|-----------------|
| **Art. 4–5** | Lawfulness, fairness, transparency | ConsentType enum, Treatment configuration, cookie banner |
| **Art. 6** | Legal basis for processing | Consent model tracks accepted_at per Treatment |
| **Art. 13–14** | Data subject information | Privacy policy URL in Treatment.documentUrl, Profile resource in Filament |
| **Art. 15** | Right of access (SAR) | ProfileResource in Filament, export API (planned) |
| **Art. 17** | Right to be forgotten (erasure) | Soft delete on Consent, purge Events within retention window |
| **Art. 18** | Right to restrict processing | Consent revocation (accepted_at = null) |
| **Art. 19** | Duty to notify | Activity module logs consent changes (planned integration) |
| **Art. 20** | Right to data portability | Export user data + consents as JSON (planned) |
| **Art. 21** | Right to object | Revoke consent endpoint |
| **Art. 32** | Security measures | Encryption of IP + payload, signed consents, audit trail |
| **Art. 33–34** | Breach notification | Activity logs provide audit trail for breach investigation |

### Consent Types and Requirements

```php
ConsentType enum defines:
- MARKETING_EMAIL, MARKETING_SMS, MARKETING_PHONE → optional
- PRIVACY_POLICY, COOKIES, ANALYTICS → depends on use case
- PERSONALIZATION, PROFILING, AUTOMATED_DECISION_MAKING → optional but high-trust
- TERMS_AND_CONDITIONS, AGE_VERIFICATION → required for registration
- DATA_TRANSFER, THIRD_PARTY_SHARING → required if applicable
```

Each Treatment is a row in config/consent.php with:
- name: machine-readable identifier
- description: user-facing text (translated)
- required: bool (show checkbox, block registration if not accepted)
- active: bool (allow new consents for this treatment)
- documentVersion: v1.0, v1.1 (track policy changes)
- documentUrl: link to full text (legal cover)
- weight: UI sort order

### Data Retention and Deletion

**Retention Windows** (configurable per treatment):
- PRIVACY_POLICY: permanent (must show we had consent for core feature)
- MARKETING_EMAIL: 2 years (GDPR recital 32 guidance)
- ANALYTICS: 12 months (Google Analytics default)
- EVENT audit trail: 3 years (PA audit requirements in Italy)

**Deletion Cascade** (when user requests erasure):
1. Soft-delete Profile records (retain for 90 days if disputed).
2. Soft-delete Consent records (retain Event history).
3. Keep Event records encrypted for audit.
4. Purge Activity logs older than retention window.
5. Purge user-identifiable data from Device, DeviceUser.

**Immutability Rule**: Once a retention window expires, data is hard-deleted and unrecoverable.

### Consent Mechanics

**Registration Flow** (via Filament RegisterWidget):
1. User checks "I accept privacy policy" (required).
2. User checks "I accept marketing emails" (optional).
3. SaveGdprConsentsAction creates Consent records for each treatment.
4. Event audit trail records the timestamp, IP, user agent.

**Revocation Flow**:
1. User clicks "Withdraw consent for marketing emails" in profile.
2. Consent.accepted_at is set to null (soft revoke, not delete).
3. Event records "revoked" action with timestamp, IP.
4. Email system checks whereNotNull('accepted_at'); revoked consents are excluded.

**Consent Validation**:
- ValidateGdprConsentAction verifies Treatment exists and is active.
- ValidateUserDataAction ensures Treatment is applicable to user's profile (e.g., no SMS consent for users without phone).
- These run on registration and on admin actions.

---

## Scopo (Purpose in FixCity)

### What This Module Achieves

1. **Trust at Scale**
   - Citizens trust FixCity with their location (pothole reports), contact info, preferences.
   - Explicit consent UI makes that trust visible and revocable.

2. **Operational Compliance**
   - Operators (city admin) can prove they had consent if audited by GDPR enforcement.
   - Filament admin panel shows Consent and Event logs.
   - Reports can be generated for data protection impact assessments (DPIA).

3. **Feature Governance**
   - Analytics feature only works if users consented to analytics.
   - Municipal data sharing only works if users consented to data_transfer.
   - Transparent, enforceable, testable.

4. **Data Subject Empowerment**
   - Users see what they consented to (ConsentResource in Filament).
   - Users can revoke at any time.
   - Users can request data deletion (with retention windows respected).

---

## Zen (The Essence)

Privacy, here, is not a burden. It is a feature.

- **For users**: "I control what data this system uses."
- **For operators**: "I can prove we had consent."
- **For developers**: "Consent is a first-class concept; it lives in code, not in assumptions."
- **For auditors**: "The audit trail is complete, encrypted, immutable."

The module embodies a simple belief: **If you are going to collect data, you must collect consent first. And you must keep both as sacred records.**

---

## Librerie da Installare (Libraries & Tools)

### Currently Integrated

| Package | Use | Rationale |
|---------|-----|-----------|
| **statikbe/laravel-cookie-consent** | Cookie banner widget | Lightweight, GDPR-friendly, integrates with middleware |
| **spatie/laravel-schemaless-attributes** | flexible metadata (Profile.extra) | Store custom profile fields without schema migration |
| **spatie/media-library** | Profile avatar, document uploads | Isolate media concerns, version media |
| **spatie/laravel-permission** | Role-based access (Filament admin) | Control who can view/edit consents and treatments |

### Recommended Additions (Future)

| Tool | Purpose | Maturity |
|------|---------|----------|
| **spatie/laravel-activitylog** | Automatic audit logging for all GDPR model changes | Production-ready; already used in Activity module |
| **spatie/laravel-export** | Export user data as portable JSON (GDPR Art. 20) | Production-ready |
| **barryvdh/laravel-dompdf** | Generate PDF reports (DPIA, consent audit) | Production-ready |
| **league/csv** | Bulk consent import/export for admin | Production-ready |

### Compliance & Best-of-Breed

- **OneTrust** (enterprise GDPR platform): Too expensive for FixCity; we build consent layer ourselves.
- **TrustArc**: Cookie management + DPIA automation; useful for large orgs.
- **Compli** (compliance automation): UK-focused; not ideal for Italian PA.
- **CookieBot**: SaaS cookie consent; not needed here (using statikbe/laravel-cookie-consent).

**Rationale for in-house**: FixCity is a public digital service. Outsourcing consent to a SaaS vendor introduces dependency risk and multi-tenancy concerns. Building it locally (with open-source libraries) gives transparency and control.

---

## Future Implementazioni (Roadmap)

### Phase 1: Foundation (Done)

- [x] Consent model with Treatment relationship.
- [x] Event audit trail with encryption.
- [x] Filament resources (ConsentResource, TreatmentResource, EventResource).
- [x] Registration widget with consent checkboxes.
- [x] ConsentType enum with required/optional logic.

### Phase 2: Data Subject Rights (Next)

- [ ] Export endpoint: return all user data + consents as JSON (Art. 20).
- [ ] Erasure flow: soft-delete with retention window (Art. 17).
- [ ] Rectification UI: allow users to correct their Profile (Art. 16).
- [ ] Restrict processing: pause features for withdrawn consents (Art. 18).
- [ ] Objection endpoint: revoke marketing consents in bulk (Art. 21).

### Phase 3: Operator Tools (6 months)

- [ ] Bulk consent import (CSV upload for migrations from legacy systems).
- [ ] DPIA wizard: automated data protection impact assessment.
- [ ] Consent dashboard: visualize coverage by treatment, by user cohort.
- [ ] Breach investigation tool: filtered Event queries (by IP, user, timestamp).
- [ ] Retention automation: scheduled purge of expired consents and events.

### Phase 4: Integration (12 months)

- [ ] Activity module hooks: auto-log all consent changes.
- [ ] Notification module: send "your consent is about to expire" reminders.
- [ ] Email module: check consent before sending marketing emails.
- [ ] Analytics module: only track users who consented to analytics.
- [ ] Webhook support: notify external DPOs of consent changes.

---

## Competitors & Inspirazioni

### Market Solutions

| Solution | Pros | Cons | Verdict |
|----------|------|------|---------|
| **OneTrust** | Comprehensive, audited, insurance-backed | $50k+/year, SaaS dependency, US vendor (data residency) | Not for FixCity |
| **TrustArc** | Good for multinational compliance | Overkill for single-nation public service | Overkill |
| **CookieBot** | Excellent cookie detection + consent | SaaS; doesn't handle registration-level consents | Partial use case |
| **In-house (this module)** | Transparent, control, no vendor lock-in | Requires ongoing maintenance, audit-ready but not pre-audited | Best for FixCity |

### Design Inspiration Sources

- **EU edpb.europa.eu guidelines on consent**: Clarity, granularity, revocation.
- **Italian Garante della Privacy (Autorità Garante per la Protezione dei Dati Personali)**: Privacy by design mandate, consent documentation requirements.
- **Spatie Laravel packages**: Audit logging, encryption, trait-based patterns.
- **Filament Admin**: Resource-based CRUD + form/table DSL for compliance UIs.
- **Laravel Actions pattern**: Reusable business logic (SaveGdprConsentsAction).

---

## Best Practices

### For Developers

1. **Always validate consent before processing**
   ```php
   // Correct:
   $canEmail = Consent::where('user_id', $user->id)
       ->where('type', 'marketing_email')
       ->whereNotNull('accepted_at')
       ->exists();
   
   if ($canEmail) {
       SendMarketingEmailJob::dispatch($user);
   }
   ```

2. **Use Treatment names consistently**
   - Define all treatments in config/consent.php once.
   - Reference by Treatment.id in Consent records, not by string.
   - Prevents typos; enables migration tracking.

3. **Encrypt IPs and sensitive metadata**
   - Event model auto-encrypts payload and ip.
   - Do not store plain-text IP in audit logs.
   - Decrypt only in admin UI; never in APIs.

4. **Audit every consent change**
   - SaveGdprConsentsAction logs to Activity (via listener).
   - UpdateGdprConsentsAction creates Event for revocation.
   - Never bulk-update consents without logging.

5. **Test consent flows**
   - Pest tests cover registration with/without consent (example in module tests).
   - Integration tests verify Event records are created.
   - Verify deletion cascade (Consent soft-delete → Event preserved).

6. **Document your treatments clearly**
   ```php
   'treatments' => [
       [
           'name' => 'marketing_email',
           'description' => 'gdpr.marketing_email.description',
           'documentUrl' => 'https://fixcity.example.com/legal/marketing',
           'required' => false,
           'active' => true,
           'weight' => 10,
       ],
   ],
   ```

### For Operators

1. **Review consents monthly**
   - Filament ConsentResource shows all active consents.
   - Filter by treatment type, date range, acceptance state.
   - Spot anomalies (e.g., bulk rejections of a treatment).

2. **Keep treatments versioned**
   - If you change privacy policy, create a new Treatment (v2.0) and deactivate v1.0.
   - Consents remain tied to the version users accepted.
   - Supports GDPR audit: "what policy version did they consent to?"

3. **Respect retention windows**
   - Don't manually delete Events older than retention period.
   - Use retention automation (when available) to purge at scheduled times.
   - Keep deletion audit log.

4. **Investigate breaches with Events**
   - EventResource in Filament allows filtering by subject_id, timestamp, action.
   - Decrypt Event.payload to see what consent state was accepted.
   - Generate report for data protection officer.

### For Legal / DPO

1. **Maintain audit trail evidence**
   - Export Event records monthly for archive.
   - Encrypt archive with DPO's GPG key.
   - Store in secure vault (not on web server).

2. **Document treatment purposes**
   - Every Treatment must have a documentUrl.
   - That URL should link to the current privacy policy / treatment terms.
   - Update version number when policy changes.

3. **Track user requests**
   - Log all erasure requests (Art. 17), portability requests (Art. 20), objections (Art. 21).
   - Timestamp the request, action taken, completion date.
   - Keep requests for 3+ years (Italian PA audit).

---

## Bad Practices (Anti-Patterns)

### Never Do This

1. **Store IP addresses in plain text**
   ```php
   // WRONG:
   $consent->ip_address = request()->ip();
   $consent->save();
   
   // Correct:
   // Event model auto-encrypts; Consent model also should.
   ```

2. **Assume consent without checking**
   ```php
   // WRONG:
   $user = Auth::user();
   SendMarketingEmail::dispatch($user); // NO CONSENT CHECK!
   
   // Correct:
   if ($user->hasConsent('marketing_email')) {
       SendMarketingEmail::dispatch($user);
   }
   ```

3. **Hard-delete Event records**
   ```php
   // WRONG:
   Event::destroy($id);
   
   // Correct:
   // Events are append-only; never delete.
   // Use soft delete (Event extends BaseModel with timestamps) if needed.
   // Better: let retention automation handle expiration.
   ```

4. **Reuse the same Treatment for different purposes**
   ```php
   // WRONG:
   'name' => 'consent', // Too vague
   
   // Correct:
   'name' => 'marketing_email', // Granular, specific
   'name' => 'analytics', // Separate treatment
   ```

5. **Make consent required without legal basis**
   ```php
   // WRONG:
   'name' => 'newsletter',
   'required' => true, // NO! Marketing is optional.
   
   // Correct:
   'required' => false, // Opt-in, not opt-out.
   ```

6. **Ignore retention windows**
   ```php
   // WRONG:
   Event::whereCreatedAt('<', now()->subMonths(12))->delete();
   
   // Correct:
   // Respect configured retention windows per treatment.
   // Let automation handle deletion (when implemented).
   ```

---

## False Friends (Common Confusions)

### GDPR vs. CCPA

| Aspect | GDPR (EU) | CCPA (USA/California) |
|--------|-----------|----------------------|
| **Scope** | Anyone, anywhere (extraterritorial) | Residents of California only |
| **Consent Default** | Opt-in required | Opt-in for sensitive; opt-out for sales |
| **Enforcement** | €20M or 4% of revenue | $7.5k per violation |
| **Right to be Forgotten** | Yes, unless legal obligation to retain | Limited (no deletion for compliance data) |

**Implication for FixCity**: Primarily GDPR (Italian/EU). If expansion to USA, add CCPA logic (separate Treatment for "sale of personal information" with opt-out mechanism).

---

### Consent vs. Legitimate Interest

| Basis | Use Case | Requirement |
|-------|----------|-------------|
| **Consent** | Marketing, analytics, personalization | Explicit, documented, revocable |
| **Legitimate Interest** | Fraud detection, system security, product improvement | Balancing test (necessity vs. user expectation) |
| **Contract** | Service delivery (e.g., email confirmation) | Necessary to fulfill contract |
| **Legal Obligation** | Tax records, court orders | No choice required |

**This module handles**: Consent (explicit) and legal obligations (log retention). Legitimate interest and contractual processing are documented separately (in privacy policy).

---

### Consent vs. Preference

| Concept | Definition | Binding |
|---------|-----------|---------|
| **Consent** | "I agree to you processing my data for X" | Legal; must be honored; must be revocable |
| **Preference** | "I prefer not to receive emails on Saturdays" | UX-friendly but not legally binding |

**Gdpr module handles**: Consent. Preferences are stored in Profile.extra (schemaless) or a separate Preference table (future).

---

### Cookie Consent vs. Consent Form

| Mechanism | Purpose | Coverage |
|-----------|---------|----------|
| **Cookie Banner** | Disclose + get consent for tracking cookies | Covers Analytics, Personalization (cookies) |
| **Registration Form Checkboxes** | Get consent for all treatments at signup | Covers all: Privacy, Terms, Marketing, etc. |

**This module**: Handles both. CookieConsentMiddleware (statikbe) shows banner. RegisterWidget shows checkboxes. Events unify the audit trail.

---

## Come Usarlo (Practical Implementation)

### Step 1: Define Your Treatments

Edit config/consent.php:

```php
'treatments' => [
    [
        'name' => 'privacy_policy',
        'description' => 'We need your agreement to our privacy policy',
        'required' => true,
        'active' => true,
        'documentUrl' => 'https://fixcity.example.com/legal/privacy',
        'documentVersion' => '2.0',
        'weight' => 0,
    ],
    [
        'name' => 'marketing_email',
        'description' => 'Allow us to send you news and updates (optional)',
        'required' => false,
        'active' => true,
        'documentUrl' => 'https://fixcity.example.com/legal/marketing',
        'documentVersion' => '1.0',
        'weight' => 10,
    ],
],
```

### Step 2: Show Consent UI at Registration

The RegisterWidget (Filament\Widgets\Auth\RegisterWidget) displays checkboxes for each Treatment. On submit, SaveGdprConsentsAction is triggered.

```php
// In your registration flow:
SaveGdprConsentsAction::dispatch($user, [
    'privacy_accepted' => $request->privacy_accepted,
    'terms_accepted' => $request->terms_accepted,
    'marketing_consent' => $request->marketing_consent,
], $request->ip(), $request->userAgent());
```

### Step 3: Check Consent Before Action

Before sending marketing emails:

```php
use Modules\Gdpr\Models\Consent;

$user = User::find($userId);
$hasMarketingConsent = Consent::where('user_id', $user->id)
    ->where('type', 'marketing_email')
    ->whereNotNull('accepted_at')
    ->where('accepted_at', '<', now()) // Exclude future-dated consents
    ->exists();

if ($hasMarketingConsent) {
    SendMarketingEmail::dispatch($user);
}
```

### Step 4: Allow Users to Revoke Consent

In user profile page or Filament ConsentResource:

```php
// User revokes marketing consent
$consent = Consent::where('user_id', auth()->id())
    ->where('type', 'marketing_email')
    ->first();

if ($consent) {
    UpdateGdprConsentsAction::dispatch($consent, ['accepted_at' => null]);
    // Event records the revocation
}
```

### Step 5: Audit and Report

Filament ConsentResource, EventResource, TreatmentResource provide admin interface:
- View all consents per user.
- Filter by treatment, date, acceptance state.
- Export as CSV for audits.
- Inspect Event logs (encrypted, decrypted in UI).

---

## Come Installarlo (Installation & Setup)

### Prerequisites

- Laravel 13
- Filament 5
- PHP 8.4+
- Module is auto-discovered in Laravel 13

### 1. Publish Config

```bash
php artisan vendor:publish --provider="Modules\Gdpr\Providers\GdprServiceProvider"
```

This creates config/gdpr.php (if custom config exists in module).

### 2. Publish Migrations

```bash
php artisan migrate --path=Modules/Gdpr/database/migrations
```

This creates tables: gdpr_profiles, gdpr_consents, gdpr_treatments, gdpr_events.

### 3. Seed Initial Treatments

```bash
php artisan db:seed --class="Modules\Gdpr\Database\Seeders\TreatmentSeeder"
```

Or manually insert via Filament TreatmentResource.

### 4. Enable Cookie Consent Middleware

In GdprServiceProvider (already done):
```php
if ($gdpr->cookie_banner_on) {
    $router->pushMiddlewareToGroup('web', CookieConsentMiddleware::class);
}
```

Set GDPR_COOKIE_BANNER_ON=true in .env to enable banner.

### 5. Publish Language Files

```bash
php artisan vendor:publish --tag="gdpr-translations"
```

Provides Italian (it) and English (en) translations for consent UI.

### 6. Register Filament Resources (if not auto-discovered)

In app/Providers/FilamentServiceProvider or AdminPanelProvider:

```php
use Modules\Gdpr\Filament\Resources\ConsentResource;
use Modules\Gdpr\Filament\Resources\TreatmentResource;

->resources([
    ConsentResource::class,
    TreatmentResource::class,
    EventResource::class,
    ProfileResource::class,
])
```

### 7. Run Tests

```bash
php artisan test --filter="Gdpr"
```

Verifies:
- Consent creation and relationships.
- Event encryption/decryption.
- Soft delete cascades.
- Action dispatch logic.

### 8. Check PHPStan Compliance

```bash
./vendor/bin/phpstan analyse Modules/Gdpr --memory-limit=-1 --level=10
```

Must be 0 errors (Level 10 requirement).

---

## Coverage Analysis (What's Implemented)

### ✅ Implemented

| Feature | Location | Status |
|---------|----------|--------|
| **Consent Model** | Models/Consent.php | Complete; traits + relationships |
| **Treatment Model** | Models/Treatment.php | Complete; versioning support |
| **Event Audit Trail** | Models/Event.php | Complete; encrypted payload + IP |
| **Profile Model** | Models/Profile.php | Extends BaseProfile; GDPR-specific fields |
| **SaveGdprConsentsAction** | Actions/SaveGdprConsentsAction.php | Complete; used in registration |
| **UpdateGdprConsentsAction** | Actions/UpdateGdprConsentsAction.php | Complete; handles revocation |
| **ConsentType Enum** | Enums/ConsentType.php | Complete; 13 types, required/optional logic |
| **Filament ConsentResource** | Filament/Resources/ConsentResource.php | Complete; CRUD + filtering |
| **Filament TreatmentResource** | Filament/Resources/TreatmentResource.php | Complete; manage treatments |
| **Filament EventResource** | Filament/Resources/EventResource.php | Complete; audit log viewer |
| **RegisterWidget** | Filament/Widgets/Auth/RegisterWidget.php | Complete; consent checkboxes |
| **Cookie Banner Middleware** | Via statikbe/laravel-cookie-consent | Complete; auto-integrated |
| **Policies** | Models/Policies/*.php | Complete; role-based access |
| **Listeners** | Listeners/SaveGdprConsents.php | Hooks registration events |
| **Tests** | tests/Feature, tests/Unit | Complete; Pest suite |
| **Migrations** | database/migrations | Complete; all 4 tables |

### ⏳ Planned (Phase 2–4)

| Feature | Purpose | Status |
|---------|---------|--------|
| **Data Export Endpoint** | Art. 20 (portability) | Design pending |
| **Erasure Automation** | Art. 17 (right to be forgotten) | Design pending |
| **Retention Purge** | Scheduled cleanup of expired events | Design pending |
| **DPIA Wizard** | Data protection impact assessment tool | Roadmap |
| **Breach Investigation UI** | Filter events by IP, user, timerange | Roadmap |
| **Consent Dashboard** | Coverage metrics by treatment | Roadmap |
| **Activity Integration** | Auto-log all consent changes | Awaiting Activity module |
| **Notification Integration** | Send "consent expiring" reminders | Awaiting Notification module |
| **Email Consent Checking** | Prevent unsolicited marketing mail | Awaiting Email module |

### ❌ Out of Scope

| Feature | Reason |
|---------|--------|
| **CCPA Compliance** | US-only; FixCity is EU/Italy-focused |
| **PIPEDA (Canada)** | Different jurisdiction; separate module if needed |
| **SaaS Multi-tenancy** | FixCity is single-tenant public service |
| **Blockchain Attestation** | Unnecessary complexity; encrypted DB suffices |
| **3rd-party Cookie Sync** | Contradicts privacy-by-design philosophy |

---

## Appendix: Key Data Structures

### Consent (Model)

```
id (UUID)
treatment_id (FK → Treatment)
subject_id (string) — who gave consent (usually user_id)
user_id (string) — who is the user
user_type (string) — full class name (App\Models\User)
type (enum → ConsentType) — specific consent type
accepted_at (timestamp|null) — when accepted (null = withdrawn)
ip_address (encrypted)
user_agent (encrypted)
metadata (json) — extensible field
created_at, updated_at, deleted_at (soft-delete)
created_by, updated_by, deleted_by (audit)
```

### Event (Model)

```
id (UUID)
consent_id (FK → Consent)
treatment_id (FK → Treatment)
subject_id (string) — who the event is about
action (string) — "created", "revoked", "expired"
ip (encrypted) — where consent was given/revoked
payload (encrypted JSON) — full consent state at time of event
created_at, updated_at, deleted_at
created_by, updated_by, deleted_by
```

### Treatment (Model)

```
id (UUID)
name (string) — machine-readable; unique
description (string) — user-facing text (translated)
active (bool) — allow new consents for this version
required (bool) — block registration without consent
documentVersion (string) — v1.0, v2.0 (track policy versions)
documentUrl (string) — link to full policy text
weight (int) — UI sort order
created_at, updated_at, deleted_at
created_by, updated_by, deleted_by
```

---

## Conclusion

This module is a bet on **transparency and auditability**. 

Privacy is not something you bolt onto an app after launch. It is a structural decision: where data flows, who can access it, when it expires. By embodying consent as a first-class concept — in the database, in the code, in the admin UI — FixCity signals to its users: "Your data is treated with respect."

That is the philosophy.

---

**Module Version**: 2.3.0  
**PHPStan Level**: 10  
**Last Updated**: 2026-09-06  
**Maintained By**: FixCity GDPR Team
