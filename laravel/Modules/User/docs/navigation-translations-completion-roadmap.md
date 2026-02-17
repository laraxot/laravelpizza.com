# Navigation Translations Completion Roadmap - User Module

**Data**: 2026-01-09  
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

- [Translation Standards](../../Xot/docs/translation-standards.md)
- [Navigation Translations Fixes](../../Lang/docs/navigation-translations-fixes.md)

---

**Status**: 📝 **ROADMAP CREATA - PRONTA PER IMPLEMENTAZIONE**

**Ultimo aggiornamento**: 2026-01-09
