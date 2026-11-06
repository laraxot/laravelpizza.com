---
title: "CONSOLIDATION PLAN"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "CONSOLIDATION PLAN"
issues: []
discussions: []
status: superseded
superseded_by: consolidation_plan.md
---

# Lang Module Docs Consolidation Plan

**Phase:** 2d Aggressive Merge  
**Current:** 579 total files (339 .md at root)  
**Target:** ≤30 files at root  
**Strategy:** Delete duplicates → Consolidate by topic → Move research to wiki/

---
## Quick Stats

| Category | Current | Target | Action |
|----------|---------|--------|--------|
| Translation files | 65 | 4 | Consolidate by topic |
| Conflict resolution | 17 | 1 | Unified guide |
| Validation | 4 | 2 | Keep both, complementary |
| PHPSTAN | 3 | 2 | Merge fixes into L10 |
| Duplicates (kebab/snake) | ~40 | 0 | Delete all snake_case |
| Obsolete (Italian) | 9 | 0 | Delete all |
| Root .md files | 339 | ~24 | Consolidate |
| **Total files** | **579** | **~150** | **74% reduction** |

---

## Consolidation Steps

### 1. DELETE DUPLICATES (Kebab vs Snake Case): ~30 files

Keep kebab-case (e.g., `translation-system.md`); delete snake_case (`translation_system.md`).

**Delete:**
```
advanced_language_switching.md
automatic_translations.md
cms_link.md
conflict_resolution_*.md (all snake_case variants)
docs_naming_convention_fix.md
documentation_link_conventions.md
errori_comuni_traduzione.md
lang_link.md
lang_service_helper_text_fix.md
lang_service_provider.md (if duplicate)
lang_service_provider_improvements.md
laravel_localization.md
translation_*.md (all snake_case)
translating_*.md (all snake_case)
validation_*.md (all snake_case)
working_with_locales.md
```

### 2. DELETE OBSOLETE FILES: ~20 files

Italian corrections, outdated analyses, and non-canonical content.

**Delete:**
```
# Italian corrections (obsolete)
correzioni-*.md
correzioni_*.md
metodi-duplicati-analisi.md
metodi_duplicati_analisi.md
tradizioni-*.md
traduzioni*.md
translationes.md
translationness.md
struttura*.md

# Analysis artifacts (not docs)
analysis-results.md
bottlenecks.md
cyclomatic-complexity.md
dependency-intelligence.md
docs-health.md
coverage.md
REDUNDANCY_ANALYSIS.md

# Index duplicates (consolidate into README.md)
00-INDEX.md
00-index.md
INDEX.md
```

### 3. CONSOLIDATE TRANSLATION FILES (65 → 4)

Merge topic-related files into four canonical documents:

#### **translation-system.md** (System architecture)
Merge: `translation-file-syntax.md`, `translation-field-structure-*.md`, `translation-completion.md`, `static-text-translation.md`, `automatic-translations.md`

#### **translation-management.md** (Workflow & editing)
Merge: `translation-file-editor.md`, `translation-file-management.md`, `translation-files-update*.md`, `translation-management-packages.md`, `translation-refactor*.md`

#### **translation-keys.md** (Naming & structure)
Merge: `translation-keys-best-practices.md`, `translation-keys-rules.md`, `translation-standards*.md`, `common-translations.md`, `translation-helper-text-standards.md`

#### **translation-validation.md** (Validation & errors)
Merge: `translation-validation*.md`, `translation-errors-correction.md`, `translation-fixes*.md`, `translation-syntax-fixes.md`, `translation-preservation*.md`

### 4. CONSOLIDATE CONFLICT RESOLUTION (17 → 1)

**conflict-resolution.md** (Unified guide)
Merge: All `conflict-resolution-*.md`, `conflicts*.md`, `case-conflicts.md`, `case-sensitivity*.md`

### 5. CONSOLIDATE VALIDATION (4 → 2)

Keep both (complementary):
- **validation-messages.md**: Structure & standards
- **translating-validation-messages.md**: Usage with plurals

Merge: `translating-plural-singular-forms.md`

### 6. CONSOLIDATE PHPSTAN (3 → 2)

- **PHPSTAN_L10.md**: Merge PHPSTAN-FIXES.md + PHPSTAN_STATUS.md into this
- Delete: `PHPSTAN-FIXES.md`, `PHPSTAN_STATUS.md`

### 7. MOVE TO WIKI/ SUBDIRECTORIES: ~40 files

Create subdirs and move strategy/research content (not essential to module root):

```bash
mkdir -p wiki/strategies wiki/how-to wiki/overviews wiki/rules

# Move strategy/research
mv PRODUCT_LAUNCH_PLAN.md wiki/strategies/
mv TRANSLATION_STRATEGIES.md wiki/strategies/
mv USER_RESEARCH.md wiki/strategies/
mv PERFORMANCE-OPTIMIZATION.md wiki/overviews/
mv SPRINT_PLANNING.md wiki/strategies/

# Move how-to guides
mv QMD-SETUP.md wiki/how-to/
mv QUICK_REFERENCE.md wiki/how-to/
mv best-practices.md wiki/how-to/
mv laravel-localization-reference.md wiki/how-to/
mv laravel_localization_complete.md wiki/how-to/
mv localizing_dates_and_currencies.md wiki/how-to/
mv pluralization_and_localization.md wiki/how-to/
mv working-with-locales.md wiki/how-to/

# Move technical overviews
mv api-reference.md wiki/overviews/
mv business-logic-overview.md wiki/overviews/
mv console-commands.md wiki/overviews/
mv database-model-coverage.md wiki/overviews/
mv schema.md wiki/overviews/

# Move rules/patterns
mv ON-DEMAND-PATTERN.md wiki/rules/
mv MCAMARA_IMPLEMENTATION_GUIDE.md wiki/overviews/
```

---

## Final Root Structure (Target: ~24 files)

```
laravel/Modules/Lang/docs/
├── README.md                         # Entry point (anchor for all docs)
├── PHPSTAN_L10.md                   # Technical status & fixes
├── MIGRATIONS.md                    # Schema/migrations
├── PRODUCT_STRATEGY.md              # Product vision (optional: move to wiki/)
├── LOCALE_MANAGEMENT.md             # Locale management basics
│
├── translation-system.md            # Core: system arch + syntax
├── translation-management.md        # Core: workflow + editing
├── translation-keys.md              # Core: naming rules
├── translation-validation.md        # Core: validation + errors
│
├── validation-messages.md           # Validation message standards
├── translating-validation-messages.md # Validation with plurals
│
├── conflict-resolution.md           # Unified conflict guide
│
├── langbase-classes-requirements.md # API reference
├── enum-translation.md              # Enum translation guide
├── models-factory-seeder.md         # Model/factory/seeder integration
│
├── autoregistration-commands.md     # Console commands
├── lang-service-provider.md         # Service provider structure
│
├── agent-confidence-discipline.md   # Meta guidelines
├── agent-confidence-protocol.md     # Meta guidelines
│
├── architecture/                    # (existing)
├── wiki/                           # (research/strategy/how-to)
├── raw/                            # (archives)
└── (other essential subdirs)
```

---

## Implementation Commands

### Backup
```bash
cd /var/www/_bases/<nome repository>
git add -A
git commit -m "backup: Lang docs before consolidation"
```

### Execute Consolidation
```bash
cd laravel/Modules/Lang/docs

# 1. Delete duplicates (snake_case)
rm -f \
  advanced_language_switching.md \
  automatic_translations.md \
  cms_link.md \
  docs_naming_convention_fix.md \
  documentation_link_conventions.md \
  errori_comuni_traduzione.md \
  lang_link.md \
---
  lang-link.md \
---
  lang_link.md \
  lang_service_helper_text_fix.md \
  laravel_localization.md \
  translation_*.md \
  translating_*.md \
  validation_*.md \
  working_with_locales.md

# 2. Delete obsolete Italian/analysis
rm -f \
  correzioni-*.md \
  metodi-duplicati-analisi.md \
  metodi_duplicati_analisi.md \
  tradizioni-*.md \
  traduzioni*.md \
  translationes.md \
  translationness.md \
  struttura*.md \
  analysis-results.md \
  bottlenecks.md \
  cyclomatic-complexity.md \
  dependency-intelligence.md \
  docs-health.md \
  coverage.md \
  REDUNDANCY_ANALYSIS.md \
  00-index.md \
  index.md
---
  00-index.md \
  00-index.md \
  index.md
---
  00-INDEX.md \
  00-index.md \
  INDEX.md

# 3. Delete conflict-resolution snake_case variants
rm -f conflict_resolution_*.md

# 4. Delete lang_service_provider variants (keep lang-service-provider.md)
rm -f lang_service_provider.md lang_service_provider_improvements.md

# 5. Create wiki subdirectories
mkdir -p wiki/strategies wiki/how-to wiki/overviews wiki/rules

# 6. Move strategy/research files
mv PRODUCT_LAUNCH_PLAN.md wiki/strategies/ 2>/dev/null || true
mv TRANSLATION_STRATEGIES.md wiki/strategies/ 2>/dev/null || true
mv USER_RESEARCH.md wiki/strategies/ 2>/dev/null || true
mv PERFORMANCE-OPTIMIZATION.md wiki/overviews/ 2>/dev/null || true
mv SPRINT_PLANNING.md wiki/strategies/ 2>/dev/null || true

# 7. Move how-to guides
mv QMD-SETUP.md wiki/how-to/ 2>/dev/null || true
mv QUICK_REFERENCE.md wiki/how-to/ 2>/dev/null || true
mv best-practices.md wiki/how-to/ 2>/dev/null || true
mv laravel-localization-reference.md wiki/how-to/ 2>/dev/null || true
mv laravel_localization_complete.md wiki/how-to/ 2>/dev/null || true
mv localizing_dates_and_currencies.md wiki/how-to/ 2>/dev/null || true
mv pluralization_and_localization.md wiki/how-to/ 2>/dev/null || true
mv working-with-locales.md wiki/how-to/ 2>/dev/null || true

# 8. Move technical overviews
mv api-reference.md wiki/overviews/ 2>/dev/null || true
mv business-logic-overview.md wiki/overviews/ 2>/dev/null || true
mv console-commands.md wiki/overviews/ 2>/dev/null || true
mv database-model-coverage.md wiki/overviews/ 2>/dev/null || true
mv schema.md wiki/overviews/ 2>/dev/null || true
mv MCAMARA_IMPLEMENTATION_GUIDE.md wiki/overviews/ 2>/dev/null || true

# 9. Move rules
mv ON-DEMAND-PATTERN.md wiki/rules/ 2>/dev/null || true

# 10. Merge PHPSTAN files (manual step: see section below)
# (Requires reading PHPSTAN-FIXES.md + PHPSTAN_STATUS.md into PHPSTAN_L10.md)
```

### Verify Results
```bash
cd laravel/Modules/Lang/docs
echo "Root .md files after consolidation:"
ls -1 *.md | wc -l

echo "Total files in docs:"
find . -type f | wc -l

echo "Files by directory:"
for dir in */; do 
  count=$(find "$dir" -type f | wc -l)
  echo "  $count $dir"
done | sort -rn
```

---

## Merge Instructions (Manual Steps)

### Merge PHPSTAN Files

1. **Read PHPSTAN-FIXES.md and PHPSTAN_STATUS.md** for key content
2. **Append key sections to PHPSTAN_L10.md**:
   - Status summary from PHPSTAN_STATUS.md
   - Fix strategies from PHPSTAN-FIXES.md
3. **Delete the two source files**:
   ```bash
   rm PHPSTAN-FIXES.md PHPSTAN_STATUS.md
   ```

### Consolidate Translation Files

For each of the 4 canonical files (translation-system.md, translation-management.md, translation-keys.md, translation-validation.md):

1. **Identify matching files** from the consolidation plan above
2. **Read each source file** and extract key sections
3. **Append/integrate into canonical file** with clear subsection headers
4. **Delete source files** after verifying content is preserved
5. **Add forward references** in README.md if needed

Example workflow:
```bash
# For translation-system.md consolidation:
# 1. Read: translation-file-syntax.md, translation-field-structure-*.md, etc.
# 2. Append key sections to translation-system.md with new headings
# 3. rm translation-file-syntax.md translation-field-structure-*.md ...
```

---

## Final Commit

```bash
cd /var/www/_bases/<nome repository>
git add -A
git commit -m "chore: Lang docs aggressive consolidation: 579→150 files, 339→24 root

- Delete 40 duplicates (kebab/snake case variants)
- Delete 20 obsolete files (Italian corrections, analysis artifacts)
- Consolidate translation files (65→4 canonical)
- Consolidate conflict resolution (17→1 unified)
- Move strategy/research to wiki/ subdirectories (40 files)
- Merge PHPSTAN files (3→2)
- Root structure now: 24 files (target ≤30) ✓
- Total reduction: 74% fewer files, 93% cleaner root"
```

---

## Before/After Comparison

### Before
```
laravel/Modules/Lang/docs/
├── 339 .md files (root)
├── 579 total files
├── 65 translation-*.md variants
├── 17 conflict-*.md variants
├── ~40 kebab/snake duplicates
├── 9 obsolete Italian files
├── Multiple index files (00-INDEX, INDEX, 00-index)
└── Chaotic: no clear separation (docs mixed with strategy/research/analysis)
```

### After
```
laravel/Modules/Lang/docs/
├── 24 .md files (root): essential only
├── ~150 total files
├── 4 translation-* canonical files
├── 1 conflict-resolution.md
├── 0 duplicates
├── 0 obsolete files
├── 1 index anchor (README.md)
├── wiki/strategies/: product/planning
├── wiki/how-to/: guides
├── wiki/overviews/: technical reference
├── wiki/rules/: patterns & rules
└── Clean: clear separation (root=essential, wiki=research)
```

---

## Metrics

| Metric | Before | After | Change |
|--------|--------|-------|--------|
| Root .md files | 339 | 24 | -93% |
| Total files | 579 | ~150 | -74% |
| Translation files | 65 | 4 | -94% |
| Conflict files | 17 | 1 | -94% |
| Duplicates | 40+ | 0 | -100% |
| Obsolete files | 9 | 0 | -100% |
| Navigation clarity | Low | High | ✓ |

---

## Success Criteria

- [ ] Root .md count ≤ 30 (target: 24)
- [ ] Zero duplicates (all snake_case deleted)
- [ ] Zero obsolete files (all Italian corrections removed)
- [ ] Translation consolidation: 65 → 4 files
- [ ] Conflict consolidation: 17 → 1 file
- [ ] All research/strategy moved to wiki/ subdirectories
- [ ] README.md serves as single entry point
- [ ] Git history preserved (no force resets)
- [ ] All changes committed atomically
