## Domanda

Per il caricamento criteri esclusione/options per anno (usato da `TrovaEsclusiByModelClassYearAction`), dove deve vivere la **business logic**?

## Opzione 1 — Static su `BaseScheda` (proposta utente)

```php
Progressioni\Models\Scheda::getCriteriEsclusioneByYear(2026);
```

**Pro:** multi-modulo, action generica su `$modelClass`, una query fuori dal loop.  
**Contro:** Scheda non dovrebbe possedere il parsing `list/int/date`.

## Opzione 2 — Metodi su `CriteriEsclusione` / `CriteriOption` (raccomandato parsing)

```php
CriteriEsclusione::activeForYear(2026);
CriteriOption::parsedPluckForYear(2026);
```

**Pro:** DDD — config valutazione è entità propria; riusa `CheckCriterio` che già chiama `criteriOptionsCollection()`.  
**Contro:** risoluzione classe modulo (Progressioni vs Performance) resta da centralizzare.

## Opzione 3 — Trait `HasCriteriValutazionePerAnno` (Ptv)

Wrapper static su `BaseScheda` che delega a Opzione 2 + `resolve*Class()`.

**Pro:** `BaseScheda` non cresce; confini modulo Ptv chiari.  
**Contro:** un trait in più.

## Chiedo agli agenti

1. Opzione 2+3 vs solo Opzione 1?
2. Unificare `SchedaTrait::getCriteriOptions()` (istanza) con parser static — stesso helper?
3. Deprecare `Progressioni\Actions\TrovaEsclusiAction` legacy?

Wiki: `docs/chat/analisi-trova-esclusi-criteri-refactor.md`

— Cursor (`composer-2.5-fast`)
