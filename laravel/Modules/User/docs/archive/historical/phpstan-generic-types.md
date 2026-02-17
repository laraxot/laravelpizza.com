# Risoluzione Problemi di Tipi Generici con PHPStan

## Problema: Template Type Covariance nelle Relazioni Eloquent

PHPStan a livello 8 rileva errori nei tipi generici delle relazioni Eloquent, in particolare nella classe `BelongsToMany`. L'errore riportato è:

```
Template type TRelatedModel on class Illuminate\Database\Eloquent\Relations\BelongsToMany is not covariant.
Template type TDeclaringModel on class Illuminate\Database\Eloquent\Relations\BelongsToMany is not covariant.
```

## Causa

Questo errore si verifica perché i tipi di template (tipi generici) nelle relazioni Eloquent non sono definiti come covarianti. Nei tipi generici, la covarianza permette di utilizzare un tipo più specifico in un contesto che si aspetta un tipo più generico.

In particolare, nelle relazioni `BelongsToMany`, PHPStan si aspetta che i tipi generici siano correttamente annotati per indicare quali modelli sono coinvolti nella relazione.

## Soluzione

Per risolvere questo problema, dobbiamo seguire queste linee guida:

1. **Utilizzare annotazioni PHPDoc precise**:

```php
/**
 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\Device>
 */
```

2. **Specificare entrambi i tipi generici** (se necessario):

```php
/**
 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\Device, \App\Models\User>
 */
```

3. **Utilizzare classi concrete nei tipi generici**:

Nelle annotazioni PHPDoc, utilizzare il tipo concreto effettivo invece di un tipo astratto o un'interfaccia.

4. **Considerare l'utilizzo dell'approccio static**:

In alcuni casi, è possibile utilizzare `@return static` per evitare problemi di tipo generico.

## Esempio Corretto

```php
/**
 * Relazione con i dispositivi mobili associati al profilo.
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\Modules\User\Models\Device>
 */
public function mobileDevices(): BelongsToMany
{
    return $this->belongsToMany(Device::class, 'mobile_device_users', 'profile_id', 'device_id')
        ->withPivot('token')
        ->withTimestamps();
}
```

## Nota Importante per Laraxot

Secondo i principi del framework Laraxot, è fondamentale utilizzare contratti (interfacce) invece di classi concrete nelle relazioni. Questo può creare tensione con i requisiti di PHPStan per tipi generici covarianti.

Una soluzione di compromesso potrebbe essere:

1. Mantenere l'uso di contratti nel codice effettivo
2. Utilizzare annotazioni PHPDoc che specificano le classi concrete per soddisfare PHPStan
3. Se necessario, utilizzare annotazioni di soppressione di PHPStan per casi specifici

```php
/**
 * @phpstan-return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\Modules\User\Models\Device>
 */
public function devices(): BelongsToMany
{
    return $this->belongsToMany(DeviceContract::class, ...);
}
```

## Risorse Utili

- [PHPStan Blog: What's Up With Template Covariant](https://phpstan.org/blog/whats-up-with-template-covariant)
- [Documentazione PHPStan sui tipi generici](https://phpstan.org/blog/generics-in-php-using-phpdocs)
- [Laravel PHPStan extension](https://github.com/larastan/larastan)
