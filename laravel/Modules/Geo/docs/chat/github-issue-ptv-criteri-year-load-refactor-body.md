## Contesto

Refactor proposto su `TrovaEsclusiByModelClassYearAction`: estrarre caricamento `criteri_esclusione` e `criteri_options` per anno.

Analisi completa: `docs/chat/analisi-trova-esclusi-criteri-refactor.md` (monorepo).

## Problema attuale

L'action duplica logica già presente in:

- `Ptv\Models\CriteriEsclusione::criteriOptionsCollection()`
- `SchedaTrait::getCriteriOptions()` (istanza, parsing migliore)
- risoluzione dinamica classi via `Str::between`

~70 righe di orchestrazione + query + map prima del `foreach` su schede.

## Proposta approvata (direzione)

| Layer | Responsabilità |
|-------|----------------|
| `CriteriOption` (Ptv) | Parsing tipizzato `list\|int\|date` → `Collection name => value` |
| `CriteriEsclusione` (Ptv) | Query criteri attivi per anno (`value != 0`) |
| `BaseScheda` o trait Ptv | Static wrapper: risolve classi modulo + delega |
| `TrovaEsclusiByModelClassYearAction` | Solo batch schede + `Check::execute` |

**Non** duplicare `switch ($type)` su `BaseScheda`.

## Naming (evitare collisioni)

- Esiste già `getCriteriOptions()` istanza su `SchedaTrait`
- Usare: `getCriteriEsclusioneByYear`, `getCriteriOptionsParsedByYear`

## Bug da correggere nello stesso refactor

`CriteriEsclusione::criteriOptionsCollection()` case `int`: usa `$value` vuoto invece di `$item->value`.

`BaseScheda::criteriOptions()` placeholder `hasMany(static::class)` — allineare a relazione reale (come `ProgressioniRelationshipTrait`).

## Checklist implementazione

- [ ] Estrarre parser condiviso `CriteriOption`
- [ ] Static/scopes per anno su modelli Criteri*
- [ ] Slim `TrovaEsclusiByModelClassYearAction`
- [ ] Pest: parsing tipi + caricamento anno
- [ ] PHPStan L10 moduli Ptv + Progressioni
- [ ] Manuale: Trova esclusi Filament anno 2026

## Discussion collegata

Percorsi B vs C vs D — ownership parsing (vedi script discussion).

— Cursor (`composer-2.5-fast`)
