# Verifica delle Proprietà nei Modelli Eloquent

Questo documento definisce le regole per la tipizzazione e la verifica degli utenti all'interno dei modelli, delle action e delle policy in Laraxot PTVX.

## Tipizzazione degli Utenti

Nelle firme dei metodi e nelle annotazioni PHPDoc, **NON** utilizzare il tipo generico `\Illuminate\Database\Eloquent\Model|null` quando si fa riferimento a un utente autenticabile. Utilizzare invece `Modules\Xot\Contracts\UserContract`.

### ❌ ERRATO
```php
/**
 * @param \Illuminate\Database\Eloquent\Model|null $user
 */
public function viewAny(?Model $user): bool
{
    return true;
}
```

### ✅ CORRETTO
```php
use Modules\Xot\Contracts\UserContract;

/**
 * @param UserContract|null $user
 */
public function viewAny(?UserContract $user): bool
{
    return true;
}
```

## Ragionamento

L'utilizzo di `UserContract` garantisce:
1. **Chiarezza Semantica**: Sappiamo esplicitamente che stiamo lavorando con un utente del sistema.
2. **Accesso alle Proprietà**: `UserContract` definisce proprietà comuni come `$id`, `$email`, `$first_name`, `$last_name`, ecc., permettendo a PHPStan di verificare l'accesso a queste proprietà senza ricorrere a ignore-next-line.
3. **Metodi di Sistema**: Garantisce l'accesso a metodi critici come `hasRole()`, `hasPermissionTo()`, `profile()`, ecc.
4. **Agnoticismo del Modello**: Permette di cambiare l'implementazione del modello User (es. da `Modules\User\Models\User` a un altro modello) senza dover modificare tutte le firme dei metodi nel sistema.

## Applicazione nelle Policy

Tutte le Policy devono utilizzare `UserContract` per il parametro `$user`.

```php
use Modules\Xot\Contracts\UserContract;

class PostPolicy
{
    public function update(UserContract $user, Post $post): bool
    {
        return $user->id === $post->user_id || $user->hasRole('admin');
    }
}
```

## Applicazione nelle Action

Le Action che operano su utenti devono accettare `UserContract`.

```php
use Modules\Xot\Contracts\UserContract;

class UpdateUserProfileAction
{
    public function execute(UserContract $user, array $data): void
    {
        // ... logic
    }
}
```
