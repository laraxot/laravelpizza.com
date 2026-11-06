---
title: "Copie numerate dei docs (-1.md, -2.md): consolidamento senza perdite"
type: story
module: Xot
status: in-progress
created: 2026-10-23
updated: 2026-10-23
tags: [docs, ridondanza, md-filenames, consolidamento, migration-map, swarm]
qmd: "copie numerate docs -1.md consolidamento ritiro old md-filenames check paths cartella subset noise User Notify"
related:
  - ../../../Fixcity/docs/bmad/stories/_from-bmad-output/docs-organization/DOC-004.duplicate-classification.story.md
  - ../../../Fixcity/docs/bmad/stories/_from-bmad-output/docs-organization/DOC-006.non-destructive-consolidation.story.md
  - ./datas-folder-convention-guard.story.md
---

# Copie numerate dei docs: consolidamento senza perdite

## Perche'

Regola dell'utente (2026-10-15, ribadita il 2026-10-23): nei nomi dei `.md` niente date, timestamp, suffissi `-1.md`. Misura del 2026-10-23: **838** nomi vietati (User 518, Notify 220, Media 34, Job 26, Xot 20, Activity 11, altri 9). Due commit `.` del 2026-10-21 (User 08:41, 2410 file; Notify 08:36) li avevano riportati dopo la rinomina del 2026-10-15: sono anche sul remoto `laraxot/dev`.

Perche' nessuno se n'era accorto: **il controllo era cieco**. `md-filenames.py check --paths <cartella>` scartava ogni argomento che non finisse in `.md`, quindi su una cartella controllava zero file e usciva 0. Tredici prompt (`12-documentation`, `15-bmad`, `19-docs`, `30-documentation-standards`, `44-module-docs-continuous`, `55-md-conventions`, `97-yaml-frontmatter-convention`, `99-closing-ritual`, `00-start`, `INDEX`, `README`, ...) dicevano di usarlo cosi'.

## Strumento (`bashscripts/tools/docs/md-filenames.py`)

| Modifica | Prova |
|----------|-------|
| `check --paths <cartella>` espande i `.md` della cartella (`check_targets()`) | selftest; `check --paths laravel/Modules/User/docs` = 518 (prima 0) |
| ritira una copia le cui righe di contenuto stanno tutte nel file col nome giusto (`body_lines()`, prima solo copie identiche byte per byte) | selftest con copia contenuta, copia con riga propria |
| `NOISE`: non contano il piede «Ultimo aggiornamento <data>», una voce che e' solo un link a una copia numerata, «See canonical documentation: <copia-N>.md». Una frase che contiene un link resta contenuto | selftest |
| `graphify-out` in `SKIP_DIRS`: e' cache generata e gitignored, non si riscrive | |

## Esecuzione

| Passata | Ritirati (`.old`) | Riferimenti riscritti | File cambiati | Verifica |
|---------|-------------------|------------------------|---------------|----------|
| 1 (copie contenute) | 344 | 27.606 | 2.539 (di cui ~664 cache graphify gitignored) | 1.665 file tracciati: **ogni** riga cambiata differisce solo per il nome di una copia ritirata -> il suo file canonico; 9 file con altre modifiche, tutte di altre sessioni (orari fuori dalla finestra) |

Mappa vecchio -> nuovo (chiave `pass1`, poi le passate successive): `migration-maps/numbered-copies-rename-map.json` accanto a questa story; il nome contiene `rename` perche' `skip_rewrite()` non la riscriva (altrimenti le coppie vecchio->nuovo diventerebbero nuovo->nuovo). Il contenuto di ogni copia ritirata resta nella storia git (`git show HEAD:<percorso>`).

Saltati di proposito: le 7 rinomine «dal titolo» del piano (nomi tipo `header-components-componenti.md`): passano agli agenti, che scelgono un nome che dica cosa contiene.

## Claim (swarm, ordine estratto a caso)

| Lotto | Elementi | Docs che insegnano `make:job` / `app/Jobs/` | Proprietario | Esito |
|-------|----------|---------------------------------------------|--------------|-------|
| user-a | 116 | 0 | agente user-a | |
| others (Media, Job, Xot, Activity, Lang, Tenant, ...) | 39 | 15 | agente others | |
| notify-b | 68 | 34 | agente notify-b | |
| notify-a | 68 | 1 | agente notify-a | |
| user-b | 116 | 0 | agente user-b | |

Gli agenti modificano **solo** i file canonici del proprio modulo e scrivono le decisioni in JSON; rinomine e ritiri li applica il lead con lo strumento, che riscrive i riferimenti. Altre sessioni: non toccare i file elencati nei lotti fino a chiusura di questa story.

## Acceptance

- [ ] `md-filenames.py check` sui moduli a 0, oppure ogni residuo motivato
- [ ] nessuna riga di contenuto persa (verifica riga per riga come nella passata 1)
- [ ] link rotti non aumentati rispetto alla base (45.147 prima della passata 1, `md-filenames.py links`)
- [ ] docs che insegnano Jobs riscritti su QueueableAction
