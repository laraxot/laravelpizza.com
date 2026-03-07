#!/bin/bash
# scripts/coverage-activity.sh

echo "📊 Analisi Activity modulo coverage..."
cd /var/www/_bases/base_laravelpizza/laravel

./vendor/bin/pest Modules/Activity/tests --coverage-text --min=100 --coverage-html=coverage/Activity

COVERAGE=$(./vendor/bin/pest Modules/Activity/tests --coverage-text --min=100 2>&1 | grep "Lines:" | awk '{print $2}')
TEST_FILES=$(find Modules/Activity/tests -name "*.php" | wc -l)

echo "📈 Activity modulo: $COVERAGE coverage con $TEST_FILES test files"
echo "📅 $(date): Activity modulo - $COVERAGE" >> coverage-progress.log

gh issue comment 244 --body "📊 **Progresso Attuale - $(date)**

### **Test Coverage Status**
- **Modulo:** Activity
- **Coverage Attuale:** $COVERAGE
- **Test Files:** $TEST_FILES files
- **Stato:** $(if [ "$COVERAGE" = "100%" ]; then echo "✅ COMPLETATO"; else echo "🔄 IN CORSO"; fi)

### **Avanzamento**
- **Prima:** 98%+
- **Dopo:** $COVERAGE
- **Miglioramento:** $(echo "scale=2; $(echo $COVERAGE | sed 's/%//') - 98" | bc)%"

if [ "$COVERAGE" = "100%" ]; then
    gh issue edit 244 --state closed
    echo "🎉 Activity modulo completato!"
fi