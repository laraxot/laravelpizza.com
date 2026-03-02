# Correzione PHPStan - Relationship Type Hints

## 🚨 Errore PHPStan Risolto

**File**: `User/app/Models/Traits/HasAuthenticationLogTrait.php`  
**Errore**: Type mismatch per relazioni MorphMany/MorphOne

### Problema
```php
// ❌ ERRORE PHPStan
@return MorphMany<AuthenticationLog, static>
// PHPStan si aspetta: MorphMany<AuthenticationLog, $this>
```

### Causa
PHPStan ha regole specifiche per i template type delle relazioni Eloquent. Per relazioni polimorfiche, il secondo parametro template deve essere `$this` invece di `static` per garantire type covariance.

### Soluzione Implementata
```php
// ✅ CORRETTO
/**
 * @return MorphMany<AuthenticationLog, $this>
 */
public function authentications(): MorphMany
{
    return $this->morphMany(AuthenticationLog::class, 'authenticatable')
        ->latest('login_at');
}

/**
 * @return MorphOne<AuthenticationLog, $this>
 */
public function latestAuthentication(): MorphOne
{
    return $this->morphOne(AuthenticationLog::class, 'authenticatable')
        ->latestOfMany('login_at');
}
```

## 📋 Pattern per Relazioni Eloquent

### MorphMany/MorphOne
```php
// ✅ CORRETTO
@return MorphMany<RelatedModel, $this>
@return MorphOne<RelatedModel, $this>
```

### HasMany/HasOne  
```php
// ✅ CORRETTO
@return HasMany<RelatedModel>
@return HasOne<RelatedModel>
```

### BelongsTo
```php
// ✅ CORRETTO  
@return BelongsTo<RelatedModel, $this>
```

### BelongsToMany
```php
// ✅ CORRETTO
@return BelongsToMany<RelatedModel, $this>
```

## 🎯 Regola Generale

Per **tutte le relazioni Eloquent** in trait e modelli:
- Utilizzare `$this` come secondo parametro template per relazioni che lo richiedono
- Seguire la documentazione PHPStan per template covariance
- Verificare sempre con PHPStan Level 9 dopo modifiche

## Collegamenti

- [PHPStan Template Covariance](https://phpstan.org/blog/whats-up-with-template-covariant)
- [Eloquent Relationships](https://laravel.com/docs/12.x/eloquent-relationships)

