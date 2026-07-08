# Pattern PHPStan Ptv

## Collection Eloquent e contratti

Le `EloquentCollection` devono usare template che estendono `Model`.
Quando il codice deve lavorare con un contratto applicativo, restringere la collection nel punto d'uso:

```php
$criteri = $criteriEsclusione
    ->filter(static fn (mixed $criterio): bool => $criterio instanceof CriteriEsclusioneContract)
    ->values()
    ->toBase();
```

Questo evita invariance tra `EloquentCollection<int, Model>` e `Collection<int, Contract>`.

## Spread Filament

Se una lista viene espansa in uno schema Filament, la property deve essere tipizzata con il componente reale:

```php
/** @var array<string, Component> */
public array $fields = [];
```

E il metodo deve dichiarare:

```php
/** @return array<int|string, Component> */
```

## Array con chiavi stringa

Per passare dati a metodi che accettano `array<string, mixed>`, normalizzare le chiavi:

```php
$validatedData = [];
foreach ($data as $key => $value) {
    if (is_string($key)) {
        $validatedData[$key] = $value;
    }
}
```

## Spatie DataCollection

`Data::collect(..., DataCollection::class)` puo' produrre chiavi `int|string` e `static`.
Allineare la PHPDoc al comportamento reale:

```php
/**
 * @param  array<int, mixed>  $data
 * @return DataCollection<int|string, static>
 */
```
