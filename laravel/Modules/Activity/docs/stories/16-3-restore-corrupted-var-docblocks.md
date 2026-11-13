---
id: story-163-restore-corrupted-var-docblocks
slug: story-163-restore-corrupted-var-docblocks
title: "STORY-163 — Ripristino dei docblock @var corrotti da merge nei modelli Activity"
description: "Tre modelli Activity hanno un path di documentazione al posto del tag @var. Il docblock e' sintatticamente valido e semanticamente vuoto: nessun gate lo intercetta, l'annotazione di tipo e' sparita in silenzio."
document_type: story
category: bmad
scope: module:Activity
status: ready-for-dev
version: 1.0.0
language: it-IT
ecosystem: Laraxot
priority: medium
epic: 16
epic_title: "PHPStan — da stato pulito a gate durevole"
created_at: '2026-08-06'
updated_at: '2026-08-06'
tags: [bmad, story, phpstan, docblock, merge-damage, activity]
related:
  - ../../../../../docs/planning-artifacts/architecture/architecture-phpstan-typesafety-gate.md
  - ../../../../../docs/planning-artifacts/epics/epic-16-phpstan-typesafety-gate.md
github:
  repository: https://github.com/laraxot/module_activity_fila5
  issues: https://github.com/laraxot/module_activity_fila5/issues
  discussions: https://github.com/laraxot/module_activity_fila5/discussions
---

# STORY-163 — Ripristino dei docblock `@var` corrotti da merge

Status: `ready-for-dev` · Scope: `module:Activity` · Epic: 16

## Story

As a **sviluppatore che legge i modelli Activity**,
I want **che i docblock dichiarino di nuovo il tipo della proprieta'**,
so that **l'annotazione persa in un merge non resti persa in silenzio**.

## Il danno, misurato

```bash
grep -rn '/\*\* @laravel/' --include=*.php laravel/Modules/ laravel/Themes/
```

Tre occorrenze, tutte in `Modules/Activity/app/Models/`:

| File | Riga | Contenuto attuale | Tag atteso |
|------|------|-------------------|------------|
| `StoredEvent.php` | 31 | `/** @laravel/Modules/UI/docs/bugfix-awstest-undefined-variable.md string */` | `/** @var string */` |
| `Snapshot.php` | 45 | `/** @laravel/Modules/UI/docs/bugfix-awstest-undefined-variable.md string */` | `/** @var string */` |
| `BaseModel.php` | 22 | `/** @laravel/Modules/UI/docs/bugfix-awstest-undefined-variable.md string\|null */` | `/** @var string\|null */` |

Un path di documentazione e' finito al posto del nome del tag. Il tipo
(`string`, `string|null`) e' rimasto: si e' perso solo il `@var`.

## Perche' nessun gate lo prende

Il docblock e' **sintatticamente valido**. `@laravel/...` viene letto come un
tag sconosciuto, quindi ignorato. PHPStan non segnala niente: per lui la
proprieta' semplicemente non ha annotazione.

Non lo prende nemmeno `check-conflict-markers.sh`: non ci sono marcatori
`<<<<<<<`. Il grep sui marcatori intercetta solo i conflitti non risolti,
non i conflitti risolti male.

Questa e' la terza categoria di danno da merge descritta
nell'architettura (AD-3): quella per cui **non esiste rete**. La story la
chiude a mano e lascia documentata la firma dell'anti-pattern per il futuro.

## Acceptance Criteria

- [ ] I tre docblock sono ripristinati al tag corretto della tabella sopra
- [ ] Il **tipo** dichiarato non viene cambiato: `BaseModel.php` resta
      `string|null`, gli altri due `string`
- [ ] `cd laravel && ./vendor/bin/phpstan analyse` -> `[OK] No errors`
- [ ] Il conteggio dei file analizzati resta 8037 (nessun file rimosso)
- [ ] `grep -rn '/\*\* @laravel/' --include=*.php laravel/Modules/ laravel/Themes/`
      non restituisce nulla
- [ ] Una ricerca piu' larga dell'anti-pattern (docblock che apre con `@`
      seguito da un path terminante in `.md`) non trova altre occorrenze; se
      ne trova, sono **elencate** in questa story invece che corrette in
      silenzio

## Perche' l'ultimo criterio non e' pignoleria

Il tag originale non e' sempre `@var`. Lo stesso incidente di merge puo' aver
mangiato `@param`, `@return`, `@property`. Correggere tutto a `@var` per
analogia introdurrebbe annotazioni sbagliate al posto di annotazioni assenti —
peggio dello stato attuale, perche' PHPStan si fiderebbe.

Ogni occorrenza trovata fuori dai tre file noti va valutata leggendo cosa
annota.

## Nota sull'origine

Il path che compare nei tre docblock —
`laravel/Modules/UI/docs/bugfix-awstest-undefined-variable.md` — appartiene al
modulo UI, non ad Activity. E' un indizio che il danno sia arrivato da un
merge che mescolava modifiche a documentazione e a codice. Vale la pena
verificare se altri moduli toccati dallo stesso merge presentano danni
analoghi non ancora emersi.

## GitHub (tracciamento)

Repository letto da frontmatter `github.repository` o `git remote -v` (se assente: repo root **`laraxot/base_quaeris_fila5`**): **`laraxot/module_activity_fila5`**.

| Risorsa | Stato | Link |
|---|---|---|
| Issue | **DA CREARE** | https://github.com/laraxot/module_activity_fila5/issues |
| Discussion | **DA CREARE** | https://github.com/laraxot/module_activity_fila5/discussions |

Il numero non e' scritto perche' non esiste ancora: `gh` non e' autenticato in questa sessione e i repo sono privati. Appena disponibile, creare con:

```bash
gh issue create --repo laraxot/module_activity_fila5 \
  --title "STORY-163 — Ripristino dei docblock @var corrotti da merge nei modelli Activity" --body-file 16-3-restore-corrupted-var-docblocks.md
gh api repos/laraxot/module_activity_fila5/discussions -f title="STORY-163 — Ripristino dei docblock @var corrotti da merge nei modelli Activity" -f body="vedi la story"
```
