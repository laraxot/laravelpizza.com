---
title: "Cluster Test di Notify riservato al super-admin"
type: story
status: review
created: 2026-10-29
updated: 2026-10-29
module: Notify
tags: [notify, sicurezza, filament, autorizzazione, cluster-test, p0]
qmd: "notify cluster test super-admin canAccess SuperAdminOnlyTrait invio email sms whatsapp telegram push autorizzazione pagine filament"
related:
  - ../00-index.md
  - ../testing.md
---

# Cluster Test di Notify riservato al super-admin

## Scopo

Le pagine del cluster `Test` (`Modules\Notify\Filament\Clusters\Test`) servono a provare i canali di invio
(email, SMS, WhatsApp, Telegram, push, Slack) con le credenziali configurate. Devono poter essere usate solo
da un super-admin: chi invia da quelle pagine sceglie destinatario e contenuto e consuma le credenziali aziendali.

Origine: audit statico interno del 2026-10-29 (finding NTF-02, priorita' P0).

## Causa radice

Nessuna pagina del cluster definiva `canAccess()`. In Filament, se `canAccess()` non e' ridefinito, l'accesso
e' consentito a chiunque sia entrato nel pannello. `XotBasePage::authorizeAccess()` esiste ma non viene
invocata da nessuno, quindi non compensa. Anche i metodi di invio erano pubblici e chiamabili senza altri controlli.

## Cosa e' cambiato

- `Modules\Xot\Filament\Traits\SuperAdminOnlyTrait` (gia' esistente, non modificato) e' applicato:
  - a tutte le 15 pagine in `app/Filament/Clusters/Test/Pages/`, comprese le copie legacy
    (`SendEmail`, `SendPushNotification`, `SendTelegram`, `SlackNotification`), perche' Filament le scopre e
    quindi sono raggiungibili come le altre;
  - alla classe cluster `Test`, cosi' anche il suo ingresso e' negato ai non super-admin.
  Una pagina ha `canAccess()` vero solo se l'utente del pannello ha il ruolo `super-admin`.
  La navigazione del cluster sparisce da sola per gli altri utenti (Filament nasconde un cluster senza
  componenti accessibili).
- Ogni metodo pubblico di invio (`sendEmail`, `sendSMS`, `sendWhatsApp`, `sendTelegram`, `sendNotification`,
  `sendPushNotification`; 13 metodi in 13 pagine) inizia con `abort_unless(static::canAccess(), 403);`.
  Cosi' una chiamata Livewire diretta, o un utente che perde il ruolo a pagina aperta, riceve 403 prima che
  il form venga letto e prima di qualsiasi invio. Il controllo sta fuori dai `try/catch` delle pagine, per non
  essere inghiottito.
- Nessun cambiamento a nomi pubblici, slug, icone, navigazione, viste o logica di invio.
- Scelta di design: `use SuperAdminOnlyTrait;` in ogni pagina invece di una classe base di cluster.
  Una classe astratta nella cartella delle pagine sarebbe soggetta alla scoperta automatica di Filament e
  richiederebbe di cambiare comunque il `extends` di 15 file; il trait e' esplicito e il test sotto impedisce
  che una pagina nuova ne sia priva.

## Test

`tests/Unit/Architecture/TestClusterAuthorizationTest.php` (Pest, nessuna query: utente e guard sono mock di
`Filament::auth()`):

- il cluster e ogni classe concreta in `Clusters/Test/Pages` (scoperte dal filesystem) usano
  `SuperAdminOnlyTrait` (`class_uses_recursive`) e il loro `canAccess()` e' quello del trait, non una
  ridefinizione piu' permissiva;
- `canAccess()` e' falso per ospite e per utente non super-admin, vero per super-admin;
- ogni metodo pubblico `send*` dichiarato dalle pagine risponde 403 a un utente non super-admin.

Nota: il test e' stato scritto e controllato con `php -l` e PHPStan; non e' stato eseguito (la base di test del
modulo apre transazioni sul database di test e in questa sessione non e' consentito usarlo). Va eseguito in CI
o da chi ha un database di test dedicato.

## Rischi e punti aperti

- Nessun throttling ne' limite di frequenza sull'invio: anche un super-admin puo' inviare senza limiti.
  Follow-up: `RateLimiter` per utente e canale.
- Le pagine legacy duplicate (`SendEmail`/`SendEmailPage`, `SendPushNotification`/`SendPushNotificationPage`,
  `SendTelegram`/`SendTelegramPage`, `SlackNotification`/`SlackNotificationPage`) restano: sono protette, ma
  vanno eliminate con una story dedicata.
- Il criterio e' il ruolo `super-admin`. Un permesso dedicato (per esempio per un ruolo di assistenza) richiede
  una decisione e di toccare il trait in Xot: fuori ambito qui.
- Chi entra nel pannello e' deciso da `BaseUser::canAccessPanel` (modulo User), non verificato in questa story.
- Fuori ambito: il resto del modulo. I punti ancora da chiudere sono nel report riservato dell'audit (repo
  `bashscripts`), non in questo repository pubblico.
