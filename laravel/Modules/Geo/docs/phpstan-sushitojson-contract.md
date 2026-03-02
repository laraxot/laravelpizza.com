# PHPStan: SushiToJsonContract per Comune

## Contesto

Il modello `Comune` usa il trait `SushiToJson` che richiede l'implementazione del contratto `SushiToJsonContract`.

## Problema

PHPStan segnalava: trait `SushiToJson` richiede che la classe implementi `SushiToJsonContract`.

## Soluzione

Aggiunto `implements SushiToJsonContract` alla classe `Comune`:

```php
use Modules\Tenant\Contracts\SushiToJsonContract;
use Xot\Traits\SushiToJson;

class Comune extends BaseModel implements SushiToJsonContract
{
    use SushiToJson;
    // ...
}
```

## Riferimenti

- [SushiToJsonContract](../../Tenant/app/Contracts/SushiToJsonContract.php)
- [00-index](00-index.md)
