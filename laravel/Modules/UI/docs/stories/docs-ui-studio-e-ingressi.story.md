---
title: "UI: studio del modulo e riordino degli ingressi docs"
type: story
status: done
created: 2026-10-14
updated: 2026-10-14
module: UI
tags: [docs, organizzazione, ui, bmad, link]
related: [bmad-output/stories/docs-organization/README.md, bmad-output/docs-architecture/module-theme-docs-contract.md, laravel/Modules/Fixcity/docs/stories/dcp-56-organizzazione-docs-moduli-e-temi.story.md]
qmd: "ui docs studio ingressi readme 00-INDEX architecture verifica link rotti pest phpstan"
---

# UI: studio del modulo e riordino degli ingressi docs

Fase BMAD: documentazione e qualita' (DOC-010 e DOC-002 del piano `bmad-output/stories/docs-organization/`).

## Richiesta

Studiare il codice di `laravel/Modules/UI`, confrontarlo con `docs/` e correggere gli ingressi con soli fatti verificati. Misure di
partenza dell'audit: 294 file `.md`, 96% dei link rotti, nessun `index.md`.

## Analisi

- Il contratto vuole `00-INDEX.md` come indice canonico: UI lo aveva, ma linkava `schema/` (cartella inesistente alla radice di
  `docs/`). Il `README.md` era un elenco di tre link. Non va creato un `index.md`.
- Il modulo e' un kit di primitive: 17 colonne, 19 campi form, 14 blocchi, 12 widget, 6 Actions, 3 modelli piu' `BaseModel`, nessuna
  Resource CRUD, rotte vuote. Consumato da Activity, Blog, Cms, Media, User, Xot.
- La mappa del codice `bmad/architecture.md` e' la migliore descrizione disponibile ma aveva 7 punti superati (cartella `app/Services`
  inesistente, `resources/lang` inesistente, 15 colonne invece di 17, 11 widget invece di 12, PHPStan e Pest "non eseguiti").
- Link: misurati con `--busy-minutes 0` (con il filtro di default il tool salta i file toccati da meno di 10 minuti e sottostima: 4 eventi
  contro 1522). Cause dei 1522 eventi in 159 file: 1255 file del modulo che non esistono (di cui 891 in `_archive/INDEX.md`, un elenco
  generato che punta a sottocartelle sparite), 122 verso docs di altri moduli o temi (soprattutto `Themes/docs/shared-components/`, che
  non esiste), 84 verso `docs/` della radice del repo, 47 fuori dal modulo, 14 verso directory inesistenti.
- Altri difetti: `bmad/purpose.md` e `wiki/purpose.md` hanno lo stesso corpo; `wiki/log.md` era citato da 3 file e non esisteva;
  `investigation/ui-investigation.md` aveva YAML non valido (`#XXX` non quotato); `bmad/architecture.md` ha la chiave `title` doppia;
  `bmad/stories/schema-org-reusable-components.story.md` contiene marker di merge; `laravel/Modules/UI/README.md` (fuori da `docs/`) ha
  marker di merge non risolti e `ARCHITECTURE.md` e `GETTING_STARTED.md` hanno segnaposto `$MOD`.

## Modifiche (solo in `laravel/Modules/UI/docs/`)

| File | Modifica |
|---|---|
| `00-INDEX.md` | tolto `schema/`; directory classificate (canoniche, evidence, legacy); ingressi duplicati dichiarati; stato misurato |
| `README.md` | da elenco di link a identita', ownership, contenuto con conteggi, quick start, limiti |
| `decision-log.md` | voce 2026-10-14 in testa |
| `wiki/log.md` | nuovo, con la voce del giorno |
| `wiki/purpose.md`, `bmad/architecture.md` | in coda sezione "Verifica del 2026-10-14", testo originale intatto |
| `investigation/ui-investigation.md` | YAML valido e `status: stale` con motivo |

Non toccati: `stories/` altrui, `bmad/` (resto), `wiki/` (resto), `_archive/`, nessun file di codice, nessun `--fix` ne' `--annotate` del tool
(`--annotate` agisce su tutta la cartella e non ha filtro per file: 1522 link in 159 file).

## Verifica

```
phpstan analyse Modules/UI                      exit 0
pest Modules/UI/tests (sqlite :memory:)         Tests: 16 failed, 1 risky, 109 skipped, 218 passed (713 assertions), 99.24s
   falliti: GroupColumnTest (3), OpeningHoursColumnTest (1), GetUserDataActionTest (7), UiBasePolicyBehaviorTest (1),
            UiFilamentComponentsCoverageTest (1), UiGapCloser100Test (1), UiRemainingCoverage100Test (2); cause non indagate
   saltati: 84 per "DB ui (themes/categories) non disponibile"
php artisan module:list                          [Enabled] UI
```

Link non risolti sui file toccati (dry-run, `--by-name`, `--busy-minutes 0`, eventi `unresolved`, prima -> dopo): `00-INDEX.md` 1 -> 0 e
`README.md` 1 -> 0 (entrambi il link a `schema/`); `decision-log.md`, `wiki/log.md`, `wiki/purpose.md`, `bmad/architecture.md`,
`investigation/ui-investigation.md` e questa story 0 -> 0. Totale del perimetro 1522 -> 1518 (2 in meno sono i miei, gli altri 2 vengono da altre
passate nello stesso periodo). I rimanenti 1518 sono in file che non ho toccato.

## Decisioni

- Un solo ingresso: `00-INDEX.md`; gli indici di `wiki/` e `bmad/` restano, dichiarati legacy.
- Le verifiche si aggiungono in coda ai documenti altrui, non si riscrivono le loro righe.
- Nessuna annotazione in massa: serve un filtro per file nel tool prima di usare `--annotate` su 159 file.

## Aperto

1. Cause dei 16 test falliti e dei 109 saltati: serve un database `ui` di scratch.
2. Marker di merge in `laravel/Modules/UI/README.md` e in `docs/bmad/stories/schema-org-reusable-components.story.md`.
3. Riordino dei 4 indici di `wiki/` e dei 4 di `bmad/` (DOC-004).
4. `_archive/INDEX.md`: 891 link a sottocartelle inesistenti, da rigenerare o marcare superseded.
5. Il tool dovrebbe accettare `--file` per `links --annotate`.
