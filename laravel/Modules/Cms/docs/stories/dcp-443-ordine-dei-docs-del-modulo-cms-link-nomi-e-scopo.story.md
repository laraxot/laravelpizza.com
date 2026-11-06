---
id: dcp-443
title: "Ordine dei docs del modulo Cms: link, nomi e scopo"
type: story
epic: docs-order
status: done
priority: P2
owner: module:Cms
module: Cms
created: 2026-10-27
updated: 2026-10-27
tags: [docs, cms, link, nomi, scopo, indice, bmad]
qmd: "dcp-443 cms docs link nomi scopo indice 00-index rooted links project_docs collegamenti tra versioni generati superseded rinomina mese anno"
related:
  - ./docs-organization-cms.story.md
  - ./docs-index-audit.story.md
  - ../00-index.md
  - ../../../Fixcity/docs/stories/dcp-56-organizzazione-docs-moduli-e-temi.story.md
  - ../../../../../bashscripts/docs/modular-bmad-story-policy.md
---

# DCP-443: ordine dei docs del modulo Cms

Fase BMAD: Implementation. Perimetro: solo `laravel/Modules/Cms/docs/**` e questa story. Il modulo e' un repo git annidato: nessun commit.

## Richiesta
Ordine permanente dell'utente (2026-10-27): studiare, aggiornare, migliorare e organizzare meglio le cartelle `docs` di moduli e temi; guardare lo **scopo** dei documenti, non solo l'errore; nomi `.md` senza date o timestamp; controllo approfondito della ridondanza; DRY e KISS.

## Scopo
La radice di `docs/` del Cms ha 529 file piatti. Chi cerca "come il sito serve una pagina" trova per prima una prova vecchia (classi che non esistono, link a cartelle mai esistite) con la stessa autorevolezza del documento vero. Lo scopo di questo giro: (1) togliere i link rotti che si possono correggere senza inventare nulla; (2) togliere i nomi con mese o anno dove il nome pulito e' libero; (3) dichiarare le copie; (4) dare alla radice un indice che dica **a cosa serve ogni gruppo e quanto fidarsi**, e rispondere alla domanda "quali documenti descrivono quello che il sito usa davvero".

## Misurato prima
Comandi (tutti in sola lettura), dalla radice del repo, con `S` = scratchpad della sessione:

```bash
python3 -I $S/cms-audit-one.py $S/cms-audit-before.json     # chiama docs-organizer.audit_one su Modules/Cms/docs
python3 bashscripts/tools/docs/docs-organizer.py links laravel/Modules/Cms/docs --report
python3 bashscripts/tools/docs/docs-organizer.py links laravel/Modules/Cms/docs [--tail]     # simulazione
python3 bashscripts/tools/docs/docs-organizer.py frontmatter laravel/Modules/Cms/docs        # simulazione
python3 bashscripts/tools/docs/docs-organizer.py dups laravel/Modules/Cms/docs               # simulazione
python3 -I bashscripts/tools/docs/md-filenames.py check --paths laravel/Modules/Cms/docs
rg -l '^(<<<<<<<|>>>>>>>)' laravel/Modules/Cms/docs                                          # marker di merge (anche /usr/bin/grep -r e git grep)
```

Il corpo del modulo era pulito in git (0 file modificati) e senza marker di merge.

## Cosa e' cambiato
Nessun file cancellato. Nessun commit. Nessun `.php`, nessun `.lock`, `raw/` e `stories/` non toccati (salvo questa story).

1. **Link, passata dello strumento.** `python3 bashscripts/tools/docs/docs-organizer.py links laravel/Modules/Cms/docs --tail --fix`: 24 link riscritti in 18 file (maiuscole di `readme.md`, `_` al posto di `-`, profondita' di `../`); verificato che 24 bersagli su 24 esistono su disco.
2. **Link, regola nuova (script in scratchpad `cms-fix-rooted-links.py`, importa le funzioni dell'organizer e ne ripete le guardie).** Riscrive in relativo i link scritti dalla radice del repo o di `laravel/` (`Modules/Cms/app/Models/Menu.php`, `laravel/modules/xot/docs/readme.md`) e quelli col vecchio nome `project_docs` al posto di `docs`, **solo se** il bersaglio, risolto senza distinguere le maiuscole, esiste su disco e non e' il file stesso (un rinvio a se stessi non e' una correzione). Prefissi ammessi: `Modules/`, `Themes/`, `laravel/`, `bashscripts/`; `docs/` e `vendor/` esclusi perche' ambigui. Comandi: `python3 $S/cms-fix-rooted-links.py laravel/Modules/Cms/docs --fix` (tre passate; l'ultima con `--busy0`). Risultato: 428 + 58 + 6 = 492 link riscritti, 492 su 492 con bersaglio esistente (ricontrollato dopo la scrittura). Quasi tutti in `duplicate-methods-analysis.md` (195 link a file PHP) e nelle sezioni generate «Collegamenti tra versioni di ...».
3. **Duplicati.** `dups --fix`: `ui-link-collegamenti-al-modulo.md` e `ui-link-collegamenti-al.md` marcati `superseded` verso `ui-link.md` (dopo la riscrittura dei link i tre corpi sono identici, verificato). A mano: `roadmap-.md` (corpo identico a `roadmap/legacy/legacy-roadmap.md`) marcato `superseded` verso quello; `code-quality-analysis-november-cms.md` (22 byte di differenza dal canone) marcato `superseded` verso `code-quality-analysis-cms-module.md`.
4. **Frontmatter.** `frontmatter --fix --default-status draft`: 1 file (`roadmap/roadmap-cms-module-q4.md`, chiave `qmd`).
5. **Nomi con mese o anno.** Dodici file (la regola dell'organizer vede solo date complete: ne riportava 0). Cinque rinominati con `git mv` nel repo del modulo, con nome verificato da `md-filenames.py name` e senza collisioni:

| Vecchio | Nuovo | Riferimenti riscritti |
|---|---|---|
| `phpstan-corrections-january.md` | `phpstan-corrections-cms-module.md` | `index.md` (1 riga) |
| `phpstan-compliance-december.md` | `phpstan-compliance-max-level.md` | `index.md` (1 riga); il nome intermedio `-level-10.md` e' stato scartato perche' finisce con un numero |
| `phpstan-fixes-january.md` | `phpstan-fixes-cms-module.md` | `index.md` (1 riga), `superseded_by` di `phpstan-fixes-gennaio-2025.md` (1) |
| `code-quality-analysis-cms-module-november.md` | `code-quality-analysis-cms-module.md` | nessuno |
| `quality-status-cms-module-november.md` | `quality-status-cms-module.md` | nessuno |

   Riscrittura con uno script Python di sostituzione esatta su `index.md` e `phpstan-fixes-gennaio-2025.md` (file lasciati invariati per il resto). Le due righe di `stories/docs-organization-cms.story.md` che nominano i vecchi file sono cronaca e non sono state toccate. Dopo: `rg` dei vecchi nomi in tutto `docs/` trova solo quelle due righe.
6. **Scopo.** `00-index.md` riscritto: era un file `superseded` che rinviava a `00-INDEX.md`, cioe' a se stesso con altro case (dopo la rinomina di `00-INDEX.md` del 2026-10-22), e 22 file lo puntavano (`rg`). Ora e' l'ingresso operativo (`status: active`): come leggere `status`, quali documenti descrivono davvero il meccanismo JSON del sito, a cosa serve ogni gruppo (conteggi verificati con `find`), quali sono prove vecchie e come aggiungere un documento.

### Cosa descrive il sito e cosa no (risposta alla domanda sullo scopo)
- Il sito legge **113 JSON** in `laravel/config/local/fixcity/database/content/pages/` (cartelle comprese) e **8** in `sections/`; 137 valori distinti di `type` annidati (blocchi, campi, passi di form).
- Descrivono quel meccanismo, tra i documenti `active`: `README.md`, `scopo.md`, `content-blocks-architecture.md`, `json-content-slug-uniqueness.md`, `actions/page-resolution-pipeline.md`, `wiki/concepts/container0-index-json-driven-pages.md`, `wiki/concepts/header-nav-block-architecture.md`, `bmad/decision-log.md`. In tutto 131 file (questi inclusi) citano classi o chiavi vere (`ResolvePageAction`, `BlockData`, `HasBlocks`, `content_blocks`, ...), quasi tutti `draft`.
- **Lacuna**: `service-flow` (44 dei 113 JSON) e gli altri tipi del front office non compaiono in nessun documento del Cms. I 27 file di `blocks/` descrivono le 16 classi `*Block.php` del Builder di amministrazione (`app/Filament/Blocks`); il rendering e' in `Themes/Sixteen/resources/views/components/blocks/` (168 voci), quindi la documentazione dei blocchi del sito va scritta nel tema.
- **Prove vecchie**: 7 documenti citano come reali `PageService`, `BlockService`, `ContentService`, `PublishPageAction`, `CreatePageAction` o `Page::addBlock()` (non esistono nel codice): `module-implementation-roadmap.md`, `roadmap-.md`, `roadmap-complete.md`, `roadmap/legacy/legacy-roadmap.md`, `roadmap/legacy/legacy-roadmap-complete.md`, `wiki/log.md`, `wiki/content-architecture.md`.

## Misurato dopo
Stessi comandi; per il dopo i link si misurano con `--busy-minutes 0` (vedi la trappola sotto).

| Misura | Prima | Dopo |
|---|---:|---:|
| File `.md` in `docs/` | 932 | 933 (la story) |
| `.md` nella radice | 529 | 529 |
| Link non risolti (`links --report`, 860 file letti) | 1520 | **1006** |
| Eventi `unresolved` di `links` (senza `--tail`) | 1679 | 1171 |
| Link correggibili in modo inequivocabile (`FIXABLE_BASIC`, `MOVED_UNIQUE`, `--tail`) | 23 (24 con `--tail`) | 0 (restano 2 `MOVED_UNIQUE`: hanno un solo candidato ma il link esce da `docs/`, in `filament-integration.md` e `errors/git-conflicts-themes-resolution.md`; lo strumento non li corregge e non li ho toccati) |
| Link rotti (`audit_one`, solo bersagli `.md`) | 450 su 1347 | 329 su 1374 |
| Causa dei 1006: `MOVED_MANY` / `NO_MATCH` / `OUTSIDE_OWNER` / `CODE_TARGET` / `MOVED_UNIQUE` | 869 / 208 / 213 / 207 / 16 (+7 correggibili) | 589 / 206 / 197 / 12 / 2 |
| File con frontmatter da completare (`frontmatter` simulato) | 1 | 0 |
| Copie da dichiarare (`dups` simulato) | 1 | 0 |
| Gruppi di corpi identici con 2 o piu' copie non `superseded` | 2 | 0 |
| Gruppi / copie di corpo identico (`audit_one`, `dup_body_*`) | 14 / 37 | 12 / 35 |
| Stub (`audit_one`) | 187 | 186 |
| Nomi non conformi per `md-filenames.py check` | 0 | 0 |
| Nomi con mese o anno fuori da `raw/` (regex: anni, mesi it/en) | 12 | 7 |
| File con marker di merge (`rg`, `/usr/bin/grep -r`, `git grep`) | 0 | 0 |
| `selftest` dell'organizer | ok | ok |
| Repo del modulo (`git status`) | 0 modificati | 87 `M`, 5 `R` (staged dal `git mv`), la story |

Sono stati misurati e non cambiano: 105 gruppi di nomi che differiscono per maiuscole o `_` (`near_dup_groups`), 7 `-renamed`, 11 col trattino finale, 105 con underscore, 15 con maiuscole, 44 `*.md.old`.

### Trappole misurate
- `docs-organizer.py links` salta i file toccati da meno di 10 minuti **anche in simulazione**. Dopo una passata `--fix` la simulazione successiva sottostima: ho letto 519 invece del vero 1007 (poi 1006 con l'indice nuovo). Per misurare sul vero stato: `--busy-minutes 0` prima del sottocomando (solo se si e' sicuri che i file recenti sono propri: qui lo erano tutti, controllato con `find -mmin -10 -printf`).
- La funzione di shell `grep` non funziona con `-r`: le scansioni ricorsive sono rifatte con `rg`, `/usr/bin/grep -r` e `git grep`, con lo stesso risultato.
- La regola dei nomi dell'organizer vede solo date complete (`2026-10-13`, `20261013`): `quality-status-2025.md` o `phpstan-fixes-gennaio.md` passano. Serve la regex sui mesi per vederli.

## Aperto (decisioni all'utente)
1. **Sezioni generate «Collegamenti tra versioni di ...»**: 85 sezioni in 83 file, 758 link, 445 non risolvono (il 38% dei rotti residui, 443 righe in 74 file; 5 README da 52 link morti ciascuno). Sono elenchi di copie in altri moduli prodotti da uno script, non contenuto. Proposta: toglierle (il testo resta in git) con `rg -l '^## Collegamenti tra versioni di'`. Non l'ho fatto: e' rimozione di testo, non correzione.
2. **Sette nomi con mese o anno** (nome pulito gia' occupato o file senza contenuto, quindi non rinominabili senza inventare): `phpstan-fixes-gennaio.md`, `quality-status-2025.md`, `roadmap-2025.md` (stub che rinviano a `Themes/docs/shared-components/`, cartella che non esiste), `code-quality-analysis-november.md` (`superseded`), `code-quality-analysis-november-cms.md` e `phpstan-fixes-gennaio-2025.md` (`superseded`), `test-test2025.md` (vuoto). La rimozione e' dell'utente. `docs/phpstan-analysis-gennaio.md` (fuori perimetro) linka `phpstan-fixes-gennaio-2025.md`: se si toglie quel file, va aggiornato.
3. **Altri nomi sporchi** (7 `-renamed`, 11 col trattino finale, 105 con underscore, 15 con maiuscole): piano di rinomina da una migration map (DOC-006), non da qui; 124 stub e 49 `superseded` sono il grosso.
4. **Regola dei link scritti dalla radice** (punto 2 dei cambiamenti): vale per tutti i moduli (in User, Geo, Sixteen c'e' lo stesso difetto). Decidere se entra in `docs-organizer.py links --fix` (modulo comune, non toccato da me).
5. **Elenchi generati con i vecchi nomi** (percorsi in backtick, non link): `docs/ai-agents/project-docs-index.md` e `laravel/Modules/Notify/docs/ai-agents/project-docs-index.md` elencano i cinque nomi rinominati; vanno rigenerati.
6. **Documentare i blocchi del sito** (`service-flow` e gli altri tipi dei 113 JSON) nel tema Sixteen, non nel Cms.
7. **Radice piatta di 529 file**: nessuno spostamento (DOC-006). L'indice la rende navigabile per prefisso; lo spostamento richiede una migration map.
8. **44 file `*.md.old`** (35 nella radice): copie di backup invisibili agli strumenti; da archiviare o togliere.

## Coordinamento

| Data e ora (UTC) | Agente | Atto |
|---|---|---|
| 2026-10-27 ~20:55 | subagent docs-Cms | misura iniziale (audit, links, frontmatter, dups, nomi, marker) |
| 2026-10-27 ~20:57 | subagent docs-Cms | `links --tail --fix` (24 link, 18 file) |
| 2026-10-27 ~21:00-21:12 | subagent docs-Cms | tre passate dello script dei link scritti dalla radice (492 link); `dups --fix`; `frontmatter --fix` |
| 2026-10-27 ~21:04-21:07 | subagent docs-Cms | `git mv` di cinque file, riscrittura riferimenti, tre marcature `superseded` a mano |
| 2026-10-27 ~21:10 | subagent docs-Cms | riscrittura di `00-index.md` |
| 2026-10-27 ~21:14 | subagent docs-Cms | rifatte le scansioni ricorsive con `rg`/`git grep` (messaggio del coordinatore sul `grep`), misura finale, questa story |

Nessun'altra sessione ha toccato `Modules/Cms/docs` durante il lavoro (tutti i file modificati negli ultimi 10 minuti erano miei). Non toccati: `homepage-parity-notes.md.lock` (lock vecchio di 30 giorni, non rimosso), `raw/`, `stories/` esistenti. La memoria collegata e' `docs-cms-module-order-dcp443`.