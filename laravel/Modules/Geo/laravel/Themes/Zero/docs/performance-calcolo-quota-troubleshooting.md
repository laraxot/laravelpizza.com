# Troubleshooting Calcolo Quota Performance

## Problema: Discrepanza Quota Distribuita

### Sintomo

Nel report calcolo quota appare una discrepanza tra:
- **Quota totale** (es: 285.209,90)
- **Quota distribuita** (es: 278.542,20)
- **Diff** (es: 6.667,70 ≈ 2,34%)

## Cause Probabilistiche (in ordine di frequenza)

### 1. Campi Non Materializzati (90% dei casi)

Il calcolo SQL usa campi che potrebbero essere NULL:

```sql
-- Questi campi DEVONO essere valorizzati prima del calcolo
- gg_presenza_dalal
- perc_parttimepond_dalal
- totale_punteggio
- gg_assenza_dalal
- hh_assenza_dalal
```

**Verifica rapida:**
```sql
SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN gg_presenza_dalal IS NULL THEN 1 ELSE 0 END) as null_gg,
    SUM(CASE WHEN perc_parttimepond_dalal IS NULL THEN 1 ELSE 0 END) as null_pt
FROM performance_organizzativa 
WHERE anno = '2025' AND type = 'dip' AND ha_diritto > 0;
```

**Soluzione:**
Eseguire le action di materializzazione **prima** del calcolo quota.

### 2. Arrotondamenti Cumulativi (5% dei casi)

La pipeline usa molteplici divisioni/moltiplicazioni:
```
delta = quota * 365 / tot_giorni_pt_coeff
quota_teorica = delta * coeff
budget_assegnato = quota_teorica / 365 * ...
```

Errore cumulativo tipico: 0,1-0,5%

### 3. Record con Punteggio Zero (3% dei casi)

Se `totale_punteggio = 0` o NULL:
- `quota_effettiva` diventa 0
- `resti = budget_assegnato - 0 = budget_assegnato`
- Diff aumenta proporzionalmente

### 4. Altri Problemi (2% dei casi)

- Inconsistenze nei coefficienti
- Record esclusi da alcune query ma non da altre
- Problemi di precisione FLOAT vs DECIMAL

## Checklist Operativa

Prima di ogni calcolo quota, verificare:

- [ ] Nessun record con `gg_presenza_dalal IS NULL`
- [ ] Nessun record con `perc_parttimepond_dalal IS NULL`
- [ ] Nessun record con `totale_punteggio IS NULL` (se usato)
- [ ] Diff finale < 1% (accettabile) o < 0,5% (ottimale)

## Azioni Correttive

### Se la diff è > 5%

1. **STOP** - Non procedere con la distribuzione
2. Eseguire `UpdateGgPresenzaDalalAction`
3. Eseguire `UpdatePercParttimepondDalalAction`
4. Ricalcolare e verificare diff

### Se la diff è 1-5%

1. Verificare record con `totale_punteggio = 0`
2. Se accettabile, procedere con nota nel log
3. Monitorare trend mensile

### Se la diff è < 1%

1. Accettabile per arrotondamenti
2. Procedere con distribuzione

## Documentazione Tecnica

Per approfondimenti:
- [Discrepanza Calcolo Quota (modulo Performance)](../../Modules/Performance/docs/discrepanza-calcolo-quota.md)
- [Performance Actions Reference](./performance-actions-reference.md)

## Note

Il tema Zero **non** partecipa al calcolo - riceve solo i dati già calcolati dal modulo Performance.

Qualsiasi discrepanza deve essere risolta a livello di:
1. Materializzazione dati (Actions)
2. Pipeline di calcolo (SQL)
3. Validazione pre-calcolo

Non a livello di presentazione (tema).
