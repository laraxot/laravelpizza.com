## Contesto

| Campo | Valore |
|-------|--------|
| Modulo owner | **Sigma** (`laravel/Modules/Sigma`) |
| Remote canonico | `provtv/module_sigma_fila5` |
| Trigger UI | Ptv `TrovaEsclusiAction` → Progressioni lista schede |
| Ambiente | `personale2022.prov.tv.local`, PHP 8.4.21, Laravel 13.7 |

## Problema

L'azione **Trova esclusi** (anno 2026) falliva con due `TypeError` a cascata su calcolo giorni scheda:

1. **`applyQua00fProproFilters`**: atteso `Builder`, ricevuto `HasMany` da `ggInSedeTot()`.
2. **`GgFilterData::$lista_tipo_codice`**: atteso `?string`, ricevuto `array` da `getListaTipoCodiceAspettative()`.

## Catena business

`MinGgCatecoPosfunNoAsz` → `gg_cateco_posfun_no_asz` → `gg_cateco_posfun` − assenze → `Anag::ggInSedeTot` / `ggAssenzaInSedeTot` su `qua00f` / `asz00k1`.

## Fix applicati (mono)

| File | Modifica |
|------|----------|
| `FunctionExtra.php` | `applyQua00fProproFilters(Builder\|Relation $qua00f)` — FK `ente`+`matr` preservate |
| `GgFilterData.php` | `prepareForPipeline()` + `normalizeListaTipoCodice()` array → CSV |
| `FunctionExtra.php` | `hhAssenzaInSedeTot` usa normalizzatore su `$params` grezzi |
| `GgFilterDataTest.php` | 3 test Pest |

## Percorsi valutati (disciplina business-first)

| ID | Percorso | Verdetto |
|----|----------|----------|
| A | `Builder\|Relation` su helper privati | ✅ Fix immediato tipo relazione |
| B | `getQuery()` sulla HasMany | ❌ Perde vincoli FK |
| C | `implode` in 15+ call site SchedaTrait | ❌ DRY violato |
| D | Normalizzazione in `GgFilterData::prepareForPipeline` | ✅ Fix immediato lista_tipo_codice |
| E | Query object / relazioni scoped | 🔜 Refactor futuro |
| F | Batch eager load Trova esclusi | 🔜 Performance N+1 |

## Documentazione

- `docs/wiki/patterns/bugfix-business-logic-before-type.md`
- `laravel/Modules/Sigma/docs/wiki/concepts/function-extra-relation-query-pattern.md`
- `laravel/Modules/Ptv/docs/wiki/concepts/trova-esclusi-gg-cascade.md`
- `docs/chat/handoff-function-extra-relation-typeerror.md`

## Verifica

- [x] PHPStan L10 su `GgFilterData.php`, `FunctionExtra.php`
- [x] Pest `Modules/Sigma/tests/Unit/Datas/GgFilterDataTest.php` (3 passed)
- [ ] Manuale: Trova esclusi su `/progressioni/admin/schedas?filters[anno_valutatore][anno]=2026`

## Rischio residuo

- `ggAssenzaInSedeTot()` stub (`return 0`) per performance — assenze in sede non conteggiate finché non riattivato
- N+1 su batch schede: vedi `Sigma/docs/performance/function-extra-n-plus-1-queries.md`

## Discussion collegata

Dibattito percorsi E/F: discussion Sigma (creare con script `bashscripts/ai/gh-sigma-trova-esclusi-audit.sh`).

— Cursor (`composer-2.5-fast`)
