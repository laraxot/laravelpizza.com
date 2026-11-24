---
title: "Mailjet: studio e integrazione nel modulo Notify"
type: analysis
status: active
module: Notify
created: 2026-11-18
<<<<<<< .merge_file_GfKsTo
updated: 2026-11-23
=======
<<<<<<< HEAD
updated: 2026-11-18
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> .merge_file_0EzQij
related:
  - ./email-setup.md
  - ./DELIVERABILITY-INDEX.md
  - ./best-practices.md
qmd: "mailjet sinch email transazionali send api v3.1 webhook event api sandbox spf dkim dmarc gdpr ue laravel mailer symfony mailjet-mailer"
---

# Mailjet

## In una riga

Mailjet (gruppo Sinch, azienda francese) manda email transazionali e newsletter da server **solo in UE**.
Laravel non ha un driver Mailjet: il modulo Notify registra il mailer `mailjet` usando il bridge ufficiale
Symfony `symfony/mailjet-mailer`, e riceve gli esiti (consegnata, rimbalzata, spam, …) con un webhook.

## Perché interessa

| Aspetto | Mailjet | Note |
|---|---|---|
| Dati | archiviati solo in UE (Google Cloud, regioni europee) | utile per il GDPR: niente trasferimenti extra-UE da giustificare per le email |
| Piano gratuito | 6.000 email/mese, **max 200/giorno**, 1.000 contatti, logo Mailjet | basta per prove e per un locale piccolo; 200/giorno si superano con un portale di più ristoranti |
| Piani (prezzi IVA esclusa) | Starter 8 €/mese (8.000), Essential 18 € (15.000, senza logo), Premium 27 € (15.000, 20 sub-account) | i crediti non usati non si accumulano; oltre soglia si paga a pacchetti di 1.000 |
| API | Send API v3.1 (`POST https://api.mailjet.com/v3.1/send`, Basic Auth chiave pubblica + privata) | fino a 50 messaggi per chiamata |
| SMTP | `in-v3.mailjet.com`, porte 587 (consigliata), 465, 25, 2525 | per hosting che bloccano HTTPS in uscita |
| Prove | `SandboxMode`: valida tutto e risponde, ma non consegna | da usare in staging |
| Esiti | Event API (webhook): `sent`, `open`, `click`, `bounce`, `blocked`, `spam`, `unsub` | riprova ogni 30 s per 24 h se non rispondiamo 200, poi sospende l'URL |
| Sub-account | uno per ristorante sui piani Premium | reputazione e statistiche separate per locale |
| Newsletter | liste contatti, campagne, editor, disiscrizione gestita | il modulo Restaurant esporta già i clienti iscritti alla newsletter |
| Extra | API SMS (Sinch), Parse API (email in arrivo) | non integrati |

Fonti: [prezzi Mailjet](https://www.mailjet.com/pricing/?currency=eur),
[Sandbox Mode](https://dev.mailjet.com/docs/email-api/send-api-v31/sandbox.mode),
[guida tecnica 2026](https://www.captaindns.com/it/blog/mailjet-transactional-email-technical-guide),
[symfony/mailjet-mailer](https://github.com/symfony/mailjet-mailer).

### Limiti da conoscere

- **200 email al giorno** nel piano gratuito: oltre, Mailjet rifiuta. Per un portale con più ristoranti
  serve almeno Starter.
- **DMARC passa solo con DKIM**: l'SPF non è allineato di default (Return-Path `bnc3.mailjet.com`).
  L'allineamento SPF richiede un CNAME e un ticket, solo a pagamento. Basta che il DKIM sia a posto.
- Il nome del mittente deve essere su un **dominio verificato**. Non si può mandare "da" l'email Gmail del
  ristorante: si manda dal dominio del portale e si mette l'email del ristorante in **Reply-To** (la
  Send API accetta un solo Reply-To).
- La Send API transazionale **non programma** invii futuri (`send_at` solo per campagne): i promemoria si
  programmano con la coda di Laravel.

## Come è integrato

```
Mailable / Notification Laravel ──► mailer "mailjet" ──► CreateMailjetTransportAction
                                                         └─ symfony/mailjet-mailer ─► api.mailjet.com/v3.1/send
Mailjet ──► POST /api/notify/mailjet/events/{token} ──► HandleMailjetEventsAction
                                                         └─ evento MailDeliveryEventReceived (lo ascolta il progetto)
```

| Pezzo | File |
|---|---|
| Dipendenza | `composer.json`: `symfony/mailjet-mailer ^8.1` (+ `symfony/http-client`, già presente) |
| Trasporto | `app/Actions/Mail/Mailjet/CreateMailjetTransportAction.php` (`api` o `smtp`, `sandbox`) |
| Registrazione | `NotifyServiceProvider::registerMailjetTransport()` → `Mail::extend('mailjet', …)` |
| Webhook | `app/Actions/Mail/Mailjet/HandleMailjetEventsAction.php`, rotta `notify.mailjet.events` |
| Evento | `app/Events/MailDeliveryEventReceived.php` con `app/Datas/MailDeliveryEventData.php` |
| Test | `tests/Unit/Actions/Mail/MailjetTransportTest.php`, `tests/Feature/MailjetEventsWebhookTest.php` |

Il modulo resta agnostico: non sa cosa sia una prenotazione. Il progetto ascolta
`MailDeliveryEventReceived` e decide (es. segnare "email non valida" su un cliente).

### Configurazione del progetto

`config/mail.php`:

```php
'mailjet' => ['transport' => 'mailjet'],
```

`config/services.php`:

```php
'mailjet' => [
    'key' => env('MAILJET_APIKEY_PUBLIC'),
    'secret' => env('MAILJET_APIKEY_PRIVATE'),
    'sandbox' => env('MAILJET_SANDBOX', false),
    'scheme' => env('MAILJET_SCHEME', 'api'),   // api | smtp
],
```

`.env`:

```dotenv
MAIL_MAILER=mailjet
MAIL_FROM_ADDRESS=prenotazioni@dominio-verificato.it
MAILJET_APIKEY_PUBLIC=...
MAILJET_APIKEY_PRIVATE=...
MAILJET_WEBHOOK_TOKEN=una-stringa-lunga-casuale
```

Per avere un piano B: `'failover' => ['transport' => 'failover', 'mailers' => ['mailjet', 'smtp']]` e
`MAIL_MAILER=failover`.

### Collegare le email agli esiti

Il trasporto legge alcuni header e li passa a Mailjet; tornano uguali nel webhook:

```php
public function headers(): Headers
{
    return new Headers(text: [
        'X-MJ-CustomID' => 'reservation-'.$this->reservation->id,  // torna come customId
        'X-MJ-EventPayload' => json_encode(['tenant' => $tenantId]), // torna come payload
    ]);
}
```

`->tag()` e `->metadata()` dei Mailable Laravel **non** vengono passati da questo trasporto: usare gli
header sopra.

## Messa in produzione (passo per passo)

1. Creare l'account su mailjet.com e copiare chiave pubblica e privata (Account → API Key Management).
2. **Sender domains**: aggiungere il dominio del portale, pubblicare i record DNS che Mailjet indica:
   - TXT SPF con `include:spf.mailjet.com` (uno solo per dominio: unire con gli altri `include`);
   - TXT DKIM su `mailjet._domainkey` (chiave 2048 bit);
   - DMARC: iniziare con `v=DMARC1; p=none; rua=mailto:…`, poi `quarantine`, poi `reject`.
3. Mettere le variabili nel `.env` e `MAIL_MAILER=mailjet`; in staging `MAILJET_SANDBOX=true`.
4. **Event notifications (webhook)**: URL `https://<dominio>/api/notify/mailjet/events/<MAILJET_WEBHOOK_TOKEN>`,
   versione 2, spuntare almeno bounce, blocked, spam, unsub. Gli eventi si possono anche raggruppare:
   il webhook accetta sia il singolo evento sia la lista.
5. Prova: `php artisan tinker` →
   `Mail::mailer('mailjet')->raw('Prova', fn ($m) => $m->to('tu@esempio.it')->subject('Prova Mailjet'));`
6. Rinnovare la chiave privata periodicamente (Mailjet consiglia ogni 90 giorni).

## Cosa resta fuori (idee)

- Sincronizzare con una lista Mailjet i clienti che hanno dato il consenso alla newsletter
  (oggi il modulo Restaurant li esporta in CSV).
- Sub-account per ristorante e chiavi per ristorante (oggi una chiave per tutto il portale).
- Parse API per le risposte dei clienti (il modulo ha già `ProcessInboundMailAction` per Postmark/Mailgun).
