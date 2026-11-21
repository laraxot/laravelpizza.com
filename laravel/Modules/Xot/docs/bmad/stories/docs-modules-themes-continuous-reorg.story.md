---
tags: [documentation, docs-hygiene, bmad]
created: 2026-09-29
updated: 2026-09-29
issues: []
discussions: []
title: "Riorganizzazione continua docs moduli e temi (lotto C, prima passata)"
type: story
module: Xot
status: in-progress
track: docs-hygiene
qmd: "docs modules themes continuous reorg misura stories bmad purpose readme"
related:
  - ./docs-filename-no-date-bonifica-xot.story.md
  - ./git-conflicts-docs-markers-2026-09-24.story.md
  - ../../../../../../docs/sprint-status.yaml
---

# Riorganizzazione continua docs moduli e temi

## Perche'

Direttiva utente permanente (2026-09-29): studiare, aggiornare, migliorare e
organizzare meglio `laravel/Modules/*/docs` e `laravel/Themes/*/docs`, sempre
con BMAD + second brain. Questa story e' il registro della campagna: ogni
passata aggiunge misura, azioni e backlog qui, non in nuovi file.

Regole verificate sul filesystem (non sulla wiki): story in
`docs/bmad/stories/`, nomi kebab-case, ogni modulo ha `docs/purpose.md`,
frontmatter sui `.md`, mai cancellare ne' rinumerare story.
La policy BMAD e' applicata dal bridge
`bashscripts/ai/.agents/rules/00-ON_DEMAND_PATTERN.md`; il vecchio puntatore
alla policy citato da alcune regole non esiste e non va usato.

## Misura di partenza (2026-09-29, script fuori repo)

Criteri: `viol` = nome non kebab-case (maiuscole, underscore, >8 parole);
`date` = data/timestamp nel nome; `nofm` = senza frontmatter `---`;
`dup` = file >=200 byte con contenuto identico; `st_old` = story in
`docs/stories/` fuori da `docs/bmad/stories/`; `tiny` = <200 byte.
`docs/purpose.md` e `docs/README.md` presenti in TUTTI i 18 moduli e 3 temi.

| Modulo/Tema | md | tiny | viol | date | nofm | dup | st_old | st_new | bmad |
|---|---:|---:|---:|---:|---:|---:|---:|---:|---|
| Xot | 8408 | 1334 | 1670 | 66 | 2288 | 1303 | 291 | 124 | si |
| Notify | 3867 | 23 | 1736 | 68 | 647 | 326 | 24 | 4 | si |
| User | 3068 | 35 | 623 | 62 | 543 | 257 | 98 | 3 | si |
| Activity | 784 | 92 | 146 | 20 | 517 | 88 | 36 | 4 | si |
| UI | 1092 | 83 | 370 | 11 | 80 | 34 | 29 | 5 | si |
| Lang | 845 | 3 | 293 | 9 | 6 | 64 | 19 | 3 | si |
| IndennitaResponsabilita | 363 | 2 | 168 | 5 | 33 | 24 | 102 | 55 | si |
| Rating | 381 | 7 | 186 | 10 | 70 | 11 | 63 | 74 | si |
| Tenant | 449 | 44 | 80 | 2 | 32 | 79 | 14 | 1 | si |
| Media | 425 | 1 | 94 | 11 | 39 | 17 | 17 | 5 | si |
| Job | 450 | 16 | 78 | 3 | 4 | 21 | 22 | 3 | si |
| Ptv | 257 | 0 | 82 | 1 | 25 | 1 | 33 | 43 | si |
| Zero (tema) | 237 | 3 | 34 | 5 | 32 | 8 | 4 | 2 | si |
| Three (tema) | 55 | 1 | 1 | 0 | 0 | 0 | 1 | 0 | NO |
| Sigma | 197 | 0 | 16 | 2 | 6 | 1 | 15 | 3 | si |
| IndennitaCondizioniLavoro | 85 | 0 | 13 | 2 | 8 | 4 | 3 | 4 | si |
| One (tema) | 119 | 0 | 14 | 1 | 2 | 5 | 3 | 1 | si |
| Performance | 101 | 0 | 13 | 1 | 7 | 2 | 5 | 5 | si |
| Progressioni | 112 | 3 | 6 | 0 | 49 | 0 | 4 | 3 | si |
| Incentivi | 83 | 3 | 9 | 0 | 32 | 1 | 3 | 4 | si |
| Pdnd | 82 | 3 | 11 | 1 | 27 | 1 | 2 | 4 | si |

Anomalie fuori tabella:

- `laravel/Modules/docs/` non e' un modulo: contiene solo `changelog.md`.
- `laravel/Modules/Activity/Activity/` : modulo annidato duplicato
  (`Activity/Activity/docs/stories`), da riconciliare.
- `laravel/Modules/IndennitaResponsabilita/.bmad/stories`: cartella dot-bmad
  fuori da `docs/`, vuota.
- Root repo: 9 `.md` (AGENTS, CHANGELOG, CLAUDE, CONTRIBUTING, GEMINI, QWEN,
  README, SECURITY, phpstan-configuration) contro il tetto di 6; vedi story
  `root-md-max5-verify`, non toccati qui.
- `docs/sprint-status.yaml` nel working tree risulta troncato a 26 righe
  (HEAD: 1773) il 2026-09-29 09:52 da altra sessione, con lock stale del
  2026-09-23 (`IR-assenze-fix`, opencode). NON scritto da questa story; la riga
  da registrare e' riportata sotto.

## Fatto in questa passata (solo spostamenti reversibili con `git mv`)

Story spostate da `docs/stories/` a `docs/bmad/stories/` (nome invariato, zero
collisioni, zero rinumerazioni), 13 file:

- Themes/Three: `0.1.archive-or-complete-decision` (ora ha `docs/bmad/`)
- Pdnd: `7.1.phpstan-anpr-boundaries`, `7.2.phpstan-pest-false-positive-verification`
- Incentivi: `4.22`, `7.1`, `7.2` (phpstan)
- IndennitaCondizioniLavoro: `7.1`, `7.2`, `8.21`
- Progressioni: `4.3`, `4.18`, `4.19`, `18.47`

Puntatori aggiornati (solo sostituzione `docs/stories/` -> `docs/bmad/stories/`
sui nomi spostati): `docs/epics.md` (righe 136 e 351), Notify 4.31,
IndennitaResponsabilita 8.14, e le story bmad di IndennitaCondizioniLavoro,
Pdnd, Progressioni. Le directory `docs/stories/` rimaste vuote sono state
rimosse.

Motivo della scelta dei bersagli: i moduli peggiori (Xot, Notify, User,
Activity, UI) hanno centinaia di file e riferimenti incrociati; nessuna
correzione sicura e reversibile in una sola passata. Sono a backlog.

## Passata 2026-10-02: tetto massimo 100

### Perche' il limite serve

La cartella `docs/` e' il corpus operativo, non un deposito illimitato di
dump, report generati, duplicati e storia grezza. Oltre il limite la ricerca
BMAD/QMD perde segnale, gli indici diventano ambigui e gli agenti scelgono
fonti obsolete. Il contenuto storico non viene perso: viene separato dal
corpus operativo in `.docs-archive/2026-10-02/docs/`, mantenendo lo stesso
percorso relativo per rendere ogni recupero reversibile.

### Criterio applicato

Per ogni `Modules/*/docs` e `Themes/*/docs` sono rimasti al massimo 100 file
`.md`, usando questo ordine: BMAD attivo e non concluso; README/purpose e
indici; wiki/concepts/rules/architecture riusabili; poi i documenti restanti
in ordine alfabetico fino al tetto. In Xot, dove anche le sole storie BMAD
superano il budget, sono state mantenute le storie con stato attivo,
backlog, review, ready, draft, proposed o blocked; le storie senza stato o
con stato concluso sono nell'archivio. Trade e Four erano gia' sotto il
tetto.

### Risultato verificato

| Area | Prima | Operativi | Archivio reversibile |
|---|---:|---:|---:|
| AI | 251 | 100 | 151 |
| Activity | 841 | 100 | 741 |
| Cms | 990 | 100 | 890 |
| Gdpr | 344 | 100 | 244 |
| Job | 471 | 100 | 371 |
| Lang | 710 | 100 | 610 |
| Media | 474 | 100 | 374 |
| Notify | 2084 | 100 | 1984 |
| Seo | 194 | 100 | 94 |
| Tenant | 526 | 100 | 426 |
| Trade | 5 | 5 | 0 |
| UI | 991 | 100 | 891 |
| User | 3357 | 100 | 3257 |
| Xot | 7762 | 100 | 7662 |
| Themes/Four | 2 | 2 | 0 |

La verifica ripetibile e' `find docs -type f -name '*.md' | wc -l`, eseguita
per ogni root. Nessun file e' stato cancellato; sono stati usati spostamenti
reversibili e i tre file gia' modificati in `.claude-flow/` non sono stati
toccati. I link verso il corpus storico vanno migrati solo quando una pagina
archiviata torna operativa: l'albero archivio conserva il percorso originale
come mappa di recupero.

## Backlog per modulo (ordine di gravita')

1. Xot: 1334 tiny scaffold (vedi memoria `tiny-scaffold-docs-pattern`: cercare
   la policy prima di eliminare), 1303 duplicati, 291 story in `docs/stories`,
   66 date nel nome (story `docs-filename-no-date-bonifica-xot`).
2. Notify: 1736 nomi non kebab, 326 duplicati, 647 senza frontmatter.
3. User: 623 nomi, 98 story fuori posto, 543 senza frontmatter.
4. Activity: unificare `Activity/Activity`, 517 senza frontmatter, 92 tiny.
5. UI: 370 nomi, 83 tiny, 29 story fuori posto.
6. IndennitaResponsabilita / Rating / Ptv: 102 / 63 / 33 story in `docs/stories`
   (con riferimenti in `docs/epics.md` e sprint-status da riallineare prima).
7. Lang, Tenant, Media, Job, Sigma: batch di rinomina (uppercase, underscore).
8. Temi One/Zero: migrare `docs/stories` (3 e 4 file), frontmatter Zero.
9. Ripulire i puntatori residui alla vecchia policy BMAD (file inesistente) e
   la cartella `laravel/Modules/docs`.

## Riga da registrare in docs/sprint-status.yaml

```yaml
  "Xot/docs-modules-themes-continuous-reorg": in-progress # direttiva permanente docs moduli/temi; misura 21 target, 13 story spostate in docs/bmad/stories (Three, Pdnd, Incentivi, IndennitaCondizioniLavoro, Progressioni), backlog per modulo. Story Modules/Xot/docs/bmad/stories/docs-modules-themes-continuous-reorg.story.md
```

## Acceptance

- [x] Misura riproducibile (script fuori repo, ripetibile a ogni passata)
- [x] Almeno 3 target corretti con `git mv`, puntatori aggiornati
- [ ] Riga registrata in `docs/sprint-status.yaml` (bloccata: file troncato)
- [ ] Prossime passate: backlog sopra, aggiornare la tabella qui
- [x] Memoria second brain + `llm-wiki-qmd.sh update`
