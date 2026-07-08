# 📖 Documentation Policy - Policy Documentazione

> **FONDAMENTALE**: Documentazione consistente e manutenibile è essenziale per la sostenibilità del progetto PTVX.

## 🎯 Principi Documentazione

### DRY (Don't Repeat Yourself)
- Single Source of Truth per ogni informazione
- Link invece di duplicare contenuti
- Referenze incrociate tra documenti

### KISS (Keep It Simple, Stupid)
- Documenti focalizzati su singoli argomenti
- Linguaggio chiaro e diretto
- Struttura prevedibile e navigabile

### JUST IN TIME
- Informazioni disponibili quando necessarie
- Livelli di dettaglio appropriati al contesto
- Quick reference per task comuni

---

## 📂 Struttura Documentatione

### Gerarchia Documenti

```
docs/
├── claude/                          # Documentazione principale (START HERE)
│   ├── README.md                   # 🚀 Entry point principale
│   ├── core.md                     # Regole fondamentali
│   ├── architecture-rules.md       # Architettura
│   ├── common-pitfalls.md          # Errori comuni
│   ├── code-quality.md             # Qualità codice
│   ├── framework-specifics.md      # Framework details
│   ├── module-structure.md         # Struttura moduli
│   ├── development-tasks.md        # Task sviluppo
│   ├── conventions.md              # Convenzioni
│   ├── laravel-boost.md            # MCP tools
│   ├── eloquent-properties.md      # Proprietà Eloquent
│   └── documentation-policy.md     # Questo documento
├── modules/                        # Documentazione moduli
│   ├── modules.md                  # Indice moduli
│   └── {ModuleName}/                # Docs specifiche modulo
└── themes/                         # Documentazione temi
    ├── themes.md                   # Indice temi
    └── {ThemeName}/                 # Docs specifiche tema
```

---

## 📝 Standard Documentazione

### 1. **Struttura Documento Standard**

Ogni documento deve seguire questa struttura:

```markdown
# Titolo Breve e Descrittivo

> **FONDAMENTALE**: Frase che spiega perché questo documento è importante.

## 🎯 Panoramica
Breve introduzione al contenuto del documento (2-3 frasi).

---

## 📋 Sezione Principale 1
Contenuto dettagliato con:
- Sottosezioni logiche
- Esempi di codice
- Best practices

### Esempio Codice
```php
// Esempio pratico e funzionante
```

---

## 📚 Riferimenti Correlati
Link ad altri documenti rilevanti.

---

**Versione**: X.X  
**Priorità**: 🔥/⚡/📡 - Livello di importanza  
**Aggiornamento**: Mese Anno  
**Maintainer**: Team/Persona responsabile

> **💡 Principio**: Frase riassuntiva che ricorda il concetto chiave.
```

### 2. **Naming Conventions**

#### File Names
```bash
# ✅ CORRETTO
core.md
architecture-rules.md
common-pitfalls.md
html2pdf-integration.md

# ❌ SBAGLIATO
Core.md
ArchitectureRules.md
Common Pitfalls.md
html2pdf_integration.md
```

#### Section Headers
```markdown
# ✅ CORRETTO
# 🎯 Panoramica
## 📋 Sezione Principale
### 🔧 Sottosezione
#### 📝 Dettaglio

# ❌ SBAGLIATO
# Overview
## Main Section
### Subsection
#### Detail
```

### 3. **Code Documentation Standards**

#### Code Blocks
```php
<?php

declare(strict_types=1); // Sempre incluso

namespace Modules\MyModule\Services;

// ✅ Con contesto e spiegazione
public function createUser(array $data): User
{
    // Valida dati prima della creazione (security requirement)
    $this->validateUserData($data);
    
    // Crea utente con evento per notifiche
    $user = $this->repository->create($data);
    
    event(new UserCreated($user));
    
    return $user;
}

// ❌ Senza contesto
public function createUser(array $data): User
{
    return $this->repository->create($data);
}
```

#### Inline Documentation
```php
// ✅ Commenti che spiegano il PERCHÉ
if ($user->hasPermissionTo('admin')) {
    // Admin può vedere tutti i record (security policy)
    return $this->repository->all();
}

// Non admin vede solo i propri record (privacy requirement)
return $this->repository->findByUser($user->id);

// ❌ Commenti che descrivono il COSA
if ($user->hasPermissionTo('admin')) {
    // Get all records
    return $this->repository->all();
}

// Get user records only
return $this->repository->findByUser($user->id);
```

---

## 🔄 Processo Documentazione

### 1. **Creazione Nuovo Documento**

```bash
# 1. Verifica se documento esiste già
find docs/ -name "*similar-topic*"

# 2. Crea file con struttura standard
cat > docs/claude/new-document.md << 'EOF'
# New Document Title

> **FONDAMENTALE**: Why this document matters.

## 🎯 Panoramica
Brief introduction.

---

## 📋 Main Section
Content here.

---

## 📚 Riferimenti Correlati
- [Related Document](related-document.md)

---

**Versione**: 1.0  
**Priorità**: 📡 MEDIA  
**Aggiornamento**: Dicembre 2025  
**Maintainer**: Your Name

> **💡 Principio**: Key concept reminder.
EOF

# 3. Aggiungi indice
# Edit docs/claude/README.md per includere nuovo documento
```

### 2. **Aggiornamento Documento Esistente**

```bash
# 1. Verifica versione corrente
grep "Versione" docs/claude/document.md

# 2. Aggiorna contenuto
# Edit file...

# 3. Aggiorna versione e data
# Incrementa versione e aggiorna data

# 4. Verifica link
find docs/ -name "*.md" -exec grep -l "document.md" {} \;
```

### 3. **Review Documentazione**

```bash
# 1. Verifica struttura
find docs/ -name "*.md" -exec echo "=== {} ===" \; -exec head -10 {} \;

# 2. Verifica link broken
grep -r "\[.*\](.*\.md)" docs/ | while read line; do
    link=$(echo "$line" | sed -n 's/.*(\([^)]*\.md\)).*/\1/p')
    if [ ! -f "docs/$link" ]; then
        echo "Broken link: $line"
    fi
done

# 3. Verifica convenzioni
grep -r "^## " docs/ | grep -v "## 📋\|## 🎯\|## 🔧\|## 📝"
```

---

## 📋 Tipi Documento

### 1. **Core Documentation** (Priorità 🔥 URGENTE)
Documenti fondamentali che ogni sviluppatore DEVE leggere:
- `core.md` - Regole fondamentali
- `common-pitfalls.md` - Errori critici
- `eloquent-properties.md` - Proprietà magiche

### 2. **Architecture Documentation** (Priorità ⚡ ALTA)
Documenti architetturali per understanding sistemico:
- `architecture-rules.md` - Pattern architetturali
- `module-structure.md` - Struttura moduli
- `framework-specifics.md` - Dettagli framework

### 3. **Reference Documentation** (Priorità 📡 MEDIA)
Documenti di riferimento per task specifici:
- `code-quality.md` - Tools qualità
- `development-tasks.md` - Script e automazioni
- `conventions.md` - Stile codice
- `laravel-boost.md` - MCP tools

### 4. **Module/Theme Documentation** (Priorità 📡 MEDIA)
Documentazione specifica per moduli e temi:
- `modules/modules.md` - Indice moduli
- `themes/themes.md` - Indice temi
- `{Module}/docs/README.md` - Docs modulo

---

## 🔧 Tools Documentazione

### 1. **Markdown Linting**
```bash
# Installa markdownlint
npm install -g markdownlint-cli

# Verifica stile
markdownlint docs/**/*.md

# Fix automatici
markdownlint --fix docs/**/*.md
```

### 2. **Link Checking**
```bash
# Installa markdown-link-check
npm install -g markdown-link-check

# Verifica link
find docs/ -name "*.md" -exec markdown-link-check {} \;
```

### 3. **Documentazione Generata**
```bash
# Script generazione indice
#!/bin/bash
echo "# 📚 Indice Documentazione PTVX\n"
echo "## 📋 Documenti Principali\n"

for file in docs/claude/*.md; do
    basename=$(basename "$file" .md)
    title=$(head -1 "$file" | sed 's/^# //')
    echo "- [$title](claude/$basename.md)"
done
```

---

## 📊 Metriche Qualità

### KPI Documentazione

| Metrica | Target | Misura |
|---------|--------|--------|
| **Copertura** | 95% moduli documentati | `find Modules/ -name "README.md" | wc -l` |
| **Link Validi** | 100% | `markdown-link-check docs/` |
| **Aggiornamenti** | < 30 giorni | `git log --since="30 days ago" -- docs/` |
| **Struttura** | 100% standard | `markdownlint docs/` |
| **Accessibilità** | < 3 click navigazione | Test manuale |

### Review Checklist

#### Contenuto
- [ ] Informazioni accurate e aggiornate
- [ ] Esempi di codice funzionanti
- [ ] Spiegazioni chiare e concise
- [ ] Riferimenti incrociati appropriati

#### Struttura
- [ ] Header gerarchici corretti
- [] Emoji consistenti nelle sezioni
- [ ] Metadata completo (versione, data, maintainer)
- [ ] Link relativi funzionanti

#### Stile
- [ ] Linguaggio professionale ma accessibile
- [ ] Formattazione markdown consistente
- [ ] Assenza di errori grammaticali
- [ ] Tono appropriato al pubblico

---

## 🚨 Anti-Patterns Documentazione

### 1. **Documentazione Obsoleta**
```markdown
# ❌ SBAGLIATO
## PHPStan Level 9
Usiamo PHPStan livello 9...

# ✅ CORRETTO
## PHPStan Level 10
Usiamo PHPStan livello 10 (aggiornato da v9 a Dicembre 2025)...
```

### 2. **Informazioni Duplicate**
```markdown
# ❌ SBAGLIATO - Duplicazione
# In core.md
## MAI usare property_exists()
...

# In eloquent-properties.md
## MAI usare property_exists()
...

# ✅ CORRETTO - Single Source
# In core.md
## Proprietà Eloquent
Vedi [Eloquent Properties](eloquent-properties.md) per dettagli completi.

# In eloquent-properties.md
## MAI usare property_exists()
Dettagli completi qui...
```

### 3. **Documentazione Troppo Tecnica**
```markdown
# ❌ SBAGLIATO
## Dependency Injection
Il pattern Dependency Injection è un pattern di inversione del controllo...

# ✅ CORRETTO
## Dependency Injection
Inietta dipendenze nel costruttore invece di crearle internamente:

```php
// ✅ Dependency injection
public function __construct(UserRepository $repository) {
    $this->repository = $repository;
}
```
```

---

## 🔄 Workflow Documentazione

### 1. **Development Phase**
- Scrivi documentazione mentre scrivi codice
- Aggiorna esempi quando implementi nuove features
- Documenta decisioni architetturali importanti

### 2. **Review Phase**
- Peer review della documentazione
- Verifica link e esempi funzionanti
- Controllo qualità con tools automatici

### 3. **Maintenance Phase**
- Review trimestrale della documentazione
- Aggiornamento con nuove versioni/framework
- Rimozione documentazione obsoleta

---

## 📚 Template Repository

### Modelli Riutilizzabili

```markdown
<!-- Template per documentazione modulo -->
# {{MODULE_NAME}}

> **FONDAMENTALE**: Breve descrizione del perché il modulo è importante.

## 🎯 Panoramica
Descrizione del modulo e suo scopo nel sistema PTVX.

## 🚀 Installazione
Passi per installare e configurare il modulo.

## 📋 Utilizzo
Esempi pratici di utilizzo del modulo.

## 🔧 Configurazione
Opzioni di configurazione disponibili.

## 🧪 Testing
Come testare il modulo.

## 📚 Riferimenti
Link ad altri documenti rilevanti.

---

**Versione**: 1.0  
**Priorità**: 📡 MEDIA  
**Aggiornamento**: {{DATA}}  
**Maintainer**: {{MAINTAINER}}
```

---

## 📋 Commit Documentation Standards

### Messaggi Commit per Documentazione

```bash
# ✅ CORRETTO
git commit -m "docs: add html2pdf integration guide"

git commit -m "docs: update phpstan level from 9 to 10"

git commit -m "docs: fix broken links in architecture rules"

# ❌ SBAGLIATO
git commit -m "update docs"

git commit -m "documentation changes"

git commit -m "fix readme"
```

### PR Template per Documentazione

```markdown
## Description
Breve descrizione dei cambiamenti documentazione.

## Type of Change
- [ ] Nuovo documento
- [ ] Aggiornamento documento esistente
- [ ] Fix documentazione
- [ ] Miglioramento stile/struttura

## Testing
- [ ] Link verificati funzionanti
- [ ] Esempi di codice testati
- [ ] Struttura markdown validata

## Impact
Quali impatti questi cambiamenti hanno sulla documentazione esistente?
```

---

## 📚 Riferimenti Correlati

- [Core Rules](core.md) - Regole fondamentali
- [Conventions](conventions.md) - Stile e convenzioni
- [Development Tasks](development-tasks.md) - Script e automazioni
- [Module Structure](module-structure.md) - Architettura moduli

---

**Versione**: 3.0 (Refactor DRY + KISS)  
**Priorità**: 📡 MEDIA - Policy documentazione  
**Aggiornamento**: Dicembre 2025

> **💡 Principio**: "Buona documentazione è come buon codice: non esiste, si evolve costantemente."