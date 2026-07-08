# Handoff: FunctionExtra TypeError + disciplina bugfix

## Stato

**Implementato** (2026-06-18): `getCriteriEsclusioneByYear` / `getCriteriOptionsParsedByYear`; `Check` con `SchedaContract`, fail-fast, `assertAttributesAreFillable` + `update()` (no `persist*`). Test: `BaseSchedaCriteriByYearTest`, `CriteriEsclusioneEnumActionRegistryTest`.

## Problema

`TypeError` in `Anag::applyQua00fProproFilters()` — atteso `Builder`, ricevuto `HasMany` da `ggInSedeTot()`.

Trigger: `TrovaEsclusiAction` → `MinGgCatecoPosfunNoAsz` → accessor `gg_cateco_posfun_no_asz` → `ggInSedeTot`.

## Fix codice

`Modules/Sigma/app/Models/Traits/Extras/FunctionExtra.php`: `applyQua00fProproFilters(Builder|Relation $qua00f, …)` — allineato a `applyQua00fCoalesceTotSelect*`.

## Percorsi valutati

| ID | Percorso | Verdetto |
|----|----------|----------|
| A | `Builder\|Relation` sulla firma | ✅ Scelto — minimo, FK preservate |
| B | `->getQuery()` | ❌ Perde vincoli `ente`+`matr` |
| C | Solo PHPDoc | ❌ TypeError runtime |
| D | `Qua00f::query()` manuale | ❌ Duplica contratto relazione |
| E | Query object dedicato | 🔜 Refactor futuro |
| F | Relazioni scoped per filtro | 🔜 DRY lungo termine |

## Docs consolidate

- Pattern root: [bugfix-business-logic-before-type.md](../wiki/patterns/bugfix-business-logic-before-type.md)
- Memoria: [second-brain/bugfix-business-logic-before-type.md](../wiki/second-brain/bugfix-business-logic-before-type.md)
- Sigma: [function-extra-relation-query-pattern.md](../../laravel/Modules/Sigma/docs/wiki/concepts/function-extra-relation-query-pattern.md)
- Ptv: [trova-esclusi-gg-cascade.md](../../laravel/Modules/Ptv/docs/wiki/concepts/trova-esclusi-gg-cascade.md)
- Progressioni: [trova-esclusi-ui-cascade.md](../../laravel/Modules/Progressioni/docs/wiki/concepts/trova-esclusi-ui-cascade.md)
- Xot: sezione aggiunta in [agent-confidence-discipline.md](../../laravel/Modules/Xot/docs/wiki/concepts/agent-confidence-discipline.md)

## Rischio residuo

N+1 su batch Trova esclusi — non affrontato da questo fix. Vedi `Sigma/docs/performance/function-extra-n-plus-1-queries.md`.

## Fix 2026-06-18 (lista_tipo_codice)

`GgFilterData::prepareForPipeline()` — array da `getListaTipoCodiceAspettative()` → stringa CSV. Test: `Modules/Sigma/tests/Unit/Datas/GgFilterDataTest.php`.

## GitHub (modulo Sigma)

Dopo `gh auth login`:

```bash
bash bashscripts/ai/gh-sigma-trova-esclusi-audit.sh
```

Body issue: `docs/chat/github-issue-sigma-function-extra-trova-esclusi-body.md`  
Repo: `provtv/module_sigma_fila5`
