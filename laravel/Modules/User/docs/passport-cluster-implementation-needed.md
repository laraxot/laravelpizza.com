# Passport Cluster - Implementazione Necessaria

**Data**: 2025-01-22  
**Status**: 🔴 DA IMPLEMENTARE  
**Metodologia**: Super Mucca

---

## 📋 Situazione Attuale

La directory `Modules/User/app/Filament/Clusters/Passport/Resources/` è **vuota**. Tutte le risorse OAuth devono essere implementate.

---

## 🎯 Obiettivo

Implementare tutte le 5 risorse OAuth nel cluster Passport seguendo il pattern standardizzato di Laraxot.

---

## 📊 Struttura da Implementare

```
Modules/User/app/Filament/Clusters/Passport/
├── Passport.php (✅ Esiste)
└── Resources/
    ├── OauthClientResource.php (❌ DA CREARE)
    │   └── Pages/
    │       ├── ListOauthClients.php
    │       ├── CreateOauthClient.php
    │       ├── EditOauthClient.php
    │       └── ViewOauthClient.php
    ├── OauthAccessTokenResource.php (❌ DA CREARE)
    │   └── Pages/
    │       ├── ListOauthAccessTokens.php
    │       ├── ViewOauthAccessToken.php
    │       └── EditOauthAccessTokens.php
    ├── OauthRefreshTokenResource.php (❌ DA CREARE)
    │   └── Pages/
    │       ├── ListOauthRefreshTokens.php
    │       └── ViewOauthRefreshToken.php
    ├── OauthAuthCodeResource.php (❌ DA CREARE)
    │   └── Pages/
    │       ├── ListOauthAuthCodes.php
    │       └── ViewOauthAuthCode.php
    └── OauthPersonalAccessClientResource.php (❌ DA CREARE)
        └── Pages/
            ├── ListOauthPersonalAccessClients.php
            ├── CreateOauthPersonalAccessClient.php
            ├── EditOauthPersonalAccessClient.php
            └── ViewOauthPersonalAccessClient.php
```

**Totale**: 20 file PHP da creare (5 risorse + 15 pages)

---

## 📝 Modelli di Riferimento

### OauthClient
- **Model**: `Modules\User\Models\OauthClient`
- **Base**: `Laravel\Passport\Client`
- **Campi**: `id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`
- **Relazioni**: `user`, `tokens`, `authCodes`

### OauthAccessToken
- **Model**: `Modules\User\Models\OauthAccessToken`
- **Base**: `Laravel\Passport\Token`
- **Campi**: `id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `expires_at`
- **Relazioni**: `user`, `client`, `refreshToken`

### OauthRefreshToken
- **Model**: `Modules\User\Models\OauthRefreshToken`
- **Base**: `Laravel\Passport\RefreshToken`
- **Campi**: `id`, `access_token_id`, `revoked`, `expires_at`
- **Relazioni**: `accessToken`

### OauthAuthCode
- **Model**: `Modules\User\Models\OauthAuthCode`
- **Base**: `Laravel\Passport\AuthCode`
- **Campi**: `id`, `user_id`, `client_id`, `scopes`, `revoked`, `expires_at`
- **Relazioni**: `user`, `client`

### OauthPersonalAccessClient
- **Model**: `Modules\User\Models\OauthPersonalAccessClient`
- **Base**: `BaseModel`
- **Campi**: `id`, `client_id`, `uuid`, `created_at`, `updated_at`
- **Relazioni**: `client`

---

## 🏗️ Pattern da Seguire

### Resource Base Pattern
```php
namespace Modules\User\Filament\Clusters\Passport\Resources;

use Modules\User\Filament\Clusters\Passport;
use Modules\Xot\Filament\Resources\XotBaseResource;

class OauthClientResource extends XotBaseResource
{
    protected static ?string $cluster = Passport::class;
    protected static ?string $model = OauthClient::class;
    
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            // Schema components
        ];
    }
    
    /**
     * @return array<string, class-string>
     */
    public static function getPages(): array
    {
        return [
            'index' => ListOauthClients::route('/'),
            'create' => CreateOauthClient::route('/create'),
            'edit' => EditOauthClient::route('/{record}/edit'),
            'view' => ViewOauthClient::route('/{record}'),
        ];
    }
}
```

### Page Pattern
```php
namespace Modules\User\Filament\Clusters\Passport\Resources\OauthClientResource\Pages;

use Modules\User\Filament\Clusters\Passport\Resources\OauthClientResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListOauthClients extends XotBaseListRecords
{
    protected static string $resource = OauthClientResource::class;
}
```

---

## ✅ Checklist Implementazione

### OauthClientResource
- [ ] Resource principale
- [ ] ListOauthClients page
- [ ] CreateOauthClient page
- [ ] EditOauthClient page
- [ ] ViewOauthClient page
- [ ] Form schema con tutti i campi
- [ ] Table columns appropriate
- [ ] Relazioni eager loaded

### OauthAccessTokenResource
- [ ] Resource principale
- [ ] ListOauthAccessTokens page
- [ ] ViewOauthAccessToken page
- [ ] EditOauthAccessTokens page
- [ ] Form schema
- [ ] Table columns (id, user, client, name, scopes, revoked, expires_at)
- [ ] Filtri per revoked/expired

### OauthRefreshTokenResource
- [ ] Resource principale
- [ ] ListOauthRefreshTokens page
- [ ] ViewOauthRefreshToken page
- [ ] NO Create/Edit (generati automaticamente)

### OauthAuthCodeResource
- [ ] Resource principale
- [ ] ListOauthAuthCodes page
- [ ] ViewOauthAuthCode page
- [ ] NO Create/Edit (generati automaticamente)

### OauthPersonalAccessClientResource
- [ ] Resource principale
- [ ] ListOauthPersonalAccessClients page
- [ ] CreateOauthPersonalAccessClient page
- [ ] EditOauthPersonalAccessClient page
- [ ] ViewOauthPersonalAccessClient page
- [ ] Form schema semplice (solo client_id)

---

## 📚 Riferimenti

- [Passport Cluster Resources Pattern](./passport-cluster-resources-pattern.md)
- [Passport Cluster Summary](./passport-cluster-summary.md)
- [Filament Class Extension Rules](../../Xot/docs/filament-class-extension-rules.md)

---

**Ultimo aggiornamento**: 2025-01-22  
**Versione**: 1.0.0  
**Status**: 🔴 DA IMPLEMENTARE
