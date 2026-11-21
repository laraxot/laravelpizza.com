---
title: "Audit traduzioni .navigation — modulo Notify"
type: story
module: Notify
epic: quality
story_id: "navigation-translations-audit"
status: done
track: quality/i18n
priority: P2
created: 2026-09-29
updated: 2026-09-29
related:
  - ../../../../../docs/wiki/i18n/navigation-translations-audit.md
  - ../../../../../docs/wiki/i18n/navigation-translations-inventory-2026-09-29.md
issues: []
discussions: []
---

# Audit traduzioni `.navigation` — modulo Notify

Task utente 2026-09-29: trovare tutti i file di traduzione con la sottostringa
`.navigation` o una chiave `'navigation'`, completare/migliorare per ogni
lingua, senza mai togliere contenuto esistente. Dettaglio completo, metodo e
tabelle nel documento di sintesi cross-modulo:
`docs/wiki/i18n/navigation-translations-audit.md` (inventario pre-intervento in `docs/wiki/i18n/navigation-translations-inventory-2026-09-29.md`).

## Esito

2 file corretti e commitati (`lang/de/contact-column.php`,
`lang/en/contact-column.php`: `navigation.label`/`plural_label` da
`Missing Navigation *` a valori reali).

## Vincoli rispettati

- Nessuna chiave rimossa; solo sostituzioni di placeholder o aggiunte.
- Lock check eseguito a inizio sessione (`bashscripts/lock/status.sh`: nessun
  lock attivo di rilievo; `find laravel/Modules -name '*.php' -newermt "-5
  minutes"`: nessuna scrittura concorrente nella finestra immediata).
- `php -l` verde su ogni file toccato prima del commit.
- Commit solo sui file esattamente toccati (mai `git add -A`): il modulo ha
  working tree con modifiche concorrenti di altri agenti, verificate via
  `git diff -- <file>` prima di ogni `git add`.

## Second brain

Confermato: `qmd://concepts/translation-discipline-rule.md`. Pattern nuovo
scoperto (falso positivo euristica case-insensitive su valori Title Case) da
consolidare in una memoria Xot condivisa — vedi sintesi cross-modulo §6.
