# Contratti del Modulo Xot

## Descrizione
Il modulo Xot definisce vari contratti (interfacce) che standardizzano il comportamento dei modelli e delle classi nel sistema Laraxot.

## UserContract

### Ubicazione
`Modules\Xot\Contracts\UserContract`

### Scopo
Definisce l'interfaccia per tutti i modelli User nel sistema, includendo autenticazione, autorizzazione, ruoli, permessi e media.

### Problema Critico Identificato (2025-01-06)

**ERRORE PHPSTAN**: Il metodo `hasPermissionTo()` è utilizzato in tutte le policy ma non è definito nel contratto `UserContract`.

**Impatto**: 350+ errori PHPStan nel modulo User e altri moduli che utilizzano policy.

### Interfacce Estese
```php
interface UserContract extends 
    Authenticatable, 
    Authorizable, 
    CanResetPassword, 
    FilamentUser, 
    HasTeamsContract, 
    ModelContract, 
    MustVerifyEmail, 
    PassportHasApiTokensContract,
    HasMedia
```

### Metodi Attualmente Definiti
- `profile(): HasOne`
- `getRelationValue($key)`
- `newInstance($attributes = [], $exists = false)`
- `getKey()`
- `hasRole(...): bool`
- `assignRole(...)`
- `removeRole($role)`
- `roles(): BelongsToMany`
- `tenants(): BelongsToMany`

### Metodi Mancanti Identificati
- `hasPermissionTo(string $permission): bool` - **CRITICO**

## Soluzione Proposta

### Opzione 1: Aggiungere hasPermissionTo() al UserContract
```php
/**
 * Check if user has specific permission.
 *
 * @param string $permission
 * @return bool
 */
public function hasPermissionTo(string $permission): bool;
```

### Opzione 2: Estendere Interfaccia Spatie Permission
Fare in modo che il `UserContract` estenda anche l'interfaccia di Spatie Permission che definisce `hasPermissionTo()`.

### Implementazione Corrente
Attualmente tutte le policy assumono che `UserContract` abbia il metodo `hasPermissionTo()` ma non è definito nell'interfaccia.

## Altri Contratti

### ModelContract
Contratto base per tutti i modelli del sistema.

### ProfileContract
Contratto per i profili utente.

### ModelProfileContract
Contratto per modelli che hanno profili.

## Best Practices

1. **Coerenza**: Tutti i metodi utilizzati dalle implementazioni devono essere definiti nel contratto
2. **Documentazione**: Ogni metodo del contratto deve avere PHPDoc completo
3. **Tipizzazione**: Utilizzare tipi specifici invece di mixed quando possibile
4. **Compatibilità**: Mantenere compatibilità con le interfacce Laravel e package esterni

## Implementazione Prioritaria

**ALTA PRIORITÀ**: Risolvere il problema `hasPermissionTo()` per eliminare 350+ errori PHPStan.

## Collegamenti
- [Policy PHPStan Errors](../User/project_docs/policy-phpstan-errors.md)
- [Root PHPStan Errors](../../project_docs/troubleshooting/phpstan-errors.md)
- [Spatie Permission Documentation](https://spatie.be/project_docs/laravel-permission)

*Ultimo aggiornamento: 2025-01-06*
