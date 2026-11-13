---
title: "Email Deliverability & Inbound Pipeline"
type: documentation
tags: [notify, mail, deliverability, inbound, dns, spam]
created: 2026-11-12
updated: 2026-11-12
status: active
---

# Email: deliverability e ricezione — FixCity

Documento operativo completo per l'invio e la ricezione email di produzione.
Owner del codice: `Modules/Notify`. Config: `config/mail.php`, `config/services.php`,
`Modules/Notify/config/notify.php`.

## 1. Stato attuale (audit DNS fixcity.eu)

Rilevato il 2026-11-12 via `dig`:

| Record | Stato | Azione |
|---|---|---|
| A `fixcity.eu` | `46.225.90.178` | OK (server Ploi) |
| MX | **assente** | NECESSARIO per la casella reale (sezione 4) |
| TXT SPF | **assente** | Aggiungere record forniti da Mailtrap (sezione 2) |
| DKIM + CNAME Mailtrap (`mt78`, `rwmt1._domainkey`, `rwmt2._domainkey`, `mt-link`) | **presenti ma con target errato**: l'editor DNS ha completato il valore con `.fixcity.eu` perche' manca il punto finale (es. `smtp.mailtrap.live.fixcity.eu`) | Correggere i 4 valori aggiungendo il punto finale (sezione 2). Misurato con `php artisan notify:check-dns`: tutti `missing-trailing-dot` |
| DMARC `_dmarc` | `v=DMARC1; p=none; rua/ruf=mailto:dmarc@reports.mailtrap.io` | Mantenere `p=none` in osservazione, poi `quarantine` → `reject` |
| PTR (reverse DNS) | da verificare sul provider hosting | Allineare a `fixcity.eu` o `mail.fixcity.eu` |

**Conseguenza**: senza SPF+DKIM allineati al dominio del From, Gmail/Outlook
posizionano sistematicamente in spam o rifiutano. Il codice non può compensare.

## 2. DNS da configurare (fonte: dashboard Mailtrap → Sending Domains → fixcity.eu)

I valori esatti **non vanno indovinati**: copiare dalla dashboard Mailtrap dopo
aver aggiunto e verificato il dominio mittente. Tipicamente:

- 1 record di verifica dominio (TXT o CNAME su `fixcity.eu`)
- 2 CNAME DKIM (`<selector>._domainkey.fixcity.eu` → provider)
- 1 CNAME tracking opzionale (open/click tracking — **consigliato disattivato**
  per link tracciati personalizzati interni)
- SPF: Mailtrap lo copre tramite il record di verifica dominio; se si usa un
  secondo provider (SES/Postmark), ogni provider ha il suo include —
  **mai due record `v=spf1`**: un solo TXT con `include:` multipli.

Verifica dopo propagazione (attendere 5–60 min, TTL fino a 24h):

```bash
dig TXT fixcity.eu +short          # deve contenere v=spf1 ...
dig CNAME <selector>._domainkey.fixcity.eu +short   # record DKIM
dig TXT _dmarc.fixcity.eu +short   # DMARC
dig MX fixcity.eu +short           # casella in ingresso
```

### Verifica automatica: `notify:check-dns`

```bash
cd laravel && php artisan notify:check-dns            # dominio e CNAME attesi da config
php artisan notify:check-dns altro-dominio.example    # stesso set di CNAME, altro dominio
```

Sola lettura (risolve i nomi, non scrive nulla). Controlla i 4 CNAME di `notify.notify.mail_dns.cnames`
e che `_dmarc.<dominio>` contenga `v=DMARC1`. Stati per riga: `ok`, `missing` (record assente),
`wrong-target` (punta altrove) e **`missing-trailing-dot`**: il target e' quello atteso con in coda il
dominio della zona, cioe' il valore e' stato salvato senza il punto finale e il provider non verifichera'
mai il dominio. Exit code 1 se anche una sola riga non e' `ok`, quindi puo' bloccare un deploy.

Nota sulla config: i file di config dei moduli Laraxot sono montati come `<modulo>.<file>`, quindi
`Modules/Notify/config/notify.php` si legge con `config('notify.notify.<chiave>')`, **non**
`config('notify.<chiave>')` (restituisce `null`). La guardia e' `tests/Unit/NotifyConfigMountTest.php`.
Dopo il deploy: `php artisan config:clear` (o `config:cache`) per far vedere la chiave `mail_dns`.

Tool esterni di check: `mail-tester.com` (invio test → punteggio),
`dmarcian.com` o `app.dmarcian.com` per i report aggregati.

## 3. Configurazione applicazione (invio)

`.env` produzione (vedi `.env.production.example`):

```env
MAIL_MAILER=mailtrap-sdk
MAILTRAP_HOST=send.api.mailtrap.io        # produzione
# MAILTRAP_HOST=sandbox.api.mailtrap.io   # solo test, richiede MAILTRAP_SANDBOX_ID
MAILTRAP_API_KEY=<secret>
MAILTRAP_SANDBOX_ID=
MAIL_FROM_ADDRESS=noreply@fixcity.eu      # MAI hello@example.com
MAIL_FROM_NAME="FixCity"
MAIL_INBOUND_TOKEN=<secret casuale lungo> # webhook inbound (sezione 5)
```

Transport: `MailtrapSdkProvider` (auto-discovery di `railsware/mailtrap-php`)
registra il mailer `mailtrap-sdk`. `SpatieEmail` (template DB) è il Mailable
effettivo per notification email (`verify-email` ecc.).

Provider alternativi già cablati in `config/mail.php` + `config/services.php`:
`ses` (AWS SES via `aws/aws-sdk-php`), `postmark` (`symfony/postmark-mailer`),
`resend`, `mailgun`, `smtp`, `sendmail`. Per failover/doppio provider la
strategia consigliata è **provider primario + secondario manuale**
(cambiare `MAIL_MAILER`), non blend contemporaneo sulle stesse notification.

Comandi:

```bash
php artisan notify:test-mail [email] [--subject=...]   # test diretto Mailtrap API
php artisan notify:test-mailtrap                      # test layer API
php artisan config:clear && php artisan config:cache  # OBBLIGATORIO dopo edit .env
```

Regole anti-spam lato codice (già rispettate, non regredire):

- From coerente con dominio autenticato (SPF+DKIM alignment).
- HTML + text plain entrambi presenti (Spatie template ha entrambi).
- Niente link ignoti: tutti i link puntano a `fixcity.eu` (verificato in
  `SpatieEmail`: `login_url`, `site_url`, `verification_url`).
- Immagini: logo embedded CID (`embedLogo`), non hotlink esterni.
- Reputazione: lista contatti solo opt-in; la notification `verify-email` è
  transazionale e non richiede `List-Unsubscribe` (non è bulk).

## 4. Casella reale (ricezione "mailbox")

La pipeline inbound (sezione 5) riceve webhook dal provider, ma serve comunque
una **casella email reale** per:

- risposte degli utenti alle notification (reply-to)
- indirizzi pubblici (`info@`, `segnalazioni@`) leggibili da operatori
- DMARC report e bounce

Opzioni: Google Workspace / Microsoft 365 / casella del provider
(Postmark Inbound, Mailgun Routes, SES→S3+Lambda, o IMAP su hosting).
Per fixcity.eu la scelta minima è **un MX verso il provider di posta**
(es. Google Workspace: MX `smtp.google.com` priorità 1) e una casella
`noreply@`/`info@` dedicata. I record MX esatti arrivano dal provider scelto —
non inventarli.

## 5. Pipeline inbound applicazione (già implementata)

Endpoint: `POST /api/inbound/{provider}/{token}`
→ `Modules\Notify\Actions\Mail\ProcessInboundMailAction`
→ tabella `inbound_emails` (modulo owner: Notify, migrazione
`2026_11_13_000001_create_inbound_emails_table`).

Provider token: `config('notify.notify.inbound_token')` ← env `MAIL_INBOUND_TOKEN`.
Segreto nella URL: generare con `Str::random(48)` e configurare il webhook
provider con l'URL completo. **Non** è una firma crittografica: per produzione
consigliato IP allowlist del provider o firma se supportata (Postmark non firma;
Mailgun supporta `timestamp`+`token`+HMAC — da aggiungere se si adotta Mailgun).

Payload accettati:

- **Postmark**: JSON con `MessageID`, `From`/`FromFull`, `To`, `Subject`,
  `TextBody`, `HtmlBody`, `Headers`.
- **Mailgun**: form `sender`/`recipient`/`subject`/`body-plain`/`body-html`
  oppure `body-mime` (base64 MIME completo).
- **Raw MIME**: `Content-Type: message/rfc822` o body che inizia con `From:`
  → parsato con `zbateson/mail-mime-parser`.

Comportamento:

- deduplica su `(provider, message_id)` via `updateOrCreate`;
- raw MIME salvato in `storage/app/inbound/{provider}/Y/m/d/*.eml`;
- `status='received'`; i payload non parsabili → `422` + log warning
  `notify.inbound.parse_failed`;
- alleggi non estratti (todo: malware scan + storage limiti prima di
  qualsiasi uso downstream).

Setup provider:

- **Postmark Inbound**: server → Inbound → webhook URL
  `https://fixcity.eu/api/inbound/postmark/{MAIL_INBOUND_TOKEN}`.
- **Mailgun Routes**: `match_recipient(".*@fixcity.eu")` → forward HTTP
  `https://fixcity.eu/api/inbound/mailgun/{token}`.
- **SES**: SNS→HTTPS o Lambda→endpoint raw MIME.

Test: `Modules/Notify/tests/Feature/InboundMailWebhookTest.php` (4 casi verdi).

## 6. Warm-up e monitoraggio

- Dominio nuovo: iniziare con volumi bassi (centinaia/giorno) e crescere
  gradualmente per 2–4 settimane; i filtri si fidano di storico coerente.
- Tenere complaint rate < 0,1% e bounce < 2% (soglia Gmail/Yahoo bulk sender).
- Monitorare: Mailtrap dashboard (bounce/complaint), DMARC report via
  `dmarc@reports.mailtrap.io` (in attesa: aggregare con un parser DMARC
  o servizio esterno), `mail-tester.com` dopo ogni modifica template.
- Escalation DMARC: `p=none` → (2–4 settimane, allineamento verificato)
  `p=quarantine; pct=25` → `pct=100` → `p=reject`.
- Non promettere inbox garantita: dipende anche da contenuto, engagement e
  reputazione IP del provider.

## 7. Checklist go-live

- [ ] `MAIL_FROM_ADDRESS=noreply@fixcity.eu` in `.env` produzione
- [ ] `MAIL_MAILER=mailtrap-sdk` + `MAILTRAP_HOST=send.api.mailtrap.io` + API key
- [ ] Dominio mittente verificato in Mailtrap; SPF+DKIM attivi (verificare con dig)
- [ ] `config:clear && config:cache` dopo ogni modifica env
- [ ] `php artisan notify:test-mail <tua-mail> --subject="FixCity test"` → controllare inbox/spam
- [ ] Account Mailtrap approvato (pending approval blocca domini mittente diversi)
- [ ] `MAIL_INBOUND_TOKEN` valorizzato + webhook provider configurato
- [ ] `php artisan migrate` (crea `inbound_emails`)
- [ ] MX del provider di posta attivo per la casella reale
