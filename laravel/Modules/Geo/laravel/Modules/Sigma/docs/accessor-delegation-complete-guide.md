# 🧘 Accessor Delegation Pattern - Guida Completa

> **"Il metodo puro vive VICINO all'accessor, non in Helper separati"**
> **Aggiornato**: 2026-04-01
> **Versione**: 2.0 (COMPLETATO ✅)
> **Stato**: 22/22 accessor refactorizzati (100%)

---

## 🎯 Panoramica

Questo documento definisce il **pattern completo di delega** per gli accessor in Laravel, applicato con successo al modulo Sigma con **22 accessor refactorizzati**.

**Regola SACRA**: 
> Il metodo puro `get<Nome>()` deve vivere **VICINO** all'accessor `get<Nome>Attribute()`, idealmente nelle stesse 50 righe di codice.

---

## 📊 Risultati Sigma Module

| Fase | Accessor | Stato | File |
|------|----------|-------|------|
| **Fase 1** | 6/6 | ✅ COMPLETATA | SchedaTrait.php |
| **Fase 2** | 15/15 | ✅ COMPLETATA | SchedaTrait.php + SchedaMutator.php |
| **Fase 3** | 1/1 | ✅ COMPLETATA | SchedaTrait.php + SchedaExtraFieldTrait.php |
| **Totale** | **22/22** | **100% COMPLETATO** | |

**Quality Gates**:
- ✅ PHPStan Level 10: No errors
- ✅ Pattern applicato consistentemente
- ✅ Documentazione completa

---

## 📋 Pattern Completo (Template SACRO)

### Struttura Base

```php
/**
 * Helper method: [Descrizione calcolo] (calcolo puro).
 *
 * Business Rule: [Spiegazione regola business]
 *
 * @return [Tipo]|[null] [Descrizione risultato], null se [condizione]
 */
protected function get<Nome>(): [Tipo]|null
{
    // ✅ SOLO calcolo puro (max 50 righe)
    // Nessun update(), nessun save(), nessun side effect
}

/**
 * Accessor per <snake_case_nome> ([descrizione]).
 * Delega calcolo a get<Nome>().
 *
 * @param [Tipo]|null $value Valore cached dal DB
 *
 * @return [Tipo]|[null] [Descrizione risultato] calcolato
 */
protected function get<Nome>Attribute([Tipo]|null $value): [Tipo]|null
{
    // ✅ Cache hit
    if ([controllo tipo]) {
        return $value;
    }

    // ✅ Guard: modello deve avere PK
    if (null == $this->getKey()) {
        return null;
    }

    // ✅ Delega al metodo puro (VICINO!)
    $value = $this->get<Nome>();

    if (null === $value) {
        return null;
    }

    // ✅ Persist con update chirurgico
    $this->update(['<snake_case_nome>' => $value]);

    return $value;
}
```

---

## 🧠 Perché la Prossimità è Importante

### 1. **Cognitive Load (Carico Cognitivo)**

```
❌ SEPARATO (Helper lontano):
1. Leggi accessor (riga 100)
2. Scorri 500 righe
3. Trovi metodo puro (riga 600)
4. Torni all'accessor
5. Capisci il flusso

✅ VICINO (stesso posto):
1. Leggi accessor (riga 100)
2. Scorri 20 righe
3. Trovi metodo puro (riga 80)
4. Capisci il flusso
```

**Riduzione carico cognitivo**: 500 righe → 20 righe = **25x meno scrolling**

### 2. **AI Agent Context Window**

Gli AI agent (Qwen, Gemini, Claude) hanno context window limitati:

```
❌ SEPARATO:
- Qwen legge SchedaTrait.php (3000 righe)
- Trova accessor che chiama getGgIntegParamsAsz()
- Deve aprire SchedaHelper.php (700 righe)
- Context: 3000 + 700 = 3700 righe (troppo!)

✅ VICINO:
- Qwen legge SchedaTrait.php (3000 righe)
- Trova accessor + metodo puro insieme (50 righe)
- Context: 50 righe (perfetto!)
```

**Context efficiency**: 3700 righe → 50 righe = **74x più efficiente**

### 3. **Multi-Agent Collaboration**

Quando più AI agent lavorano sullo stesso codice:

```
❌ SEPARATO:
- Agent A modifica accessor in SchedaTrait
- Agent B modifica metodo puro in SchedaHelper
- Conflitti: chi coordina?
- Duplicazione: entrambi riscrivono logica

✅ VICINO:
- Agent A e B vedono stesso file
- Stesso contesto
- Stessa comprensione
- Meno conflitti
```

---

## 📝 Esempi Reali (Sigma Module)

### Esempio 1: Calcolo Semplice

```php
/**
 * Helper method: Calcola giorni fuori sede senza assenze (calcolo puro).
 *
 * Business Rule: Giorni fuori sede - (giorni assenza + ore assenza / 6).
 * Conversione ore in giorni: 6 ore = 1 giorno.
 *
 * @return float|null Giorni fuori sede netti, null se dati non disponibili
 */
protected function getGgFuoriSedeNoAsz(): ?float
{
    if (null == $this->gg_fuori_sede) {
        return null;
    }

    $gg_asz_fuori_sede = $this->gg_asz_fuori_sede ?? 0;
    $hh_asz_fuori_sede = $this->hh_asz_fuori_sede ?? 0;

    return (float) ($this->gg_fuori_sede - $gg_asz_fuori_sede - ($hh_asz_fuori_sede / 6));
}

/**
 * Accessor per gg_fuori_sede_no_asz (giorni fuori sede senza assenze).
 * Delega calcolo a getGgFuoriSedeNoAsz().
 *
 * @param float|null $value Valore cached dal DB
 *
 * @return float|null Giorni fuori sede netti calcolati
 */
protected function getGgFuoriSedeNoAszAttribute(?float $value): ?float
{
    // Cache hit
    if (null !== $value && ! request()->input('refresh', false)) {
        return $value;
    }

    // Guard: modello deve avere PK
    if (null == $this->getKey()) {
        return null;
    }

    // Delega calcolo al metodo puro (VICINO!)
    $value = $this->getGgFuoriSedeNoAsz();

    if (null === $value) {
        return null;
    }

    // Persist con update chirurgico
    $this->update(['gg_fuori_sede_no_asz' => $value]);

    return $value;
}
```

### Esempio 2: Fetch da Relazione

```php
/**
 * Helper method: Ottiene codqua da qua00f (calcolo puro).
 *
 * Business Rule: Estrae codqua dalla relazione qua00f filtrata per qua2kd.
 * Se qua00f esiste, aggiorna anche cont e tipco per consistenza.
 *
 * @return string|null Codqua calcolato, null se non disponibile
 */
protected function getCodqua(): ?string
{
    // Guard: qua2kd deve esistere
    if ($this->qua2kd === '') {
        return null;
    }

    $qua00f = $this->qua00f->where('qua2kd', $this->qua2kd)->first();
    if (! \is_object($qua00f)) {
        return null;
    }

    // Effettua update per consistenza (cont e tipco)
    if ($this->getKey() !== null) {
        $this->update([
            'codqua' => $qua00f->codqua,
            'cont' => $qua00f->cont,
            'tipco' => $qua00f->tipco,
        ]);
    }

    return (string) $qua00f->codqua;
}

/**
 * Accessor per codqua (codice qualifica da qua00f).
 * Delega calcolo a getCodqua().
 *
 * @return string|null Codqua calcolato
 */
protected function getCodquaAttribute(): ?string
{
    // Cache hit: se già in attributes, uso quello
    $value = $this->attributes['codqua'] ?? null;
    if ($value !== null) {
        return (string) $value;
    }

    // Guard: record deve esistere
    if ($this->getKey() == null) {
        return null;
    }

    // Delega calcolo al metodo puro (VICINO!)
    return $this->getCodqua();
}
```

### Esempio 3: Placeholder (Non Implementato)

```php
/**
 * Helper method: Ottiene giorni assenza per tipo codice escluso subito (calcolo puro).
 *
 * Business Rule: Attualmente non implementato. Placeholder per future implementazioni.
 *
 * @return null Sempre null (non implementato)
 */
protected function getGgAszTipCodEsclusoSubito(): ?int
{
    // Placeholder: non implementato
    return null;
}

/**
 * Accessor per gg_asz_tip_cod_escluso_subito (giorni assenza per tipo codice escluso subito).
 * Delega calcolo a getGgAszTipCodEsclusoSubito().
 *
 * @param int|null $_value Valore cached dal DB (non usato)
 *
 * @return null Sempre null (non implementato)
 */
protected function getGgAszTipCodEsclusoSubitoAttribute(?int $_value): ?int
{
    // Delega calcolo al metodo puro (VICINO!)
    return $this->getGgAszTipCodEsclusoSubito();
}
```

---

## 🔧 Refactoring Checklist

Per ogni accessor da refactorizzare:

- [ ] **1. Identificare** l'accessor `get<Nome>Attribute()`
- [ ] **2. Leggere** il codice esistente
- [ ] **3. Estrarre** il calcolo puro in `get<Nome>()`
- [ ] **4. Spostare** il metodo puro **PRIMA** dell'accessor (entro 50 righe)
- [ ] **5. Aggiornare** l'accessor per delegare al metodo puro
- [ ] **6. Aggiungere** PHPDoc completo a entrambi
- [ ] **7. Rimuovere** debug code (`dddx()`, `echo`, etc.)
- [ ] **8. Verificare** PHPStan Level 10: no errors
- [ ] **9. Commit** con messaggio descrittivo
- [ ] **10. Aggiornare** documentazione

---

## 📖 Lezioni Apprese

### 1. **Mai Semplificare il Dominio**

❌ **SBAGLIATO**: Rimuovere logica business specializzata
✅ **CORRETTO**: Preservare la logica, estrarla solo in metodo puro

### 2. **Gestione Errori**

❌ **SBAGLIATO**: Ignorare errori o usare `mixed`
✅ **CORRETTO**: Tipi forti, gestione esplicita null

### 3. **Debug Code**

❌ **SBAGLIATO**: Lasciare `dddx()`, `echo` in produzione
✅ **CORRETTO**: Rimuovere tutto, usare log se necessario

### 4. **Commenti Legacy**

❌ **SBAGLIATO**: Mantenere commenti commentati `/* ... */`
✅ **CORRETTO**: Rimuovere commenti inutili, documentare solo logica

### 5. **Multi-Agent Coordination**

❌ **SBAGLIATO**: Lavorare senza documentazione
✅ **CORRETTO**: Documentare tutto, usare indici, tracciare commit

---

## 📚 Riferimenti

- [Accessor/Mutator Philosophy](accessor-mutator-philosophy.md)
- [Accessor Delegation Audit](accessor-delegation-audit.md)
- [BMAD Story 2-1](stories/2-1-refactoring-accessor-fase2.md)
- [Laravel Accessors](https://laravel.com/docs/eloquent-mutators)

---

*Documento creato: 2026-04-01*
*Ultimo aggiornamento: 2026-04-01*
*Stato: ✅ COMPLETATO (22/22 accessor)*
*Multi-Agent Safe: Pattern documentato e verificato*
