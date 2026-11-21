---
title: "Audit traduzioni .navigation — modulo User"
type: story
module: User
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

# Audit traduzioni `.navigation` — modulo User

Task utente 2026-09-29: trovare tutti i file di traduzione con la sottostringa
`.navigation` o una chiave `'navigation'`, completare/migliorare per ogni
lingua, senza mai togliere contenuto esistente. Dettaglio completo, metodo e
tabelle nel documento di sintesi cross-modulo:
`docs/wiki/i18n/navigation-translations-audit.md` (inventario pre-intervento in `docs/wiki/i18n/navigation-translations-inventory-2026-09-29.md`).

## Esito

Target esplicito dell'utente: unico file con `.navigation` letterale come
segmento di chiave (`user::auth.navigation.*`) è `lang/it/auth.php`, già
completo. Le altre 4 lingue con lo stesso file (`en`, `fr`, `es`, `ru`)
avevano `navigation.label`/`plural_label`/`group` a placeholder: tradotti
sulla base del riferimento italiano (Autenticazione/Autenticazioni/Generale).
`de` ha il file ma senza sezione `navigation` **e** con contaminazione
italiano/tedesco preesistente nelle label: non toccato, segnalato come debito
(serve pulizia dedicata prima di poter aggiungere `navigation`). Le altre 26
lingue del modulo non hanno `auth.php`: non creato (niente file fantasma).

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
