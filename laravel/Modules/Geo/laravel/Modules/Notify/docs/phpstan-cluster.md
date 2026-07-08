# PHPStan Cluster - 2026-03-10

## Stato attuale

Il cluster `Notify` emerso dal run globale non e' causato da type hints sofisticati, ma da riferimenti a modelli mancanti o rimasti in file non canonici.

## Root cause principali

### 1. Modelli log/canale non risolti

- `NotificationLog` viene usato da command, controller e factory, ma nel modulo il file canonico non e' presente come `app/Models/NotificationLog.php`.
- Esistono solo file storici o rinominati (`.old*`, `.up`), che PHPStan ignora correttamente.

### 2. Factory verso modello inesistente

- `NotificationChannelFactory` punta a `Modules\Notify\Models\NotificationChannel`, ma il modello non esiste nello stato attuale del modulo.

## Regola operativa

- Prima ripristinare classi canoniche nel namespace e percorso corretti.
- Poi riallineare factory, controller e command al contratto del modello reale.
- Evitare di mascherare il problema con `class_alias` o ignore statici finche' manca il file canonico.

Decisione applicativa:

- `NotificationLog` va ripristinato come file canonico `app/Models/NotificationLog.php`.
- `NotificationChannel` va reintrodotto come modello minimale e factory-backed, perche' test e factory del modulo lo usano gia' come contratto pubblico.

## Aggiornamento 2026-03-12

- Il contratto `SendNotificationAction` -> `SendNotificationJob` -> `NotificationManager` va riallineato sul model reale `Modules\Notify\Models\Notification` per il canale `database`.
- `FirebaseCloudMessagingChannel` deve restringere il payload passato a `Messaging::sendMulticast()` a `Kreait\Firebase\Messaging\Message|array`, senza propagare `object` generico dal contract.
