---
title: campagna deduplica docs moduli e temi
type: chat
created: 2026-05-21
related:
  - ../wiki/how-to/module-docs-deduplication.md
  - ../wiki/how-to/github-issue-agent-discipline.md
---

## Campagna deduplica docs (2026-05-21)

## Contesto

Analisi ridondanze in `laravel/Modules/*/docs` e `laravel/Themes/*/docs` (issue [#124](https://github.com/provtv/base_ptv_fila5_mono/issues/124)).

## Esecuzione

- Tool: `bashscripts/tools/dedup_module_docs.py`
- Remote: `provtv/base_ptv_fila5_mono`

## Esito

~2807 delete, ~349 stub, canonici Media (html2pdf) e Xot (wiki/concepts).

## Domande ad altri agenti

1. **Seconda passata:** conviene abbassare soglia MD5 a coppie (`len==2`) solo con stesso basename, o rischio perdere varianti volute?
2. **Indici:** unificare `INDEX.md` / `00-INDEX.md` / `index.md` per modulo in un solo `README.md` + `docs/wiki/index.md`?
3. **User legacy:** cartella `User/docs/legacy/` ancora grande — spostare in `docs/raw/` modulo o purge graduale?

## Prossimo passo

Gate `verify-llm-wiki.sh`; eventuale PR solo docs con report allegato.

## Update (2026-05-27) — ridondanza “vera” e issue modulo

### Evidenze verificate (non assunte)

- **Modulo User**: esistono *entrambi* i path per Login/Logout widget:
  - `laravel/Modules/User/app/Filament/Widgets/LoginWidget.php`
  - `laravel/Modules/User/app/Filament/Widgets/Auth/LoginWidget.php`
  - `laravel/Modules/User/app/Filament/Widgets/LogoutWidget.php`
  - `laravel/Modules/User/app/Filament/Widgets/Auth/LogoutWidget.php`
- **Cartelle `docs/archive/` presenti** in alcuni moduli (es. User, Notify): naming ambiguo e spesso incompatibile con discipline/gate.

### Issue aggiornate (discussione con altri agenti)

- **User (provtv/module_user_fila5)**:
  - `#4` `[Discussione] Ridondanza codice e documentazione — DRY/KISS`
  - `#2` `[DISCUSSIONE] Ridondanza documentazione modulo User`
- **Notify (laraxot/module_notify_fila5)**:
  - `#31` `COPILOT: Redundancy & phpstan — Notify`
  - `#30` `[AI] PHPStan e confidenza agenti`

Nota: per repo/remote non hardcodare org nei docs; usare la guida `docs/wiki/how-to/module-theme-github-issues.md` e verificare con `git remote -v` nel modulo.

### Domande “dure” per gli agenti (serve risposta in thread)

1. User: quale path è **canonico** per Filament discovery e perché? Possiamo fare shim BC per 1 release e poi rimuovere duplicati?
2. Docs `archive/`: lo consideriamo **storia** (→ `legacy/`/`superseded/`) o ci sono contenuti *operativi* che stanno finendo nel posto sbagliato?
3. Notify: i duplicati di basename sono copie identiche o varianti di driver/dominio? Se varianti, documentare il confine invece di DRY cieco.
