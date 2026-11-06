#!/bin/bash

# Lang Module Docs Consolidation Script
# Phase 2d Aggressive Merge (346 → target ≤30)
# Usage: cd laravel/Modules/Lang/docs && bash consolidate.sh

set -e

DOCS_DIR="/var/www/_bases/base_ptvx_fila5/laravel/Modules/Lang/docs"
cd "$DOCS_DIR"

echo "=== Lang Module Docs Consolidation ==="
echo "Current directory: $(pwd)"
echo

# Count before
BEFORE=$(find . -type f ! -path './.git*' ! -path './.*' | wc -l)
BEFORE_MD=$(ls -1 *.md 2>/dev/null | wc -l)
echo "BEFORE: $BEFORE total files, $BEFORE_MD root .md files"
echo

# Backup
echo "[1/9] Creating backup commit..."
git add -A
git commit -m "backup: Lang docs before consolidation" || true
echo "✓ Backup created"
echo

# 1. Delete duplicates (snake_case versions)
echo "[2/9] Deleting duplicates (snake_case variants)..."
for file in \
  advanced_language_switching.md \
  automatic_translations.md \
  cms_link.md \
  docs_naming_convention_fix.md \
  documentation_link_conventions.md \
  errori_comuni_traduzione.md \
  lang_link.md \
  lang_service_helper_text_fix.md \
  laravel_localization.md \
  working_with_locales.md; do
  [ -f "$file" ] && rm -v "$file"
done

# Delete all translation_*.md (snake_case)
find . -maxdepth 1 -name "translation_*.md" -type f -exec rm -v {} \;

# Delete all translating_*.md (snake_case)
find . -maxdepth 1 -name "translating_*.md" -type f -exec rm -v {} \;

# Delete all validation_*.md (snake_case)
find . -maxdepth 1 -name "validation_*.md" -type f -exec rm -v {} \;

# Delete all conflict_resolution_*.md (snake_case)
find . -maxdepth 1 -name "conflict_resolution_*.md" -type f -exec rm -v {} \;

echo "✓ Duplicates deleted"
echo

# 2. Delete obsolete files (Italian corrections, analysis)
echo "[3/9] Deleting obsolete files..."
for file in \
  correzioni-errori-sintassi-.md \
  correzioni-errori-sintassi.md \
  correzioni-navigation.md \
  correzioni_errori_sintassi.md \
  correzionii-sintassi.md \
  metodi-duplicati-analisi.md \
  metodi_duplicati_analisi.md \
  METODI_DUPLICATI_ANALISI.md \
  tradizioni-navigation-.md \
  tradizioni-navigation.md \
  traduzioni.md \
  traduzioni-navigation-.md \
  traduzioni-navigation.md \
  traduzioni_navigation.md \
  traduzioni_navugation.md \
  struttura-traduzioni.md \
  struttura-translations.md \
  struttura_traduzioni.md \
  translationes.md \
  translationness.md \
  correzioni_errori_sintassi.md \
  analysis-results.md \
  bottlenecks.md \
  cyclomatic-complexity.md \
  dependency-intelligence.md \
  docs-health.md \
  coverage.md \
  REDUNDANCY_ANALYSIS.md; do
  [ -f "$file" ] && rm -v "$file"
done

echo "✓ Obsolete files deleted"
echo

# 3. Delete index duplicates
echo "[4/9] Consolidating index files..."
for file in 00-INDEX.md 00-index.md INDEX.md; do
  [ -f "$file" ] && rm -v "$file"
done
echo "✓ Index duplicates removed (README.md is canonical)"
echo

# 4. Create wiki subdirectories
echo "[5/9] Creating wiki/ subdirectories..."
mkdir -p wiki/strategies wiki/how-to wiki/overviews wiki/rules
echo "✓ Directories created"
echo

# 5. Move strategy/research files
echo "[6/9] Moving strategy/research files to wiki/..."
for file in \
  PRODUCT_LAUNCH_PLAN.md \
  TRANSLATION_STRATEGIES.md \
  USER_RESEARCH.md \
  SPRINT_PLANNING.md; do
  [ -f "$file" ] && mv -v "$file" wiki/strategies/ || true
done

[ -f PERFORMANCE-OPTIMIZATION.md ] && mv -v PERFORMANCE-OPTIMIZATION.md wiki/overviews/ || true

echo "✓ Strategy files moved"
echo

# 6. Move how-to guides
echo "[7/9] Moving how-to guides to wiki/how-to/..."
for file in \
  QMD-SETUP.md \
  QUICK_REFERENCE.md \
  best-practices.md \
  laravel-localization-reference.md \
  laravel_localization_complete.md \
  localizing_dates_and_currencies.md \
  pluralization_and_localization.md; do
  [ -f "$file" ] && mv -v "$file" wiki/how-to/ || true
done
echo "✓ How-to guides moved"
echo

# 7. Move technical overviews
echo "[8/9] Moving technical references to wiki/overviews/..."
for file in \
  api-reference.md \
  business-logic-overview.md \
  console-commands.md \
  database-model-coverage.md \
  schema.md; do
  [ -f "$file" ] && mv -v "$file" wiki/overviews/ || true
done
echo "✓ Technical references moved"
echo

# 8. Move rules/patterns
echo "[9/9] Moving rules to wiki/rules/..."
for file in \
  ON-DEMAND-PATTERN.md \
  MCAMARA_IMPLEMENTATION_GUIDE.md; do
  [ -f "$file" ] && mv -v "$file" wiki/overviews/ || true
done
echo "✓ Rules moved"
echo

# Verify
AFTER=$(find . -type f ! -path './.git*' ! -path './.*' | wc -l)
AFTER_MD=$(ls -1 *.md 2>/dev/null | wc -l)

echo "=== Consolidation Complete ==="
echo "AFTER: $AFTER total files, $AFTER_MD root .md files"
echo "Reduction: Total -$(( (BEFORE - AFTER) * 100 / BEFORE ))%, Root -$(( (BEFORE_MD - AFTER_MD) * 100 / BEFORE_MD ))%"
echo

echo "Root .md files:"
ls -1 *.md | sort

echo
echo "Wiki structure:"
find wiki -type f | sort

echo
echo "Next steps:"
echo "1. Manually consolidate PHPSTAN files (PHPSTAN-FIXES.md → PHPSTAN_L10.md)"
echo "2. Consolidate translation files (manual merge of 65 → 4 canonical)"
echo "3. Verify with: find . -type f | wc -l"
echo "4. Commit: git commit -m 'chore: Lang docs consolidation phase 2d complete'"
