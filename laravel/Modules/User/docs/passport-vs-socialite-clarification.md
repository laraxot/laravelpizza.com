# Passport vs Socialite - Distinzione Critica

**Data**: 2025-01-22
**Status**: ✅ Documentazione Critica
**Scopo**: Chiarire la differenza fondamentale tra Laravel Passport e Laravel Socialite

---

## 🎯 La Distinzione Fondamentale

### Laravel Passport (OAuth2 Server)
**Scopo**: Fornire un server OAuth2 completo per autenticazione API

**Componenti**:
- `OauthClient` - Client OAuth che richiedono token
- `OauthAccessToken` - Token di accesso per API
- `OauthRefreshToken` - Token per rinnovare access token
- `OauthAuthCode` - Authorization codes per OAuth flow
- `OauthPersonalAccessClient` - Client per personal access tokens

**Cluster Filament**: `Modules/User/app/Filament/Clusters/Passport/Resources/`

**Quando usare**: Quando la tua applicazione deve **fornire** API OAuth2 ad altre applicazioni/client.

---

### Laravel Socialite (Social Authentication)
**Scopo**: Autenticazione utenti tramite provider social (Google, Facebook, GitHub, ecc.)

**Componenti**:
- `SocialProvider` - Configurazione provider social (Google, Facebook, GitHub, ecc.)
- `SocialiteUser` - Collegamento account utente con provider social

**Posizione Filament**: `Modules/User/app/Filament/Resources/` (NON nel cluster Passport!)

**Quando usare**: Quando gli utenti devono **autenticarsi** usando account social esterni.

---

## ❌ ERRORE COMUNE

**NON confondere**:
- ❌ `SocialProviderResource` (Socialite) → **NON** va nel cluster Passport
- ✅ `OauthClientResource` (Passport) → **SÌ** va nel cluster Passport

**Perché**:
- **Passport** = La tua app è un **server OAuth2** (fornisce token ad altre app)
- **Socialite** = La tua app è un **client OAuth2** (usa token da provider esterni per autenticare utenti)

---

## 📊 Struttura Corretta

```
Modules/User/app/Filament/
├── Clusters/
│   └── Passport/                    ← SOLO OAuth2 Server (Passport)
│       └── Resources/
│           ├── OauthClientResource.php ✅
│           ├── OauthAccessTokenResource.php ✅
│           ├── OauthRefreshTokenResource.php ✅
│           ├── OauthAuthCodeResource.php ✅
│           └── OauthPersonalAccessClientResource.php ✅
│
└── Resources/                       ← Risorse generiche (incluso Socialite)
    ├── UserResource.php
    ├── SocialProviderResource.php ✅  ← Socialite (NON Passport!)
    ├── SocialiteUserResource.php ✅   ← Socialite (NON Passport!)
    └── ...
```

---

## 🔍 Verifica

**Per verificare che SocialProviderResource NON sia nel cluster Passport**:

```bash
# NON deve esistere:
find Modules/User/app/Filament/Clusters/Passport/Resources -name "SocialProviderResource.php"

# Deve esistere qui:
find Modules/User/app/Filament/Resources -name "SocialProviderResource.php"
```

---

## 📚 Riferimenti

- [Passport Cluster Resources Only Rule](./passport-cluster-resources-only-rule.md)
- [Filosofia Modulo User](./filosofia_modulo_user.md)
- [Laravel Passport Documentation](https://laravel.com/docs/passport)
- [Laravel Socialite Documentation](https://laravel.com/docs/socialite)

---

**
**Versione**: 1.0.0
**Status**: ✅ Documentazione Critica
