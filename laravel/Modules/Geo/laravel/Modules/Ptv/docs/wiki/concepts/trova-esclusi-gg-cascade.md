---
title: "trova esclusi gg cascade"
type: concept
module: Ptv
tags: [trova-esclusi, criteri-esclusione, scheda, sigma, progressioni]
created: 2026-06-18
updated: 2026-06-18
qmd: "TrovaEsclusiAction gg_cateco_posfun_no_asz MinGgCatecoPosfunNoAsz cascade"
related:
  - ../../../../Sigma/docs/wiki/concepts/function-extra-relation-query-pattern.md
  - ./phpstan-scheda-actions.md
  - ../../../../../../docs/wiki/patterns/bugfix-business-logic-before-type.md
---

# Trova esclusi: cascata calcolo giorni

## Scopo

L'azione Filament **Trova esclusi** (`TrovaEsclusiAction`) valuta ogni scheda dell'anno contro i criteri di esclusione configurati. Non è solo UI: tocca la logica di dominio Progressioni/Ptv sui giorni di presenza.

**Entry point:** `Modules/Ptv/app/Filament/Actions/Header/TrovaEsclusiAction.php`  
**Orchestrazione:** `TrovaEsclusiByModelClassYearAction` → `CriteriEsclusione\Check` → action per criterio.

## Catena esempio: `min_gg_cateco_posfun_no_asz`

1. `MinGgCatecoPosfunNoAsz::execute()` legge `$scheda->gg_cateco_posfun_no_asz`
2. Accessor `getGgCatecoPosfunNoAszAttribute` → `getGgCatecoPosfunNoAsz()` (`SchedaHelper`)
3. Formula: `gg_cateco_posfun − gg_asz_cateco_posfun` (giorni netti assenze)
4. `gg_cateco_posfun` → `getGgCatecoPosfunInSede()` → `anag->ggInSedeTot($data)`
5. `GgFilterData`: `lista_propro` da `categoriaPropro`, `posfun`, date da `criteriOptions`
6. `FunctionExtra::ggInSedeTot` query su `qua00f` del dipendente

Un TypeError in passo 6 blocca l'intera azione anche se il criterio Ptv è corretto.

## Lezione per il fix

Correggere solo `TrovaEsclusiAction` o `MinGgCatecoPosfunNoAsz` sarebbe **sbagliato**: il bug era nel layer Sigma (`FunctionExtra`), nel contratto tipo relazione/query.

Prima di patchare in Ptv, tracciare sempre questa cascata fino al modello che esegue la query.

## lista_tipo_codice nella cascata

Passo 4b (assenze in sede): `getListaTipoCodiceAspettative()` restituisce **array**; `GgFilterData` richiede **stringa CSV** — normalizzazione in `prepareForPipeline()`.

## Performance (percorso migliore futuro)

Per batch su tutte le schede anno:

- Eager load `anag`, `categoriaPropro`, `criteriOptions` dove possibile
- Valutare precalcolo campi `gg_*` prima del loop criteri
- Vedi Sigma [function-extra-n-plus-1-queries](../../../../Sigma/docs/performance/function-extra-n-plus-1-queries.md)

## Collegamenti

- [function-extra-relation-query-pattern](../../../../Sigma/docs/wiki/concepts/function-extra-relation-query-pattern.md)
- [phpstan-scheda-actions](./phpstan-scheda-actions.md)
- [bugfix-business-logic-before-type](../../../../../../docs/wiki/patterns/bugfix-business-logic-before-type.md)
