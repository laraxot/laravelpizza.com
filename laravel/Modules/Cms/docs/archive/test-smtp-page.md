# Test SMTP in il progetto

![test smtp page](test-smtp-page.jpg)

È possibile testare una qualsiasi configurazione SMTP tramite questa pagina di test.

Il sistema rileverà in automatico la configurazione di default, ma si potrà benissimo cambiarla in modo da provarne altre.

![test smtp form](test-smtp-page-form.jpg)

Inserite le varie impostazioni, si potrà verificare il funzionamento di una determinata configurazione email.

## Test via Tinker

In alternativa alla pagina di test, è possibile utilizzare Tinker per testare rapidamente la configurazione SMTP:

```php
Mail::raw('Test email content', function($message) {
    $message->to('destinatario@example.com')
            ->subject('Test Email via Tinker');
});
```

Per maggiori dettagli, consultare la guida completa: [Test Laravel SMTP Mail via Tinker](https://medium.com/@azishapidin/test-laravel-smtp-mail-via-tinker-cec59999214)

## Troubleshooting

### Problemi comuni

1. **Errore di connessione**: Verificare che le credenziali SMTP siano corrette e che il server sia raggiungibile.
2. **Errore di autenticazione**: Controllare username e password.
3. **Timeout**: Verificare che la porta SMTP non sia bloccata dal firewall.
4. **Errore SSL/TLS**: Assicurarsi che le impostazioni di crittografia siano corrette.

### Configurazione in .env

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=username@example.com
MAIL_PASSWORD=password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="il progetto"
```
MAIL_FROM_NAME="<main module>"
```
## Collegamenti tra versioni di test-smtp-page.md
* [test-smtp-page.md](laravel/Modules/Notify/project_docs/test-smtp-page.md)
* [test-smtp-page.md](laravel/Modules/Cms/project_docs/test-smtp-page.md)

