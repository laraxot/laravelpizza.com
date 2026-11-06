---
title: "story 002 scheda contract unification"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "story 002 scheda contract unification"
issues: []
discussions: []
scope: module:Geo
---

# STORY-002: Unificazione SchedaContract e gerarchia BaseScheda

**Epic:** Architecture — Module Inheritance & DRY  
**Priority:** Must Have  
**Story Points:** 8  
**Status:** In Progress (Phase 2 completata 2026-06-15)  
**Sprint:** PHPStan Quality Gate  
**Created:** 2026-06-15 (BMAD `/bmad/create-story`)

---

## User Story

**As a** architetto Laraxot  
**I want** un unico `SchedaContract` e `Progressioni\Scheda extends BaseScheda` con `asz()` ereditata  
**So that** le action Ptv usano `$scheda->asz()->ofRangeDate()` senza duplicare query né contratti paralleli

---

## Brainstorming (discussione con sé stessi)

### Cosa è andato storto

Un agente ha “fixato” PHPStan sostituendo la catena relazione con `Asz00k1::query()->where(matr, ente, aszann)`.  
**Perché è sbagliato:** viola la religione DRY — i filtri vivono in un solo posto (`BaseScheda::asz()`), non nelle action.

### Visione target

```
SchedaContract          ← unico contratto (@method asz per PHPStan)
    ↑ implements
BaseScheda              ← asz() canonica (ente, matr, aszann)
    ↑ extends
Progressioni\Scheda     ← solo override dominio Progressioni
Ptv\Scheda              ← vuota / minima
```

### Perché eliminare ProgressioneSchedaContract

- Duplica `SchedaContract` senza valore aggiunto
- Induce type-hint sbagliati (`SchedaContract` vs `ProgressioneSchedaContract`)
- `Progressioni\Scheda` **già** estende `BaseScheda` → eredita `SchedaContract`

### PHPStan senza bypass

- `SchedaContract`: `@method HasMany<Asz00k1, Model> asz()` (no metodo interface → evita covarianza `HasMany`)
- `BaseScheda::asz()` implementazione con `@return HasMany<Asz00k1, $this>`
- Action: `SchedaContract $scheda` + `$scheda->asz()->ofRangeDate()` → **0 errori**

---

## Acceptance Criteria

### Fatto (2026-06-15)

- [x] `Progressioni\Scheda extends BaseScheda`
- [x] `ProgressioneSchedaContract` **eliminato**
- [x] `asz()` su `BaseScheda` (fonte unica filtri)
- [x] `asz()` rimossa da `ProgressioniRelationshipTrait` (no duplicato)
- [x] `ListaAszTipCodEsclusoSubito` usa `SchedaContract` + `$scheda->asz()->ofRangeDate()`
- [x] PHPStan `Modules` → 0 errori (`memory_limit=2G`)
- [x] Regola cardinale documentata: [eloquent-relationship-encapsulation.md](../wiki/rules/eloquent-relationship-encapsulation.md)
- [x] Regola gerarchia: [module-hierarchy-inheritance-pattern.md](../wiki/rules/module-hierarchy-inheritance-pattern.md) — `implements` solo su `BaseScheda`

### Rimanente

- [ ] `Legge104\Scheda extends BaseScheda` (oggi `BaseModel` isolato)
- [ ] Audit action Ptv/Progressioni per altri bypass query
- [x] Aggiornare doc Sigma obsolete (`implements ProgressioneSchedaContract`)

---

## File toccati

| File | Azione |
|------|--------|
| `Ptv/Models/Contracts/SchedaContract.php` | `@method asz()` unificato |
| `Ptv/Models/Contracts/ProgressioneSchedaContract.php` | **Eliminato** |
| `Ptv/Models/BaseScheda.php` | `asz()` canonica |
| `Progressioni/Traits/ProgressioniRelationshipTrait.php` | Rimossa `asz()` duplicata |
| `Ptv/Actions/.../ListaAszTipCodEsclusoSubito.php` | `SchedaContract` + relazione |

---

## Definition of Done

- [x] Story documentata
- [x] Codice allineato a regola cardinale relazioni
- [x] PHPStan verde
- [ ] Legge104 in gerarchia BaseScheda
- [ ] Wiki moduli/temi allineati

---

## Riferimenti

- [Story analisi gerarchia](../chat/story-scheda-model-hierarchy-unification.md)
- [Pattern ASZ](../wiki/patterns/scheda-asz-relationship-query.md)
- [Handoff revert](../chat/handoff-asz-relationship-revert.md)

**BMAD:** Phase 4 Implementation Planning → Phase 4 Implementation (parziale)

## GitHub (tracciamento)

Repository letto da frontmatter `github.repository` o `git remote -v` (se assente: repo root **`laraxot/base_quaeris_fila5`**): **`laraxot/base_quaeris_fila5`**.

| Risorsa | Stato | Link |
|---|---|---|
| Issue | **DA CREARE** | https://github.com/laraxot/base_quaeris_fila5/issues |
| Discussion | **DA CREARE** | https://github.com/laraxot/base_quaeris_fila5/discussions |

Il numero non e' scritto perche' non esiste ancora: `gh` non e' autenticato in questa sessione e i repo sono privati. Appena disponibile, creare con:

```bash
gh issue create --repo laraxot/base_quaeris_fila5 \
  --title "STORY-002: Unificazione SchedaContract e gerarchia BaseScheda" --body-file <FILE>
gh api repos/laraxot/base_quaeris_fila5/discussions -f title="STORY-002: Unificazione SchedaContract e gerarchia BaseScheda" -f body="vedi la story"
```
