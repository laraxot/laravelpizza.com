# Data Objects in Laraxot

I Data Objects sono classi che incapsulano dati strutturati utilizzati in tutto il framework Laraxot. Utilizzano la libreria `spatie/laravel-data` e sono progettati per essere immutabili e facilmente trasferibili tra i vari componenti dell'applicazione.

## Struttura Tipica di un Data Object

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Datas;

use Spatie\LaravelData\Data;

class EsempioData extends Data
{
    public function __construct(
        public readonly string $proprieta1,
        public readonly int $proprieta2,
        public readonly array $proprieta3 = []
    ) {
    }

    /**
     * Create a new instance of this Data object.
     *
     * @return static
     */
    public static function make(): static
    {
        return new static();
    }
}
```

## Best Practices

1. **Immutabilità**: Usare `readonly` per le proprietà quando possibile per garantire l'immutabilità.
2. **Tipizzazione**: Specificare sempre i tipi delle proprietà e dei valori di ritorno dei metodi.
3. **Costruttore**: Definire tutte le proprietà nel costruttore, con valori predefiniti quando appropriato.
4. **Metodo `make()`**: Implementare un metodo `make()` che restituisca un'istanza della classe.

## Correzioni comuni per PHPStan

### Correzione per il metodo `make()`

Un errore comune segnalato da PHPStan è il tipo di ritorno del metodo `make()`. La correzione consiste nel sostituire `self` con `static`:

```php
// Errore: PHPStan segnala che il metodo dovrebbe restituire "static" ma restituisce "self"
public static function make(): self
{
    return new self();
}

// Correzione
public static function make(): static
{
    return new static();
}
```

Questa correzione garantisce che quando il metodo viene ereditato da classi figlie, restituisca il tipo corretto della classe figlia.

### Altri errori comuni

- **PHPDoc incompleto per le relazioni Eloquent**: Aggiungere tutti i tipi di template nella documentazione PHPDoc.
- **Accesso a proprietà inesistenti**: Verificare l'esistenza delle proprietà prima dell'accesso.
- **Tipo di ritorno `class-string`**: Usare asserzioni o casting appropriati quando si restituiscono stringhe che rappresentano classi. 