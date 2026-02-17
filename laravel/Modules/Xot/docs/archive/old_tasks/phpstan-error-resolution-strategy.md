# Strategia Risoluzione Errori PHPStan - 1565 Errori

## Status Iniziale

**Data**: 2025-12-12  
**Errori Totali**: 1565  
**Obiettivo**: 0 errori  
**Approccio**: Sistematico, pattern-based, documentato

## Categorie Errori Principali

### 1. Model Static Methods Not Found (~400 errori stimati)

**Pattern:**
```
Call to an undefined static method Modules\Activity\Models\Activity::create().
Call to an undefined static method Modules\Activity\Models\Activity::where().
```

**Causa**: Models non hanno PHPDoc @mixin per Eloquent Builder  
**Fix Tipo**: Aggiungere `@mixin \Illuminate\Database\Eloquent\Builder` ai Models

**Priorità**: ALTA (blocca funzionalità base)

### 2. Translation array|string|null (~300 errori stimati)

**Pattern:**
```
Parameter #1 $label expects string|null, array|string|null given.
```

**Causa**: `__()` può restituire array se la chiave non esiste  
**Fix Tipo**: Cast a string o gestione condizionale

**Priorità**: MEDIA (non critico ma fastidioso)

### 3. Builder Method Not Found (~250 errori stimati)

**Pattern:**
```
Call to an undefined method Illuminate\Database\Eloquent\Builder::where().
```

**Causa**: PHPStan non riconosce metodi Builder dinamici  
**Fix Tipo**: PHPDoc @var annotations

**Priorità**: ALTA (molto comune)

### 4. Return Type Mismatch (~200 errori stimati)

**Pattern:**
```
Method should return int but returns mixed.
```

**Causa**: Tipi di ritorno non espliciti o troppo generici  
**Fix Tipo**: Type casting o explicit return types

**Priorità**: MEDIA

### 5. Method Non-Object (~150 errori stimati)

**Pattern:**
```
Cannot call method delete() on mixed.
```

**Causa**: Chain di metodi su tipi mixed  
**Fix Tipo**: Assertions o type guards

**Priorità**: ALTA (può causare runtime errors)

## Strategia di Risoluzione

### Fase 1: Quick Wins (Target: -500 errori)

1. **Model PHPDoc Bulk Fix**
   - Script automatico per aggiungere `@mixin` a tutti i Models
   - Stimato: -400 errori

2. **Translation Cast Fix**
   - Helper function `trans_string(): string`
   - Rimpiazza `__()` dove serve string garantito
   - Stimato: -100 errori

### Fase 2: Pattern Fixes (Target: -600 errori)

3. **Builder Type Annotations**
   - PHPDoc @var su query builder chains
   - Stimato: -250 errori

4. **Return Type Declarations**
   - Aggiungere explicit return types
   - Stimato: -200 errori

5. **Method Call Guards**
   - Type guards prima delle chiamate
   - Stimato: -150 errori

### Fase 3: Edge Cases (Target: -465 errori)

6. **Rimanenti errori specifici**
   - Fix caso per caso
   - Documentazione per pattern nuovi

## Tools e Scripts

### Script 1: Bulk Model @mixin

```bash
#!/bin/bash
# add-model-mixins.sh
find Modules -name "*php" -path "*/Models/*" -type f | while read file; do
    if ! grep -q "@mixin" "$file"; then
        # Add @mixin before class declaration
        sed -i '/^class /i /**\n * @mixin \\Illuminate\\Database\\Eloquent\\Builder\n */' "$file"
    fi
done
```

### Script 2: Count Errors by Type

```bash
#!/bin/bash
# count-errors.sh
./vendor/bin/phpstan analyse Modules --error-format=raw 2>&1 | \
  grep -oE "🪪  [a-z.]+" | \
  sort | uniq -c | sort -rn
```

## Tracking Progress

### Checkpoint 1: Iniziale
- **Data**: 2025-12-12 11:00
- **Errori**: 1565
- **Commit**: a1ee40a99

### Checkpoint 2: Post Quick Wins
- **Data**: TBD
- **Errori Target**: ~1000
- **Commit**: TBD

### Checkpoint 3: Post Pattern Fixes
- **Data**: TBD
- **Errori Target**: ~400
- **Commit**: TBD

### Checkpoint 4: Finale
- **Data**: TBD
- **Errori**: 0 ✅
- **Commit**: TBD

## Regole di Lavoro

1. **MAI committare codice che aumenta gli errori**
2. **SEMPRE testare dopo ogni batch di fix**
3. **SEMPRE documentare pattern nuovi scoperti**
4. **Fare commit ogni -50 errori circa**
5. **Validare con phpstan + phpmd + phpinsights**

## Next Steps

1. [ ] Eseguire Script 1 per Models bulk fix
2. [ ] Creare helper trans_string()
3. [ ] Fix Activity module (punto di partenza)
4. [ ] Fix Cms module
5. [ ] Fix Geo module
6. [ ] Fix Notify module
7. [ ] Fix TechPlanner module
8. [ ] Fix User module
9. [ ] Fix UI module
10. [ ] Fix rimanenti moduli

## Referencias

- PHPStan Documentation: https://phpstan.org/
- Laravel & PHPStan: https://github.com/larastan/larastan
- Eloquent Type Hints: https://laravel.com/docs/eloquent

---

**Mantenuto da**: Claude Sonnet 4.5  
**Ultimo aggiornamento**: 2025-12-12
