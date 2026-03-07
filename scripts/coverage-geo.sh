#!/bin/bash
# scripts/coverage-geo.sh

echo "📊 Analisi Geo modulo coverage..."
cd /var/www/_bases/base_laravelpizza/laravel

./vendor/bin/pest Modules/Geo/tests --coverage-text --min=100 --coverage-html=coverage/Geo

COVERAGE=$(./vendor/bin/pest Modules/Geo/tests --coverage-text --min=100 2>&1 | grep "Lines:" | awk '{print $2}')
TEST_FILES=$(find Modules/Geo/tests -name "*.php" | wc -l)

echo "📈 Geo modulo: $COVERAGE coverage con $TEST_FILES test files"
echo "📅 $(date): Geo modulo - $COVERAGE" >> coverage-progress.log

gh issue comment 242 --body "📊 **Progresso Attuale - $(date)**

### **Test Coverage Status**
- **Modulo:** Geo
- **Coverage Attuale:** $COVERAGE
- **Test Files:** $TEST_FILES files
- **Stato:** $(if [ "$COVERAGE" = "100%" ]; then echo "✅ COMPLETATO"; else echo "🔄 IN CORSO"; fi)

### **Avanzamento**
- **Prima:** 99%+
- **Dopo:** $COVERAGE
- **Miglioramento:** $(echo "scale=2; $(echo $COVERAGE | sed 's/%//') - 99" | bc)%"

if [ "$COVERAGE" = "100%" ]; then
    gh issue edit 242 --state closed
    echo "🎉 Geo modulo completato!"
fi