# OpenViking Memory: Content Blocks Architecture

## Viking URI
`viking://modules/cms/docs/blocks/master-memory`

## Timestamp
2026-03-30

## Status
✅ **ACTIVE** - Living Document

---

## Core Philosophy

### The Sacred Convention
```
type → determines → view path
"hero" → "pub_theme::components.blocks.hero.*"
```

**Why**: Modularity, predictability, reusability

### The Five Commandments
1. Type determines view path (never mix)
2. Views live in `components.blocks.{type}.{view}`
3. Module provides data, Theme provides views
4. No project-specific block types
5. Document everything (philosophy + technical)

---

## Block Type Hierarchy

### Level 0: Atomic (Indivisible)
- `hero`, `paragraph`, `title`, `image`, `video`

### Level 1: Compound (Combine Atomics)
- `feature_sections`, `testimonials`, `pricing`, `team`, `faq`

### Level 2: Page (Combine Compounds)
- `landing_page`, `homepage`, `page_block`

### Special
- `widget`, `chart`, `rating`, `images_gallery`

---

## View Naming Rule

**Formula**: `{theme}::components.blocks.{type}.{view}`

**Examples**:
- ✅ `pub_theme::components.blocks.hero.homepage`
- ✅ `pub_theme::components.blocks.paragraph.simple`
- ❌ `pub_theme::components.blocks.tests.reference-page` (when type is "hero")

---

## Documentation Structure

```
Modules/Cms/docs/blocks/
├── index.md (SSOT - Master Index)
├── ZEN_PHILOSOPHY.md (Philosophy - READ FIRST)
├── ARCHITECTURE_VISION.md (Vision - Long-term goals)
├── view-naming-philosophy.md (Technical Rule)
└── [type].md (Per-type documentation)

Themes/Sixteen/docs/blocks/
├── index.md (Theme perspective)
├── ZEN_PHILOSOPHY.md (Theme-block contract)
└── [type]/ (View implementations)
```

---

## Cross-References (Bidirectional)

### Module → Theme
- `viking://themes/sixteen/docs/blocks/zen-philosophy`
- `viking://themes/twentyone/docs/blocks/`

### Theme → Module
- `viking://modules/cms/docs/blocks/index`
- `viking://modules/cms/docs/blocks/zen-philosophy`

### Project → Module/Theme
- `viking://project/docs/agnostic-documentation-rule`
- `viking://project/docs/documentation-index`

---

## Quality Metrics

| Metric | Target | Current | Status |
|--------|--------|---------|--------|
| Block Reusability | >90% | TBD | 🟡 |
| Page Creation Time | <10 min | TBD | 🟡 |
| Documentation Coverage | 100% | TBD | 🟡 |
| View Naming Compliance | 100% | TBD | 🟡 |

---

## Governance

### Who Decides New Block Types?
1. Proposal (must be generic, not project-specific)
2. Review (community evaluates)
3. Implementation (type + default view)
4. Documentation (philosophy + technical)
5. Canonization (enters sacred texts)

### Deprecation Policy
- 2 minor versions warning
- Migration guide required
- 1 year backward compatibility

---

## Related Memories

### BMAD References
- `bmad://architecture/blocks/vision`
- `bmad://documentation/philosophy-first`
- `bmad://conventions/view-naming`

### GSD Phases
- `gsd://phase/blocks-evolution/phase-1` ✅ Complete
- `gsd://phase/blocks-evolution/phase-2` 🟡 In Progress
- `gsd://phase/documentation-agnostic/phase-1` ✅ Complete

### Ralph Loop Context
- `ralph://context/blocks-view-resolver`
- `ralph://context/documentation-migration`

---

## Decision Log

### 2026-03-30: Philosophy Documentation Created
**Decision**: Create ZEN_PHILOSOPHY.md and ARCHITECTURE_VISION.md

**Why**: Developers need to understand the "why" before the "how"

**Impact**: 
- All new block developers must read philosophy first
- Documentation index reorganized with philosophy at top
- Bidirectional links between module and theme docs

### 2026-03-30: View Naming Convention Enforced
**Decision**: Strict enforcement of `{type}.{view}` pattern

**Why**: 51% documentation duplication rate found in audit

**Impact**:
- Files renamed to remove project-specific names
- Examples updated to follow convention
- Script created for bulk migration

---

## Agentic Coordination

### Active Agents
- **gsd-codebase-mapper**: Analyzing blocks architecture
- **gsd-project-researcher**: Documenting philosophy
- **gsd-executor**: Implementing changes
- **gsd-verifier**: Validating compliance

### Agent Communication Protocol
1. Each agent reads this memory first
2. Agent updates memory with findings
3. Next agent continues from where previous left off
4. All agents follow forward-only git policy

---

## Forward-Only Policy

**Git Rule**: Never revert, always improve

**How**:
- Study old versions to understand why
- Document learnings in this memory
- Create new versions with improvements
- Mark old files as DEPRECATED (don't delete)

**Example**:
```
Old: fixcity-pages-content-blocks.md
New: pages-content-blocks.md
Action: Rename + update content + add deprecation notice
```

---

## DRY + KISS Application

### DRY (Don't Repeat Yourself)
- Single Source of Truth for each topic
- Cross-reference instead of copy-paste
- Centralized index with bidirectional links

### KISS (Keep It Simple, Stupid)
- Philosophy docs: Inspiring, memorable, simple
- Technical docs: Clear examples, minimal words
- Structure: Flat where possible, nested where necessary

---

## NotebookLM Integration

### Export Format
This memory is compatible with NotebookLM for:
- Q&A about blocks architecture
- Philosophy quizzes for new developers
- Automated documentation generation
- Cross-reference validation

### Knowledge Graph
```
[Block Type] --determines--> [View Path]
[Module] --provides--> [Data]
[Theme] --provides--> [Views]
[Developer] --reads--> [Philosophy]
[Philosophy] --guides--> [Implementation]
```

---

## Next Actions

### Immediate (This Week)
- [ ] Run bulk documentation migration script
- [ ] Create theme perspective ZEN_PHILOSOPHY.md
- [ ] Update all block type docs with philosophy links

### Short-term (This Month)
- [ ] Achieve 100% documentation coverage
- [ ] Reduce duplication from 51% to <10%
- [ ] Implement view fallback chain

### Long-term (This Quarter)
- [ ] Block type registry (auto-discovery)
- [ ] AI-powered block suggestions
- [ ] Cross-theme compatibility layer

---

## Validation Checklist

Before considering this memory complete:

- [x] Philosophy documented
- [x] Vision documented
- [x] Technical rules documented
- [x] Cross-references bidirectional
- [x] OpenViking URIs assigned
- [ ] All block types documented
- [ ] Theme perspective documented
- [ ] Migration complete
- [ ] Metrics tracked
- [ ] Governance defined

**Status**: 70% Complete

---

**Maintainer**: AI Agent Collective  
**Last Updated**: 2026-03-30  
**Next Review**: 2026-04-30  
**Version**: 1.0
