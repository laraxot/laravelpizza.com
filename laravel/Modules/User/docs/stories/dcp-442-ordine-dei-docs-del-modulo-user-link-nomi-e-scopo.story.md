---
id: dcp-442
title: "Ordine dei docs del modulo User: link, nomi e scopo"
type: story
epic: dc-parity-v2
status: in-progress
priority: P1
owner: module:User
module: User
created: 2026-10-27
updated: 2026-10-27
tags: [docs, organizzazione, link, nomi, scopo, second-brain]
related:
  - ../00-index.md
  - ../scopo.md
  - ../../../Fixcity/docs/stories/dcp-56-organizzazione-docs-moduli-e-temi.story.md
qmd: "dcp-442 docs user ordine link rotti nomi suffisso numerico scopo indice puntatore canonical themes shared-components cartelle gemelle"
---

# DCP-442: ordine dei docs del modulo User

Fase BMAD: Implementation. Seguito di DCP-56 limitato a `laravel/Modules/User/docs/**`, il perimetro piu' disordinato del monorepo.

## Richiesta

Ordine permanente dell'utente (ripetuto): «costantemente devi studiare aggiornare e migliorare e organizzare meglio le cartelle docs dentro i moduli e dentro i temi ... nei nomifile non ci devono essere date o timestamp». Concentrarsi sullo scopo dei documenti, controllare la ridondanza, DRY + KISS, mai superficiale.

## Scopo

I docs del modulo non sono un archivio: sono quello che QMD e il second brain restituiscono a chi chiede "come funziona il login" o "perche' il modello e' cosi'". Se la cartella contiene la stessa nota in tre maiuscole, 407 file che rinviano a un percorso inesistente e link che portano nel vuoto, la ricerca restituisce il documento stantio al posto di quello vero (e' gia' successo, vedi DCP-44). Tenere in ordine vuol dire due cose: che ogni gruppo di documenti dichiari a cosa serve e quanto ci si puo' fidare (ora in [00-index.md](../00-index.md)), e che i collegamenti fra documenti portino a un file che esiste.

## Misurato prima (2026-10-27, sola lettura)

Comandi: `docs-organizer.py audit --out F.json`; `docs-organizer.py links laravel/Modules/User/docs [--report]`; `... frontmatter ... --default-status draft`; `... dups ...`; `md-filenames.py check --paths laravel/Modules/User/docs --json`; `md-collisions.py plan`.

La base del 2026-10-13 (3358 file) non e' piu' valida: nel frattempo 468 copie in radice sono state ritirate come `.md.old`.

| Misura | Prima |
|---|---|
| File `.md` / nella radice | 2300 / 1294 |
| Eventi link non risolti o correggibili (`links`) | 5052 (311 correggibili con la regola base, 4741 irrisolti) |
| Link rotti per causa (`links --report`, 4570 su 2133 file) | FIXABLE_BASIC 295, MOVED_UNIQUE 525, MOVED_MANY 1970, NO_MATCH 594, CODE_TARGET 520, OUTSIDE_OWNER 666 |
| Frontmatter completo / parziale / assente | 1948 / 141 / 211 |
| Copie di contenuto da marcare (`dups`) | 38 |
| Gruppi di corpo duplicato (`dup_body_groups`) / copie in piu' | 66 / 108 |
| Collisioni di maiuscole | 82 |
| Stub | 80 (`audit`), 312 con `status: stub` |
| Nomi che violano la convenzione (`md-filenames.py check`) | 33, tutti in `archive/` (suffisso `-1` o data) |
| Marker di merge nel perimetro | 2 file (vedi Aperto) |

## Cosa e' cambiato

Nel repo annidato del modulo, nessun commit. 294 file toccati da me su 298 modificati (gli altri 4 sono di altre sessioni, vedi Coordinamento). Nessun file cancellato, spostato o rinominato.

Comandi eseguiti (da `/mnt/nas07/var/www/_bases/base_fixcity_fila5`, scritture di massa da script, cioe' `docs-organizer.py`, non edit a mano):

1. `python3 bashscripts/tools/docs/docs-organizer.py links laravel/Modules/User/docs --fix`: 311 link riscritti in 90 file, ogni nuovo bersaglio verificato su disco (311 su 311).
2. `python3 bashscripts/tools/docs/docs-organizer.py --busy-minutes 0 frontmatter laravel/Modules/User/docs --fix --default-status draft`: 192 file. Con `draft` e non `active` perche' `active` afferma «verificato».
3. `python3 bashscripts/tools/docs/docs-organizer.py --busy-minutes 0 dups laravel/Modules/User/docs --fix`, poi di nuovo dopo la correzione dei link (un gruppo di copie e' emerso solo allora): 38 file marcati `status: superseded` con `superseded_by` verso il canone. Esempi: `BMAD-SESSION.md` verso `bmad-session.md`; `archive/historical/navigation-translations-fixes-january-2026.md` (nome con data) verso `.../navigation-translations-fixes-january.md`.
4. `python3 bashscripts/tools/docs/docs-organizer.py --busy-minutes 0 links laravel/Modules/User/docs --tail --fix`: 552 link riscritti (379 nel solo `wiki/integrations/_da-riconciliare/index.md`), regola «UN solo file con la stessa coda di percorso», 552 su 552 bersagli esistenti. Nessun bersaglio inventato.
5. Modifiche a mano (3 file, corpo verificato identico a `HEAD` tranne questi): `00-index.md` riscritto come mappa degli scopi (stato verificato, senza emoji, senza il blocco-alias incollato in fondo, che rinviava a un `00-INDEX.md` inesistente); `index.md` e `00-index-indice-documentazione-modulo-user.md` ora `superseded` verso `00-index.md`.

`--busy-minutes 0` e' stato usato solo dopo aver verificato con `find -mmin -12` che i file recenti fossero tutti miei.

Verifica del corpo: per i 291 file toccati dallo script (esclusi i 3 a mano e i 4 di altre sessioni), il testo senza frontmatter e senza bersagli dei link e' identico a `HEAD`. Nessuna riga di contenuto persa.

Incidente corretto: la funzione di shell `grep` nasconde i marker di merge (`grep -rlE '^(<<<<<<<|>>>>>>>)'` non trova nulla); lo scopre `/usr/bin/grep`. Il passaggio `frontmatter` aveva inserito un blocco sopra i marker di due file; ripristinati a `HEAD` (`git show HEAD:<file> > <file>`), nessuna modifica residua.

## Misurato dopo (stessi comandi)

| Misura | Prima | Dopo |
|---|---|---|
| File `.md` / nella radice | 2300 / 1294 | 2300 / 1294 (nessuno spostato) |
| Eventi `links` irrisolti | 4741 | 4189 |
| Link correggibili (regola base) | 311 | 0 |
| Link correggibili con `--tail` (in piu' della regola base) | 552 (misurati dopo la regola base) | 2, nel file di un'altra sessione (`bmad/filament-blueprint.md`, volutamente non toccato) |
| Link rotti totali (`--report`) | 4570 | 3748 (CODE_TARGET 520, MOVED_MANY 1968, MOVED_UNIQUE 1, NO_MATCH 595, OUTSIDE_OWNER 664) |
| Frontmatter completo / parziale / assente | 1948 / 141 / 211 | 2139 / 133 / 28 |
| Copie da marcare (`dups`) | 38 | 0 |
| Gruppi di corpo duplicato / copie in piu' | 66 / 108 | 26 / 63 |
| Collisioni di maiuscole | 82 | 82 (richiedono migration map) |
| Nomi che violano la convenzione | 33 | 33 (piano sotto, soglia 30 superata) |
| `status: superseded` (`git grep` su `HEAD` / albero di lavoro) | 244 | 282 (+38) |

Frontmatter assente residuo, 28: 20 in `stories/` e 7 in `raw/` (esclusi per policy), 1 file di un'altra sessione.

## Aperto: decisioni all'utente

1. **Nomi con suffisso numerico o data: 33 file, tutti in `archive/`.** Sono piu' di 30, quindi non rinominati. In 28 casi il nome pulito esiste gia' con contenuto diverso (non si disambigua con un numero). Piano di `md-collisions.py plan` per User:
   - 8 rinomine senza perdita: `archive/traits-complete-guide-1.md` verso `traits-complete-guide.md`; `archive/user-factory-advanced-integration-1.md` verso `user-factory-advanced-integration.md`; `archive/fullcalendar-scheduler-documentation-summary-1.md` verso `fullcalendar-scheduler-documentation-summary.md`; `archive/historical/volt-folio-logout-1.md` verso `volt-folio-logout.md`; `archive/historical/volt-folio-logout-error-1.md` verso `volt-folio-logout-error.md`; con parole dal titolo: `archive/historical/avatar-implementation-1.md` verso `avatar-implementation-implementazione.md`, `archive/historical/user-factory-advanced-integration-1.md` verso `user-factory-advanced-integration-modulo-nome.md`, `archive/historical/volt-blade-implementation-1.md` verso `volt-blade-implementation-implementazione-form.md`.
   - 25 ritiri (`.md.old` sul posto): copie al 97% o piu' uguali al file con il nome pulito, 2 con data (`archive/git-conflicts-resolution-2025-01-27.md`, `archive/git_conflicts_resolution_2025_01_27.md`) e 23 `-1.md` in `archive/historical/`.
   - Rischio: `md-collisions.py apply` agisce su tutto il repo (13 rinomine, 25 ritiri; 5 rinomine sono fuori da User) e non ha filtro per modulo; 3 riferimenti entranti da correggere (`git-conflicts-resolution-2025-01-27.md` 2, `fullcalendar-scheduler-documentation-summary-1.md` 1). Va eseguito `git mv` nel repo del modulo.
2. **Rinvii morti a `Themes/docs/shared-components/`: 407 file.** Contengono la riga `See canonical documentation: ../../../Themes/docs/shared-components/<nome>.md`; la cartella non esiste (513 rinvii, 0 risolti). 285 file sono solo quel rinvio e un titolo: stub senza informazione, trovati da QMD. Gli altri 122 hanno contenuto vero piu' il rinvio morto. Decidere: ritirarli (`.md.old`) o ripristinare il canone. Non toccati.
3. **Cartelle gemelle** (da unificare con migration map, DOC-006): `_integration/` e `-integration/` (26 e 21 file; il nome con trattino iniziale rompe `ls`); `commands/`, `console-commands/`, `console_commands/`; `models/` con sette sottocartelle di backup e `tmp-rename`; `fixes/`, `bug-fixes/`, `bugfix/`, `bugs/`, `bug-tracking/`.
4. **Collisioni di maiuscole: 82 coppie**, e 26 gruppi di corpo duplicato residui che il tool non marca (nomi diversi in cartelle diverse).
5. **Link non risolti, 3748**, tutti con bersaglio inesistente o ambiguo: MOVED_MANY 1968 (il file esiste in piu' copie), NO_MATCH 595, OUTSIDE_OWNER 664, CODE_TARGET 520. Non annotati con `--annotate`: la frase «target mancante» sarebbe falsa per MOVED_MANY. Idea: far scegliere al tool la copia non `superseded` quando i candidati sono piu' d'uno (ora che 280 copie sono marcate).
6. **11 blocchi di frontmatter incollati a meta' file** (tool: `manual-stray-block`): `PROJECT-STRUCTURE.md`, `project-structure.md`, `phpstan-fix-plan.md`, `phpstan-fixes.md`, `product-roadmap.md`, `roadmap.md`, `team-contract-usage-reasoning.md`, `architecture/README.md`, `console-commands/README.md`, `commands/README.md`, `wiki/integrations/_da-riconciliare/project-structure.md`. Sono due documenti concatenati per collisione di maiuscole: separarli e' un lavoro di contenuto.
7. **Marker di merge**, non toccati: `console_commands/archive/console-commands.md`, `console_commands/archive/console_commands_philosophy.md`.
8. **`README.md`** (65 KB, 2354 righe) ha il corpo ripetuto due volte (nota di DCP-56 e del 2026-10-14). Non toccato.
9. `scopo.md` ha chiavi duplicate nel frontmatter (`updated`, `tags`, `qmd`); non corretto a mano perche' toccato da un'altra sessione il 2026-10-26.

## Coordinamento

| Data e ora (UTC) | Agente | Azione |
|---|---|---|
| 2026-10-27 20:57 | subagent docs-User | Audit e misure di partenza |
| 2026-10-27 20:58 | subagent docs-User | `links --fix` (311) |
| 2026-10-27 21:00 | subagent docs-User | `frontmatter --fix`, `dups --fix`, `links --tail --fix` (552) |
| 2026-10-27 21:05 | subagent docs-User | `00-index.md`, `index.md` e copia dell'indice |
| 2026-10-27 21:08 | subagent docs-User | ripristino dei 2 file con marker; ultimo `dups --fix` (1 file) |
| 2026-10-27 21:09 | subagent docs-User | questa story, memoria second brain |
| (altre sessioni) | non miei | `docs/bmad/filament-blueprint.md`, `docs/bmad/stories/phpstan-l10-user-seeders-tests.story.md`, `docs/google-oauth-frontoffice-setup.md`, `docs/login-fix.md`, `docs/stories/google-oauth-production-activation.story.md`: sporchi in git prima di me. Dove lo script li ha toccati (frontmatter, 2 link) il contenuto e' stato riportato a quello di partenza (hash e `git diff` uguali alla base). |

Perimetri di altri agenti, non toccati: `Modules/Cms/docs`, `bashscripts/docs/prompts`, Fixcity, Sixteen, Media, Xot.