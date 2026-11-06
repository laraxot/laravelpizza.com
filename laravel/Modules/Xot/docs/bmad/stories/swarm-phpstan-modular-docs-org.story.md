---
title: "Xot - swarm-phpstan-modular-docs-org.story.md"
module: Xot
bmad: true
status: draft
updated: 2026-10-23
tags: [docs, xot, bmad]
qmd: "bmad story   swarm parallel: analisi phpstan modulare + docs org + wiki/second brain xot"
---

# BMAD Story: Swarm parallel: analisi PHPStan modulare + docs org + wiki/second brain

## Epic
SWARM-PHPSTAN-001

## AC
- [ ] Analisi PHPStan per modulo (non globale, timeout ambiente)
- [ ] Organizzazione `docs/` in ogni modulo: `bmad/`, `stories/`, `wiki/` standard
- [ ] Rimozione duplicati `.lock` dove presenti
- [ ] Aggiornamento wiki/memoria continuo
- [ ] Focus funzionalità HR/Performance (valutazioni, schede, criteri, rating)

## Task
1. Moduli target: Xot, User, Rating, Performance, Progressioni, Ptv, IndennitaCondizioniLavoro, IndennitaResponsabilita
2. Per modulo: phpstan analisi mirata + verifica struttura docs + wiki_observe
3. Lock BMAD via `bashscripts/lock/`
4. Ordine random per indipendenza

## References
- [[sources/obs-2026-10-06-xotbaseresource-navigationicon-rule-swarm-docs-org]]
- [[sources/indennita-migration-criteri-options-fix-20260930]]

## Status
Todo

## Passata swarm-docs 2026-10-06 (agente swarm-docs): indici di radice

Claim: `README.md` di `Themes/Zero|One|Three` e `Modules/Rating|Ptv|Sigma` (lock `docs-index-org`, rilasciati). Nessun file spostato, rinominato, cancellato. Story esistenti non toccate.

Cosa e' stato fatto: in ciascun `docs/README.md` e' stata aggiunta una sezione generata (tra i marker `swarm-docs:index:start` e `swarm-docs:index:end`, rigenerabile) con entry point, tabella sottocartelle, sovrapposizioni misurate, tutti i file .md di radice raggruppati per tema (euristica su nome e titolo), sospetti duplicati, file senza front matter. Verifica: 1006 link relativi scritti, 0 rotti (controllo `exists` su ogni link).

Fuori dal solo-additivo, dichiarato: `Themes/Zero/docs/README.md` aveva marker di merge annidati (committati). Risolto tenendo il corpo "Tema Zero - Documentazione" (lato `laraxot/dev`, riga Overview con "PTVX") e scartando il blocco boilerplate "Core module for the FixCity Platform" con badge rotti. Originale recuperabile con `git show HEAD:docs/README.md` dalla cartella del tema.

| Cartella | .md in radice | Non linkati da README/INDEX/index (prima, poi) | Non linkati da nessun .md (prima) | Senza front matter | Gruppi duplicati | Lock saltati |
| --- | --- | --- | --- | --- | --- | --- |
| Themes/Zero | 158 | 4, 0 | 4 | 9 | 26 | 0 |
| Themes/One | 73 | 29, 0 | 28 | 2 | 5 | 19 (agente-6, docs-100-merge, 2026-10-05) |
| Themes/Three | 43 | 0, 0 | 0 | 0 | 1 | 0 |
| Modules/Rating | 136 | 131, 0 | 104 | 28 | 32 | 0 |
| Modules/Ptv | 114 | 110, 0 | 62 | 17 | 3 | 0 |
| Modules/Sigma | 100 | 96, 0 | 54 | 9 | 1 | 0 |

Nota AC "Rimozione duplicati .lock": non eseguita. I 19 `.lock` in `Themes/One/docs` (15 in radice, 2 in `roadmap/`, 2 in `wiki/`) sono di `agente-6`, task `docs-100-merge`, creati il 2026-10-05 alle 09:53, a oltre 18 ore: stale per la soglia di 60 minuti, ma non rimossi perche' non miei. Servono conferma di agente-6 o dell'orchestratore.

### Proposte docs (richiedono approvazione)

Principio: seguire `docs-archive-policy.md` (Zero/One/Three): niente cancellazioni, il duplicato diventa uno stub che punta al canonico. Prima di ogni mossa: `rg -F "<nome>.md"` sui riferimenti e aggiornare l'indice nello stesso passo (lezione della story `docs-modules-themes-continuous-reorg`).

| # | File o cartella | Destinazione proposta | Motivo (misurato) | Rischio |
| --- | --- | --- | --- | --- |
| 1 | `Modules/Ptv/docs/stories/` (35 file) | rimuovere dopo verifica, o stub `README.md` che punta a `bmad/stories/` | 35 su 35 nomi presenti in `bmad/stories/` con contenuto byte-identico | basso (grep dei riferimenti a `docs/stories/<nome>`, `epics.md`, `sprint-status.yaml`) |
| 2 | `Modules/Rating/docs/bmad/*.md` (142 file di radice di `bmad/`) | tenere in `bmad/` solo artefatti BMAD (`architecture`, `brainstorming`, `quick-reference`, `setup-guide`, `README`); gli altri diventano stub verso `docs/<nome>.md` | 133 hanno lo stesso nome di un file di `docs/`, 128 byte-identici: mirror della radice dentro `bmad/` | medio (molti link interni a `bmad/`; fare un batch dedicato) |
| 3 | `Modules/Sigma/docs/bmad/*.md` (111 file) | come #2 | 99 stesso nome, 96 byte-identici | medio, come #2 |
| 4 | `Modules/Rating/docs/stories/` (64), `Modules/Sigma/docs/stories/` (35), `Themes/Zero/docs/stories/` (4), `Themes/One/docs/stories/` (3) | `bmad/stories/` della stessa cartella | posizione canonica per policy; 0 collisioni di nome con `bmad/stories/` | medio: riferimenti da altre story e da `docs/epics.md` (grep prima, aggiornarli nello stesso passo) |
| 5 | `Themes/Zero/docs`: 113 .md di radice (141 ricorsivi) con marker `<<<<<<<` / `>>>>>>>` committati (merge con `laraxot/dev`) | risoluzione in blocco, file per file, tenendo l'unione dei contenuti | e' la causa di buona parte della confusione di Zero (anche `index.md`, `INDEX.md`, `00-INDEX.md`) | alto: perdita di contenuto da un lato; richiede un revisore. Dopo: `rg -l --max-depth 1 -g "*.md" "^(<<<<<<<\|>>>>>>>) "` deve dare 0 |
| 6 | Zero: `INDEX.md`, `index.md`, `00-INDEX.md`, `00-index.md` | un solo `index.md` canonico (la regola `docs-index-file` lo richiede), gli altri stub | `INDEX.md` dice "canonico e' index.md", `index.md` dice "canonico e' 00-index.md": circolare; `index.md` e' 669 righe con due versioni fuse | medio: 71 e 97 citazioni del nome nel repo (omonimi di altri moduli inclusi) |
| 7 | Zero, contenuto identico: `PANDOC_GUIDE`/`pandoc-guide`, `TECH_SPEC`/`tech-spec`, `analisi-completa-tema`/`comprehensive-theme-analysis`, `dry-kiss-best-practices-historic`/`dry-kiss-best-practices`, `dual-label-chart-widget-implementation`/`simplechartwidget-quality-analysis`, `phpstan-dry-kiss-guidelines`/`phpstan-dry-kiss-theme-guidelines-historic` | tenere il nome kebab minuscolo, l'altro diventa stub | byte-identici | basso |
| 8 | Rating, contenuto identico: `BAD_PRACTICES`/`bad-practices`, `FALSE_FRIENDS`/`false-friends`, `MIGRATIONS`/`migrations`, `ON-DEMAND-PATTERN`/`on-demand-pattern`, `PERFORMANCE-OPTIMIZATION`/`performance-optimization`, `PROJECT-STRUCTURE`/`project-structure`, `QMD-SETUP`/`qmd-setup`, `REDUNDANCY_ANALYSIS`/`redundancy-analysis`/`redundancy_analysis` | nome kebab minuscolo canonico | byte-identici; le varianti maiuscole rompono i checkout su filesystem case-insensitive | basso; `ON-DEMAND-PATTERN` ha 8 link locali oltre al README |
| 9 | Varianti di solo caso o `_`/`-` (non identiche): Zero 17 gruppi (es. `ARCHITECTURE`/`architecture`, `CONFLICT*` x4, `duplicate-methods*` x4, `product_*`), One 5 (`ARCHITECTURE`, `FRAMEWORKS`, `PRD`, `README-en`, `duplicate*`), Rating 20, Ptv 3 (`GIT_DISCIPLINE`/`git-discipline`, `METODI_DUPLICATI_ANALISI`, `duplicate-methods*`), Sigma 1, Three 1 | confronto con diff, poi unificare nel kebab minuscolo con stub | regola `019-english-only-filenames` e `020-markdown-filename-convention`; elenchi esatti nella sezione "Sospetti duplicati" di ogni `docs/README.md` | medio: contenuti divergenti da riconciliare a mano |
| 10 | `Themes/One/docs`: i 19 file bloccati (`ARCHITECTURE`, `FRAMEWORKS`, `PRD`, `README-en`, `architecture`, `charts-integration`, `duplicate*` x4, `frameworks`, `html2pdf-integration`, `prd`, `readme-en`, `schema`, `roadmap/*` x2, `wiki/SCHEMA`, `wiki/schema`) | attendere il task `docs-100-merge` di agente-6, poi applicare #9 | lock stale ma altrui; sono proprio i gruppi caso-doppio | basso se agente-6 conferma che e' concluso |
| 11 | `Modules/Rating/docs/README.md.old` e `wiki/README.md.old` | `Modules/Rating/docs/raw/` o rimozione se coperto da git | estensione non `.md`, non indicizzabile, storia gia' in git | basso |
| 12 | Sezione "Senza front matter" di ogni README (Zero 9, One 2, Rating 28, Ptv 17, Sigma 9) | aggiungere front matter standard (`wiki-markdown-frontmatter-mandatory`) | non indicizzabili da qmd con metadati | basso (solo aggiunta in testa) |
| 13 | `Themes/Zero/docs/README.md`: link `../../docs/gestionale-docs-index.md` e `../../docs/tenant-modules-navigation-discipline.md` | puntare al percorso reale (la cartella `Themes/docs/` non esiste) | link preesistenti rotti, fuori dal mio perimetro additivo | basso |

Lezioni: (1) `docs/bmad/` puo' diventare un mirror della radice: misurare l'identita' byte per byte prima di toccare. (2) Il percorso citato `bashscripts/docs/modular-bmad-story-policy.md` non esiste (confermato; vedi memoria `docs-moduli-temi-riorganizzazione-continua`): i riferimenti reali sono `bashscripts/ai/wiki/workflows/story-first.md` e `bashscripts/ai/wiki/rules/theme-module-docs-readme-mandatory.md`. (3) Un indice generato e rigenerabile (marker start/end) evita di riscrivere a mano 100 voci.