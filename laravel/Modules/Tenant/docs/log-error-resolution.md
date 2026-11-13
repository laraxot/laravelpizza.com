# Risoluzione errori di bootstrap e log

## Causa

Il file `GetTenantFilePathAction.php` conteneva marker di conflitto Git annidati
(`<<<<<<<`, `=======`, `>>>>>>>`). Il file non era PHP valido e il bootstrap
falliva mentre caricava la configurazione tenant. Laravel registrava quindi sia
il `ParseError` sia l'errore secondario `Log [] is not defined`, perché il logger
non riusciva a inizializzarsi durante la gestione dell'eccezione.

## Correzione

La risoluzione conserva entrambe le intenzioni compatibili: prepara la copia
isolata dei contenuti tenant per i test e usa il path sorgente per inizializzare
la copia sotto `storage/framework/testing/tenant-content`.

## Verifica

- `php -l Modules/Tenant/app/Actions/Config/GetTenantFilePathAction.php`
- `php artisan about`
- `php artisan optimize`
- nessun marker di conflitto nei sorgenti PHP, Blade, JS o JSON

> **Verifica del 2026-11-12 (sessione di triage, misurata):** la frase barrata qui sotto
> era falsa. `laravel/storage/logs/archive/2026-11-12-error-cleanup/` contiene
> `laravel.log` (0 byte) e `laravel-2026-11-12.log` (14 KB, 78 righe); **non c'e'**
> nessun file dell'11/11 e il resto (circa 42 MB) non e' recuperabile (ext4 locale,
> senza snapshot). Gli errori storici NON sono stati conservati per intero. Il metodo
> corretto e' in `Modules/Xot/docs/stories/xot-log-triage-after-log-wipe.story.md`:
> copia prima, riscrittura in place togliendo solo i blocchi risolti, mai azzerare.

~~Gli errori precedenti sono stati conservati nell'archivio del log e rimossi dal
file operativo corrente; non sono stati cancellati senza copia di recupero.~~
