# Meetup Profile Contract PHPDoc Governance

Nel modulo Meetup le relazioni audit/profile esposte nei PHPDoc dei model non devono dipendere da `Modules\Meetup\Models\Profile`.

Per campi come:
- `$creator`
- `$updater`
- `$deleter`

il tipo corretto e':

```php
\Modules\Xot\Contracts\ProfileContract|null
```

Questo mantiene i model Meetup allineati al contratto architetturale condiviso e impedisce che una wave `ide-helper` restringa i tipi a una implementazione concreta locale.
