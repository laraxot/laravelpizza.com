# PHPStan: Firebase e Mobile Push Notification

## Contesto

Il modulo Notify usa Kreait Firebase e FCM per push notification. Le classi Kreait non sono sempre analizzate da PHPStan.

## Correzioni applicate

### 1. Contratto MobilePushNotification

Creato `app/Contracts/MobilePushNotification.php` con metodi `toArray()` e `toCloudMessage()` per type safety.

### 2. SendPushNotification e SendPushNotificationPage

- Uso di `class_exists()` e nomi di classe come stringhe per Kreait
- `@phpstan-ignore-next-line method.nonObject` per catene su `CloudMessage` ottenute dinamicamente

### 3. FirebaseAndroidNotification

- `class_exists()` per Kreait e FcmChannel
- `@phpstan-ignore-next-line method.nonObject` per `withAndroidConfig()` e `withData()`

### 4. MailTemplateVersion

- Rimosso import inesistente `MailTemplateVersionFactory`
- PHPDoc `factory()` aggiornato a `\Illuminate\Database\Eloquent\Factories\Factory<static>`

## Pattern

Per dipendenze opzionali (Kreait, FCM): usare `class_exists()` e `@phpstan-ignore` solo dove necessario.
