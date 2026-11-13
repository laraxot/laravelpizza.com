# Email Infrastructure Setup — FixCity / Laraxot (User Module)

**Data**: 2026-11-12  
**Modulo**: User (owner)  
**Stato**: ✅ CONFIGURATO E OPERATIVO

---

## Panoramica

Il server FixCity (`fixcity.eu`) è configurato per **inviare** e **ricevere** email tramite:

1. **Sendmail** (locale, Postfix) — per consegna diretta dal server
2. **Mailtrap SDK** (API) — per test/sandbox
3. **Symfony Mailer** (Laravel Mail) — orchestratore centrale
4. **Spatie Laravel Database Mail Templates** — template persistenti

---

## Architettura

```
┌─────────────────────────────────────────────────────────────┐
│                    Laravel Application                       │
│  ┌───────────────────────────────────────────────────────┐  │
│  │              Illuminate\Support\Facades\Mail          │  │
│  │  (Orchestratore: smtp, sendmail, log, array, ...)     │  │
│  └──────────────────────┬────────────────────────────────┘  │
│                         │                                   │
│  ┌──────────────────────▼────────────────────────────────┐  │
│  │         Symfony\Component\Mailer\Mailer               │  │
│  │  (Trasporto: SendmailTransport, SmtpTransport, ...)   │  │
│  └──────────────────────┬────────────────────────────────┘  │
│                         │                                   │
│  ┌──────────────────────▼────────────────────────────────┐  │
│  │         Moduli/Temi (Blade + Mailable)                │  │
│  └───────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────────────┐
│                    Server Infrastructure                     │
│  ┌──────────────────────┐  ┌───────────────────────────┐   │
│  │  /usr/sbin/sendmail  │  │  Postfix (MTA)            │   │
│  │  (Sendmail binary)   │  │  relayhost: (vuoto)       │   │
│  └──────────────────────┘  └───────────────────────────┘   │
└─────────────────────────────────────────────────────────────┘
```

---

## Componenti Installati

### 1. Sendmail / Postfix (locale)
- **Binary**: `/usr/sbin/sendmail`
- **PHP path**: `sendmail_path = /usr/sbin/sendmail -t -i`
- **Postfix**: `3.8.6-1ubuntu0.1` (Ubuntu 24.04)
- **Uso**: Consegna diretta dal server senza relay SMTP esterno
- **Stato**: ✅ ATTIVO

### 2. Mailtrap SDK (API-based testing)
- **Package**: `railsware/mailtrap-php: ^3.18`
- **Provider**: `Mailtrap\Bridge\Laravel\MailtrapSdkProvider`
- **Mailer**: `mailtrap-sdk` (custom transport)
- **Config**: `config/services.php` → `mailtrap-sdk`
- **Uso**: Sandbox per test email (richiede domain verification)
- **Stato**: ✅ INSTALLATO

### 3. Symfony Mailer (Laravel Mail)
- **Package**: `symfony/mailer: ^8.1`
- **Mailers supportati**: smtp, sendmail, mailgun, ses, postmark, resend, log, array
- **Uso**: Orchestratore per l'invio di email
- **Stato**: ✅ ATTIVO

### 5. Altri Provider Mail
- **Mailgun**: `symfony/mailgun-mailer: ^8.1`
- **Postmark**: `symfony/postmark-mailer: *`
- **Resend**: `resend/resend-php: ^1.18`
- **AWS SES**: `aws/aws-sdk-php: *`

### 6. Notifiche
- **Telegram**: `irazasyed/telegram-bot-sdk: *`, `laravel-notification-channels/telegram: *`
- **FCM (Firebase)**: `kreait/laravel-firebase: ^7.0`, `laravel-notification-channels/fcm: ^6.0`
- **Database Templates**: `spatie/laravel-database-mail-templates: *`

### 7. User Module
- **Verifica email**: `Themes/Sixteen/resources/views/pages/auth/verify.blade.php`
- **Notifica verifica**: `Modules/User/app/Actions/Auth/ResendEmailVerificationAction.php`
- **Loading spinner**: Aggiunto per UX (Livewire `wire:loading`)

---

## Configurazione

### `.env` (variabili chiave)

```bash
# Mailer attivo (scegliere uno):
MAIL_MAILER="sendmail"        # Locale (immediato)
MAIL_MAILER="mailtrap-sdk"    # Mailtrap (sandbox/test)
MAIL_MAILER="smtp"            # SMTP esterno
MAIL_MAILER="log"             # Log only (sviluppo)

# Sendmail (locale)
MAIL_SENDMAIL_PATH="/usr/sbin/sendmail -t -i"

# SMTP (esterno)
MAIL_HOST="smtp.example.com"
MAIL_PORT=587
MAIL_ENCRYPTION="tls"
MAIL_USERNAME=""
MAIL_PASSWORD=""
MAIL_EHLO_DOMAIN="fixcity.eu"

# Mailtrap
MAILTRAP_HOST="send.api.mailtrap.io"
MAILTRAP_API_KEY="your-api-key-here"
MAILTRAP_SANDBOX_ID=""

# Da/From
MAIL_FROM_ADDRESS="noreply@fixcity.eu"
MAIL_FROM_NAME="${APP_NAME}"
```

### `config/mail.php` (mailer definitions)

```php
'mailers' => [
    'sendmail' => [
        'transport' => 'sendmail',
        'path' => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail -bs -i'),
    ],
    'mailtrap-sdk' => [
        'transport' => 'mailtrap-sdk',
    ],
    'smtp' => [
        'transport' => 'smtp',
        'url' => env('MAIL_URL'),
        'host' => env('MAIL_HOST', '127.0.0.1'),
        'port' => env('MAIL_PORT', 2525),
        'encryption' => env('MAIL_ENCRYPTION', 'tls'),
        'username' => env('MAIL_USERNAME'),
        'password' => env('MAIL_PASSWORD'),
        'timeout' => null,
        'local_domain' => env('MAIL_EHLO_DOMAIN', parse_url(env('APP_URL', 'http://localhost'), PHP_URL_HOST)),
    ],
    // ... altri mailer
],
```

---

## Componenti Email nel Modulo User

### Actions

| Action | Percorso | Descrizione |
|--------|----------|-------------|
| `ResendEmailVerificationAction` | `app/Actions/Auth/` | Reinvia la mail di verifica indirizzo |
| `ResendEmailAction` | `app/Actions/Auth/` | Reinvia email di verifica (nuova azione) |
| `SendEmailAction` | `app/Actions/Mail/` | Invia email generica |
| `TryMailAction` | `app/Actions/Mail/` | Tenta invio con fallback |
| `GetMailLayoutAction` | `app/Actions/Mail/` | Recupera layout email |

### Models

| Model | Tabella | Descrizione |
|-------|---------|-------------|
| `MailTemplate` | `mail_templates` | Template email persistenti (Spatie) |
| `MailTemplateLog` | `mail_template_logs` | Log invio email |
| `MailTemplateVersion` | `mail_template_versions` | Versioning template |

### Emails (Mailable)

| Email | Percorso | Descrizione |
|-------|----------|-------------|
| `SpatieEmail` | `app/Emails/` | Mailable per template Spatie |
| `EmailDataEmail` | `app/Emails/` | Mailable con dati strutturati |

---

## Test e Verifica

### Comandi Artisan disponibili

```bash
# Test invio via sendmail (locale)
php artisan notify:test-sendmail

# Test invio via Mailtrap (API)
php artisan notify:test-mailtrap

# Test SMTP generico
php artisan notify:send-mail

# Verifica configurazione mail
php artisan config:show mail

# Pulizia cache
php artisan config:clear
php artisan view:clear
```

### Verifica Postfix

```bash
# Stato servizio
sudo systemctl status postfix

# Coda mail
mailq

# Log Postfix
sudo tail -f /var/log/mail.log

# Test sendmail diretto
echo "Subject: Test" | sendmail marco.sottana@gmail.com
```

---

## Sicurezza Email

### SPF (Sender Policy Framework)
```
Type: TXT
Host: @
Value: "v=spf1 ip4:YOUR_SERVER_IP include:_spf.google.com ~all"
```

### DKIM (DomainKeys Identified Mail)
- Generare chiavi DKIM con Postfix
- Aggiungere record TXT al DNS

### DMARC
```
Type: TXT
Host: _dmarc
Value: "v=DMARC1; p=quarantine; rua=mailto:dmarc@fixcity.eu"
```

---

## Troubleshooting

### Errore: "Mailer [mailtrap-sdk] is not defined"

**Causa**: MailtrapSdkProvider non registrato.

**Soluzione**:
```bash
composer require railsware/mailtrap-php symfony/http-client nyholm/psr7
php artisan config:clear
```

### Errore: "Unable to send email: 412 Recipient domain mismatch"

**Causa**: Mailtrap richiede che il dominio del destinatario corrisponda al dominio verificato.

**Soluzione**: Configurare il dominio in Mailtrap dashboard.

### Errore: "Connection refused" (SMTP)

**Causa**: Server SMTP esterno non raggiungibile.

**Soluzione**: Verificare credenziali e firewall:
```bash
telnet smtp.example.com 587
```

### Errore: "No such file or directory" (sendmail)

**Causa**: Sendmail non installato o path errato.

**Soluzione**:
```bash
sudo apt install sendmail
which sendmail
# Verificare MAIL_SENDMAIL_PATH in .env
```

---

## Ricezione Email (Postfix)

Il server può **ricevere** email configurando Postfix come MTA:

```bash
# Configurazione Postfix (/etc/postfix/main.cf)
myhostname = fixcity.eu
mydestination = $myhostname, localhost.$mydomain, localhost
mynetworks = 127.0.0.0/8 [::ffff:127.0.0.1]/104 [::1]/128
relayhost =
```

### Caselle Email (Alias)

```bash
# /etc/aliases
postmaster: root
webmaster: root
noreply: devnull
info: marco.sottana@gmail.com
```

### DNS (per ricezione)

Configurare record MX per `fixcity.eu`:

```
Type: MX
Host: @
Value: mail.fixcity.eu
Priority: 10
```

---

## Sicurezza Email

### SPF (Sender Policy Framework)
```
Type: TXT
Host: @
Value: "v=spf1 ip4:YOUR_SERVER_IP include:_spf.google.com ~all"
```

### DKIM (DomainKeys Identified Mail)
- Generare chiavi DKIM con Postfix
- Aggiungere record TXT al DNS

### DMARC
```
Type: TXT
Host: _dmarc
Value: "v=DMARC1; p=quarantine; rua=mailto:dmarc@fixcity.eu"
```

---

## Troubleshooting

### Errore: "Mailer [mailtrap-sdk] is not defined"

**Causa**: MailtrapSdkProvider non registrato.

**Soluzione**:
```bash
composer require railsware/mailtrap-php symfony/http-client nyholm/psr7
php artisan config:clear
```

### Errore: "Unable to send email: 412 Recipient domain mismatch"

**Causa**: Mailtrap richiede che il dominio del destinatario corrisponda al dominio verificato.

**Soluzione**: Configurare il dominio in Mailtrap dashboard.

### Errore: "Connection refused" (SMTP)

**Causa**: Server SMTP esterno non raggiungibile.

**Soluzione**: Verificare credenziali e firewall:
```bash
telnet smtp.example.com 587
```

### Errore: "No such file or directory" (sendmail)

**Causa**: Sendmail non installato o path errato.

**Soluzione**:
```bash
sudo apt install sendmail
which sendmail
# Verificare MAIL_SENDMAIL_PATH in .env
```

---

## Documentazione Correlata

- **Notify Module**: `/home/ploi/fixcity.eu/laravel/Modules/Notify/docs/email/email-setup.md`
- **User Module**: `/home/ploi/fixcity.eu/laravel/Modules/User/docs/email/email-setup.md`
- **Sixteen Theme**: `/home/ploi/fixcity.eu/laravel/Themes/Sixteen/docs/email-setup.md`
- **TwentyOne Theme**: `/home/ploi/fixcity.eu/laravel/Themes/TwentyOne/docs/email-setup.md`

---

## Riferimenti

- [Mailtrap PHP SDK](https://github.com/mailtrap/mailtrap-php)
- [Laravel Mail](https://laravel.com/docs/11.x/mail)
- [Symfony Mailer](https://symfony.com/doc/current/mailer.html)
- [Postfix](https://www.postfix.org/documentation.html)
- [Spatie Database Mail Templates](https://spatex.be/docs/laravel-database-mail-templates)
- [DMARC/SPF/DKIM](https://www.cloudflare.com/learning/dns/dns-records/)

---

**Owner**: Modulo User  
**Ultimo aggiornamento**: 2026-11-12  
**Stato**: Operativo per invio, configurazione ricezione in corso