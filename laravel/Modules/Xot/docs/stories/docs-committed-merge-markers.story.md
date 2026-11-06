---
title: "Marker di merge committati nei docs dei moduli: risoluzione senza perdite e per scopo"
type: story
module: Xot
status: in-progress
created: 2026-10-23
updated: 2026-10-23
tags: [docs, merge-markers, conflitti, resolve_merge_blocks, swarm]
qmd: "marker merge committati docs moduli merge_file resolve_merge_blocks senza perdite divergenti per scopo onde agenti"
related:
  - ../../../Fixcity/docs/stories/dcp-177-marker-di-merge-non-risolti-nei-prompt-e-nelle-docs.story.md
  - ./docs-numbered-copies-consolidation.story.md
---

# Marker di merge committati nei docs dei moduli

## Perche'

Misura del 2026-10-23: **6.905** file `.md` in `Modules/*/docs` con marker committati, **11.378** blocchi `<<<<<<< .merge_file_*` (Notify 2.872 file, User 1.467, Lang 724, Activity 582, Tenant 342, Media 341, Job 318, Rating 117, Xot 82, UI 59, Geo 2). Vengono da `git merge-file` nello script di sincronizzazione, che committa i conflitti senza risolverli (memoria `bashscripts-sync-merge-leaves-conflicts-and-hangs-in-editor`). Ogni agente che legge un doc legge due versioni intrecciate; QMD indicizza i marker.

Classificazione dei blocchi: un lato vuoto 5.574, divergenti 5.525, identici 194, uno contenuto nell'altro 29.

## Strumento: `bashscripts/tools/resolve_merge_blocks.py` corretto

Prima rigenerava i file dal blob di HEAD (cancellando le modifiche non committate), scriveva «ours provvisorio» sui blocchi divergenti (perdendo l'altro lato) e ripristinava vecchi blob per i malformati (vietato da git-forward-only; la memoria `merge-markers-committed-e7e667b11` diceva gia' «usarlo solo in dry-run»). Ora: legge e scrive il working tree; scrive un file solo se **tutti** i blocchi sono senza perdite (regola DCP-177: si tiene il lato che contiene l'altro); divergenti, sole maiuscole, lato «stub» e malformati restano intatti ed elencati; salta i file toccati da meno di 10 minuti; `=======` da solo non e' un marker (sottolineatura Markdown). `--selftest` con 8 casi.

## Passata meccanica

| Modulo | Scritti | Trattenuti (< 10 min) | Da decidere |
|--------|---------|-----------------------|-------------|
| Notify | 2115 | 10 | 746 |
| Activity | 517 | 0 | 65 |
| User | 504 | 23 | 940 |
| Lang | 485 | 0 | 239 |
| Job | 275 | 0 | 41 |
| Media | 272 | 0 | 69 |
| Tenant | 207 | 0 | 134 |
| Rating | 99 | 0 | 18 |
| UI | 49 | 0 | 10 |
| Xot | 47 | 0 | 35 |
| Geo | 2 | 0 | 0 |
| **Totale** | **4572** | **33** | **2297** |

Prova: istantanea dei 6.902 file prima della scrittura; per ogni file cambiato ogni riga di contenuto dell'originale e' ancora presente e nessun marker resta fuori dai code fence: **4572 su 4572 ok**, 2330 invariati.

## Restano: blocchi divergenti (lettura per scopo)

2.128 file con 4.150 blocchi semantici (solo 204 file sarebbero risolvibili con le regole di corruzione note: `project_docs` -> `docs`, data reale > `[DATE]`, nome reale > `<nome progetto>`). Metodo DCP-177: leggere i due lati, tenere cio' che e' coerente con le regole canoniche e con il codice di oggi, unire le parti complementari, mai rollback; agenti per modulo, massimo 3 alla volta.

| Onda | File | Proprietario | Esito |
|------|------|--------------|-------|
| 1-a Activity + UI | 75 | agente onda 1-a | |
| 1-b Media + Rating | 87 | agente onda 1-b | 87 risolti, 177 blocchi; verificato: 0 marker residui su 87 |
| 1-c Job + Xot | 76 | agente onda 1-c | 76 risolti; verificato: 0 marker residui su 76. Corretto dopo: YAML non valido in `Job/docs/concepts/xotbase-never-extend-filament.md` (`\*` in stringa tra doppi apici). Lasciato: `Xot/docs/bmad/stories/phpstan-ptv-incentivi-indennitaresponsabilita-l10-swarm.story.md` `in_progress` con corpo «analyse completato»: riguarda moduli di un altro progetto, non verificabile qui |
| 2 Tenant + Lang | 373 | da avviare | |
| 3 Notify | 746 | da avviare | |
| 4 User | 940 | da avviare | |

Altre sessioni: non toccare i file delle onde in corso.

## Link rotti trovati dall'onda 1-b (fuori dai blocchi, non toccati)

I commit e2282c1b (Media) e c74fdcb (Rating) del 2026-10-22 hanno cancellato gli indici; i README li citano ancora. I due README vengono riscritti da un'altra sessione (ultima scrittura 15:49:20, stesso secondo per entrambi): la correzione va fatta alla fonte che li genera.

| File | Link | Bersaglio esistente |
|------|------|---------------------|
| `Media/docs/README.md` righe 29, 79 | `INDEX.md` | `index.md` (269 righe) |
| `Media/docs/README.md` riga 80 e `related` | `bmad/00-INDEX.md`, `bmad/readme.md` | nessuno |
| `Rating/docs/README.md` riga 27 | `00-INDEX.md` | `index.md` («Rating Module: Documentation Index») |

La «Mappa delle directory» del vecchio `Media/docs/00-INDEX.md` non sopravvive in nessun file: si recupera da `git -C laravel/Modules/Media show e2282c1b~1:docs/00-INDEX.md`.

## Causa a monte (aperta)

Finche' lo script di sincronizzazione committa conflitti, i marker tornano a ogni merge. Va corretto lo script (fermarsi su conflitto, non committare) oppure aggiunto un controllo che rifiuti il commit con marker (`bashscripts/tools/check-conflict-markers.sh` esiste ma non blocca nulla da solo).