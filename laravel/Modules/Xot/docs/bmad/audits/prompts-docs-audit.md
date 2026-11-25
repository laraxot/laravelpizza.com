---
id: prompts-docs-audit-2026-11-16
title: Audit documentale profondo — bashscripts/docs/prompts e governance docs
type: audit
module: Xot
status: done
created: 2026-11-16
qmd: "audit prompt bashscripts docs prompts duplicati stale indici governance markdown"
related:
  - ../stories/docs-prompts-reorganization.story.md
---

# Audit documentale: prompts, docs trasversali, memorie

Audit di sola lettura eseguito il 2026-11-16 su `bashscripts/docs/prompts/`,
`bashscripts/docs/`, `.agents/` (= symlink a `bashscripts/ai/.agents/`),
`docs/wiki/` e `bashscripts/ai/wiki/memories/`. Nessun file esistente
modificato. Caveat metodologico: repo `_bases/base_ptvx_fila5` (base
modulare); link che puntano a moduli/temi non presenti nella base possono
essere falsi positivi.

## 1. Inventario `bashscripts/docs/prompts/`

- **167 file `.md`** + 2 script (`start-enhanced.sh`,
  `swarm-execution.sh`) + 2 directory (`studied/`, `swarm-results/`) +
  2 story BMAD dentro la cartella (`prompts-audit.story.md`,
  `prompts-review.story.md`).
- **Front matter**: tutti i 167 iniziano con `---`; 166/167 hanno `qmd:` e
  `title:`. Unico `title:` mancante: `03-quality-gates.md`. Stati
  fuori tassonomia ma semanticamente ok: `completed`
  (`audit-professionale.md`), `historical` (`continue-tomorrow.md`,
  `docs2.md`, `docs3.md`, `welcome.md`).
- **Nomi**: nessuna violazione nella cartella (tutto kebab-case minuscolo;
  `README.md` eccezione legittima). Nessuna data/timestamp nei nomi.
- **Numerazione collidente** (stesso prefisso, scope diverso): `01` x2,
  `04` x3 (`04-`, `04b-`, `04-datas-`), `05` x2, `06` x3, `07` x2, `08` x2,
  `09` x2, `10` x3, `11` x2, `15` x2, `16` x2, `17` x3, `18` x2, `19` x2,
  `20` x2, `57` x2. Gap: `31`, `40`, `41`, `49` assenti.
- **Coppie stesso scope, numero diverso**: `01-confidence-bootstrap` ↔
  `27-confidence-bootstrap`; `05-livewire-to-filament-widgets` ↔
  `28-livewire-to-filament-widgets`; `06-testing-standards` ↔
  `29-testing-standards`; `07-documentation-standards` ↔
  `30-documentation-standards`; `16-git`/`17-git` ↔
  `16-git-forward-only`; `17-gitmodules-sync` ↔ `48-gitmodules-sync`.
- **Alias/redirect**: pattern maturo (`document_type: alias`,
  `canonical:`, `superseded_by:`) — es. `collision-current.md` (19 righe,
  redirect a `51-`), `phpstan-all.md` (41 righe, stub superseded →
  `11-phpstan.md`), `continue-tomorrow.md` (→ `54-`). Funziona, ma gli
  alias non sono elencati nell'indice (vedi §4).

## 2. Duplicazione (similarity Jaccard su body senza front matter)

Coppie più simili (>0.45; nessun duplicato esatto per md5):

| Score | File A | File B | Nota |
|-------|--------|--------|------|
| 0.89 | `02-controller-to-folio-actions.md` | `04b-controller-to-folio-actions.md` | quasi identici |
| 0.80 | `filament-structure-rules.md` | `structure.md` | |
| 0.72 | `30-documentation-standards.md` | `07-documentation-standards.md` | |
| 0.69 | `docs2.md` | `docs1.md` | varianti docs* |
| 0.64 | `10-pest-xot-base-test.md` | `08-playwright-ui.md` | probabilmente boilerplate comune |
| 0.62 | `05-livewire-to-filament-widgets.md` | `05-widget.md` | 1600 righe ciascuno |
| 0.59 | `01-confidence-bootstrap.md` | `27-confidence-bootstrap.md` | stesso scope |
| 0.51 | `16-git.md` | `16-git-forward-only.md` | |

Cluster di varianti sullo stesso tema:

- **PHPStan**: 7 file — `phpstan.md` (2021 righe), `phpstan1.md` (1781),
  `phpstan-old.md` (572), `phpstan-all.md` (stub), `phpstan-module.md`
  (281), `phpstan-module-analysis.md` (93), `changelog-phpstan1.md`
  (222). Il canonico dichiarato è `11-phpstan.md`.
- **Docs**: 5 file — `docs.md` (573), `docs1.md` (869), `docs2.md` (893),
  `docs3.md` (501), `docs4.md` (394) ≈ 3200 righe complessive.
- **Daily report**: `daily-report.md` (930), `98-daily-report.md` (792),
  `daily-report-v2-extended.md` (329).
- **Git/conflitti**: 9 file (`16-git`, `17-git`, `16-git-forward-only`,
  `17-gitmodules-sync`, `48-gitmodules-sync`,
  `17-gitmodules-path-iteration`, `51-conflitti-git-current-change`,
  `collision`, `collision-current`).
- **Filament**: 7 file (`04-filament`, `06-filament`, `06-filament-audit`
  1324 righe, `filament-rules` 1188, `filament-class` 686,
  `filament-structure-rules`, `filament-5-nested-resources`).

## 3. Stale (campione verificato su file esistenti)

| File | Riferimento | Esito |
|------|-------------|-------|
| `prompt.md`, `bugfix.md`, `phpstan1.md`, `docs2.md` | `.cursor/memories` | **inesistente** nel repo |
| `prompt.md`, `bugfix.md`, `docs2.md` | `.cursor/rules` | esiste ma quasi vuoto: 1 solo `.mdc`, creato il 2026-11-16 17:20 (lavoro parallelo in corso); le 26 rule canoniche stanno in `bashscripts/ai/.cursor/rules/` |
| `spatie.md`, `prompt.md` | `app/Datas` | `laravel/app/Datas` **inesistente** |
| `phpstan1.md`, `prompt.md`, `bugfix.md` | `Modules\Xot\Providers\XotBaseServiceProvider` | path errato: reale è `laravel/Modules/Xot/app/Providers/XotBaseServiceProvider.php` |
| `phpstan1.md`, `prompt.md` | `Modules\Xot\Filament\Resources\Pages\XotBase*` | directory inesistente |
| `phpstan1.md`, `prompt.md`, `bugfix.md` | path con backslash Windows (`Modules\*\...`) | non risolvibili su Linux |
| `passport.md` | `laravel/passport` | package in vendor, path ambiguo |
| `theme.md` | `laravel/Themes/<ThemeName>/...`, `laravel/config/<tenant>/...` | placeholder + struttura config da verificare |
| `00-start.md` | `laravel/Modules/<M>/docs/bmad/stories/` | path reale è `docs/bmad/stories/` (ok) ma forme analoghe da ricontrollare |

Placeholder `{ModuleName}`/`<T>` in `docs1/2`, `test.md`, `coverage.md`,
`md.md`: trattabili come template, non errori.

## 4. Ownership e indici

- `index.md` (24 KB, `updated: 2026-11-16`, dichiara "elenco di **tutti** i
  prompt") + `README.md` (24 KB, mappa per dominio). Ruoli distinti e
  dichiarati — coerente.
- **55/167 file non referenziati** da `index.md`+`README.md`. La maggior
  parte è `superseded`/`historical`/`archived` (coerente con la policy
  "mai cancellare"), MA **~20 prompt con status `active`/`stable`/`review`
  risultano senza entry**: `action.md`, `bugfix.md`, `debugbar-rule.md`,
  `filament-5-nested-resources.md`, `filament-rules.md`,
  `global-context.md`, `init.md`, `jpgraph-guide.md`, `llm-wiki.md`,
  `llm-wiki-full.md`, `manifest.md`, `mcp.md`(superseded, ok),
  `module-analysis-3.md` (review), `passport.md`, `prompt-template.md`,
  `roadmap.md`, `sentry.md`, `spatie.md`, `theme.md`, `ui-ux.md`,
  `versioning.md`, `webmozarts-assert-rules.md`. L'indice non è completo
  vs la propria dichiarazione.
- **14 link rotti** nei due indici, quasi tutti con nome underscore o
  maiuscolo (`start_optimized.md`, `notify-module-context.md`,
  `nested_resources_tenancy_charts.md`, `vite_asset_troubleshooting.md`,
  `super_mucca.md`, `filament-class.md`, `phpstan_module.md`,
  `jpgraph_tenancy_integration.md`, `notify-continuation.md`,
  `97-YAML-FRONTMATTER-CONVENTION.md`, `BMAD_PROMPT.md`, `INDEX.md`,
  `llm-wiki.txt`, `studied/`): indizio di rename kebab-case non
  propagato agli indici.

## 5. Docs trasversali

- `.agents` è **symlink** → `bashscripts/ai/.agents`: un solo albero, non
  una duplicazione.
- **P0 — marker di conflitto git committati**: 106 file con
  `<<<<<<<`/`>>>>>>>` non risolti (nessun merge in corso). Localizzati:
  `bashscripts/ai/wiki/rules/11-forms/` (20 file, **incluso
  `00-TRIGGER_MAP.md`**, il router delle regole), `.agents/` e
  `bashscripts/ai/.agents/` (CLAUDE.md con 2 blocchi, index-3.md,
  methodologies.md, git-workflow.md, ~40 file in docs/guidelines/
  memories/helpers/templates), `bashscripts/ai/wiki/rules/migrated-from-agents/`
  (2), `.ai/`, `.ai-context/`. I prompt in `bashscripts/docs/prompts/`
  sono puliti (0 marker) — coerente con la story
  `docs-prompts-reorganization` ("i prompt hanno ora zero blocchi").
  Esiste memoria `merge-remote-repo-2-reinjects-conflict-markers.md`:
  problema noto e ricorrente.
- **`.agents/docs/`**: 282 `.md`; 37 con maiuscole/underscore
  (`00-INDEX.md`, `GITHUB_ISSUES_WORKFLOW.md`,
  `MODULAR_DOCUMENTATION_REFACTORING.md`, `REFACTOR-SUMMARY.md`, …)
  contro la convenzione kebab-minuscolo. Indici frammentati: `INDEX.md`,
  `index.md`, `README.md` e `00-INDEX.md` ripetuti in ~20 sottodirectory.
  **Campione 80 file: 122/275 link interni rotti (44%)** — molti puntano
  a `bashscripts/ai/.agents/...` con path relativi errati o a directory
  spostate.
- **`docs/wiki/`**: 52 file + `00-INDEX.md`. Check completo link:
  6845/10615 rotti, ma la stragrande maggioranza sono `*-census.md` che
  puntano a `../../laravel/Modules/<Mod>/docs/wiki/concepts/...` di
  moduli assenti o privi di quel concetto nella base — da trattare come
  not-a-bug parziale; da riverificare modulo per modulo.
- **`bashscripts/docs/` root**: 48 `.md`, **38 senza front matter**,
  10 con nome non conforme (`conflict_resolution_summary.md`,
  `phpstan_errors_corrections.md`, `second-brain-2026-09-11.md`,
  `employee_timbrature_implementation.md`, `rector-*`…). 44/48 non
  referenziati da `index.md`: report one-off ( Rector, merge conflict,
  audit) mai archiviati in `superseded/` (che contiene 1 solo file).

## 6. Memorie / standing order

- `bashscripts/ai/wiki/memories/`: **687 file** (`.md`+`.mdc`).
  `index-3.md` ne referenzia solo 4: indice di fatto inutile, coerente
  con la regola on-demand (recupero via `qmd`) ma da segnalare.
- Violazioni naming: file con data `2026-02-26-*` (5+), maiuscolo
  (`STANDING-ORDER-MAI-DIMENTICARE*.md`, `HASXOTTABLE-*.story.md`,
  `MEMORY.md`), duplicati `.md`+`.mdc` (`model-testing-philosophy*`,
  `testing-priority*`, `bash-permissions-memory.mdc`).
- Coerenza regole: OK sulle regole cardine — esistono e sono `active`
  `pest-scratch-db-clone-order.md`, `public-path-is-public-html.md`,
  `png-signature-cr-stripped-not-lfs-pointer.md` (no-LFS),
  `pest-gate-mandatory-standing-order.md`, `no-tests-on-production.md`.
- **Rischio**: 102 memorie citano `.cursor/rules` — path ora ambiguo
  dopo la creazione di `.cursor/rules/` root (quasi vuoto) mentre le
  canoniche sono in `bashscripts/ai/.cursor/rules/` e
  `bashscripts/ai/wiki/rules/`. Stessa ambiguità in `AGENTS.md` root che
  referenzia `.cursor/rules/bmad-always.mdc`,
  `pest-gate-mandatory.mdc`, `php-array-one-key-per-line.mdc`,
  `data-sacred-no-destructive-db.mdc`, `public-path-public-html.mdc`:
  nessuno di questi file esiste sotto `.cursor/rules/` (trovati in
  `bashscripts/ai/wiki/rules/` e `bashscripts/ai/.agents/rules/`).

## Priorità di consolidamento

1. **P0** — Risolvere i 106 file con marker di conflitto (partire da
   `bashscripts/ai/wiki/rules/11-forms/00-TRIGGER_MAP.md` e
   `../../../../Geo/docs/root-md-files/claude.md`): confronto dei due lati, mai scelta automatica.
   Esiste già la procedura in `51-conflitti-git-current-change.md` e lo
   script `bashscripts/tools/check-conflict-markers.sh`.
2. **P1** — Allineare `.cursor/rules/` root con le canoniche
   (`bashscripts/ai/.cursor/rules/` + `wiki/rules/`) o correggere i
   riferimenti in `AGENTS.md`/memorie: 102 memorie + standing order
   puntano a path ambigui.
3. **P1** — Completare `../../../../Lang/docs/wiki/rules/index-3.md`: aggiungere le ~20 voci
   attive non coperte e correggere i 14 link rotti (rename underscore →
   kebab già avvenuto sui file, non propagato).
4. **P2** — Consolidare i cluster duplicati: `02`/`04b` (0.89),
   `01`/`27`, `05`/`28`, `06`/`29`, `07`/`30`, le 7 varianti `phpstan*`,
   le 5 `docs*`, i 3 `daily-report*`, i 9 git/collision. Ogni cluster:
   un canonico + alias `superseded_by:` (pattern già maturo).
5. **P2** — `.agents/docs/`: deduplicare indici (`INDEX`/`index`/`00-INDEX`),
   correggere i ~44% di link rotti del campione, uniformare i 37 nomi
   non conformi.
6. **P3** — `bashscripts/docs/` root: archiviare i ~40 report one-off
   in `superseded/` o `raw/`, aggiungere front matter dove manca.
7. **P3** — `memories/`: decidere se implementare `INDEX.md` reale o
   dichiararlo solo router QMD; rinominare i file data/maiuscolo e
   mergiare le coppie `.md`/`.mdc`.
8. **Nota** — La story `docs-prompts-reorganization.story.md` (status
   `review`) copre parte dei punti 3-4; questo audit fornisce il
   censimento aggiornato al 2026-11-16 senza sovrascrivere il suo lavoro.
