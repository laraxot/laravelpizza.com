#!/bin/bash
# scripts/coverage-meetup.sh

echo "📊 Analisi Meetup modulo coverage..."
cd /var/www/_bases/base_laravelpizza/laravel

./vendor/bin/pest Modules/Meetup/tests --coverage-text --min=100 --coverage-html=coverage/Meetup

COVERAGE=$(./vendor/bin/pest Modules/Meetup/tests --coverage-text --min=100 2>&1 | grep "Lines:" | awk '{print $2}')
TEST_FILES=$(find Modules/Meetup/tests -name "*.php" | wc -l)

echo "📈 Meetup modulo: $COVERAGE coverage con $TEST_FILES test files"
echo "📅 $(date): Meetup modulo - $COVERAGE" >> coverage-progress.log

gh issue comment 243 --body "📊 **Progresso Attuale - $(date)**

### **Test Coverage Status**
- **Modulo:** Meetup
- **Coverage Attuale:** $COVERAGE
- **Test Files:** $TEST_FILES files
- **Stato:** $(if [ "$COVERAGE" = "100%" ]; then echo "✅ COMPLETATO"; else echo "🔄 IN CORSO"; fi)

### **Avanzamento**
- **Prima:** 95%+
- **Dopo:** $COVERAGE
- **Miglioramento:** $(echo "scale=2; $(echo $COVERAGE | sed 's/%//') - 95" | bc)%"

if [ "$COVERAGE" = "100%" ]; then
    gh issue edit 243 --state closed
    echo "🎉 Meetup modulo completato!"
fi