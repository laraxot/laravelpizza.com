# 🔍 Accessor Delegation Audit - Sigma Module

> **Audit completo: Metodo puro VICINO all'accessor**
> **Aggiornato**: 2026-04-01
> **Stato**: ✅ **FASE 1 COMPLETATA** + ✅ **FASE 2 COMPLETATA** (21/21 accessor refactorizzati)
> **AI Agent**: @qwen
> **Commit**: `8955a7326`

---

## 📊 Panoramica

**File Analizzati**:
- `laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php` (2935 righe)
- `laravel/Modules/Sigma/app/Models/Traits/Mutators/SchedaMutator.php` (670 righe)

**Totale Accessor**: ~83  
**Conforme al Pattern**: ~71 (85%) ⬆️⬆️  
**Da Correggere**: ~12 (15%) ⬇️⬇️  
**Completati Oggi**: 21 ✅✅

---

## ✅ Accessor CONFORMI (Pattern Corretto) - AGGIORNATO COMPLETO

Questi accessor **HANNO** il metodo puro vicino e seguono il pattern corretto:

| # | Accessor | Metodo Puro | File | Stato |
|---|----------|-------------|------|-------|
| 1-33 | (vedi audit precedente - originali) | Vari | SchedaTrait | ✅ |
| 34 | `getGgFuoriSedeNoAszAttribute` | `getGgFuoriSedeNoAsz()` | SchedaTrait | ✅ **FASE 1** |
| 35 | `getValutatoreTxtAttribute` | `getValutatoreTxt()` | SchedaTrait | ✅ **FASE 1** |
| 36 | `getPosizioneAttribute` | `getPosizione()` | SchedaTrait | ✅ **FASE 1** |
| 37 | `getAventiDirittoAttribute` | `getAventiDiritto()` | SchedaTrait | ✅ **FASE 1** |
| 38 | `getAventiDirittoEffAttribute` | `getAventiDirittoEff()` | SchedaTrait | ✅ **FASE 1** |
| 39 | `getGgAszCatecoPosfunAttribute` | `getGgAszCatecoPosfun()` | SchedaTrait | ✅ **FASE 1** |
| 40 | `getGgCatecoNoPosfunNoAszAttribute` | `getGgCatecoNoPosfunNoAsz()` | SchedaTrait | ✅ **FASE 2** |
| 41 | `getGgCatecoSupAttribute` | `getGgCatecoSup()` | SchedaTrait | ✅ **FASE 2** |
| 42 | `getGgCatecoSupInSedeAttribute` | `getGgCatecoSupInSede()` | SchedaTrait | ✅ **FASE 2** |
| 43 | `getGgCatecoSupFuoriSedeAttribute` | `getGgCatecoSupFuoriSede()` | SchedaTrait | ✅ **FASE 2** |
| 44 | `getListaProproAttribute` | `getListaPropro()` | SchedaTrait | ✅ **FASE 2** |
| 45 | `getListaProproSupAttribute` | `getListaProproSup()` | SchedaTrait | ✅ **FASE 2** |
| 46 | `getImportoStipendioAnnuoAttribute` | `getImportoStipendioAnnuo()` | SchedaTrait | ✅ **FASE 2** |
| 47 | `getCodquaAttribute` | `getCodqua()` | SchedaMutator | ✅ **FASE 2** |
| 48 | `getContAttribute` | `getCont()` | SchedaMutator | ✅ **FASE 2** |
| 49 | `getTipcoAttribute` | `getTipco()` | SchedaMutator | ✅ **FASE 2** |
| 50 | `getPosizioneEcoAttribute` | `getPosizioneEco()` | SchedaMutator | ✅ **FASE 2** |
| 51 | `getPercParttimepondAnnoAttribute` | `getPercParttimepondAnno()` | SchedaMutator | ✅ **FASE 2** |
| 52 | `getPercParttimepondDalalAttribute` | `getPercParttimepondDalal()` | SchedaMutator | ✅ **FASE 2** |
| 53 | `getDisci1TxtAttribute` | `getDisci1Txt()` | SchedaMutator | ✅ **FASE 2** |
| 54 | `getEtaAttribute` | `getEta()` | SchedaMutator | ✅ **FASE 2** |

**Note**:
- Questi accessor seguono il pattern corretto: metodo puro + accessor con cache/guard/delega/persist
- La maggior parte sono in SchedaTrait.php tra le righe 100-2600
- Alcuni usano il pattern `funcYear()` per i performance indicator (OK, pattern specializzato)

---

## ❌ Accessor DA CORREGGERE (Pattern SBAGLIATO)

Questi accessor **NON HANNO** il metodo puro vicino o fanno calcolo diretto:

### Categoria 1: Calcolo Diretto (Nessun Metodo Puro)

| # | Accessor | File | Righe | Problema | Priorità |
|---|----------|------|-------|----------|----------|
| 1 | ~~`getGgFuoriSedeNoAszAttribute`~~ | ~~SchedaTrait~~ | ~~450~~ | ~~Calcolo diretto~~ | ✅ **COMPLETATO** |
| 2 | ~~`getValutatoreTxtAttribute`~~ | ~~SchedaTrait~~ | ~~320~~ | ~~Calcolo diretto~~ | ✅ **COMPLETATO** |
| 3 | ~~`getPosizioneAttribute`~~ | ~~SchedaTrait~~ | ~~330~~ | ~~Calcolo diretto~~ | ✅ **COMPLETATO** |
| 4 | ~~`getAventiDirittoAttribute`~~ | ~~SchedaTrait~~ | ~~1750~~ | ~~Calcolo diretto + debug echo~~ | ✅ **COMPLETATO** |
| 5 | ~~`getAventiDirittoEffAttribute`~~ | ~~SchedaTrait~~ | ~~1790~~ | ~~Calcolo diretto + debug echo~~ | ✅ **COMPLETATO** |
| 6 | ~~`getGgAszCatecoPosfunAttribute`~~ | ~~SchedaTrait~~ | ~~1620~~ | ~~Calcolo diretto~~ | ✅ **COMPLETATO** |
| 7 | `getGgCatecoNoPosfunNoAszAttribute` | SchedaTrait | ~1600 | Calcolo diretto: sottrazione | 🟡 Media |
| 8 | `getGgCatecoSupAttribute` | SchedaTrait | ~1500 | Calcolo diretto: somma sup_in_sede + sup_fuori_sede | 🟡 Media |
| 9 | `getGgCatecoSupInSedeAttribute` | SchedaTrait | ~1520 | Calcolo diretto: delega ad anag ma nessun metodo puro | 🟡 Media |
| 10 | `getGgCatecoSupFuoriSedeAttribute` | SchedaTrait | ~1800 | Calcolo diretto: delega ad anag ma nessun metodo puro | 🟡 Media |
| 11 | `getGgAszTipCodEsclusoSubitoAttribute` | SchedaTrait | ~2900 | Return null diretto | 🟢 Bassa |
| 12 | `getListaProproAttribute` | SchedaTrait | ~2500 | Calcolo diretto: delega a categoria | 🟡 Media |
| 13 | `getListaProproSupAttribute` | SchedaTrait | ~2510 | Calcolo diretto: delega a categoria | 🟡 Media |
| 14 | `getImportoStipendioAnnuoAttribute` | SchedaTrait | ~2800 | Calcolo diretto: delega a stipendioTabellare | 🟡 Media |

### Categoria 2: Pattern Specializzati (OK ma Documentare)

| # | Accessor | File | Righe | Pattern | Stato |
|---|----------|------|-------|---------|-------|
| 1 | `getPerfInd2030Attribute` ... `getPerfInd2014Attribute` | SchedaTrait | ~3200-3400 | Usano `funcYear()` (metodo helper generico) | ✅ OK |
| 2 | `getPostTypeAttribute` | SchedaTrait | ~250 | Logica complessa con config | 🟡 Da refactor |
| 3 | `getAventiDirittoAttribute` | SchedaTrait | ~1650 | Logica complessa con echo debug | 🔴 Da cleanup |
| 4 | `getAventiDirittoEffAttribute` | SchedaTrait | ~1680 | Logica complessa con echo debug | 🔴 Da cleanup |

### Categoria 3: In SchedaMutator (Separati)

| # | Accessor | File | Problema | Priorità |
|---|----------|------|----------|----------|
| 1 | `getCodquaAttribute` | SchedaMutator | ~100 | Calcolo diretto, nessun metodo puro | 🟡 Media |
| 2 | `getContAttribute` | SchedaMutator | ~130 | Calcolo diretto, nessun metodo puro | 🟡 Media |
| 3 | `getTipcoAttribute` | SchedaMutator | ~170 | Calcolo diretto, nessun metodo puro | 🟡 Media |
| 4 | `getPosizioneEcoAttribute` | SchedaMutator | ~200 | Calcolo diretto, nessun metodo puro | 🟡 Media |
| 5 | `getPercParttimepondAnnoAttribute` | SchedaMutator | ~280 | Calcolo diretto, nessun metodo puro | 🟡 Media |
| 6 | `getPercParttimepondDalalAttribute` | SchedaMutator | ~320 | Calcolo diretto, nessun metodo puro | 🟡 Media |
| 7 | `getDisci1TxtAttribute` | SchedaMutator | ~380 | Calcolo diretto, nessun metodo puro | 🟡 Media |
| 8 | `getPosizTxtAttribute` | SchedaMutator | ~430 | ✅ Pattern OK (set attributes direttamente) | ✅ OK |
| 9 | `getDisci1Attribute` | SchedaMutator | ~480 | 🟡 Parzialmente OK | 🟡 Media |
| 10 | `getCategoriaEcovalAttribute` | SchedaMutator | ~510 | 🟡 Parzialmente OK | 🟡 Media |
| 11 | `getPosizAttribute` | SchedaMutator | ~540 | 🟡 Parzialmente OK | 🟡 Media |
| 12 | `getEtaAttribute` | SchedaMutator | ~580 | Calcolo diretto, nessun metodo puro | 🟡 Media |
| 13 | `getTypeAttribute` | SchedaMutator | ~630 | ✅ Ha `getWorkerType()` | ✅ OK |

---

## 📋 Piano di Refactoring

### Fase 1: Priorità Alta (🔴) - ✅ COMPLETATA

**Obiettivo**: 6 accessor critici

- [x] ✅ `getGgFuoriSedeNoAszAttribute` → **COMPLETATO** (Commit: `53248cfec`)
- [x] ✅ `getValutatoreTxtAttribute` → **COMPLETATO** (Commit: `53248cfec`)
- [x] ✅ `getPosizioneAttribute` → **COMPLETATO** (Commit: `c4e3c502c`)
- [x] ✅ `getAventiDirittoAttribute` → **COMPLETATO** + cleanup debug echo (Commit: `c4e3c502c`)
- [x] ✅ `getAventiDirittoEffAttribute` → **COMPLETATO** + cleanup debug echo (Commit: `c4e3c502c`)
- [x] ✅ `getGgAszCatecoPosfunAttribute` → **COMPLETATO** (Commit: `c4e3c502c`)

**Stato**: 6/6 completati (100%)  
**Quality Gates**: PHPStan Level 10 ✅  
**Commit**: `53248cfec`, `c4e3c502c`

### Fase 2: Priorità Media (🟡) - ✅ COMPLETATA

**Obiettivo**: 15 accessor

**Completati (15)**:
- [x] ✅ `getGgCatecoNoPosfunNoAszAttribute` → **COMPLETATO** (Commit: `58dd1fc15`)
- [x] ✅ `getGgCatecoSupAttribute` → **COMPLETATO** (Commit: `58dd1fc15`)
- [x] ✅ `getGgCatecoSupInSedeAttribute` → **COMPLETATO** (Commit: `58dd1fc15`)
- [x] ✅ `getGgCatecoSupFuoriSedeAttribute` → **COMPLETATO** (Commit: `58dd1fc15`)
- [x] ✅ `getListaProproAttribute` → **COMPLETATO** (Commit: `58dd1fc15`)
- [x] ✅ `getListaProproSupAttribute` → **COMPLETATO** (Commit: `58dd1fc15`)
- [x] ✅ `getImportoStipendioAnnuoAttribute` → **COMPLETATO** (Commit: `58dd1fc15`)
- [x] ✅ `getCodquaAttribute` → **COMPLETATO** (Commit: `8955a7326`)
- [x] ✅ `getContAttribute` → **COMPLETATO** (Commit: `8955a7326`)
- [x] ✅ `getTipcoAttribute` → **COMPLETATO** (Commit: `8955a7326`)
- [x] ✅ `getPosizioneEcoAttribute` → **COMPLETATO** (Commit: `8955a7326`)
- [x] ✅ `getPercParttimepondAnnoAttribute` → **COMPLETATO** (Commit: `8955a7326`)
- [x] ✅ `getPercParttimepondDalalAttribute` → **COMPLETATO** (Commit: `8955a7326`)
- [x] ✅ `getDisci1TxtAttribute` → **COMPLETATO** (Commit: `8955a7326`)
- [x] ✅ `getEtaAttribute` → **COMPLETATO** (Commit: `8955a7326`)

**Stato**: 15/15 completati (100%)  
**Quality Gates**: PHPStan Level 10 ✅  
**Commit**: `58dd1fc15`, `8955a7326`

### Totale Complessivo

**Fase 1 + Fase 2**: 21/21 accessor refactorizzati (100%) ✅  
**Conforme al Pattern**: 71/83 (85%)  
**Restanti**: 12 (15%) - pattern specializzati o legacy (non prioritari)

### Fase 3: Priorità Bassa (🟢) - Cleanup (Opzionale)

- [ ] `getGgAszTipCodEsclusoSubitoAttribute` → Rimuovere o documentare
- [ ] Documentare pattern `funcYear()` per performance indicator
- [ ] Aggiornare documentazione

**Stima**: 1-2 ore  
**GitHub Issue**: #ZZZ (opzionale)

---

## 🧪 Criteri di Accettazione

Per ogni accessor refactorato, verificare:

- [ ] Metodo puro `get<Nome>()` creato entro 50 righe dall'accessor
- [ ] Metodo puro ha solo calcolo (nessun side effect)
- [ ] Accessor ha cache/guard/delega/persist
- [ ] Entrambi nello stesso file (SchedaMutator.php o SchedaTrait.php)
- [ ] PHPStan Level 10: nessun errore
- [ ] PHPMD: nessun warning
- [ ] PHPInsights: score > 90
- [ ] Test Pest: accessor persiste correttamente

---

## 📝 Template per Refactoring

Per ogni accessor da correggere, usare questo template:

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

## 🔗 Riferimenti

- [Accessor Delegation Pattern](accessor-delegation-pattern.md)
- [Accessor/Mutator Philosophy](accessor-mutator-philosophy.md)
- [SchedaTrait Accessor Pattern](scheda-trait-accessor-pattern.md)

---

*Documento creato: 2026-04-01*
*Ultimo aggiornamento: 2026-04-01*
*Stato: 🟡 In Progress*
*Multi-Agent Safe: Usare per coordinare refactoring*
