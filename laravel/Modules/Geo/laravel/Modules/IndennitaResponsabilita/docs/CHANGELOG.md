# Changelog - Modulo IndennitaResponsabilita

All notable changes to this module will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

---

## [Unreleased]

### Added
- Complete code quality analysis (41 violations identified)
- Refactoring action plan with 18 detailed tasks
- Best practices guide with DO/DON'T patterns
- Trait responsibility violation analysis
- Rating schemaless usage documentation

### Changed
- Updated README with analysis links
- Corrected schemaless attributes usage patterns

### Fixed
- MySQL collation error (database migration)
- Scope implementation for schemaless attributes

---

## [2025-01-02] - Code Quality Analysis

### Added
- Comprehensive code analysis following DRY+KISS+SOLID principles
- Refactoring action plan (8-12 days, 4 phases)
- Best practices documentation
- Quick start guide

### Identified
- 41 code quality violations
- God Class anti-pattern (457 lines, complexity 55)
- Missing Service Layer
- No DTO pattern
- Hardcoded strings (18+)

### Fixed
- Rating module collation error (database level)
- Documentation corrections

---

## [2024-12-10] - PHPStan & Filament 4

### Added
- PHPStan fixes (see phpstan-fixes-strategy.md for details)
- Filament 4 migration (see filament-4-upgrade.md)
- MyLog architecture: Now extends PtvListMyLogs (DRY compliance)

### Changed
- Upgraded to Filament 4
- PHPStan compliance improvements
- MyLogResource: Proper PTV extension pattern
- ListMyLogs: Extends PtvListMyLogs instead of XotBaseListRecords

### Fixed
- PHPStan errors: 100 → 91 (91 remaining)
- Filament 4 compatibility issues
- Import statements in Resources
- Return type annotations
- Unnecessary nullsafe operators

---

## [2024-12-04] - Navigation Translations

### Fixed
- Navigation translation issues
- Translation key mismatches

---

## [Earlier] - Initial Development

### Added
- Core module functionality
- Rating system integration
- Activity log integration
- Translation system
- Filament resources

---

**Note**: Dates in filenames are being consolidated into this CHANGELOG.
Specific technical details in permanent documentation files (no dates in names).


