# Memory: Notify Tracking Controller Removed

- Regola: niente `NotificationTrackingController` nel modulo Notify.
- Motivo: architettura action/channel-first, no controller legacy.
- Il tracking notifiche non appartiene al tema e non deve vivere in un endpoint controller monolitico.
- Se compare di nuovo un controller simile, va trattato come regressione architetturale.
- Se serve correggere un errore collegato, la fix resta forward-only: nessun revert del repository come scorciatoia.
