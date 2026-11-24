---
title: "Audit BMAD — Notify"
type: audit
status: review
<<<<<<< HEAD
updated: 2026-11-16
module: Notify
qmd: "audit BMAD Notify sintesi finding P1 NotificationLog policy webhook inbound canali incompleti"
=======
updated: 2026-11-23
module: Notify
qmd: "audit BMAD Notify sintesi finding P1 NotificationLog policy webhook inbound canali incompleti"
created: 2026-11-23
>>>>>>> laraxot/dev
---

# Audit BMAD — Notify

SSoT dettagliata: [audits/notify-audit.md](./audits/notify-audit.md)

**Scopo:** Notify è il solo punto da cui la piattaforma parla con una persona; testi
e temi sono dati, non codice ([purpose](./purpose.md)).

## Sintesi misurata (2026-11-16)

| Metrica | Valore |
|---|---:|
| PHP `app/` | 254 |
| Action / Services / Jobs | 53 / 0 / 0 |
| Resource / Pagine Filament | 6 / 39 |
| Policy (file) / `return true` | 11 / 0 |
| Resource senza policy (runtime) | 1 (`NotificationLog`) |
| Test PHP / `*Test.php` / casi | 170 / 140 / ≈843 |
| Marker conflitto | 0 |

## Top finding

| Id | Sev | Cosa | Perché (business) |
|---|---|---|---|
| P1-1 | P1 | `NotificationLogResource` senza policy → Filament consente tutto | audit trail con dati personali dei destinatari |
| P1-2 | P1 | webhook inbound: token nel path, no firma provider, no throttle esplicito, `provider` non whitelisted | endpoint pubblico che scrive su disco e DB |
| P1-3 | P1 | canali Telegram/WhatsApp/Twilio/Firebase con TODO | utenti non avvisati senza errore |
| P2 | P2 | 10 `.up` orfani, 53 label literal, 3208 md (481 non kebab) | rumore e deriva |

## Gate

- PHPStan `Modules/Notify`: **0 errori** (2026-11-16).
- Pest: **skip documentato** — MySQL `10.100.200.53:3306` non raggiungibile da questo host.

Dettagli e fix: [audit approfondito](./audits/notify-audit.md) ·
[ECC](../ecc/notify-ecc-audit.md) · [story](./stories/module-bmad-audit.story.md)
