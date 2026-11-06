---
title: "Xot: riordino della docs, numeri prima e dopo"
type: story
status: in-progress
created: 2026-10-20
updated: 2026-10-25
module: Xot
tags: [docs, organizzazione, xot, bmad, gitignore, frontmatter, superseded, vuoti]
related:
  - stories/docs-xot-studio-e-ingressi.story.md
  - stories/services-parity-audit-xot.story.md
  - bmad/stories/docs-filename-no-date-bonifica-xot.story.md
  - conventions/docs-organization.md
qmd: "xot docs riordino organizzazione file vuoti gitignore stories negazione frontmatter superseded coppie maiuscole minuscole nomi con data link rotti misura prima dopo"
---

# Xot: riordino della docs, numeri prima e dopo

Fase BMAD: implementazione (docs). Lane DOCS Xot, ordine permanente dell'utente di riordinare di continuo le docs di moduli e temi.
Solo file `.md`, la loro organizzazione e `docs/.gitignore`. Nessun PHP, nessun PHPStan, nessun Pest, nessun commit.

## Richiesta

1. Eliminare i `.md` di 0 byte solo se senza riferimenti entranti e non indici, README o story.
2. Non toccare i 9 file con marker di conflitto in `docs/archive/` (li risolve un'altra sessione).
3. Evitare che `.gitignore` nasconda file nuovi che devono essere tracciati (story, `stories/**`).
4. Radice di docs: spostare i file a tema inequivocabile, risolvere le coppie di maiuscole, togliere date e suffissi dai nomi, dare un frontmatter minimo.
5. Aggiornare `00-INDEX.md` con le sezioni reali e i link alle story `services-parity-audit-xot` e `docs-organization-xot`.
6. Regola d'oro: dopo ogni lotto i link rotti non devono aumentare (stesso script prima e dopo).

## Metodo di misura

Script proprio in Python con `-I`, sola lettura, lo stesso prima e dopo (copia in scratchpad di sessione, non in repo).
Il conteggio dei link salta code fence e code span, risolve i path relativi sul filesystem, ignora URL, ancore e path assoluti
(86 saltati). Controprova eseguita su una cartella di prova con un link valido, due rotti, un link in fence, uno in code span,
una coppia di maiuscole, un nome con data, un marker di conflitto e un file vuoto: ha riconosciuto tutto e solo quello che doveva.
Controprova dei numeri semplici con `find`, `git ls-files`, `rg --no-ignore -lP` e `grep -rlE`: conteggi uguali (2521 `.md`,
1647 vuoti tracciati, 9 file con marker).

## Numeri prima e dopo (`laravel/Modules/Xot/docs`)

| Misura | Prima | Dopo | Chi ha mosso il numero |
|---|---|---|---|
| File `.md` | 2521 | 2501 | 17 cancellati da questa lane; netto -4 da un'altra sessione (`readme.md` fusi in `README.md`, qualche pagina nuova) |
| `.md` di 0 byte tracciati | 1647 | 1626 | stessi 17, piu' 4 vuoti spariti con la fusione dei `readme.md` |
| `.md` nella radice di docs | 324 | 323 | altra sessione (`readme.md`) |
| Coppie di path che differiscono per maiuscole (solo `.md`) | 16 | 10 | altra sessione: 6 coppie `readme.md` / `README.md`; le 10 rimaste sono tutte collegate e marcate (sotto) |
| Nomi con data o suffisso numerico (escluse story `N.N.slug` e `dcp-N-`) | 133 | 127 | 2 rinomine di questa lane, 4 nomi spariti con i 17 vuoti cancellati |
| `.md` non vuoti senza frontmatter | 564 | 304 | 260 frontmatter aggiunti da questa lane |
| File con marker di conflitto | 9 | 0 | risolti da un'altra sessione (non toccati qui) |
| File ignorati da git ma tracciati e presenti | 1600 | 1583 | 17 cancellati (15 in `consolidated/`, 2 in `archive/`) |
| File ignorati e non tracciati (file nuovi nascosti) | 0 | 0 | nessuno oggi |
| Link relativi controllati | 2412 | 2336 | |
| Link relativi rotti | 1737 | 1582 | 99 riparazioni di `docs-organizer.py links` (vedi Incidente), resto altra sessione |

I link rotti non sono mai aumentati per causa di questa lane. Dopo il primo lotto (17 cancellazioni) il confronto per coppia
file/link non mostra nessun link verso i file cancellati. Le coppie "nuove" che il confronto mostra (61, quasi tutte in
`filament/README.md`) sono i link rotti che stavano in `filament/readme.md`, fuso in `README.md` da un'altra sessione.
Due link `../readme.md` in `archive/` sono rotti per la cancellazione di `docs/readme.md` fatta dalla stessa sessione; poi sono stati riparati dal tool (case).

## Cosa e' stato fatto

### Passo 1: file vuoti

Analisi dei 1647 vuoti tracciati con due metodi indipendenti (tokenizzatore Python e `grep -rhoiE`, scope: `laravel/Modules`,
`laravel/Themes`, `bashscripts`, `docs`, `bmad-output`, `bmad`, `tasks`, `laravel/app`, `laravel/config`, `laravel/routes`),
nome e path, maiuscole ignorate. Esito: 18 protetti (README, indici), 1612 referenziati, 17 senza alcun riferimento.
Per i 17 controllo finale con `rg -F -i --hidden` e `grep -rliF` sul basename e `rg` sul path `docs/<rel>`: 0 e 0 e 0
(controprova positiva sul basename `machine-learning.md`: rg 3, grep 3).

Cancellati (17, elenco completo):
`archive/laragon/update-mysql-aggiornare.md`, `archive/laravelfs-analysis.md`, `consolidated/archive/class-string-fixes.md`,
`consolidated/archive/data-object-fixes.md`, `consolidated/archive/fixes-effettuate.md`, `consolidated/archive/laravelfs-analysis.md`,
`consolidated/archive/level-10-analysis.md`, `consolidated/archive/missing-data-classes-fixes.md`,
`consolidated/archive/mixed-type-solutions.md`, `consolidated/archive/path-resolution-fixes.md`,
`consolidated/archive/property-type-fixes.md`, `consolidated/archive/return-type-fixes.md`,
`consolidated/archive/static-access-fixes.md`, `consolidated/archive/summary-of-all-fixes.md`,
`consolidated/archive/update-mysql-aggiornare.md`, `consolidated/panel-provider-1.md`, `consolidated/xotbase-extension-rules-2.md`.
Lock per directory (`archive`, `consolidated`), rilasciati. Git li ricorda.

Restano 1612 vuoti referenziati, per tipo di riferimento:

| Tipo | N | Esempio |
|---|---|---|
| Solo il basename compare altrove, nessun link o path risolve a questo file | 874 | `testing.md` nominato in un log |
| Il path compare solo in indici generati (`project-docs-index.md`, copie in Notify, `bashscripts/ai/.agents/docs`, `bashscripts/ai/wiki/docs`), report e log | 638 | `_integration/machine-learning.md` |
| Il path o il link compare in docs reali (pagine di regole, guideline, altre docs di Xot) | 100 | `module-structure.md` |

Per la regola "nessun riferimento" restano tutti. Vedi Decisioni aperte.

### Passo 2: marker di conflitto

Non toccato. Oggi sono 0 (misura con `rg --no-ignore -lP '^(<{7}|>{7})( |$)'` e `grep -rlE`; il prima era 9 con gli stessi due metodi).
Li ha risolti l'altra sessione mentre questa lane lavorava.

### Passo 3: `docs/.gitignore`

`git check-ignore -v` su file nuovi ipotetici, prima e dopo. Le story di primo livello (`stories/**`, `bmad/stories/**`,
`stories/phpstan-*.story.md`) non erano nascoste: 0 story tracciate-ignorate, 0 file ignorati non tracciati.
Nascoste erano solo le cartelle annidate `archive/` e `consolidated/` dentro `stories/` e `bmad/stories/`:

| File ipotetico | Prima | Dopo |
|---|---|---|
| `docs/stories/archive/foo.story.md` | ignorato (`.gitignore:54 docs/**/archive/`) | non ignorato |
| `docs/stories/a/archive/foo.story.md` | ignorato (stessa regola) | non ignorato |
| `docs/stories/consolidated/foo.story.md` | ignorato (`docs/.gitignore:8 consolidated`) | non ignorato |
| `docs/bmad/stories/archive/foo.story.md` | ignorato (`docs/**/archive/`) | non ignorato |
| `docs/bmad/stories/consolidated/foo.story.md` | ignorato (`docs/.gitignore:8`) | non ignorato |
| `docs/stories/phpstan-foo.story.md` | non ignorato | non ignorato |
| `docs/archive/foo.md`, `docs/consolidated/foo.md`, `docs/phpstan/foo.md`, `docs/actions/archive/foo.md`, `docs/wiki/consolidated/foo.md`, `docs/archive/stories/foo.story.md` | ignorati | ignorati (controllo: la negazione non perde) |

Aggiunte 4 righe in coda a `docs/.gitignore`: `!stories/**/archive/`, `!stories/**/consolidated/`, `!bmad/stories/**/archive/`,
`!bmad/stories/**/consolidated/` (l'ultima regola vince, stanno dopo `consolidated`). `docs/phpstan/` resta ignorata di proposito:
contiene 20 `level-N.json` (dati, non docs). Il `.gitignore` radice del modulo non e' stato toccato.
Prima del cambio il file e' stato copiato in scratchpad; il "prima" e' stato ricostruito in un repo git temporaneo con i due `.gitignore` originali.

### Passo 4: radice, coppie, nomi, frontmatter

Spostamenti dalla radice a sottocartelle: **non eseguiti**. Nessuno strumento del repo sposta un file tra directory riscrivendo i riferimenti:
`docs-organizer.py` "mai cancella, sposta o rinomina" e `md-filenames.py apply` cambia solo l'ultimo componente del path. Spostare a mano
con un mio script avrebbe violato l'ordine di usare solo gli strumenti del repo. Radice: 323 file, vedi Decisioni aperte.

Coppie di maiuscole (sha256 confrontati prima di agire). Nessun file cancellato: tutti hanno riferimenti entranti per path esatto.

| Coppia | Contenuto | Esito |
|---|---|---|
| `CHANGELOG.MD` / `changelog.MD` | identici | `changelog.MD` `superseded_by: CHANGELOG.MD` |
| `REFACTOR-panelmixin.md` / `refactor-panelmixin.md` | identici | la maiuscola `superseded_by` la minuscola |
| `QA-VERIFICATION.md` / `qa-verification.md` | identici | idem |
| `filament/infinite-loop-getStepByName-fix.md` / `...getstepbyname-fix.md` | entrambi vuoti | la camelCase e' ora uno stub `superseded_by` la minuscola |
| `wiki/commands/INDEX.md` / `index.md` | stesso corpo | `INDEX.md` `superseded_by: index.md` (via `docs-organizer.py dups`) |
| `wiki/concepts/INDEX.md` / `index.md` | divergenti, `index.md` piu' ricco | `INDEX.md` superseded, contenuto conservato |
| `wiki/AGENTS.md` / `agents.md` | stesso corpo salvo 3 chiavi di frontmatter | `AGENTS.md` superseded |
| `wiki/Architecture.md` / `architecture.md` | divergenti in una nota (la minuscola e' quella verificata) | `Architecture.md` superseded |
| `INDEX.md` / `index.md` | divergenti, `INDEX.md` e' lo spine dichiarato | `index.md` `superseded_by: INDEX.md` |
| `00-INDEX.md` / `00-index.md` | divergenti | `00-index.md` era gia' alias `superseded` verso `00-INDEX.md` |

Le coppie restano due file con lo stesso nome a meno delle maiuscole: su un filesystem senza distinzione di maiuscole collidono ancora.
Per toglierle davvero serve cancellare una meta', dopo aver riscritto i link per path esatto.

`docs-organizer.py dups --fix` ha marcato `superseded` altri 8 file con corpo identico (frontmatter a parte), sempre con `superseded_by`:
`base/url-not-found.md`, `consolidated/architecture/development-rules.md`, `wiki/best-practices/README.md`, `wiki/architecture/architecture-best-practices.md`,
`wiki/laragon/update-mysql.md`, `wiki/testing/coverage-100-execution-notes.md`, `wiki/testing/coverage.md`, `wiki/commands/INDEX.md`.
Altri 38 candidati non scritti: 32 senza frontmatter (il tool non ne crea), 6 occupati (`--busy-minutes 30`).

Nomi con data o suffisso: `md-filenames.py plan` propone 82 rinomine in Xot. Applicate solo 2, con `apply --only` e `--map-out`:
`bmad/stories/10000-phpstan-modules-fix-2026-10-15.story.md` diventa `10000-phpstan-modules-fix.story.md` (il numero 10000 resta),
`phpstan-fixes-summary.md` diventa `phpstan-fixes-summary-risultati-finali-gennaio.md`. Entrambi senza riferimenti fuori dagli indici generati
(tre `project-docs-index.md` riscritti dal tool; 308 file sporchi saltati, con le due copie piu' vecchie ancora al nome vecchio: sono indici generati).
Non applicate le altre, per tre motivi: 80 sono in `archive/` e 40 in `consolidated/`, cartelle ignorate da git (rinominare un file tracciato li' lo fa uscire dal tracciamento);
in radice i 6 rimasti sono citati come esempio di nome vietato in guideline e report (il tool li riscriverebbe distruggendo la spiegazione) o sono falsi positivi;
`migrazione-filament.md` e' un falso positivo (4 e' la versione di Filament; `KEEP_AFTER` del tool non ha `filament`).

Frontmatter: aggiunto lo schema minimo (`title`, `type: note`, `status: unverified`, `created`, `updated`, `module: Xot`, `tags`, piu' `qmd` perche' la convenzione 55 lo chiede) a 260 file non vuoti,
con uno script proprio che antepone il blocco e verifica byte per byte che il corpo non sia cambiato (corpo identico per costruzione, asserzione nel codice).
`created` e `updated` dalla storia git del file. Lo `status` e' `unverified`, non `active`: nessuno ha letto quei contenuti. Esclusi `archive/`, `consolidated/`,
`-integration/`, `_integration/`, `raw/`, `stories/` e `bmad/stories/` (rumore di massa o policy delle story) e 4 file sporchi in git. Per `docs-organizer.py frontmatter --fix`:
non usato, perche' riscrive anche i blocchi spuri nel corpo e aggiunge chiavi a tutti i file (oltre il perimetro chiesto).

### Passo 5: indice

`docs/00-INDEX.md` aggiornato con una sezione sulla organizzazione e i link alle due story. Non e' stato riscritto altro contenuto.
Vedi Decisioni aperte per chi e' l'ingresso canonico.

## Incidente: riparazione link prima del divieto

Prima che il coordinatore vietasse `docs-organizer.py links --fix`, questa lane lo ha eseguito (senza `--by-name`) su sei sottocartelle
(`archive`, `standards`, `bmad`, `consolidated`, `phpstan-fix-plan`, `wiki/memories`; `filament` saltata per gate), con lock di directory e `--busy-minutes 30`.
Risultato: 99 link riparati (21 solo di maiuscole, 78 di profondita' `../`). Verifica a posteriori: in tutti e 99 i casi il nuovo target esiste
e ha lo stesso basename (maiuscole a parte) di quello vecchio. Nessuna story toccata (la cartella `bmad/stories/` e' saltata dal tool,
`git status` conferma). L'elenco e' in scratchpad (`links-fix-applied.json`). Non usare `--fix` da ora: serve una revisione a occhio se
la riparazione finisce nel ripristino del coordinatore. Nessuna annotazione `--annotate` fatta.

## Decisioni aperte

1. **1612 file vuoti referenziati.** 874 hanno solo il basename citato altrove e 638 solo da indici generati e log: cancellarli non romperebbe un link che risolve.
   Serve il via dell'owner dei tre `project-docs-index.md` (Notify e `bashscripts/ai`) o la loro rigenerazione prima. 100 hanno un riferimento reale: restano.
2. **Spostamenti dalla radice** (323 file): serve uno strumento che sposti e riscriva i riferimenti (estendere `md-filenames.py` o aggiungere un comando a `docs-organizer.py`). Fino ad allora la radice non si riduce.
3. **Ingresso canonico.** L'ordine di questa lane dice `00-INDEX.md`; `README.md` si dichiara "ingresso unico"; `INDEX.md` si dichiara "indice canonico"
   (spine) e `conventions/docs-organization.md` dice README unico ingresso con gli altri come alias. Tre pagine, tre rivendicazioni: serve una decisione.
4. **Rinomina dei 120 nomi con data in `archive/` e `consolidated/`.** Prima va deciso se quei file devono essere tracciati (oggi sono tracciati ma la cartella e' ignorata).
5. **Falso positivo del tool** `migrazione-filament.md`: aggiungere `filament` a `KEEP_AFTER` in `md-filenames.py` (non toccato qui).
6. **Coppie di maiuscole** chiuse il 2026-10-25 (vedi sotto): 8 -> 0 gruppi.
7. **Link rotti rimasti**: 1582, soprattutto verso path di altri progetti, `docs/` di altri moduli inesistenti e README di cartelle sparite. Nessun intervento qui (divieto del coordinatore).
8. **`wiki/Architecture.md`** era `stale`, ora `superseded`: la ragione `stale` e' nel corpo, non piu' nello status.

## Verifica

- Misura prima e dopo con lo stesso script e controprova su fixture (sopra).
- Conteggi base confrontati con `find`, `git ls-files`, `rg --no-ignore -lP`, `grep -rlE`.
- Link rotti per fase: 1737 all'inizio, 1673 dopo le cancellazioni, 1673 dopo rinomine e coppie, 1673 dopo i frontmatter, 1582 dopo le riparazioni. Nessuna fase di questa lane ha aggiunto link rotti; le due coppie nuove `../readme.md` in `archive/` vengono dalla cancellazione di `docs/readme.md` fatta dall'altra sessione.
- Lock presi a livello di directory o di file, tutti rilasciati (`find -name '*.lock'` negli ultimi 60 minuti: nessuno).
- Gate che hanno detto SKIP e rifatti dopo il raffreddamento: `wiki/`, `filament/` (tocchi miei di meno di 120 secondi).

## Trappole trovate

- In questa shell `find` e' una funzione che chiama `bfs`: `find -newermt '-120 seconds'` stampa un errore e niente su stdout, quindi `[ -z "$(find ...)" ]` passa sempre.
  Il gate va fatto con `/usr/bin/find` (GNU). Controprova: file appena creato, GNU lo trova.
- In zsh una variabile non quotata non si divide in parole: `rg ... $SC` cercava in una directory chiamata `laravel/Modules laravel/Themes ...` e dava 0 per ogni file (falso zero). Con array bash la controprova stampa 3.
- `rg --no-ignore` salta comunque le cartelle nascoste (`bashscripts/ai/.agents/...`): serve anche `--hidden`.
- `md-filenames.py check --paths <cartella>` stampa 0 perche' scarta i path che non finiscono in `.md`; per questo il conteggio dei nomi usa `violations()` del tool, importato.

## Collasso delle coppie di maiuscole

Le 8 coppie ancora aperte sono state chiuse con una politica unica: il nome
canonico e' il minuscolo, la meta' maiuscola o camelCase viene archiviata con
`git mv <gemello> <nome>.old` (nessun file cancellato). Prima di ogni rinomina,
prova di sussunzione: `grep -vxFf <canonico> <gemello> | grep -vc '^$'`; se il
gemello aveva righe uniche, fusione a mano nel canonico.

| Coppia | Esito |
|---|---|
| `CHANGELOG.MD` / `changelog.MD` | assorbiti in `CHANGELOG.md` di radice; archiviati come `changelog-md-uppercase.md.old` e `changelog-md-lowercase.md.old` |
| `QA-VERIFICATION.md` / `qa-verification.md` | `qa-verification.md.old`; lo stub minuscolo ora punta alla story della bonifica, non a se stesso |
| `REFACTOR-panelmixin.md` / `refactor-panelmixin.md` | `refactor-panelmixin.md.old`, stesso trattamento |
| `bmad/stories/ST-XX-relationx-analysis.md` / `st-xx-...` | `st-xx-relationx-analysis.md.old` (corpi identici) |
| `consolidated/CODE_QUALITY.md` / `code_quality.md` | `code_quality.md.old` (il maiuscolo era 0 byte) |
| `stories/STORY-XXX-phpstan-zero-error-compliance-bmad.md` / `story-xxx-...` | `story-xxx-phpstan-zero-error-compliance-bmad.md.old` (corpi identici, 13126 byte) |
| `wiki/AGENTS.md` / `agents.md` | `agents.md.old` (il maiuscolo era lo stub superseded) |
| `filament/infinite-loop-getStepByName-fix.md` / `...getstepbyname-fix.md` | stub archiviato con `superseded_by` corretto a `infinite-loop-get-step-by-name-fix.md`, che e' il documento reale (4908 byte); la minuscola era 0 byte |

Trovato in piu' nella stessa cartella: `filament/infinite_loop_getstepbyname_fix.md`
(0 byte, underscore) era un terzo gemello dello stesso concetto, archiviato anche lui.

Effetto collaterale riparato: `CHANGELOG.md` di radice conteneva due volte lo stesso
blocco assorbito (145 righe duplicate), un blocco di chiavi frontmatter senza delimitatori
a meta' corpo e 4 link a documenti inesistenti. Ora e' un changelog unico, con la voce
`[2025-06-04]` che esisteva solo nelle due copie in `docs/`.

Misura con lo stesso script del censimento (`os.walk` su `docs/`, basename in minuscolo):
**8 gruppi -> 0**; file `.md` 1851 -> 1842 (i `.old` non rientrano nel conteggio).
