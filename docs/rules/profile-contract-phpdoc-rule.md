# Profile Contract PHPDoc Rule

## Regola

Nei PHPDoc dei model, le relazioni audit/profile come:

- `$creator`
- `$updater`
- `$deleter`

non devono puntare a un model concreto `Modules\*\Models\Profile`.

Devono invece essere annotate con:

```php
\Modules\Xot\Contracts\ProfileContract|null
```

## Motivo

- il chiamante dipende dal contratto, non dall'implementazione concreta del profilo;
- evita accoppiamento improprio tra moduli;
- rende piu' stabile il risultato di `ide-helper:models -W`;
- mantiene i PHPDoc coerenti con l'architettura contract-first del progetto.
