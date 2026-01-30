# Regole per Model Casts in Base

## IMPORTANTE: Proprietà `$casts` Deprecata

Nel progetto Base, l'utilizzo della proprietà `$casts` nei modelli Eloquent è **deprecato**.

### ❌ NON utilizzare:

```php
protected $casts = [
    'birth_date' => 'date',
    'is_active' => 'boolean',
];
```

### ✅ Utilizzare invece il metodo `casts()`:

```php
protected function casts(): array
{
    return [
        'birth_date' => 'date',
        'is_active' => 'boolean',
        // Includere anche i cast ereditati dal modello base
        ...(parent::casts()),
    ];
}
```

## Vantaggi del metodo `casts()`

1. **Tipizzazione più forte**: Il metodo `casts()` restituisce un array tipizzato `array<string, string>`
2. **Ereditarietà più chiara**: Permette di estendere facilmente i cast dalla classe genitore
3. **Maggiore flessibilità**: Consente logica dinamica nella definizione dei cast
4. **Coerenza**: Allineamento con altre moderne pratiche di Laravel
5. **IDE Support**: Migliore supporto negli IDE per completamento e suggerimenti

## Implementazione nelle Classi Base

La classe `XotBaseModel` implementa già un metodo `casts()` base con diversi cast comuni:

```php
protected function casts(): array
{
    return [
        'id' => 'string',
        'uuid' => 'string',
        'published_at' => 'datetime',
        'verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'updated_by' => 'string',
        'created_by' => 'string',
        'deleted_by' => 'string',
    ];
}
```

Quando estendi questa classe, assicurati di includere i cast del genitore con:

```php
protected function casts(): array
{
    return array_merge(parent::casts(), [
        // Tuoi cast specifici
        'birth_date' => 'date',
        'is_active' => 'boolean',
    ]);
}
```

Ultima modifica: 01/04/2025
