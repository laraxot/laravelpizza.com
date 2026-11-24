---
title: "Audit approfondito modulo Notify"
type: audit
status: review
updated: 2026-11-23
module: Notify
qmd: "audit approfondito Notify inventario PHPStan Pest policy NotificationLog webhook inbound canali Filament Actions"
created: 2026-11-23
---

# Audit approfondito — Notify

## Perché esiste (business)

Notify è il solo punto da cui la piattaforma parla con una persona (mail, SMS,
push, Telegram, WhatsApp): separa il *fatto* accaduto dal *come* lo si dice.
Testi e temi sono **dati** (`MailTemplate`, `NotificationTemplate`, `NotifyTheme`),
non codice. Un difetto qui o non avvisa un dipendente di una scadenza o espone
dati personali di destinatari. Vedi [purpose](../purpose.md).

## Metodo

Source-first, 2026-11-16: `find`/`rg` sul sorgente, `Gate::getPolicyFor()` a runtime
su ogni `$model` delle Resource (script one-shot, nessuna scrittura DB), lettura
dei file critici. Le cifre del primo audit (template) sono **sostituite**: alcune
erano errate (policy 22 → **11**, lang it 179 → **90**, migration 30 → **37**).
Nessuna UI inventata, nessun `migrate:fresh`.

## Inventario misurato

| Area | Conteggio | Nota |
|---|---:|---|
| PHP in `app/` | 254 | `strict_types` mancante: 0 |
| Action `app/Actions` | 53 (+1 `Filament/Actions`) | `Services/`: 0, `Jobs/`: 0 |
| Model `app/Models` (file totali) | 38 | 18 top-level, 11 Policy, Traits/Contracts |
| Policy | 11 | tutte `extends NotifyBasePolicy → UserBasePolicy`; `return true`: **0** |
| Resource Filament | 6 | 1 senza policy (P1-1) |
| Pagine Filament | 39 | 15 nel cluster `Test` |
| Notifications / Channels / Mail | 13 / 4 / 2 | 5 `ShouldQueue` |
| Route | `api.php` 1 attiva, `web.php` 0 | webhook inbound |
| Migration | 37 | additive |
| Lang IT / blade | 90 / 85 | |
| Test PHP | 170 | 140 `*Test.php`, ≈843 `it()/test()`; Feature 19, Unit 126 |
| Test su policy / Livewire-page | 6 file / 21 file | |
| File test `*coverage*`/`*100*` | 18 | rischio test "da coverage" |
| Label/placeholder/tooltip literali in `app/` | 53 | da triage vs auto-traduzione |
| Marker conflitto git | 0 | |
| TODO/FIXME | 5 | canali incompleti (P1-3) |
| File `.up` orfani in `app/` | 10 | P2-1 |
| Docs `.md` | 3208 | 9 senza frontmatter, 481 nomi non kebab-case |

## Finding

### P1 — sicurezza e dominio

**P1-1 — `NotificationLogResource` senza policy (verificato a runtime)**
- `Gate::getPolicyFor(NotificationLog::class)` → `NONE`; le altre 5 Resource hanno policy.
- `app/Filament/Resources/NotificationLogResource.php:16` (`$model = NotificationLog::class`),
  nessun `NotificationLogPolicy.php` in `app/Models/Policies/`.
- Il commento in `User/app/Providers/UserServiceProvider.php:221` documenta la causa:
  "Filament, senza policy, consente tutto".
- Perché: il log contiene destinatario, canale, payload e stato di invio di ogni
  comunicazione a dipendenti: è audit trail e dato personale.
- Fix: `NotificationLogPolicy extends NotifyBasePolicy` (sola lettura per ruolo
  `notify::admin`, nessuna `delete*`); Pest `assertForbidden` per ruolo senza permesso.

**P1-2 — Webhook inbound pubblico `POST /api/inbound/{provider}/{token}`**
- `routes/api.php:17`, logica in `app/Actions/Mail/ProcessInboundMailAction.php`.
- Bene: `hash_equals`, token vuoto → 401 (`:48-51`).
- Rischi: (a) token nel **path** → finisce in access log di proxy/CDN; (b) nessuna
  verifica di firma del provider (Postmark/Mailgun); (c) nessun `throttle` esplicito
  nel file route; (d) `$provider` non in whitelist ed è concatenato nel path di
  storage `inbound/{provider}/Y/m/d/uuid.eml` (`:214`); (e) corpo raw e `html_body`
  salvati senza limite di dimensione né sanificazione (rischio XSS se un domani
  renderizzati in Filament).
- Fix: token in header o firma HMAC provider; `Route::...->middleware('throttle:...')`;
  `in_array($provider, ['postmark','mailgun','raw'])`; limite `Content-Length`;
  `strip_tags`/HTMLPurifier solo in visualizzazione.

**P1-3 — Canali dichiarati ma incompleti**
- TODO attivi: `Notifications/Channels/TelegramChannel.php:26,34`,
  `Notifications/WhatsAppNotification.php:66`, `Notifications/GenericNotification.php:113`
  (Twilio), `Filament/Clusters/Test/Pages/SendFirebasePushNotificationPage.php:112`.
- Perché: un canale che "esiste" ma non invia produce utenti non avvisati senza errore.
- Fix: matrice capability canale (reale / stub) in [architecture](../architecture.md);
  gli stub devono lanciare eccezione esplicita, non ritornare silenziosamente.

### P2 — igiene

- **P2-1** 10 file `.up` orfani (`app/Models/NotificationLog.php.up`,
  `NotificationTemplateVersion.php.up`, `notificationlog.php.up`,
  `notificationtemplateversion.php.up`, 6 in `app/Filament/Resources/`): codice morto
  con nomi case-variant. Fix: story di rimozione (forward-only, nuovo commit).
- **P2-2** 53 stringhe literal in `label/placeholder/tooltip/helperText` in `app/`:
  triage contro la regola "label auto-tradotte via Lang".
- **P2-3** Docs: 3208 `.md`, 481 con nome non kebab-case, 9 senza frontmatter,
<<<<<<< HEAD
<<<<<<< HEAD
  36 `README`/`readme`, 1 link rotto in `architecture.md` (ricontato 2026-11-19: 0, già corretto): rumore per QMD. Non rinominare in massa senza story.
=======
<<<<<<< .merge_file_Ymt0ce
  36 `README`/`readme`, 1 link rotto in `architecture.md`: rumore per QMD. Non rinominare in massa senza story.
=======
  36 `README`/`readme`, 1 link rotto in `architecture.md` (ricontato 2026-11-19: 0, già corretto): rumore per QMD. Non rinominare in massa senza story.
>>>>>>> .merge_file_yAxh8V
>>>>>>> laraxot/dev
=======
  36 `README`/`readme`, 1 link rotto in `architecture.md` (ricontato 2026-11-19: 0, già corretto): rumore per QMD. Non rinominare in massa senza story.
>>>>>>> laraxot/dev
- **P2-4** Test: rapporto test/app 0.67 buono ma 18 file `*coverage*`/`*100*` e solo
  19 Feature; i test su `ProcessInboundMailAction` e `NotificationLog` vanno verificati.

### Positivi verificati

- 15 pagine del cluster `Test` (invio email/SMS/push/Telegram/WhatsApp/Slack) +
  il cluster usano `SuperAdminOnlyTrait` (`Clusters/Test.php:17`, pagine `use`): solo `super-admin`.
- `return true` nelle policy: 0; `property_exists` su model: non rilevato.
- PHPStan 0 errori; nessun marker di conflitto; `strict_types` ovunque.

## Gate (2026-11-16)

```bash
cd laravel
php -d memory_limit=3G ./vendor/bin/phpstan analyse Modules/Notify --no-progress
./vendor/bin/pest Modules/Notify/tests --no-coverage   # solo con DB testing raggiungibile
```

| Gate | Esito |
|---|---|
| PHPStan `Modules/Notify` (level max) | **0 errori** (148 s) |
| Pest | **non eseguito**: MySQL `10.100.200.53:3306` non raggiungibile da questo host (`/dev/tcp` timeout 3 s); `pest` Pdnd/Performance in hang e kill a 240/90 s. Skip documentato, non verde dichiarato. |

## Piano

Epic e story: [epics](../epics.md), [story audit](../stories/module-bmad-audit.story.md),
[piano](../piano-miglioramento.md). Ordine: P1-1 → P1-2 → P1-3 → P2.

## Riferimenti

- [audit sintesi](../audit.md) · [ECC](../../ecc/notify-ecc-audit.md) · [indice](../index.md)
- [decision-log](../decision-log.md) · [brainstorming](../brainstorming.md)
