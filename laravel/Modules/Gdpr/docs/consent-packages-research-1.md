# Research: GDPR & Legal Consent Packages

This document analyzes two popular Laravel consent packages, capturing technical logic and deeper philosophical considerations.

---

## 1. MaizeTech Laravel Legal Consent

### Overview
- Provides flexible, database-driven legal consent management.
- Supports multiple consent types (privacy, terms, marketing).
- Tracks versioned consents and user acceptance.

### Key Concepts & Logic
- **Models**: `LegalConsent`, `ConsentRecord` representing templates and user agreements.
- **Migrations**: Tables for consent templates and user logs.
- **Middleware**: `RequireLegalConsent` ensures users accept latest version.
- **Services**: `ConsentManager` facade to fetch active templates and record responses.
- **Views & Stubs**: Blade templates for banners, modals.

### Usage Pattern
1. **Install & Publish**: `composer require maize-tech/laravel-legal-consent` + `artisan vendor:publish`.
2. **Configure**: Define `LEGAL_CONSENT_TYPES`, set `consent_version` tables.
3. **Middleware**: Protect routes until consent given.
4. **Record**: `ConsentManager::accept('privacy');`
5. **Events**: `ConsentAccepted` for audit and notifications.

### Philosophical Alignment
- **Transparency & Accountability**: Clear versioning and user logs.
- **Governance & Ethics**: Enforces consent flow, minimizes legal risk.
- **Inclusivity**: Multi-language support for user comprehension.

---

## 2. Foothing Laravel GDPR Consent

### Overview
- Cookie banner and consent storage for GDPR compliance.
- Lightweight, relies on config + middleware.

### Key Concepts & Logic
- **Config**: `gdpr-consent.php` for banner options and cookie groups.
- **Middleware**: `CheckCookieConsent` injects banner and enforces opt-in.
- **Controller & Views**: Blade component for banner UI.
- **Cookie Storage**: JSON payload in a cookie named `gdpr_consent`.
- **Helpers**: `hasConsent('analytics')` to conditionally load scripts.

### Usage Pattern
1. **Install**: `composer require foothing/laravel-gdpr-consent`.
2. **Publish Config**: customize cookie categories, labels.
3. **Add Middleware**: in `web` group for banner injection.
4. **Blade**: `@gdprBanner()` to render consent UI.
5. **Check**: `if (gdpr_consent()->analytics) { /* load analytics */ }

### Philosophical Alignment
- **User Autonomy**: explicit opt-in for cookie categories.
- **Ethical Design**: minimize data collection until consent.
- **Behavioral Insight**: clear feedback to shape trust.

---

## Comparative Insights

| Aspect                | MaizeTech Legal Consent                | Foothing GDPR Consent         |
|-----------------------|----------------------------------------|-------------------------------|
| Focus                 | Generic legal agreements               | Cookie and script consent     |
| Storage               | Database (versioned)                   | Cookie (client-side)          |
| Middleware Enforcement| Route protection                       | Banner injection              |
| UI                    | Custom blade templates                 | Blade directive & config      |
| Extension Points      | Events, facades, models                | Helpers, config, middleware   |

---

## Deeper Reflections
- **Epistemology**: codifies legal knowledge into templates and logs.
- **Ethics & Accountability**: records decisions, creates audit trail.
- **User Experience**: balance persuasion vs informed consent.
- **Technical Debt**: DB vs cookie trade-offs, maintainability.
- **Sustainability**: aligns with regulatory changes, version control.

---

*Generated: 2025-06-06*
