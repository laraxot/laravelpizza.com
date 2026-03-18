# Audit Passport OAuth - Modelli e Corredo Filament

**Scopo**: Verificare che ogni modello Passport abbia wrapper Oauth* completo con policy, Filament resource, traduzioni e test.

**Data audit**: 2025-03

---

## Modelli Passport (vendor)

| Classe Passport | Tabella | Wrapper | Policy | Resource | Traduzioni | Test |
|-----------------|---------|---------|--------|----------|------------|------|
| `AuthCode` | oauth_auth_codes | OauthAuthCode | OauthAuthCodePolicy | OauthAuthCodeResource | oauth_auth_code | PoliciesTest |
| `Client` | oauth_clients | OauthClient | OauthClientPolicy | OauthClientResource | oauth_client | PoliciesTest |
| `DeviceCode` | oauth_device_codes | OauthDeviceCode | OauthDeviceCodePolicy | OauthDeviceCodeResource | oauth_device_code | PoliciesTest |
| `RefreshToken` | oauth_refresh_tokens | OauthRefreshToken | OauthRefreshTokenPolicy | OauthRefreshTokenResource | oauth_refresh_token | PoliciesTest |
| `Token` | oauth_access_tokens | OauthToken | OauthTokenPolicy | OauthAccessTokenResource | oauth_token/oauth_access_token | PoliciesTest |

**Nota**: `OauthAccessToken` è stato rimosso (AccessToken non è Model ma DTO). `OauthAccessTokenResource` usa `OauthToken` come model.

---

## Checklist per ogni modello Oauth*

- [x] **Model**: Estende classe Passport, `$connection = 'user'`
- [x] **Policy**: Estende UserBasePolicy, permessi oauth-{slug}.*
- [x] **Resource**: Nel cluster Passport, estende XotBaseResource
- [x] **Pages**: List + View (o Create/Edit dove applicabile)
- [x] **Traduzioni**: lang/{locale}/oauth_{slug}.php con navigation, label, fields, actions
- [x] **PoliciesTest**: Test di istanziazione policy

---

## OauthClient - Dettaglio implementazione

**Riferimento**: [aurmich/sample_passport Client.php](https://github.com/aurmich/sample_passport/blob/develop/app/Models/Client.php)

### Model
- `OauthClient` estende `Laravel\Passport\Client` e implementa `AuthorizableContract`
- `$connection = 'user'`, `$guard_name = 'api'`
- Traits: `Authorizable`, `HasRoles` (Spatie Permission)
- **user()**: override con `XotData::make()->getUserClass()` (mai config)
- **can()**, **cant()**, **cannot()**, **canAny()**: override per integrazione Spatie con catch `PermissionDoesNotExist`

### Test
- `Modules/User/tests/Unit/Models/OauthClientTest.php`

---

## OauthDeviceCode - Dettaglio implementazione

**RFC8628 Device Authorization Grant** - Codici dispositivo per autorizzazione su dispositivi limitati (TV, console).

### Model
- `OauthDeviceCode` estende `Laravel\Passport\DeviceCode`
- `$connection = 'user'`
- Relazioni: `client()`, `user()` (aggiunte perché DeviceCode vendor non le definisce)
- **Regola**: usare `XotData::make()->getUserClass()` per la relazione user, mai `config('auth.providers.users.model')`
- **PHPDoc**: `@property UserContract|null $user` (non `Model|null`)

### Policy
- `OauthDeviceCodePolicy` con permessi `oauth-device-code.view.any`, `oauth-device-code.view`, ecc.

### Resource
- `OauthDeviceCodeResource` in `Clusters/Passport/Resources/`
- Pages: ListOauthDeviceCodes, ViewOauthDeviceCode
- Azione revoke come OauthAuthCodeResource

### Traduzioni
- `lang/it/oauth_device_code.php` con navigation, fields, actions.revoke

---

## Riferimenti

- [passport-model-wrappers](passport-model-wrappers.md)
- [oauth-passport-model-wrappers](oauth-passport-model-wrappers.md)
- [passport-cluster-completion-status](passport-cluster-completion-status.md)
- [oauth-access-token-removal](oauth-access-token-removal.md)
