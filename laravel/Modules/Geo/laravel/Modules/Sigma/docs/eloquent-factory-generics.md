# Eloquent Factory Generics

## Regola

Le factory Eloquent che estendono `Illuminate\Database\Eloquent\Factories\Factory`
devono dichiarare il modello generico con PHPDoc:

```php
/**
 * @extends Factory<NomeModello>
 */
class NomeModelloFactory extends Factory
{
}
```

## Motivazione

PHPStan segnala `missingType.generics` quando una classe estende `Factory`
senza specificare il template `TModel`.

## Verifica

Usare la configurazione standard del progetto:

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/Sigma/database/factories --no-progress --error-format=table
```
