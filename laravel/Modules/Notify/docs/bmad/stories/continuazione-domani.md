---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "continuazione domani"
issues: []
discussions: []
title: "Continuazione BMAD — Domani (Notify)"
type: module-fix
scope: Notify
epic: "5"
bmad_version: v3.30.1
updated_at: '2026-09-22'
status: in-progress
related:
  - ./netfun-conflict-markers.story.md
  - ./cleanup-notify-2026-09-22.story.md
  - ../../../Xot/docs/bmad/stories/cleanup-all-modules.story.md
---

# Notify — Continuazione Domani

## Stato verificato ora (sessione 2026-09-22)

- Marker di conflitto in codice PHP/lang: **risolti**. Sequenza reale da
  `git log --oneline -20`: `bd02a591` (marker residui, 6 file),
  `bb6a7761` (`SendNetfunSMSAction.php` + 4 lang file, tenuto lato
  `isSuccessfulResponse`/redazione token/`Safe\json_decode`),
  `c0ff8ebe` (marker committati nei 4 `lang/it/send_*.php`, tenuto formato
  multiriga una-chiave-per-riga). Verificato ora: `SendNetfunSMSAction.php`
  in HEAD ha davvero `isSuccessfulResponse`, `Safe\json_decode`, token
  gestito senza log in chiaro — coerente con quanto dichiarato nei commit e
  in `netfun-conflict-markers.story.md` (che ha ancora `status: review` ma
  il lavoro descritto è verificato applicato).

## Bug reale trovato: marker di conflitto ANCORA committati in HEAD

`git status --short` è pulito, ma un grep ricorsivo su tutto il modulo
(esclusi vendor/node_modules/graphify-out) trova marker di merge **committati
e non testuali per caso**, non toccati dalle pulizie sopra:

- `docs/wiki/AGENTS.md` — **20 blocchi** `<<<<<<<`/`=======`/`>>>>>>>`
  (conflitti annidati HEAD/HEAD su commit `3096f6ae` "sync dal prototipo
  canonico" vs `a988596b` "first"), righe 141-435+.
- `docs/wiki/session-summary.md` — 1 blocco, marker da merge a 3 vie
  (`<<<<<<< .merge_file_AJqkFi` / `=======` / `>>>>>>> .merge_file_SIMIXa`),
  riga 1 e 326-327.

Entrambi i file risultano **ultimo toccati da `c9a3ec6d`**
("fix(notify): allinea working tree — schema Filament e marker docs",
2026-09-21), il commit che *dichiara* di aver sistemato i marker nei docs ma
in realtà li ha lasciati (o reintrodotti) in questi due file. Nessuna story
esistente copre `docs/wiki/`.

## Altri segnali reali in app/ (grep mirato)

- 4 `TODO` reali su feature non finite (non rumore):
  - `app/Notifications/Channels/TelegramChannel.php:26,34` — il canale
    Telegram è uno **stub**: non chiama mai `toTelegram()`/nessuna
    `BotTelegramAction`, logga solo `'Telegram notification would be sent'`
    con un messaggio placeholder fisso.
  - `app/Notifications/GenericNotification.php:113` — `TwilioSmsMessage`
    non implementato.
  - `app/Notifications/WhatsAppNotification.php:66` — `WhatsAppChannel` non
    implementato.
  - `app/Filament/Clusters/Test/Pages/SendFirebasePushNotificationPage.php:115`
    — `PushNotification` class non implementata.
- 4 `@phpstan-ignore trait.unused`: 3 hanno motivazione inline
  (`HasTenantNotifications.php`, `HasNotificationTracking.php` — "consumer
  in app/ futuri, coverage via test doubles/dummy model"), 1 senza motivo
  (`app/Models/Traits/HasContact.php:19`). Da ricordare: per questi trait la
  memoria `feedback-trait-unused-false-positive-module-scoped.md` avverte
  che una run PHPStan isolata per modulo può dare falsi positivi — non
  rimuovere l'ignore senza una run fleet-wide.
- `dddx(...)` in `app/`: **5 occorrenze, tutte commentate** (debug residuo
  ma innocuo, non attivo) — `RecordNotification.php:115`,
  `TestSmtpPage.php:94`, `NetfunSendAction.php:50,87`,
  `NotifyTheme/Get.php:110`. A differenza di Media (dove `dddx` è attivo),
  qui è solo rumore da pulire con bassa priorità.

## Continuazione — priorità

1. **`docs/wiki/AGENTS.md` + `docs/wiki/session-summary.md`** — risolvere i
   marker committati (20+1 blocchi). Verificare prima con `git log -S` quale
   lato (`3096f6ae` vs `a988596b`, oppure i due `.merge_file_*`) è quello
   corretto prima di tagliare — non assumere "tieni HEAD" per default su
   file di merge a 3 vie.
2. **`TelegramChannel.php`** — decidere se completare l'integrazione reale
   (serve `BotTelegramAction` + `TelegramMessageData`, citati nel TODO ma
   mai creati) o rimuovere il canale finché non è pronto — oggi logga soltanto
   senza inviare nulla, rischio di falso positivo silenzioso in produzione.
3. **`netfun-conflict-markers.story.md`** — chi la possiede la marchi `done`
   (lavoro già verificato sopra), non riaprire l'analisi.
4. **`HasContact.php:19`** — aggiungere la motivazione inline mancante
   all'`@phpstan-ignore trait.unused` (uniformare alle altre 3), solo dopo
   una run PHPStan fleet-wide che confermi che è davvero unused.
5. **`cleanup-notify-2026-09-22.story.md`** — template generico mai
   eseguito, valutare chiusura o contenuto reale.

## Second brain

`qmd query` su "Notify docs wiki AGENTS conflict markers c9a3ec6d TelegramChannel stub" prima di riprendere; `qmd update` dopo ogni chiusura.
