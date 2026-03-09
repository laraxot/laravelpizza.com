# PHPStan Level 10 Patterns - User Module

**Last Updated**: 2026-02-16  
**Related Issue**: #77

---

## Dynamic Method Call Type Safety

### ❌ Anti-Pattern: Dynamic Method Invocation
```php
// PHPStan cannot infer return type
return $this->stringHelper->of($email)
    ->before('@')
    ->$searchMethod('.') // ❌ Returns mixed
    ->trim();
```

###✅ Correct Pattern: Explicit Conditional Logic
```php
$emailPart = $this->stringHelper->of($email)
    ->before('@');

// Use conditional logic for type safety
if ($searchMethod === self::NAME_SEARCH) {
    return $emailPart->before('.')->trim()->title();
}

return $emailPart->after('.')->trim()->title();
```

**Rule**: When PHPStan reports `mixed` return types from dynamic method calls, replace with explicit conditional logic using constants.

---

## Backward Compatibility for Property Names

### ❌ Anti-Pattern: Breaking Change Without Alias
```php
class UserNameFieldsResolver
{
    public ?string $lastName; // ❌ Breaking change from $last_name
}

// Usage in other files will break
$userAttributes->last_name; // Error: property not found
```

### ✅ Correct Pattern: Add Compatibility Alias
```php
class UserNameFieldsResolver
{
    public ?string $lastName;
    public ?string $last_name; // Alias for backward compatibility

    public function __construct(User $user)
    {
        $this->lastName = $this->resolveSurname($user);
        $this->last_name = $this->lastName; // Set alias
    }
}
```

**Rule**: When refactoring property names (camelCase ↔ snake_case), maintain backward compatibility aliases until all consuming code is migrated.

---

## External Package Type Assertions

### ❌ Anti-Pattern: Trust `mixed` Returns
```php
// nwidart/laravel-modules returns mixed
$allModules = $this->moduleRepository->all();
$moduleKeys = array_keys($allModules); // ❌ PHPStan error: mixed given
```

### ✅ Correct Pattern: Runtime Type Guard + PHPDoc
```php
/** @var array<string, mixed> $allModules */
$allModules = $this->moduleRepository->all();

// Ensure $allModules is an array for PHPStan
if (! is_array($allModules)) {
    $this->error('Unable to retrieve modules.');
    return;
}

$moduleKeys = array_map('strval', array_keys($allModules));
```

**Rule**: For external packages returning `mixed`, add runtime `is_array()` guards and explicit PHPDoc hints.

---

## Laravel Prompts Type Contracts

### ❌ Anti-Pattern: Incorrect Array Value Types
```php
$modulesOpts = array_combine($keys, $keys); // array<int|string, int|string>
multiselect(options: $modulesOpts); // ❌ Expects array<int|string, string>
```

### ✅ Correct Pattern: Ensure String Values
```php
// Force all keys and values to strings
$moduleKeys = array_map('strval', array_keys($allModules));
/** @var array<int|string, string> $modulesOpts */
$modulesOpts = array_combine($moduleKeys, $moduleKeys);

multiselect(options: $modulesOpts); // ✅ Correct type
```

**Rule**: For Laravel Prompts functions, ensure all array values are explicitly cast to `string` using `array_map('strval', ...)`.

---

## PHPDoc Error Accuracy

### ❌ Anti-Pattern: Incorrect `@param` Tags
```php
/**
 * @param  OauthClient|string  $client  // ❌ Removed in method signature
 */
public function revokeClient(OauthClient|string $client): bool
{
    return $this->execute($client, false);
}
```

### ✅ Correct Pattern: Match PHPDoc to Method Signature
```php
/**
 * Revoca un client OAuth2 senza revocare i token associati.
 *
 * @param  OauthClient|string  $client  Il client da revocare (istanza o ID)
 * @return bool True se il client è stato revocato con successo
 */
public function revokeClient(OauthClient|string $client): bool
{
    return $this->execute($client, false);
}
```

**Rule**: Always ensure `@param` tags exactly match method signatures. Remove orphaned `@param` tags when refactoring.

---

## Verification Checklist

When fixing PHPStan errors:

- [ ] Run `phpstan analyse <file> --level=10` after each fix
- [ ] Check for breaking changes in public APIs
- [ ] Add backward compatibility aliases if needed
- [ ] Document type assertions with inline comments
- [ ] Update PHPDoc to match actual signatures
- [ ] Test with actual data to verify runtime behavior

---

## Related Files

- [`RevokeClientAction.php`](file:///var/www/_bases/base_laravelpizza/laravel/Modules/User/app/Actions/Passport/RevokeClientAction.php)
- [`UserNameFieldsResolver.php`](file:///var/www/_bases/base_laravelpizza/laravel/Modules/User/app/Actions/Socialite/Utils/UserNameFieldsResolver.php)
- [`AssignModuleCommand.php`](file:///var/www/_bases/base_laravelpizza/laravel/Modules/User/app/Console/Commands/AssignModuleCommand.php)

---

## Further Reading

- [PHPStan: Solving Access to Undefined Property](https://phpstan.org/blog/solving-phpstan-access-to-undefined-property)
- [PHPStan: Type Narrowing](https://phpstan.org/writing-php-code/narrowing-types)
- [PHPStan: Type Aliases](https://phpstan.org/writing-php-code/phpdoc-types#advanced-types)
