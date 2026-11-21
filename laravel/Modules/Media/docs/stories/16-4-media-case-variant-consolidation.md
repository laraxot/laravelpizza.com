---
type: note
created: 2026-09-26
updated: 2026-09-26
qmd: "16 4 media case variant consolidation"
issues: []
discussions: []
id: story-164-media-case-variant-consolidation
slug: story-164-media-case-variant-consolidation
title: "STORY-164 — Consolidamento delle coppie case-variant nel modulo Media"
description: "Tre coppie di directory case-variant in Media producono due test con lo stesso FQCN di cui uno solo viene eseguito, e due generatori di conversione duplicati. Consolidare confrontando il contenuto, non le date."
document_type: story
category: bmad
scope: module:Media
status: ready-for-dev
version: 1.0.0
language: it-IT
ecosystem: Laraxot
priority: high
epic: 16
epic_title: "PHPStan — da stato pulito a gate durevole"
blocks: [16.2]
created_at: '2026-08-06'
updated_at: '2026-08-06'
tags: [bmad, story, psr4, no-case-variations, media, pest]
related:
  - ../../../../../docs/planning-artifacts/architecture/architecture-phpstan-typesafety-gate.md
  - ../../../../../docs/planning-artifacts/epics/epic-16-phpstan-typesafety-gate.md
  - ../../../../../docs/stories/16-2-case-variant-dirs-guard.md
github:
  repository: https://github.com/laraxot/module_media_fila5
  issues: https://github.com/laraxot/module_media_fila5/issues
  discussions: https://github.com/laraxot/module_media_fila5/discussions
---

# STORY-164 — Consolidamento delle coppie case-variant in Media

Status: `ready-for-dev` · Scope: `module:Media` · Epic: 16
Blocca: 16.2 (il guard non puo' entrare finche' Media e' rosso)

## Story

As a **sviluppatore che esegue la suite Media**,
I want **una sola directory per ogni nome**,
so that **il test che leggo sia quello che gira davvero**.

## Il danno, misurato

```bash
ls -la laravel/Modules/Media/tests/feature laravel/Modules/Media/tests/Feature
```

| Coppia | Contenuto | Esito |
|--------|-----------|-------|
| `tests/feature` + `tests/Feature` | `MediaBusinessLogicTest.php` — 16504 vs 16510 byte | **divergenti** |
| `tests/filament` + `tests/Filament` | `resources/` vs `Resources/` (a loro volta case-variant) | da ispezionare |
| `app/conversions` + `app/Conversions` | `imagegenerators`/`videogenerators` vs `ImageGenerators`; `PowerPoint.php`, `Webm.php` | **divergenti** |

## Perche' non basta cancellarne una

I due `MediaBusinessLogicTest.php` **non sono lo stesso test in due copie**:

| | `tests/feature/` | `tests/Feature/` |
|---|---|---|
| Framework asserzioni | `expect()` di Pest | `PHPUnit\Framework\Assert` |
| Cast dei valori | `SafeIntCastAction::cast()` | helper locale `mediaIntegerish()` |

Sono **due test diversi con lo stesso nome pienamente qualificato**
(`Modules\Media\Tests\Feature\MediaBusinessLogicTest`). PHPStan li analizza
entrambi e resta verde. L'autoloader ne carica uno solo: l'altro non e' mai
stato eseguito, quindi non c'e' alcuna garanzia che passi.

Scegliere per data e' l'errore da non fare. La copia in `tests/feature/` e'
piu' recente (2026-08-06 21:39) perche' e' stata modificata durante la
sessione di fix PHPStan — non perche' sia la versione buona.

## Acceptance Criteria

- [ ] Per ognuna delle tre coppie resta **una sola** directory, con nome
      PascalCase (`Feature`, `Filament`, `Conversions`) secondo PSR-4 e la
      convenzione Laravel
- [ ] Il contenuto conservato e' scelto **leggendo i due file**, non per data
      ne' per dimensione, e la scelta e' motivata in una riga nel commit
- [ ] Se i due test coprono casi diversi, i casi mancanti sono **portati** nel
      file conservato invece che persi
- [ ] Il test conservato **viene eseguito e passa**:
      `cd laravel && ./vendor/bin/pest --filter=MediaBusinessLogic`
- [ ] `./vendor/bin/phpstan analyse` resta a 0 errori
- [ ] Il conteggio dei file analizzati cala **esattamente** del numero di file
      rimossi, non di piu'
- [ ] `tests/filament/resources` + `tests/Filament/Resources` sono risolte
      anche al livello annidato

## Il controllo che conta

Il test conservato non e' mai stato eseguito nella sua variante non caricata.
Il criterio "PHPStan resta verde" **non e' sufficiente**: PHPStan era verde
anche prima, con entrambe le copie. L'unica prova che il consolidamento non ha
rotto niente e' eseguire Pest.

Vincolo di progetto sui test: mai `RefreshDatabase`, mai `migrate:fresh`,
isolamento con `DatabaseTransactions` sulle repliche MySQL `*_test`. Vedi
`docs/wiki/rules/data-sacred-no-destructive-db.md`.

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
  --title "STORY-164 — Consolidamento delle coppie case-variant nel modulo Media" --body-file 16-4-media-case-variant-consolidation.md
gh api repos/laraxot/module_media_fila5/discussions -f title="STORY-164 — Consolidamento delle coppie case-variant nel modulo Media" -f body="vedi la story"
```
