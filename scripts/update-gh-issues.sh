#!/bin/bash
# scripts/update-gh-issues.sh

echo "📊 Aggiornamento GitHub Issues - $(date)"

# Verifica stato attuale moduli
cd /var/www/_bases/base_laravelpizza/laravel

# User modulo
echo "🔍 Verifica stato User modulo..."
USER_COVERAGE=$(./vendor/bin/pest Modules/User/tests --coverage-text --min=100 2>&1 | grep "Lines:" | awk '{print $2}')
USER_TEST_FILES=$(find Modules/User/tests -name "*.php" | wc -l)
USER_TEST_FUNCTIONS=$(./vendor/bin/pest Modules/User/tests --coverage-text --min=100 2>&1 | grep "Functions:" | awk '{print $2}')
USER_ERRORS=$(./vendor/bin/phpstan analyse Modules/User --memory-limit=-1 --level=10 2>&1 | grep -E "(error|Error)" | wc -l)

echo "📈 User: $USER_COVERAGE, $USER_TEST_FILES files, $USER_TEST_FUNCTIONS functions, $USER_ERRORS errors"

# Geo modulo
echo "🔍 Verifica stato Geo modulo..."
GEO_COVERAGE=$(./vendor/bin/pest Modules/Geo/tests --coverage-text --min=100 2>&1 | grep "Lines:" | awk '{print $2}')
GEO_ERRORS=$(./vendor/bin/phpstan analyse Modules/Geo --memory-limit=-1 --level=10 2>&1 | grep -E "(error|Error)" | wc -l)

echo "📈 Geo: $GEO_COVERAGE, $GEO_ERRORS errors"

# Meetup modulo
echo "🔍 Verifica stato Meetup modulo..."
MEETUP_COVERAGE=$(./vendor/bin/pest Modules/Meetup/tests --coverage-text --min=100 2>&1 | grep "Lines:" | awk '{print $2}')
MEETUP_ERRORS=$(./vendor/bin/phpstan analyse Modules/Meetup --memory-limit=-1 --level=10 2>&1 | grep -E "(error|Error)" | wc -l)

echo "📈 Meetup: $MEETUP_COVERAGE, $MEETUP_ERRORS errors"

# Activity modulo
echo "🔍 Verifica stato Activity modulo..."
ACTIVITY_ERRORS=$(./vendor/bin/phpstan analyse Modules/Activity --memory-limit=-1 --level=10 2>&1 | grep -E "(error|Error)" | wc -l)

echo "📈 Activity: $ACTIVITY_ERRORS errors"

# Cms modulo
echo "🔍 Verifica stato Cms modulo..."
CMS_ERRORS=$(./vendor/bin/phpstan analyse Modules/Cms --memory-limit=-1 --level=10 2>&1 | grep -E "(error|Error)" | wc -l)

echo "📈 Cms: $CMS_ERRORS errors"

# Aggiorna GitHub issue 267 (User modulo)
gh issue comment 267 --body "📊 **Progresso Attuale - $(date)**

### **Test Coverage Status**
- **Modulo:** User
- **Coverage Attuale:** $USER_COVERAGE
- **Test Files:** $USER_TEST_FILES files
- **Test Functions:** $USER_TEST_FUNCTIONS functions
- **Errori PHPStan:** $USER_ERRORS
- **Stato:** IN CORSO

### **Avanzamento**
- **Prima:** 14.6%
- **Dopo:** $USER_COVERAGE
- **Miglioramento:** $(echo "scale=2; $(echo $USER_COVERAGE | sed 's/%//') - 14.6" | bc)%

### **Piani d'azione**
1. **Fase 1:** Analisi gap - COMPLETATO
2. **Fase 2:** Test Models - IN CORSO
3. **Fase 3:** Test Actions - PIANIFICATO
4. **Fase 4:** Test Controllers - PIANIFICATO

### **Richiesta feedback**
Approvate le fasi di lavoro?"

# Aggiorna GitHub issue 268 (Geo modulo)
gh issue comment 268 --body "🔧 **Fix Errori Geo - $(date)**

### **Stato Attuale**
- **Modulo:** Geo
- **Coverage:** $GEO_COVERAGE
- **Errori Rimanenti:** $GEO_ERRORS
- **Fix In Corso:** Sì

### **Piani d'azione**
1. **Fase 1:** Fix errori PHPStan - IN CORSO
2. **Fase 2:** Verifica 100% coverage - PIANIFICATO
3. **Fase 3:** Test Models - PIANIFICATO
4. **Fase 4:** Test Actions - PIANIFICATO

### **Richiesta feedback**
Approvate le fasi di lavoro?"

# Aggiorna GitHub issue 269 (Meetup modulo)
gh issue comment 269 --body "🔧 **Fix Errori Meetup - $(date)**

### **Stato Attuale**
- **Modulo:** Meetup
- **Coverage:** $MEETUP_COVERAGE
- **Errori Rimanenti:** $MEETUP_ERRORS
- **Fix In Corso:** Sì

### **Piani d'azione**
1. **Fase 1:** Fix errori PHPStan - IN CORSO
2. **Fase 2:** Verifica 100% coverage - PIANIFICATO
3. **Fase 3:** Test Models - PIANIFICATO
4. **Fase 4:** Test Actions - PIANIFICATO
5. **Fase 5:** Test Controllers - PIANIFICATO

### **Richiesta feedback**
Approvate le fasi di lavoro?"

# Aggiorna GitHub issue 270 (Monitoraggio principale)
gh issue comment 270 --body "🔄 **Monitoraggio Continuo - $(date)**

### **Status Finale**
- **User modulo:** $(gh issue view 267 --json state -q '.state')
- **Geo modulo:** $(gh issue view 268 --json state -q '.state')
- **Meetup modulo:** $(gh issue view 269 --json state -q '.state')

### **Report Globale**
\`\`\`
Stato Attuale Moduli:
- User: $USER_COVERAGE coverage, $USER_TEST_FILES files, $USER_TEST_FUNCTIONS functions, $USER_ERRORS errors
- Geo: $GEO_COVERAGE coverage, $GEO_ERRORS errors
- Meetup: $MEETUP_COVERAGE coverage, $MEETUP_ERRORS errors
- Activity: $ACTIVITY_ERRORS errors
- Cms: $CMS_ERRORS errors
\`\`\`

### **Piani d'azione**
1. **Fase 1:** Implementazione moduli - IN CORSO
2. **Fase 2:** Fix errori PHPStan - IN CORSO
3. **Fase 3:** Aggiornamento documentazione - PIANIFICATO
4. **Fase 4:** Monitoraggio continuo - ATTIVO

### **Richiesta feedback**
Approvate le fasi di lavoro?"