# Markdown File Naming Rules

**Data**: 29 Novembre 2024

---

## 📝 Regole per File .md

### Naming Convention

1. ✅ **Lowercase with dashes**: `my-document-name.md`
2. ❌ **NO CamelCase**: ~~`MyDocumentName.md`~~
3. ❌ **NO snake_case**: ~~`my_document_name.md`~~
4. ❌ **NO UPPERCASE**: ~~`MY-DOCUMENT.md`~~

### Exceptions (ONLY)

- ✅ `README.md` (uppercase, standard convention)
- ✅ `CHANGELOG.md` (uppercase, standard convention)

---

## 📂 File Location

### Regola Fondamentale

**TUTTI i file .md devono essere nelle cartelle `docs/` ESISTENTI**

- ✅ `Themes/Meetup/docs/my-document.md`
- ✅ `Modules/Pizza/docs/api-guide.md`
- ❌ **NO nuove cartelle docs**: Non creare `docs/subfolder/` se non esiste già

---

## ✅ Esempi Corretti

```
docs/
├── README.md                                    # ✅ Exception allowed
├── CHANGELOG.md                                 # ✅ Exception allowed
├── project-purpose.md                           # ✅ Lowercase with dashes
├── architecture-folio-volt-filament.md          # ✅ Lowercase with dashes
├── completion-plan.md                           # ✅ Lowercase (should be renamed)
├── completion-plan-corrections.md               # ✅ Lowercase with dashes
├── next-steps-implementation.md                 # ✅ Lowercase with dashes
├── implementation-log.md                        # ✅ Lowercase with dashes
└── markdown-file-naming-rules.md                # ✅ Lowercase with dashes
```

---

## ❌ Esempi Sbagliati

```
docs/
├── ProjectPurpose.md                            # ❌ CamelCase
├── COMPLETION_PLAN.md                           # ❌ UPPERCASE with underscore
├── Next-Steps-Implementation.md                 # ❌ Starts with capital
├── Implementation_Log.md                        # ❌ Underscore
└── Architecture.MD                              # ❌ Extension uppercase
```

---

## 🔧 Correzione File Esistenti

### File da Rinominare

Se esistono file con naming sbagliato:

```bash
# Check for uppercase files (except README.md and CHANGELOG.md)
find docs/ -name "*.md" -not -name "README.md" -not -name "CHANGELOG.md" | grep -E '[A-Z]'

# Rename examples:
mv docs/ProjectPurpose.md docs/project-purpose.md
mv docs/COMPLETION_PLAN.md docs/completion-plan.md
mv docs/Next_Steps.md docs/next-steps.md
```

---

## 📚 Naming Best Practices

### Choose Descriptive Names

- ✅ `authentication-flow.md` (chiaro cosa contiene)
- ❌ `auth.md` (troppo generico)

### Use Semantic Grouping

Se hai molti file simili, usa prefissi:

```
docs/
├── architecture-overview.md
├── architecture-folio-volt-filament.md
├── architecture-database-schema.md
├── guide-getting-started.md
├── guide-deployment.md
└── troubleshooting-tailwind-v4.md
```

### Max Length

- Limite raccomandato: **50 caratteri**
- Se troppo lungo, usa abbreviazioni comuni

---

## 🔍 Git Check Before Commit

Prima di commit, verifica naming:

```bash
# Check all .md files
git ls-files | grep '\.md$'

# Should NOT return files with uppercase (except README.md, CHANGELOG.md)
git ls-files | grep '\.md$' | grep -v README.md | grep -v CHANGELOG.md | grep -E '[A-Z]'
```

Se ritorna files → rinomina prima di commit!

---

## 🚨 Pre-commit Hook (Opzionale)

Per evitare errori, aggiungi `.git/hooks/pre-commit`:

```bash
#!/bin/bash

# Check for .md files with wrong naming
BAD_FILES=$(git diff --cached --name-only | grep '\.md$' | grep -v README.md | grep -v CHANGELOG.md | grep -E '[A-Z]')

if [ -n "$BAD_FILES" ]; then
    echo "❌ Error: Markdown files must be lowercase (except README.md and CHANGELOG.md)"
    echo "Bad files:"
    echo "$BAD_FILES"
    echo ""
    echo "Please rename to lowercase with dashes (e.g., my-file.md)"
    exit 1
fi

echo "✅ Markdown file naming is correct"
```

---

## 📖 References

Queste regole seguono best practices comuni:

- [Google Style Guide for Markdown](https://google.github.io/styleguide/docguide/style.html)
- [CommonMark Spec](https://commonmark.org/)
- Laravel Community Conventions

---

## ✅ Checklist

Quando crei/modifichi file .md:

- [ ] Nome in lowercase?
- [ ] Trattini (dash) al posto di spazi?
- [ ] NO CamelCase?
- [ ] NO underscore (except README/CHANGELOG)?
- [ ] File dentro `docs/` esistente?
- [ ] NO nuove sottocartelle `docs/`?
- [ ] Estensione `.md` (lowercase)?

Se tutte ✅ → procedi con commit!
