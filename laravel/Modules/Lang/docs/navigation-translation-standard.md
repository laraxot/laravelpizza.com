---
qmd: "navigation translation standard"
issues: []
discussions: []
title: "Standard per le traduzioni di navigazione Filament"
type: standard
module: Lang
created: 2026-09-17
updated: 2026-09-17
tags: [traduzioni, filament, navigazione]
related:
  - ./translation-keys-best-practices.md
  - ./TRANSLATION_PROCESS.md
---

# Standard per le traduzioni di navigazione Filament

## Regola

In `lang/it/*.php`, la sezione `navigation` contiene valori runtime, non chiavi
di traduzione. `label` e `group` devono essere testi italiani leggibili; `icon`
deve essere un nome Heroicon valido, ad esempio `heroicon-o-cog-6-tooth`.

La stringa `{file}.navigation` può rimanere soltanto in un campo `key` usato
dal catalogo delle traduzioni. Non deve comparire nei valori visualizzati.

## Checklist

- mantenere invariata la struttura delle chiavi;
- tradurre `label`, `group`, `name` e `plural` quando sono mostrati all'utente;
- usare icone semantiche, senza testo o chiavi nel campo `icon`;
- preservare `sort` e gli altri metadati non interessati;
- controllare la sintassi con `php -l` e cercare nuovamente i placeholder.

Il modulo Lang è il riferimento comune; i moduli dominio possono aggiungere
terminologia specifica, mentre i temi devono limitarsi a presentare le label.
