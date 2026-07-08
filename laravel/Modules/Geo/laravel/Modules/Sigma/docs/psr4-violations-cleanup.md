# PSR-4 Violations - File Template da Rimuovere

## 🚨 File che Violano PSR-4

### 1-2. SchedaTrait Template Files

**File**:
- `Modules/Sigma/app/Models/Traits/SchedaTrait_FINAL_TEMPLATE.php`
- `Modules/Sigma/app/Models/Traits/SchedaTrait_CLEAN.php`

**Problema**: 
Classe `Modules\Sigma\Models\Traits\SchedaTrait` NON matcha filename (suffisso `_CLEAN`, `_FINAL_TEMPLATE`)

**PSR-4 Violation**:
```
Namespace: Modules\Sigma\Models\Traits\SchedaTrait
Filename: SchedaTrait_FINAL_TEMPLATE.php  ← MISMATCH!
Expected: SchedaTrait.php
```

**Analisi**:
- Sono file di **LAVORO/TEMPLATE** non production
- Esistono **backup multipli** dello SchedaTrait principale (vedi `.backup-*`)
- File `SchedaTrait.php` principale esiste ed è up-to-date

**Raccomandazione**: ✅ **ELIMINARE** i file template

### Rationale Eliminazione

**FILOSOFIA**: Template files NON appartengono a production codebase

**RELIGIONE PSR-4**: Un file PHP = una classe, filename = classname

**POLITICA**: 
- Template/examples → `docs/examples/` o `docs/templates/`
- Backup → `.git` history o `bashscripts/backups/`
- Production code → SOLO file attivi

**ZEN**: _"Il template è una fase, non una destinazione"_

### Azione Raccomandata

```bash
cd laravel

# Opzione 1: Elimina (raccomandato)
rm Modules/Sigma/app/Models/Traits/SchedaTrait_CLEAN.php
rm Modules/Sigma/app/Models/Traits/SchedaTrait_FINAL_TEMPLATE.php

# Opzione 2: Sposta in docs (se utili come reference)
mkdir -p Modules/Sigma/docs/templates
mv Modules/Sigma/app/Models/Traits/SchedaTrait_CLEAN.php \
   Modules/Sigma/docs/templates/
mv Modules/Sigma/app/Models/Traits/SchedaTrait_FINAL_TEMPLATE.php \
   Modules/Sigma/docs/templates/
```

**Verifica**: Nessun codice production usa questi file
```bash
grep -r "SchedaTrait_CLEAN\|SchedaTrait_FINAL_TEMPLATE" \
  Modules/Sigma/app/ --include="*.php"
# Output vuoto = safe to delete
```

---

## 📋 Cleanup Status

- [ ] SchedaTrait_CLEAN.php - Da eliminare
- [ ] SchedaTrait_FINAL_TEMPLATE.php - Da eliminare  
- [ ] Backup files (.backup-*) - Considerare cleanup (mantieni ultimi 3)

---

**Documento creato**: Gennaio 2025  
**Priority**: P2 - MINOR (non blocca application)  
**Type**: Cleanup / Technical Debt  
**Azione**: Elimina file template da production codebase

