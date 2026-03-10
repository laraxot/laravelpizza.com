# Notify Rule: No NotificationTrackingController

Nel modulo Notify non deve esistere `app/Http/Controllers/NotificationTrackingController.php`.

Motivazione:
- il tracking notifiche va gestito tramite Actions/Channels dedicati,
- evitare controller legacy non allineati alla struttura corrente,
- ridurre superfici HTTP non governate dal flusso modulo.

Conseguenza operativa:
- rimuovere il file controller dal runtime,
- mantenere eventuale tracking dentro action class testabili e servizi di canale,
- non spostare questa responsabilita' nel tema o nei file Folio/Blade.
