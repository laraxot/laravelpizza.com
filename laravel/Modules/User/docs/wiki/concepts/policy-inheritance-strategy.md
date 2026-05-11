# Policy Inheritance Strategy in Laraxot

## REGOLA PERMANENTE: Gerarchia corretta delle Policy Base

### Panoramica

Nel sistema Laraxot esistono due policy base che servono scopi diversi:

1. **`Modules\Xot\Models\Policies\XotBasePolicy`** - Base universale per tutti i moduli
2. **`Modules\User\Models\Policies\UserBasePolicy`** - Base specifica per il modulo User

### Vincolo assoluto

```
UserBasePolicy DEVE estendere XotBasePolicy
NON duplicare la logica di super-admin in entrambe le classi
```

### Perché

- **XotBasePolicy** fornisce funzionalità comuni a tutti i moduli (es. controllo super-admin)
- **UserBasePolicy** dovrebbe aggiungere logica specifica per il dominio utente
- Senza corretta gerarchia, si duplica codice e si crea confusione sui responsabilità

### Come applicare

1. **In XotBasePolicy**: mantenere la logica universale (super-admin, metodi base)
2. **In UserBasePolicy**: estendere XotBasePolicy e aggiungere logica specifica utente
3. **Rimuovere duplicazioni**: eliminare il metodo `before()` duplicato da UserBasePolicy

### Esempio corretto

```php
// Modules/Xot/Models/Policies/XotBasePolicy.php
namespace Modules\Xot\Models\Policies;

use Modules\Xot\Contracts\UserContract;

abstract class XotBasePolicy
{
    use HandlesAuthorization;

    public function before(UserContract $user, string $_ability): ?bool
    {
        return once(function () use ($user) {
            if ($user->hasRole('super-admin')) {
                return true;
            }
        });
    }

    public function viewAny(UserContract $userContract): bool
    {
        return false;
    }
}
```

```php
// Modules/User/Models/Policies/UserBasePolicy.php
namespace Modules\User\Models\Policies;

use Modules\Xot\Models\Policies\XotBasePolicy;

abstract class UserBasePolicy extends XotBasePolicy
{
    // Solo logica specifica per il dominio utente qui
    // Esempio:
    // public function update(UserContract $user, Model $model): bool
    // {
    //     return $user->id === $model->user_id;
    // }
}
```

### Verifica

```bash
# Controlla che UserBasePolicy estenda XotBasePolicy
grep -r "extends.*XotBasePolicy" laravel/Modules/User/app/Models/Policies/

# Verifica assenza di duplicazione super-admin
! grep -r "hasRole.*super-admin" laravel/Modules/User/app/Models/Policies/
```

### Documentazione correlata

- `Modules/Xot/docs/wiki/concepts/xotbasepolicy-architecture.md`
- `Modules/User/docs/wiki/concepts/userpolicy-domain-specific.md`
- Root wiki: `docs/wiki/concepts/laraxot-policy-inheritance.md`
