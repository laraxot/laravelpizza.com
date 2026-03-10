# Meetup: audit relation PHPDoc must use ProfileContract

## Regola locale

Nel modulo `Meetup`, i PHPDoc di `creator`, `updater` e `deleter` non devono referenziare `Modules\Meetup\Models\Profile`.

Il tipo corretto e':

```php
\Modules\Xot\Contracts\ProfileContract|null
```

## Perche'

- `Meetup` consuma un profilo di dominio condiviso;
- il dettaglio implementativo del profilo puo' cambiare;
- il contratto condiviso mantiene il modulo piu' DRY, KISS e riusabile.
