---
title: "Story: bonifica marker merge residui modulo UI"
type: story
module: UI
epic: quality
status: done
related:
  - ../../../../Xot/docs/bmad/stories/merge-marker-fleet-residue.story.md
updated: 2026-10-23
tags: [docs, ui, bmad]
qmd: "git-status-fleet-merge-markers-ui ui"
---

# git-status-fleet-merge-markers-ui

Bonifica dei marker di merge conflict committati da "laraxot" nel modulo `laravel/Modules/UI`
(`<<<<<<<`, `=======`, `>>>>>>>`, varianti diff3 `||||||||`), secondo la strategia canonica
della story Xot/merge-marker-fleet-residue:

- HEAD pulito → `git checkout HEAD -- file`
- HEAD sporco → restore blob dell'ultimo commit pulito in history
- nessuna versione pulita → MANUAL

Tool: `bashscripts/tools/resolve-merge-markers.sh` (detection: marker fuori dai code fence ```` ``` ````).

## Stato iniziale

- Branch: `dev`, up to date con `laraxot/dev`, worktree pulito (0 dirty, 0 unmerged).
- `.gitattributes`: già pulito, nessun marker (nessuna copia template necessaria).
- Lock: `bashscripts/lock/git-status-fleet-UI.lock` (preso dal fleet orchestrator).

## Risultati

| Metrica | Valore |
|---|---|
| File candidati (grep marker) | 453 |
| restored_head | 0 |
| restored_hist | 438 |
| manual | 0 (2 fallback manuali, vedi sotto) |
| skipped (marker solo dentro fence / file assenti) | 15 |
| File modificati finali (`git status --porcelain`) | 438 |
| Marker residui fuori fence dopo apply | **0** |

## Fallback manuali (pathspec mancante nel commit "pulito")

Lo script ha individuato come "ultimo commit pulito" `7a96868c`, ma in quel commit il path
non esiste (`git show` falliva → blob considerato pulito per errore → `git checkout` con
`error: pathspec did not match`). Risolti a mano cercando il commit pulito più recente in cui
il path esiste davvero:

| File | Commit restore | Nota |
|---|---|---|
| `docs/phpstan-corrections.md` | `3ac71f6d` | Contenuto "Gennaio 2025" del lato theirs già presente in `phpstan-corrections-gennaio.md` / `phpstan-corrections-january.md` → nessuna perdita |
| `docs/components/legacy/full-calendar.md` | `5d04da30` | Blob pulito completo (259 righe) |

Nessun file MANUAL/MANUAL_UNTRACKED irrisolto.

## Verifica campionaria (commits_reverted più alti)

Max `commits_reverted` = 5 (`docs/architecture-patterns.md`); nessun file >5.

- `docs/architecture-patterns.md` (5): unica perdita = 19 righe di link duplicati
  `- **Architecture Overview**` / `- **Index**` (spazzatura di merge). OK.
- `docs/README.md` (4): persa solo riga footer duplicata "Documento generato…". OK.
- `docs/filament/file-upload-component.md` (4): perse righe frontmatter duplicate con
  placeholder `<nome repository>` (lato scartato). OK.

## Esito verifica finale

- Zero marker fuori code fence in tutto il modulo (awk detection identica allo script).
- 438 file modificati nel worktree, **nessun commit eseguito** (da committare a valle del fleet).

## Nota Pest / test

Solo file `docs/*.md` toccati: nessun comportamento di codice modificato → test Pest skippati
per scelta (non pertinenti a bonifica documentale).

## Note operative

- Lo script è terminato con un falso `syntax error` a EOF (file riletto/shifted durante
  l'esecuzione): tutti i 438 apply erano già completati; verificato a posteriori.
- Bug minore del tool segnalato: `blob_has_markers` tratta "path assente nel commit" come
  "pulito" → `git checkout` fallisce con pathspec error. Workaround applicato manualmente.

## Review blocchi divergenti

Seconda passata sul pack `/tmp/review-UI.md` (58 blocchi, 40 file) dopo il merge
`--allow-unrelated-histories` da `laraxot/dev`. Scelta provvisoria "ours" già nel worktree;
valutato caso per caso con le regole canoniche (stub→canonico, kebab/lowercase, contenuto
più curato, union deduplicata, zero marker). Molti file contenevano **entrambe le versioni
concatenate o interleaved** (2-9 copie dello stesso doc): in quei casi tenuta una copia sola.

| File | Blocco | Decisione | Motivo |
|---|---|---|---|
| docs/ARCHITECTURE.md | 1 | ours | theirs = solo marker garbage |
| docs/INDEX.md | 6 | ours | theirs vuoto/markers |
| docs/_archive/readme.md | 1 | union | badge `Laravel 13.x` (repo è Laravel 13) + URL badge coerente |
| docs/_archive/readme.md | 2 | union | idem; header doppio deduplicato |
| docs/_integration/carousel-slider.md | 3 | union | copia con frontmatter completo + 4 link; scartata copia con YAML aperto e meno link |
| docs/_integration/flip-cards.md | 8 | union | contenuto reale su entrambi (header+github theirs, flourish ours) → copia unica |
| docs/_integration/flip-cards.md | 9 | union | 4 copie concatenate → una |
| docs/_integration/page-builder.md | 2 | union | frontmatter chiuso + heading + link; rimosso heading orfano pre-frontmatter |
| docs/architecture-patterns.md | 1 | ours | link lowercase; refs uppercase aggiornate a file kebab esistenti |
| docs/changelog.md | 2 | ours | theirs vuoto |
| docs/cms-link.md | 7 | ours | link `docs/` (nuova convenzione) vs `project_docs/`; seconda copia eliminata |
| docs/cms-themes-link.md | 2 | ours | `../../../../docs/` (root docs) + copia `docs/`; scartata copia `project_docs/` |
| docs/conflict-resolution-locationselector.md | 6 | ours | `../docs/` vs `project_docs/` triplicato |
| docs/filament-components-errors.md | 2 | ours | `../../../../docs/filament/components.md` (root docs); tenuta copia ricca con esempi |
| docs/filament-components-errors.md | 5 | union | regola `Modules/UI/docs/` + item 4 (unione delle due liste) |
| docs/filament-components-location-studio.md | 2 | theirs | `<nome progetto>.` pulito vs `<nome progetto>corrente` artefatto |
| docs/filament-components-location-studio.md | 10 | ours | theirs solo markers |
| docs/filament-components-location-studio.md | 11 | ours | theirs vuoto |
| docs/filament-components-usage.md | 5 | theirs | `Modules/UI/...` = convenzione del file; collassati 6 dup |
| docs/filament-error-fileupload-buttonlabel.md | 5 | ours | `Patient/docs/` vs `project_docs/`; copia2 con URL rotta eliminata |
| docs/flags-components-1.md | 1 | theirs (file eliminato) | variante stale con `SaluteOra` hardcoded, sottoinsieme di flags-components.md |
| docs/flags-components.md | 2 | theirs | `<nome progetto>` pulito vs `corrente`/vuoti; 6 varianti → 1 |
| docs/git-multi-org-sync-handoff.md | 1 | ours | ours include theirs + link concreto |
| docs/iconstatesplitcolumn-actions-implementation.md | 2 | ours | Filament 4.x > 3.x |
| docs/iconstatesplitcolumn-implementation.md | 4 | union | file era ~9 copie interleaved; ricostruito da variante con `<nome progetto>` + Filament 4.x |
| docs/layouts-and-themes.md | 2 | ours | copia ours (docs/, 7-up) tenuta; depth corretta a `../../../../docs/` |
| docs/layouts-and-themes.md | 5 | ours | idem |
| docs/mcp-integration.md | 2 | theirs | `base_ptvx_fila5` = questo repo; rimossa coda doc duplicata (~350 righe) |
| docs/multi-org-sync-laraxot-provtv.md | 2 | ours | theirs vuoto |
| docs/navigation-components.md | 5 | theirs | `lang/{locale}/auth.php` = convenzione file |
| docs/optimization-recommendations.md | 1 | ours | union level10+Level9 già presente |
| docs/optimization-recommendations.md | 7 | ours | `per <nome progetto>` + rimossa riga troncata `per` |
| docs/optimization-recommendations.md | 10 | ours | union level10+Level9 |
| docs/paths-and-assets-1.md | 6 | file eliminato | variante stale `saluteora` di paths-and-assets.md |
| docs/paths-and-assets-1.md | 7 | file eliminato | idem |
| docs/paths-and-assets-1.md | 8 | file eliminato | idem |
| docs/paths-and-assets-1.md | 10 | file eliminato | idem |
| docs/paths-and-assets.md | 7 | ours | righe tabella `[project-root]` reintegrate nella copia tenuta (file era 3 copie) |
| docs/paths-and-assets.md | 12 | theirs | `Modules/UI/...` relativo vs path assoluto macchina `/var/www/html/ptvx` |
| docs/philosophy-dev-rules.md | 1 | union | `architecture.md` + `testing.md` (`root-md-files/` inesistente) |
| docs/philosophy.md | 3 | union | variante "Predictable" (coerente col doc, forma maggioritaria) |
| docs/project-structure.md | 1 | ours | lowercase `architecture.md` |
| docs/root-md-files/changelog.md | 3 | ours | file non presente in worktree (contenuto in `raw/root-import/changelog.md`) |
| docs/root-md-files/philosophy.md | 1 | ours | file non presente in worktree |
| docs/spatie-media-library-migration-1.md | 4 | file eliminato | variante stale `saluteora`+Filament 3.x di spatie-media-library-migration.md |
| docs/spatie-media-library-migration-1.md | 7 | file eliminato | idem |
| docs/spatie-media-library-migration.md | 2 | ours | theirs vuoto |
| docs/spatie-media-library-migration.md | 14 | ours | `BaseModel <nome progetto>` vs theirs placeholder perso; rimossi frammenti tronchi `odel` |
| docs/spatie-media-library-migration.md | 47 | theirs | `Modules/{ModuleName}` = placeholder corretto in posizione modulo |
| docs/spatie-media-library-migration.md | 62 | theirs | idem |
| docs/spatie-media-library-migration.md | 80 | theirs | idem |
| docs/standards/auth-form-standards.md | 5 | union | link `./form-standards.md` (kebab esistente); copia2 compressa eliminata |
| docs/stories/01.UI-phpstan-fix.story.md | 1 | theirs | titolo theirs già nel worktree (più recente) |
| docs/stories/01.UI-phpstan-fix.story.md | 2 | theirs | `updated: 2026-09-23` > entrambe le date |
| docs/wiki/agents.md | 3 | ours | stub canonico mantenuto; **nota**: target canonico `Themes/docs/shared-components/AGENTS-Modules.md` assente nel worktree |
| docs/wiki/concepts/xotbase-inheritance-audit.md | 1 | ours | union generico+concreto già presente |
| docs/wiki/how-to/gitmodules-sync-session.md | 1 | ours | union già presente |
| docs/wiki/log.md | 8 | ours | theirs vuoto |

**Conteggio** (58 blocchi): ours 29 · theirs 11 · union 11 · file eliminato (stale dup) 7
(3 file: `flags-components-1.md`, `paths-and-assets-1.md`, `spatie-media-library-migration-1.md`).

### File fuori pack con marker reali (bonificati per arrivare a zero marker)

| File | Esito | Motivo |
|---|---|---|
| docs/svg-icons-automatic-registration.md | risolto in place | union URL commenti; droppato `fixcity.local` stale |
| docs/brands-icons-integration.md | risolto in place | idem |
| docs/blade-data-handling-1.md | risolto in place | blocco blank-vs-whitespace |
| docs/file-naming-rules.md | risolto (ours) | `CHANGELOG.md` coerente con la regola del doc stesso |
| docs/filosofia-modulo-ui.md | risolto (ours ×2) | `modulo operativo` generico vs `TechPlanner` stale |
| docs/testing.md | risolto (union) | `<nome progetto>_data_test`: entrambi i lati stale (`quaeris`/`modulo questionari` rotto) |
| docs/wiki/context-compression.md | risolto (union) | `<nome progetto>-docs` + `project-docs`; droppato `fixcity` |
| docs/wiki/schema.md | risolto | solo `schema.md` nel tree (il doc stesso dichiara SCHEMA.md duplicato) |
| docs/SVG_ICONS_AUTOMATIC_REGISTRATION.md | eliminato | dup UPPERCASE del file kebab (contenuto identico) |
| docs/BRANDS_ICONS_INTEGRATION.md | eliminato | dup UPPERCASE di brands-icons-integration.md |
| docs/architecture_rules.md | eliminato | sottoinsieme snake di architecture-rules.md (0 righe uniche) |
| docs/form_filament_widgets.md | eliminato | sottoinsieme snake di form-filament-widgets.md |
| docs/vscode_php_setup.md | eliminato | sottoinsieme snake di vscode-php-setup.md |
| docs/bugfix-table-layout-action-.md | eliminato | dup artifact; uniche righe = curl stale, canonico ha `<nome progetto>` |
| docs/bugfix-table-layout-action-conflict.md | eliminato | idem |

### Altri duplicati stale eliminati (convenzione kebab, canonico presente)

`blade-data-handling.md`, `_integration/{carousel_slider,custom_firm_fields,custom_theme,
flip_cards,page_builder,tailwind_themes}.md`, `standards/{form_standards,auth_form_standards}.md`,
`svg_icons_automatic_registration.md`, `DESIGN_COMUNI_IMPLEMENTATION.md`,
`_archive/{svg_icons_automatic_registration,brands_icons_integration}.md`,
`paths_and_assets.md`, `paths-and-assets_1.md`, `filament_components_usage.md`,
`filament-components-usage_1.md`, `iconstatesplitcolumn{,-actions}-implementation{-1,_1}.md`,
`iconstatesplitcolumn_implementation.md`, `iconstatesplitcolumn_actions_implementation.md`,
`brands_icons_integration.md`, `svg_icons_complete.md`, `SVG_ICONS_COMPLETE.md`,
`brands_icons.md`, `BRANDS_ICONS.md`, `PROJECT-STRUCTURE.md`.

Tutti verificati come sottoinsiemi/duplicati del canonico kebab (0 righe uniche reali o solo
righe stale `saluteora`/`fixcity`/`project_docs`). Refs rotte verso i file eliminati corrette
in `architecture-patterns.md`, `svg-icons-automatic-registration.md`,
`_archive/svg-icons-automatic-registration.md`, `filament-components-usage.md`,
`legacy/filament-components-usage.md`, `roadmap/roadmap.md`, `conflitti_merge_risolti.md`,
`_archive/conflitti_merge_risolti.md`, `_archive/filament_components_usage.md`.

### Esito verifica

- `grep -rn '^<<<<<<<\|^=======$\|^>>>>>>>\|^|||||||'` su `laravel/Modules/UI` → **0 hit**.
- File con menzioni `<<<<<<<` in prosa/backtick (story/doc sui marker): lasciati intatti.
- `PHILOSOPHY.md` (1311 righe, doc diverso e più ricco di `philosophy.md`) **mantenuto**:
  contenuto distinto, non un duplicato: solo naming non conforme (segnalato).
- Debris `ours+theirs` residui (righe duplicate consecutive) restano in ~35 file NON nel pack
  (es. `readme.md`, `frontend.md`, `studio-card-selector-implementation.md`,
  `overview-extended.md`): non toccati, fuori scope del pack: da instradare a batch dedicato.
- `docs/raw/root-import/` contiene varianti `-1` dei doc importati (es. `changelog-1.md`):
  non toccate, area `raw/` dichiarata immutable dal wiki schema.