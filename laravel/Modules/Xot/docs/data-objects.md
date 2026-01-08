# Data Objects

## Principi Fondamentali

1. **Struttura**:
   - I Data Objects sono in `Modules\{Module}\Datas`
   - I namespace sono `Modules\{Module}\Datas`
   - Estendono `Spatie\LaravelData\Data`

2. **Scopo**:
   - Validazione dei dati
   - Trasporto dei dati tra layer
   - Type safety
   - Immutabilità

## Implementazione

1. **Struttura Base**:
   ```php
   <?php

   declare(strict_types=1);

   namespace Modules\Module\Datas;

   use Spatie\LaravelData\Data;

   class ExampleData extends Data
   {
       public function __construct(
           public ?string $field,
       ) {
       }
   }
   ```

2. **Validazione**:
   ```php
   public static function rules(): array
   {
       return [
           'field' => ['required', 'string'],
       ];
   }
   ```

## Best Practices

1. **Validazione**:
   - Implementare sempre `rules()`
   - Usare tipi di ritorno stretti
   - Documentare le regole di business

2. **Tipizzazione**:
   - Usare tipi di ritorno PHP 8
   - Usare nullable quando appropriato
   - Documentare i tipi complessi

3. **Documentazione**:
   - Aggiungere docblock per la classe
   - Documentare le proprietà
   - Aggiungere esempi di utilizzo

## Errori Comuni

1. **Errore**: Directory errata
   - ❌ `/var/www/html/<nome progetto>/Modules/Module/Datas/`
   - ✅ `/var/www/html/<nome progetto>/laravel/Modules/Module/Datas/`

2. **Errore**: Namespace errato
   - ❌ `namespace Modules\Module\App\Datas;`
   - ✅ `namespace Modules\Module\Datas;`

3. **Errore**: Validazione mancante
   - ❌ Manca `rules()`
   - ✅ Implementare `rules()`

## Collegamenti

- [Data Objects Patient](../Patient/docs/data-objects.md)
- [Best Practices](./best-practices.md)
- [Convenzioni di Codice](./coding-standards.md) 
