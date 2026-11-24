---
<<<<<<< .merge_file_V8KDID
=======
<<<<<<< HEAD
=======
<<<<<<< .merge_file_6XOrHS
qmd: "xot bmad stories theme three docs index refresh story md"
=======
>>>>>>> .merge_file_PhtRok
>>>>>>> laraxot/dev
>>>>>>> .merge_file_RB1lnJ
title: "Theme Three — indice docs completo e navigazione coerente"
status: done
epic: documentation-quality
acceptance_criteria:
  - L'indice usa il nome canonico minuscolo `index.md`.
  - Tutti i documenti Markdown attuali del tema sono raggiungibili dall'indice.
  - Il README descrive la struttura esistente e indirizza all'indice.
  - Il piano Themes riporta l'inventario misurato del tema Three.
references:
  - ../../../../../Themes/docs-reorg.md
  - ../../../../../Themes/Three/docs/index.md
  - ../../../../../Themes/Three/docs/README.md
  - ./phpstan-modules-swarm-random.story.md
<<<<<<< .merge_file_V8KDID
qmd: "theme three refresh story indice completo"
=======
>>>>>>> .merge_file_RB1lnJ
---

# Theme Three — indice docs completo e navigazione coerente

## Scopo

Rendere trovabile la documentazione esistente del tema senza spostare contenuti
né perdere link. L'audit aveva trovato un indice che elencava meno della meta'
dei file e un README che citava una pagina `customization.md` inesistente.

## Intervento

- Rinominato `INDEX.md` in `index.md`, coerente con la convenzione minuscola e
  con il target definito nel piano Themes.
- Aggiunte all'indice le pagine di prodotto, architettura, governance, Filament,
  qualita', BMAD, prompt e wiki.
- Riscritto il README con le directory reali e un link all'indice.
- Aggiornato l'inventario: 43 documenti Markdown top-level + 10 annidati = 53.

## Verifiche

- Verifica link Markdown: 52 link locali presenti; 0 destinazioni mancanti.
- Inventario verificato: 53 file Markdown totali, 43 al primo livello.
- Nessuno spostamento delle altre cartelle: resta il piano Themes distinto.
