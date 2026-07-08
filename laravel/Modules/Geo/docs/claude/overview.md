# Overview e Technology Stack

This documentation provides guidance when working with code in this repository.

## 📚 Documentazione Organizzata

This documentation is organized in separate files to:

- **DRY**: Avoid duplication
- **KISS**: Keep simplicity
- **Maintainability**: Easy updates

## 🚀 Quick Start

1. Read [Architecture Rules](architecture-rules.md) - **CRITICAL**
2. Study [Module Structure](module-structure.md) - Understand the modular architecture
3. Consult [Development Tasks](development-tasks.md) for common tasks
4. Follow [Conventions](conventions.md) for code consistency

## 🏗️ Technology Stack

**Core Stack**: Laravel 12.x | PHP 8.3+ | Filament 4.x | Pest 3.x | PHPStan Level 10 (maximum strictness) | MySQL

### Module Architecture

```
Modules/{ModuleName}/
├── app/{Actions,Models,Filament,Http}/
├── docs/README.md
├── tests/{Feature,Unit}/
└── lang/{de,en,it}/
```

**Rules**:
- Every module extends `XotBaseServiceProvider`
- Business logic in Action classes: `Get*Action`, `Create*Action`
- Models extend `XotBaseModel` with strict typing
- Required: `docs/README.md` per module

## 📖 Navigation

- **For New Developers**: Start with [Architecture Rules](architecture-rules.md) for critical rules
- **For Filament**: Read [Framework Specifics](framework-specifics.md) for all Filament rules
- **For Quality**: Consult [Code Quality](code-quality.md) for testing and PHPStan

---

**Version**: 2.0 (Refactor DRY + KISS)  
**File**: overview.md - Overview and quick start