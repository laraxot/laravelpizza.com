---
title: "Mail server di produzione: invio e ricezione su fixcity.eu senza finire in spam"
type: story
bmad: true
status: in-progress
created: 2026-11-12
updated: 2026-11-12
owner: module:Notify
module: Notify
related:
  - ../bmad/email-infrastructure-audit-and-runbook.md
  - ../email-infrastructure.md
  - ../email/email-setup.md
  - mailtrap-sdk-bridge-study.story.md
  - send-test-mail-wrong-location.story.md
  - ../../../../../bashscripts/docs/mail/mail-server.md
tags: [mail, postfix, dovecot, opendkim, dns, deliverability, spam, production]
---

# Mail server di produzione: invio e ricezione su fixcity.eu

## Story

**Come** gestore di FixCity **voglio** che il server di produzione invii e riceva posta su `@fixcity.eu`
**cosi' che** verifica email, reset password e notifiche arrivino in inbox (mai in spam) e le risposte abbiano
una casella vera.

Decisioni dell'utente (2026-11-12): **mail server completo su questo host** (non inoltro via provider);
modifiche di sistema tramite **script in `bashscripts/tools/mail/`**, documentato in `bashscripts/docs/mail/`;
"fare tutto il possibile per non finire mai in spam".

## Fasi BMAD

| Fase | Esito |
|---|---|
| Analyst (recon) | Host e DNS misurati, vedi "Evidenze" |
| Architect | Postfix + Dovecot (virtuali, LMTP, SASL) + OpenDKIM, hostname `fixcity.eu`, IPv4 |
| Dev | 3 script, `TestSendmail` corretto + test, config deduplicata |
| ECC review | review indipendente degli script: 6 difetti, tutti corretti (sotto) |
| QA | `bash -n`, Pint, PHPStan; Pest non eseguibile su questo host (sotto) |
| Ops (utente, sudo + DNS) | **da fare**: vedi "Azioni rimaste" |

## Evidenze (2026-11-12, host 46.225.90.178 = record A di fixcity.eu)

- Gia' installati: Postfix 3.8.6 (attivo, `myhostname = sottana-com`, porta 25 aperta), OpenDKIM (senza chiavi),
  `postfix-mta-sts-resolver`, swaks, certbot, ufw. **Mancava Dovecot.** sudo richiede password.
- `MAIL_MAILER=resend` -> `The fixcity.eu domain is not verified`.
- Postfix diretto -> Gmail `550-5.7.26 ... Gmail requires all senders to authenticate with either SPF or DKIM` (bounce in `/var/mail/ploi`).
- DNS (Hetzner): nessun MX, nessun SPF, DMARC `p=none` verso Mailtrap, CNAME DKIM Mailtrap rotti
  (`rwmt1.dkim.smtp.mailtrap.live.fixcity.eu.`: manca il punto finale), PTR generico Hetzner.
- Blacklist: **Barracuda LISTED** (`127.0.0.2`), Spamhaus pulito (verificato sul NS autoritativo), SpamCop/PSBL/Mailspike puliti.
- `docs/email/email-setup.md` dichiarava "✅ CONFIGURATO E OPERATIVO": non era vero, corretto.

## Lavoro parallelo: riconciliazione

Il commit `15f491884a` (altro agente, stesso giorno) ha aggiunto ingestione inbound via webhook
(`ProcessInboundMailAction`, `POST /api/inbound/{provider}/{token}`, tabella `inbound_emails`), il bridge
`mailtrap-sdk`, `notify:test-mail` e il runbook `bmad/email-infrastructure-audit-and-runbook.md`.
Quel runbook descrive **un altro host** (workstation `192.168.1.40`, Postfix `loopback-only`, `fixcity.local`) e
chiude con 5 "decisioni richieste". Questa story le prende per l'host pubblico:

| Decisione del runbook | Scelta |
|---|---|
| 1. hostname posta (`mail.fixcity.eu`?) | `fixcity.eu`: ha gia' A, PTR impostabile e certificato Ploi valido; `mail.` richiederebbe A + certificato nuovo senza benefici per un solo dominio |
| 2. porte 25/587/993 | esposte direttamente (IP pubblico, no NAT); 465 aggiunta; 143 spenta |
| 3. caselle | utenti virtuali Dovecot (`passwd-file`), nessun utente di sistema |
| 4. invio | Postfix diretto firmato DKIM (decisione utente); provider (`mailtrap-sdk`, `resend`) restano mailer alternativi |
| 5. root/DNS | script da lanciare con sudo; record DNS stampati dallo script |

Le due vie di ricezione convivono: le **persone** leggono via IMAP; un indirizzo destinato all'**applicazione**
puo' in futuro essere consegnato da Postfix al raw-MIME endpoint di `ProcessInboundMailAction` (transport `pipe`),
senza provider. Non attivato ora: serve una decisione su quale indirizzo.

Comandi di test, ruoli distinti: `notify:test-mail` = API Mailtrap; `notify:test-sendmail {to} --mailer=` = un
mailer qualsiasi di `config/mail.php` (default `sendmail`, cioe' il Postfix locale).

## Conflitti git risolti (stesso giorno, checkout condiviso col sync automatico)

Il sync ha committato marker in 6 file; `config/services.php` rompeva il bootstrap: **sito in 500**. Ogni file
studiato per intero con la storia (`git log`/`git show` dei due lati):

| File | Risoluzione e motivo |
|---|---|
| `config/services.php` | unione: i lati aggiungevano chiavi diverse (`mailgun/postmark/resend/ses` e `mailtrap-sdk`). Poi rimosse le **prime** definizioni duplicate di `postmark` (`POSTMARK_TOKEN`), `ses`, `resend` (`RESEND_KEY`): PHP tiene l'ultima, quindi erano codice morto; i valori effettivi (`POSTMARK_API_KEY`, `RESEND_API_KEY`) sono quelli in `.env` |
| `config/mail.php`, `config/local/fixcity/mail.php` | rimossi `mailtrap-sdk` e `postmark` duplicati, tenuta la definizione che vinceva (con `message_stream_id`) |
| `Modules/Notify/composer.json` | lato a 4 spazi (formato del resto del file) + `resend/resend-php` e `symfony/mailgun-mailer` dell'altro lato (gia' nel `composer.lock`); `zbateson/mail-mime-parser` del lavoro inbound conservato |
| `Themes/Sixteen/.../pages/auth/verify.blade.php` | tenuta la versione con `auth-link-button__loading`, `role="status"`, `aria-live`: il suo CSS e' in `components/auth/assets.blade.php` (anche *reduce-motion*). Prima scelta sbagliata (cercato il CSS solo in `resources/css`), corretta in avanti |
| `Modules/User/.../livewire/auth/verify.blade.php`, `Themes/TwentyOne/.../verify.blade.php` | tenuta la versione con `wire:target="resend"` e testo "sending" tradotto: lo spinner reagisce solo al resend |
| `Themes/Sixteen/docs/prompts/04.md` | documento: tenute entrambe le parti |

## Implementazione

- `bashscripts/tools/mail/setup-mail-server.sh` — installazione idempotente, backup in `/root/mail-setup-backup/`.
- `bashscripts/tools/mail/mailbox-add.sh` — caselle virtuali, password interattiva.
- `bashscripts/tools/mail/check-mail-dns.sh` — verifica senza sudo (DNS, PTR, blacklist, porte, servizi).
- `Modules/Notify/app/Console/Commands/TestSendmail.php` — argomento `to` (prima: indirizzo personale cablato
  nel codice), `--mailer` (prima: dichiarava sendmail ma usava il default), exit `FAILURE` se il trasporto
  lancia (prima: "sent successfully" sempre).
- `Modules/Notify/tests/Unit/Console/Commands/TestSendmailTest.php`.

### Difetti trovati dalla review ECC degli script (tutti corretti)

1. Utente autenticato poteva spedire come chiunque `@fixcity.eu` -> `smtpd_sender_login_maps` + `reject_sender_login_mismatch`.
2. `permit_mynetworks` sulla 25: ogni sito PHP del server poteva fare relay firmato DKIM -> rimosso (Laravel usa `sendmail`).
3. Record DKIM stampato come stringa unica > 255 caratteri -> spezzato a 250.
4. `mailbox-add.sh` cancellava righe via regex (`a.b@` colpiva `axb@`) -> confronto esatto con `awk`.
5. Link al certificato fissi: un certificato riemesso da Ploi avrebbe fermato Dovecot -> l'hook di rinnovo riallinea i link.
6. Servizio non attivo ma exit 0 -> lo script fallisce.

## Criteri di accettazione

- [x] Inventario di cio' che e' gia' installato (nessuna reinstallazione inutile).
- [x] Script idempotenti, `bash -n` ok, documentati in `bashscripts/docs/mail/mail-server.md`.
- [x] Nessun open relay, submission solo autenticata, mittente legato al login.
- [x] `TestSendmail` senza dati personali, onesto sull'esito; PHPStan ok sui file toccati.
- [ ] Script lanciato con sudo, `check-mail-dns.sh` tutto OK.
- [ ] MX, SPF, DKIM, DMARC, TLS-RPT pubblicati; PTR `fixcity.eu`; CNAME Mailtrap corretti o rimossi.
- [ ] Delisting Barracuda richiesto dopo PTR/SPF/DKIM.
- [ ] Gmail "Mostra originale": SPF, DKIM, DMARC = PASS; mail-tester.com 10/10.
- [ ] `MAIL_MAILER=sendmail` in `.env` di produzione + `config:cache`.

## Azioni rimaste (utente: sudo e pannelli esterni)

Vedi la procedura in `bashscripts/docs/mail/mail-server.md`: sudo script -> casella `hello@` -> DNS Hetzner + PTR
-> `check-mail-dns.sh` -> delisting Barracuda -> `.env` -> `notify:test-sendmail` -> Google Postmaster Tools.

## Verifica eseguita

- `bash -n` sui 3 script: ok. `check-mail-dns.sh` eseguito: 8 FAIL attesi prima dell'installazione (output nel doc).
- `vendor/bin/pint` sui file PHP toccati: passed. PHPStan sui file toccati: prima bloccato dal bootstrap rotto
  dai marker (vedi conflitti), dopo la risoluzione **0 errori**.
- Pest: **non eseguibile su questo host** (produzione): `SQLSTATE[HY000] [1045] Access denied for user 'marco'`
  dal `.env.testing`; anche il preesistente `SendMailCommandTest` fallisce 4/4 allo stesso modo. Da lanciare in sviluppo.
- Sito: 500 durante il conflitto, 200 dopo la risoluzione (`curl -L https://fixcity.eu/`).

## Filament Blueprint: pagina "Stato posta" (proposta, non implementata)

Per non dover aprire una shell per sapere se la posta funziona. Owner: Notify.

| Elemento | Specifica |
|---|---|
| Classe | `Modules\Notify\Filament\Pages\MailServerStatus extends XotBasePage` (mai `Filament\Pages\Page` diretto) |
| Navigazione | gruppo Notify, icona da `config` del modulo, etichette da `lang/{it,en}/mail_server_status.php` (niente `->label()`) |
| Widget | `MailDnsStatusWidget` (MX, SPF, DKIM, DMARC, TLS-RPT, PTR: OK/FAIL), `MailBlacklistWidget`, `MailQueueWidget` (`postqueue -j`, conteggio e messaggi piu' vecchi) |
| Logica | Spatie QueueableAction `Modules\Notify\Actions\Mail\CheckMailDeliverabilityAction::execute(string $domain): MailDeliverabilityData` (stessi controlli di `check-mail-dns.sh`, `dns_get_record`), risultato in cache 15 min |
| Azioni | "Invia mail di prova" (destinatario + mailer, riusa la logica di `notify:test-sendmail`), solo ruolo super-admin |
| Test | Pest: Action con resolver DNS finto; pagina accessibile solo al ruolo previsto |
