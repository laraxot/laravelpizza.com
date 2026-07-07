# Quick Reference - Filament

## Errori comuni

- `Table [...] must have a [query()], [relationship()], or [records()]`
  - Causa probabile: conflitto lifecycle tabella (trait Filament riusato in modo improprio).
  - Check:
    - page list estende `XotBaseListRecords`
    - nessun override anomalo di `table()`
    - `HasXotTable` non usa `InteractsWithTable`

- `Access level ... must be public/protected`
  - Causa probabile: visibilita metodo non allineata con trait/classe Filament 5.
  - Check firma metodo nel trait/vendor e riallinea visibilita.

## File chiave

- `laravel/Modules/Xot/app/Filament/Traits/HasXotTable.php`
- `laravel/Modules/Xot/app/Filament/Resources/Pages/XotBaseListRecords.php`
- `laravel/Modules/*/app/Filament/Resources/*/Pages/List*.php`

## Comandi utili

```bash
cd laravel
php artisan optimize:clear
vendor/bin/phpstan analyse Modules/Xot Modules/Quaeris
```
