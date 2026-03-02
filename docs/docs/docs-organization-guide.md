# Documentation Organization Guide

> **Guida completa per organizzare e mantenere la documentazione dei moduli**

---

## 🎯 Obiettivi

1. **Struttura consistente** tra tutti i moduli
2. **Facile navigazione** e ricerca
3. **Manutenzione semplice** e scalabile
4. **Zero file vuoti** o duplicati
5. **Naming conventions** chiare e uniformi

---

## 📁 Struttura Standard

### Ogni Modulo Deve Avere

```
Modules/<ModuleName>/docs/
├── 00-INDEX.md                    # ⭐ Indice principale (OBBLIGATORIO)
├── README.md                      # Introduzione generale
│
├── 01-getting-started/            # Quick start
│   ├── README.md
│   ├── installation.md
│   ├── quick-start.md
│   └── configuration.md
│
├── 02-architecture/               # Architettura
│   ├── README.md
│   ├── overview.md
│   ├── components.md
│   └── design-patterns.md
│
├── 03-development/                # Sviluppo
│   ├── README.md
│   ├── coding-standards.md
│   ├── phpstan-guide.md
│   └── testing.md
│
├── 04-features/                   # Features specifiche del modulo
│   ├── README.md
│   └── [feature-specific files]
│
├── 05-api/                        # API / Public interfaces
│   ├── README.md
│   ├── classes.md
│   ├── traits.md
│   └── contracts.md
│
├── 06-integration/                # Integrazione con altri moduli
│   ├── README.md
│   └── [integration docs]
│
├── 07-troubleshooting/            # Problem solving
│   ├── README.md
│   ├── common-issues.md
│   └── faq.md
│
└── _archive/                      # File obsoleti (opzionale)
    └── YYYY-MM-DD-[old-file].md
```

---

## 📝 Naming Conventions

### Files

```
✅ CORRETTO:
- lowercase-with-dashes.md
- 01-numbered-for-order.md
- feature-name.md
- component-name.md

❌ SBAGLIATO:
- Uppercase_File.md
- file_with_underscores.md
- File With Spaces.md
- CamelCaseFile.md
- file.md.tmp
```

### Directories

```
✅ CORRETTO:
- lowercase-directory/
- 01-numbered-directory/
- feature-category/

❌ SBAGLIATO:
- Uppercase_Directory/
- directory_with_underscores/
- Directory With Spaces/
- _old/  (usare _archive/)
```

### Special Files

```
MAIUSCOLE (convenzione standard):
- README.md         # Introduzione cartella
- INDEX.md          # Indice navigazione
- CHANGELOG.md      # Change log
- LICENSE.md        # Licenza
- CONTRIBUTING.md   # Guida contribuzione
```

---

## 📄 Template File Markdown

### File Standard

```markdown
# Titolo Documento

> **Descrizione breve del contenuto**
> **Modulo**: Nome Modulo
> **Status**: ✅ Updated / ⚠️ WIP / 🔄 Review Needed

---

## Quick Reference

[Tabella o lista per accesso rapido]

---

## Contenuto Principale

### Sezione 1

Testo e spiegazioni...

### Sezione 2

```php
// Esempi di codice
```

---

## Examples

### Example 1: Titolo Esempio

```php
// Codice esempio completo e funzionante
```

---

## See Also

- [Documento correlato](./related-doc.md)
- [Altra risorsa](../other-module/docs/file.md)

---

**Ultimo aggiornamento**: YYYY-MM-DD
**Autore**: Nome
**Status**: ✅ / ⚠️ / 🔄
```

### README.md Cartella

```markdown
# Nome Cartella

> **Descrizione contenuto della cartella**

## Files in This Directory

- [file-1.md](file-1.md) - Descrizione
- [file-2.md](file-2.md) - Descrizione
- [file-3.md](file-3.md) - Descrizione

## Overview

Panoramica generale dell'argomento coperto da questa sezione.

---

**Cartella**: `path/to/this/folder/`
**Files**: X documenti
```

---

## 🔍 Regole di Organizzazione

### 1. Zero File Vuoti

```bash
# Trova e rimuovi file vuoti
find Modules/*/docs -type f -size 0 -name "*.md" -delete
```

**Regola**: Se un file è vuoto, o lo riempi SUBITO o lo elimini.

### 2. Zero Duplicati

```bash
# Trova duplicati (stesso nome, case diverso)
find Modules/*/docs -type f | sort -f | uniq -di
```

**Pattern comuni**:
- `file.md` vs `File.md` → mantieni lowercase
- `file_name.md` vs `file-name.md` → mantieni dash
- `file.md` vs `file.md.tmp` → elimina .tmp

### 3. Consolidamento Archive

```bash
# Sposta file vecchi in _archive con data
mv old-file.md _archive/[DATE]-old-file.md
```

**Quando archiviare**:
- File obsoleti ma utili per riferimento
- Vecchie versioni di guide aggiornate
- Documentazione di features deprecate

**Quando eliminare**:
- File completamente inutili
- Draft mai completati
- File duplicati senza valore

### 4. Link Relativi

```markdown
✅ CORRETTO:
[Link](./same-folder/file.md)
[Link](../parent-folder/file.md)
[Link](../../modules/other/docs/file.md)

❌ SBAGLIATO:
[Link](/absolute/path/file.md)
[Link](file://...)
[Link](C:\Windows\...)
```

---

## 🛠️ Script di Riorganizzazione

### 1. Cleanup File Vuoti

```bash
#!/bin/bash
# cleanup-empty-files.sh

MODULE_PATH="Modules"

echo "🔍 Cercando file vuoti..."
EMPTY_FILES=$(find $MODULE_PATH/*/docs -type f -size 0 -name "*.md")
COUNT=$(echo "$EMPTY_FILES" | grep -c "^")

if [ $COUNT -gt 0 ]; then
    echo "📋 Trovati $COUNT file vuoti"
    echo "$EMPTY_FILES"

    read -p "Vuoi eliminarli? (y/n) " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        find $MODULE_PATH/*/docs -type f -size 0 -name "*.md" -delete
        echo "✅ File eliminati"
    fi
else
    echo "✅ Nessun file vuoto trovato"
fi
```

### 2. Fix Naming Conventions

```bash
#!/bin/bash
# fix-naming-conventions.sh

MODULE_PATH="Modules"

echo "🔍 Correggendo naming conventions..."

# Converti underscore in dash (escluso _archive)
find $MODULE_PATH/*/docs -type f -name "*_*.md" ! -path "*/_archive/*" | while read file; do
    dir=$(dirname "$file")
    base=$(basename "$file")
    new_name=$(echo "$base" | tr '_' '-')

    if [ "$base" != "$new_name" ]; then
        echo "  $base → $new_name"
        mv "$dir/$base" "$dir/$new_name"
    fi
done

echo "✅ Naming conventions corrette"
```

### 3. Crea Struttura Standard

```bash
#!/bin/bash
# create-docs-structure.sh

MODULE=$1

if [ -z "$MODULE" ]; then
    echo "Usage: $0 <module-name>"
    exit 1
fi

DOCS_DIR="Modules/$MODULE/docs"

# Crea cartelle standard
mkdir -p "$DOCS_DIR"/{01-getting-started,02-architecture,03-development,04-features,05-api,06-integration,07-troubleshooting,_archive}

# Crea README.md in ogni cartella
for dir in "$DOCS_DIR"/0*; do
    if [ ! -f "$dir/README.md" ]; then
        cat > "$dir/README.md" << EOF
# $(basename $dir | sed 's/^[0-9]*-//' | tr '-' ' ' | sed 's/\b\(.\)/\u\1/g')

> **Documentazione** $(basename $dir | sed 's/^[0-9]*-//')

## Contents

[Lista dei file in questa cartella]

---

**Module**: $MODULE
EOF
    fi
done

echo "✅ Struttura creata per $MODULE"
```

---

## 📊 Checklist Qualità Docs

### Per Ogni Modulo

- [ ] **00-INDEX.md** esiste e completo
- [ ] **README.md** aggiornato e informativo
- [ ] Cartelle numerate 01-XX presenti
- [ ] README.md in ogni cartella
- [ ] Zero file vuoti (size 0)
- [ ] Zero duplicati (case sensitivity)
- [ ] Naming lowercase-with-dashes
- [ ] Link relativi (no assoluti)
- [ ] Esempi di codice presenti
- [ ] Data ultimo aggiornamento
- [ ] Status indicator (✅⚠️🔄)

### Per Ogni File

- [ ] Titolo H1 chiaro
- [ ] Descrizione iniziale
- [ ] Struttura con headers H2/H3
- [ ] Code blocks con syntax highlight
- [ ] Esempi pratici
- [ ] Sezione "See Also" se pertinente
- [ ] Footer con metadata
- [ ] Linguaggio chiaro e conciso
- [ ] Formattazione consistente
- [ ] Link funzionanti

---

## 🔄 Workflow Manutenzione

### Quando Aggiungere Docs

1. **Identifica categoria** (getting-started, development, etc.)
2. **Segui naming convention** (lowercase-with-dashes.md)
3. **Usa template** appropriato
4. **Aggiorna INDEX.md** se rilevante
5. **Aggiorna README.md** della cartella
6. **Link da altri docs** se correlato
7. **Commit con message chiaro**

### Quando Aggiornare Docs

1. **Leggi doc esistente** completamente
2. **Mantieni struttura** consistente
3. **Aggiorna sezione specifica** necessaria
4. **Aggiorna metadata** (data, status)
5. **Verifica link** ancora validi
6. **Test esempi** di codice
7. **Commit con changelog** modifiche

### Quando Archiviare Docs

1. **Valuta utilità** storica
2. **Se utile**: sposta in `_archive/YYYY-MM-DD-nome.md`
3. **Se inutile**: elimina direttamente
4. **Aggiorna link** che puntavano al file
5. **Rimuovi da INDEX.md**
6. **Documenta motivo** archiviazione

---

## 🎨 Best Practices

### Markdown Style

```markdown
✅ DO:
- Usa headers gerarchici (H1 → H2 → H3)
- Code blocks con linguaggio (```php, ```bash)
- Liste puntate per chiarezza
- Tabelle per dati strutturati
- Emoji con moderazione (guide, status)
- Link descrittivi

❌ DON'T:
- Troppi livelli di nesting
- Code blocks senza linguaggio
- Muri di testo senza struttura
- Link generici ("click here")
- Emoji ovunque
- Formattazione inconsistente
```

### Content Organization

```markdown
✅ DO:
- Sezione "Quick Reference" all'inizio
- Esempi pratici funzionanti
- Link a docs correlate
- Metadata footer
- Status indicator

❌ DON'T:
- Teoria senza esempi
- Esempi senza spiegazione
- Link esterni senza context
- Docs senza date
- File senza categoria
```

---

## 🚀 Quick Commands

```bash
# Trova file vuoti
find Modules/*/docs -type f -size 0 -name "*.md"

# Conta file per modulo
find Modules/*/docs -type f -name "*.md" | cut -d'/' -f2 | sort | uniq -c

# Trova file con underscore
find Modules/*/docs -name "*_*.md" ! -path "*/_archive/*"

# Trova file duplicati (case-insensitive)
find Modules/*/docs -type f | sort -f | uniq -di

# Trova file senza estensione .md
find Modules/*/docs -type f ! -name "*.md" ! -name "*.json" ! -name "*.sh"

# Verifica link rotti (richiede markdown-link-check)
find Modules/*/docs -name "*.md" -exec markdown-link-check {} \;

# Genera indice automatico
tree Modules/Xot/docs/ -L 2 -I '_archive|node_modules'
```

---

## 📈 Metriche Qualità

### Target Obiettivi

| Metrica | Target | Tolleranza |
|---------|--------|------------|
| File vuoti | 0 | 0 |
| Duplicati | 0 | 0 |
| Naming violations | 0 | < 5% |
| Link rotti | 0 | < 2% |
| Files senza date | 0 | < 10% |
| Cartelle senza README | 0 | 0 |
| Coverage INDEX | 100% | > 90% |

### Monitoring

```bash
#!/bin/bash
# docs-health-check.sh

echo "📊 Docs Health Check"
echo "===================="

MODULE_PATH="Modules"

# File vuoti
EMPTY=$(find $MODULE_PATH/*/docs -type f -size 0 | wc -l)
echo "File vuoti: $EMPTY"

# Naming violations
UNDERSCORES=$(find $MODULE_PATH/*/docs -name "*_*.md" ! -path "*/_archive/*" | wc -l)
echo "Underscore violations: $UNDERSCORES"

# Missing INDEX
MISSING_INDEX=$(find $MODULE_PATH/*/docs -maxdepth 1 -type d ! -exec test -e "{}/00-INDEX.md" \; -print | wc -l)
echo "Missing INDEX: $MISSING_INDEX"

# Total docs
TOTAL=$(find $MODULE_PATH/*/docs -type f -name "*.md" | wc -l)
echo "Total docs: $TOTAL"

echo "===================="

if [ $EMPTY -eq 0 ] && [ $UNDERSCORES -eq 0 ] && [ $MISSING_INDEX -eq 0 ]; then
    echo "✅ Docs health: EXCELLENT"
else
    echo "⚠️  Docs health: NEEDS ATTENTION"
fi
```

---

## 📚 Resources

### Tools

- **markdown-link-check**: Verifica link
- **markdownlint**: Linting markdown
- **prettier**: Formattazione automatica
- **doctoc**: Genera TOC automatici
- **tree**: Visualizza struttura

### Templates

- `docs/templates/` - Template riutilizzabili
- `docs/examples/` - Esempi completi

### References

- [GitHub Markdown Guide](https://guides.github.com/features/mastering-markdown/)
- [Markdown Cheatsheet](https://www.markdownguide.org/cheat-sheet/)
- [Documentation Best Practices](https://www.writethedocs.org/guide/)

---

## 🤝 Contributing

Per migliorare questa guida:

1. Fork del progetto
2. Branch feature per modifiche
3. Aggiorna esempi se necessario
4. Test su modulo reale
5. Pull request con descrizione

---

**Ultimo aggiornamento**: [DATE]
**Versione**: 1.0
**Status**: ✅ Active
**Maintainer**: Team Laraxot
