# Documentation Philosophy - PTVX

**Focus**: WHY, not just WHAT  
**Principle**: Business Logic over Implementation Details  
**Style**: DRY + KISS

---

## 🎯 What to Document

### Focus On

1. **Business Logic** - PERCHÉ esiste questo codice
2. **Scopo** - A COSA serve
3. **Filosofia** - COME si integra nel sistema
4. **Logica** - QUALE problema risolve
5. **Zen** - Il modo "giusto" di fare le cose

### Don't Focus On

1. ❌ Solo "cosa fa" (ovvio dal codice)
2. ❌ Date specifiche (use CHANGELOG.md)
3. ❌ History dettagliata (use git log)
4. ❌ Implementation details ovvi

---

## 📝 Documentation Structure

### Module docs/ Structure

```
Modules/ModuleName/docs/
├── README.md                    # Overview + navigation
├── CHANGELOG.md                 # Temporal tracking
├── business-logic.md            # WHY & business rules
├── architecture-overview.md     # HOW it's structured
├── best-practices.md            # Patterns & anti-patterns
├── troubleshooting.md           # Common issues
├── quick-start.md               # Fast onboarding
└── [specific-topics].md         # As needed
```

### Root docs/ Structure

```
docs/
├── README.md                    # Project documentation hub
├── claude/                      # AI assistant guidelines
│   ├── README.md
│   ├── architecture-rules.md
│   └── ...
├── architecture/                # System architecture
├── best-practices/              # Project-wide practices
├── testing/                     # Testing strategies
└── troubleshooting/             # Common issues
```

---

## ✅ Before Creating a Document

### Checklist

1. [ ] **Check if exists**: Search for existing docs on topic
2. [ ] **Identify purpose**: What business problem does this solve?
3. [ ] **Choose location**: Existing docs/ directory
4. [ ] **Name correctly**: lowercase-kebab-case, no dates
5. [ ] **Focus on WHY**: Not just implementation
6. [ ] **Link bidirectionally**: From and to related docs

### Search First

```bash
# Find existing docs on topic
find docs laravel/Modules/*/docs -name "*keyword*.md"

# Search content
grep -r "your topic" docs laravel/Modules/*/docs --include="*.md"
```

---

## 📋 Document Types

### Business Logic Documents

**Purpose**: Explain WHY and business rules

**Example**: `business-logic.md`
```markdown
## Scopo del Modulo
Il problema da risolvere...
La soluzione implementata...

## Business Rules
- Rule 1: Why this rule exists
- Rule 2: What business need it serves
```

### Architecture Documents

**Purpose**: Explain HOW system is structured

**Example**: `architecture-overview.md`
```markdown
## Components
- Component A: Handles X because Y
- Component B: Integrates with Z for purpose W
```

### Best Practices

**Purpose**: Guide developers on correct patterns

**Example**: `best-practices.md`
```markdown
## Pattern X
✅ DO: This way (why: business reason)
❌ DON'T: That way (why: causes problem Y)
```

---

## 🚫 Anti-Patterns

### Anti-Pattern 1: Date in Filename

```
❌ WRONG:
- analysis.md
- fixes.md

✅ CORRECT:
- code-analysis.md (content in CHANGELOG.md with date)
- phpstan-fixes.md (dates in CHANGELOG.md)
```

### Anti-Pattern 2: Implementation-Only Docs

```
❌ WRONG:
"This method does X, then Y, then Z"
(Just reading the code!)

✅ CORRECT:
"This method calculates indennità because business rule requires..."
(Explains WHY)
```

### Anti-Pattern 3: Duplicate Content

```
❌ WRONG:
- code-quality.md
- code-analysis.md
- quality-analysis.md
(All same topic!)

✅ CORRECT:
- code-quality.md (consolidate all in one)
```

---

## 🔗 Linking Strategy

### Bidirectional Links

```markdown
<!-- In module docs -->
See also: [Root Best Practices](../../../docs/best-practices/README.md)

<!-- In root docs -->
Example: [IndennitaResponsabilita](../laravel/Modules/IndennitaResponsabilita/docs/README.md)
```

### Link to CHANGELOG for Dates

```markdown
<!-- In permanent doc -->
For historical changes, see [CHANGELOG.md](./CHANGELOG.md)

<!-- In CHANGELOG.md -->
## [2024-12-10]
### Changed
- Updated code-quality.md with new analysis
```

---

## 📊 Quality Metrics

Good documentation has:
- ✅ Clear business purpose
- ✅ Explains WHY, not just WHAT
- ✅ Linked to related docs
- ✅ No dates in filename
- ✅ Lowercase kebab-case
- ✅ In existing docs/ directory
- ✅ No duplication

---

## 🎓 Examples

### Good Documentation

```markdown
# business-logic.md

## Scopo
Questo modulo risolve il problema di...

## Perché questa architettura
Usiamo pattern X perché business rule Y richiede...

## Workflow
1. Step A (scopo: garantire trasparenza)
2. Step B (scopo: calcolo automatico)
```

### Bad Documentation

```markdown
# Code-Analysis.md

## What the code does
Line 50: Creates object
Line 51: Calls method
Line 52: Returns value

(Just describing code, no business context!)
```

---

## 🔗 Related

- [Documentation Naming Rules](../../.cursor/rules/documentation-naming.mdc)
- [Git Forward-Only](../../.cursor/rules/git-forward-only.mdc)
- [Scripts Location](../../.cursor/rules/scripts-location-mandatory.mdc)

---

**Remember**: Document WHY, use CHANGELOG for WHEN, focus on business value!


