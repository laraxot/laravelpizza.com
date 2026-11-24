---
qmd: "media root txt hygiene.story"
issues: []
discussions: []
title: "Media root .txt hygiene"
module: "Media"
type: story
status: done
tags: [root, hygiene, txt, docs]
created: 2026-09-07
updated: 2026-09-07
---

# Story: Media root .txt hygiene

## Contesto

Regola di igiene root modulo (canon: `bashscripts/docs/prompts/03-quality-gates.md`,
sezione "Igiene root modulo/tema"): la root di ogni `Modules/<Nome>/` ammette al
massimo 6 file `.md` e ZERO file `.txt`. Verifica del 2026-09-07 ha trovato
`Modules/Media/` con 3 file `.md` in root (sotto soglia, ok) e 2 file `.txt` in
root (0 ammessi, violazione).

## File coinvolti

- `Media_phpmd.txt` — output effimero di un run PHPMD (report path riferiscono
  `base_techplanner_fila5`, run storico non riproducibile in questo albero).
- `pest_results.txt` — output effimero (con codici ANSI) di un run Pest storico.

Entrambi sono log/output di tool, non documentazione viva.

## Azione

Spostati (mai cancellati, `git mv` per preservare history) sotto
`docs/archived/`:

- `Media_phpmd.txt` → `docs/archived/Media_phpmd.txt`
- `pest_results.txt` → `docs/archived/pest_results.txt`

## Verifica

```
find laravel/Modules/Media -maxdepth 1 -iname '*.txt' | wc -l
# => 0
find laravel/Modules/Media -maxdepth 1 -iname '*.md' | wc -l
# => 3 (invariato, sotto soglia 6)
```

## Note

- Non toccato `laravel/phpstan.neon`.
- Nessun conflitto di lock: nessun altro agente aveva lock attivo su questi due
  file al momento dell'operazione (2026-09-07).
- `docs/chat/document-media-table-collision-blocker.md` e
  `docs/chat/ide-helper-models-write-fqn.log` sono stati controllati: nessuna
  relazione con questo task (collisione tabella `media` cross-modulo, e log
  ide-helper cross-repo), nessun conflitto.
- Convenzione locale del modulo (`docs/root-file-policy.md`) referenzia una
  cartella `docs/root-txt-files/` per normalizzazioni precedenti (0 file al
  momento). Per questi due file, trattandosi di output di tool effimeri, si è
  scelto `docs/archived/` come da procedura assegnata.
