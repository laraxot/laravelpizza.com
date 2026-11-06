---
title: "SettingPage di Notify: accesso libero ai segreti e nome"
status: ready-for-dev
module: Notify (owner)
created: 2026-10-28
repository: "https://github.com/provtv/base_ptv_fila5_mono"
github_issue: "https://github.com/provtv/base_ptv_fila5_mono/issues"
github_discussion: "https://github.com/provtv/base_ptv_fila5_mono/discussions"
related:
  - ../../../Xot/docs/stories/module-setting-pages.epic.md
  - ../../../Progressioni/docs/stories/progressioni-audit.epic.md
---

# SettingPage di Notify: accesso libero ai segreti e nome

## Fase BMAD

Sicurezza. Nata dall'audit del 2026-10-28 (epic `progressioni-audit`).

## Problema (verificato)

`Notify/app/Filament/Pages/SettingPage.php` mostra un EnvWidget che scrive nel `.env` chiavi con segreti (telegram_bot_token, netfun_token, mail_password...) e non ha `canAccess()`: la vede chiunque acceda al pannello. Il nome coincide con le SettingPage dei moduli (BaseSettingPage), ma il ruolo e' diverso (env vs config tenant).

## Requisiti

- `canAccess()` solo super-admin.
- Rinominare in `EnvSettingPage` (o simile) aggiornando test e lang.

## Criteri di accettazione

- [ ] Utente non super-admin: pagina non accessibile.
- [ ] Nessuna collisione di nome con BaseSettingPage.

## File coinvolti

- `app/Filament/Pages/SettingPage.php`
- `tests/Unit/Filament/Pages/SettingPageTest.php`

## Verifica

PHPStan livello 10 sui file toccati, Pint; Pest su ambiente di sviluppo (non su 10.100.200.15).
