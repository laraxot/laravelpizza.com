# No Orphan Http Controllers Memory

- I controller HTTP senza route attive o boundary dichiarato non devono restare nel repo.
- Un file in `app/Http/Controllers` non e' neutro: comunica un endpoint reale.
- Se la logica e' dominio puro, preferire action/service; se non e' integrata, rimuovere il file.
- Caso esplicito consolidato: `Modules/Notify/app/Http/Controllers/NotificationTrackingController.php` non deve stare nel modulo.
