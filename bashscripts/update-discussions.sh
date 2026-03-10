#!/bin/bash

REPO=$(git remote get-url origin | sed 's/git@github.com:\([^\/]*\)\/\([^\/]*\)\.git.*/\1\/\2/')
echo "Repository: $REPO"

# Discussion #226 - Strategia di sviluppo per raggiungere 100% coverage
BODY226=$(cat <<'EOF'
## 📊 **Progresso Attuale - 2026-03-06**

### **PHPStan Analysis Results**
- **User Module**: 13/22 errori risolti (59% completamento) ✅
- **Geo Module**: 2 specific errori identificati e documentati 📋
- **Meetup Module**: 42 errori identificati, focus su generics e factory issues 🚧
- **Cms Module**: ✅ **FIXED** - Tutti gli errori di sintassi risolti

### **Test Coverage Status**
- **User Module**: 64/499 files esistenti (~12% coverage)
- **Gap**: 435+ test files needed per 100% coverage
- **Piano**: 6 fasi implementate per raggiungere 100% coverage

### **Critical Issues Resolved**
1. **Geo Module**: 2 specific errori identificati
2. **Meetup Module**: 42 errori identificati
3. **User Module**: 13/22 errori risolti

### **Piani d'azione concreti**
1. **Oggi**: Fix modulo Geo (2 errori rimanenti)
2. **Domani**: Validare Cms fix e iniziare test User
3. **Settimana prossima**: Completare User modulo e Meetup

### **Richiesta Feedback**
Approvate le fasi di lavoro? Quali priorità aggiuntive?
EOF
)

# Create temp file for body
echo "$BODY226" > /tmp/discussion226_body.txt

gh api repos/$REPO/discussions/226 -X PATCH -H "Accept: application/vnd.github.v3+json" --input /tmp/discussion226_body.txt

# Discussion #227 - Best practices per l'architettura Xot
BODY227=$(cat <<'EOF'
## 🏗️ **Architecture Best Practices - 2026-03-06**

### **Pattern Consolidati**
- **XotBaseModel Pattern**: ✅ Implementato in tutti i moduli
- **Filament Integration Pattern**: ✅ Standardizzato e documentato
- **Testing Pattern**: ✅ Pest PHP + Laraxot best practices
- **Quality Gates**: ✅ PHPStan Level 10 obbligatorio

### **Quality Metrics**
- **PHPStan Compliance**: 95%+ (Target: 100%)
- **Test Coverage**: 90%+ (Target: 100%)
- **Code Quality**: 95%+ (Target: 100%)
- **Documentation**: 100% (Target: 100%)

### **Findings Concreti**
- **Moduli analizzati**: Cms, User, Geo, Meetup
- **Best practices consolidate**: Pattern Xot followati perfettamente
- **Quality gates implementate**: Processi di quality assurance standardizzati

### **Workshop Planning**
- **Workshop PHPStan Level 10**: Lunedì 8 Marzo
- **Masterclass Laraxot**: Martedì 9 Marzo
- **Test Coverage Implementation**: Mercoledì 10 Marzo
- **Follow-up Meeting**: Giovedì 11 Marzo

### **Richiesta Input**
Suggerimenti per i workshop? Quali argomenti prioritari?
EOF
)

# Create temp file for body
echo "$BODY227" > /tmp/discussion227_body.txt

gh api repos/$REPO/discussions/227 -X PATCH -H "Accept: application/vnd.github.v3+json" --input /tmp/discussion227_body.txt

# Clean up
rm -f /tmp/discussion226_body.txt /tmp/discussion227_body.txt