---
type: note
created: 2026-09-26
updated: 2026-09-26
qmd: "16 2 case variant dirs guard"
issues: []
discussions: []
id: story-162-case-variant-dirs-guard
slug: story-162-case-variant-dirs-guard
title: "STORY-162 — Guard sulle directory case-variant e bonifica Media/tests"
description: "Due directory sorelle che differiscono solo per case producono classi omonime nello stesso namespace PSR-4: PHPStan ne analizza una sola e l'altra degrada in silenzio. Aggiungere il guard e consolidare Media/tests/Feature + feature."
document_type: story
category: bmad
scope: module:Media
status: ready-for-dev
version: 1.0.0
language: it-IT
ecosystem: Laraxot
priority: medium
epic: 16
epic_title: "PHPStan — da stato pulito a gate durevole"
created_at: '2026-08-06'
updated_at: '2026-08-06'
tags: [bmad, story, phpstan, psr4, no-case-variations, media]
related:
  - ../../../../../docs/planning-artifacts/architecture/architecture-phpstan-typesafety-gate.md
  - ../../../../../docs/planning-artifacts/epics/epic-16-phpstan-typesafety-gate.md
  - ../../../../../docs/wiki/rules/no-case-variations.md
github:
  repository: https://github.com/laraxot/module_media_fila5
  issues: https://github.com/laraxot/module_media_fila5/issues
  discussions: https://github.com/laraxot/module_media_fila5/discussions
---

# STORY-162 — Guard sulle directory case-variant e bonifica `Media/tests`

Status: `ready-for-dev` · Scope: `module:Media` · Epic: 16

## Story

As a **manutentore**,
I want **che due directory sorelle che differiscono solo per case facciano
fallire la build**,
so that **nessuna porzione di codice resti fuori dall'analisi statica senza
che nessuno lo sappia**.

## Perche' non e' una pulizia cosmetica

Su filesystem case-sensitive, `Factories/` e `factories/` sono due directory
reali distinte. Se entrambe contengono classi con lo stesso namespace PSR-4 e
lo stesso nome, autoloader e PHPStan ne risolvono **una sola**. L'altra non
viene mai analizzata.

Prova raccolta il 2026-08-06 in `Modules/Cms/database/`:

- `Factories/` e `factories/` con 8 classi omonime
- 6 coppie su 8 con contenuto **divergente**
- nella copia non analizzata sopravviveva `$faker->boolean(80)` — variabile
  non definita, errore fatale a runtime — con PHPStan a zero errori

Il caso Cms e' stato consolidato durante quella sessione. Ne resta uno:

```
laravel/Modules/Media/tests/Feature
laravel/Modules/Media/tests/feature
```

## Acceptance Criteria

### Parte 1 — il guard

- [ ] Esiste `bashscripts/tools/check-case-variant-dirs.sh`
- [ ] Cerca sotto `laravel/Modules` e `laravel/Themes` le directory sorelle
      (stesso genitore) i cui nomi coincidono a meno del case
- [ ] Esce con codice diverso da zero elencando **ogni** coppia trovata, con
      path completo di entrambe
- [ ] Esclude `vendor`, `node_modules`, `.git`
- [ ] Segue le convenzioni degli altri guard in `bashscripts/tools/`
      (`set -uo pipefail`, `cd` relativo a `BASH_SOURCE`, commento iniziale con
      motivazione e riferimento alla regola canonica)
- [ ] E' invocato dal workflow della Story 16.1

### Parte 2 — la bonifica

- [ ] `Modules/Media/tests/feature` e `Modules/Media/tests/Feature` sono
      consolidate in una sola directory
- [ ] Il consolidamento **confronta file per file prima di unire**: le coppie
      omonime possono essere divergenti, non si assume che una sia copia
      dell'altra
- [ ] `./vendor/bin/phpstan analyse` resta `[OK] No errors`
- [ ] Il numero di file analizzati **non cala oltre i file effettivamente
      rimossi**: il conteggio va annotato prima e dopo

## Il controllo che conta davvero

Il conteggio dei file analizzati e' l'unico segnale che distingue
"analisi pulita" da "analisi muta". Un calo inatteso dopo il consolidamento
significa che si e' rimosso codice ancora referenziato, non che si e' pulito.

```bash
cd laravel && ./vendor/bin/phpstan analyse 2>&1 | grep -E '[0-9]+/[0-9]+'
```

Riferimento: 8037 file al 2026-08-06.

## Direzione del consolidamento

PSR-4 e la convenzione Laravel per le directory dei test vogliono
`tests/Feature` (PascalCase). La directory da eliminare e' quindi la
lowercase — **dopo** aver verificato che ogni suo file sia gia' presente e
identico in `Feature/`, o averlo spostato se manca o diverge.

Nota: `Modules/Media/tests/feature/MediaBusinessLogicTest.php` e' stato
modificato il 2026-08-06 (sostituzione dei cast `(int)` con
`SafeIntCastAction::cast()`). Se `Feature/` contiene un omonimo, e' quasi
certo che sia la versione **vecchia**: il confronto va fatto sul contenuto,
non sulla data.

## Regola canonica

`docs/wiki/rules/no-case-variations.md`

## GitHub (tracciamento)

Repository letto da frontmatter `github.repository` o `git remote -v` (se assente: repo root **`laraxot/base_quaeris_fila5`**): **`laraxot/module_media_fila5`**.

| Risorsa | Stato | Link |
|---|---|---|
| Issue | **DA CREARE** | https://github.com/laraxot/module_media_fila5/issues |
| Discussion | **DA CREARE** | https://github.com/laraxot/module_media_fila5/discussions |

Il numero non e' scritto perche' non esiste ancora: `gh` non e' autenticato in questa sessione e i repo sono privati. Appena disponibile, creare con:

```bash
gh issue create --repo laraxot/module_media_fila5 \
  --title "STORY-162 — Guard sulle directory case-variant e bonifica Media/tests" --body-file 16-2-case-variant-dirs-guard.md
gh api repos/laraxot/module_media_fila5/discussions -f title="STORY-162 — Guard sulle directory case-variant e bonifica Media/tests" -f body="vedi la story"
```
