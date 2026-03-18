# OAuth Passport Model Wrappers

## Pattern

Every Laravel Passport model that extends `Model` must have a corresponding wrapper class in `Modules/User/app/Models/` with the `Oauth` prefix.

## Mapping

| Passport vendor class | Wrapper in User module |
|----------------------|----------------------|
| `Laravel\Passport\AuthCode` | `Modules\User\Models\OauthAuthCode` |
| `Laravel\Passport\Client` | `Modules\User\Models\OauthClient` |
| `Laravel\Passport\DeviceCode` | `Modules\User\Models\OauthDeviceCode` |
| `Laravel\Passport\RefreshToken` | `Modules\User\Models\OauthRefreshToken` |
| `Laravel\Passport\Token` | `Modules\User\Models\OauthToken` |

Additionally, `OauthPersonalAccessClient` extends `BaseModel` because no Passport vendor class exists for `oauth_personal_access_clients`.

## Why this pattern

- Centralize `$connection = 'user'` in one place per model
- Allow adding project-specific scopes, relations, casts without touching vendor code
- Enable PHPStan docblock annotations for all properties
- Register custom models in `PassportServiceProvider` via `Passport::useTokenModel(OauthToken::class)` etc.
- Allow custom policies: each `Oauth*` model has a corresponding `Oauth*Policy`

## Wrapper template

```php
<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Laravel\Passport\Token as PassportToken;

/**
 * @property string      $id
 * @property string|null $user_id
 * @property bool        $revoked
 * @property Carbon|null $expires_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|OauthToken newModelQuery()
 * @method static Builder|OauthToken newQuery()
 * @method static Builder|OauthToken query()
 *
 * @mixin \Eloquent
 */
class OauthToken extends PassportToken
{
    /** @var string */
    protected $connection = 'user';
}
```

## Files

- `Modules/User/app/Models/OauthToken.php`
- `Modules/User/app/Models/OauthAuthCode.php`
- `Modules/User/app/Models/OauthClient.php`
- `Modules/User/app/Models/OauthDeviceCode.php`
- `Modules/User/app/Models/OauthPersonalAccessClient.php`
- `Modules/User/app/Models/OauthRefreshToken.php`
- `Modules/User/app/Models/OauthToken.php`

## Rule

When upgrading Passport, always check `vendor/laravel/passport/src/*.php` for new classes that extend `Model`. Each new class needs a wrapper in `Modules/User/app/Models/Oauth{ClassName}.php`.
