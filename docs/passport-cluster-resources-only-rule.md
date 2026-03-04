# Regola Critica: Cluster Passport - Solo Risorse OAuth/Passport

**Data**: 2025-01-22
**Status**: ✅ Regola Critica OBBLIGATORIA
**Integrazione**: Architettura Filament Clusters

---

## 🎯 La Regola Fondamentale

**NELLA DIRECTORY `Modules/User/app/Filament/Clusters/Passport/Resources/` CI DEVONO STARE SOLO LE RISORSE ATTINENTI A PASSPORT/OAUTH.**

---

## ✅ Risorse Consentite (Solo OAuth/Passport)

### Risorse Standard Laravel Passport
1. **OauthClientResource** - Gestione client OAuth
   - Model: `Laravel\Passport\Client` (via `Passport::clientModel()`)
   - Scopo: Creare e gestire client OAuth

2. **OauthAccessTokenResource** - Token di accesso
   - Model: `Modules\User\Models\OauthAccessToken`
   - Scopo: Visualizzare e gestire token di accesso

3. **OauthRefreshTokenResource** - Token di refresh
   - Model: `Modules\User\Models\OauthRefreshToken`
   - Scopo: Visualizzare token di refresh

4. **OauthAuthCodeResource** - Authorization codes
   - Model: `Modules\User\Models\OauthAuthCode`
   - Scopo: Visualizzare authorization codes

5. **OauthPersonalAccessClientResource** - Personal access clients
   - Model: `Modules\User\Models\OauthPersonalAccessClient`
   - Scopo: Gestire personal access clients

### Risorse Opzionali (Se Implementate)
6. **OauthDeviceCodeResource** - Device codes (se implementato)
   - Model: `Modules\User\Models\OauthDeviceCode`
   - Scopo: Gestire device codes per OAuth Device Flow

---

## ❌ VIETATO

### Risorse NON Consentite
- ❌ **UserResource** - NON attinente a Passport
- ❌ **TeamResource** - NON attinente a Passport
- ❌ **RoleResource** - NON attinente a Passport
- ❌ **PermissionResource** - NON attinente a Passport
- ❌ **SocialProviderResource** - NON attinente a Passport (è Socialite, non Passport)
- ❌ **SsoProviderResource** - NON attinente a Passport
- ❌ Qualsiasi altra risorsa non direttamente correlata a Laravel Passport/OAuth

### Motivo
Il cluster `Passport` è stato creato specificamente per organizzare tutte le funzionalità OAuth/Passport in un unico posto. Mettere risorse non attinenti:
- **Rompe l'organizzazione logica** del cluster
- **Confonde gli utenti** che si aspettano solo OAuth
- **Violenta il principio di coesione** (cohesion) del cluster

---

## 📊 Struttura Corretta

```
Modules/User/app/Filament/Clusters/Passport/
├── Passport.php (Cluster minimale)
└── Resources/
    ├── OauthClientResource.php ✅
    ├── OauthAccessTokenResource.php ✅
    ├── OauthRefreshTokenResource.php ✅
    ├── OauthAuthCodeResource.php ✅
    ├── OauthPersonalAccessClientResource.php ✅
    └── OauthDeviceCodeResource.php ✅ (se implementato)
```

**Nessun'altra risorsa deve essere presente in questa directory!**

---

## 🔍 Verifica

Per verificare che la directory contenga solo risorse OAuth/Passport:

```bash
# Lista tutte le risorse nel cluster Passport
find Modules/User/app/Filament/Clusters/Passport/Resources -name "*Resource.php" -type f

# Dovrebbero essere solo:
# - OauthClientResource.php
# - OauthAccessTokenResource.php
# - OauthRefreshTokenResource.php
# - OauthAuthCodeResource.php
# - OauthPersonalAccessClientResource.php
```

---

## 📚 Riferimenti

- [Passport Cluster Summary](./passport-cluster-summary.md)
- [Passport Cluster Implementation](./passport-cluster-implementation-completed.md)
- [Filament Clusters Documentation](../../xot/docs/filament-class-extension-rules.md)

---

**
**Versione**: 1.0.0
**Status**: ✅ Regola Critica OBBLIGATORIA
