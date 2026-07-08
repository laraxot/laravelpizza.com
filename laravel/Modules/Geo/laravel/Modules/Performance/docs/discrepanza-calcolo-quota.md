# Discrepanza nel Calcolo Quota - Analisi e Soluzioni

## Problema

Nel calcolo delle quote performance per l'anno 2025 (tipo "dip") si osserva una discrepanza significativa:

| Valore | Importo |
|--------|----------|
| Quota totale | 285.209,90 |
| Quota distribuita | 278.542,20 |
| **Diff** | **6.667,70** |
| **% Diff** | **2,34%** |

## Fonti di Discrepanza

### 1. Campi Non Materializzati (NULL o 0)

La discrepanza più comune è causata da record con campi calcolati non ancora materializzati:

```sql
-- Record con gg_presenza_dalal NULL o 0
SELECT COUNT(*) FROM performance_organizzativa 
WHERE anno = '2025' AND type = 'dip' AND ha_diritto > 0
AND (gg_presenza_dalal IS NULL OR gg_presenza_dalal = 0);

-- Record con perc_parttimepond_dalal NULL
SELECT COUNT(*) FROM performance_organizzativa 
WHERE anno = '2025' AND type = 'dip' AND ha_diritto > 0
AND perc_parttimepond_dalal IS NULL;

-- Record con totale_punteggio NULL o 0
SELECT COUNT(*) FROM performance_organizzativa 
WHERE anno = '2025' AND type = 'dip' AND ha_diritto > 0
AND (totale_punteggio IS NULL OR totale_punteggio = 0);
```

**Impatto:** Se `gg_presenza_dalal` o `perc_parttimepond_dalal` sono NULL:
- `tot_giorni_pt` sottostimato
- `budget_assegnato` sottostimato
- Quota distribuita < Quota totale

### 2. Arrotondamenti in Cascata

La pipeline di calcolo usa molteplici operazioni con arrotondamenti:

```
delta = quota * 365 / tot_giorni_pt_coeff  ← Divisione float
quota_teorica = delta * coeff                ← Moltiplicazione
budget_assegnato = quota_teorica / 365 * ... ← Divisione + moltiplicazione
quota_effettiva = ... / 365 * ...            ← Altra divisione
```

**Impatto:** Ogni arrotondamento introduce piccoli errori che si sommano.

### 3. Formula Quota Effettiva

```sql
quota_effettiva = quota_teorica / 365 * 
    ((totale_punteggio/100) * 1 * 
     (gg_presenza_dalal - (gg_assenza_dalal + round(hh_assenza_dalal/6.0,0))) * 
     perc_parttimepond_dalal)
```

**Problemi potenziali:**
- `totale_punteggio = 0` → quota_effettiva = 0 (ma budget_assegnato > 0)
- `hh_assenza_dalal/6.0` arrotondato per difetto → giorni sottostimati
- Risultato: `resti = budget_assegnato - 0 = budget_assegnato`

### 4. Record Esclusi dal Calcolo

Query controllano `ha_diritto > 0` ma la distribuzione finale potrebbe includere/escludere record diversi:

```sql
-- Update budget_assegnato (ha_diritto > 0)
-- vs
-- Update quota_teorica (tutti i record con type = 'dip')
```

## Soluzioni Proposte

### Soluzione A: Materializzazione Completa

**Prima** di eseguire i calcoli economici, assicurarsi che tutti i campi siano materializzati:

```php
// In OrganizzativaMoney o script pre-calcolo
app(UpdateGgPresenzaDalalAction::class)->execute('2025', 'dip');
app(UpdatePercParttimepondDalalAction::class)->execute('2025', 'dip');
app(UpdateAssenzeAction::class)->execute('2025', 'dip'); // se esiste
```

**Verifica:**
```sql
-- Controlla record ancora da materializzare
SELECT 
    SUM(CASE WHEN gg_presenza_dalal IS NULL THEN 1 ELSE 0 END) as null_gg,
    SUM(CASE WHEN perc_parttimepond_dalal IS NULL THEN 1 ELSE 0 END) as null_pt,
    SUM(CASE WHEN totale_punteggio IS NULL THEN 1 ELSE 0 END) as null_punt
FROM performance_organizzativa 
WHERE anno = '2025' AND type = 'dip' AND ha_diritto > 0;
```

### Soluzione B: Validazione Pre-Calcolo

Aggiungere un controllo che blocchi il calcolo se ci sono campi NULL:

```php
public function validateBeforeCalculate(string $year, string $type): array
{
    $issues = [];
    
    $nullGg = Scheda::where('anno', $year)
        ->where('type', $type)
        ->where('ha_diritto', '>', 0)
        ->whereNull('gg_presenza_dalal')
        ->count();
    
    $nullPt = Scheda::where('anno', $year)
        ->where('type', $type)
        ->where('ha_diritto', '>', 0)
        ->whereNull('perc_parttimepond_dalal')
        ->count();
    
    if ($nullGg > 0) {
        $issues[] = "$nullGg record senza gg_presenza_dalal";
    }
    if ($nullPt > 0) {
        $issues[] = "$nullPt record senza perc_parttimepond_dalal";
    }
    
    return $issues;
}
```

### Soluzione C: Arrotondamento Delta

Modificare il calcolo del delta per ridurre l'errore cumulativo:

```sql
-- Attuale (usare come riferimento)
delta = quota * 365 / tot_giorni_pt_coeff

-- Alternativa con maggiore precisione
-- Calcolare delta con DECIMAL(15,8) invece di FLOAT
```

### Soluzione D: Controllo Redistribuzione

Aggiungere una fase di "aggiustamento" finale:

```sql
-- Dopo aver calcolato tutti i campi, verificare la diff
-- Se diff > threshold, ridistribuire proporzionalmente
```

### Soluzione E: Logging Dettagliato

Aggiungere più granularità nei log per identificare quali record contribuiscono alla diff:

```sql
-- Query per identificare record problematici
SELECT 
    id, ente, matr,
    budget_assegnato,
    quota_effettiva,
    resti,
    (resti / budget_assegnato * 100) as resti_pct
FROM performance_organizzativa 
WHERE anno = '2025' AND type = 'dip' AND ha_diritto > 0
ORDER BY ABS(resti) DESC
LIMIT 20;
```

## Checklist Diagnostica

Prima di ogni calcolo quota, verificare:

- [ ] `UpdateGgPresenzaDalalAction` eseguita (no NULL, no 0)
- [ ] `UpdatePercParttimepondDalalAction` eseguita (no NULL)
- [ ] `totale_punteggio` calcolato per tutti i record (no NULL)
- [ ] Conteggio record `ha_diritto > 0` coerente tra le query
- [ ] Diff < 0,5% (accettabile) o < 0,1% (ottimale)

## Raccomandazioni

1. **Priorità 1:** Eseguire sempre le action di materializzazione prima dei calcoli economici
2. **Priorità 2:** Aggiungere validazione che blocchi calcolo se campi NULL > 0
3. **Priorità 3:** Implementare logging granularità singolo record per debug
4. **Priorità 4:** Considerare DECIMAL al posto di FLOAT per calcoli monetari

## Note Architetturali

La discrepanza è un **sintomo** di dati incompleti, non un bug del calcolo.

Il sistema è progettato per:
- Separare materializzazione dati (Actions) da calcolo economico (SQL)
- Permettere ricalcolo parziale senza riprocessare tutto
- Mantenere tracciabilità dei valori intermedi

Quando la diff è alta (>1%), il problema è quasi sempre nella **pipeline di materializzazione**, non nelle formule SQL.

## Collegamenti

- [Update Gg Presenza Dalal](./action-update-gg-presenza-dalal.md)
- [Update Perc Part-time](./action-update-perc-parttimepond-dalal.md)
- [Model Fillable Checklist](./model-fillable-checklist.md)
- [Performance actions reference nel tema Zero](../../Themes/Zero/docs/performance-actions-reference.md)
