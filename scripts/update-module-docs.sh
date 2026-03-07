#!/bin/bash
# scripts/update-module-docs.sh

echo "📚 Aggiornamento documentazione moduli - $(date)"

# Verifica stato docs per modulo
cd /var/www/_bases/base_laravelpizza/laravel
for MODULE in User Geo Meetup Activity Cms; do
    DOCS_COUNT=$(find laravel/Modules/$MODULE -name "*.md" | wc -l)
    echo "📊 $MODULE: $DOCS_COUNT file docs"
    
    # Aggiorna GitHub issue
    gh issue comment 272 --body "📚 **Aggiornamento Docs $MODULE - $(date)**

### **Stato Attuale**
- **Modulo:** $MODULE
- **File Docs:** $DOCS_COUNT files
- **Stato:** IN CORSO

### **Progresso**
- [Descrizione progresso]

### **Piani d'azione**
1. **Fase 1:** Analisi docs esistenti - COMPLETATO
2. **Fase 2:** Aggiornamento docs mancanti - IN CORSO
3. **Fase 3:** Verifica coerenza - PIANIFICATO
4. **Fase 4:** Test documentazione - PIANIFICATO

### **Richiesta feedback**
Approvate le fasi di lavoro?"
    
    # Aggiorna discussion
    gh discussion comment 280 --body "📚 **Aggiornamento Docs $MODULE - $(date)**

### **Stato Attuale**
- **Modulo:** $MODULE
- **File Docs:** $DOCS_COUNT files
- **Stato:** IN CORSO

### **Progresso**
- [Descrizione progresso]

### **Piani d'azione**
1. **Fase 1:** Analisi docs esistenti - COMPLETATO
2. **Fase 2:** Aggiornamento docs mancanti - IN CORSO
3. **Fase 3:** Verifica coerenza - PIANIFICATO
4. **Fase 4:** Test documentazione - PIANIFICATO

### **Richiesta feedback**
Approvate le fasi di lavoro?"
done

# Verifica stato globale docs
TOTAL_DOCS=$(find laravel/Modules -name "*.md" | wc -l)
TOTAL_MODULES=$(find laravel/Modules -name "docs" -type d | wc -l)

echo "📈 Stato Globale Docs"
echo "- Moduli con docs: $TOTAL_MODULES"
echo "- File docs totali: $TOTAL_DOCS"

# Aggiorna issue principale
gh issue comment 272 --body "📈 **Stato Globale Docs - $(date)**

### **Stato Attuale**
- **Moduli con docs:** $TOTAL_MODULES
- **File docs totali:** $TOTAL_DOCS
- **Stato:** IN CORSO

### **Progresso**
- [Descrizione progresso]

### **Piani d'azione**
1. **Fase 1:** Analisi docs esistenti - COMPLETATO
2. **Fase 2:** Aggiornamento docs mancanti - IN CORSO
3. **Fase 3:** Verifica coerenza - PIANIFICATO
4. **Fase 4:** Test documentazione - PIANIFICATO

### **Richiesta feedback**
Approvate le fasi di lavoro?"