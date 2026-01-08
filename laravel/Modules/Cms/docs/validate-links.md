# Sistema di Validazione Link Relativi

## 🔍 **Controlli Automatici**

### **Script di Validazione**

```bash
#!/bin/bash
# validate-links.sh - Sistema controllo link relativi

echo "🔍 CONTROLLO LINK ASSOLUTI VIETATI"
echo "=================================="

# Controllo 1: Path assoluti /var/www/html
echo "❌ Cercando path assoluti /var/www/html..."
ABSOLUTE_PATHS=$(grep -r "/var/www/html" Modules/*/docs/ --include="*.md" | wc -l)
if [ $ABSOLUTE_PATHS -gt 0 ]; then
    echo "🚨 ERRORE: Trovati $ABSOLUTE_PATHS link assoluti VIETATI!"
    grep -r "/var/www/html" Modules/*/docs/ --include="*.md"
else
    echo "✅ Nessun path assoluto trovato"
fi

# Controllo 2: Link relativi errati ../../laravel/
echo -e "\n❌ Cercando link relativi errati ../../laravel/..."
WRONG_RELATIVE=$(grep -r "\.\./\.\./laravel/" Modules/*/docs/ --include="*.md" | wc -l)
if [ $WRONG_RELATIVE -gt 0 ]; then
    echo "🚨 ERRORE: Trovati $WRONG_RELATIVE link relativi errati!"
    grep -r "\.\./\.\./laravel/" Modules/*/docs/ --include="*.md"
else
    echo "✅ Nessun link relativo errato trovato"
fi

# Controllo 3: Progetti vecchi base_<nome progetto>
echo -e "\n❌ Cercando riferimenti progetti vecchi..."
OLD_PROJECTS=$(grep -r "base_<nome progetto>" Modules/*/docs/ --include="*.md" | wc -l)
if [ $OLD_PROJECTS -gt 0 ]; then
    echo "🚨 ERRORE: Trovati $OLD_PROJECTS riferimenti a progetti vecchi!"
    grep -r "base_<nome progetto>" Modules/*/docs/ --include="*.md"
else
    echo "✅ Nessun riferimento a progetti vecchi trovato"
fi

echo -e "\n📊 RIEPILOGO CONTROLLI"
echo "======================"
echo "Path assoluti: $ABSOLUTE_PATHS"
echo "Link errati: $WRONG_RELATIVE" 
echo "Progetti vecchi: $OLD_PROJECTS"

TOTAL_ERRORS=$((ABSOLUTE_PATHS + WRONG_RELATIVE + OLD_PROJECTS))
if [ $TOTAL_ERRORS -eq 0 ]; then
    echo "🎉 TUTTI I CONTROLLI SUPERATI!"
    exit 0
else
    echo "🚨 ERRORI TOTALI: $TOTAL_ERRORS"
    exit 1
fi
```

### **Utilizzo Script**

```bash
# Rendere eseguibile
chmod +x validate-links.sh

# Eseguire controlli
./validate-links.sh

# Integrazione in CI/CD
# Aggiungere al pipeline per bloccare merge con errori
```

## 🛡️ **Regole di Prevenzione**

### **Pre-commit Hook**
```bash
#!/bin/bash
# .git/hooks/pre-commit

# Controlla link assoluti prima del commit
if grep -r "/var/www/html" Modules/*/docs/ --include="*.md" >/dev/null 2>&1; then
    echo "🚨 COMMIT BLOCCATO: Link assoluti trovati nella documentazione!"
    echo "Correggi i link usando percorsi relativi prima del commit."
    exit 1
fi
```

### **Controlli IDE**
- **VSCode**: Estensione "Markdown All in One" per validazione link
- **PHPStorm**: Plugin "Markdown Navigator" con controllo link
- **Vim**: Plugin "markdown-preview" con validazione

### **Controlli Automatici GitHub Actions**
```yaml
name: Validate Documentation Links
on: [push, pull_request]
jobs:
  validate-links:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Check for absolute paths
        run: |
          if grep -r "/var/www/html" Modules/*/docs/ --include="*.md"; then
            echo "::error::Absolute paths found in documentation"
            exit 1
          fi
```

## 📋 **Checklist Validazione**

### **Prima di Commit**
- [ ] Eseguire `validate-links.sh`
- [ ] Controllare che tutti i link siano relativi
- [ ] Verificare che i percorsi puntino ai file corretti
- [ ] Testare almeno 3 link random manualmente

### **Prima di Merge**
- [ ] Pipeline CI/CD passa tutti i controlli
- [ ] Nessun link assoluto in tutta la documentazione
- [ ] Nessun riferimento a progetti vecchi
- [ ] Documentazione README aggiornata

### **Manutenzione Periodica**
- [ ] Controllo mensile con script validazione
- [ ] Aggiornamento regole se necessario
- [ ] Training team su regole link relativi
- [ ] Review documentazione nuovi moduli

## 🎯 **Obiettivi di Qualità**

### **Target Metriche**
- **Link assoluti**: 0 (zero tolleranza)
- **Link relativi errati**: 0 (zero tolleranza)  
- **Link rotti**: < 1% (controllo manuale)
- **Copertura documentazione**: > 90%

### **SLA Correzioni**
- **Link assoluti**: Correzione immediata (blocca deploy)
- **Link rotti**: Correzione entro 24h
- **Documentazione mancante**: Entro 1 settimana

## 🧠 **Memoria e Apprendimento**

### **Pattern Comuni Errori**
1. Copy-paste da documentazione esterna
2. Path assoluti in esempi di codice
3. Riferimenti hardcoded a ambienti specifici
4. Link a documentazione esterna non relative

### **Soluzioni Automatiche**
- Snippet IDE per link relativi
- Template documentazione con esempi corretti
- Script di conversione automatica path assoluti
- Linter personalizzato per documentazione

---

**Ultimo aggiornamento**: Gennaio 2025  
**Versione**: 1.0  
**Integrazione**: Sistema CI/CD e pre-commit hooks
