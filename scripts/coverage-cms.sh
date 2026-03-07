#!/bin/bash
# scripts/coverage-cms.sh

echo "📊 Analisi Cms modulo coverage..."
cd /var/www/_bases/base_laravelpizza/laravel

./vendor/bin/pest Modules/Cms/tests --coverage-text --min=100 --coverage-html=coverage/Cms

COVERAGE=$(./vendor/bin/pest Modules/Cms/tests --coverage-text --min=100 2>&1 | grep "Lines:" | awk '{print $2}')
TEST_FILES=$(find Modules/Cms/tests -name "*.php" | wc -l)

echo "📈 Cms modulo: $COVERAGE coverage con $TEST_FILES test files"
echo "📅 $(date): Cms modulo - $COVERAGE" >> coverage-progress.log

gh issue comment 247 --body "📊 **Progresso Attuale - $(date)**

### **Test Coverage Status**
- **Modulo:** Cms
- **Coverage Attuale:** $COVERAGE
- **Test Files:** $TEST_FILES files
- **Stato:** $(if [ "$COVERAGE" = "100%" ]; then echo "✅ COMPLETATO"; else echo "🔄 IN CORSO"; fi)

### **Avanzamento**
- **Prima:** 97%+
- **Dopo:** $COVERAGE
- **Miglioramento:** $(echo "scale=2; $(echo $COVERAGE | sed 's/%//') - 97" | bc)%"

if [ "$COVERAGE" = "100%" ]; then
    gh issue edit 247 --state closed
    echo "🎉 Cms modulo completato!"
fi