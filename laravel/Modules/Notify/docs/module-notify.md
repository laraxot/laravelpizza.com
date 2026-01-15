# Modulo Notify

## Informazioni Generali
- **Nome**: `laraxot/module_notify_fila3`
- **Descrizione**: Modulo dedicato alla gestione delle notifiche
- **Namespace**: `Modules\Notify`
- **Repository**: https://github.com/laraxot/module_notify_fila3.git

## Service Providers
1. `Modules\Notify\Providers\NotifyServiceProvider`
2. `Modules\Notify\Providers\Filament\AdminPanelProvider`

## Struttura
```
app/
├── Filament/       # Componenti Filament
├── Http/           # Controllers e Middleware
├── Models/         # Modelli del dominio
├── Providers/      # Service Providers
└── Services/       # Servizi di notifica
```

## Dipendenze
### Pacchetti Required
- `aws/aws-sdk-php`
- `filament/filament`
- `irazasyed/telegram-bot-sdk`
- `kreait/laravel-firebase`
- `laravel-notification-channels/fcm`
- `laravel-notification-channels/telegram`: ^5.0
- `symfony/http-client`
- `symfony/postmark-mailer`

### Moduli Required
- Xot
- Tenant
- UI

## Database
### Factories
Namespace: `Modules\Notify\Database\Factories`

### Seeders
Namespace: `Modules\Notify\Database\Seeders`

## Testing
Comandi disponibili:
```bash
composer test           # Esegue i test
composer test-coverage  # Genera report di copertura
composer analyse       # Analisi statica del codice
composer format        # Formatta il codice
```

## Funzionalità
- Notifiche Email
  - SMTP
  - Amazon SES
  - Postmark
- Notifiche Push
  - Firebase Cloud Messaging
  - Web Push
- Notifiche Telegram
- Notifiche SMS
- Notifiche WhatsApp
- Code asincrona
- Templates personalizzabili

## Configurazione
### Providers
- Configurazione in `config/services.php`
- Chiavi richieste in `.env`:
  ```
  MAIL_MAILER=
  AWS_ACCESS_KEY_ID=
  AWS_SECRET_ACCESS_KEY=
  TELEGRAM_BOT_TOKEN=
  FIREBASE_CREDENTIALS=
  ```

## Best Practices
1. Seguire le convenzioni di naming Laravel
2. Documentare tutte le classi e i metodi pubblici
3. Mantenere la copertura dei test
4. Utilizzare il type hinting
5. Seguire i principi SOLID
6. Implementare rate limiting
7. Gestire fallback per notifiche
8. Monitorare le code

## Troubleshooting
### Problemi Comuni
1. **Errori di Invio Email**
   - Verificare configurazione SMTP
   - Controllare limiti provider
   - Verificare template email

2. **Problemi Firebase**
   - Verificare credenziali Firebase
   - Controllare configurazione FCM
   - Verificare token dispositivi

3. **Errori Telegram**
   - Verificare token bot
   - Controllare permessi bot
   - Verificare chat ID

## Test SMTP
- Disponibile pagina di test SMTP
- Verifica configurazione email
- Debug problemi di invio

## Changelog
### Versione HEAD

Le modifiche vengono tracciate nel repository GitHub. 
## Collegamenti tra versioni di module_notify.md
* [module_notify.md](docs/module_notify.md)
* [module_notify.md](../../../Notify/docs/module_notify.md)


### Versione Incoming

Le modifiche vengono tracciate nel repository GitHub. 

---

