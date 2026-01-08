# Audit Cross-Modules: Accessor con save() senza Guard

## Obiettivo Audit

Verificare **TUTTI i moduli** per accessor che chiamano `save()` senza guard `if (null == $this->getKey())`.

## Moduli Identificati con Accessor

### Distribuzione Accessor nel Progetto

| Modulo | Files con Accessor | Priorità Audit |
|--------|-------------------|----------------|
| Sigma | 20 | ✅ FATTO |
| IndennitaCondizioniLavoro | 11 | 🔴 ALTA |
| Progressioni | 5 | 🔴 ALTA |
| User | 4 | 🟠 MEDIA |
| Ptv | 4 | 🟠 MEDIA |
| Performance | 4 | 🔴 ALTA |
| IndennitaResponsabilita | 4 | 🔴 ALTA |
| Rating | 2 | 🟡 BASSA |
| Notify | 2 | 🟡 BASSA |
| Media | 2 | 🟡 BASSA |
| Job | 2 | 🟡 BASSA |
| Incentivi | 2 | 🟡 BASSA |
| Xot | 1 | 🟡 BASSA |
| Tenant | 1 | 🟡 BASSA |
| Lang | 1 | 🟡 BASSA |

## Status Audit per Modulo

### ✅ Sigma - COMPLETATO
- **File**: SchedaTrait.php
- **Accessor con save()**: 83
- **Guard aggiunti**: 15 (nei refactoring)
- **Rimanenti**: 68 (da completare refactoring)
- **Status**: 🟢 Pattern corretto implementato

### ⏳ IndennitaCondizioniLavoro - DA VERIFICARE

**File Principali**:
1. `Models/CondizioniLavoro.php`
   - ✅ getTotAttribute - HA GIÀ guard! (linea 283)
2. `Models/ServizioEsterno.php` - Da verificare
3. `Models/CondizioniLavoroAdm.php` - Da verificare  
4. `Models/CondizioniLavoroRep.php` - Da verificare
5. `Models/Traits/MutatorTrait.php` - Da verificare

**Prossima Azione**: Audit sistematico

### ⏳ Performance - DA VERIFICARE

**File Principali**:
1. `Models/Traits/MutatorTrait.php` - Verificato: NO accessor
2. `Models/Traits/FunctionTrait.php` - Da verificare
3. `Models/StabiDirigente.php` - Da verificare
4. `Models/IndividualeAssenze.php` - Da verificare
5. `Models/IndividualeDecurtazioneAssenze.php` - Da verificare

### ⏳ Progressioni - DA VERIFICARE

**File Principali**:
1. `Models/Schede.php` - Da verificare
2. `Models/Pesi.php` - Da verificare
3. `Models/MaxCatecoPosfunAnno.php` - Da verificare

### ⏳ IndennitaResponsabilita - DA VERIFICARE

**File Principali**:
1. `Models/Traits/MutatorTrait.php` - Verificato: NO accessor
2. `Models/LettI.php` - Da verificare
3. `Models/LettF.php` - Da verificare

## Strategia Audit

### Approccio Sistematico

**Per ogni modulo (in ordine priorità)**:

1. **Preparazione**:
   - [ ] Studiare docs modulo esistenti
   - [ ] Comprendere business logic
   - [ ] Identificare file con accessor

2. **Analisi**:
   - [ ] Leggere ogni accessor
   - [ ] Identificare quali chiamano save()/update()
   - [ ] Verificare presenza guard getKey()

3. **Documentazione**:
   - [ ] Creare/aggiornare doc in modulo
   - [ ] Documentare accessor problematici
   - [ ] Piano di fix

4. **Implementazione**:
   - [ ] Applicare guard dove mancano
   - [ ] Testare (se possibile)
   - [ ] Verificare no regression

5. **Completamento**:
   - [ ] Aggiornare audit tracker
   - [ ] Collegamenti documentazione
   - [ ] Next modulo

### Timeline Stimata

**Settimana 1** (giorni 1-5):
- Sigma: ✅ FATTO (15/83 refactorati con guard)
- IndennitaCondizioniLavoro: Audit + Fix
- Performance: Audit + Fix

**Settimana 2** (giorni 6-10):
- Progressioni: Audit + Fix
- IndennitaResponsabilita: Audit + Fix
- User: Audit + Fix

**Settimana 3** (giorni 11-15):
- Ptv: Audit + Fix
- Altri moduli minori
- Cleanup e documentazione finale

## Template Documentazione Modulo

Ogni modulo deve avere:

```markdown
# Accessor Guard Audit - Modulo {Nome}

## Accessor con save()

### File: {filename}

#### Accessor Verificati

1. **get{Nome}Attribute** (linea X)
   - Guard PK: ✅ Presente / ❌ Mancante
   - Pattern: Calcolo / Delegazione / Aggregazione
   - Action: Nessuna / Aggiungere guard / Refactorare

## Implementazione Fix

### Guard Aggiunti

[Lista accessor fixati]

## Test

[Test per verificare guard]

## Collegamenti

- [Regola Globale](../../Xot/docs/accessor-save-guard-global-rule.md)
```

## Metriche Target

### Obiettivi Audit Completo

- [ ] 100% moduli auditati
- [ ] 100% accessor con save() identificati
- [ ] 100% guard aggiunti dove necessari
- [ ] 80%+ accessor refactorati pattern puro
- [ ] 100% documentazione aggiornata

### KPI Success

| Metrica | Prima | Target | Attuale |
|---------|-------|--------|---------|
| Moduli auditati | 0/15 | 15/15 | 1/15 |
| Guard mancanti identificati | ? | 0 | ? |
| Guard aggiunti | 0 | 100% | 15 (Sigma) |
| Accessor refactorati | 0 | >70% | 15 |

## Collegamenti

- [Regola Globale](./accessor-save-guard-global-rule.md)
- [Sigma Implementation](../../Sigma/docs/fix-duplicate-entry-error-summary.md)
- [Pattern Template](../../Sigma/docs/accessor-refactoring-philosophy.md)

---

**Creato**: 2025-01-29  
**Status**: 📊 Audit Framework Pronto  
**Prossimo**: Audit IndennitaCondizioniLavoro  
**Timeline**: 3 settimane per audit completo

