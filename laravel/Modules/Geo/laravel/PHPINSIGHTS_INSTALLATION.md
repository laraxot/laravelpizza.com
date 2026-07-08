# PHPInsights Standalone Installation Guide

## Overview
PHPInsights v2.13.3 has been successfully installed as a standalone tool in the PTVX project.

## Why Standalone Instead of Composer?
- **No Dependency Conflicts**: Standalone installation avoids conflicts with project dependencies
- **Version Lock**: Locked to v2.13.3 regardless of project composer updates
- **Isolation**: Uses its own dependency tree in `nunomaduro-phpinsights-ae780a9/`
- **Portable**: Can be easily moved between projects

## Installation Status
✅ **COMPLETED**: PHPInsights v2.13.3 standalone installed
- Source: Downloaded from GitHub tarball release v2.13.3
- Dependencies: Self-contained in `nunomaduro-phpinsights-ae780a9/vendor/`
- Binary: `laravel/phpinsights-standalone` (wrapper)
- Script: `laravel/phpinsights-standalone.sh` (convenient interface)

## Usage

### Quick Start
```bash
# Analyze specific module
./phpinsights-standalone.sh Xot

# Analyze all modules with summary
./phpinsights-standalone.sh all --summary

# Set minimum quality threshold
./phpinsights-standalone.sh Xot --min-quality=80
```

### Available Commands
```bash
./phpinsights-standalone.sh [module_name|all] [options]
```

**Examples:**
- `./phpinsights-standalone.sh Xot` - Analyze Xot module
- `./phpinsights-standalone.sh Xot --min-quality=80` - With minimum quality
- `./phpinsights-standalone.sh all --summary` - All modules with summary

## Current Analysis Results Summary

### High Quality Modules (80%+)
- **Badge**: 97.0% (Code: 97, Complexity: 100, Architecture: 88.2, Style: 92.8)
- **CertFisc**: 98.0% (Code: 98, Complexity: 100, Architecture: 88.2, Style: 95.2)
- **ContoAnnuale**: 98.0% (Code: 98, Complexity: 100, Architecture: 88.2, Style: 95.2)
- **Europa**: 98.0% (Code: 98, Complexity: 100, Architecture: 88.2, Style: 95.2)
- **Inail**: 98.0% (Code: 98, Complexity: 100, Architecture: 94.1, Style: 95.2)
- **Legge104**: 97.0% (Code: 97, Complexity: 100, Architecture: 70.6, Style: 95.2)
- **Legge109**: 98.0% (Code: 98, Complexity: 100, Architecture: 88.2, Style: 95.2)
- **Mensa**: 97.0% (Code: 97, Complexity: 100, Architecture: 76.5, Style: 95.2)

### Medium Quality Modules (70-79%)
- **Activity**: 88.0% (Code: 88, Complexity: 96.6, Architecture: 82.4, Style: 91.6)
- **DbForge**: 83.0% (Code: 83, Complexity: 89.4, Architecture: 88.2, Style: 90.4)
- **Gdpr**: 86.0% (Code: 86, Complexity: 99.7, Architecture: 82.4, Style: 96.4)
- **Incentivi**: 77.0% (Code: 77, Complexity: 91.6, Architecture: 82.4, Style: 86.7)
- **IndennitaCondizioniLavoro**: 85.0% (Code: 85, Complexity: 89.6, Architecture: 58.8, Style: 80.7)
- **IndennitaResponsabilita**: 78.0% (Code: 78, Complexity: 94.2, Architecture: 58.8, Style: 79.5)
- **Job**: 86.0% (Code: 86, Complexity: 98.5, Architecture: 70.6, Style: 89.2)
- **Lang**: 84.0% (Code: 84, Complexity: 93.5, Architecture: 70.6, Style: 92.8)
- **Media**: 81.0% (Code: 81, Complexity: 93.2, Architecture: 82.4, Style: 90.4)

### Priority Issues Identified
1. **Architecture Score**: Many modules have low architecture scores (58-70%)
2. **Code Quality**: Xot module has only 77% code quality with many violations
3. **Style Issues**: Line length and formatting issues across all modules

## Integration with Existing Tools

### Workflow Integration
```bash
# During development
./phpinsights-standalone.sh ModuleName --min-quality=75

# Before commits
./phpinsights-standalone.sh all --summary

# CI/CD integration
./phpinsights-standalone.sh $MODULE --min-quality=80 --format=json
```

### Complementary Tools
- **PHPStan**: Static analysis (Level 10) - Focus on type safety
- **PHPInsights**: Code quality - Focus on architecture, complexity, style
- **Pint**: Code formatting - Fix style issues automatically

## Agent Notifications
All AI agents should be aware that:
1. PHPInsights is available as `./phpinsights-standalone.sh`
2. Use it for code quality analysis alongside PHPStan
3. Focus on Architecture and Complexity scores that PHPStan doesn't cover
4. Reference this guide for usage patterns

## File Structure
```
laravel/
├── phpinsights-standalone                 # Main binary (wrapper)
├── phpinsights-standalone.sh             # Convenience script
└── nunomaduro-phpinsights-ae780a9/     # Source + dependencies
    ├── bin/phpinsights                 # Original binary
    ├── vendor/                        # Isolated dependencies
    └── config/                        # Configuration
```

This setup ensures PHPInsights is available for all agents without polluting the main project dependencies.