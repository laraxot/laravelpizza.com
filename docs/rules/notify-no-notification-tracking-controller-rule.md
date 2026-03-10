# Notify: No NotificationTrackingController

`Modules/Notify/app/Http/Controllers/NotificationTrackingController.php` non e' ammesso.

Motivazione architetturale:
- il tracking non e' una UI controller concern, ma una responsabilita' di dominio Notify;
- un controller legacy accorpa transport HTTP, mutazioni del log e redirect in un punto poco riusabile;
- l'approccio corretto nel progetto e' action/channel-first, con responsabilita' piccole e testabili.

Regola operativa:
- niente controller dedicati al tracking nel modulo Notify;
- il tracking di open/click va orchestrato tramite action o service dedicati;
- le route, se servono, devono restare sottili e delegare subito al dominio;
- il tema non deve implementare o governare endpoint di tracking notifiche.
- la ricomparsa di `NotificationTrackingController.php` va trattata come regressione architetturale.

Alternative consentite:
- action class dedicate;
- channel notification handlers;
- route/pipeline allineate al dominio Notify.
