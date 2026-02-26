# PHPStan Best Practices per Relazioni Eloquent

## Regola Fondamentale

Per evitare errori PHPStan di covarianza, **NON utilizzare annotazioni generiche** nelle relazioni Eloquent. Mantenere solo la tipizzazione del metodo e documentazione descrittiva.

## Pattern Corretto

### ✅ DO - Rimuovere Annotazioni Generiche Problematiche

```php
/**
 * Get the user.
 */
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}

/**
 * Get the comments.
 */
public function comments(): HasMany
{
    return $this->hasMany(Comment::class);
}

/**
 * Get the commentable model.
 */
public function commentable(): MorphTo
{
    return $this->morphTo();
}
```

### ❌ DON'T - Non utilizzare annotazioni generiche

```php
/**
 * @return BelongsTo<User, Post>  // ❌ ERRORE PHPStan di covarianza
 */
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}

/**
 * @return HasMany<Comment, self>  // ❌ ERRORE PHPStan di covarianza
 */
public function comments(): HasMany
{
    return $this->hasMany(Comment::class);
}

/**
 * @return MorphTo<Model, self>  // ❌ ERRORE PHPStan di covarianza
 */
public function commentable(): MorphTo
{
    return $this->morphTo();
}
```

## Tipi di Relazioni Supportate

### BelongsTo
```php
/**
 * Get the parent model.
 */
public function parent(): BelongsTo
{
    return $this->belongsTo(ParentModel::class);
}
```

### HasOne
```php
/**
 * Get the child model.
 */
public function child(): HasOne
{
    return $this->hasOne(ChildModel::class);
}
```

### HasMany
```php
/**
 * Get the children models.
 */
public function children(): HasMany
{
    return $this->hasMany(ChildModel::class);
}
```

### BelongsToMany
```php
/**
 * Get the related models.
 */
public function relatedModels(): BelongsToMany
{
    return $this->belongsToMany(RelatedModel::class);
}
```

### MorphTo
```php
/**
 * Get the morphable model.
 */
public function morphable(): MorphTo
{
    return $this->morphTo();
}
```

### MorphOne
```php
/**
 * Get the morph child model.
 */
public function morphChild(): MorphOne
{
    return $this->morphOne(ChildModel::class, 'morphable');
}
```

### MorphMany
```php
/**
 * Get the morph children models.
 */
public function morphChildren(): MorphMany
{
    return $this->morphMany(ChildModel::class, 'morphable');
}
```

## Motivazione Tecnica

### Problema della Covarianza
PHPStan non supporta completamente la covarianza dei tipi generici. Quando si utilizza il nome esplicito della classe come secondo parametro generico, PHPStan genera errori del tipo:

```
Method Model::relation() should return BelongsTo<User, Model> 
but returns BelongsTo<User, $this(Model)>.
```

### Soluzione: Rimozione Annotazioni Generiche
La rimozione delle annotazioni generiche risolve il problema perché:
1. **Nessun conflitto di covarianza**: PHPStan non deve gestire tipi generici problematici
2. **Tipizzazione mantenuta**: Il tipo di ritorno del metodo (`BelongsTo`, `HasMany`, etc.) è preservato
3. **Compatibilità garantita**: Funziona con tutte le versioni di PHPStan e Laravel
4. **Codice più pulito**: Meno annotazioni complesse da mantenere

## Esempi Pratici per Moduli Laraxot

### Modulo User
```php
namespace Modules\User\Models;

class User extends BaseModel
{
    /**
     * Get the posts created by this user.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the roles assigned to this user.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
}
```

### Modulo Blog
```php
namespace Modules\Blog\Models;

class Post extends BaseModel
{
    /**
     * Get the author of this post.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the comments for this post.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the tags associated with this post.
     */
    public function tags(): MorphMany
    {
        return $this->morphMany(Tag::class, 'taggable');
    }
}
```

## Checklist di Verifica

Prima di committare modelli con relazioni, verificare:

- [ ] Tutte le relazioni hanno documentazione descrittiva chiara
- [ ] **NO** annotazioni generiche `@return RelationType<Model, self>`
- [ ] I tipi di relazione sono corretti nel tipo di ritorno del metodo
- [ ] PHPStan livello 9+ passa senza errori
- [ ] **MAI** modificare `/var/www/html/_bases/base_<nome progetto>/laravel/phpstan.neon`

## Verifica PHPStan

```bash
# Test modello singolo
./vendor/bin/phpstan analyze Modules/ModuleName/app/Models/ModelName.php --level=9

# Test tutti i modelli di un modulo
./vendor/bin/phpstan analyze Modules/ModuleName/app/Models/ --level=9

# Test completo
./vendor/bin/phpstan analyze --level=9
```

## Automazione con IDE

### PHPStorm/Cursor Live Templates
Creare live template per relazioni:

```php
/**
 * @return BelongsTo<$MODEL$, self>
 */
public function $NAME$(): BelongsTo
{
    return $this->belongsTo($MODEL$::class);
}
```

### VS Code Snippets
```json
{
  "Eloquent BelongsTo": {
    "prefix": "belongsTo",
    "body": [
      "/**",
      " * @return BelongsTo<${1:Model}, self>",
      " */",
      "public function ${2:relation}(): BelongsTo",
      "{",
      "    return \\$this->belongsTo(${1:Model}::class);",
      "}"
    ]
  }
}
```

## Errori Comuni e Soluzioni

### Errore: "Template type not covariant"
**Causa**: Uso del nome della classe invece di `self`
**Soluzione**: Sostituire con `self`

### Errore: "Missing generic type"
**Causa**: Annotazione PHPDoc mancante o incompleta
**Soluzione**: Aggiungere annotazione completa con generics

### Errore: "Wrong relationship type"
**Causa**: Tipo di relazione errato nell'annotazione
**Soluzione**: Verificare che il tipo corrisponda al metodo Eloquent utilizzato

## Integrazione nei Template di Modulo

Tutti i template di generazione modelli devono includere annotazioni corrette:

```php
// Template per BaseModel
/**
 * @return BelongsTo<{{relatedModel}}, self>
 */
public function {{relationName}}(): BelongsTo
{
    return $this->belongsTo({{relatedModel}}::class);
}
```

## Conclusione

L'uso di `self` nelle annotazioni PHPDoc delle relazioni Eloquent è la best practice raccomandata per tutti i moduli Laraxot. Garantisce compatibilità PHPStan, mantiene la tipizzazione forte e segue le convenzioni Laravel.

---

**Applicabile a**: Tutti i moduli Laraxot  
**PHPStan Version**: 1.10+  
**Laravel Version**: 10+  
**Priorità**: Alta (Obbligatorio per nuovi modelli)  
**Stato**: ✅ Standard Adottato
