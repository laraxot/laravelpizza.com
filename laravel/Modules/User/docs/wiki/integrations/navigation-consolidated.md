---
title: "navigation: Consolidated Documentation"
module: user
type: integration
tags: [integrations, modules, user]
created: 2026-08-24
updated: 2026-08-24
status: draft
qmd: "navigation   consolidated documentation user"
---

# navigation: Consolidated Documentation

Consolidated from **6** individual files.

## Table of Contents

- [---](#navigation-structure)
- [---](#navigation-translations-completion)
- [---](#navigation-translations-fixes-january)
- [---](#navigation-translations-fixes)
- [---](#navigation-translationses)
- [Struttura Navigazione](#navigation_structure)

---

## navigation-structure

*Consolidated from: `navigation-structure.md`*

module: theme
topic: navigation-structure
canonical: ../../../Themes/docs/shared-components/navigation-structure.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/navigation-structure.md

---

## navigation-translations-completion

*Consolidated from: `navigation-translations-completion.md`*

title: "Navigation Translations Completion Roadmap - User Module"
type: concept
tags: [navigation, translations, completion]
created: 2026-07-14
updated: 2026-07-14
qmd: "navigation-translations-completion navigation translations completion roadmap - user module"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Navigation Translations Completion Roadmap - User Module

**Modulo**: User  
**Status**: 📝 **ROADMAP CREATA**

---

## 📊 Executive Summary

Completamento e miglioramento delle traduzioni per i file con sezione `.navigation` nel modulo User per le **6 lingue più parlate al mondo**:
1. Italiano (it) ✅ - Base
2. Inglese (en) ✅ - Presente
3. Spagnolo (es) ✅ - Presente
4. Francese (fr) ✅ - Presente
5. Tedesco (de) ✅ - Presente
6. Portoghese (pt) ⚠️ - Parzialmente presente (pt_BR, pt_PT)

---

## 🔍 Analisi File con `.navigation`

### File Identificati (12 file)

1. ⚠️ `passport.php` - Solo IT
2. ⚠️ `sso_provider.php` - Solo IT
3. ⚠️ `team_invitation.php` - Solo IT
4. ⚠️ `team_user.php` - Solo IT
5. ⚠️ `tenant_user.php` - Solo IT
6. ⚠️ `socialite_user.php` - Solo IT
7. ⚠️ `authentication_log.php` - Solo IT
8. ⚠️ `oauth_access_token.php` - Solo IT
9. ⚠️ `oauth_auth_code.php` - Solo IT
10. ⚠️ `oauth_refresh_token.php` - Solo IT
11. ⚠️ `password_reset.php` - Solo IT
12. ⚠️ File in `resources/lang/it/` (duplicati)

---

## 🎯 Problema Identificato

### Chiavi Navigation con Riferimenti

I file usano chiavi di traduzione nidificate che rimandano a chiavi principali:

```php
'navigation' => [
    'label' => 'passport.navigation',      // ← Riferimento a chiave
    'group' => 'passport.navigation',       // ← Riferimento a chiave
    'icon' => 'passport.navigation',        // ← Riferimento a chiave
],
```

**Problema**: Le chiavi devono essere risolte con valori diretti o chiavi definite nel file principale.

---

## 📋 Strategia di Completamento

### Fase 1: Risolvere Chiavi Navigation (Priorità Alta)

**Pattern da Applicare**:
```php
// PRIMA (Riferimento a chiave)
'navigation' => [
    'label' => 'passport.navigation',
    'group' => 'passport.navigation',
    'icon' => 'passport.navigation',
],

// DOPO (Valore diretto)
'navigation' => [
    'label' => 'OAuth Passport',  // o 'OAuth Passport' per IT
    'group' => 'Authentication',   // o 'Autenticazione' per IT
    'icon' => 'heroicon-o-key',
],
```

### Fase 2: Creare File Traduzione per Tutte le Lingue (Priorità Alta)

**Lingue da Creare**: en, es, fr, de, pt per tutti i file

---

## 🌍 Traduzioni Navigation per Lingua

### Inglese (en)
- `passport.navigation` → "OAuth Passport"
- `sso provider.navigation` → "SSO Providers"
- `team invitation.navigation` → "Team Invitations"
- `team user.navigation` → "Team Users"
- `tenant user.navigation` → "Tenant Users"
- `socialite user.navigation` → "Socialite Users"
- `authentication log.navigation` → "Authentication Logs"
- `oauth access token.navigation` → "OAuth Access Tokens"
- `oauth auth code.navigation` → "OAuth Auth Codes"
- `oauth refresh token.navigation` → "OAuth Refresh Tokens"
- `password reset.navigation` → "Password Resets"

### Spagnolo (es)
- `passport.navigation` → "OAuth Passport"
- `sso provider.navigation` → "Proveedores SSO"
- `team invitation.navigation` → "Invitaciones de Equipo"
- `team user.navigation` → "Usuarios de Equipo"
- `tenant user.navigation` → "Usuarios de Inquilino"
- `socialite user.navigation` → "Usuarios Socialite"
- `authentication log.navigation` → "Registros de Autenticación"
- `oauth access token.navigation` → "Tokens de Acceso OAuth"
- `oauth auth code.navigation` → "Códigos de Autorización OAuth"
- `oauth refresh token.navigation` → "Tokens de Actualización OAuth"
- `password reset.navigation` → "Restablecimientos de Contraseña"

### Francese (fr)
- `passport.navigation` → "OAuth Passport"
- `sso provider.navigation` → "Fournisseurs SSO"
- `team invitation.navigation` → "Invitations d'Équipe"
- `team user.navigation` → "Utilisateurs d'Équipe"
- `tenant user.navigation` → "Utilisateurs Locataires"
- `socialite user.navigation` → "Utilisateurs Socialite"
- `authentication log.navigation` → "Journaux d'Authentification"
- `oauth access token.navigation` → "Jetons d'Accès OAuth"
- `oauth auth code.navigation` → "Codes d'Autorisation OAuth"
- `oauth refresh token.navigation` → "Jetons de Rafraîchissement OAuth"
- `password reset.navigation` → "Réinitialisations de Mot de Passe"

### Tedesco (de)
- `passport.navigation` → "OAuth Passport"
- `sso provider.navigation` → "SSO-Anbieter"
- `team invitation.navigation` → "Team-Einladungen"
- `team user.navigation` → "Team-Benutzer"
- `tenant user.navigation` → "Mandanten-Benutzer"
- `socialite user.navigation` → "Socialite-Benutzer"
- `authentication log.navigation` → "Authentifizierungsprotokolle"
- `oauth access token.navigation` → "OAuth-Zugriffstoken"
- `oauth auth code.navigation` → "OAuth-Autorisierungscodes"
- `oauth refresh token.navigation` → "OAuth-Aktualisierungstoken"
- `password reset.navigation` → "Passwort-Zurücksetzungen"

### Portoghese (pt)
- `passport.navigation` → "OAuth Passport"
- `sso provider.navigation` → "Provedores SSO"
- `team invitation.navigation` → "Convites de Equipe"
- `team user.navigation` → "Usuários de Equipe"
- `tenant user.navigation` → "Usuários de Inquilino"
- `socialite user.navigation` → "Usuários Socialite"
- `authentication log.navigation` → "Registros de Autenticação"
- `oauth access token.navigation` → "Tokens de Acesso OAuth"
- `oauth auth code.navigation` → "Códigos de Autorização OAuth"
- `oauth refresh token.navigation` → "Tokens de Atualização OAuth"
- `password reset.navigation` → "Redefinições de Senha"

---

## ✅ Checklist Implementazione

### Per Ogni File

- [ ] Verificare struttura file IT
- [ ] Creare file per lingue mancanti (en, es, fr, de, pt)
- [ ] Risolvere chiavi navigation (valori diretti)
- [ ] Tradurre tutte le sezioni
- [ ] Verificare coerenza traduzioni
- [ ] Testare visualizzazione in Filament

---

## 📚 Documentazione Correlata

- [Translation Standards](../../../../Xot/docs/translation-standards.md)
- [Navigation Translations Fixes](../../../../Lang/docs/navigation-translations-fixes.md)
- [Navigation Translations Fixes](../../../../Lang/docs/navigation-translations-fixes.md)

---

**Status**: 📝 **ROADMAP CREATA - PRONTA PER IMPLEMENTAZIONE**

**Ultimo aggiornamento**: [DATE]

---

## navigation-translations-fixes-january

*Consolidated from: `navigation-translations-fixes-january.md`*

title: "Correzioni Traduzioni Navigation - Gennaio 2026"
type: concept
tags: [navigation, translations, fixes, january]
created: 2026-07-14
updated: 2026-07-14
qmd: "navigation-translations-fixes-january correzioni traduzioni navigation - gennaio 2026"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Correzioni Traduzioni Navigation - Gennaio 2026

## Data Intervento
**2026-01-22** - Sistemazione completa traduzioni navigation secondo regole DRY + KISS

## Problema Identificato

Tutti i file di traduzione che contengono la stringa `.navigation` indicano traduzioni incomplete/placeholder che devono essere sistemate immediatamente.

## File Corretti

### 1. `lang/it/oauth_client.php`
**Problema**: Placeholder `.navigation` in label, group e icon
**Correzione**: 
- `name`: "OAuth Client"
- `plural`: "OAuth Clients"
- `label`: "Client OAuth"
- `group`: "API" con descrizione
- `icon`: "heroicon-o-key"
- `sort`: 89

### 2. `lang/it/tenant_user.php`
**Problema**: Placeholder `.navigation` in label, group e icon
**Correzione**:
- `name`: "Utente Tenant"
- `plural`: "Utenti Tenant"
- `label`: "Utenti Tenant"
- `group`: "Tenants" con descrizione
- `icon`: "heroicon-o-building-office"
- `sort`: 87

### 3. `lang/it/team_user.php`
**Problema**: Placeholder `.navigation` in label, group e icon
**Correzione**:
- `name`: "Utente Team"
- `plural`: "Utenti Team"
- `label`: "Utenti Team"
- `group`: "Teams" con descrizione
- `icon`: "heroicon-o-user-group"
- `sort`: 65

### 4. `lang/it/sso_provider.php`
**Problema**: Placeholder `.navigation` in label, group e icon
**Correzione**:
- `name`: "Provider SSO"
- `plural`: "Provider SSO"
- `label`: "Provider SSO"
- `group`: "Authentication" con descrizione
- `icon`: "heroicon-o-identification"
- `sort`: 3

### 5. `lang/it/authentication_log.php`
**Problema**: Placeholder `.navigation` in group e icon
**Correzione**:
- `name`: "Log Autenticazione"
- `plural`: "Log Autenticazione"
- `label`: "Log Autenticazione"
- `group`: "Sicurezza" con descrizione
- `icon`: "heroicon-o-shield-check"
- `sort`: 3

### 6. `lang/it/password_reset.php`
**Problema**: Placeholder `.navigation` in group e icon
**Correzione**:
- `name`: "Reset Password"
- `plural`: "Reset Password"
- `label`: "Reset Password"
- `group`: "Sicurezza" con descrizione
- `icon`: "heroicon-o-key"
- `sort`: 4

### 7. `lang/it/oauth_auth_code.php`
**Problema**: Placeholder `.navigation` in label, group e icon
**Correzione**:
- `name`: "OAuth Authorization Code"
- `plural`: "OAuth Authorization Codes"
- `label`: "Authorization Code OAuth"
- `group`: "API" con descrizione
- `icon`: "heroicon-o-code-bracket"
- `sort`: 31

### 8. `lang/it/oauth_access_token.php`
**Problema**: Placeholder `.navigation` in group e icon
**Correzione**:
- `name`: "OAuth Access Token"
- `plural`: "OAuth Access Tokens"
- `label`: "Access Token OAuth"
- `group`: "API" con descrizione
- `icon`: "heroicon-o-key"
- `sort`: 5

### 9. `lang/it/team_invitation.php`
**Problema**: Placeholder `.navigation` in label, group e icon
**Correzione**:
- `name`: "Invito Team"
- `plural`: "Inviti Team"
- `label`: "Inviti Team"
- `group`: "Teams" con descrizione
- `icon`: "heroicon-o-envelope"
- `sort`: 34

### 10. `lang/it/socialite_user.php`
**Problema**: Placeholder `.navigation` in label, group e icon
**Correzione**:
- `name`: "Autenticazione Social"
- `plural`: "Autenticazioni Social"
- `label`: "Autenticazioni Social"
- `group`: "Authentication" con descrizione
- `icon`: "heroicon-o-user"
- `sort`: 89

### 11. `lang/it/oauth_refresh_token.php`
**Problema**: Placeholder `.navigation` in label, group e icon
**Correzione**:
- `name`: "OAuth Refresh Token"
- `plural`: "OAuth Refresh Tokens"
- `label`: "Refresh Token OAuth"
- `group`: "API" con descrizione
- `icon`: "heroicon-o-arrow-path"
- `sort`: 27

## Struttura Corretta Applicata

Tutte le traduzioni seguono ora la struttura espansa completa:

```php
'navigation' => [
    'name' => 'Nome Singolare',
    'plural' => 'Nome Plurale',
    'label' => 'Etichetta Navigazione',
    'group' => [
        'name' => 'Nome Gruppo',
        'description' => 'Descrizione del gruppo',
    ],
    'sort' => 10,
    'icon' => 'heroicon-o-icon-name',
],
```

## Raggruppamento Logico

### Gruppo "API"
- OAuth Client
- OAuth Authorization Code
- OAuth Access Token
- OAuth Refresh Token
- OAuth Personal Access Client (già corretto)

### Gruppo "Authentication"
- SSO Provider
- Socialite User

### Gruppo "Sicurezza"
- Authentication Log
- Password Reset

### Gruppo "Teams"
- Team User
- Team Invitation

### Gruppo "Tenants"
- Tenant User

## Regole Applicate

### DRY (Don't Repeat Yourself)
- Eliminata duplicazione di chiavi placeholder
- Raggruppamento logico coerente
- Icone standard Heroicons per consistenza

### KISS (Keep It Simple, Stupid)
- Traduzioni dirette e chiare in italiano
- Nomi descrittivi e intuitivi
- Struttura semplice e leggibile

## Validazione

- ✅ Nessuna chiave con `.navigation` rimasta
- ✅ Tutte le traduzioni appropriate e localizzate
- ✅ Icone standard Heroicons
- ✅ Raggruppamento logico coerente
- ✅ Struttura espansa completa per tutte le navigation

## Collegamenti

- [Filosofia Traduzioni Laraxot](../../Xot/docs/translation-philosophy.md)
- [Standard Traduzioni](../../../../Xot/docs/translation-standards.md)
- [Documentazione Modulo User](./readme.md)
- [Documentazione Modulo User](./readme.md)
- [Filosofia Traduzioni Laraxot](../../xot/docs/translation-philosophy.md)
- [Standard Traduzioni](../../../../Xot/docs/translation-standards.md)
- [Documentazione Modulo User](./readme.md)

## Note Tecniche

- Mantenuta la struttura espansa esistente
- Preservata la sintassi array breve `[]`
- Rispettato il `declare(strict_types=1);`
- Icone scelte per semantica appropriata
- Sort order allineato con i Resource corrispondenti

*Intervento completato il: 2026-01-22*
*Conforme alle regole DRY + KISS*
---

## navigation-translations-fixes

*Consolidated from: `navigation-translations-fixes.md`*

title: "Correzioni Traduzioni Navigation - Gennaio 2026"
type: concept
tags: [navigation, translations, fixes]
created: 2026-07-14
updated: 2026-07-14
qmd: "navigation-translations-fixes correzioni traduzioni navigation - gennaio 2026"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Correzioni Traduzioni Navigation - Gennaio 2026

## Data Intervento
**2026-01-22** - Sistemazione completa traduzioni navigation secondo regole DRY + KISS

## Problema Identificato

Tutti i file di traduzione che contengono la stringa `.navigation` indicano traduzioni incomplete/placeholder che devono essere sistemate immediatamente.

## File Corretti

### 1. `lang/it/oauth_client.php`
**Problema**: Placeholder `.navigation` in label, group e icon
**Correzione**: 
- `name`: "OAuth Client"
- `plural`: "OAuth Clients"
- `label`: "Client OAuth"
- `group`: "API" con descrizione
- `icon`: "heroicon-o-key"
- `sort`: 89

### 2. `lang/it/tenant_user.php`
**Problema**: Placeholder `.navigation` in label, group e icon
**Correzione**:
- `name`: "Utente Tenant"
- `plural`: "Utenti Tenant"
- `label`: "Utenti Tenant"
- `group`: "Tenants" con descrizione
- `icon`: "heroicon-o-building-office"
- `sort`: 87

### 3. `lang/it/team_user.php`
**Problema**: Placeholder `.navigation` in label, group e icon
**Correzione**:
- `name`: "Utente Team"
- `plural`: "Utenti Team"
- `label`: "Utenti Team"
- `group`: "Teams" con descrizione
- `icon`: "heroicon-o-user-group"
- `sort`: 65

### 4. `lang/it/sso_provider.php`
**Problema**: Placeholder `.navigation` in label, group e icon
**Correzione**:
- `name`: "Provider SSO"
- `plural`: "Provider SSO"
- `label`: "Provider SSO"
- `group`: "Authentication" con descrizione
- `icon`: "heroicon-o-identification"
- `sort`: 3

### 5. `lang/it/authentication_log.php`
**Problema**: Placeholder `.navigation` in group e icon
**Correzione**:
- `name`: "Log Autenticazione"
- `plural`: "Log Autenticazione"
- `label`: "Log Autenticazione"
- `group`: "Sicurezza" con descrizione
- `icon`: "heroicon-o-shield-check"
- `sort`: 3

### 6. `lang/it/password_reset.php`
**Problema**: Placeholder `.navigation` in group e icon
**Correzione**:
- `name`: "Reset Password"
- `plural`: "Reset Password"
- `label`: "Reset Password"
- `group`: "Sicurezza" con descrizione
- `icon`: "heroicon-o-key"
- `sort`: 4

### 7. `lang/it/oauth_auth_code.php`
**Problema**: Placeholder `.navigation` in label, group e icon
**Correzione**:
- `name`: "OAuth Authorization Code"
- `plural`: "OAuth Authorization Codes"
- `label`: "Authorization Code OAuth"
- `group`: "API" con descrizione
- `icon`: "heroicon-o-code-bracket"
- `sort`: 31

### 8. `lang/it/oauth_access_token.php`
**Problema**: Placeholder `.navigation` in group e icon
**Correzione**:
- `name`: "OAuth Access Token"
- `plural`: "OAuth Access Tokens"
- `label`: "Access Token OAuth"
- `group`: "API" con descrizione
- `icon`: "heroicon-o-key"
- `sort`: 5

### 9. `lang/it/team_invitation.php`
**Problema**: Placeholder `.navigation` in label, group e icon
**Correzione**:
- `name`: "Invito Team"
- `plural`: "Inviti Team"
- `label`: "Inviti Team"
- `group`: "Teams" con descrizione
- `icon`: "heroicon-o-envelope"
- `sort`: 34

### 10. `lang/it/socialite_user.php`
**Problema**: Placeholder `.navigation` in label, group e icon
**Correzione**:
- `name`: "Autenticazione Social"
- `plural`: "Autenticazioni Social"
- `label`: "Autenticazioni Social"
- `group`: "Authentication" con descrizione
- `icon`: "heroicon-o-user"
- `sort`: 89

### 11. `lang/it/oauth_refresh_token.php`
**Problema**: Placeholder `.navigation` in label, group e icon
**Correzione**:
- `name`: "OAuth Refresh Token"
- `plural`: "OAuth Refresh Tokens"
- `label`: "Refresh Token OAuth"
- `group`: "API" con descrizione
- `icon`: "heroicon-o-arrow-path"
- `sort`: 27

## Struttura Corretta Applicata

Tutte le traduzioni seguono ora la struttura espansa completa:

```php
'navigation' => [
    'name' => 'Nome Singolare',
    'plural' => 'Nome Plurale',
    'label' => 'Etichetta Navigazione',
    'group' => [
        'name' => 'Nome Gruppo',
        'description' => 'Descrizione del gruppo',
    ],
    'sort' => 10,
    'icon' => 'heroicon-o-icon-name',
],
```

## Raggruppamento Logico

### Gruppo "API"
- OAuth Client
- OAuth Authorization Code
- OAuth Access Token
- OAuth Refresh Token
- OAuth Personal Access Client (già corretto)

### Gruppo "Authentication"
- SSO Provider
- Socialite User

### Gruppo "Sicurezza"
- Authentication Log
- Password Reset

### Gruppo "Teams"
- Team User
- Team Invitation

### Gruppo "Tenants"
- Tenant User

## Regole Applicate

### DRY (Don't Repeat Yourself)
- [Regole Traduzioni Laraxot](../../../../Xot/docs/translation-rules.md)
- [Standard Qualità Traduzioni](../<nome progetto>/docs/translation-quality-standards.md)
- [Documentazione Modulo User](readme.md)
- [Documentazione Modulo User](readme.md)
- Eliminata duplicazione di chiavi placeholder
- Raggruppamento logico coerente
- Icone standard Heroicons per consistenza

### KISS (Keep It Simple, Stupid)
- Traduzioni dirette e chiare in italiano
- Nomi descrittivi e intuitivi
- Struttura semplice e leggibile

## Validazione

- ✅ Nessuna chiave con `.navigation` rimasta
- ✅ Tutte le traduzioni appropriate e localizzate
- ✅ Icone standard Heroicons
- ✅ Raggruppamento logico coerente
- ✅ Struttura espansa completa per tutte le navigation

## Collegamenti

- [Filosofia Traduzioni Laraxot](../../xot/docs/translation-philosophy.md)
- [Standard Traduzioni](../../../../Xot/docs/translation-standards.md)
- [Documentazione Modulo User](./readme.md)

## Note Tecniche

- Mantenuta la struttura espansa esistente
- Preservata la sintassi array breve `[]`
- Rispettato il `declare(strict_types=1);`
- Icone scelte per semantica appropriata
- Sort order allineato con i Resource corrispondenti

*Intervento completato il: 2026-01-22*
*Conforme alle regole DRY + KISS*
---

## navigation-translationses

*Consolidated from: `navigation-translationses.md`*

title: "Correzioni Traduzioni Navigation - Modulo User"
type: concept
tags: [navigation, translationses]
created: 2026-07-14
updated: 2026-07-14
qmd: "navigation-translationses correzioni traduzioni navigation - modulo user"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Correzioni Traduzioni Navigation - Modulo User

## Data Intervento
**[DATE]** - Sistemazione traduzioni secondo regole DRY + KISS

## Problemi Identificati

### File: `lang/it/device.php`
**Problema**: Chiavi hardcoded con ".navigation" nella sezione navigation
```php
// ❌ PRIMA (Problematico)
'navigation' => [
    'label' => 'device.navigation',
    'group' => 'device.navigation', 
    'icon' => 'device.navigation',
]
```

**Soluzione**: Traduzioni localizzate e appropriate
```php
// ✅ DOPO (Corretto)
'navigation' => [
    'label' => 'Dispositivi',
    'group' => 'Sicurezza',
    'icon' => 'heroicon-o-device-phone-mobile',
]
```

### File: `lang/it/permission.php`
**Problema**: Chiavi hardcoded con ".navigation" nella sezione navigation
```php
// ❌ PRIMA (Problematico)
'navigation' => [
    'label' => 'permission.navigation',
    'group' => 'permission.navigation',
    'icon' => 'permission.navigation',
]
```

**Soluzione**: Traduzioni localizzate e appropriate
```php
// ✅ DOPO (Corretto)
'navigation' => [
    'label' => 'Permessi',
    'group' => 'Sicurezza', 
    'icon' => 'heroicon-o-shield-check',
]
```

## Regole Applicate

### DRY (Don't Repeat Yourself)
- Eliminata duplicazione di chiavi non tradotte
- Raggruppamento logico sotto "Sicurezza" per coerenza
- Icone standard Heroicons per consistenza

### KISS (Keep It Simple, Stupid)
- Traduzioni dirette e chiare
- Nomi descrittivi e intuitivi
- Struttura semplice e leggibile

## Benefici Ottenuti

1. **Localizzazione Corretta**: Traduzioni in italiano appropriato
2. **Coerenza UI**: Raggruppamento logico sotto "Sicurezza"
3. **Manutenibilità**: Eliminazione di chiavi hardcoded
4. **Standard Compliance**: Rispetto delle regole di traduzione Laraxot

## Validazione

- ✅ Nessuna chiave hardcoded con ".navigation"
- ✅ Traduzioni appropriate e localizzate
- ✅ Icone standard Heroicons
- ✅ Raggruppamento logico coerente

## Collegamenti

- [Audit Generale Traduzioni Navigation](../../../docs/navigation-translations-audit.md)
- [Regole Traduzioni Laraxot](../../../../Xot/docs/translation-rules.md)
- [Standard Qualità Traduzioni](../<nome progetto>/docs/translation-quality-standards.md)
- [Documentazione Modulo User](readme.md)

## Note Tecniche

- Mantenuta la struttura espansa esistente
- Preservata la sintassi array breve `[]`
- Rispettato il `declare(strict_types=1);`
- Icone scelte per semantica appropriata

*Intervento completato il: [DATE]*
*Conforme alle regole DRY + KISS*

---

## navigation_structure

*Consolidated from: `navigation_structure.md`*


## Overview

La navigazione è composta da tre componenti principali:
1. Language Switcher
2. User Dropdown
3. Avatar

## Struttura File

```
laravel/Themes/One/resources/views/
├── components/
│   └── blocks/
│       └── navigation/
│           ├── index.blade.php           # Componente principale
│           ├── language-switcher.blade.php
│           ├── user-dropdown.blade.php
│           └── avatar.blade.php
└── layouts/
    └── navigation.blade.php              # Layout della navigazione
```

## Componenti

### 1. Navigation (index.blade.php)
- Container principale
- Responsive design
- Gestione stati mobile/desktop

### 2. Language Switcher
- Lista lingue disponibili
- Indicatore lingua corrente
- Gestione cambio lingua
- Persistenza scelta

### 3. User Dropdown
- Informazioni utente
- Menu opzioni
- Gestione logout
- Link amministrazione

### 4. Avatar
- Immagine profilo
- Fallback image
- Gestione upload
- Cache immagini

## Stati

### Desktop
```blade
<nav class="hidden md:flex">
    <!-- Language Switcher -->
    <!-- User Dropdown -->
    <!-- Avatar -->
</nav>
```

### Mobile
```blade
<nav class="md:hidden">
    <!-- Mobile Menu -->
    <!-- Language Switcher -->
    <!-- User Dropdown -->
    <!-- Avatar -->
</nav>
```

## Eventi

### Language Change
```php
Event::dispatch('language.changed', [
    'old' => $oldLocale,
    'new' => $newLocale,
    'user_id' => Auth::id()
]);
```

### User Actions
```php
Event::dispatch('user.action', [
    'action' => 'logout',
    'user_id' => Auth::id(),
    'timestamp' => now()
]);
```

## Stili

### Filament Integration
```css
.filament-header {
    @apply bg-white dark:bg-gray-800;
}

.filament-nav-link {
    @apply text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white;
}
```

### Custom Components
```css
.language-switcher {
    @apply flex items-center space-x-2;
}

.user-dropdown {
    @apply relative inline-block;
}

.avatar {
    @apply rounded-full;
}
```

## Best Practices

1. **Performance**
   - Lazy loading immagini
   - Caching componenti
   - Ottimizzazione bundle

2. **Accessibilità**
   - ARIA labels
   - Keyboard navigation
   - Screen reader support

3. **Responsive**
   - Mobile-first approach
   - Breakpoints consistenti
   - Touch-friendly

4. **Sicurezza**
   - CSRF protection
   - XSS prevention
   - Input validation

## Collegamenti Correlati
- [Header Components](./HEADER_COMPONENTS.md)
- [Security Best Practices](./SECURITY_BEST_PRACTICES.md)
- [Session Management](./SESSION_MANAGEMENT.md) 

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04
