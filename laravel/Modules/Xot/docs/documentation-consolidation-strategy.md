# Strategia di Consolidamento Documentazione - Moduli Laraxot

## 🎯 Obiettivo

**RIDURRE** il numero di file documentation da **migliaia** a **~10 file focalizzati per modulo**, seguendo i principi **KISS** e **DRY**.

## 📊 Stato Attuale (2025-11-04)

| Modulo | File .md Attuali | Target | Riduzione Necessaria |
|--------|------------------|--------|---------------------|
| **Xot** | 2,560 | 10-15 | -99.4% |
| **Notify** | 701 | 8-10 | -98.6% |
| **UI** | 375 | 8-10 | -97.3% |
| **User** | 510 | 8-10 | -98.0% |
| **Altri 32 moduli** | ~1,121 | ~200 | ~82% |
| **TOTALE** | **~5,267** | **~350** | **~93.4%** |

## 🚫 Violazioni Identificate

### 1. File con Nomi NON Conformi
```bash
# ❌ UPPERCASE (vietato)
CODE_QUALITY_STANDARDS.md
BUSINESS_LOGIC_ANALYSIS.md
MODEL_INHERITANCE_AUDIT.md

# ✅ Dovrebbero essere:
code-quality-standards.md
business-logic-analysis.md
model-inheritance-audit.md
```

### 2. File con Date (vietato)
```bash
# ❌ Date nel nome
merge-conflict-resolution-2025-11-04.md
lessons-learned-2025-11-04-merge-conflicts.md
phpstan-analysis-2025-08-18.md

# ✅ Usare CHANGELOG.md invece
# Oppure nomi generici aggiornati:
merge-conflict-resolution.md (latest)
lessons-learned.md (with dates in content)
phpstan-analysis.md (current)
```

### 3. Duplicazioni underscore/hyphen
```bash
# ❌ Duplicati
actions_structure.md
actions-structure.md

auth_pages.md
auth-pages.md

# ✅ Mantenere solo hyphen (kebab-case)
actions-structure.md
auth-pages.md
```

### 4. File Eccessivamente Specifici
```bash
# ❌ Troppo granulari
analisi-dettagliata-1.md
analisi-dettagliata-2.md
analisi-dettagliata-3.md
...
analisi-dettagliata-6.md

# ✅ Consolidare in:
comprehensive-analysis.md
```

## 📋 Struttura Target per Modulo

### Template Minimalista (5-10 files)

```
Modules/ModuleName/docs/
├── README.md                 # Entry point - scopo, quick start, correzioni recenti
├── architecture.md           # Architettura tecnica e pattern
├── business-logic.md         # Regole business e WHY
├── configuration.md          # Setup e configurazione
├── api.md                   # API documentation (se applicabile)
├── testing.md               # Testing guidelines
├── troubleshooting.md       # Common issues
└── CHANGELOG.md             # Storia modifiche con date
```

### Modulo Xot (Core) - Esteso (max 15 files)

```
Modules/Xot/docs/
├── README.md                           # ⭐ Entry point
├── architecture-overview.md            # Architettura generale
├── laraxot-framework.md               # Framework core principles
├── xotbase-classes.md                 # XotBase* inheritance
├── service-providers.md               # Service provider patterns
├── file-locking-pattern.md            # 🆕 File locking rule
├── namespace-conventions.md           # PSR-4 rules
├── filament-best-practices.md         # Filament integration
├── actions-pattern.md                 # Spatie QueueableActions
├── translations-system.md             # Lang system
├── testing.md                         # Testing guidelines
├── troubleshooting.md                 # Common issues
├── code-quality-standards.md          # PHPStan + Pint
├── merge-conflict-resolution.md       # 🆕 Latest fixes
└── CHANGELOG.md                       # 🆕 History with dates
```

## 🔄 Piano di Consolidamento

### Fase 1: Identificazione File da Mantenere (FATTO parzialmente)
- ✅ README.md (tutti i moduli)
- ✅ File con contenuto unico e attuale
- ✅ File con business logic critica
- ✅ File di reference (architecture, configuration)

### Fase 2: Merge File Duplicati
```bash
# Esempio: Consolidare analisi multiple
cat analisi-dettagliata-*.md > comprehensive-analysis.md
# Rimuovere file originali
rm analisi-dettagliata-*.md
```

### Fase 3: Rinominare File Non Conformi
```bash
# Lowercase
mv CODE_QUALITY_STANDARDS.md code-quality-standards.md
mv BUSINESS_LOGIC_ANALYSIS.md business-logic-analysis.md

# Rimuovere duplicati underscore/hyphen
rm actions_structure.md  # Keep actions-structure.md
rm auth_pages.md         # Keep auth-pages.md
```

### Fase 4: Archiviare File Obsoleti
```bash
# Creare cartella archive
mkdir -p Modules/ModuleName/docs/archive

# Spostare file obsoleti/datati
mv Modules/Xot/docs/*-2024-*.md Modules/Xot/docs/archive/
mv Modules/Xot/docs/*-2025-*.md Modules/Xot/docs/archive/

# Mantenere solo l'ultimo se rilevante
mv Modules/Xot/docs/archive/merge-conflict-resolution-2025-11-04.md \
   Modules/Xot/docs/merge-conflict-resolution.md
```

### Fase 5: Creare CHANGELOG.md
```markdown
# Changelog - Modulo Xot

## 2025-11-04 - Merge Conflicts Resolution
- Corretti 18 file con merge conflicts massivi
- Implementato File Locking Pattern
- Fix PSR-4 namespace violations
- Server Laravel ora funzionante

## 2025-10-29 - PHPStan Level 10 Achievement
- Raggiunto PHPStan Level 10 su tutto il modulo
- Corretti 500+ type hints
- Documentazione aggiornata

...
```

## 🎯 Regole di Consolidamento

### 1. File Naming (CRITICO)
- ✅ **kebab-case lowercase**: `my-document.md`
- ❌ **NO UPPERCASE**: ~~`MY_DOCUMENT.md`~~
- ❌ **NO dates**: ~~`analysis-2025-11-04.md`~~
- ❌ **NO underscores**: ~~`my_document.md`~~
- ✅ **Exception**: `README.md`, `CHANGELOG.md`

### 2. DRY Principle
- Prima di creare nuovo file: **CERCARE** se esiste già
- Preferire **aggiornare** file esistente a crearne uno nuovo
- Merge file simili (es: tutte le "analisi" in un unico file)

### 3. KISS Principle
- Massimo **10 file per modulo standard**
- Massimo **15 file per modulo Xot (core)**
- Focalizzarsi su **business logic** e **WHY**, non WHAT

### 4. Cross-Module References
```markdown
<!-- ❌ WRONG -->
See /var/www/.../Modules/Xot/docs/xotbase-rules.md

<!-- ✅ CORRECT -->
See [XotBase Rules](../../Xot/docs/xotbase-rules.md)
```

## 📝 Template README.md Standard

```markdown
# Modulo [Nome] - Documentazione

## Panoramica
Breve descrizione (2-3 frasi) dello scopo del modulo.

## 🔧 Correzioni Recenti
Ultime modifiche significative con date nel contenuto (non nel nome file).

### [Data] - [Titolo Fix]
- Breve descrizione
- Pattern corretti
- File coinvolti

## Funzionalità Core
- Feature 1
- Feature 2
- Feature 3

## Componenti Principali
### Modelli
- Model1: Descrizione
- Model2: Descrizione

### Filament Resources
- Resource1: Scopo

## Architettura Tecnica
Pattern e design decisions (WHY non WHAT).

## Configurazione
Setup essenziale e variabili ambiente.

## Testing
```bash
php artisan test Modules/ModuleName
```

## Troubleshooting
Common issues e soluzioni.

## References
- [Doc interna 1](./other-doc.md)
- [Doc Xot](../../Xot/docs/core-doc.md)
- [External](https://example.com)

---
**Ultimo aggiornamento:** [Data] - [Breve descrizione]
```

## 🔨 Script di Consolidamento

### Analisi Duplicati
```bash
#!/bin/bash
# find_duplicate_docs.sh

cd /var/www/_bases/base_ptvx_fila4_mono/laravel

for MODULE in Modules/*/docs; do
    echo "Analyzing: $MODULE"
    
    # Trova file con nome simile (ignora case e - vs _)
    find "$MODULE" -maxdepth 1 -name "*.md" -type f | while read file; do
        basename=$(basename "$file" .md | tr '_' '-' | tr '[:upper:]' '[:lower:]')
        echo "$basename -> $file"
    done | sort | uniq -d -w 30
    
    echo ""
done
```

### Rinomina UPPERCASE to kebab-case
```bash
#!/bin/bash
# rename_uppercase_docs.sh

find Modules/*/docs -maxdepth 1 -name "*.md" -type f | while read file; do
    dir=$(dirname "$file")
    base=$(basename "$file")
    
    # Skip README.md and CHANGELOG.md
    if [[ "$base" == "README.md" ]] || [[ "$base" == "CHANGELOG.md" ]]; then
        continue
    fi
    
    # Convert to lowercase kebab-case
    new_base=$(echo "$base" | tr '[:upper:]' '[:lower:]' | tr '_' '-')
    
    if [[ "$base" != "$new_base" ]]; then
        echo "Renaming: $file -> $dir/$new_base"
        mv "$file" "$dir/$new_base"
    fi
done
```

### Archivia File con Date
```bash
#!/bin/bash
# archive_dated_docs.sh

find Modules/*/docs -maxdepth 1 -name "*-20[0-9][0-9]-*.md" -type f | while read file; do
    dir=$(dirname "$file")
    base=$(basename "$file")
    
    # Crea archive se non esiste
    mkdir -p "$dir/archive/historical"
    
    echo "Archiving: $file"
    mv "$file" "$dir/archive/historical/$base"
done
```

## 📈 Priorità di Consolidamento

### Priorità ALTA (Immediate)
1. ✅ **Xot module** - Già creati 3 nuovi doc (file-locking, merge-conflicts, lessons-learned)
2. ✅ **User module** - README aggiornato
3. ✅ **UI module** - README aggiornato
4. ✅ **Notify module** - README aggiornato

### Priorità MEDIA (Prossimi step)
5. Rinominare file UPPERCASE → kebab-case
6. Rimuovere duplicati underscore/hyphen
7. Archiviare file con date nei nomi
8. Merge file "analisi-dettagliata-N" in comprehensive-analysis.md

### Priorità BASSA (Future)
9. Consolidare cartelle `archive/`, `consolidated/`, `old/`
10. Creare CHANGELOG.md per ogni modulo
11. Review e merge di file molto simili
12. Eliminare file completamente obsoleti

## ✅ Checklist per Ogni Modulo

Prima di considerare un modulo "consolidato":

- [ ] README.md aggiornato con latest fixes
- [ ] Max 10-15 file (eccetto Xot che può avere 15)
- [ ] Tutti i nomi kebab-case lowercase
- [ ] Nessun file con date nel nome
- [ ] CHANGELOG.md creato per storia modifiche
- [ ] Nessun duplicato underscore/hyphen
- [ ] File obsoleti in archive/
- [ ] Cross-references corretti (relative paths)
- [ ] Business logic documentata (WHY non WHAT)

## 🔗 References

- [Documentation Guidelines](./documentation-guidelines.md)
- [File Naming Rules](./file-naming-rules.md)
- [KISS Principles](./dry-kiss-analysis.md)
- [No Root Docs Rule](./no-root-docs-rule.md)

---

**Created:** 2025-11-04  
**Purpose:** Strategic plan per ridurre documentation bloat  
**Target:** ~350 total files across all modules (da ~5,267)

