# Accessor Guard Audit - Modulo IndennitaCondizioniLavoro

## Business Logic del Modulo

**Scopo**: Gestione indennità condizioni di lavoro (es. turni notturni, festivi, disagio)

**Calcoli Principali**:
- Totale indennità: Σ(euro_giorno × giorni) per tipo indennità
- Applicazione part-time: Totale × coefficiente part-time
- Giorni trasferte/presenze annuali per validazione

## Accessor Audit - File: CondizioniLavoro.php

### ✅ Accessor CON Guard Corretto

#### 1. getTotAttribute (linea 269)

**Business Rule**: Calcola totale indennità = Σ(euro_giorno × gg) per ogni tipo

**Codice**:
```php
public function getTotAttribute(?float $value): ?float
{
    $tot = 0;
    foreach ($this->indennitaTipoDettaglio as $tipo) {
        $tot += $tipo->euro_giorno * $tipo->pivot->gg;
    }
    
    $this->tot = $tot;
    
    // ✅ GUARD PRESENTE
    if ($this->getKey() === null) {
        return $tot;
    }
    
    // ✅ Persistenza chirurgica con update mirato
    $this->update(['tot' => $tot]);

    return $tot;
}
```

**Status**: ✅ Corretto, ora usa `update()` al posto di `save()` per evitare loop ActivityLog

#### 2. getGgPresenzaAnnoAttribute (linea 391)

**Business Rule**: Conta giorni distinti con timbrature nell'anno

**Codice**:
```php
public function getGgPresenzaAnnoAttribute(?int $value): ?int
{
    if ($value !== null) return $value;
    
    $gg = $this->wstr01lx()->select('wtdata')->distinct('wtdata')->get()->count();
    $this->gg_presenza_anno = $gg;
    
    // ✅ GUARD PRESENTE  
    if ($this->getKey() === null) {
        return $gg;
    }
    
    // ✅ Persistenza con update mirato
    $this->update(['gg_presenza_anno' => $gg]);
    return $gg;
}
```

**Status**: ✅ Corretto, persistenza aggiornata a `update()` per evitare side effect

### 🟡 Accessor SENZA save() (Safe)

#### 3. getTotXPtimeAttribute (linea 292)

**Business Rule**: Applica coefficiente part-time al totale

**Codice**:
```php
public function getTotXPtimeAttribute(?float $value): ?float
{
    return $this->tot * $this->perc_p_time_daterange;
}
```

**Status**: ✅ Nessun save(), nessun guard necessario

#### 4-15. Altri Accessor

Tutti gli altri accessor (getReparTxt, getDisci1, getCodqua, etc.) **non chiamano save()**.

**Status**: ✅ Nessuna azione necessaria

### 🔵 Accessor Disabilitati (Commentati)

#### getGgTrasferteAnnoAttribute (linea 363)

**Codice**:
```php
public function getGgTrasferteAnnoAttribute(?int $value): ?int
{
    if ($value !== null) return $value;
    
    return 0;
    
    /* CODICE COMMENTATO con save()
    // ...
    $this->gg_trasferte_anno = $giorni;
    $this->save(); // Era senza guard
    return $giorni;
    */
}
```

**Status**: ⚠️ Disabilitato, se riattivato necessita guard

**Azione**: Documentare per futura riattivazione

## Opportunità Refactoring

### Accessor Candidati per Pattern Metodo Puro

Anche se non hanno save(), alcuni accessor potrebbero beneficiare del pattern:

1. **getTotAttribute**: Logica aggregazione complessa (30 righe loop)
   - Candidato: Estrarre `protected function getTot(): float`
   - Beneficio: Testabilità, riusabilità

2. **getGgPresenzaAnnoAttribute**: Query distinct count
   - Candidato: Estrarre `protected function getGgPresenzaAnno(): int`
   - Beneficio: Riuso in report, test

**Decisione**: Da valutare in fase refactoring successiva (non urgente)

## Riepilogo Modulo

### Statistiche

| Metrica | Valore |
|---------|--------|
| Accessor totali | 15 |
| Accessor con update() | 2 |
| Guard presenti | 2/2 ✅ |
| Guard mancanti | 0 ✅ |
| Accessor disabilitati | 1 |

### Conclusione Audit

✅ **Modulo SICURO**: Tutti gli accessor attivi usano `update()` con guard corretto!

**Nessun fix necessario per questo modulo.**

## Collegamenti

- [Regola Globale Guard](../../Xot/docs/accessor-save-guard-global-rule.md)
- [Audit Cross-Modules](../../Xot/docs/accessor-audit-cross-modules.md)
- [Pattern Refactoring](../../Sigma/docs/accessor-refactoring-philosophy.md)

---

**Data Audit**: 2025-01-29  
**Auditato da**: AI Assistant  
**Status**: ✅ COMPLIANT  
**Azioni Richieste**: Nessuna (guard già presenti)

