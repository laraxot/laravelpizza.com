# Regole per Link Relativi nella Documentazione

## 🚨 **REGOLA CRITICA LARAXOT**

**TUTTI i link nei file .md DEVONO essere sempre relativi rispetto alla posizione del file.**

### ❌ **VIETATO - Link Assoluti**
```markdown
[Link errato](/var/www/html/_bases/<directory progetto>/docs/file.md)
[Link errato](../../laravel/Modules/Cms/docs/file.md)
```

### ✅ **CORRETTO - Link Relativi**
```markdown
[Link corretto](./file.md)
[Link corretto](../altro-modulo/docs/file.md)
[Link alla root](../../../docs/file.md)
```

## 🎯 **Motivazioni Filosofiche**

### **Principi Zen Laraxot**
- **Portabilità**: Il codice deve funzionare ovunque
- **Autonomia**: Ogni modulo è indipendente 
- **Serenità**: Nessun link rotto dopo refactor
- **Un solo punto di verità**: Nessun path assoluto

### **Vantaggi Tecnici**
1. **Refactoring sicuro**: Spostare directory non rompe link
2. **Portabilità cross-platform**: Funziona su Windows/Linux/Mac
3. **Deployment flessibile**: Funziona in qualsiasi ambiente
4. **Manutenzione semplice**: Modifiche strutturali non richiedono aggiornamenti massivi

### **Problemi dei Link Assoluti**
1. **Lock-in del path**: Dipendenza da struttura specifica
2. **Rottura durante refactoring**: Ogni spostamento rompe i link
3. **Incompatibilità deployment**: Non funziona su server diversi
4. **Violazione principi DRY**: Duplicazione informazioni path

## 📏 **Schema Percorsi Relativi**

### **Dal modulo Cms alla root docs**
```
Percorso: Modules/Cms/docs/ → ../../../docs/
Logica: 
  Modules/Cms/docs/ → ../ (torna a Modules/)
  Modules/ → ../ (torna a laravel/) 
  laravel/ → ../ (torna a <directory progetto>/)
  <directory progetto>/ → docs/ (entra nella root docs)
```

### **Tra moduli**
```
Da: Modules/Cms/docs/
A:  Modules/User/docs/
Link: ../../User/docs/
```

### **All'interno dello stesso modulo**
```
Da: Modules/Cms/docs/
A:  Modules/Cms/docs/components/
Link: ./components/
```

## 🔧 **Checklist Correzione Link**

- [ ] Identificare tutti i file con `/var/www/html`
- [ ] Identificare tutti i file con `../../laravel/`
- [ ] Convertire tutti i link in relativi
- [ ] Testare che i link funzionino
- [ ] Documentare le modifiche
- [ ] Aggiornare regole per prevenire errori futuri

## 📚 **Esempi Pratici**

### **Caso 1: Link alla documentazione root**
```markdown
<!-- PRIMA (ERRATO) -->
[Gestione Homepage](/var/www/html/_bases/<directory progetto>/docs/gestione-homepage.md)

<!-- DOPO (CORRETTO) -->
[Gestione Homepage](../../../docs/gestione-homepage.md)
```

### **Caso 2: Link ad altro modulo**
```markdown
<!-- PRIMA (ERRATO) -->
[Modulo User](/var/www/html/_bases/<directory progetto>/laravel/Modules/User/docs/README.md)

<!-- DOPO (CORRETTO) -->
[Modulo User](../../User/docs/README.md)
```

### **Caso 3: Link interno al modulo**
```markdown
<!-- PRIMA (ERRATO) -->
[Componenti](../../laravel/Modules/Cms/docs/components/header.md)

<!-- DOPO (CORRETTO) -->
[Componenti](./components/header.md)
```

## 🛡️ **Prevenzione Errori Futuri**

### **Regole di Scrittura**
1. **Mai** utilizzare path assoluti con `/var/www/html`
2. **Mai** utilizzare `../../laravel/` (è ridondante)
3. **Sempre** partire dalla posizione del file corrente
4. **Sempre** testare i link dopo la scrittura

### **Controlli Automatici**
```bash
# Cerca link assoluti problematici
grep -r "/var/www/html" Modules/*/docs/ --include="*.md"
grep -r "\.\./\.\./laravel/" Modules/*/docs/ --include="*.md"
```

### **Memory Update**
Aggiornare sempre le regole personali:
- `.cursor/rules`
- `.windsurf/rules`
- `.cursor/memories`

## 🎭 **Filosofia del Link Relativo**

### **Politica**
"Ogni modulo deve essere autonomo e portabile"

### **Religione**  
"Non avrai altro path all'infuori del relativo"

### **Zen**
"La serenità viene dalla navigazione fluida senza rotture"

### **Economia Circolare**
"Un link relativo oggi, refactoring sereno domani"

---

**Ultimo aggiornamento**: Gennaio 2025  
**Versione**: 1.0  
**Conformità**: Regole Laraxot per documentazione modulare e portabile
