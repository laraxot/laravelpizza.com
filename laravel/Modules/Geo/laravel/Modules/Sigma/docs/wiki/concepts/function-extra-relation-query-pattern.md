---
title: "function extra relation query pattern"
type: concept
module: Sigma
tags: [function-extra, qua00f, gg-in-sede, eloquent, relation, bugfix]
created: 2026-06-18
updated: 2026-06-18
qmd: "FunctionExtra ggInSedeTot qua00f Builder Relation applyQua00fProproFilters GgFilterData lista_tipo_codice"
issues:
  - "https://github.com/provtv/module_sigma_fila5/issues/TBD"
discussions:
  - "https://github.com/provtv/module_sigma_fila5/discussions/TBD"
related:
  - ./has-ente-matr-relation-helpers.md
  - ../../refactoring/function-extra-is-helper-analysis.md
  - ../../performance/function-extra-n-plus-1-queries.md
  - ../../../../Ptv/docs/wiki/concepts/trova-esclusi-gg-cascade.md
  - ../../../../../../docs/wiki/patterns/bugfix-business-logic-before-type.md
---

# FunctionExtra: pattern query su relazione `qua00f`

## Scopo di dominio

`FunctionExtra` calcola giorni/ore di presenza e assenza interrogando tabelle Sigma (`qua00f`, `asz00k1`, …) **per un singolo dipendente** (`ente` + `matr`).

`ggInSedeTot(GgFilterData $data)` risponde a: *quanti giorni in sede ha questo dipendente nel periodo, per le categorie propro e la posizione funzionale richieste?*

Usato da accessor sulla scheda (`gg_cateco_posfun`, `gg_cateco_posfun_no_asz`, …) e quindi da criteri di esclusione Ptv (es. `MinGgCatecoPosfunNoAsz`).

## Flusso query (ggInSedeTot)

1. `$this->qua00f()` — `HasMany` via `hasManyByEnteMatr` (vincolo `ente`+`matr`)
2. Filtri propro/posfun — `applyQua00fProproFilters`
3. Filtri `posiz`, intervallo `qua2kd`/`qua2ka`
4. Aggregato giorni — `applyQua00fCoalesceTotSelect`
5. `$qua00f->first()->tot`

Tutti i passi concatenano sulla **stessa** istanza relazione/query.

## Bug (2026-06-18)

```
TypeError: applyQua00fProproFilters(): Argument #1 ($qua00f) must be of type Builder, HasMany given
```

**Causa:** refactor PHPStan aveva ristretto `applyQua00fProproFilters` a `Builder`, mentre i chiamanti passavano sempre la relazione (come già facevano per `applyQua00fCoalesceTotSelect`).

**Non era un bug di business:** il runtime voleva la relazione; la firma era incoerente.

## Percorsi valutati

| Percorso | Esito | Motivo |
|----------|-------|--------|
| **A — `Builder\|Relation` su `applyQua00fProproFilters`** | ✅ Scelto | Minimo, coerente con gemelli nello stesso file, FK preservate |
| B — `$qua00fRelation->getQuery()` | ❌ | Perde vincoli `ente`+`matr` della `HasMany` → risultati su altri dipendenti |
| C — Solo PHPDoc `@var Builder` | ❌ | TypeError runtime in PHP 8.4 |
| D — `Qua00f::query()->where('matr', …)` manuale | ❌ | Duplica contratto relazione; viola DRY |
| E — Query object / Action dedicata | 🔜 Futuro | Migliore testabilità; scope refactor ampio |
| F — Relazione scoped `qua00fForFilter(GgFilterData)` | 🔜 Futuro | Allinea regola encapsulation Ptv; molte combinazioni filtri |

## Fix applicato

File: `app/Models/Traits/Extras/FunctionExtra.php`

- `applyQua00fProproFilters(Builder|Relation $qua00f, …)`
- PHPDoc allineato ai metodi `applyQua00fCoalesceTotSelect*`

## Debito noto (non risolto da questo fix)

- **N+1:** accessor scheda × `Trova esclusi` batch → vedi [function-extra-n-plus-1-queries](../../performance/function-extra-n-plus-1-queries.md)
- **Posizione trait:** calcoli in `FunctionExtra` su modello `Anag` — analisi [function-extra-is-helper-analysis](../../refactoring/function-extra-is-helper-analysis.md)

## Verifica

```bash
cd laravel && ./vendor/bin/phpstan analyse --level=10 Modules/Sigma/app/Models/Traits/Extras/FunctionExtra.php
```

Test manuale: azione **Trova esclusi** su lista schede Progressioni con filtro anno.

## lista_tipo_codice (array → CSV)

`getListaTipoCodiceAspettative()` → `array` di coppie `tipo-codice`. `GgFilterData::prepareForPipeline()` normalizza per `find_in_set`. File: `app/Datas/GgFilterData.php`.

Repo owner: **`provtv/module_sigma_fila5`**. Issue/discussion: eseguire `bash bashscripts/ai/gh-sigma-trova-esclusi-audit.sh` (richiede `gh auth login`).

## Collegamenti

- [has-ente-matr-relation-helpers](./has-ente-matr-relation-helpers.md)
- [trova-esclusi-gg-cascade](../../../../Ptv/docs/wiki/concepts/trova-esclusi-gg-cascade.md)
- [bugfix-business-logic-before-type](../../../../../../docs/wiki/patterns/bugfix-business-logic-before-type.md)
