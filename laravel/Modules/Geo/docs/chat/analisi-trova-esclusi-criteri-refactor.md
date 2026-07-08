# Analisi: estrarre caricamento criteri da `TrovaEsclusiByModelClassYearAction`

**Data:** 2026-06-18  
**File trigger:** `laravel/Modules/Ptv/app/Actions/Scheda/TrovaEsclusiByModelClassYearAction.php`  
**Repo issue owner:** `provtv/module_ptv_fila5` (action + `BaseScheda` + modelli `Criteri*`)

---

## Cosa stai cercando di fare (interpretazione)

Vuoi **togliere dall'action** il blocco che:

1. Risolve dinamicamente `CriteriEsclusione` / `CriteriOption` dal nome modulo (`Str::between`)
2. Carica per anno i criteri con `value != 0`
3. Trasforma le option (`list` / `int` / `date`) in `Collection name => value_real`

e metterlo in **due metodi riusabili** su `BaseScheda`, passando l'anno.

**Intento corretto:** DRY, action più leggibile, un solo posto per la “config di valutazione per anno”. L'action deve orchestrare (schede → `Check`), non possedere query + parsing.

---

## Contesto business

| Pezzo | Ruolo |
|-------|--------|
| `criteri_esclusione` | Regole attive per anno (nome + soglia `value`) |
| `criteri_options` | Parametri tipizzati (liste, date presenza, minimi…) |
| `TrovaEsclusiByModelClassYearAction` | Batch: tutte le schede anno → `Check` → aggiorna `ha_diritto` / `motivo` |
| `Check` | Per ogni criterio, risolve action `Modules\Ptv\Actions\CriteriEsclusione\{StudlyName}` |

I criteri sono **configurazione di campagna** (per `anno`), non proprietà di una singola riga scheda — ma vengono **consumati** durante il calcolo su ogni scheda.

---

## Duplicazioni già presenti (non partire da zero)

| Posizione | Cosa fa | Note |
|-----------|---------|------|
| `TrovaEsclusiByModelClassYearAction` | query + map inline | **duplicato** |
| `Ptv\Models\CriteriEsclusione::criteriOptionsCollection()` | map + pluck | usato da `CheckCriterio`; bug `int` usa `$value` vuoto invece di `$item->value` |
| `SchedaTrait::getCriteriOptions()` | istanza, `match` su `type` | via relazione `$this->criteriOptions` — **migliore** |
| `Progressioni\Actions\TrovaEsclusiAction` | legacy, `pluck` grezzo | **senza** coercion tipi — path vecchio |
| `CheckCriterio` | `$criterio->criteriOptionsCollection()` | già delega al modello |

Se aggiungi solo 2 static su `BaseScheda` **senza** unificare il parsing, aumenti la duplicazione a 5.

---

## La tua proposta: static su `BaseScheda` + anno

### Cosa funziona

- L'action oggi risolve le classi con `Str::between($modelClass, 'Modules\\', '\Models\\')` — fragile ma **multi-modulo** (Progressioni, Performance…).
- Metodi **static** sulla classe scheda concreta (`Progressioni\Models\Scheda::…`) risolvono naturalmente `Progressioni\Models\CriteriEsclusione` — stesso pattern di `CriteriEsclusione::schede()` che fa `Str::beforeLast` + `\Scheda`.
- Nel batch i criteri vanno caricati **una volta fuori il `foreach`** — static per anno è adatto.

### Dove ti contesto (non fare “scimmia”)

1. **Nome `getCriteriOption` / `getCriteriEsclusione`**  
   Su `SchedaTrait` esiste già `getCriteriOptions()` **di istanza** (legge relazione). Aggiungere static `getCriteriOption` crea confusione semantica.  
   Meglio: `getCriteriEsclusioneByYear(int $year, string $yearField = 'anno')` e `getCriteriOptionsParsedByYear(...)`.

2. **Responsabilità: Scheda vs modello Criteri***  
   Il parsing `list|int|date` è logica di **`CriteriOption`**, non della scheda.  
   `BaseScheda` può esporre static **facade** che delega:
   ```text
   Scheda::criteriEsclusioneModelClass() → query
   CriteriOption::parsedCollectionForYear($year) → Collection
   ```
   Mettere tutto il `switch ($type)` dentro `BaseScheda` appesantisce un modello già enorme (`SchedaTrait`).

3. **`BaseScheda::criteriOptions()` è un placeholder rotto**  
   ```php
   return $this->hasMany(static::class); // SBAGLIATO
   ```
   Progressioni ha la relazione vera in `ProgressioniRelationshipTrait`. Prima di static “get”, allineare relazione o trait condiviso `HasCriteriValutazioneRelationships`.

4. **Static sì, ma non per ogni scheda nel loop**  
   Se qualcuno chiama ` $row->getCriteriEsclusione($year)` dentro il `foreach`, ripeti query identiche × N schede. L'action deve restare:
   ```php
   $criteri = $modelClass::getCriteriEsclusioneByYear($year, $fieldName);
   $options = $modelClass::getCriteriOptionsParsedByYear($year, $fieldName);
   foreach ($rows as $row) { Check... }
   ```

5. **`fieldName` non è sempre `anno`**  
   L'action accetta `$fieldName` (es. `anno` vs `year`). I metodi static devono propagare lo stesso parametro, non hardcodare `anno`.

---

## Percorsi architetturali valutati

| ID | Percorso | Verdetto |
|----|----------|----------|
| A | 2 static su `BaseScheda` con query + switch inline | ⚠️ DRY parziale, duplica parsing |
| B | Static su `BaseScheda` che delega a `CriteriOption::parsedForYear()` | ✅ **Consigliato** — action snella, parsing unico |
| C | Solo scope su `CriteriEsclusione::query()->forYear()` | ✅ per query; parsing resta su Option |
| D | Trait `HasCriteriValutazionePerAnno` su Ptv | ✅ se `BaseScheda` resta leggibile |
| E | Lasciare tutto nell'action | ❌ debito attuale |
| F | Instance `$scheda->criteriEsclusione()` nel loop | ❌ N query inutili in batch |

**Raccomandazione:** **B + D**

1. `CriteriOption` (Ptv): `public static function parsedPluckForYear(int $year, string $yearField = 'anno'): Collection` — unifica con logica `SchedaTrait::getCriteriOptions()` (estrarre `match` condiviso).
2. `CriteriEsclusione` (Ptv): `public static function activeForYear(int $year, string $yearField = 'anno'): EloquentCollection` — `where value != 0`.
3. `BaseScheda` o trait: `resolveCriteriEsclusioneClass()` / `resolveCriteriOptionClass()` + static wrapper che chiama i metodi sopra sulla classe modulo-corretta.
4. `TrovaEsclusiByModelClassYearAction`: ~15 righe, niente `Str::between` nel corpo.
5. Deprecare / allineare `criteriOptionsCollection()` su `CriteriEsclusione` (fix bug `int`).

---

## Relazione con fix recenti (Sigma)

`Check` → criteri Ptv → accessor scheda → `GgFilterData` / `FunctionExtra` (Sigma).  
Il refactor criteri **non risolve** TypeError Sigma; rende però l'action più chiara per debuggare la cascata. Vedi [trova-esclusi-gg-cascade](../../laravel/Modules/Ptv/docs/wiki/concepts/trova-esclusi-gg-cascade.md).

---

## Prossimi passi (se approvi)

1. Issue `module_ptv_fila5`: refactor caricamento criteri (questo documento).
2. Discussion: ownership parsing su `CriteriOption` vs `BaseScheda`.
3. Implementazione incrementale: parsing unico → static wrapper → slim action → test Pest.
4. Non toccare `Progressioni\Actions\TrovaEsclusiAction` legacy nello stesso PR senza audit esplicito.

---

## GitHub

```bash
gh auth login
bash bashscripts/ai/gh-ptv-trova-esclusi-criteri-refactor-audit.sh
```

— Cursor (`composer-2.5-fast`)
