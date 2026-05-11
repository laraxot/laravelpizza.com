# Spatie Permission Team Model Not Configured

## Context

Su route admin (`/admin`) il menu utente Filament invoca il cambio team (`Modules\User\Http\Livewire\Team\Change`), che passa da `HasRoles` di Spatie Permission.
Con `teams` abilitato in config, Spatie richiede esplicitamente `permission.models.team`.

## Error

`Spatie\Permission\Exceptions\TeamModelNotConfigured` con messaggio:
`No team model configured. Set models.team in your permission config file.`

## Root Cause

La configurazione `permission.php` aveva:
- `teams => true`
- `column_names.team_foreign_key => 'team_id'`

ma mancava la chiave:
- `models.team => Modules\User\Models\Team::class`

Questo causava eccezione runtime quando Spatie tentava di risolvere il model team durante check ruoli/permessi con scope team.

## Fix Applied

Aggiunta la voce `models.team` in tutti i profili config attivi, per evitare drift tra ambienti:

- `../../../../../config/permission.php`
- `../../../../../config/localhost/permission.php`
- `../../../../../config/local/fixcity/permission.php`
- `../../../../../config/local/fixcityam/permission.php`
- `../../../../../config/eu/fixcity/permission.php`
- `../../../../../config/test/fixcity/permission.php`

Valore impostato:

```php
'team' => Modules\User\Models\Team::class,
```

## Verification

1. cache config pulita con `php artisan optimize:clear`;
2. verifica runtime con:
   `php artisan tinker --execute="dump(config('permission.models.team'));"`;
3. output atteso:
   `Modules\User\Models\Team`.

## Best Practices

- quando `teams` e' `true`, trattare `models.team` come requisito obbligatorio;
- mantenere allineati tutti i file `config/*/permission.php` per evitare bug solo su specifici ambienti;
- dopo fix config, eseguire sempre clear cache prima del recheck route.

## Related

- `../index.md`
- `../../../../../docs/wiki/concepts/laravel-permission.md`
