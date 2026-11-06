---
title: "Riordino della docs del modulo Cms"
type: story
status: partial
created: 2026-10-20
updated: 2026-10-20
module: Cms
tags: [docs, cms, bmad, riordino, maiuscole, frontmatter]
qmd: "cms docs riordino coppie maiuscole superseded merged gitignore story phpstan non ignorate frontmatter minimo indice canonico 00-INDEX"
related:
  - ../00-INDEX.md
  - ./docs-cms-studio.story.md
  - ../../../Lang/docs/stories/docs-organization-lang.story.md
  - ../../../../../bashscripts/docs/modular-bmad-story-policy.md
  - ../../../../../bashscripts/docs/prompts/44-module-docs-continuous.md
---

# Riordino della docs del modulo Cms

## Richiesta
Fase BMAD documentazione (lane DOCS, Cms, dopo Lang). Ordine permanente dell'utente: riordinare di continuo le docs di moduli e temi. Perimetro: solo file `.md`, la loro organizzazione e `docs/.gitignore`. Nessun codice, nessun commit.

## Analisi
- **`.gitignore`**: il Cms non ha `docs/.gitignore` e il `.gitignore` radice del modulo non ha `phpstan*` (solo `docs/phpstan/`). Prova con `git check-ignore -v -n` su una story esistente (`docs/stories/phpstan-test-wave-cms.story.md`), su un path ipotetico (`docs/stories/phpstan-ipotetica-lcu.story.md`, `docs/phpstan-ipotetica-lcu.story.md`) e su `docs/phpstan.md`: nessuno e' ignorato (exit 1, prima e dopo). Non serve alcuna negazione e non ne e' stata aggiunta.
- 41 coppie di path che differiscono solo per le maiuscole. Una sessione precedente aveva gia' unificato alcune coppie con `status: merged` (es. `CHANGELOG.md` rimanda a `changelog.md`): la direzione e' stata rispettata, non invertita.
- 21 file non vuoti senza frontmatter; 31 nomi con data o suffisso numerico (26 in `raw/`, immutabile).

## Modifiche
- **Gemelli per maiuscole**: canonico = nome minuscolo (eccezioni `README.md`, `AGENTS.md`, `00-INDEX.md`; per `INDEX.md`/`index.md` nelle sottocartelle, chi ha piu' riferimenti entranti). 30 gemelli marcati `status: superseded` con `superseded_by` (corpo invariato); 5 gia' superseded o merged non toccati. 1 cancellato: `design-comuni/screenshots/TESTS_ROUTING_NORMALIZATION.md` (corpo identico a `tests_routing_normalization.md`, frontmatter uguale a meno delle maiuscole, tracciato, pulito in git, zero riferimenti entranti con due metodi indipendenti e controprova positiva, mtime oltre 120 secondi; dopo la cancellazione `rg -F` sul nome = 0 risultati).
- **Rinomina con `md-filenames.py apply`**, solo dove il dry-run preciso non riscrive nulla fuori dal modulo: `quality-status.md` diventa `quality-status-cms-module-november.md`, `fix-session-2026-07-13.md` diventa `fix-session.md`, `coverage-pest.md` diventa `coverage-pest.md`, `roadmap/roadmap.md` diventa `roadmap/roadmap-cms-module-q4.md` (0 riferimenti riscritti, 4 file mossi).
- **Frontmatter minimo** (title, type, status: draft, created, updated, module, tags) a 21 file senza, corpo invariato. Il titolo di `coverage-pest.md` e' ricavato solo dalla prima riga logica: il file contiene `\n` letterali al posto degli a capo.
- **Indice**: `00-INDEX.md` aggiornato con i conteggi reali e la sezione "Riordino della docs". `index.md` e' il catalogo per argomento e rimanda gia' a `00-INDEX.md` con una nota in testa: non marcato superseded.

## Verifica
Stesso script di misura di Lang (Python proprio, salta code fence e code span, controprova su cartella di prova), stessi criteri prima e dopo.

| Misura | Prima | Dopo |
|---|---|---|
| File `.md` | 988 | 988 |
| `.md` nella radice di `docs/` | 567 | 567 |
| Coppie di path solo per maiuscole (gruppi) | 41 | 40 |
| Nomi con data o suffisso numerico (26 in `raw/`) | 31 | 27 |
| Non vuoti senza frontmatter | 21 | 0 |
| `.md` di 0 byte | 0 | 0 |
| Link relativi rotti | 1866 | 1868 (vedi nota) |
| File con marker di conflitto | 0 | 0 |
| `.md` ignorati e non tracciati | 0 | 0 |

Nota sui link rotti. Confronto insiemistico con la copia di `HEAD` (stesso script, simboli verso il resto del repo): rispetto a `HEAD` il mio lavoro ha introdotto un solo link rotto, quello da `00-INDEX.md` a questa story, ora risolto (verificato dopo la creazione della story). Il conteggio assoluto passa da 1866 a 1868 (+2): la differenza non compare nel confronto con `HEAD` ed e' attribuibile a modifiche di altre sessioni durante il lavoro (file non toccati da questa lane); non ho potuto isolarla oltre. Controprova degli zeri: marker con `rg -P` e con `/bin/grep -E`, 0 byte con `find -size 0`.

## Decisioni
- Stessa regola di Lang: canonico minuscolo, gemello superseded, cancellazione solo con zero riferimenti.
- Le coppie con contenuto diverso (similarita' sotto 0.9) non sono state marcate se il gemello piu' piccolo non e' chiaramente uno stub.
- `code-quality-analysis-cms-module-november.md` non rinominato: `md-filenames.py apply` riscriverebbe anche i registri di lavoro `docs/worklog/2026/03/13/*.md` e `bashscripts/docs/md-collisions-migration-map.json`, che sono cronologia.

## Coppie divergenti — chiuse per contenuto (2026-10-25)
Le coppie non si fondono (due PRD, due strategie: un merge produrrebbe un testo
contraddittorio) e non si archiviano (nessuna prova di sussunzione). Si rinominano per
concetto, come gia' fatto in `Themes/Barthelemy`:

| Prima | Dopo | Perche' |
|---|---|---|
| `PHILOSOPHY.md` (625 r., dogmi EN) | `philosophy-religion.md` | `philosophy.md` (153 r., IT, con story e issue) resta il canonico del modulo |
| `PRD.md` (525 r., corporate v1.0) | `prd-corporate.md` | `prd.md` (94 r., vivente) resta il canonico; il corporate non e' dichiarato superseded perche' nessuno l'ha deciso |
| `PRODUCT_STRATEGY.md` (97 r., EN) | `product-strategy-corporate.md`, con `superseded_by: product-strategy.md` | il file si dichiarava gia' superseded verso `product_strategy.md`, nome che non esiste piu' dopo il collasso: puntatore riallineato al reale |

Census `basename.lower()` per cartella: **3 -> 0 gruppi** (927 `.md`). Link ripuntati:
`index.md` (3 ref), piu' 4 moduli esterni (Seo x2, AI, Blog) che puntavano a
`Cms/docs/PRD.md` e ora vanno a `prd.md`.

## Aperto
- **Radice di `docs/`**: 525 `.md`. Nessuno strumento del repo sposta file tra cartelle
  riscrivendo i riferimenti; spostare a mano romperebbe link.
- **Link rotti preesistenti**: centinaia, quasi tutti path stile `laravel/modules/xot/...`
  o `docs/...` mai esistiti in questo checkout. La riparazione e' dello strumento in
  lavorazione in un'altra sessione; qui nessun `--fix`.
- **Blocchi frontmatter spurii**: il generatore shard lascia un secondo blocco
  `title: ...` dentro il corpo (996 file in tutto il repo). Rimosso nei file toccati; in Cms
  il rilevatore stretto ora non ne trova (0), il resto del repo e' uno sweep a se'.
