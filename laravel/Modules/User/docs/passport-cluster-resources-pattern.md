# Passport Cluster Resources Pattern

**Data**: 2025-01-22
**Status**: ✅ Implementato

---

## 📋 Panoramica

Tutte le risorse OAuth (Laravel Passport) sono organizzate dentro il cluster `Passport` seguendo il pattern standardizzato di Laraxot.

---

## 🏗️ Struttura

```
Modules/User/app/Filament/Clusters/Passport/
├── Passport.php (Cluster)
└── Resources/
    ├── OauthClientResource.php
    │   └── Pages/
    │       ├── ListOauthClients.php
    │       ├── CreateOauthClient.php
    │       ├── EditOauthClient.php
    │       └── ViewOauthClient.php
    ├── OauthAccessTokenResource.php
    │   └── Pages/
    │       ├── ListOauthAccessTokens.php
    │       ├── ViewOauthAccessToken.php
    │       └── EditOauthAccessTokens.php
    ├── OauthRefreshTokenResource.php
    │   └── Pages/
    │       ├── ListOauthRefreshTokens.php
    │       └── ViewOauthRefreshToken.php
    ├── OauthAuthCodeResource.php
    │   └── Pages/
    │       ├── ListOauthAuthCodes.php
    │       └── ViewOauthAuthCode.php
    └── OauthPersonalAccessClientResource.php
        └── Pages/
            ├── ListOauthPersonalAccessClients.php
            ├── CreateOauthPersonalAccessClient.php
            ├── EditOauthPersonalAccessClient.php
            └── ViewOauthPersonalAccessClient.php
```

---

## 📝 Namespace Pattern

### Cluster
```php
namespace Modules\User\Filament\Clusters;

use Modules\Xot\Filament\Clusters\XotBaseCluster;

class Passport extends XotBaseCluster
{
}
```

### Resource
```php
namespace Modules\User\Filament\Clusters\Passport\Resources;

use Modules\User\Filament\Clusters\Passport;
use Modules\Xot\Filament\Resources\XotBaseResource;

class OauthClientResource extends XotBaseResource
{
    protected static ?string $cluster = Passport::class;
    protected static ?string $model = Client::class;
}
```

### Pages
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

## ✅ Pattern Corretto

### 1. Cluster minimale
- Estende `XotBaseCluster`
- Nessuna proprietà aggiuntiva (KISS)
- Parentesi graffe su righe separate (coerenza con `Appearance.php`)

### 2. Resource nel cluster
- Namespace: `Modules\{Module}\Filament\Clusters\{Cluster}\Resources`
- Estende `XotBaseResource`
- Property `$cluster` obbligatoria
- `getPages()` restituisce `array<string, \Filament\Resources\Pages\PageRegistration>`

### 3. Pages nella resource
- Namespace: `Modules\{Module}\Filament\Clusters\{Cluster}\Resources\{Resource}\Pages`
- Estende `XotBase{List|Create|Edit|View}Record`
- Property `$resource` con classe completa

---

## 🎯 Riferimenti

- Pattern simile: `Modules/Gdpr/app/Filament/Clusters/Profile/Resources/`
- Cluster esempio: `Modules/User/app/Filament/Clusters/Appearance.php`
- Documentazione: `Modules/Xot/docs/filament-class-extension-rules.md`

---

## ⚠️ Errori Comuni da Evitare

1. ❌ **Resource fuori dal cluster**: `Modules/User/app/Filament/Resources/OauthClientResource.php`
2. ❌ **Namespace errato**: `Modules\User\Filament\Resources\OauthClientResource`
3. ❌ **Cluster con proprietà errate**: `protected static ?string $navigationGroup = 'API';`
4. ❌ **File duplicati**: `PassportCluster.php` e `Passport.php` insieme

---

## 📊 Statistiche

- **Totale file**: 20 file PHP (1 cluster + 5 risorse + 14 pages)
- **PHPStan**: ✅ Level 10 - No errors
- **Pint**: ✅ Formatted
- **Pattern**: ✅ Coerente con Gdpr/Profile/Resources/

## 🔄 Lavoro Completato da Altro Agente

- ✅ Rimossi import non usati
- ✅ Corretto stile (Yoda → normale)
- ✅ Aggiunte righe vuote per leggibilità
- ✅ Verificato PHPStan L10

---

**Ultimo aggiornamento**: 2025-01-22
**Versione**: 1.0.1
**Status**: ✅ Pattern implementato, verificato e completato
