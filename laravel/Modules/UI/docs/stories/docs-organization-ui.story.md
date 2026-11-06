---
title: "Riordino della docs del modulo UI"
type: story
status: partial
created: 2026-10-20
updated: 2026-10-20
module: UI
tags: [docs, ui, bmad, riordino, gitignore, maiuscole, frontmatter]
qmd: "ui docs riordino coppie maiuscole superseded gitignore story phpstan radice docs versionate frontmatter minimo indice canonico 00-INDEX vuoti"
related:
  - ../00-INDEX.md
  - ./docs-ui-studio-e-ingressi.story.md
  - ./phpstan-test-wave-ui.story.md
  - ../../../Lang/docs/stories/docs-organization-lang.story.md
  - ../../../../../bashscripts/docs/modular-bmad-story-policy.md
  - ../../../../../bashscripts/docs/prompts/44-module-docs-continuous.md
---

# Riordino della docs del modulo UI

## Richiesta
Fase BMAD documentazione (lane DOCS, UI, ultimo dei tre moduli). Ordine permanente dell'utente: riordinare di continuo le docs di moduli e temi. Perimetro: solo file `.md`, la loro organizzazione e `docs/.gitignore`. Nessun codice, nessun commit.

## Analisi
- `docs/.gitignore` aveva `phpstan*` (riga 214) con la negazione `!stories/phpstan-*.story.md` (riga 216): le story in `stories/` erano visibili, quelle fuori da `stories/` no. Il `.gitignore` radice del modulo non e' stato toccato.
- Un'altra sessione lavora sulla radice della docs di UI: ha cancellato `readme.md` e `bmad/readme.md`, creato `readme-legacy-snapshot.md` e un `INDEX.md` non tracciato che si dichiara canonico. Questi file non sono stati toccati e spiegano parte della differenza nei numeri sotto (le coppie `readme.md`/`README.md` sono sparite da sole).
- 305 dei 483 `.md` hanno 0 byte.

## Modifiche
- **`docs/.gitignore`**: aggiunta `!phpstan-*.story.md` subito dopo la regola esistente. Prova con `git check-ignore -v -n` e con l'exit code:
  - prima: `docs/phpstan-test-wave-ui.story.md` e il path ipotetico `docs/phpstan-ipotetica-lcu.story.md` coperti da `docs/.gitignore:214:phpstan*` (exit 0, ignorati); `docs/stories/phpstan-ipotetica-lcu.story.md` gia' riabilitato da `:216`.
  - dopo: gli stessi due path risolvono su `docs/.gitignore:218:!phpstan-*.story.md` (exit 1, visibili). `docs/phpstan-ipotetica-lcu.md` (non story) e `docs/phpstan/x.md` restano ignorati, come voluto.
- **Gemelli per maiuscole**: canonico = nome minuscolo (eccezioni `README.md`, `AGENTS.md`, `00-INDEX.md`; per `INDEX.md`/`index.md` nelle sottocartelle, chi ha piu' riferimenti entranti). 7 gemelli marcati `status: superseded` con `superseded_by` (corpo invariato), tra cui la story `bmad/stories/STORY-UI-TABLE-LAYOUT-ENUM-TRANSLATIONS.md` (identica per sha256 al gemello minuscolo; due riferimenti entranti, quindi non cancellata, e le story non si cancellano mai). 1 gia' superseded (`00-index.md`). Nessuna cancellazione: nessun gemello aveva zero riferimenti con corpo equivalente.
- **Frontmatter minimo** (title, type, status: draft, created, updated, module, tags) a 38 file senza, corpo invariato. Escluso `index.md` (famiglia degli indici in lavorazione altrove).
- **Indice**: `00-INDEX.md` aggiornato con i conteggi reali e la sezione "Riordino della docs"; corretta la frase "non esiste `index.md`" (esiste, 2 righe).

## Verifica
Stesso script di misura di Lang e Cms (Python proprio, salta code fence e code span, controprova su cartella di prova), stessi criteri prima e dopo.

| Misura | Prima | Dopo |
|---|---|---|
| File `.md` | 484 | 484 (con questa story; l'altra sessione ha tolto `readme.md` e `bmad/readme.md` e aggiunto `readme-legacy-snapshot.md`) |
| `.md` nella radice di `docs/` | 223 | 223 |
| Coppie di path solo per maiuscole (gruppi) | 15 | 13 |
| Nomi con data o suffisso numerico | 0 | 0 |
| Non vuoti senza frontmatter | 40 | 1 (`index.md`, escluso) |
| `.md` di 0 byte | 305 | 305 |
| Link relativi rotti | 313 | 275 |
| File con marker di conflitto | 0 | 0 |
| `.md` ignorati e non tracciati | 0 | 0 |

Dei 15 gruppi iniziali, 2 sono spariti per la cancellazione di `readme.md` e `bmad/readme.md` fatta dall'altra sessione (verificato: `git ls-files` ha entrambe le coppie `README.md`/`readme.md`), 0 per la mia lane; i 7 gemelli marcati restano come path. Il calo dei link rotti (313 a 275) e' in parte dell'altra sessione: il mio lavoro non ha toccato link. Controprova degli zeri: marker con `rg -P` e `/bin/grep -E`; nomi datati con una regex indipendente (`find | grep -E`); 0 byte con `find -size 0` (305 nei due metodi).

## Decisioni
- Stessa regola di Lang e Cms: canonico minuscolo, gemello superseded, cancellazione solo con zero riferimenti.
- Non ho toccato `INDEX.md`, `index.md`, `readme-legacy-snapshot.md` e le cancellazioni dell'altra sessione.

## Aperto
- **Due indici che si dichiarano canonici**: `00-INDEX.md` (contratto docs e ordine dell'utente) e `INDEX.md` non tracciato con `status: canonical`. Va deciso quale resta; l'altro deve rimandare.
- **Coppie divergenti** (decisione dell'owner): `bmad/00-index.md` (9.9 KB) contro `bmad/00-INDEX.md` (3.5 KB); `wiki/00-index.md` contro `wiki/00-INDEX.md`; `wiki/agents.md` contro `wiki/AGENTS.md`; `wiki/INDEX.md` contro `wiki/index.md`.
- **305 `.md` di 0 byte**: un file vuoto non e' documentazione ma e' tracciato e a volte referenziato (`filament/ListRecords.md` e `filament/listrecords.md` sono entrambi vuoti). Serve la decisione sul destino prima di cancellarli (regola: zero riferimenti, due metodi).
- **Radice di `docs/`**: restano 223 `.md`. Nessuno strumento del repo sposta file tra cartelle riscrivendo i riferimenti.
- **Link rotti**: la riparazione e' dello strumento in lavorazione in un'altra sessione; qui nessun `--fix`.
