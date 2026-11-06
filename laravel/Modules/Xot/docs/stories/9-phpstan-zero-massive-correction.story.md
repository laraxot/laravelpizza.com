---
title: "PHPStan Zero: Massiva Correzione Errori e Miglioramento Continuo"
module: Xot
bmad: true
type: story
status: active
created: 2026-10-20
updated: 2026-10-20
tags: [phpstan, quality, swarm, subagent, bmad, zero-error]
issues: []
discussions: []
---

# BMAD Story 9: PHPStan Zero: Massiva Correzione Errori

**Phase**: 9  
**Owner**: Claude Haiku 4.5 / Swarm Agent(s)  
**Start**: 2026-10-20  
**Status**: Active: Swarm bers choix (scope disgiunti file level)  

---

## Problem Statement

Ogni volta che si lancia `./vendor/bin/phpstan analyse Modules` si ottengono **3183 errori** su 176 file, divisi tra 8 moduli:

| Modulo | Errori | Fasi priorità |
|--------|--------:|---------------|
| Notify | 819 | Background Async |
| UI | 720 | Widget + Test pattern |
| Cms | 496 | Semantic keys array |
| Geo | 421 | Type narrowing collection |
| User | 387 | Factory + model |
| Gdpr | 188 | Schema PHPDoc |
| Lang | 119 | Safe json_encode |
| AI | 33 | Method return types |

**Pattern ripetitivi**: `method.nonObject` (694), `property.nonObject` (226), `offsetAccess.nonOffsetAccessible` (352), `argument.type` (207), `pest.expectation.redundant` (175), `class.notFound` (156), `theCodingMachineSafe.function` (120).

---

## Goal

Ridurre a zero errori PHPStan (`analyse Modules`) senza:
- Modificare `phpstan.neon`
- Usare baseline o ignore
- Modificare `mixed` per zittire PHPStan
- Usare `@var` inline per far sparire il messaggio
- Cancellare logiche reali solo test

Ogni fix deve seguire scopo→causa→fix, come descritto nella [11-phpstan.md](bashscripts/docs/prompts/11-phpstan.md).

---

## Strategy

### Phase 1: Swarm Batch (8 moduli parzialmente indipendenti)

| Wave | Moduli | Timeout | Conditional |
|------|--------|---------|-------------|
| A | AI, Lang, Gdpr, User | 30 min | Solo errori leggri direttamente fixabili |
| B | Geo, Cms, UI | 45 min | Chiuse batch, eventualmente chunk |
| C | Notify (819) | 60 min | Solo fine batch 1 |

Solo i moduli che rimangono hanno errori fissabili sono chunkati per sottovia.

### Fix Patterns by Category

1. **missingType.iterableValue** (75): Aggiungere array shape PHPDoc o tipizzazioni `array<string, mixed>` al parametro/return
2. **method.nonObject** (393): Asserzione `assert($x instanceof Type)` immediatamente dopo l'assecoestazione di un factory/container
3. **property.nonObject** (226): `@var array<string, mixed>` o `@var BelongsTo<...>` al momento dell'accesso
4. **offsetAccess.nonOffsetAccessible** (352): `@var` permitive o assert sui array access
5. **theCodingMachineSafe.function** (120): Aggiungere `use function Safe\json_encode;` e `use function Safe\json_decode;` all'inizio file
6. **pest.expectation.redundant** (175): Rioriduzione assert o `toBeArray()` → `toBe()rides`  
7. **class.notFound** (156): Usare `git log -S` per ritenere il simbolo; reinstallare/creare classe

### Phase 2: Docs & Prompts

Dopo le fix: organizza docs inside `Modules/<M>/docs/` e `Themes/Zero/docs/`, studia e migliora prompt in `bashscripts/docs/prompts/`.

---

## Verification

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules --error-format=json > /tmp/final.json 2>&1; echo $?
# Verrà eseguita di nuovo dopo il completamento del lavoro
```

Success criterion: exit code 0 con zero file_errors nel json `totals`.

---

## Stakeholder Charter

- Each subagent dichiarera scope (lista path assoluti) e approccio nella story/handoff BMAD.
- Un solo file ha un solo writer: scope disgiunti a livello path.
- Non randomizzare l'ordine delle dipendenze: control dependency perimetri.
- Poche RAM (`free -h`) sopra ~50 processi PHPStan: serializza.
- Il coordinatore chiude ogni batch con un solo run completo.

---

## Closure Criteria

- [ ] Exit code 0 con zero file_errors per `analyse Modules`
- [ ] Docs rip dentro `Modules/<M>/docs/` per ogni modulo Fixed (o marzato superseded se dead code)
- [ ] Prompt migliorato in `bashscripts/docs/prompts/` per i pattern PHPStan visti
- [ ] Second brain aggiornato con nuovi pattern scoperti (extra blocco task successivo)
- [ ] Stories BMAD accredtiere every modello solensione (causa radice, fix, verifica)
- [ ] `git diff --check`: newline checking solo allefimo saldi

---

## Interoperability

Questo initative è l'epic padre delle storie 8.x che chiariscono il problema. Alla finalizzazione del wall: refactoro della 9-storione alla 9-done.
</STORY
echo "Story created successfully"