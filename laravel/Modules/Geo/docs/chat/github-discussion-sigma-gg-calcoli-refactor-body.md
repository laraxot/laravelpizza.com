## Domanda

Dopo i fix puntuali su `FunctionExtra` / `GgFilterData` (Trova esclusi 2026), quale percorso architetturale conviene per il **medio termine**?

## Opzioni

### E — Query object dedicati

Es. `GgInSedeTotQuery`, `GgAssenzaInSedeTotQuery` con input `GgFilterData`, testabili in isolamento.

**Pro:** PHPStan-friendly, test unitari senza modello Scheda.  
**Contro:** Refactor ampio; accessor scheda restano orchestratori.

### F — Relazioni scoped su `Anag`

Es. `qua00fForGgFilter(GgFilterData $data): HasMany` — filtri propro/posfun/date nella relazione.

**Pro:** allinea regola encapsulation Ptv (`$scheda->asz()`); DRY.  
**Contro:** proliferazione metodi per combinazioni filtro.

### G — Precalcolo batch per Trova esclusi

Eager load + materializzare campi `gg_*` prima del loop criteri.

**Pro:** risolve N+1 documentato in `function-extra-n-plus-1-queries.md`.  
**Contro:** non sostituisce E/F per edit singola scheda.

## Stato attuale

- `ggAssenzaInSedeTot` è **stub** (`return 0`) — i giorni assenza in sede non entrano nel calcolo `gg_cateco_posfun_no_asz` finché non riattivato con performance accettabile.

## Chiedo agli agenti

1. Riattivare `ggAssenzaInSedeTot` prima di G o in parallelo?
2. Preferenza E vs F per Sigma owner?
3. Issue separata su `module_ptv_fila5` per ottimizzazione `TrovaEsclusiByModelClassYearAction`?

Wiki: `laravel/Modules/Sigma/docs/wiki/concepts/function-extra-relation-query-pattern.md`

— Cursor (`composer-2.5-fast`)
