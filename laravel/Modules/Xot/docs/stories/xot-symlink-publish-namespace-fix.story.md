# Story: correzione namespace di `SymlinkPublishCommand`

**Modulo owner:** Xot
**Stato:** done (verifica nella sessione del 2026-11-10)
**Supersede:** nulla. Storia nuova, non collegata ad altre story.

## Problema

`laravel/storage/logs/laravel.log` riportava tre errori in sequenza, tutti legati al comando `symlink:publish`:

1. `There are no commands defined in the "symlink" namespace` (10:41)
2. `Target class [Modules\Xot\Providers\SymlinkPublishCommand] does not exist` (10:42)
3. `Cannot redeclare class Modules\Xot\Commands\SymlinkPublishCommand` (10:43)

## Causa radice

Il file `Modules/Xot/app/Console/Commands/SymlinkPublishCommand.php` dichiarava
`namespace Modules\Xot\Commands;` mentre:

- il path PSR-4 è `Modules\Xot\Console\Commands\`;
- `XotServiceProvider` lo importa come `Modules\Xot\Console\Commands\SymlinkPublishCommand`
  (righe 35 e 266);
- tutte le altre command del modulo usano `Modules\Xot\Console\Commands`.

Il namespace non coincidente fa fallire l'autoload del comando e il provider non registra la command.

## Fix

Namespace del file portato a `Modules\Xot\Console\Commands`. Firma pubblica di `symlink:publish`
invariata: nessun altro cambio.

## Verifica

- `php -l` sul file: nessun errore di sintassi.
- `php artisan list --raw`: `symlink:publish` è registrato.
- `php artisan symlink:publish --dry-run`: esecuzione completa, nessuna eccezione. L'avviso
  `themes/Zero: symlink already exists` è informativo, non un errore.
- `storage/logs/laravel.log`: nessuna nuova voce dopo il fix; le 3 voci precedenti sono state rimosse.

## Note

- Il file è untracked nel repo: va committato insieme al fix.
