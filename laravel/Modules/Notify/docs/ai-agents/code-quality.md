---
title: "code quality"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< HEAD
<<<<<<< .merge_file_Xzi0MZ
<<<<<<< .merge_file_VCKi9U
updated: 2026-11-23
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> .merge_file_uGDWF2
=======
>>>>>>> .merge_file_YEtcIZ
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
<<<<<<< .merge_file_Xzi0MZ
<<<<<<< .merge_file_VCKi9U
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_uGDWF2
=======
>>>>>>> .merge_file_YEtcIZ
qmd: "code quality"
issues: []
discussions: []
---

# Code Quality

> Standard di qualità del codice per PTVX.

## 🔍 Quality Checks (obbligatori dopo ogni modifica)

### PHPStan (Level 10)
```bash
php -d memory_limit=2G ./vendor/bin/phpstan analyse
```

**Regole:**
- Tutti gli errori devono essere risolti
- Nessun ignore errors
- Livello 10 obbligatorio

### PHPMD
```bash
bash laravel/tools/phpmd.sh laravel text phpmd.xml --exclude vendor,node_modules,bootstrap,caches
```

**Regola:** Usare sempre il wrapper PHAR, mai composer require.

### PHPInsights
```bash
./vendor/bin/phpinsights -v --no-interaction
```

## ✨ Laravel Pint (PSR-12)
```bash
# Verifica
./vendor/bin/pint --test

# Correzione automatica
./vendor/bin/pint --dirty
```

## 🔗 Link

**Di ritorno:**
<<<<<<< HEAD
- → [CLAUDE.md - Code Quality](../../../Geo/docs/root-md-files/claude.md)
- → [AGENTS.md - Quality Checks](../../AGENTS.md#quality-checks-obbligatori-dopo-ogni-modifica)
- → [AGENTS.md - Quality Checks](../../AGENTS.md#quality-checks-obbligatori-dopo-ogni-modifica)
=======
<<<<<<< HEAD
<<<<<<< .merge_file_Xzi0MZ
<<<<<<< .merge_file_VCKi9U
<<<<<<< HEAD
- → [CLAUDE.md - Code Quality](../../../Geo/docs/root-md-files/claude.md)
- → [AGENTS.md - Quality Checks](../../AGENTS.md#quality-checks-obbligatori-dopo-ogni-modifica)
- → [AGENTS.md - Quality Checks](../../AGENTS.md#quality-checks-obbligatori-dopo-ogni-modifica)
=======
<<<<<<< HEAD
=======
>>>>>>> .merge_file_YEtcIZ
- → [CLAUDE.md - Code Quality](../../../Geo/docs/root-md-files/claude.md)
- → [AGENTS.md - Quality Checks](../../AGENTS.md#quality-checks-obbligatori-dopo-ogni-modifica)
- → [agents.md - Quality Checks](../../agents.md#quality-checks-obbligatori-dopo-ogni-modifica)
=======
- → [CLAUDE.md - Code Quality](../../../Geo/docs/root-md-files/claude.md)
- → [AGENTS.md - Quality Checks](../../AGENTS.md#quality-checks-obbligatori-dopo-ogni-modifica)
- → [AGENTS.md - Quality Checks](../../AGENTS.md#quality-checks-obbligatori-dopo-ogni-modifica)
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_Xzi0MZ
=======
- → [CLAUDE.md - Code Quality](../../../Geo/docs/root-md-files/claude.md)
- → [AGENTS.md - Quality Checks](../../AGENTS.md#quality-checks-obbligatori-dopo-ogni-modifica)
- → [agents.md - Quality Checks](../../agents.md#quality-checks-obbligatori-dopo-ogni-modifica)
=======
- → [CLAUDE.md - Code Quality](../../../Geo/docs/root-md-files/claude.md)
- → [AGENTS.md - Quality Checks](../../AGENTS.md#quality-checks-obbligatori-dopo-ogni-modifica)
- → [agents.md - Quality Checks](../../agents.md#quality-checks-obbligatori-dopo-ogni-modifica)
=======
- → [CLAUDE.md - Code Quality](../../../Geo/docs/root-md-files/claude.md)
- → [AGENTS.md - Quality Checks](../../AGENTS.md#quality-checks-obbligatori-dopo-ogni-modifica)
- → [AGENTS.md - Quality Checks](../../AGENTS.md#quality-checks-obbligatori-dopo-ogni-modifica)
>>>>>>> .merge_file_uGDWF2
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_YEtcIZ
- → [INDEX](index.md)
