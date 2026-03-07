#!/bin/bash
# scripts/coverage-user.sh

echo "📊 Analisi User modulo coverage..."
cd /var/www/_bases/base_laravelpizza/laravel

# Esegui test con coverage
./vendor/bin/pest Modules/User/tests --coverage-text --min=100 --coverage-html=coverage/User

# Estrai risultati
COVERAGE=$(./vendor/bin/pest Modules/User/tests --coverage-text --min=100 2>&1 | grep "Lines:" | awk '{print $2}')
TEST_FILES=$(find Modules/User/tests -name "*.php" | wc -l)

echo "📈 User modulo: $COVERAGE coverage con $TEST_FILES test files"
echo "📅 $(date): User modulo - $COVERAGE" >> coverage-progress.log

# Aggiorna GitHub issue
gh issue comment 241 --body "📊 **Progresso Attuale - $(date)**

### **Test Coverage Status**
- **Modulo:** User
- **Coverage Attuale:** $COVERAGE
- **Test Files:** $TEST_FILES files
- **Stato:** $(if [ "$COVERAGE" = "100%" ]; then echo "✅ COMPLETATO"; else echo "🔄 IN CORSO"; fi)

### **Avanzamento**
- **Prima:** 14.6%
- **Dopo:** $COVERAGE
- **Miglioramento:** $(echo "scale=2; $(echo $COVERAGE | sed 's/%//') - 14.6" | bc)%"

# Chiudi issue se completato
if [ "$COVERAGE" = "100%" ]; then
    gh issue edit 241 --state closed
    echo "🎉 User modulo completato!"
fi