#!/bin/bash
# scripts/implement-user-tests.sh

echo "🚀 Implementazione User modulo test coverage - $(date)"

# Esegui test con coverage
cd /var/www/_bases/base_laravelpizza/laravel
./vendor/bin/pest Modules/User/tests --coverage-text --min=100 --coverage-html=coverage/User

# Estrai risultati
COVERAGE=$(./vendor/bin/pest Modules/User/tests --coverage-text --min=100 2>&1 | grep "Lines:" | awk '{print $2}')
TEST_FILES=$(find Modules/User/tests -name "*.php" | wc -l)
TEST_FUNCTIONS=$(./vendor/bin/pest Modules/User/tests --coverage-text --min=100 2>&1 | grep "Functions:" | awk '{print $2}')

echo "📈 User modulo: $COVERAGE coverage con $TEST_FILES test files, $TEST_FUNCTIONS functions"

# Aggiorna GitHub issue
gh issue comment 267 --body "📊 **Progresso Attuale - $(date)**

### **Test Coverage Status**
- **Modulo:** User
- **Coverage Attuale:** $COVERAGE
- **Test Files:** $TEST_FILES files
- **Test Functions:** $TEST_FUNCTIONS functions
- **Stato:** IN CORSO

### **Avanzamento**
- **Prima:** 14.6%
- **Dopo:** $COVERAGE
- **Miglioramento:** $(echo "scale=2; $(echo $COVERAGE | sed 's/%//') - 14.6" | bc)%

### **Piani d'azione**
1. **Fase 1:** Analisi gap - COMPLETATO
2. **Fase 2:** Test Models - IN CORSO
3. **Fase 3:** Test Actions - PIANIFICATO
4. **Fase 4:** Test Controllers - PIANIFICATO

### **Richiesta feedback**
Approvate le fasi di lavoro?"

# Chiudi issue se completato
if [ "$COVERAGE" = "100%" ]; then
    gh issue edit 267 --state closed
    gh issue edit 241 --state closed
    echo "🎉 User modulo completato!"
    
    # Aggiorna discussion
    gh discussion comment 277 --body "🎉 **User Modulo Completato! - $(date)**

### **Stato Finale**
- **Coverage:** 100%
- **Test Files:** $TEST_FILES files
- **Test Functions:** $TEST_FUNCTIONS functions

### **Completamento**
- ✅ Analisi gap - COMPLETATO
- ✅ Test Models - COMPLETATO
- ✅ Test Actions - COMPLETATO
- ✅ Test Controllers - COMPLETATO

### **Miglioramento**
- **Prima:** 14.6%
- **Dopo:** 100%
- **Miglioramento:** +85.4%

### **Prossimi Passi**
- 🎯 Iniziare implementazione modulo Geo
- 📚 Aggiornare documentazione moduli
- 🔄 Monitoraggio continuo progresso"
fi