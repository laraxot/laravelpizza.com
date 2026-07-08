# 🧘 Zen of FixCity - Complete Philosophy

**Version**: 2.0  
**Created**: 2026-03-30  
**Status**: ✅ Active  
**Owner**: Multi-Agent Team

---

## 🎯 The Five Pillars

### 1. **Git Forward-Only** 🚀

> **Non si torna mai indietro. Si studia il passato per migliorare.**

**Principi**:
- ✅ `git rebase` invece di `git reset`
- ✅ `git revert` invece di `git checkout <old-commit>`
- ✅ Studiare commit history per capire decisioni
- ✅ Documentare lezioni apprese
- ✅ Mai force-push su branch condivisi

**Comandi**:
```bash
# ✅ CORRETTO: Rebase per pulire history
git rebase -i HEAD~5

# ✅ CORRETTO: Revert per annullare cambiamenti
git revert <commit-hash>

# ❌ SBAGLIATO: Reset che distrugge history
git reset --hard HEAD~5

# ❌ SBAGLIATO: Checkout di vecchi commit
git checkout abc123
```

**Perché**:
- La history è sacra
- Ogni commit racconta una storia
- Si può imparare dal passato
- I team collaborano meglio

---

### 2. **DRY + KISS** 📐

> **Ogni concetto UNA volta. Semplice, non stupido.**

**DRY (Don't Repeat Yourself)**:
- Ogni concetto documentato UNA volta
- Codice riutilizzabile, non copiato
- Single Source of Truth (SSOT)
- Cross-reference invece di duplicazione

**KISS (Keep It Simple, Stupid)**:
- Max 3 livelli di nesting
- File < 500 righe
- Funzioni < 50 righe
- Naming descrittivo

**Esempi**:

**❌ SBAGLIATO** (38 file identici):
```
pages/tests/argomenti.blade.php
pages/tests/homepage.blade.php
pages/tests/servizi.blade.php
... (35 più)
```

**✅ CORRETTO** (1 file dinamico):
```
pages/tests/[slug].blade.php  // Gestisce 38 pagine
```

---

### 3. **Universal Block Taxonomy** 🧱

> **I blocchi vengono da Flowbite, Tailwind UI, DaisyUI.**

**10 Categorie Universali**:

| Categoria | Scopo | Esempi |
|-----------|-------|--------|
| `navigation` | Navigazione | navbar, breadcrumb, steps, tabs |
| `hero` | Header pagina | center, left, right, with-image |
| `marketing` | Promozione | features, cta, testimonials, faq |
| `content` | Contenuto | text, image, video, cards, topics-grid |
| `layout` | Struttura | container, grid, columns, divider |
| `data` | Dati | stats, table, list, description-list |
| `forms` | Input | contact-form, search-form, signin |
| `feedback` | Feedback | alert, banner, toast, progress |
| `ecommerce` | Shopping | product-card, cart, checkout |
| `dashboard` | Admin | stats-cards, activity-feed |

**Golden Rule**:
```
Block type: <category>/<block_type>
View: pub_theme::components.blocks.<category>.<block_type>
File: blocks/<category>/<block_type>.blade.php
```

**Esempio Corretto**:
```json
{
  "type": "content/topics-grid",
  "data": {
    "view": "pub_theme::components.blocks.content.topics-grid"
  }
}
```

**❌ SBAGLIATO**:
```json
{
  "type": "argomenti",
  "data": {
    "view": "pub_theme::components.blocks.tests.argomenti"
  }
}
```

---

### 4. **Folio + Volt Routing** ⚡

> **File-based routing, zero configurazione.**

**Pattern**:
```
pages/
├── tests/
│   ├── [slug].blade.php    // Dynamic: 38 pages
│   └── index.blade.php     // Static: index
```

**[slug].blade.php**:
```php
new class extends Component {
    public function mount(string $slug): void
    {
        $this->pageSlug = 'tests.'.$slug;
    }
};
```

**Perché**:
- ✅ 38 pagine → 1 file
- ✅ Zero routing configuration
- ✅ Automatico, convenzionale
- ✅ DRY + KISS compliant

---

### 5. **Multi-Agent Collaboration** 🤖

> **Più agenti AI lavorano insieme. Coordina, non isolare.**

**Strumenti**:

| Strumento | Scopo | Comando |
|-----------|-------|---------|
| **OpenViking** | Context preservation | `openviking add-memory` |
| **BMAD** | Requirements & Architecture | `_bmad/threads/` |
| **GSD** | Phase execution | `.planning/phases/` |
| **Ralph Loop** | Autonomous tasks | `ralph-loop run` |
| **NotebookLM** | Source-grounded Q&A | `python scripts/run.py ask_question.py` |

**Protocollo**:
1. Check OpenViking context
2. Check BMAD threads
3. Declare intention su GitHub
4. Execute con GSD phases
5. Log decisions
6. Run quality gates
7. Commit with evidence

---

## 📚 Documentation Philosophy

### Living Documentation

> **La documentazione che si aggiorna da sola.**

**Strumenti**:
- **PHPDoc** → Genera API docs automaticamente
- **Tests** → Documentano comportamento
- **Type hints** → Documentano contratti
- **Git history** → Traccia cambiamenti temporali

**❌ SBAGLIATO**:
```markdown
# Last Updated: 2026-03-30
# Version: 1.0.0
```

**✅ CORRETTO**:
```markdown
<!-- No temporal strings -->
<!-- Use git log --follow docs/file.md for history -->
```

### Single Source of Truth

> **Ogni concetto documentato UNA volta.**

**Struttura**:
```
docs/                              # Root (SSOT)
├── MASTER_DOCUMENTATION_INDEX.md
├── ZEN_OF_DOCUMENTATION.md
├── architecture/
├── guides/
└── conventions/

laravel/Modules/*/docs/            # Module-specific (1 index)
├── 00-index.md
├── architecture/
└── guides/

laravel/Themes/*/docs/             # Theme-specific (1 index)
├── 00-index.md
└── design-comuni/
```

**Regole**:
- 1 index per modulo
- Cross-reference invece di duplicazione
- No temporal strings
- Bidirectional linking

---

## 🛠️ Quality Gates

### Git Forward-Only

```bash
# Pre-commit hook
if git rev-parse --verify HEAD >/dev/null 2>&1; then
    # Check for reset/revert attempts
    if git diff --cached --name-only | grep -q "reset\|revert"; then
        echo "❌ Use git revert, not git reset"
        exit 1
    fi
fi
```

### DRY Check

```bash
# Find duplicate content
./bashscripts/docs/check-duplicates.sh

# Target: <1% duplicate content
```

### Block View Validation

```bash
# Validate block views exist
./bashscripts/docs/validate-block-views.sh

# Target: 100% compliance
```

### Documentation Index

```bash
# Check all docs are indexed
./bashscripts/docs/check-orphans.sh

# Target: <5% orphaned files
```

---

## 📊 Metrics

| Metric | Target | Current | Status |
|--------|--------|---------|--------|
| Git Reset/Revert | 0 | 0 | ✅ |
| Duplicate Content | <1% | 43-57% | 🔴 |
| Universal Block Compliance | 100% | 10% | 🔴 |
| Folio + Volt Pages | 100% | 100% | ✅ |
| Documentation Indexed | 95%+ | 50% | 🔴 |
| Multi-Agent Coordination | 100% | 80% | 🟡 |

---

## 🚀 Implementation Roadmap

### Phase 1: Foundation ✅
- [x] Define Zen philosophy
- [x] Create documentation structure
- [x] Establish Git forward-only

### Phase 2: Block Taxonomy 🟡
- [x] Define universal categories
- [ ] Create all block views (GSD Phase 06)
- [ ] Refactor JSON files

### Phase 3: Documentation Cleanup ⏳
- [ ] Remove duplicates
- [ ] Create indices
- [ ] Add cross-references

### Phase 4: Automation ⏳
- [ ] CI/CD quality gates
- [ ] Automated validation
- [ ] Ralph Loop maintenance

---

## 📞 Coordination

### OpenViking Context

```bash
openviking add-memory \
  --title="Zen of FixCity" \
  --content="5 pillars: Git Forward-Only, DRY+KISS, Universal Blocks, Folio+Volt, Multi-Agent"
```

### BMAD Thread

```
_bmad/threads/zen-documentation.md
```

### GSD Phases

```
.planning/phases/
├── 05-create-tests-blocks/
├── 06-create-universal-blocks/
├── 07-documentation-cleanup/
└── 08-automation/
```

---

## 🎯 Success Criteria

- ✅ Git history preservata (no reset/revert)
- ✅ 0% duplicate content
- ✅ 100% universal block compliance
- ✅ 100% Folio + Volt routing
- ✅ 95%+ documentation indexed
- ✅ Multi-agent coordination 100%

---

**Last Updated**: 2026-03-30  
**Next Review**: After Phase 2 completion  
**Owner**: Multi-Agent Team
