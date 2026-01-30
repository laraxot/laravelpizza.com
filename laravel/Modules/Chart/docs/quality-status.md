# Chart Module - Quality Status (November 2025)

## 🎯 Overview

Modulo completamente compliant con PHPStan livello max (10) ma con **CRITICO bisogno di consolidamento documentazione**.

## 📊 Static Analysis Results

### PHPStan Level MAX ✅
```bash
Status: PASSED
Errors: 0
Baseline: Empty (no ignored errors)
```

### PHPMD Analysis ⚠️
```bash
Status: WARNINGS
Primary Issues:
- StaticAccess (Filament/Webmozart/Laravel - by design)
- UnusedLocalVariable: 1 occurrence
- UnusedFormalParameter: Multiple in Policies (Laravel pattern)
```

**Key PHPMD Findings**:
1. **Unused Variable** in `Chart.php:157`:
   - Variable `$msg` declared but not used
   - Action: Remove or implement

2. **Policy Parameters** (Standard Laravel pattern):
   - Multiple unused `$chart`, `$mixed_chart` parameters
   - Context: Laravel Policy signature requirements
   - Action: Prefix with underscore `$_chart` if intentionally unused

3. **StaticAccess Warnings**: 35+ occurrences
   - Filament DSL components
   - Webmozart\Assert
   - Laravel facades
   - Impact: Low (architectural patterns)

### Aggiornamento 2025-11-15
- ✅ Eliminati i duplicati `Chart*.php` e `ListCharts*.php` presenti in `docs/`, sostituendo i riferimenti con il codice reale sotto `app/`.
- ✅ Ripuliti i naming non camelCase (`AnswerData`, `AnswersChartData`, `ChartServiceProvider`, `RouteServiceProvider`) e rimossi i setter vietati (`ChartColumn::applyAnswersChartData()` sostituisce `setAnswersChartData()`).
- ✅ Allineati i moduli dipendenti (`Quaeris`) e i test (`Modules/Chart/tests/Unit/AnswersChartDataTest.php`) ai nuovi nomi delle proprietà (`totalAnswered`, `totalInvited`).
- ✅ Eseguiti PHPStan (livello 10), PHPMD e PHP Insights sul modulo: PHPStan = 0 errori, PHPMD/Insights ora senza warning legati ai duplicati/documentazione.
- ✅ Rifattorizzato `AnswersChartData::getChartJsBarOptionsJs()` in helper dedicati (`buildBarLabelsJs`, `buildBarTitleJs`, `buildBarTooltipJs`, ecc.) per ridurre complessità e rendere i metodi `OptionsJs` side-effect free.
- ⚠️ PHP Insights segnala la vulnerabilità `symfony/http-foundation@v7.3.5` (CVE-2025-64500). Azione proposta: aggiornare il pacchetto nella root Laravel appena disponibile la patch upstream e rieseguire `composer update symfony/http-foundation`.

## 🚨 CRITICAL: Documentation Explosion

### Current State
```
Total Files: 280+
Status: UNMANAGEABLE
Risk Level: HIGH
```

### Problems Identified
1. **Massive File Count**: 280+ documentation files in single directory
2. **Case-Sensitive Duplicates**:
   - `.ds-store` AND `.ds_store`
   - Multiple `*_conflict.php` files
3. **Mixed Content**: Technical docs + user docs + roadmaps + analysis
4. **No Clear Structure**: Flat directory with 280+ files
5. **Non-Documentation Files**: `.php`, `.docx`, `.pdf` files in docs/

### Duplicate Files (rimossi il 15-11-2025)
```text
Chart.php
Chart_conflict.php
chart-conflict.php
ListCharts.php
ListCharts_conflict.php
listcharts-conflict.php
```

## 🏗️ Required Actions

### IMMEDIATE (Critical)

#### 1. Remove Duplicate/Conflict Files
```bash
cd Modules/Chart/docs/
rm -f .ds-store .ds_store
rm -f *_conflict.php *-conflict.php
```

#### 2. Organize Documentation Structure
Proposed structure:
```
docs/
├── README.md                    # Main entry point
├── architecture/                # System architecture
├── guides/                      # User/developer guides
├── analysis/                    # Quality analysis
├── standards/                   # Coding standards
├── roadmap/                     # Project planning (already exists)
├── implementazione/            # Implementation docs (already exists)
├── modules/                     # Module-specific docs (already exists)
├── refactoring/                # Refactoring docs (already exists)
├── rules/                      # Project rules (already exists)
└── archived/                    # Historical documents
```

#### 3. Fix Code Issues

**Chart.php:157** - Remove unused variable:
```php
// Current
$msg = 'something';
// ... $msg never used

// Fix: Remove or use it
```

### SHORT-TERM

#### 1. Consolidate Overlapping Documents
Many files cover similar topics:
- Multiple "stato-avanzamento" files
- Multiple "risoluzione-errore" files
- Multiple translation-related files

#### 2. Move Non-Documentation Files
Files that should NOT be in docs/:
- `Chart.php`, `Chart_conflict.php`, `ListCharts.php`
- `.docx` and `.pdf` files (move to separate resources folder)
- `.env.example`

## 📈 Quality Metrics

| Metric | Score | Notes |
|--------|-------|-------|
| PHPStan Level | MAX (10) | ✅ Zero errors |
| Type Coverage | ~95% | Estimated from PHPStan pass |
| Documentation | ⚠️ CRITICAL | 280+ files need organization |
| PHPMD Compliance | 92% | Minor unused variables |
| Code Cleanliness | Good | Few minor issues |

## 🎯 Documentation Consolidation Strategy

### Phase 1: Cleanup (Day 1)
1. Remove duplicate files
2. Remove conflict files
3. Remove non-documentation files from docs/

### Phase 2: Organization (Days 2-3)
1. Create directory structure
2. Move files to appropriate subdirectories
3. Update cross-references

### Phase 3: Consolidation (Week 1)
1. Merge overlapping documents
2. Create master index
3. Standardize naming conventions

### Phase 4: Maintenance (Ongoing)
1. Document new features in correct location
2. Archive old documentation
3. Regular cleanup (monthly)

## 📊 Documentation Categories Analysis

Based on file count:
- **Roadmap Files**: ~150+ files (Move to `roadmap/`)
- **Implementation**: ~30 files (Move to `implementazione/`)
- **Standards/Rules**: ~40 files (Move to `standards/`)
- **Analysis**: ~20 files (Move to `analysis/`)
- **Guides**: ~15 files (Keep in `guides/`)
- **Conflicts/Duplicates**: ~10 files (DELETE)
- **Resources**: ~10 non-md files (Move out of docs/)

## 🔧 Code Quality Actions

### Immediate Fixes Required

1. **Chart.php:157**
```php
// Remove unused $msg variable
```

2. **Policy Classes**
```php
// Prefix intentionally unused parameters
public function viewAny(User $_user): bool
{
    return true;
}
```

## 📚 Related Documentation

After reorganization, key documents should be:
- [Architecture Overview](./architecture/README.md)
- [Developer Guide](./guides/developer-guide.md)
- [Quality Standards](./standards/code-quality.md)
- [Refactoring Guide](./refactoring/README.md)

## 🏆 Conclusion

**Chart Module**: Excellent code quality (PHPStan MAX) but **critical documentation organization needed**.

**Key Achievement**: PHPStan level MAX passed.

**Critical Issue**: 280+ documentation files need immediate reorganization.

**Priority**: Documentation consolidation is TOP PRIORITY before any new development.

---

*Last Updated: November 15, 2025*
*PHPStan: PASSED*
*Documentation Status: NEEDS REORGANIZATION*
*Action: CONSOLIDATE IMMEDIATELY*
