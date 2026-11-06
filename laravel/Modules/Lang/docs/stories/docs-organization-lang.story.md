---
title: "Riordino della docs del modulo Lang"
type: story
status: partial
created: 2026-10-20
updated: 2026-10-20
module: Lang
tags: [docs, lang, bmad, riordino, gitignore, maiuscole, frontmatter]
qmd: "lang docs riordino coppie maiuscole superseded gitignore story phpstan versionate frontmatter minimo DIVERGENZA indice canonico 00-INDEX"
related:
  - ../00-INDEX.md
  - ./docs-lang-studio.story.md
  - ./phpstan-test-wave-lang.story.md
  - ../../../../../bashscripts/docs/modular-bmad-story-policy.md
  - ../../../../../bashscripts/docs/prompts/44-module-docs-continuous.md
---

# Riordino della docs del modulo Lang

## Richiesta
Fase BMAD documentazione (lane DOCS, Lang). Ordine permanente dell'utente: riordinare di continuo le docs di moduli e temi. Perimetro: solo file `.md`, la loro organizzazione e `docs/.gitignore`. Nessun codice, nessun commit.

## Analisi
La docs di Lang aveva quattro difetti misurabili:
1. Le story `phpstan-*.story.md` erano nascoste dal `phpstan*` del `.gitignore` radice del modulo (riga 123, pensato per cache e baseline): il commit automatico non le raccoglieva. Erano 4 story piu' 1 pagina.
2. 94 coppie di path che differiscono solo per le maiuscole (es. `PRD.md` e `prd.md`), di cui 38 sono note di divergenza `*.DIVERGENZA.md` / `*.divergenza.md` in `wiki/integrations/_da-riconciliare/`.
3. 19 file non vuoti senza frontmatter.
4. 16 nomi con data o suffisso numerico (10 in `raw/`, immutabile per policy).

## Modifiche
- **`docs/.gitignore`**: aggiunte `!stories/phpstan-*.story.md` e `!phpstan-*.story.md`. Il `.gitignore` radice del modulo non e' stato toccato. Prova con `git check-ignore -v -n`: prima `phpstan*` (riga 123 del `.gitignore` radice) copriva tutti i path; dopo la regola `docs/.gitignore:55:!phpstan-*.story.md` li riabilita (story esistenti e path ipotetico). `docs/phpstan-corrections-subagent.md` (non e' una story) resta ignorato, come `docs/phpstan/`.
- **Gemelli per maiuscole**: canonico = nome minuscolo (eccezioni `README.md`, `CHANGELOG.md`, `AGENTS.md`, `00-INDEX.md`; per `INDEX.md`/`index.md` e `README.*` nelle sottocartelle, chi ha piu' riferimenti entranti). 45 gemelli marcati `status: superseded` con `superseded_by` (frontmatter, corpo invariato); 4 erano gia' superseded. 37 duplicati `*.DIVERGENZA.md` cancellati: corpo identico al gemello `*.divergenza.md`, frontmatter uguale a meno delle maiuscole, tracciati e puliti in git, zero riferimenti entranti con due metodi indipendenti (indice Python dei token `*.md` su tutto il repo e `grep -F` ricorsivo con controprova positiva su `00-INDEX.md`), mtime oltre 120 secondi. Controllo dopo la cancellazione: `rg -F` sui 37 nomi in `laravel`, `bashscripts`, `docs`, `bmad-output` = 0 risultati (controprova positiva sullo stesso comando).
- **Indice**: `index.md` marcato superseded da `00-INDEX.md`; `00-INDEX.md` aggiornato con i conteggi reali per cartella e la sezione "Riordino della docs". `00-INDEX.md` non e' in conflitto (`git status` senza `UU/DU/UD/AA`, nessun marker).
- **Frontmatter minimo** (title, type, status: draft, created, updated, module, tags) a 19 file senza, corpo invariato (`git diff --numstat`: solo righe aggiunte). Date da `git log` o mtime.
- **Rinomina con `md-filenames.py apply`**: `quality-analysis-report-media-module.md` diventa `quality-analysis-report-lang-module.md` (nessun riferimento riscritto, 0 file toccati).

## Verifica
Misura con uno script Python proprio (salta code fence e code span; controprova su una cartella di prova con link valido, link rotto, marker, coppia di maiuscole, nome datato e file senza frontmatter), stessi criteri prima e dopo.

| Misura | Prima | Dopo |
|---|---|---|
| File `.md` | 1014 | 978 |
| `.md` nella radice di `docs/` | 512 | 512 |
| Coppie di path solo per maiuscole (gruppi) | 94 | 57 |
| Nomi con data o suffisso numerico (10 in `raw/`) | 16 | 15 |
| Non vuoti senza frontmatter | 19 | 0 |
| `.md` di 0 byte | 0 | 0 |
| Link relativi rotti | 2449 | 2412 |
| File con marker di conflitto | 0 | 0 |
| `.md` ignorati e non tracciati | 5 | 1 |

I link rotti non sono aumentati: calo di 37 per i duplicati cancellati. Controprova degli zeri: marker con `rg -P` e con `/bin/grep -E` (stesso zero, sonda positiva su un file di prova); 0 byte con `find -size 0`.

## Decisioni
- Canonico minuscolo anche quando il gemello maiuscolo ha piu' riferimenti: i link verso il gemello superseded continuano a risolvere, e la regola dei nomi vince sulla popolarita'.
- Cancellati solo i duplicati senza alcun riferimento; tutto il resto resta, marcato.
- Le coppie con contenuto diverso (similarita' sotto 0.9) non sono state marcate: nascondere un documento sostanziale dietro un puntatore e' peggio di un gemello in piu'.

## Aperto
- **Coppie divergenti non risolte** (decisione dell'owner): `PHILOSOPHY.md` (29 KB, stable, 9 riferimenti) contro `philosophy.md` (8 KB, 90 riferimenti); `PHPSTAN-FIXES.md` contro `phpstan-fixes.md`; `bmad/ARCHITECTURE.md` contro `bmad/architecture.md`; `AGENTS.md` contro `agents.md` in `llm-wiki/` e `wiki/` (7 KB contro 3 KB); `wiki/INDEX.md` contro `wiki/index.md`; la coppia `pluralization-and-localization.DIVERGENZA.md` (le due note riguardano file diversi).
- **`INDEX.md` contro `index.md` in radice**: `INDEX.md` era in modifica non committata di un'altra sessione, non toccato. `index.md` rimanda a `00-INDEX.md`.
- **5 nomi datati non rinominati**: `analysis-results-risultati-analisi-modulo-lang.md`, `enum-translation-pattern-implementation-implementazione-regola-critica.md`, `lang-service-translation-updates-aggiornamento-file-traduzione.md`, `quality-improvements-miglioramenti-qualita-codice-modulo.md`, `translation-refactor-complete-summary-completo-file-traduzione-riepilogo.md`. Il dry-run preciso di `md-filenames.py apply` mostra che riscriverebbe anche file di altri moduli (Geo, Notify, Xot, temi), il registro `bashscripts/docs/md-collisions-migration-map.json` e `bashscripts/ai/.ai/guidelines/documentation-rename-plan.md` (tabelle vecchio/nuovo che diventerebbero nuovo/nuovo): fuori perimetro, quindi lasciati. Serve una modalita' di `apply` limitata a un modulo che salti i registri di rinomina.
- **Radice di `docs/`**: restano 512 `.md`. Nessuno strumento del repo sposta file tra cartelle riscrivendo i riferimenti (`md-filenames.py` cambia solo il nome, `docs-organizer.py` non sposta); spostare a mano romperebbe link. Da fare quando esiste lo strumento.
- **`docs/phpstan-corrections-subagent.md`** e' un rapporto non-story ancora nascosto da `phpstan*` e non tracciato: decidere se versionarlo con `!phpstan-corrections-subagent.md`.
- I 2412 link rotti restano: la riparazione dei link e' dello strumento in lavorazione in un'altra sessione.
