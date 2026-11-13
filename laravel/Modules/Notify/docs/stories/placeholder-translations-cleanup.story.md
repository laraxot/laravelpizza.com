---
type: story
slug: placeholder-translations-cleanup
title: "Via le traduzioni segnaposto dai file di lingua"
status: done
created: 2026-11-10
updated: 2026-11-10
related:
  - "../../../Lang/docs/stories/placeholder-translations.story.md"
---

# Via le traduzioni segnaposto dai file di lingua

Rimosse le voci `helper_text`, `placeholder`, `description`, `tooltip`, `label`, `heading` e `hint` uguali al nome del
campo. Le aveva scritte il salvataggio automatico delle chiavi mancanti (`AutoLabelAction`, solo in locale) e
comparivano in produzione come testo sotto e dentro i campi. Eliminati anche i file `.php` senza nome.

Strumento: `php artisan lang:clean-placeholders {Modulo} [--dry-run]` (modulo Lang). Tocca solo i file di soli
dati: quelli che chiamano funzioni restano come sono.
