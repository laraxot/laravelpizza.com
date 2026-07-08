# Story 2-1: Refactoring Accessor Sigma - Fase 2

> **Stato**: backlog  
> **Epic**: 2 - Refactoring Accessor Delegation Pattern  
> **Story**: 1  
> **Priorità**: Media (🟡)  
> **Stima**: 6-8 ore  
> **AI Agent**: @qwen (o qualsiasi AI agent disponibile)

---

## 📋 User Story

**Come** sviluppatore del modulo Sigma  
**Voglio** che tutti gli accessor seguano il pattern di delega con metodo puro vicino  
**In modo da** avere codice manutenibile, AI-friendly, e multi-agent safe

---

## 🎯 Obiettivi

Refactorizzare ~15 accessor nel modulo Sigma per seguire il pattern di delega:

1. Metodo puro `get<Nome>()` entro 50 righe dall'accessor
2. Accessor `get<Nome>Attribute()` con cache/guard/delega/persist
3. Entrambi nello stesso file (SchedaTrait.php o SchedaMutator.php)
4. PHPStan Level 10: nessun errore
5. Documentazione aggiornata

---

## ✅ Acceptance Criteria (BDD)

### Scenario 1: Refactoring completato

```gherkin
Dato che ho 15 accessor da refactorizzare in Fase 2
Quando applico il pattern di delega a tutti
Allora ogni accessor ha un metodo puro corrispondente entro 50 righe
E PHPStan Level 10 non riporta errori
E la documentazione è aggiornata
```

### Scenario 2: Pattern corretto

```gherkin
Dato un accessor get<Nome>Attribute()
Quando refactorizzo seguendo il pattern
Allora esiste get<Nome>() come metodo puro
E l'accessor delega al metodo puro
E il metodo puro ha solo calcolo (nessun side effect)
E l'accessor ha cache/guard/delega/persist
```

### Scenario 3: Quality gates

```gherkin
Dato il refactoring completato
Quando eseguo i quality gate
Allora PHPStan Level 10: 0 errori
E PHPMD: 0 warning
E PHPInsights: score > 90
```

---

## 📚 Contesto Tecnico

### File Coinvolti

1. **`laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`**
   - ~10 accessor da refactorizzare
   - Aggiungere metodi puri vicino agli accessor

2. **`laravel/Modules/Sigma/app/Models/Traits/Mutators/SchedaMutator.php`**
   - ~5 accessor da refactorizzare
   - Aggiungere metodi puri vicino agli accessor

3. **`laravel/Modules/Sigma/docs/accessor-delegation-audit.md`**
   - Aggiornare stato completamento

### Pattern da Seguire

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

## 🔧 Accessor da Refactorizzare

### Priorità Media (🟡) - SchedaTrait.php

| # | Accessor | Righe Approssimative | Note |
|---|----------|---------------------|------|
| 1 | `getGgCatecoNoPosfunNoAszAttribute` | ~1600 | Sottrazione: gg_cateco_no_asz - gg_cateco_posfun_no_asz |
| 2 | `getGgCatecoSupAttribute` | ~1500 | Somma: sup_in_sede + sup_fuori_sede |
| 3 | `getGgCatecoSupInSedeAttribute` | ~1520 | Delega ad anag, nessun metodo puro |
| 4 | `getGgCatecoSupFuoriSedeAttribute` | ~1800 | Delega ad anag, nessun metodo puro |
| 5 | `getListaProproAttribute` | ~2500 | Delega a categoriaPropro |
| 6 | `getListaProproSupAttribute` | ~2510 | Delega a categoriaPropro |
| 7 | `getImportoStipendioAnnuoAttribute` | ~2800 | Delega a stipendioTabellare |

### Priorità Media (🟡) - SchedaMutator.php

| # | Accessor | Note |
|---|----------|------|
| 8 | `getCodquaAttribute` | Fetch da qua00f |
| 9 | `getContAttribute` | Fetch da qua00f |
| 10 | `getTipcoAttribute` | Fetch da qua00f |
| 11 | `getPosizioneEcoAttribute` | Fetch da tqu00f |
| 12 | `getPercParttimepondAnnoAttribute` | Calcolo part-time |
| 13 | `getPercParttimepondDalalAttribute` | Calcolo part-time daterange |
| 14 | `getDisci1TxtAttribute` | Fetch da Codici |
| 15 | `getEtaAttribute` | Calcolo età |

---

## 📖 Documentazione di Riferimento

1. **Pattern SACRO**: `laravel/Modules/Sigma/docs/accessor-delegation-pattern.md`
2. **Audit Completo**: `laravel/Modules/Sigma/docs/accessor-delegation-audit.md`
3. **Filosofia**: `laravel/Modules/Sigma/docs/accessor-mutator-philosophy.md`
4. **Coordination**: `docs/ai-agent-coordination.md`

---

## 🧪 Testing Requirements

### Test Unitari (Pest PHP)

Per ogni accessor refactorizzato:

```php
it('delegates to pure method correctly', function (): void {
    // Arrange
    $model = SigmaModel::factory()->create();
    
    // Act
    $result = $model->attribute_name;
    
    // Assert
    expect($result)->toBeType('expected_type');
});

it('caches value in database', function (): void {
    // Arrange
    $model = SigmaModel::factory()->create(['attribute_name' => null]);
    
    // Act
    $model->attribute_name; // Trigger calcolo
    $model->refresh();
    
    // Assert
    expect($model->attribute_name)->not->toBeNull();
});
```

---

## 📝 Dev Notes (da compilare durante l'implementazione)

### Refactoring Completati

| Accessor | Commit | Note |
|----------|--------|------|
| | | |

### Problemi Incontrati

| Problema | Soluzione |
|----------|-----------|
| | |

### Decisioni Tecniche

| Decisione | Motivazione |
|-----------|-------------|
| | |

---

## 🔗 Dipendenze

### Dipende da

- ✅ Fase 1 completata (6 accessor critici)
- ✅ Documentazione creata
- ✅ Pattern definito e testato

### Blocca

- Fase 3 (Cleanup e documentazione)
- Quality gates finali su tutto il modulo

---

## 📊 Metriche di Successo

- [ ] 15 accessor refactorizzati
- [ ] 0 errori PHPStan Level 10
- [ ] 0 warning PHPMD
- [ ] PHPInsights score > 90
- [ ] Documentazione aggiornata
- [ ] Multi-agent safe (lock file usati)

---

## 🚀 Next Steps

Dopo il completamento:

1. Eseguire quality gates (PHPStan + PHPMD + PHPInsights)
2. Aggiornare audit document
3. Creare GitHub Issue per Fase 3
4. Pianificare Fase 3 (Cleanup)

---

*Creato: 2026-04-01*  
*Ultimo aggiornamento: 2026-04-01*  
*Stato: backlog → ready-for-dev*
