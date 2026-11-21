---
title: "Notify — epic 5.251: canali e provider di notifica"
type: epic
tags: [notify, epic, channels, sms, telegram, whatsapp, push, email]
created: 2026-09-28
updated: 2026-09-28
qmd: "Notify epic canali provider SMS Telegram WhatsApp push email notifiche"
related:
  - ../architecture.md
  - ../architecture/module-boundary.md
  - ../brainstorming.md
  - ./module-roadmap.md
  - ../stories/module-bmad-audit-20260928.story.md
---

# Epic 5.251 — canali e provider di notifica Notify

> **SUMMARY**: epic per documentare i canali di notifica (SMS, Telegram,
> WhatsApp, Email, FCM push) e i rispettivi provider/driver nel modulo
> `Modules\Notify`. Scope: documentazione derivata dal codice reale,
> zero modifiche PHP. Grounded in `app/Channels/`, `app/Actions/`, `app/Enums/`,
> `app/Notifications/`, `config/`.

## Scope

Il modulo Notify espone notifiche su 5 canali con driver multipli. Questa epic
documenta:

1. Canali nativi (`app/Channels/*.php`)
2. Notifications native (`app/Notifications/`)
3. Driver SMS (`app/Actions/SMS/`)
4. Action push (`app/Actions/Push/`)
5. Action Telegram (`app/Actions/Telegram/`)
6. Action WhatsApp (`app/Actions/WhatsApp/`)
7. Enum di supporto (`app/Enums/`)
8. Config dedicate (`config/sms.php`, `config/telegram.php`, `config/whatsapp.php`)

## Fonti verificate

| Fonte | Path |
|---|---|
| Channels | `app/Channels/` (4 file) |
| Notifications | `app/Notifications/` (12 file) |
| Actions SMS | `app/Actions/SMS/` (11 file) |
| Actions Push | `app/Actions/Push/` (10 file) |
| Actions Telegram | `app/Actions/Telegram/` (3 file) |
| Actions WhatsApp | `app/Actions/WhatsApp/` (4 file) |
| Actions Mail | `app/Actions/Mail/` (7 file) |
| Enums | `app/Enums/` (9 file) |
| Config | `config/sms.php`, `config/telegram.php`, `config/whatsapp.php`, `config/notify.php` |
| Jobs | `app/Jobs/` (2 file) |
| Facade | `app/Facades/NotificationFacade.php` |
| Migrations | `database/migrations/2022_10_12_133532_create_notifications_table.php` |

## Task

- [x] T1 — Inventariare canali in `app/Channels/`
- [x] T2 — Mappare notification native in `app/Notifications/`
- [x] T3 — Catalogare driver SMS in `app/Actions/SMS/`
- [x] T4 — Documentare action push, telegram, whatsapp
- [x] T5 — Mappare enum di supporto in `app/Enums/`
- [x] T6 — Redigere `architecture.md` (indice root → shard)
- [x] T7 — Redigere `quick-reference.md` e `setup-guide.md`

## Acceptance Criteria

- [AC1] Tutti i canali in `app/Channels/` sono documentati con file e config
- [AC2] Tutti i driver SMS in `app/Actions/SMS/` sono elencati
- [AC3] Enum `ChannelEnum`, `SmsDriverEnum`, `TelegramDriverEnum`,
  `WhatsAppDriverEnum` documentati
- [AC4] Nessun file PHP modificato (`git status` mostra solo `docs/`)
- [AC5] Ogni path citato nel corpo esiste: `test -e <path>` verificato

## Rischi

- Duplicazione tra `SmsChannel.php` e action SMS
- Config distribuita in 4 file diversi (`notify`, `sms`, `telegram`, `whatsapp`)

## DoD

- Documentazione canali completa e linkata
- Tutti i path verificati con `test -e`
- Lock rispettati per ogni scrittura
- Esito riportato in story correlata
