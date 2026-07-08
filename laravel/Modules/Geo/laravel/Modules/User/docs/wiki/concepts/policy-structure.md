---
name: user-policy-structure
description: Policy architecture for User module vs Xot base policy
---
# User vs Xot Policy Structure

## Overview
The project follows a **separation-of-concerns** approach for authorization policies:
- **`UserBasePolicy`** (`laravel/Modules/User/app/Models/Policies/UserBasePolicy.php`) contains rules that are *specific to the `users` table* and to `User`‑related features (login, socialite linking, profile privacy, etc.).
- **`XotBasePolicy`** (located in the Xot module) defines *generic, cross-module policies* that operate on Xot-wid concepts such as **roles**, **capabilities**, and **global resources**.

## When to extend which policy
| Situation | Extend | Reason |
|-----------|--------|--------|
| Logic dealing with **user credentials**, **profile fields**, **socialite connections**, **password reset**, etc. | `UserBasePolicy` | Keeps user-centric rules close to the User module, easier to test and document. |
| Logic applying to **any Xot entity** (e.g., generic `viewAny`, `create`, `delete` for Xot resources) | `XotBasePolicy` | Ensures single source of truth for Xot-wide permissions, avoids duplication. |
| Shared logic reusable by both modules (e.g., `super-admin` bypass) | Place in a **trait** (e.g., `HandlesSuperAdmin`) and use in both policies. |

## Recommended structure
```php
namespace Modules\User\Models\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;

abstract class UserBasePolicy {
    use HandlesAuthorization;
    use HandlesSuperAdmin; // trait with before() that checks super-admin

    public function before(UserContract $user, string $ability): ?bool {
        // super-admin shortcut handled in trait
        return null;
    }
    // ... user-specific methods (updateProfile, linkSocialite, etc.)
}
```
```php
namespace Modules\Xot\Models\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Xot\Contracts\UserContract;

abstract class XotBasePolicy {
    use HandlesAuthorization;
    use HandlesSuperAdmin;
    // Generic methods (viewAny, create, delete) for Xot models
}
```

## Benefits of keeping them separate
- **Single Responsibility** – each policy only knows about its domain.
- **Testability** – unit tests can focus on the module they belong to.
- **Future extensibility** – new modules can inherit from `XotBasePolicy` without User-specific logic.
- **Documentation clarity** – each module’s `docs/wiki/concepts` has a concise policy guide.

---
> **Note**: Do **not** merge the files. They serve distinct purposes and keeping them separate respects the *One Migration per Model* philosophy of the codebase.